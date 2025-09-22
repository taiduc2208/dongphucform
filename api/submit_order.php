<?php
header('Content-Type: application/json');
$allowed_domain = "photo-event.unaux.com";

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';

if (
    (stripos($origin, $allowed_domain) === false) &&
    (stripos($referer, $allowed_domain) === false)
) {
    http_response_code(403);
    die(json_encode(['status'=>'error','message'=>'Forbidden']));
}
session_start();

// Chỉ cho phép POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status'=>'error','message'=>'Method Not Allowed']);
    exit;
}

// Chỉ cho phép JSON
if (stripos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') === false) {
    http_response_code(400);
    echo json_encode(['status'=>'error','message'=>'Invalid Content-Type']);
    exit;
}
// Token bảo mật
$SECRET_TOKEN = "tham0501_an3008_abu2208";

// Include config
require_once "cfg_dongphuc.php";

// Đọc JSON từ body
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
  http_response_code(400);
  echo json_encode(['status' => 'error', 'message' => 'Invalid JSON']);
  exit;
}
if (!isset($input['csrf_token']) || $input['csrf_token'] !== $_SESSION['csrf_token']) {
    http_response_code(403);
    die(json_encode(['status'=>'error','message'=>'Invalid CSRF token']));
}

// Kiểm tra token
$token = $input['token'] ?? '';
if ($token !== $SECRET_TOKEN) {
  http_response_code(403);
  echo json_encode(['status' => 'error', 'message' => 'Forbidden']);
  exit;
}

// Lấy dữ liệu
$school_name   = trim($input['school_name'] ?? '');
$size   = trim($input['size'] ?? '');
$parent_name   = trim($input['parent_name'] ?? '');
$student_name  = trim($input['student_name'] ?? '');
$gender        = trim($input['gender'] ?? '');
$grade         = intval($input['grade'] ?? 0);
$class_name    = trim($input['class'] ?? '');
$customClass   = trim($input['customClass'] ?? '');
if ($class_name === 'other' && $customClass) {
  $class_name = $customClass;
}
$height_cm     = floatval($input['height'] ?? 0);
$weight_kg     = floatval($input['weight'] ?? 0);
$style         = trim($input['style'] ?? '');
$message       = trim($input['message'] ?? '');

// Kiểm tra bắt buộc
if (!$school_name || !$parent_name || !$student_name) {
  echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
  exit;
}

// Ghi log
$log_file = __DIR__ . '/logs/order_log.txt';
if (!file_exists(dirname($log_file))) {
  mkdir(dirname($log_file), 0777, true);
}
file_put_contents($log_file, date('Y-m-d H:i:s') . " | " . json_encode($input) . PHP_EOL, FILE_APPEND);

// Insert DB
try {
  $stmt = $conn->prepare("INSERT INTO orders 
        (school_name, size, parent_name, student_name, gender, grade, class, height, weight, style, message)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  $stmt->execute([
    $school_name,
    $size,
    $parent_name,
    $student_name,
    $gender,
    $grade,
    $class_name,
    $height_cm,
    $weight_kg,
    $style,
    $message
  ]);
  $order_id = $conn->lastInsertId();

  // Xử lý loại áo
  $types = ['coctay', 'daitay', 'khoac', 'codo'];
  foreach ($types as $type) {
    $qty = intval($input["qty_$type"] ?? 0);
    if ($qty > 0) {
      $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, type, quantity) VALUES (?, ?, ?)");
      $stmt_item->execute([$order_id, $type, $qty]);
    }
  }

  echo json_encode(['status' => 'success', 'order_id' => $order_id]);
} catch (PDOException $e) {
  http_response_code(500);
  echo json_encode(['status' => 'error', 'message' => 'DB insert failed', 'error' => $e->getMessage()]);
}
