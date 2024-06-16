<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfpt"; // Tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $email = $_POST['email'];
    $otp = $_POST['otp'];
    $newPassword = $_POST['new_password'];

    // Kiểm tra OTP
    $sql = "SELECT * FROM taikhoan WHERE Email = '$email' AND OTP = '$otp' AND OTPExpiry > NOW()";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // OTP hợp lệ, đặt lại mật khẩu
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql_update = "UPDATE taikhoan SET MatKhau = '$hashedPassword', OTP = NULL, OTPExpiry = NULL WHERE Email = '$email'";
        if ($conn->query($sql_update) === true) {
            echo "Mật khẩu đã được cập nhật thành công!";
        } else {
            echo "Lỗi khi cập nhật mật khẩu: " . $conn->error;
        }
    } else {
        echo "OTP không hợp lệ hoặc đã hết hạn.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
    <!-- Bootstrap 5.3.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="text-center">Đặt lại mật khẩu</h2>
                    <form method="post" action="reset_password.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="otp" class="form-label">OTP:</label>
                            <input type="text" class="form-control" id="otp" name="otp" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Mật khẩu mới:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <button type="submit" class="btn btn-custom btn-block">Đặt lại mật khẩu</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5.3.3 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
