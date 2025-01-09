<!DOCTYPE html>
<html>
<head>
    <title>Hoàn Shop</title>
    <style>
        /* Header styles */
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

        /* Main content styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7fafc;
        }

        h1 {
            text-align: center;
            color: #2d3748;
            margin: 2rem 0;
            font-size: 2rem;
        }

        /* Cart styles */
        .cart {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .cart h2 {
            color: #2d3748;
            margin-bottom: 1.5rem;
        }

        .cart-total {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 2px solid #edf2f7;
            font-weight: bold;
            color: #2d3748;
        }

        /* Checkout form styles */
        #checkout-form {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #checkout-form h2 {
            color: #2d3748;
            margin-bottom: 1.5rem;
        }

        #checkout-form form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        #checkout-form label {
            font-weight: 500;
            color: #4a5568;
        }

        #checkout-form input {
            padding: 0.8rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
        }

        /* Footer styles */
        footer {
            background: #2d3748;
            color: white;
            padding: 2rem 0;
            margin-top: 4rem;
            text-align: center;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer-content p {
            margin: 0.5rem 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 sản phẩm mỗi hàng */
            gap: 2rem;
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .product-container {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .product-container img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-container:hover img {
            transform: scale(1.05);
        }

        .product-info {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 900px) {
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .products-grid {
                grid-template-columns: 1fr;
            }
        }
        .filter-section {
            display: flex; /* Sử dụng Flexbox để sắp xếp ngang */
            justify-content: center; /* Căn giữa các phần tử */
            align-items: center; /* Căn giữa theo chiều dọc */
            margin: 2rem auto;
            max-width: 1400px;
            padding: 0 2rem;
        }

        .filter-section label {
            margin-right: 1rem;
            font-weight: 500;
            color: #4a5568;
            margin-left: 2rem; /* Thêm khoảng cách giữa các bộ lọc */
        }

        .filter-section select {
            padding: 0.5rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            background-color: white;
            cursor: pointer;
        }

        /* Thêm styles cho modal thanh toán */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            border-radius: 15px;
            width: 80%;
            max-width: 500px;
            position: relative;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 10px;
            font-size: 28px;
            cursor: pointer;
        }

        .payment-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .payment-form input, .payment-form select {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .payment-form button {
            margin-top: 15px;
        }

        /* Thêm style cho link giỏ hàng */
        .cart-link {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .cart-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, #764ba2, #667eea);
        }

        .cart-link i {
            font-size: 1.2rem;
        }
    </style>
</head>

<!-- Cập nhật cấu trúc header -->
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
            <a href="trangchu.php">Trang chủ</a>
            <a href="gioithieu.php">Giới thiệu</a>
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

<body>
    <h1>Danh mục sản phẩm</h1>
    <a href="giohang.php" class="cart-link">
        <i class="fas fa-shopping-cart"></i>
        Giỏ hàng
    </a>
<div class="products-grid">
    <div class="product-container">
        <img src="img/1.jpg" alt="Balo Black orange" class="product-image">
        <div class="product-info">
            <h3><a href="balo1.php">Balo Black orange</a></h3>
            <p class="product-price">150.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Balo Black orange', 150000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo Black orange', 150000)">Mua hàng</button>
        </div>
    </div>
    
    <div class="product-container">
        <img src="img/2.jpg" alt="Balo xám to" class="product-image">
        <div class="product-info">
            <h3><a href="balo2.php">Balo xám to</a> </h3>
            <p class="product-price">160.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Balo xám to', 160000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo xám to', 160000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/3.jpg" alt="Balo họa tiết xanh lục" class="product-image">
        <div class="product-info">
            <h3><a href="balo3.php">Balo họa tiết xanh lục</a></h3>
            <p class="product-price">120.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Balo họa tiết xanh lục', 120000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo họa tiết xanh lục', 120000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/4.jpg" alt="Balo da" class="product-image">
        <div class="product-info">
            <h3><a href="balo4.php">Balo da</a></h3>
            <p class="product-price">140.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Balo da', 140000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo da', 140000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/5.jpg" alt="Balo đen nam tính" class="product-image">
        <div class="product-info">
            <h3><a href="balo5.php">Balo đen nam tính</a></h3>
            <p class="product-price">150.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Balo đen nam tính', 150000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo đen nam tính', 150000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/6.jpg" alt="Balo vịt vàng đáng yêu" class="product-image">
        <div class="product-info">
            <h3><a href="balo6.php">Balo vịt vàng đáng yêu</a></h3>
            <p class="product-price">99.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Balo vịt vàng đáng yêu', 99000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo vịt vàng đáng yêu', 99000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/7.jpg" alt="Balo xanh lá" class="product-image">
        <div class="product-info">
            <h3><a href="balo7.php">Balo xanh lá</a></h3>
            <p class="product-price">130.000 VND</p>
            <button class="btn" onclick="addToCart('Balo xanh lá', 130000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo xanh lá', 130000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/8.jpg" alt="Balo trắng nhỏ gọn" class="product-image">
        <div class="product-info">
            <h3><a href="balo8.php">Balo trắng nhỏ gọn</a></h3>
            <p class="product-price">140.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Balo trắng nhỏ gọn', 140000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo trắng nhỏ gọn', 140000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/9.jpg" alt="Balo to hợp đi du lịch" class="product-image">
        <div class="product-info">
            <h3><a href="balo9.php">Balo to hợp đi du lịch</a></h3>
            <p class="product-price">110.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Balo to hợp đi du lịch', 110000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo to hợp đi du lịch', 110000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/10.jpg" alt="Balo thỏ" class="product-image">
        <div class="product-info">
            <h3><a href="balo10.php">Balo thỏ</a></h3>
            <p class="product-price">150.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Balo thỏ', 150000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Balo thỏ', 150000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/11.jpg" alt="Túi đeo chéo màu xám" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach11.php">Túi đeo chéo màu xám</a></h3>
            <p class="product-price">99.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi đeo chéo màu xám', 99000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi đeo chéo màu xám', 99000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/12.jpg" alt="Túi đeo chéo ngang" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach12.php">Túi đeo chéo ngang</a></h3>
            <p class="product-price">110.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi đeo chéo ngang', 110000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi đeo chéo ngang', 110000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/13.jpg" alt="Túi xách, đeo chéo dễ thương" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach13.php">Túi xách, đeo chéo dễ thương</a></h3>
            <p class="product-price">85.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi xách, đeo chéo dễ thương', 85000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi xách, đeo chéo dễ thương', 85000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/14.jpg" alt="Túi đeo chéo đen" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach14.php">Túi đeo chéo đen</a></h3>
            <p class="product-price">99.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi đeo chéo đen', 99000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi đeo chéo đen', 99000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/15.jpg" alt="Túi xách dây rút" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach15.php">Túi xách dây rút</a></h3>
            <p class="product-price">89.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi xách dây rút', 89000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi xách dây rút', 89000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/16.jpg" alt="Túi xách tai thỏ" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach16.php">Túi xách tai thỏ</a></h3>
            <p class="product-price">87.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi xách tai thỏ', 130000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi xách tai thỏ', 130000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/17.jpg" alt="Túi đeo chéo to" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach17.php">Túi đeo chéo to</a></h3>
            <p class="product-price">130.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi đeo chéo to', 147000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi đeo chéo to', 147000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/18.jpg" alt="Túi đeo chéo caro" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach18.php">Túi đeo chéo caro</a></h3>
            <p class="product-price">130.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi đeo chéo caro', 90000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi đeo chéo caro', 90000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/19.jpg" alt="Túi xách mini" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach19.php">Túi xách mini </a></h3>
            <p class="product-price">89.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi xách mini', 89000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi xách mini', 89000)">Mua hàng</button>
        </div>
    </div>
    <div class="product-container">
        <img src="img/20.jpg" alt="Túi xách công sở" class="product-image">
        <div class="product-info">
            <h3><a href="tuixach20.php">Túi xách công sở</a></h3>
            <p class="product-price">130.000 VNĐ</p>
            <button class="btn" onclick="addToCart('Túi xách công sở', 130000)">Thêm vào giỏ hàng</button>
            <button class="btn" onclick="showPaymentModal('Túi xách công sở', 130000)">Mua hàng</button>
        </div>
    </div>
</div>

<!-- Thêm modal thanh toán vào đây, trước thẻ đóng body -->
<div id="paymentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Thông tin thanh toán</h2>
        <form class="payment-form" onsubmit="processPayment(event)">
            <input type="text" placeholder="Họ và tên" required>
            <input type="tel" placeholder="Số điện thoại" required>
            <input type="email" placeholder="Email" required>
            <input type="text" placeholder="Địa chỉ giao hàng" required>
            <select required>
                <option value="">Chọn phưương thức thanh toán</option>
                <option value="cod">Thanh toán khi nhận hàng</option>
                <option value="banking">Chuyển khoản ngân hàng</option>
                <option value="momo">Ví MoMo</option>
            </select>
            <p>Tổng tiền: <span id="totalAmount">0</span> VNĐ</p>
            <button type="submit" class="btn">Xác nhận đặt hàng</button>
        </form>
    </div>
</div>

</body>
</html>

<script>
function filterProducts() {
    const productType = document.getElementById('product-type').value;
    const priceRange = document.getElementById('price-filter').value;
    const products = document.querySelectorAll('.product-container');

    products.forEach(product => {
        const productName = product.querySelector('h3').textContent.toLowerCase();
        const priceText = product.querySelector('.product-price').textContent;
        // Chuyển đổi chuỗi giá thành số, loại bỏ "VNĐ" và dấu chấm phân cách
        const price = parseInt(priceText.replace(/[^\d]/g, ''));

        let showByType = true;
        let showByPrice = true;

        // Lọc theo loại sản phẩm
        if (productType !== 'all') {
            if (productType === 'balo' && !productName.includes('balo')) {
                showByType = false;
            }
            if (productType === 'tuixach' && !productName.includes('túi')) {
                showByType = false;
            }
        }

        // Lọc theo giá
        if (priceRange !== 'all') {
            const [min, max] = priceRange.split('-').map(Number);
            if (priceRange === '0-100000') {
                showByPrice = price < 100000;
            } else if (priceRange === '100000-120000') {
                showByPrice = price >= 100000 && price < 120000;
            } else if (priceRange === '120000-150000') {
                showByPrice = price >= 120000 && price <= 150000;
            } else if (priceRange === '150000+') {
                showByPrice = price > 150000;
            }
        }

        // Hiển thị hoặc ẩn sản phẩm
        if (showByType && showByPrice) {
            product.style.display = '';  // Sử dụng giá trị mặc định của display
        } else {
            product.style.display = 'none';
        }
    });
}

function addToCart(name, price) {
    // Lấy giỏ hàng hiện tại từ localStorage
    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    
    // Thêm sản phẩm mới vào giỏ hàng
    cartItems.push({
        name: name,
        price: price
    });
    
    // Lưu giỏ hàng vào localStorage
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    
    // Thông báo cho người dùng
    alert('Đã thêm ' + name + ' vào giỏ hàng!');
    
    // Log để kiểm tra
    console.log('Đã thêm vào giỏ hàng:', {name, price});
    console.log('Giỏ hàng hiện tại:', cartItems);
}

function showPaymentModal(productName, price) {
    const modal = document.getElementById('paymentModal');
    document.getElementById('totalAmount').textContent = price.toLocaleString();
    modal.style.display = "block";
    
    // Lưu thông tin sản phẩm hiện tại
    modal.setAttribute('data-product', productName);
    modal.setAttribute('data-price', price);
}

// Đóng modal khi click vào nút close
document.querySelector('.close').onclick = function() {
    document.getElementById('paymentModal').style.display = "none";
}

// Đóng modal khi click bên ngoài
window.onclick = function(event) {
    const modal = document.getElementById('paymentModal');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function processPayment(event) {
    event.preventDefault();
    const modal = document.getElementById('paymentModal');
    const productName = modal.getAttribute('data-product');
    const price = modal.getAttribute('data-price');
    
    // Xử lý đơn hàng đây
    alert('Đặt hàng thành công! Cảm ơn bạn đã mua hàng.');
    modal.style.display = "none";
}
</script>

<!-- Thêm Font Awesome để có icon giỏ hàng -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<footer>
    <div class="footer-content">
        <p>© 2024 Your Website. All rights reserved.</p>
        <p>Liên hệ(Contact): 0795474219</p>
    </div>
</footer>
