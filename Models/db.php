<?php
// db.php

$servername = "localhost"; // Thay thế bằng tên máy chủ cơ sở dữ liệu của bạn
$username = "root"; // Thay thế bằng tên người dùng cơ sở dữ liệu của bạn
$password = ""; // Thay thế bằng mật khẩu cơ sở dữ liệu của bạn
$dbname = "phpfpt"; // Thay thế bằng tên cơ sở dữ liệu của bạn

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
