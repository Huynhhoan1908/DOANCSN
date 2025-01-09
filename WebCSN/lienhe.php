<!DOCTYPE html>
<html>
<head>
    <title>Hoàn Shop</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
    }

    header {
        background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
        padding: 20px 0;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 40px;
    }

    .left-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .logo img {
        border-radius: 50%;
        border: 3px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s ease;
    }

    .logo img:hover {
        transform: scale(1.05);
    }

    .logo h1 {
        color: #ffffff;
        margin: 0;
        font-size: 2.2em;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }

    .slogan {
        color: rgba(255, 255, 255, 0.95);
        margin: 5px 0;
        font-size: 1.2em;
        font-weight: 400;
        font-style: italic;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        max-width: 600px;
    }

    .nav-menu {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .nav-menu a {
        text-decoration: none;
        color: #ffffff;
        padding: 12px 25px;
        border-radius: 25px;
        transition: all 0.3s ease;
        font-weight: 500;
        font-size: 1em;
        background: rgba(255,255,255,0.1);
        letter-spacing: 0.5px;
    }

    .nav-menu a:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .contact-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 20px;
        background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    .contact-info h1 {
        color: #2193b0;
        border-bottom: 3px solid #6dd5ed;
        padding-bottom: 10px;
        display: inline-block;
    }

    .shop-description {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 25px;
        border-radius: 12px;
        border-left: 5px solid #2193b0;
        margin-top: 20px;
    }

    .shop-description h3 {
        color: #2193b0;
    }

    .contact-info p strong {
        color: #2193b0;
    }

    .contact-image img {
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }

    .contact-image img:hover {
        transform: scale(1.02);
    }

    footer {
        background: linear-gradient(to right, #2193b0, #6dd5ed);
        color: #fff;
        text-align: center;
        padding: 25px;
        position: relative;
        bottom: 0;
        width: 100%;
    }

    /* Thêm hiệu ứng cho danh sách */
    .shop-description ul li {
        margin: 10px 0;
        padding-left: 20px;
        position: relative;
    }

    .shop-description ul li:before {
        content: "•";
        color: #2193b0;
        font-weight: bold;
        position: absolute;
        left: 0;
    }

    /* Thêm style cho banner-images */
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
</style>
</head>
<body>
    <header>
        <div class="header-content">
            <div class="left-content">
                <div class="logo">
                    <img src="img/logo.jpg" alt="Hoàn Shop Logo" width="90" height="90">
                    <h1>Hoàn Shop</h1>
                </div>
                <h3 class="slogan">Hãy để balo của chúng tôi trở thành người bạn đồng hành không thể thiếu trong hành trình của bạn!</h3>
            </div>
            
            <nav class="nav-menu">
                <a href="trangchu.php">Trang chủ</a>
                <a href="gioithieu.php">Giới thiệu</a>
                <a href="Sản phẩm.php">Sản phẩm</a>
                <a href="dangnhap.php">Đăng nhập</a>
                <a href="dangky.php">Đăng ký</a>
            </nav>
        </div>
    </header>

    <div class="contact-container">
        <div class="contact-info">
            <h1>Thông tin chi tiết của Shop</h1>
            <h3>Tên: Hoàn Shop</h3>
            <p><strong>Số điện thoại liên hệ, zalo:</strong> 0795474219</p>
            <p><strong>Địa chỉ shop:</strong> Vinh Kim, Cầu Ngang, Trà Vinh</p>
            <p><strong>Số sản phẩm đang bán:</strong> 20 sản phẩm</p>
            
            <div class="shop-description">
                <h3>Mô tả shop:</h3>
                <p>Cảm ơn các cậu đã ghé thăm Hoàn Shop</p>
                <p>- Chuyên balo Unisex, túi xách xinh xắn, hàng đẹp giá OKE</p>
                <p><strong>Quý khách lưu ý:</strong></p>
                <ul>
                    <li>Shop không nhận đặt hàng qua tin nhắn và ghi chú, quý khách vui lòng đặt hàng trên website giúp shop</li>
                    <li>Khi nhận hàng vui lòng quay lại video mở hàng, hãy nhắn tin cho shop nếu có bất kì khiếu nại hoặc thắc mắc gì, shop sẽ hỗ trợ tận tình và nhanh nhất</li>
                </ul>
            </div>
        </div>
        
        <div class="contact-image">
            <img src="img/7.jpg" alt="Shop Image" width="300" height="300">
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <p>© 2024 Hoàn Balo Shop. All rights reserved.</p>
            <p>Liên hệ (Contact): 0795474219</p>
        </div>
    </footer>
</body>
</html>