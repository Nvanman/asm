<?php
include_once __DIR__ . '/../Models/User.php';
include_once __DIR__ . '/db.php'; // Bao gồm tệp kết nối cơ sở dữ liệu

class RegisterController {
    public function checkEmailExists($email) {
        global $conn;

        $sql = "SELECT * FROM taikhoan WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return true; // Email đã tồn tại
            }
            $stmt->close();
        }
        return false; // Email chưa tồn tại
    }

    public function register() {
        global $conn;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $tenTK = $_POST['TenTK'];
            $matKhau = password_hash($_POST['MatKhau'], PASSWORD_BCRYPT);
            $email = $_POST['Email'];

            // Kiểm tra xem email đã tồn tại hay chưa
            if ($this->checkEmailExists($email)) {
                echo "Địa chỉ email đã được sử dụng cho một tài khoản khác.";
                return; // Dừng quá trình đăng ký
            }

            // Thực hiện xác thực và sau đó chèn vào cơ sở dữ liệu
            $sql = "INSERT INTO taikhoan (TenTK, MatKhau, Email) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sss", $tenTK, $matKhau, $email);
                if ($stmt->execute()) {
                    echo "Đăng ký thành công!";
                } else {
                    echo "Đăng ký thất bại: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Đăng ký thất bại: " . $conn->error;
            }
        }

        // Hiển thị view đăng ký người dùng
        require_once __DIR__ . '/../login/register.php';
    }
}
?>
