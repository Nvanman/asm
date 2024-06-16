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

    // Lấy dữ liệu từ bảng "danhmuc"
    $sql_brand = "SELECT * FROM danhmuc";
    $query_brand = $connect->query($sql_brand);

    // Kiểm tra xem mã sản phẩm có được cung cấp hay không
    if (isset($_GET['MaSP']) && $_GET['MaSP'] !== '') {
        $MaSP = $_GET['MaSP'];

        // Lấy thông tin sản phẩm dựa vào MaSP
        $sql_product = "SELECT * FROM sanpham WHERE MaSP = :MaSP";
        $stmt = $connect->prepare($sql_product);
        $stmt->bindParam(':MaSP', $MaSP);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            echo "Không tìm thấy sản phẩm với mã sản phẩm này.";
            exit;
        }
    } else {
        echo "Mã sản phẩm không được cung cấp.";
        exit;
    }

    // Xử lý dữ liệu được gửi từ form
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Lấy dữ liệu từ form
        $TenSP = $_POST['TenSP'];
        $DonGia = $_POST['DonGia'];
        $MoTa = $_POST['MoTa'];

        // Kiểm tra và gán giá trị cho $MaDM
        if (isset($_POST['MaDM']) && $_POST['MaDM'] !== '') {
            $MaDM = $_POST['MaDM'];
        } else {
            $MaDM = 1; // Gán giá trị mặc định
        }

        // Xử lý file upload
        if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
            $img = $_FILES['img']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($img);
            move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
        } else {
            $img = $product['img']; // Giữ nguyên ảnh cũ nếu không có ảnh mới được tải lên
        }

        // Thực hiện câu UPDATE
        $sql = "UPDATE sanpham SET TenSP = :TenSP, img = :img, DonGia = :DonGia, MoTa = :MoTa, MaDM = :MaDM WHERE MaSP = :MaSP";
        $stmt = $connect->prepare($sql);
        $stmt->bindParam(':TenSP', $TenSP);
        $stmt->bindParam(':img', $img);
        $stmt->bindParam(':DonGia', $DonGia);
        $stmt->bindParam(':MoTa', $MoTa);
        $stmt->bindParam(':MaDM', $MaDM);
        $stmt->bindParam(':MaSP', $MaSP);

        if ($stmt->execute()) {
            echo "Cập nhật sản phẩm thành công!";
        } else {
            echo "Lỗi: Không thể cập nhật sản phẩm";
        }
    }
} catch (PDOException $e) {
    echo "Lỗi kết nối: " . $e->getMessage();
}

// Đóng kết nối cơ sở dữ liệu
$connect = null;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<div class="container mx-auto p-6">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <h2 class="text-2xl font-semibold text-gray-700">Sửa Sản Phẩm</h2>
        </div>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label class="block text-gray-700" for="MaSP">Mã Sản Phẩm</label>
                <input type="text" name="MaSP" id="MaSP" class="form-input mt-1 block w-full" value="<?php echo $product['MaSP']; ?>" readonly>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="TenSP">Tên Sản Phẩm</label>
                <input type="text" name="TenSP" id="TenSP" class="form-input mt-1 block w-full" value="<?php echo $product['TenSP']; ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="img">Ảnh Sản Phẩm</label>
                <input type="file" name="img" id="img" class="mt-1 block w-full">
                <img src="img/<?php echo $product['img']; ?>" alt="<?php echo $product['TenSP']; ?>" class="mt-2 w-24 h-24 object-cover">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="DonGia">Giá Sản Phẩm</label>
                <input type="number" name="DonGia" id="DonGia" class="form-input mt-1 block w-full" value="<?php echo $product['DonGia']; ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="MoTa">Mô Tả Sản Phẩm</label>
                <input type="text" name="MoTa" id="MoTa" class="form-input mt-1 block w-full" value="<?php echo $product['MoTa']; ?>" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700" for="MaDM">Thương Hiệu</label>
                <select name="MaDM" id="MaDM" class="form-select mt-1 block w-full">
                    <?php
                    while ($row_brand = $query_brand->fetch(PDO::FETCH_ASSOC)) { ?>
                        <option value="<?php echo $row_brand['MaDM']; ?>" <?php if ($row_brand['MaDM'] == $product['MaDM']) echo 'selected'; ?>>
                            <?php echo $row_brand['TenDM']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button name="sbm" class="btn btn-success bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Cập Nhật</button>
        </form>
    </div>
</div>
</body>
</html>
