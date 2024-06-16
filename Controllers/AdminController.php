<?php
session_start();

class AdminController {
    private $conn;

    public function __construct() {
        // Kiểm tra người dùng đăng nhập và có quyền truy cập admin không
        if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
            $this->redirect('index.php');
        }

        // Khởi tạo kết nối đến cơ sở dữ liệu
        $this->conn = new PDO('mysql:host=localhost;dbname=your_database', 'your_username', 'your_password');
    }

    public function getAllProducts() {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM danhmuc");
            $stmt->execute();
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            throw new Exception("Lỗi: " . $e->getMessage());
        }
    }

    public function render($page_layout = 'danhsach') {
        // Đảm bảo rằng tham số 'page_layout' đã được truyền và xử lý nó
        if (isset($_GET['page_layout'])) {
            $page_layout = $_GET['page_layout'];
        }

        // Kiểm tra tính hợp lệ của tham số $page_layout
        $validLayouts = array('danhsach', 'them', 'sua', 'xoa');
        if (!in_array($page_layout, $validLayouts)) {
            throw new Exception("Trang không hợp lệ.");
        }

        // Hiển thị trang tương ứng
        $file_path = dirname(__FILE__) . '/../Views/admin/' . $page_layout . '.php';
        if (file_exists($file_path)) {
            require_once $file_path;
        } else {
            throw new Exception("Trang không tồn tại.");
        }
    }

    private function redirect($url) {
        header('Location: ' . $url);
        exit;
    }   
}

// Sử dụng lớp AdminController
$adminController = new AdminController();
$products = $adminController->getAllProducts();
$adminController->render();
?>