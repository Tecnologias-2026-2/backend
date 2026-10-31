<?php
require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../controllers/product.controller.php';

function handleProductRoutes($method, $path) {
  // GET /productos - Get all products
  if ($method === 'GET' && $path === '/productos') {
    getAllProducts();
  }
  // GET /productos/:id - Get product by id
  elseif ($method === 'GET' && preg_match('/^\/productos\/(\d+)$/', $path, $matches)) {
    getProductById($matches[1]);
  } else {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
  }
}
?>
