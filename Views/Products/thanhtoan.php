<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Địa Chỉ</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        label {
            margin-bottom: 10px;
        }
        
        input[type="text"], input[type="tel"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
        }
        
        #qr-code {
            display: none;
            margin-top: 20px;
        }
        
        #qr-code img {
            height: 500px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <h2 class="text-2xl font-bold mb-4">Nhập Địa Chỉ Nhận Hàng</h2>
    <form id="address-form" method="post" class="w-1/2 mx-auto">
        <label for="name" class="block">Họ Tên:</label>
        <input type="text" id="name" name="name" required class="block w-full p-2 rounded border border-gray-300">
        
        <label for="phone" class="block">Số Điện Thoại:</label>
        <input type="tel" id="phone" name="phone" pattern="[0-9]{10,11}" required class="block w-full p-2 rounded border border-gray-300">
        
        <label for="address" class="block">Địa Chỉ:</label>
        <input type="text" id="address" name="address" required class="block w-full p-2 rounded border border-gray-300">
        
        <label for="payment" class="block">Phương Thức Thanh Toán:</label>
        <select id="payment" name="payment" class="block w-full p-2 rounded border border-gray-300">
            <option value="cash">Thanh Toán Khi Nhận Hàng</option>
            <option value="online">Thanh Toán Online</option>
        </select>
        
        <button type="submit" class="btn btn-success mt-4">Xác Nhận Đặt Hàng</button>
    </form>
    
    <script>
        document.getElementById('payment').addEventListener('change', function() {
            var qrCode = document.getElementById('qr-code');
            if (this.value === 'online') {
                qrCode.style.display = 'block';
            } else {
                qrCode.style.display = 'none';
            }
        });
    </script>
</body>
</html>
