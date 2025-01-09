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

// Xử lý đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM nguoi_dung WHERE ten_dang_nhap=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
      $user_data = $result->fetch_assoc();
      if (password_verify($password, $user_data['mat_khau'])) {
          $_SESSION['username'] = $username;
          $_SESSION['user_id'] = $user_data['id'];
          $_SESSION['role'] = $user_data['quyen'];
          
          // Update the path if trang-chu.php is in a different directory
          header("location: trangchu.php"); // Change this if needed, e.g., "location: /subdir/trang-chu.php"
          exit();
      } else {
          $error = "Tên đăng nhập hoặc mật khẩu không đúng";
      }
  } else {
      $error = "Tên đăng nhập hoặc mật khẩu không đúng";
  }
}  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Đăng nhập</title>
</head>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .login-container {
    background: rgba(255, 255, 255, 0.95);
    padding: 40px 50px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    width: 100%;
    max-width: 400px;
    transition: transform 0.3s ease;
  }

  .login-container:hover {
    transform: translateY(-5px);
  }

  h1 {
    text-align: center;
    color: #2d3748;
    margin-bottom: 30px;
    font-size: 2.2em;
    font-weight: 600;
  }

  form {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }

  label {
    color: #4a5568;
    font-weight: 500;
    font-size: 0.95em;
  }

  input[type="text"],
  input[type="password"] {
    padding: 15px;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 1em;
    transition: all 0.3s ease;
    outline: none;
  }

  input[type="text"]:focus,
  input[type="password"]:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
  }

  input[type="submit"] {
    background: linear-gradient(to right, #667eea, #764ba2);
    color: white;
    padding: 15px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1em;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    margin-top: 10px;
  }

  input[type="submit"]:hover {
    background: linear-gradient(to right, #764ba2, #667eea);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
  }
  .signup-link {
    text-align: center;
    margin-top: 20px;
    display: block;
    color: #667eea;
    text-decoration: none;
    font-weight: 500;
    font-size: 1em;
    transition: all 0.3s ease;
  }

  .signup-link:hover {
    color: #764ba2;
    transform: translateY(-2px);
  }
</style>
<body>
  <div class="login-container">
    <h1>Đăng nhập</h1>
    <?php if(isset($error)) { ?>
        <p style="color: red; text-align: center;"><?php echo $error; ?></p>
    <?php } ?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="username">Tên đăng nhập:</label>
      <input type="text" id="username" name="username" required>
      <p></p>
      <label for="password">Mật khẩu:</label>
      <input type="password" id="password" name="password" required>
      <p></p>
      <input type="submit" value="Đăng nhập">
      <a href="dangky.php" class="signup-link">Đăng ký tài khoản mới</a>
    </form>
  </div>
</body>
</html>