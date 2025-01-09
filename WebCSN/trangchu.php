<?php
try {
    // Thông tin kết nối MySQL
    $host = 'localhost';
    $dbname = 'ban_hang';
    $username = 'root';
    $password = '';

    // Tạo kết nối PDO với các options bổ sung
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, $options);
    
        
} catch(PDOException $e) {
    // Bổ sung thêm log lỗi
    error_log("Database Error: " . $e->getMessage());
    die("Lỗi kết nối: " . $e->getMessage());
}
?>
<viphp
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoàn Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            background-color: #f9f7f7;
            color: #555;
        }

        header {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: #ffffff;
            padding: 25px 25px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 1200px;
            margin: 0 auto;
        }

        .left-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            border-radius: 50%;
            border: 3px solid rgba(255,255,255,0.3);
            transition: transform 0.4s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .logo img:hover {
            transform: scale(1.05);
        }

        .logo h1 {
            font-size: 2em;
            margin: 0;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .slogan {
            font-size: 1em;
            margin: 5px 0;
            max-width: 300px;
            color: rgba(255,255,255,0.9);
            font-style: italic;
            padding-left: 0;
        }

        .nav-menu {
            display: flex;
            gap: 20px;
            padding-top: 10px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
            font-weight: 500;
            font-size: 0.95em;
            background: rgba(255,255,255,0.1);
        }

        .nav-menu a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .banner-images {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            margin-top: 10px;
            padding: 5px 40px;
            transform: translateX(-20px);
        }

        .product-image {
            width: 160px;
            height: 110px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-image:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.3);
        }

        main {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 40px 20px;
            margin-bottom: 80px;
            background-color: #f9f7f7;
        }

        .video-container {
            background: white;
            border-radius: 20px;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            transition: all 0.4s ease;
            width: 340px;
        }

        .video-container:hover {
            transform: translateY(-15px);
            box-shadow: 0 15px 35px rgba(75,108,183,0.15);
        }

        .video-container video {
            border-radius: 15px;
            width: 100%;
            height: 280px;
            object-fit: cover;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .btn {
            background: #f8f9fa;
            border: none;
            margin-top: 15px;
            padding: 12px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn a {
            text-decoration: none;
            color: #2c3e50;
            font-weight: 600;
            font-size: 1.1em;
            display: block;
        }

        .btn:hover {
            background: #3498db;
        }

        .btn:hover a {
            color: #ffffff;
        }

        footer {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: #ffffff;
            text-align: center;
            padding: 25px;
            position: fixed;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
        }

        .footer-content p {
            margin: 5px 0;
            font-size: 0.9em;
            color: #ecf0f1;
        }

        .filter-section {
            margin: 20px 0;
            text-align: center;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
        }

        .filter-section label {
            font-weight: 500;
            color: #555;
            margin-right: 10px;
        }

        .filter-section select {
            padding: 10px 15px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            background-color: #f7f9fc;
            color: #465881;
        }

        .filter-section select:focus {
            outline: none;
            box-shadow: 0 2px 15px rgba(181, 198, 224, 0.3);
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="left-content">
                <div class="logo">
                    <img src="img/logo.jpg" alt="Hoàn Shop Logo" width="80" height="80">
                    <h1>Hoàn Shop</h1>
                </div>
                <h3 class="slogan">Hãy để balo của chúng tôi trở thành người bạn đồng hành không thể thiếu trong hành trình của bạn!</h3>
            </div>
            
            <nav class="nav-menu">

                <a href="gioithieu.php">Giới thiệu</a>
                <a href="Sản phẩm.php">Sản phẩm</a>
                <a href="lienhe.php">Liên hệ</a>
                <a href="dangnhap.php">Đăng nhập</a>
                <a href="dangky.php">Đăng ký</a>
            </nav>
        </div>
        
        <div class="banner-images">
            <img src="img/3.jpg" alt="Balo họa tiết xanh lục" class="product-image">
            <img src="img/7.jpg" alt="Balo xanh lá" class="product-image">
            <img src="img/16.jpg" alt="túi xách tai thỏ" class="product-image">
            <img src="img/13.jpg" alt="túi xách đeo chéo dễ thương" class="product-image">
        </div>
    </header>
            <!-- Thanh lọc sản phẩm -->
            <div class="filter-section">
            <label for="product-type">Loại sản phẩm:</label>
            <select id="product-type" onchange="filterProducts()">
                <option value="all">Tất cả</option>
                <option value="balo">Balo</option>
                <option value="tuixach">Túi xách</option>
            </select>
        </div>
    <main>
    <div class="video-container">
      <figure>
        <video src="video/v1.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="balo1.php">Balo Black orange</a></button></figcaption>
        <figcaption></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v2.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="balo2.php">Balo xám to</a></button></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v3.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="balo3.php">Balo họa tiết xanh lục</a></button></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v7.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="balo7.php">Balo xanh lá</a></button></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v8.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="balo8.php">Balo trắng nhỏ gọn</a></button></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v10.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="balo10.php">Balo thỏ</a></button></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v12.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="tuixach12.php">Túi đeo chéo ngang</a></button></figcaption>
        <figcaption></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v13.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="tuixach13.php">Túi xách, đeo chéo dễ thương</a></button></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v16.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="tuixach16.php">Túi xách tai thỏ</a></button></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v17.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="tuixach7.php">Túi đeo chéo to</a></button></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v18.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="tuixach18.php">Túi đeo chéo caro</a></button></figcaption>
      </figure>
      </div>
      <div class="video-container">
      <figure>
        <video src="video/v20.mp4" width="300" height="250" controls></video>
        <figcaption><button class="btn"><a href="tuixach20.php">Túi xách công sở</a></button></figcaption>
      </figure>
      </div>
    </main>

    <script>
    function filterProducts() {
        const selectedType = document.getElementById('product-type').value;
        const videoContainers = document.querySelectorAll('.video-container');

        videoContainers.forEach(container => {
            const link = container.querySelector('a').getAttribute('href');
            
            if (selectedType === 'all') {
                container.style.display = 'block';
            } else if (selectedType === 'balo' && link.includes('balo')) {
                container.style.display = 'block';
            } else if (selectedType === 'tuixach' && link.includes('tuixach')) {
                container.style.display = 'block';
            } else {
                container.style.display = 'none';
            }
        });
    }

    // Thêm class để đánh dấu loại sản phẩm
    document.addEventListener('DOMContentLoaded', function() {
        const videoContainers = document.querySelectorAll('.video-container');
        
        videoContainers.forEach(container => {
            const link = container.querySelector('a').getAttribute('href');
            if (link.includes('balo')) {
                container.classList.add('type-balo');
            } else if (link.includes('tuixach')) {
                container.classList.add('type-tuixach');
            }
        });
    });
    </script>

        <footer>
        <div class="footer-content">
            <p>© 2024 Hoàn Shop. All rights reserved.</p>
            <p>Liên hệ (Contact): 0795474219</p>
        </div>
    </footer>

</body>
</html>