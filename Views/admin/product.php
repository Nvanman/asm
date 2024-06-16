<?php
class Product {
    private $db;

    public function __construct() {
        // Database connection parameters
        $hostname = "localhost"; // Usually "localhost" or "127.0.0.1" for local development
        $username = "root"; // Default username for XAMPP
        $password = ""; // Default password for XAMPP is empty
        $database = "phpfpt"; // Replace with your actual database name

        // Initialize the database connection using PDO
        try {
            $this->db = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getAllProducts() {
        $sql = "SELECT p.*, b.TenDM
                FROM sanpham p
                INNER JOIN danhmuc b ON p.MaDM = b.MaDM";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $sanpham = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sanpham;
    }

    public function getTotalProducts() {
        $query = "SELECT COUNT(*) as total FROM sanpham";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getProductsByPage($page, $productsPerPage) {
        $offset = ($page - 1) * $productsPerPage;
        $query = "SELECT p.*, b.TenDM
                  FROM sanpham p
                  INNER JOIN danhmuc b ON p.MaDM = b.MaDM
                  LIMIT :offset, :limit";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $productsPerPage, PDO::PARAM_INT);
        $stmt->execute();
        $sanpham = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $sanpham;
    }

    public function getProductById($id) {
        $query = "SELECT p.*, b.TenDM
                  FROM sanpham p
                  INNER JOIN danhmuc b ON p.MaDM = b.MaDM
                  WHERE p.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $sanpham = $stmt->fetch(PDO::FETCH_ASSOC);
        return $sanpham;
    }

    public function createProduct($TenSP, $MoTa, $DonGia, $MaDM) {
        $query = "INSERT INTO sanpham (TenSP, MoTa, DonGia, MaDM) VALUES (:TenSP, :MoTa, :DonGia, :MaDM)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':TenSP', $TenSP, PDO::PARAM_STR);
        $stmt->bindParam(':MoTa', $MoTa, PDO::PARAM_STR);
        $stmt->bindParam(':DonGia', $DonGia, PDO::PARAM_STR);
        $stmt->bindParam(':MaDM', $MaDM, PDO::PARAM_INT);
        $result = $stmt->execute();
        return $result;
    }

    public function __destruct() {
        $this->db = null; // Close the PDO connection
    }
}
?>
