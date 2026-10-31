<?php
if (PHP_SAPI !== 'cli') {
  http_response_code(404);
  exit;
}

require_once __DIR__ . '/connection.php';

$jsonPath = __DIR__ . '/metas.json';
$json = file_get_contents($jsonPath);
if ($json === false) {
  throw new RuntimeException('No se pudo leer database/metas.json');
}

$metas = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
if (!is_array($metas)) {
  throw new RuntimeException('database/metas.json debe contener una lista de metas');
}

$findProduct = $conn->prepare(
  'SELECT 1 FROM public.products
   WHERE nombre = :nombre
     AND ahorrado = :ahorrado
     AND objetivo = :objetivo
     AND color IS NOT DISTINCT FROM :color
   LIMIT 1'
);
$insertProduct = $conn->prepare(
  'INSERT INTO public.products (nombre, ahorrado, objetivo, color)
   VALUES (:nombre, :ahorrado, :objetivo, :color)'
);

$inserted = 0;
$skipped = 0;
$conn->beginTransaction();

try {
  foreach ($metas as $index => $meta) {
    if (
      !is_array($meta)
      || !isset($meta['nombre'], $meta['ahorrado'], $meta['objetivo'])
      || !is_string($meta['nombre'])
      || !is_int($meta['ahorrado'])
      || !is_int($meta['objetivo'])
      || (isset($meta['color']) && !is_string($meta['color']))
    ) {
      throw new UnexpectedValueException('Meta inválida en la posición ' . $index);
    }

    $product = [
      'nombre' => $meta['nombre'],
      'ahorrado' => $meta['ahorrado'],
      'objetivo' => $meta['objetivo'],
      'color' => $meta['color'] ?? null,
    ];

    $findProduct->execute($product);
    if ($findProduct->fetchColumn()) {
      $skipped++;
      continue;
    }

    $insertProduct->execute($product);
    $inserted++;
  }

  $conn->commit();
} catch (Throwable $error) {
  $conn->rollBack();
  throw $error;
}

echo json_encode([
  'inserted' => $inserted,
  'skipped' => $skipped,
], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) . PHP_EOL;
