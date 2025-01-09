<?php
session_start();
// Debug session
error_log("Session data: " . print_r($_SESSION, true));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Giỏ hàng</title>
    <meta charset="UTF-8">
    <style>
        .cart {
            max-width: 800px;
            margin: 30px auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            background-color: #fff;
        }

        .cart h2 {
            color: #2c3e50;
            text-align: center;
            font-size: 28px;
            margin-bottom: 25px;
        }

        .cart-item {
            padding: 15px;
            border-radius: 8px;
            background-color: #f8f9fa;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
        }

        .cart-item:hover {
            transform: translateX(5px);
            background-color: #e9ecef;
        }

        .cart-total {
            margin-top: 25px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            font-weight: bold;
            text-align: right;
            font-size: 18px;
            color: #2c3e50;
        }

        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        #checkout-form {
            max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        #checkout-form h2 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 25px;
            font-size: 24px;
        }

        #checkout-form form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        #checkout-form .form-group {
            position: relative;
        }

        #checkout-form label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #34495e;
            font-size: 14px;
        }

        #checkout-form input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        #checkout-form input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }

        #checkout-form button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 14px 25px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        #checkout-form button[type="submit"]:hover {
            background-color: #0056b3;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,123,255,0.2);
        }

        #checkout-info {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #e9ecef;
            border-radius: 8px;
        }

        #checkout-info p {
            margin: 10px 0;
            padding: 5px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .btn-remove {
            background-color: #dc3545;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-remove:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

        /* Animation cho form thanh toán */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        #checkout-form {
            animation: slideIn 0.3s ease-out;
        }

        .payment-methods {
            margin: 25px 0;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 15px 20px;
            margin: 12px 0;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .payment-option:hover {
            border-color: #007bff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .payment-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .payment-option label {
            display: flex;
            align-items: center;
            margin: 0;
            cursor: pointer;
            width: 100%;
            font-weight: 500;
            color: #2c3e50;
        }

        .payment-option img {
            width: 32px;
            height: 32px;
            margin-right: 15px;
            object-fit: contain;
        }

        .payment-option:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background-color: #007bff;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .payment-option input[type="radio"]:checked + label {
            font-weight: 600;
            color: #007bff;
        }

        .payment-option input[type="radio"]:checked ~ .payment-option:before {
            opacity: 1;
        }

        .payment-option input[type="radio"]:checked + label .payment-check {
            border-color: #007bff;
            background-color: #007bff;
        }

        .payment-option input[type="radio"]:checked + label .payment-check:after {
            opacity: 1;
        }

        .payment-check {
            width: 22px;
            height: 22px;
            border: 2px solid #cbd5e0;
            border-radius: 50%;
            margin-right: 15px;
            position: relative;
            transition: all 0.3s ease;
        }

        .payment-check:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #ffffff;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .payment-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin: 15px 0;
            border: 1px solid #e9ecef;
            animation: slideDown 0.3s ease-out;
        }

        .payment-info p {
            margin: 8px 0;
            color: #2c3e50;
            font-size: 15px;
            line-height: 1.6;
        }

        .payment-info p:first-child {
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e9ecef;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Cập nhật style cho radio button khi được chọn */
        .payment-option input[type="radio"]:checked + label {
            font-weight: 600;
        }

        .payment-option input[type="radio"]:checked + label .payment-check {
            border-color: #007bff;
        }

        .payment-option input[type="radio"]:checked + label .payment-check:after {
            background-color: #007bff;
            opacity: 1;
        }

        .payment-option.selected {
            border-color: #007bff;
            background-color: #f8f9fa;
        }

        /* Thêm style cho header */
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

        header h3 {
            color: #6c757d;
            font-size: 1.2em;
            font-style: italic;
            margin: 20px auto;
            max-width: 800px;
            line-height: 1.6;
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
            <h3 class="slogan">Hãy để balo và túi xách của chúng tôi<br>trở thành người bạn đồng hành không thể thiếu trong hành trình của bạn!</h3>
        </div>
        
        <nav class="nav-menu">
            <a href="trangchu.php">Trang chủ</a>
            <a href="Sản phẩm.php">Sản phẩm</a>
            <a href="lienhe.php">Liên hệ</a>
            <a href="dangnhap.php">Đăng nhập</a>
            <a href="dangky.php">Đăng ký</a>
        </nav>
    </div>
</header>
    <div class="cart">
        <h2>Giỏ hàng</h2>
        <div id="cartItems">
            <!-- Sản phẩm sẽ được thêm vào đây -->
        </div>
        <div class="cart-total">
            Tổng: <span id="cartTotal">0 VNĐ</span>
        </div>
        <button class="btn" onclick="showCheckoutForm()">Thanh toán</button>
    </div>

    <!-- Thêm form thanh toán -->
    <div id="checkout-form" style="display: none;">
        <h2>Thông tin thanh toán</h2>
        <form onsubmit="processCheckout(event)">
            <div class="form-group">
                <label for="fullName">Họ và tên:</label>
                <input type="text" id="fullName" required placeholder="Nhập họ và tên của bạn">
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="tel" id="phone" required placeholder="Nhập số điện thoại">
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" required placeholder="Nhập địa chỉ giao hàng">
            </div>
            <div class="form-group payment-methods">
                <label>Phương thức thanh toán:</label>
                <div class="payment-option">
                    <input type="radio" id="cod" name="payment" value="cod" required>
                    <label for="cod">
                        <span class="payment-check"></span>
                        <span>Thanh toán khi nhận hàng</span>
                    </label>
                </div>
                <div class="payment-option">
                    <input type="radio" id="banking" name="payment" value="banking">
                    <label for="banking">
                        <span class="payment-check"></span>
                        <span>Chuyển khoản ngân hàng</span>
                    </label>
                </div>
                <div class="payment-option">
                    <input type="radio" id="momo" name="payment" value="momo">
                    <label for="momo">
                        <span class="payment-check"></span>
                        <span>Ví điện tử Momo</span>
                    </label>
                </div>
            </div>
            <div id="banking-info" class="payment-info" style="display: none;">
                <p>Thông tin chuyển khoản:</p>
                <p>Ngân hàng: BIDV</p>
                <p>Số tài khoản: 123456789</p>
                <p>Chủ tài khoản: NGUYEN VAN A</p>
            </div>
            <button type="submit" class="btn">Xác nhận đặt hàng</button>
        </form>
    </div>

    <script>
    // Hàm thêm vào giỏ hàng (thường nằm ở trang sản phẩm)
    function addToCart(productId, productName, productPrice) {
        // Debug: kiểm tra dữ liệu sản phẩm
        console.log('Thêm sản phẩm:', {
            id: productId,
            name: productName,
            price: productPrice
        });

        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        cartItems.push({
            id: productId,
            name: productName,
            price: productPrice
        });
        
        // Debug: kiểm tra giỏ hàng sau khi thêm
        console.log('Giỏ hàng sau khi thêm:', cartItems);
        
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        alert('Đã thêm ' + productName + ' vào giỏ hàng!');
    }

    // Hàm cập nhật hiển thị giỏ hàng
    function updateCart() {
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        const cartItemsElement = document.getElementById('cartItems');
        const cartTotalElement = document.getElementById('cartTotal');
        
        cartItemsElement.innerHTML = '';
        let total = 0;
        
        cartItems.forEach((item, index) => {
            const itemElement = document.createElement('div');
            itemElement.classList.add('cart-item');
            itemElement.innerHTML = `
                ${item.name} - ${formatPrice(item.price)} VNĐ
                <button class="btn-remove" onclick="removeFromCart(${index})">Xóa</button>
            `;
            cartItemsElement.appendChild(itemElement);
            total += parseInt(item.price);
        });
        
        cartTotalElement.textContent = formatPrice(total) + ' VNĐ';
    }

    // Hàm xóa sản phẩm khỏi giỏ hàng
    function removeFromCart(index) {
        let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        cartItems.splice(index, 1);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateCart();
    }

    // Hàm định dạng giá tiền
    function formatPrice(price) {
        return parseInt(price).toLocaleString('vi-VN');
    }

    // Cập nhật giỏ hàng khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Giỏ hàng:', localStorage.getItem('cartItems'));
        updateCart();
    });

    // Thêm hàm hiển thị form thanh toán
    function showCheckoutForm() {
        <?php 
        error_log("User ID in session: " . (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Not set'));
        ?>
        
        // Debug session status
        console.log('Session status:', <?php echo json_encode($_SESSION); ?>);
        
        <?php if (!isset($_SESSION['user_id'])): ?>
            alert('Vui lòng đăng nhập để đặt hàng');
            window.location.href = 'dangnhap.php';
            return;
        <?php endif; ?>

        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        if (cartItems.length === 0) {
            alert('Giỏ hàng của bạn đang trống!');
            return;
        }
        document.getElementById('checkout-form').style.display = 'block';
    }

    // Thêm xử lý hiển thị thông tin thanh toán
    document.querySelectorAll('input[name="payment"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const bankingInfo = document.getElementById('banking-info');
            if (this.value === 'banking') {
                bankingInfo.style.display = 'block';
            } else {
                bankingInfo.style.display = 'none';
            }
        });
    });

    // Cập nhật hàm xử lý thanh toán
    function processCheckout(event) {
        event.preventDefault();
        
        const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
        // Debug: kiểm tra dữ liệu giỏ hàng
        console.log('Giỏ hàng:', cartItems);
        
        const fullName = document.getElementById('fullName').value;
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;
        const paymentMethod = document.querySelector('input[name="payment"]:checked').value;

        // Tính tổng tiền
        const total = cartItems.reduce((sum, item) => sum + parseInt(item.price), 0);
        
        // Debug: kiểm tra dữ liệu gửi đi
        const orderData = {
            customerName: fullName,
            phone: phone,
            address: address,
            paymentMethod: paymentMethod,
            items: cartItems,
            total: total
        };
        console.log('Dữ liệu đơn hàng:', orderData);

        fetch('process_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Phản hồi từ server:', data);
            if (data.success) {
                alert('Đặt hàng thành công!');
                localStorage.removeItem('cartItems');
                updateCart();
                document.getElementById('checkout-form').style.display = 'none';
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Có lỗi xảy ra khi xử lý đơn hàng');
        });
    }
    </script>
</body>
</html>

```</rewritten_file>