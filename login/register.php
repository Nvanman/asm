    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once __DIR__ . '/../Controllers/RegisterController.php';

    $controller = new RegisterController();

    // Kiểm tra nếu có dữ liệu gửi đi từ form
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy giá trị từ form
        $tenTK = $_POST['TenTK'];
        $matKhau = $_POST['MatKhau'];
        $email = $_POST['Email'];

        // Kiểm tra xem email đã tồn tại trong cơ sở dữ liệu hay chưa
        // Ví dụ: $controller->checkEmailExists($email)
        $emailExists = $controller->checkEmailExists($email);

        if ($emailExists) {
            // Hiển thị thông báo lỗi nếu email đã tồn tại
            echo "<script>alert('Địa chỉ email đã được sử dụng cho một tài khoản khác.');</script>";
        } else {
            // Thực hiện quá trình đăng ký
            $controller->register();
        }
    }
    ?>


    <!DOCTYPE html>
    <html lang="vi">
    <head>
        <meta charset="UTF-8">
        <title>ĐĂNG KÝ</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <style>
            body, html {
                margin: 0;
                padding: 0;
                height: 100%;
                font-family: Arial, sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                background-image: url("https://i.imgur.com/kqlZiBJ.jpeg");
                background-size: cover;
                background-position: center;
            }

            .register-form {
                background-color: rgba(255, 255, 255, 0.8);
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 400px; /* Đảm bảo form có độ rộng cố định */
            }

            .form-group {
                margin-bottom: 15px;
            }

            .form-group label {
                display: block;
                margin-bottom: 5px;
            }

            .form-group input {
                width: calc(100% - 22px); /* Điều chỉnh chiều rộng của input để tránh lệch */
                padding: 10px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .form-group input[type="checkbox"] {
        position: absolute;
        top: 59px;
        right: 69px;
        transform: translateY(-50%);
    }

            .btn-submit {
                width: 100%;
                padding: 10px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }

            .text-center {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <form action="" method="post" class="register-form">
            <div class="form-group">
                <label for="TenTK">Tên tài khoản:</label>
                <input type="text" id="TenTK" name="TenTK" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="MatKhau">Mật khẩu:</label>
                <div style="position: relative;">
                    <input type="password" id="MatKhau" name="MatKhau" class="form-control" required>
                    <input type="checkbox" id="showPassword1">
                    <label for="showPassword1" class="mt-2">Hiện mật khẩu:</label>
                </div>
            </div>
            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" id="Email" name="Email" class="form-control" required>
            </div>
            <div class="form-group">
                <button type="submit" name="btn_submit" class="btn-submit">Đăng ký</button>
            </div>
            <div class="text-center">
                <p>
                    Bạn đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
                </p>
                <p>
                    Quên mật khẩu? <a href="send_reset_email.php">Khôi phục ngay</a>
                </p>
            </div>
        </form>
        <script>
            // JavaScript để thay đổi loại của input
            const passwordFields = document.querySelectorAll('input[type="password"]');
            const showPasswordCheckboxes = document.querySelectorAll('input[type="checkbox"][id^="showPassword"]');

            showPasswordCheckboxes.forEach(function(checkbox, index) {
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        passwordFields[index].type = 'text';
                    } else {
                        passwordFields[index].type = 'password';
                    }
                });
            });
        </script>
    </body>
    </html>
