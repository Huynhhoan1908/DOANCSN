<?php
session_start();
// Kết nối database
$conn = mysqli_connect("localhost", "root", "");

// Kiểm tra kết nối
if (!$conn) {
    die("Kết nối MySQL thất bại: " . mysqli_connect_error());
}

// Thử tạo database nếu chưa tồn tại
$sql = "CREATE DATABASE IF NOT EXISTS ban_hang";
if (!mysqli_query($conn, $sql)) {
    die("Lỗi tạo database: " . mysqli_error($conn));
}

// Chọn database
if (!mysqli_select_db($conn, "ban_hang")) {
    die("Lỗi chọn database: " . mysqli_error($conn));
}

// Tạo bảng nguoi_dung nếu chưa tồn tại
$sql = "CREATE TABLE IF NOT EXISTS nguoi_dung (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ho_ten VARCHAR(100) NOT NULL,
    ten_dang_nhap VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    mat_khau VARCHAR(255) NOT NULL,
    quyen VARCHAR(20) NOT NULL DEFAULT 'user',
    ngay_tao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (!mysqli_query($conn, $sql)) {
    die("Lỗi tạo bảng nguoi_dung: " . mysqli_error($conn));
}

// Xử lý đăng ký
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ho_ten = mysqli_real_escape_string($conn, $_POST['ho_ten']);
    $ten_dang_nhap = mysqli_real_escape_string($conn, $_POST['ten_dang_nhap']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mat_khau = $_POST['mat_khau'];
    
    // Kiểm tra xem tên đăng nhập hoặc email đã tồn tại chưa
    $check_query = "SELECT * FROM nguoi_dung WHERE ten_dang_nhap = ? OR email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("ss", $ten_dang_nhap, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $error = "Tên đăng nhập hoặc email đã tồn tại!";
    } else {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($mat_khau, PASSWORD_DEFAULT);
        
        // Thêm người dùng mới
        $insert_query = "INSERT INTO nguoi_dung (ho_ten, ten_dang_nhap, email, mat_khau) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssss", $ho_ten, $ten_dang_nhap, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $success = "Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.";
        } else {
            $error = "Có lỗi xảy ra: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Ký</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        background: #f5f6fa;  /* Thay đổi màu nền */
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container {
        max-width: 500px;  /* Tăng độ rộng container */
        width: 100%;
        background: #fff;
        padding: 30px;  /* Tăng padding */
        border-radius: 15px;  /* Tăng border radius */
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);  /* Điều chỉnh shadow nhẹ nhàng hơn */
        margin: auto;
    }

    .title {
        font-size: 28px;  /* Tăng kích thước chữ */
        font-weight: 600;  /* Tăng độ đậm */
        text-align: center;
        margin-bottom: 30px;  /* Tăng margin bottom */
        color: #1a1a1a;  /* Màu chữ đậm hơn */
    }

    .form-control {
        height: 45px;  /* Tăng chiều cao input */
        font-size: 16px;
        border-radius: 8px;  /* Bo tròn góc input */
        border: 1px solid #ddd;
        padding: 0 15px;
    }

    .form-control:focus {
        border-color: #71b7e6;
        box-shadow: 0 0 0 0.2rem rgba(113, 183, 230, 0.25);
    }

    .form-group {
        margin-bottom: 20px;  /* Tăng khoảng cách giữa các form group */
    }

    .form-group label {
        font-weight: 600;
        margin-bottom: 8px;
        display: block;
        color: #333;
    }

    .btn-register {
        height: 48px;  /* Tăng chiều cao button */
        width: 100%;
        background: linear-gradient(135deg, #71b7e6, #9b59b6);
        border: none;
        color: #fff;
        font-size: 18px;  /* Tăng kích thước chữ */
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .btn-register:hover {
        background: linear-gradient(135deg, #9b59b6, #71b7e6);
        transform: translateY(-2px);
    }

    .error-message, .success-message {
        padding: 12px;  /* Tăng padding */
        margin-bottom: 20px;
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
    }

    @media (max-width: 576px) {
        .container {
            margin: 20px;
            padding: 20px;
        }
    }
</style>
</head>
<body>
    <div class="container">
    <div class="title">Đăng ký tài khoản</div>
        
        <?php if (isset($error) && $error !== ''): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if (isset($success) && $success !== ''): ?>
            <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" action="" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="ho_ten">Họ và tên:</label>
                <input type="text" class="form-control" id="ho_ten" name="ho_ten" required>
            </div>

            <div class="form-group">
                <label for="ten_dang_nhap">Tên đăng nhập:</label>
                <input type="text" class="form-control" id="ten_dang_nhap" name="ten_dang_nhap" required minlength="3" maxlength="50">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="mat_khau">Mật khẩu:</label>
                <input type="password" class="form-control" id="mat_khau" name="mat_khau" required minlength="6">
            </div>

            <div class="form-group">
                <label for="xac_nhan_mat_khau">Xác nhận mật khẩu:</label>
                <input type="password" class="form-control" id="xac_nhan_mat_khau" name="xac_nhan_mat_khau" required>
            </div>

            <button type="submit" class="btn-register">Đăng ký</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
    function validateForm() {
        var password = document.getElementById("mat_khau").value;
        var confirm_password = document.getElementById("xac_nhan_mat_khau").value;
        
        if (password !== confirm_password) {
            alert("Mật khẩu xác nhận không khớp!");
            return false;
        }
        return true;
    }
    </script>
</body>
</html>