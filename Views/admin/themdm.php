<?php
// Thông tin kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfpt";

try {
    // Kết nối database
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Xử lý lưu thông tin mới
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $tenDM = $_POST['TenDM'];
        $moTa = $_POST['MoTa'];
        $maTK = $_POST['MaTK'];

        $sql = "INSERT INTO danhmuc (TenDM, MoTa, MaTK) VALUES (:tenDM, :moTa, :maTK)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':tenDM', $tenDM);
        $stmt->bindParam(':moTa', $moTa);
        $stmt->bindParam(':maTK', $maTK);
        $stmt->execute();

        header("Location: danhmuc.php");
        exit;
    }
} catch(PDOException $e) {
    echo "Kết nối database thất bại: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Danh Mục Mới</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-4">Thêm Danh Mục Mới</h1>
    <form method="post">
        <div class="mb-4">
            <label for="TenDM" class="block text-sm font-medium text-gray-600">Tên Danh Mục</label>
            <input type="text" id="TenDM" name="TenDM" class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
        </div>
        <div class="mb-4">
            <label for="MoTa" class="block text-sm font-medium text-gray-600">Mô Tả</label>
            <textarea id="MoTa" name="MoTa" class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200" rows="4" required></textarea>
        </div>
        <div class="mb-4">
            <label for="MaTK" class="block text-sm font-medium text-gray-600">Mã Tài Khoản</label>
            <input type="text" id="MaTK" name="MaTK" class="mt-1 p-2 block w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200" required>
        </div>
        <div class="flex">
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md mr-4 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">Lưu</button>
            <a href="../../index.php" class="bg-gray-300 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400">Hủy</a>
        </div>
    </form>
</div>
</body>
</html>
