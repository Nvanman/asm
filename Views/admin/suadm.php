<?php
// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfpt";

try {
    // Tạo kết nối
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Thiết lập chế độ lỗi PDO
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['MaDM'])) {
        $MaDM = $_GET['MaDM'];

        // Lấy thông tin danh mục
        $sql = "SELECT * FROM danhmuc WHERE MaDM = :MaDM";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':MaDM', $MaDM);
        $stmt->execute();
        $danhmuc = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $TenDM = $_POST['TenDM'];

            // Cập nhật thông tin danh mục
            $sql_update = "UPDATE danhmuc SET TenDM = :TenDM WHERE MaDM = :MaDM";
            $stmt_update = $connect->prepare($sql_update);
            $stmt_update->bindParam(':TenDM', $TenDM);
            $stmt_update->bindParam(':MaDM', $MaDM);

            if ($stmt_update->execute()) {
                echo "Cập nhật danh mục thành công!";
                header("Location: danhmuc.php"); // Chuyển hướng về trang danh sách danh mục
                exit();
            } else {
                echo "Lỗi: Không thể cập nhật danh mục";
            }
        }
    } else {
        echo "Không tìm thấy mã danh mục!";
        exit();
    }
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}

// Đóng kết nối cơ sở dữ liệu
$connect = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Danh Mục</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h2>Sửa Danh Mục</h2>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="form-group">
                    <label for="">Tên Danh Mục</label>
                    <input type="text" name="TenDM" id="" class="form-control" value="<?php echo htmlspecialchars($danhmuc['TenDM']); ?>" required>
                </div>
                <button name="sbm" class="btn btn-success" type="submit">Cập Nhật</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
