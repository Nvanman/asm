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

        header("Location: index.php");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1>Thêm Danh Mục Mới</h1>
    <form method="post">
        <div class="form-group">
            <label for="TenDM">Tên Danh Mục</label>
            <input type="text" class="form-control" id="TenDM" name="TenDM" required>
        </div>
        <div class="form-group">
            <label for="MoTa">Mô Tả</label>
            <textarea class="form-control" id="MoTa" name="MoTa" required></textarea>
        </div>
        <div class="form-group">
            <label for="MaTK">Mã Tài Khoản</label>
            <input type="text" class="form-control" id="MaTK" name="MaTK" required>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="index.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>
</body>
</html>