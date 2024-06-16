<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Include the PHPMailer class
require '../mail/PHPMailer/src/PHPMailer.php';
require '../mail/PHPMailer/src/Exception.php';
require '../mail/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Hàm tạo mã OTP ngẫu nhiên
function generateOTP($length = 6) {
    $chars = '0123456789';
    $otp = '';
    $charsLength = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $otp .= $chars[rand(0, $charsLength - 1)];
    }
    return $otp;
}

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfpt"; // Tên cơ sở dữ liệu của bạn

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $conn->connect_error);
}

$emailSent = false;
$emailError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    // Xử lý yêu cầu gửi email khôi phục mật khẩu
    $email = $_POST['email'];

    // Tìm tài khoản có địa chỉ email tương ứng trong cơ sở dữ liệu
    $sql = "SELECT * FROM taikhoan WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $otpCode = generateOTP(6);

        // Cập nhật mã OTP vào cơ sở dữ liệu
        $sql_update = "UPDATE taikhoan SET OTP = '$otpCode', OTPExpiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE Email = '$email'";
        if ($conn->query($sql_update) === TRUE) {
            // Tạo đối tượng PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Cấu hình SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Điền tên máy chủ SMTP của bạn
                $mail->SMTPAuth = true;
                $mail->Username = 'mannvpd10299@gmail.com'; // Điền địa chỉ email của bạn
                $mail->Password = 'txyt fkkl kiqj rekp'; // Điền mật khẩu của bạn
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Thiết lập thông tin người gửi và người nhận
                $mail->setFrom('mannvpd10299@gmail.com', 'iphone');
                $mail->addAddress($email);

                $mail->CharSet = 'UTF-8';
                // Thiết lập chủ đề và nội dung của email
                $mail->Subject = 'Khôi phục mật khẩu';
                $mail->Body = 'Xin chào, bạn có thể sử dụng mã sau để khôi phục mật khẩu của mình: ' . $otpCode;

                // Gửi email
                $mail->send();

                // Đánh dấu là email đã được gửi thành công
                $emailSent = true;
            } catch (Exception $e) {
                $emailError = "Lỗi khi gửi email: {$mail->ErrorInfo}";
            }
        } else {
            $emailError = "Lỗi khi cập nhật mã OTP: " . $conn->error;
        }
    } else {
        $emailError = "Không tìm thấy tài khoản với địa chỉ email này.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Khôi phục mật khẩu</title>
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
        .email-status {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="text-center">Khôi phục mật khẩu</h2>
                    <form method="post" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-custom btn-block">Gửi email khôi phục</button>
                    </form>
                </div>
                <?php if ($emailSent): ?>
                    <div class="alert alert-success email-status" id="success-message">
                        Email đã được gửi thành công!
                    </div>
                    <script>
                        setTimeout(function() {
                            window.location.href = "reset_password.php?email=<?php echo $email; ?>";
                        }, 1500); // Chuyển hướng sau 3 giây
                    </script>
                <?php elseif (!empty($emailError)): ?>
                    <div class="alert alert-danger email-status">
                        <?php echo $emailError; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap 5.3.3 JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
