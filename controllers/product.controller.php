<?php
require_once __DIR__ . '/../models/product.model.php';

function getAllProducts() {
  $products = getProductsModel();
  if ($products === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener productos']);
    return;
  }
  http_response_code(200);
  echo json_encode($products);
}

function getProductById($id) {
  $product = getProductByIdModel($id);
  if ($product === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Error al obtener producto']);
    return;
  }
  if (!$product) {
    http_response_code(404);
    echo json_encode(['error' => 'Producto no encontrado']);
    return;
  }
  http_response_code(200);
  echo json_encode($product);
}
?>
