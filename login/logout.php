<?php
session_start();

// Xóa tất cả các session
session_destroy();

// Chuyển hướng người dùng đến trang chính (hoặc bất kỳ trang nào bạn muốn sau khi đăng xuất)
header("Location: ../index.php");
exit;
?>
