<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoàn Shop</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #2d3436;
            line-height: 1.6;
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

        main {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .product-image {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .product-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .product-image img:hover {
            transform: scale(1.02);
        }

        .product-info {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        h3 {
            color: #2d3436;
            font-size: 1.8em;
            margin: 0 0 20px;
        }

        .price {
            font-size: 2.2em;
            color: #1a2980;
            font-weight: 700;
            margin: 25px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .price::before {
            content: '₫';
            font-size: 0.7em;
        }

        #buyButton {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            padding: 18px 35px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin: 25px 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        #buyButton:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(26, 41, 128, 0.4);
        }

        #purchaseForm {
            margin-top: 35px;
            padding: 25px;
            background: #f8f9fa;
            border-radius: 15px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: #2d3436;
            font-weight: 500;
            font-size: 1.1em;
        }

        .form-group input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1.1em;
            transition: all 0.3s ease;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255,107,107,0.1);
        }

        #submitOrder {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            padding: 18px 35px;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-size: 1.2em;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        #submitOrder:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(26, 41, 128, 0.4);
        }

        .success-message {
            background: linear-gradient(135deg, #00b894, #00cec9);
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            margin-top: 25px;
            font-size: 1.1em;
            font-weight: 500;
            box-shadow: 0 5px 20px rgba(0,184,148,0.2);
            display: none;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .specifications {
            margin-top: 40px;
            background: #f8f9fa;
            padding: 25px;
            border-radius: 12px;
        }

        .specifications h3 {
            color: #2d3436;
            font-size: 1.5em;
            margin-bottom: 20px;
        }

        .specifications p {
            margin: 12px 0;
            padding: 12px 0;
            border-bottom: 1px solid #dfe6e9;
            display: flex;
            justify-content: space-between;
        }

        @media (max-width: 768px) {
            main {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        .payment-methods {
            margin: 25px 0;
        }

        .payment-option {
            background: white;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .payment-option:hover {
            border-color: #ff6b6b;
            background: #fff8f8;
        }

        .payment-option input[type="radio"] {
            margin-right: 15px;
        }

        .payment-option label {
            display: flex;
            align-items: center;
            margin: 0;
            cursor: pointer;
            width: 100%;
        }

        .payment-option img {
            width: 30px;
            height: 30px;
            margin-right: 15px;
            object-fit: contain;
        }

        .banking-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border: 2px solid #e9ecef;
        }

        .bank-details h4 {
            color: #2d3436;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .bank-details p {
            margin: 10px 0;
            color: #636e72;
        }

        .bank-details strong {
            color: #2d3436;
            font-weight: 600;
        }

        .slogan {
            font-size: 1em;
            margin: 5px 0;
            max-width: 300px;
            color: rgba(255,255,255,0.9);
            font-style: italic;
            padding-left: 0;
        }

        .logo h1 {
            font-size: 2em;
            margin: 0;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        .logo img:hover {
            transform: scale(1.05);
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
    </header>

    <main>
        <div class="product-image">
            <img src="img/14.jpg" alt="Túi đeo chéo đen">
        </div>

        <div class="product-info">
            <h3>Túi đeo chéo đen</h3>
            <p class="price">99.000</p>
            <button id="buyButton">MUA NGAY</button>
            
            <!-- Thêm form mua hàng -->
            <form id="purchaseForm" style="display: none;">
                <div class="form-group">
                    <label for="name">Họ và tên:</label>
                    <input type="text" id="name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" required>
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" id="address" required>
                </div>
                
                <!-- Thêm phương thức thanh toán -->
                <div class="form-group payment-methods">
                    <label>Phương thức thanh toán:</label>
                    <div class="payment-option">
                        <input type="radio" id="cod" name="payment" value="cod" required>
                        <label for="cod">
                            Thanh toán khi nhận hàng (COD)
                        </label>
                    </div>
                    <div class="payment-option">
                        <input type="radio" id="banking" name="payment" value="banking">
                        <label for="banking">
                            Chuyển khoản ngân hàng
                        </label>
                    </div>
                    <div class="payment-option">
                        <input type="radio" id="momo" name="payment" value="momo">
                        <label for="momo">
                            Ví MoMo
                        </label>
                    </div>
                </div>

                <!-- Thêm thông tin tài khoản ngân hàng (ẩn mặc định) -->
                <div id="bankingInfo" class="banking-info" style="display: none;">
                    <div class="bank-details">
                        <h4>Thông tin chuyển khoản:</h4>
                        <p>Ngân hàng: <strong>Vietcombank</strong></p>
                        <p>Số tài khoản: <strong>1234567890</strong></p>
                        <p>Chủ tài khoản: <strong>NGUYEN VAN A</strong></p>
                        <p>Nội dung CK: <strong>BALO + Số điện thoại</strong></p>
                    </div>
                </div>

                <button type="submit" id="submitOrder">XÁC NHẬN ĐẶT HÀNG</button>
            </form>
            <div class="success-message">
                Đặt hàng thành công!
            </div>
            <div class="specifications">
                <h3>Thông số kỹ thuật</h3>
                <p><span>Mô tả:</span> <span>Túi đeo chéo nam nữ</span></p>
                <p><span>Đặc điểm sản phẩm:</span> <span>Thiết kế nhỏ gọn, thời trang</span></p>
                <p><span>Chất liệu:</span> <span>Vải Oxford cao cấp</span></p>
                <p><span>Ngăn đựng:</span> <span>Nhiều ngăn tiện dụng</span></p>
                <p><span>Đường may:</span> <span>Tỉ mỉ, chắc chắn</span></p>
                <p><span>Màu sắc:</span> <span>Đen</span></p>
                <p><span>Kích thước:</span> <span>25cm x 21cm x 6cm</span></p>
                <p><span>Phong cách:</span> <span>Thời trang</span></p>
                <p><span>Loại băng:</span> <span>Có thể điều chỉnh</span></p>
                <p><span>Chế độ đóng cửa:</span> <span>Dây kéo</span></p>
                <p><span>Cam Kết:</span> <span>Sản phẩm giống hình hơn 80%</span></p>
                <p><span>Đổi trả:</span> <span>Trong vòng 3 ngày</span></p>
            </div>
        </div>
    </main>

    <!-- Thêm JavaScript để xử lý form -->
    <script>
        document.getElementById('buyButton').addEventListener('click', function() {
            document.getElementById('purchaseForm').style.display = 'block';
            this.style.display = 'none';
        });

        document.getElementById('purchaseForm').addEventListener('submit', function(e) {
            e.preventDefault();
            this.style.display = 'none';
            document.querySelector('.success-message').style.display = 'block';
        });

        // Thêm xử lý hiển thị thông tin ngân hàng
        document.querySelectorAll('input[name="payment"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const bankingInfo = document.getElementById('bankingInfo');
                if (this.value === 'banking') {
                    bankingInfo.style.display = 'block';
                } else {
                    bankingInfo.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>