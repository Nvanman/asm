<?php
class User {
    private $db;

    public function __construct() {
        // Database connection parameters
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "php1fpt"; // replace with your database name

        // Initialize the database connection
        $this->db = new mysqli($hostname, $username, $password, $database);

        // Check the connection
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function getUser($username, $password) {
        $username = $this->db->real_escape_string($username);
        $password = $this->db->real_escape_string($password);
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $this->db->query($sql);
        return $result->fetch_assoc();
    }

    public function __destruct() {
        $this->db->close();
    }
}
class UserModel {
    private $conn;

    public function __construct() {
        // Connect to the database
        $this->conn = new PDO("mysql:host=localhost;dbname=phpfpt", "root", "");
        // Set error mode
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function registerUser($tenTK, $matKhau) {
        // Hash the password before storing it

        // Insert the new user into the database
        $stmt = $this->conn->prepare("INSERT INTO TaiKhoan (TenTK, MatKhau) VALUES (?, ?)");
        return $stmt->execute([$tenTK, $matKhau]);
    }
}

?>
