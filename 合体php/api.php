<?php
session_start();
require_once 'db-connect.php';

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';
$id = $data['id'] ?? 0;

if (!$action || !$id) {
  http_response_code(400);
  echo json_encode(['error' => 'invalid request']);
  exit;
}

switch ($action) {
  case 'increase':
    $sql = "UPDATE cart SET quantity = quantity + 1 WHERE cart_id = ?";
    break;
  case 'decrease':
    $sql = "UPDATE cart SET quantity = quantity - 1 WHERE cart_id = ? AND quantity > 1";
    break;
  case 'delete':
    $sql = "DELETE FROM cart WHERE cart_id = ?";
    break;
  default:
    http_response_code(400);
    echo json_encode(['error' => 'unknown action']);
    exit;
}

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

echo json_encode(['success' => true]);
