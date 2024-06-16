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

    // Kiểm tra xem mã sản phẩm có được cung cấp hay không
    if (isset($_GET['MaSP']) && $_GET['MaSP'] !== '') {
        $MaSP = $_GET['MaSP'];

        // Xóa sản phẩm dựa vào MaSP
        $sql_delete = "DELETE FROM sanpham WHERE MaSP = :MaSP";
        $stmt = $connect->prepare($sql_delete);
        $stmt->bindParam(':MaSP', $MaSP);

        if ($stmt->execute()) {
            echo "Xóa sản phẩm thành công!";
        } else {
            echo "Lỗi: Không thể xóa sản phẩm";
        }
    } else {
        echo "Mã sản phẩm không được cung cấp.";
    }
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}

// Đóng kết nối cơ sở dữ liệu
$connect = null;

// Chuyển hướng về trang danh sách sản phẩm sau khi xóa
header("Location: list_product.php");
exit;
?>
