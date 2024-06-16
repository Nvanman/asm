<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "phpfpt";

// Tạo kết nối
$connection = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
