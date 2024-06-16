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

    // Kiểm tra xem có tham số MaDM được truyền vào hay không
    if (isset($_GET['MaDM'])) {
        $maDM = $_GET['MaDM'];

        // Xóa tất cả các sản phẩm liên quan đến danh mục này trước
        $sqlDeleteProducts = "DELETE FROM sanpham WHERE MaDM = :MaDM";
        $stmtDeleteProducts = $conn->prepare($sqlDeleteProducts);
        $stmtDeleteProducts->bindParam(':MaDM', $maDM, PDO::PARAM_INT);
        $stmtDeleteProducts->execute();

        // Sau khi xóa các sản phẩm, xóa danh mục
        $sqlDeleteCategory = "DELETE FROM danhmuc WHERE MaDM = :MaDM";
        $stmtDeleteCategory = $conn->prepare($sqlDeleteCategory);
        $stmtDeleteCategory->bindParam(':MaDM', $maDM, PDO::PARAM_INT);

        if ($stmtDeleteCategory->execute()) {
            echo "Xóa danh mục thành công!";
            header("Location: danhmuc.php");
            exit();
        } else {
            echo "Xóa danh mục thất bại!";
        }
    } else {
        echo "Không có danh mục nào được chọn!";
    }
} catch(PDOException $e) {
    echo "Kết nối database thất bại: " . $e->getMessage();
}
?>
