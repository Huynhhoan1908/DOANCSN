<!DOCTYPE html>
<html>
<head>
  <title>Hoàn Shop</title>
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

body {
    font-family: 'Roboto', sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #f7f7f7;
    color: #333;
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

h1 {
    color: #2C3E50;
    text-align: center;
    margin-top: 40px;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
}

p {
    margin: 20px;
    color: #555;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.8;
}

img[src="img/8.jpg"] {
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
    margin: 20px;
    transition: transform 0.3s ease;
}

img[src="img/8.jpg"]:hover {
    transform: scale(1.05);
}

footer {
    background: linear-gradient(135deg, #eef2f3, #8e9eab);
    color: #333;
    text-align: center;
    padding: 20px 0;
    position: fixed;
    width: 100%;
    bottom: 0;
    box-shadow: 0 -4px 8px rgba(0,0,0,0.1);
}

.footer-content {
    margin: 0 auto;
    max-width: 800px;
}

.footer-content p {
    color: #333;
    margin: 5px 0;
}
</style>
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

<h1>Giới thiệu</h1>
    <img align="right" src="img/8.jpg" alt="" width="400" height="400">
<p>Chào mừng quý khách đến với cửa hàng của chúng tôi!</p>

<p> Chúng tôi tự hào giới thiệu đến bạn một bộ sưu tập đa dạng và phong cách về balo - người bạn đồng hành hoàn hảo cho cuộc sống hiện đại.</p>

<p>Với chất lượng vượt trội và thiết kế tinh tế, balo của chúng tôi không chỉ là một phụ kiện thời trang, mà còn là một công cụ hữu ích để giữ cho bạn luôn tổ chức và tiện lợi trong mọi hoạt động hàng ngày.</p>

<p> Ngăn chính rộng rãi và thông minh của balo sẽ giúp bạn d��� dàng đựng sách, laptop, quần áo và nhiều vật phẩm cá nhân khác một cách gọn gàng và an toàn.</p>

<p>Với các ngăn phụ nhỏ và tiện ích, bạn có thể dễ dàng tìm thấy điện thoại, ví tiền, chìa khóa và những vật phẩm quan trọng khác mà không cần tốn nhiều thời gian.</p>

<p>Balo của chúng tôi được thiết kế với dây đeo điều chỉnh linh hoạt, đảm bảo mang với sự thoải mái tối đa dù bạn đang di chuyển trong thành phố hay khám phá những địa điểm mới.</p>

<p>Đặc biệt, chúng tôi cam kết chất lượng vượt trội và sự bền bỉ của balo.</p>

<p>Với sự kết hợp giữa chất liệu chọn lọc và kỹ thuật sản xuất tiên tiến, balo của chúng tôi đảm bảo sẽ là người bạn đồng hành đáng tin cậy trong mọi cuộc phiêu lưu và thách thức.</p>

<p>Hãy đến và khám phá bộ sưu tập balo của chúng tôi, nơi bạn sẽ tìm thấy sự kết hợp hoàn hảo giữa phong cách, tiện ích và chất lượng.</p>

<p>Hãy để balo của chúng tôi trở thành người bạn đồng hành không thể thiếu trong hành trình của bạn!</p>
<footer>
  <div class="footer-content">
      <p>© 2024 Your Website. All rights reserved.</p>
      <p>Liên hệ(Contact): 0795474219</p>
  </div>
</footer>
</body>