<?php
require_once __DIR__ . '/../database/connection.php';

global $conn;

function getProductsModel() {
  global $conn;

  try {
    $query = "SELECT id, nombre, ahorrado, objetivo, color FROM products ORDER BY id";
    $stmt = $conn->query($query);
    return $stmt->fetchAll() ?: [];
  } catch (PDOException $e) {
    error_log("Error getting products: " . $e->getMessage());
    return false;
  }
}

function getProductByIdModel($id) {
  global $conn;

  try {
    $query = "SELECT id, nombre, ahorrado, objetivo, color FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([intval($id)]);
    return $stmt->fetch() ?: null;
  } catch (PDOException $e) {
    error_log("Error getting product by id: " . $e->getMessage());
    return false;
  }
}
?>
