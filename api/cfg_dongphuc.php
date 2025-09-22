<?php
// cfg_dongphuc.php
// Thông tin DB (không để trực tiếp ngoài webroot nếu host cho phép)
// $DB_HOST = "sql308.ezyro.com";
// $DB_NAME = "ezyro_39602684_dongphuc";
// $DB_USER = "ezyro_39602684";
// $DB_PASS = "91e1e08f9d036b63";
$DB_HOST = "localhost";
$DB_NAME = "dongphuc";
$DB_USER = "root";
$DB_PASS = "";

// Tạo kết nối PDO
try {
    $conn = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8", $DB_USER, $DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Không in lỗi chi tiết ra client
    die(json_encode(['status'=>'error','message'=>'DB Connection failed']));
}
?>
