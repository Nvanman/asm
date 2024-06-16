<?php

session_start();

// Kiểm tra xem người dùng đã đăng nhập và có quyền truy cập admin không
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    // Người dùng không có quyền truy cập admin.php, chuyển hướng hoặc hiển thị thông báo lỗi
    header('<Location: class="  ">index.php'); // Chuyển hướng đến trang chính hoặc trang đăng nhập
    exit; // Kết thúc quá trình thực thi script
}
// Thông tin kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfpt";

try {
    // Kết nối database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy danh sách danh mục từ database
    $sql = "SELECT * FROM danhmuc";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $danhMucList = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch(PDOException $e) {
    echo "Kết nối database thất bại: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans">
<header>
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-6 py-3">
            <div class="flex items-center justify-between">
                <a class="text-gray-800 text-xl font-semibold" href="#">Trang Chủ</a>
                <div class="hidden md:block">
                    <ul class="ml-4 flex items-center space-x-4">
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="list_product.php">Sản Phẩm</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="danhmuc.php">Danh Mục</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="#">Đơn Hàng</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="#">Location</a>
                        </li>
                        <li>
                            <a class="text-gray-600 hover:text-gray-800" href="#">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>
<div class="container mx-auto mt-5">
    <h1 class="text-center mb-4 text-3xl font-bold">Danh Mục</h1>
    <a href='themdm.php' class="block w-max mx-auto mb-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md shadow-md">Thêm Danh Mục</a>
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">Mã Danh Mục</th>
                    <th class="px-4 py-2">Tên Danh Mục</th>
                    <th class="px-4 py-2">Mô Tả</th>
                    <th class="px-4 py-2">Mã Tài Khoản</th>
                    <th class="px-4 py-2">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($danhMucList as $danhMuc) { ?>
                <tr class="hover:bg-gray-100 transition-colors">
                    <td class="border px-4 py-2"><?= $danhMuc['MaDM'] ?></td>
                    <td class="border px-4 py-2"><?= $danhMuc['TenDM'] ?></td>
                    <td class="border px-4 py-2"><?= $danhMuc['MoTa'] ?></td>
                    <td class="border px-4 py-2"><?= $danhMuc['MaTK'] ?></td>
                    <td class="border px-4 py-2">
                        <a href="suadm.php?MaDM=<?= $danhMuc['MaDM'] ?>" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded-md shadow-md mr-2">Sửa</a>
                        <a href="xoadm.php?MaDM=<?= $danhMuc['MaDM'] ?>" class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded-md shadow-md" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?');">Xóa</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
</body>
</html>
