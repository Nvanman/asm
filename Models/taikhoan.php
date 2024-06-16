<?php
include_once __DIR__ . '/db.php';

class TaiKhoan {
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }

    public function getTaiKhoan($tenTK, $matKhau) {
        $sql = "SELECT * FROM taikhoan WHERE TenTK = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $tenTK);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                if (password_verify($matKhau, $user['MatKhau'])) {
                    return $user;
                }
            }
            $stmt->close();
        }
        return null;
    }
}
?>
