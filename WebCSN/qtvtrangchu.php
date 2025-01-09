<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: dangnhapAdmin.php");
    exit();
}

// Thêm vào đầu file
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Trong phần xử lý phản hồi, thêm log
error_log("POST data: " . print_r($_POST, true));
// Cấu hình database và upload
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ban_hang'); // Thay đổi 'chua_khmer' thành tên database của bạn
define('UPLOAD_DIR', 'uploads/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// Kết nối database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Lấy danh sách đơn hàng
$danhSachDonHang = [];
$sql = "SELECT dh.*, nd.ho_ten as ten_nguoi_dung 
        FROM don_hang dh 
        LEFT JOIN nguoi_dung nd ON dh.nguoi_dung_id = nd.id 
        ORDER BY dh.ngay_dat DESC";

$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $danhSachDonHang[] = $row;
    }
    $result->free();
}

// Lấy danh sách người dùng cho dropdown
$danhSachNguoiDung = [];
$sql = "SELECT id, ho_ten FROM nguoi_dung"; // Remove the WHERE clause temporarily

// Alternatively, if you want to check for active users only
// $sql = "SELECT id, ho_ten FROM nguoi_dung WHERE vai_tro = 0";

$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $danhSachNguoiDung[] = $row;
    }
    $result->free();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Trị - Hoàn Shop</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
/* Reset và biến CSS */
:root {
    --primary-color: #6366f1;  /* Indigo */
    --secondary-color: #f8fafc;
    --accent-color: #8b5cf6;   /* Purple */
    --danger-color: #ef4444;   /* Red */
    --success-color: #22c55e;  /* Green */
    --warning-color: #f59e0b;  /* Amber */
    --text-color: #1e293b;     /* Slate */
    --border-color: #e2e8f0;
    --sidebar-width: 280px;
    --header-height: 70px;
    --border-radius: 12px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    --box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
}

/* Cập nhật Modal */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.5);
    z-index: 1000;
    overflow-y: auto;
    padding: 20px;
}

.modal-content {
    position: relative;
    background: #fff;
    width: 95%;
    max-width: 900px;
    margin: 20px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: var(--box-shadow);
}

/* Style cho modal title */
#modalTitle {
    color: #000; /* Thay đổi từ var(--primary-color) thành màu đen */
    font-size: 28px;
    font-weight: 600;
    text-align: center;
    margin: 0 auto 30px;
    padding: 15px 30px;
    border: 2px solid #000;
    border-radius: var(--border-radius);
    background: #fff;
    min-width: 300px;
    display: block;
    width: fit-content;
    margin-left: auto;
    margin-right: auto;
}

/* Container cho modal title */
.modal-title-container {
    width: 100%;
    text-align: center;
    margin-bottom: 30px;
}

/* Style cho labels */
.form-group label {
    display: block;
    margin-bottom: 6px; /* Giảm margin dưới */
    font-weight: 500;
    color: var(--text-color);
    font-size: 16px; /* Giảm kích thước font */
}

/* Style cho dấu sao required */
.form-group label .required {
    color: var(--danger-color);
    margin-left: 3px;
    font-size: 11px; /* Giảm kích thước dấu sao */
}

/* Điều chỉnh khong cách giữa các form groups */
.form-group {
    margin-bottom: 15px; /* Giảm margin bottom */
}

/* Điều chỉnh kích thước input fields */
.form-group input {
    width: 97%;
    min-width: 300px; /* Đảm bảo độ rộng tối thiểu */
    height: 38px; /* Tăng chiều cao */
    padding: 8px 15px;
    font-size: 14px;
}

/* Điều chỉnh textarea */
.form-group textarea {
    width: 97%;
    min-height: 50px; /* Tăng chiều cao tối thiểu */
    padding: 12px 15px;
    font-size: 14px;
    line-height: 1.6;
}

/* Điều chỉnh container chứa input */
.form-group .input-container {
    flex: 1;
    min-width: 10px; /* Đảm bảo độ rộng tối thiểu */
}

/* Điều chỉnh style khi focus */
.form-group input:focus,
.form-group textarea:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    outline: none;
}

/* Điều chỉnh style cho placeholder */
.form-group input::placeholder,
.form-group textarea::placeholder {
    color: #999;
    font-size: 14px;
}
/* Hover và Focus states cho textarea */
.data-table textarea:hover {
    border-color: var(--primary-color);
}
/* Style cho textarea trong bảng */
.data-table textarea {
    width: 97%;
    min-height: 100px;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: var(--border-radius);
    font-size: 14px;
    line-height: 1.6;
    resize: vertical;
    background-color: #fff;
    transition: var(--transition);
}

/* Cập nht bảng dữ liệu */
.data-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 10px;
}

.data-table thead th {
    background: var(--primary-color);
    color: #fff;
    padding: 18px;
    font-weight: 700;
    text-align: left;
    font-size: 14px;
    border-top: none;
    position: sticky;
    top: 0;
    z-index: 10;
    text-transform: none; /* Remove automatic capitalization */
    letter-spacing: 0.5px;
}
.data-table td {
    padding: 15px;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
}

.data-table thead th:first-child {
    border-top-left-radius: var(--border-radius);
}

.data-table thead th:last-child {
    border-top-right-radius: var(--border-radius);
}

.data-table tbody tr {
    transition: var(--transition);
    font-size: 18px;
}

.data-table tbody tr:hover {
    background-color: #f8f9fa;
}

/* Style cho text content trong cột nội dung */
.data-table td:nth-child(6) .content-text {
    white-space: pre-line;
    line-height: 1.6;
    max-height: 97px;
    overflow-y: auto;
}
/* Đặt buttons trong table cell */
.data-table td:last-child {
    display: flex;
    gap: 5px;
    justify-content: flex-start;
    align-items: center;
    padding: 8px 15px;
    white-space: normal;
    max-width: none;
}

/* Scrollbar tùy chỉnh cho textarea và content */
.data-table textarea::-webkit-scrollbar,
.data-table td:nth-child(6) .content-text::-webkit-scrollbar {
    width: 8px;
}

.data-table textarea::-webkit-scrollbar-track,
.data-table td:nth-child(6) .content-text::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.data-table textarea::-webkit-scrollbar-thumb,
.data-table td:nth-child(6) .content-text::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}

.data-table textarea::-webkit-scrollbar-thumb:hover,
.data-table td:nth-child(6) .content-text::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Đ���nh dạng hình ảnh */
.temple-image {
    max-width: 100px;
    height: auto;
    border-radius: 4px;
    cursor: pointer;
    transition: transform 0.2s;
}

.temple-image:hover {
    transform: scale(1.1);
}

/* Upload ảnh */
.image-upload-container {
    background: #f8f9fa;
    padding: 20px;
    border-radius: var(--border-radius);
    border: 2px solid #000; /* Thêm viền đen */
    text-align: center;
    margin-top: 10px;
}

.image-preview {
    width: 200px;
    height: 150px;
    margin: 15px auto;
    border-radius: var(--border-radius);
    overflow: hidden;
    background: #fff;
    box-shadow: var(--box-shadow);
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Buttons trong form actions */
.form-actions {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
}

.btn {
    padding: 5px 10px; /* Tăng padding cho nút */
    border-radius: var(--border-radius);
    font-weight: 400;
    font-size: 14px;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: var(--transition);
    border: none;
    border: 2px solid #000; /* Viền đen */
}

/* Icon trong button */
.btn i {
    font-size: 16px;
}
/* Nút Lưu trong form */
.btn-primary {
    background: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background: #357abd;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
}

/* Nút Thêm chùa mới */
.btn-add {
    background: white !important;
    color: black !important;
    border: 2px solid #000;
}

.btn-add:hover {
    background: #f0f0f0 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

/* Nút Xóa */
.btn-danger {
    background: var(--danger-color);
    color: #ffffff; /* Màu chữ trắng */
    font-weight: bold; /* Làm đậm chữ */
}

.btn-danger:hover {
    background: #c0392b;
    color: #ffffff; /* Gi màu chữ trắng khi hover */
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.2);
}

/* Nút Hủy */
.btn-secondary {
    background: black; /* Màu xám nhạt */
    color: white;
}

.btn-secondary:hover {
    background: #7f8c8d; /* Màu đậm hơn khi hover */
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(149, 165, 166, 0.2);
}
/* Nút Sửa */
.btn-warning {
    background: var(--warning-color);
    color: #000000; /* Màu chữ đen */
    font-weight: bold; /* Làm đậm chữ */
}

.btn-warning:hover {
    background: #f39c12;
    color: #000000; /* Giữ màu chữ đen khi hover */
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(241, 196, 15, 0.3);
}

/* Hiệu ứng khi button bị disable */
.btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none !important;
}

/* Style cho tất cả các buttons trong bảng */
.data-table .btn {
    padding: 6px 6px !important; /* Giảm padding ngang */
    font-size: 12px !important;
    min-width: 35px; /* Giảm độ rộng tối thiểu */
    height: 28px;
    line-height: 1;
    white-space: nowrap; /* Ngăn text xuống dòng */
}

.data-table .btn i {
    font-size: 10px !important;
    margin-right: 2px; /* Giảm khoảng cách giữa icon và text */
}

/* Điều chỉnh khoảng cách giữa các nút */
.data-table td:last-child {
    display: flex;
    gap: 2px; /* Giảm khoảng cách giữa các nút */
    align-items: center;
    padding: 4px 6px; /* Giảm padding của cell */
    white-space: nowrap;
}

/* Điều chỉnh các nút cụ thể */
.data-table .btn-warning,
.data-table .btn-danger,
.data-table .btn-primary {
    min-width: 25px; /* Giảm độ rộng tối thiểu cho các nút cụ thể */
}

/* Thêm style cho các nút có icon + text */
.data-table .btn-with-icon {
    padding-left: 4px !important;
    padding-right: 4px !important;
}

/* Container cho input file */
.file-input-container {
    border: 2px solid #000;
    padding: 16px;
    border-radius: var(--border-radius);
    background: white;
    width: 97%;
    margin: 10px 0;
    display: inline-block;
}

/* Style cho input file */
input[type="file"] {
    width: 100%;
    cursor: pointer;
    padding: 8px 0;
}

/* Style cho button "Choose File" */
::-webkit-file-upload-button {
    border: 2px solid #000;
    padding: 8px 16px;
    border-radius: 4px;
    background: #fff;
    cursor: pointer;
    font-weight: 500;
    margin-right: 10px;
    transition: all 0.3s ease;
}

::-webkit-file-upload-button:hover {
    background: #f0f0f0;
}

/* Style cho Firefox */
::file-selector-button {
    border: 2px solid #000;
    padding: 8px 16px;
    border-radius: 4px;
    background: #fff;
    cursor: pointer;
    font-weight: 500;
    margin-right: 10px;
    transition: all 0.3s ease;
}

::file-selector-button:hover {
    background: #f0f0f0;
}

/* Ẩn thanh progress mặc định */
input[type="file"]::-webkit-progress-bar {
    display: none;
}

input[type="file"]::-webkit-progress-value {
    display: none;
}

input[type="file"]::-webkit-progress {
    display: none;
}

/* Responsive cho buttons */
@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
        margin-bottom: 10px;
    }
    
    .data-table td:last-child {
        flex-direction: column;
        gap: 8px;
    }
    
    .data-table .btn {
        width: 100%;
        margin: 0;
    }
}
/* Search Container */
.search-container {
    position: relative;
    display: flex;
    align-items: center;
    margin: 10px 0px;
}

.search-input {
    padding: 8px 12px 8px 35px;
    border: 2px solid #2c3e50; /* Thêm viền đen */
    border-radius: 4px;
    font-size: 14px;
    width: 140px;
    transition: all 0.3s ease;
    background-color: white;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    width: 300px;
}

.search-icon {
    position: absolute;
    left: 10px;
    color: #2c3e50; /* Đổi màu icon thành đen */
    font-size: 14px;
}

/* Thêm hover effect */
.search-input:hover {
    border-color: var(--primary-color);
}
/* Style cho placeholder */
.search-input::placeholder {
    color: #000000; /* Thay đổi từ #999 thnh #000000 */
    font-size: 14px;
}

/* Sidebar Styles */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    width: 280px;
    height: 100vh;
    background: linear-gradient(180deg, #2c3e50 0%, #3498db 100%);
    color: white;
    padding: 0;
    box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    transition: all 0.3s ease;
}

.sidebar-header {
    padding: 30px 20px;
    text-align: center;
    background: rgba(0, 0, 0, 0.2);
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

/* Cập nhật màu cho logo/avatar */
.admin-avatar {
    width: 80px;
    height: 80px;
    margin: 0 auto 15px;
    background: #FFB800; /* Màu vàng của logo */
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 3px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.admin-avatar i {
    font-size: 35px;
    color: #000; /* Màu đen cho icon */
}

.admin-avatar:hover {
    transform: scale(1.05);
    box-shadow: 0 0 20px rgba(255, 184, 0, 0.5);
}

/* Cập nhật style cho nút đăng xuất */
.logout-btn {
    color: #c0392b; /* Màu vàng thay vì màu đỏ */
    margin-top: 20px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    font-weight: bold;
}

.logout-btn i {
    color: #fff; /* Icon cũng có màu vàng */
}

.logout-btn:hover i {
    color: #fff; /* Icon chuyển sang màu trắng khi hover */
}

.sidebar-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.admin-title {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.7);
    margin: 5px 0 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.sidebar-menu {
    list-style: none;
    padding: 20px 0;
    margin: 0;
}

/* Sidebar menu styles */
.menu-item {
    margin: 8px 0;
}

.menu-item a {
    display: flex;
    align-items: center;
    padding: 12px 25px;
    color: white;
    text-decoration: none;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
}

.menu-item i {
    margin-right: 10px;
    width: 20px;
    text-align: center;
}

/* Style riêng cho menu link (trang chủ) */
.menu-link {
    transition: all 0.3s ease;
}

.menu-link:hover {
    background: #7f8c8d;
    color: #fff;
    transform: translateX(5px);
}

.menu-link.active {
    background: rgba(255, 255, 255, 0.2);
    border-left: 4px solid #fff;
}

/* Style riêng cho logout link (không có hover) */
.logout-link {
    cursor: pointer;
}
/* Điều chỉnh main content để không bị đè bởi sidebar */
.main-content {
    margin-left: 280px;
    padding: 20px;
    transition: all 0.3s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .sidebar {
        width: 0;
        overflow: hidden;
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .sidebar.active {
        width: 280px;
    }
}

.xoa-nguoi-dung {
    padding: 8px 12px !important; /* Giảm padding */
    font-size: 14px !important; /* Giảm kích thước chữ */
}

.xoa-nguoi-dung i {
    font-size: 12px !important; /* Giảm kích thước icon */
}
/* Style cho buttons trong bảng sự kiện */
.sua-su-kien, .xoa-su-kien {
    padding: 8px 12px !important; /* Giảm padding */
    font-size: 14px !important; /* Giảm kích thước ch */
}

.sua-su-kien i, .xoa-su-kien i {
    font-size: 12px !important; /* Giảm kích thước icon */
}
/* Style cho tất cả các buttons trong bảng */
.data-table .btn {
    padding: 8px 12px !important; /* Giảm padding */
    font-size: 14px !important; /* Giảm kích thước chữ */
}

.data-table .btn i {
    font-size: 12px !important; /* Giảm kích thước icon */
}


/* Specific styles for each button type if needed */
.data-table .btn-warning,
.data-table .btn-danger {
    min-width: 80px; /* Đảm bảo độ rộng tối thiểu */
}

/* Điều chỉnh khoảng cách giữa các nút */
.data-table td:last-child {
    display: flex;
    gap: 5px;
    align-items: center;
}
/* Style cho phản hồi bình luận */
.reply-container {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
}

.admin-reply-text {
    flex: 1;
    height: 36px; /* Giảm chiều cao để vừa với nút */
    padding: 8px;
    border: 2px solid #000;
    border-radius: var(--border-radius);
    resize: none;
    font-size: 14px;
}

.btn-save-reply {
    padding: 8px 12px;
    background: var(--primary-color);
    color: white;
    border: 2px solid #000;
    border-radius: var(--border-radius);
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    white-space: nowrap;
    height: 36px; /* Đảm bảo chiều cao bằng với textarea */
}

.btn-save-reply:hover {
    background: #357abd;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(74, 144, 226, 0.2);
}

.btn-save-reply i {
    font-size: 12px;
}

/* Style cho khung nhập phản hồi */
.admin-reply-text {
    width: 100%;
    min-width: 100px;
    max-width: 100px;
    height: 60px;
    padding: 8px;
    border: 2px solid #000;
    border-radius: var(--border-radius);
    font-size: 10px;              /* Giảm cỡ chữ xuống 10px cho phản hồi */
    line-height: 1.3;             /* Khoảng cách dòng phù hợp */
    background-color: #fff;
    resize: none;
}

/* Responsive cho màn hình lớn */
@media (max-width: 1200px) {
    .content-text,
    .admin-reply-text {
        min-width: 150px;
        max-width: 250px;
        height: 50px;
    }
}

/* Responsive cho màn hình nhỏ */
@media (max-width: 768px) {
    .content-text,
    .admin-reply-text {
        min-width: 120px;
        max-width: 200px;
        height: 45px;
    }
}

/* Style cho form phản hồi */
.comment-display {
    width: 97%;
    min-height: 50px;
    padding: 12px 15px;
    border: 2px solid #000;
    border-radius: var(--border-radius);
    background-color: #f8f9fa;
    font-size: 14px;
    line-height: 1.6;
    white-space: pre-wrap;
    word-wrap: break-word;
    margin-bottom: 15px;
}

#reply_content {
    width: 97%;
    min-height: 100px;
    padding: 12px 15px;
    border: 2px solid #000;
    border-radius: var(--border-radius);
    font-size: 14px;
    line-height: 1.6;
    resize: vertical;
    background-color: #fff;
    transition: var(--transition);
}

#reply_content:hover {
    border-color: var(--primary-color);
}

#reply_content:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    outline: none;
}




</style>   
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <div class="admin-avatar">
            <i class="fas fa-user-shield"></i>
        </div>
        <h2>Quản Trị Viên</h2>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-item">
            <a href="index.php">
                <i class="fas fa-home"></i>
                <span>Trang chủ</span>
            </a>
        </li>
        <li class="menu-item">
            <a href="?action=logout">
                <i class="fas fa-sign-out-alt"></i>
                <span>Đăng xuất</span>
            </a>
        </li>
    </ul>
</div>

<div class="main-content">
<!-- HTML structure -->
<div class="table-container">
    <div class="section-header">
        <h2>Quản lý đơn hàng</h2>
        <button class="btn btn-primary btn-add">
            <i class="fas fa-plus"></i> Thêm đơn hàng mới
        </button>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Người đặt</th>
                <th>Ngày đặt</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ghi chú</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($danhSachDonHang as $donHang): ?>
            <tr>
                <td><?php echo htmlspecialchars($donHang['id']); ?></td>
                <td data-user-id="<?php echo $donHang['nguoi_dung_id']; ?>">
                    <?php echo htmlspecialchars($donHang['ten_nguoi_dung']); ?>
                </td>
                <td data-raw-date="<?php echo date('Y-m-d\TH:i', strtotime($donHang['ngay_dat'])); ?>">
                    <?php echo date('d/m/Y H:i', strtotime($donHang['ngay_dat'])); ?>
                </td>
                <td data-raw-amount="<?php echo $donHang['tong_tien']; ?>">
                    <?php echo number_format($donHang['tong_tien'], 0, ',', '.'); ?>đ
                </td>
                <td>
                    <select class="trang-thai-don-hang" data-id="<?php echo $donHang['id']; ?>">
                        <option value="0" <?php echo $donHang['trang_thai'] == 0 ? 'selected' : ''; ?>>Chờ xử lý</option>
                        <option value="1" <?php echo $donHang['trang_thai'] == 1 ? 'selected' : ''; ?>>Đã xác nhận</option>
                        <option value="2" <?php echo $donHang['trang_thai'] == 2 ? 'selected' : ''; ?>>Đang giao</option>
                        <option value="3" <?php echo $donHang['trang_thai'] == 3 ? 'selected' : ''; ?>>Đã giao</option>
                        <option value="4" <?php echo $donHang['trang_thai'] == 4 ? 'selected' : ''; ?>>Đã hủy</option>
                    </select>
                </td>
                <td><?php echo nl2br(htmlspecialchars($donHang['ghi_chu'])); ?></td>
                <td>
                    <button class="btn btn-warning sua-don-hang" data-id="<?php echo $donHang['id']; ?>">
                        <i class="fas fa-edit"></i> Sửa
                    </button>
                    <button class="btn btn-danger xoa-don-hang" data-id="<?php echo $donHang['id']; ?>">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="modalDonHang" class="modal">
    <div class="modal-content">
        <div class="modal-title-container">
            <h2 id="modalTitle">Thêm đơn hàng mới</h2>
        </div>
        
        <div class="form-container">
            <form id="formDonHang">
                <input type="hidden" id="don_hang_id" name="don_hang_id">
                
                <div class="form-group">
                    <label>Người đặt:<span class="required">*</span></label>
                    <select id="nguoi_dung_id" name="nguoi_dung_id" required>
                        <option value="">Chọn người đặt</option>
                        <?php foreach($danhSachNguoiDung as $nguoiDung): ?>
                            <option value="<?php echo $nguoiDung['id']; ?>">
                                <?php echo htmlspecialchars($nguoiDung['ho_ten']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ngày đặt:<span class="required">*</span></label>
                    <input type="datetime-local" id="ngay_dat" name="ngay_dat" required>
                </div>

                <div class="form-group">
                    <label>Tổng tiền:<span class="required">*</span></label>
                    <input type="number" id="tong_tien" name="tong_tien" required min="0">
                </div>

                <div class="form-group">
                    <label>Trạng thái:</label>
                    <select id="trang_thai" name="trang_thai">
                        <option value="0">Chờ xử lý</option>
                        <option value="1">Đã xác nhận</option>
                        <option value="2">Đang giao</option>
                        <option value="3">Đã giao</option>
                        <option value="4">Đã hủy</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Ghi chú:</label>
                    <textarea id="ghi_chu" name="ghi_chu"></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="btnSave">
                        <i class="fas fa-save"></i> Lưu
                    </button>
                    <button type="button" class="btn btn-secondary close-modal">
                        <i class="fas fa-times"></i> Hủy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="table-container">
    <!-- Bảng quản lý người dùng -->
<div class="table-container">
    <div class="section-header">
        <h2>Quản lý người dùng</h2>
        <div class="search-container">
            <input type="text" id="timKiemNguoiDung" class="search-input" placeholder="Tìm kiếm người dùng">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Tên đăng nhập</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Vai trò</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($danhSachNguoiDung as $nguoiDung): ?>
            <tr>
                <td><?php echo htmlspecialchars($nguoiDung['ten_dang_nhap']); ?></td>
                <td><?php echo htmlspecialchars($nguoiDung['ho_ten']); ?></td>
                <td><?php echo htmlspecialchars($nguoiDung['email']); ?></td>
                <td><?php echo $nguoiDung['vai_tro'] == 1 ? 'Admin' : 'Người dùng'; ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($nguoiDung['ngay_tao'])); ?></td>
                <td>
                    <?php if($nguoiDung['vai_tro'] != 1): ?>
                        <button class="btn btn-danger xoa-nguoi-dung" data-id="<?php echo $nguoiDung['id']; ?>">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Form quản lý sự kiện -->
<div class="table-container">
    <div class="section-header">
        <h2>Quản lý sự kiện</h2>
        <button class="btn btn-primary btn-add">
            <i class="fas fa-plus"></i> Thêm sự kiện
        </button>
    </div>
<!-- Modal form sự kiện -->
<div id="eventFormContainer" class="modal">
    <div class="modal-content">
        <div class="modal-title-container">
            <h2 id="eventModalTitle">Thêm sự kiện mới</h2>
        </div>
        
        <div class="form-container">
            <form id="eventForm">
                <input type="hidden" id="event_id" name="event_id">
                
                <div class="form-group">
                    <label for="ten_su_kien">Tên sự kiện<span class="required">*</span></label>
                    <input type="text" id="ten_su_kien" name="ten_su_kien" required>
                </div>
                
                <div class="form-group">
                    <label for="y_nghia">Ý nghĩa<span class="required">*</span></label>
                    <textarea id="y_nghia" name="y_nghia" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="thoi_gian_to_chuc">Thời gian tổ chức<span class="required">*</span></label>
                    <input type="text" id="thoi_gian_to_chuc" name="thoi_gian_to_chuc" required>
                </div>
                
                <div class="form-group">
                    <label for="cac_nghi_thuc">Các nghi thức<span class="required">*</span></label>
                    <textarea id="cac_nghi_thuc" name="cac_nghi_thuc" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="am_thuc_truyen_thong">Ẩm thực truyền thống<span class="required">*</span></label>
                    <textarea id="am_thuc_truyen_thong" name="am_thuc_truyen_thong" required></textarea>
                </div>
                
                <div class="form-group">
                    <label for="luu_y_khach_tham_quan">Lưu ý khách tham quan<span class="required">*</span></label>
                    <textarea id="luu_y_khach_tham_quan" name="luu_y_khach_tham_quan" required></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" id="btnSaveEvent">
                        <i class="fas fa-save"></i> Lưu sự kiện
                    </button>
                    <button type="button" class="btn btn-secondary close-modal">
                        <i class="fas fa-times"></i> Hủy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Bảng hiển thị sự kiện -->
<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>Tên sự kiện</th>
                <th>Ý nghĩa</th>
                <th>Thời gian tổ chức</th>
                <th>Các nghi thức</th>
                <th>Ẩm thực truyền thống</th>
                <th>Lưu ý khách tham quan</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($su_kien_list as $su_kien): ?>
            <tr>
                <td><?php echo htmlspecialchars($su_kien['ten_su_kien']); ?></td>
                <td class="content-text"><?php echo htmlspecialchars($su_kien['y_nghia']); ?></td>
                <td><?php echo htmlspecialchars($su_kien['thoi_gian_to_chuc']); ?></td>
                <td class="content-text"><?php echo htmlspecialchars($su_kien['cac_nghi_thuc']); ?></td>
                <td class="content-text"><?php echo htmlspecialchars($su_kien['am_thuc_truyen_thong']); ?></td>
                <td class="content-text"><?php echo htmlspecialchars($su_kien['luu_y_khach_tham_quan']); ?></td>
                <td>
                    <button class="btn btn-warning sua-su-kien" data-id="<?php echo $su_kien['id']; ?>">
                        <i class="fas fa-edit"></i> Sửa
                    </button>
                    <button class="btn btn-danger xoa-su-kien" data-id="<?php echo $su_kien['id']; ?>">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<div class="table-container">
    <div class="section-header">
        <h2>Quản lý bình luận</h2>
        <div class="search-container">
            <input type="text" id="timKiemBinhLuan" class="search-input" placeholder="Tìm kiếm bình luận">
            <i class="fas fa-search search-icon"></i>
        </div>
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Người bình luận</th>
                <th>Email</th>
                <th>Nội dung bình luận</th>
                <th>Phản hồi</th>
                <th>Ngày bình luận</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($danhSachBinhLuan as $binhLuan): ?>
            <tr>
                <td>
                    <?php echo htmlspecialchars($binhLuan['ten_nguoi_dung'] ?? $binhLuan['ten_dang_nhap'] ?? 'Ẩn danh'); ?>
                </td>
                <td><?php echo htmlspecialchars($binhLuan['email_nguoi_dung'] ?? ''); ?></td>
                <td>
                    <div class="comment-content">
                        <?php echo nl2br(htmlspecialchars($binhLuan['noi_dung'])); ?>
                    </div>
                </td>
               <td>
                <?php if (!empty($binhLuan['phan_hoi'])): ?>
                    <div class="comment-text">
                        <?php echo nl2br(htmlspecialchars($binhLuan['phan_hoi'])); ?>
                    </div>
                <?php else: ?>
                    <em class="no-reply">Chưa có phản hồi</em>
                <?php endif; ?>
            </td>
            <td>
                <?php echo date('d/m/Y', strtotime($binhLuan['ngay_tao'])); ?>
            </td>
                <td>
                    <select class="trang-thai-binh-luan" data-id="<?php echo $binhLuan['id']; ?>">
                        <option value="1" <?php echo ($binhLuan['trang_thai'] ?? 0) == 1 ? 'selected' : ''; ?>>Hiển thị</option>
                        <option value="0" <?php echo ($binhLuan['trang_thai'] ?? 0) == 0 ? 'selected' : ''; ?>>Ẩn</option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-primary btn-save-reply" data-id="<?php echo $binhLuan['id']; ?>">
                        <i class="fas fa-reply"></i> Phản hồi
                    </button>
                    <button class="btn btn-danger xoa-binh-luan" data-id="<?php echo $binhLuan['id']; ?>">
                        <i class="fas fa-trash"></i> Xóa
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal form phản hồi bình luận -->
<div id="replyFormContainer" class="modal">
    <div class="modal-content">
        <div class="modal-title-container">
            <h2 id="replyModalTitle">Phản hồi bình luận</h2>
        </div>
        
        <div class="form-container">
            <form id="replyForm">
                <input type="hidden" id="comment_id" name="comment_id">
                
                <div class="form-group">
                    <label>Nội dung bnh luận:</label>
                    <div id="originalComment" class="comment-display"></div>
                </div>
                
                <div class="form-group">
                    <label for="reply_content">Nội dung phản hồi:<span class="required">*</span></label>
                    <textarea id="reply_content" name="reply_content" required></textarea>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-reply"></i> Gửi phản hồi
                    </button>
                    <button type="button" class="btn btn-secondary close-modal">
                        <i class="fas fa-times"></i> Hủy
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>

// Khai báo các biến toàn cục
const modal = $("#modalChua");
const form = $("#formChua");
const fileInput = $("#hinh_anh");
const imagePreview = $("#image-preview");
const removeImageBtn = $("#remove-image");
let isProcessing = false;

$(document).ready(function() {
    // Cấu hình thông báo toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right", 
        "timeOut": "3000",
        "extendedTimeOut": "1000"
    };

    // Khởi tạo các chức năng quản lý
    khoiTaoQuanLyChua();
    khoiTaoQuanLySuKien();
    khoiTaoQuanLyNguoiDung();
    khoiTaoQuanLyBinhLuan();
});

// QUẢN LÝ CHÙA
function khoiTaoQuanLyChua() {
    // Xử lý preview ảnh khi chọn file
    $("#hinh_anh").change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $("#image-preview").html(`<img src="${e.target.result}" alt="Xem trước" style="max-width: 100%; height: 100%;">`);
                $("#remove-image").show();
            };
            reader.readAsDataURL(file);
        } else {
            xoaFormAnh();
        }
    });

    // Xử lý thêm mới chùa
    $(document).on('click', '.btn-add', function() {
        const sectionTitle = $(this).closest('.section-header').find('h2').text();
        if (!sectionTitle.includes('sự kiện')) {
            $("#modalTitle").text("Thêm thông tin chùa");
            xoaFormChua();
            $("#modalChua").show();
        }
    });

    // Xử lý sửa chùa
    $(document).on('click', '.sua-chua', function() {
        const hang = $(this).closest('tr');
        const chuaId = $(this).data('id');
        
        $("#modalTitle").text("Sửa thông tin chùa");
        $("#chua_id").val(chuaId);
        $("#ten_chua").val(hang.find('td:eq(0)').text().trim());
        $("#dia_chi").val(hang.find('td:eq(1)').text().trim());
        $("#tru_tri").val(hang.find('td:eq(2)').text().trim());
        $("#dien_thoai").val(hang.find('td:eq(3)').text().trim());
        $("#email").val(hang.find('td:eq(4)').text().trim());
        $("#noi_dung").val(hang.find('td:eq(5)').text().trim());
        $("#trang_thai").val(hang.find('select.trang-thai-chua').val());

        // Xử lý hiển thị ảnh
        const anhHienTai = hang.find('td:eq(6) img').attr('src');
        if (anhHienTai) {
            $("#image-preview").html(`<img src="${anhHienTai}" alt="Xem trước" style="max-width: 100%; height: 100%;">`);
            $("#remove-image").show();
        } else {
            xoaFormAnh();
        }
        
        $("#modalChua").show();
    });

    // Xử lý submit form chùa
$("#formChua").submit(function(e) {
    e.preventDefault();
    if (isProcessing) return;
    isProcessing = true;
    
    const tenChua = $("#ten_chua").val().trim();
    const diaChi = $("#dia_chi").val().trim();
    const truTri = $("#tru_tri").val().trim();
    const trangThai = $("#trang_thai").val(); // Lấy giá trị trạng thái từ form
    
    if (!tenChua || !diaChi || !truTri) {
        toastr.error('Vui lòng điền đầy đủ thông tin bắt buộc');
        isProcessing = false;
        return;
    }

    const formData = new FormData(this);
    const chuaId = $("#chua_id").val();
    
    if (chuaId) {
        formData.append('sua_chua', '1');
        formData.append('id', chuaId);
    } else {
        formData.append('them_chua', '1');
    }
    formData.append('trang_thai', trangThai);

    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            try {
                const ketQua = typeof response === 'string' ? JSON.parse(response) : response;
                if (ketQua.success) {
                    // Cập nhật trạng thái trong bảng ngay lập tức
                    if (chuaId) {
                        $(`.trang-thai-chua[data-id="${chuaId}"]`).val(trangThai);
                    }
                    $("#modalChua").hide();
                    toastr.success(ketQua.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(ketQua.message || 'Có lỗi xảy ra');
                }
            } catch (e) {
                console.error('Lỗi:', e);
                toastr.error('Có lỗi xảy ra khi xử lý phản hồi');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi Ajax:', error);
            toastr.error('Có lỗi xảy ra khi gửi yêu cầu');
        },
        complete: function() {
            isProcessing = false;
        }
    });
});

    // Xử lý xóa chùa
    $(document).on('click', '.xoa-chua', function(e) {
        e.preventDefault();
        if (isProcessing) return;
        
        const chuaId = $(this).data('id');
        const row = $(this).closest('tr');
        
        if (confirm('Bạn có chắc chắn muốn xóa chùa này?')) {
            isProcessing = true;
            
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    'xoa_chua': '1',
                    'id': chuaId
                },
                success: function(response) {
                    try {
                        const ketQua = typeof response === 'string' ? JSON.parse(response) : response;
                        if (ketQua.success) {
                            row.fadeOut(400, function() {
                                $(this).remove();
                            });
                            toastr.success('Xóa chùa thành công');
                        } else {
                            toastr.error(ketQua.message || 'Có lỗi xảy ra');
                        }
                    } catch (e) {
                        console.error('Lỗi:', e);
                        toastr.error('Có lỗi xảy ra khi xử lý phản hồi');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi Ajax:', error);
                    toastr.error('Có lỗi xảy ra khi gửi yêu cầu');
                },
                complete: function() {
                    isProcessing = false;
                }
            });
        }
    });

    // Xử lý xóa ảnh
    $("#remove-image").click(function(e) {
        e.preventDefault();
        if (isProcessing) return;
        
        const chuaId = $("#chua_id").val();
        
        if (chuaId) {
            if (!confirm('Bạn có chắc chắn muốn xóa ảnh này?')) return;
            
            isProcessing = true;
            
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    'xoa_anh_chua': '1',
                    'id': chuaId
                },
                success: function(response) {
                    try {
                        const ketQua = typeof response === 'string' ? JSON.parse(response) : response;
                        if (ketQua.success) {
                            xoaFormAnh();
                            $(`.sua-chua[data-id="${chuaId}"]`).closest('tr').find('td:eq(6)').empty();
                            toastr.success('Xóa ảnh thành công');
                        } else {
                            toastr.error(ketQua.message || 'Có lỗi xảy ra');
                        }
                    } catch (e) {
                        console.error('Lỗi:', e);
                        toastr.error('Có lỗi xảy ra khi xử lý phản hồi');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi Ajax:', error);
                    toastr.error('Có lỗi xảy ra khi gửi yêu cầu');
                },
                complete: function() {
                    isProcessing = false;
                }
            });
        } else {
            xoaFormAnh();
        }
    });

    // Xử lý thay đổi trạng thái chùa
    $(document).on('change', '.trang-thai-chua', function() {
        if (isProcessing) return;
        
        const chuaId = $(this).data('id');
        const trangThaiMoi = $(this).val();
        
        isProcessing = true;
        
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                'thay_doi_trang_thai_chua': '1',
                'chua_id': chuaId,
                'trang_thai': trangThaiMoi
            },
            success: function(response) {
                try {
                    const ketQua = typeof response === 'string' ? JSON.parse(response) : response;
                    if (ketQua.success) {
                        toastr.success('Cập nhật trạng thái thành công');
                    } else {
                        toastr.error(ketQua.message || 'Có lỗi xảy ra');
                    }
                } catch (e) {
                    console.error('Lỗi:', e);
                    toastr.error('Có lỗi xảy ra khi xử lý phản hồi');
                }
            },
            error: function(xhr, status, error) {
                // Nếu có lỗi, reset về giá trị cũ
                select.val(trangThaiMoi === '1' ? '0' : '1');
                console.error('Lỗi Ajax:', error);
                toastr.error('Có lỗi xảy ra khi gửi yêu cầu');
            },
            complete: function() {
                // Enable lại select sau khi xử lý xong
                select.prop('disabled', false);
            }
        });
    });
}

// QUẢN LÝ SỰ KIỆN
function khoiTaoQuanLySuKien() {
    // Xử lý thêm mới sự kiện
    $('.btn-add').click(function() {
        if ($(this).closest('.section-header').find('h2').text().includes('sự kiện')) {
            xoaFormSuKien();
            $('#eventFormContainer').show();
        }
    });

    // Xử lý sửa sự kiện
    $(document).on('click', '.sua-su-kien', function(e) {
        e.preventDefault();
        
        const hang = $(this).closest('tr');
        const suKienId = $(this).data('id');
        
        $('#eventModalTitle').text('Sửa sự kiện');
        $('#event_id').val(suKienId);
        $('#ten_su_kien').val(hang.find('td:eq(0)').text().trim());
        $('#y_nghia').val(hang.find('td:eq(1)').text().trim());
        $('#thoi_gian_to_chuc').val(hang.find('td:eq(2)').text().trim());
        $('#cac_nghi_thuc').val(hang.find('td:eq(3)').text().trim());
        $('#am_thuc_truyen_thong').val(hang.find('td:eq(4)').text().trim());
        $('#luu_y_khach_tham_quan').val(hang.find('td:eq(5)').text().trim());
        
        $('#eventFormContainer').show();
    });

    // Xử lý submit form sự kiện
    $('#eventForm').submit(function(e) {
        e.preventDefault();
        
        const tenSuKien = $('#ten_su_kien').val().trim();
        if (!tenSuKien) {
            toastr.error('Vui lòng nhập tên sự kiện');
            return;
        }

        const formData = new FormData(this);
        const suKienId = $('#event_id').val();
        
        formData.append(suKienId ? 'sua_su_kien' : 'them_su_kien', true);
        if (suKienId) formData.append('event_id', suKienId);

        guiAjax({
            url: window.location.href,
            method: 'POST',
            data: formData,
            thanhCong: function(ketQua) {
                $('#eventFormContainer').hide();
                xoaFormSuKien();
                toastr.success(ketQua.message || 'Thao tác thành công');
                setTimeout(() => location.reload(), 1000);
            }
        });
    });

   // Xử lý xóa sự kiện
$(document).on('click', '.xoa-su-kien', function(e) {
    e.preventDefault();
    if (isProcessing) return;
    
    const suKienId = $(this).data('id');
    const row = $(this).closest('tr');
    
    if (confirm('Bạn có chắc chắn muốn xóa sự kiện này?')) {
        isProcessing = true;
        
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                'xoa_su_kien': '1',
                'id': suKienId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    row.fadeOut(400, function() {
                        $(this).remove();
                    });
                    toastr.success(response.message || 'Xóa sự kiện thành công');
                } else {
                    toastr.error(response.message || 'Có lỗi xảy ra khi xóa sự kiện');
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi Ajax:', error);
                toastr.error('Có lỗi xảy ra khi gửi yêu cầu xóa');
            },
            complete: function() {
                isProcessing = false;
            }
        });
    }
});
}

// QUẢN LÝ NGƯỜI DÙNG
function khoiTaoQuanLyNguoiDung() {
    // Xử lý tìm kiếm người dùng
    $('#timKiemNguoiDung').on('input', function() {
        const tuKhoa = $(this).val().toLowerCase();
        const bangNguoiDung = $(this).closest('.table-container').find('.data-table tbody tr');
        
        bangNguoiDung.each(function() {
            const tenDangNhap = $(this).find('td:eq(0)').text().toLowerCase();
            const hoTen = $(this).find('td:eq(1)').text().toLowerCase();
            const email = $(this).find('td:eq(2)').text().toLowerCase();
            
            if (tenDangNhap.includes(tuKhoa) || 
                hoTen.includes(tuKhoa) || 
                email.includes(tuKhoa)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

 // Xử lý xóa người dùng
$(document).on('click', '.xoa-nguoi-dung', function(e) {
    e.preventDefault();
    if (isProcessing) return;
    
    const nguoiDungId = $(this).data('id');
    const row = $(this).closest('tr');
    
    if (confirm('Bạn có chắc chắn muốn xóa người dùng này?')) {
        isProcessing = true;
        
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                'xoa_nguoi_dung': '1',
                'user_id': nguoiDungId
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    row.fadeOut(400, function() {
                        $(this).remove();
                    });
                    toastr.success(response.message || 'Xóa người dùng thành công');
                } else {
                    toastr.error(response.message || 'Có lỗi xảy ra khi xóa người dùng');
                }
            },
            error: function(xhr, status, error) {
                console.error('Lỗi Ajax:', error);
                toastr.error('Có lỗi xảy ra khi gửi yêu cầu xóa');
            },
            complete: function() {
                isProcessing = false;
            }
        });
    }
});
}
// QUẢN LÝ BÌNH LUẬN
function khoiTaoQuanLyBinhLuan() {
    // Xử lý tìm kiếm bình luận
    $('#timKiemBinhLuan').on('input', function() {
        const tuKhoa = $(this).val().toLowerCase();
        const bangBinhLuan = $(this).closest('.table-container').find('.data-table tbody tr');
        
        bangBinhLuan.each(function() {
            const nguoiDung = $(this).find('td:eq(0)').text().toLowerCase();
            const noiDung = $(this).find('td:eq(2)').text().toLowerCase();
            
            if (nguoiDung.includes(tuKhoa) || noiDung.includes(tuKhoa)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    // Xử lý thay đổi trạng thái bình luận
    $(document).on('change', '.trang-thai-binh-luan', function() {
        const select = $(this);
        const binhLuanId = select.data('id');
        const trangThaiMoi = select.val();
        
        // Disable select trong khi đang xử lý
        select.prop('disabled', true);
        
        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: {
                'action': 'cap_nhat_trang_thai_binh_luan',
                'comment_id': binhLuanId,
                'trang_thai': trangThaiMoi
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    toastr.success('Cập nhật trạng thái thành công');
                } else {
                    // Nếu thất bại, reset về giá trị cũ
                    select.val(trangThaiMoi === '1' ? '0' : '1');
                    toastr.error(response.message || 'Có lỗi xảy ra khi cập nhật trạng thái');
                }
            },
            error: function(xhr, status, error) {
                // Nếu có lỗi, reset về giá trị cũ
                select.val(trangThaiMoi === '1' ? '0' : '1');
                console.error('Lỗi Ajax:', error);
                toastr.error('Có lỗi xảy ra khi gửi yêu cầu');
            },
            complete: function() {
                // Enable lại select sau khi xử lý xong
                select.prop('disabled', false);
            }
        });
    });

// Xử lý hiển thị form phản hồi
$(document).on('click', '.btn-save-reply', function(e) {
    e.preventDefault();
    const row = $(this).closest('tr');
    const binhLuanId = $(this).data('id');
    const noiDungBinhLuan = row.find('.comment-content').text().trim();
    const phanHoiHienTai = row.find('.current-reply').text().trim();
    
    $('#comment_id').val(binhLuanId);
    $('#originalComment').text(noiDungBinhLuan);
    $('#reply_content').val(phanHoiHienTai);
    
    $('#replyFormContainer').show();
});

// Cập nhật phần xử lý submit form phản hồi
$('#replyForm').submit(function(e) {
    e.preventDefault();
    const binhLuanId = $('#comment_id').val();
    const phanHoiText = $('#reply_content').val().trim();
    
    if (!phanHoiText) {
        toastr.warning('Vui lòng nhập nội dung phản hồi');
        return;
    }
    
    $.ajax({
        url: window.location.href,
        type: 'POST',
        data: {
            'action': 'phan_hoi_binh_luan',
            'comment_id': binhLuanId,
            'phan_hoi': phanHoiText
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                toastr.success('Gửi phản hồi thành công');
                
                // Cập nhật trực tiếp nội dung phản hồi trong bảng
                const row = $(`.btn-save-reply[data-id="${binhLuanId}"]`).closest('tr');
                const tdPhanHoi = row.find('td:nth-child(4)'); // Cột phản hồi
                
                // Cập nhật nội dung phản hồi
                tdPhanHoi.html(`
                    <div class="comment-text">
                        ${phanHoiText.replace(/\n/g, '<br>')}
                    </div>
                `);
                
                // Đóng modal và xóa nội dung form
                $('#replyFormContainer').hide();
                $('#reply_content').val('');
                
                // Tải lại trang sau 1 giây
                setTimeout(function() {
                    location.reload();
                }, 1000);
            } else {
                toastr.error(response.message || 'Có lỗi xảy ra khi lưu phản hồi');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi Ajax:', error);
            toastr.error('Có lỗi xảy ra khi gửi yêu cầu');
        }
    });
});

// Xử lý đóng modal
$(document).on('click', '.close-modal', function() {
    $(this).closest('.modal').hide();
});

    // Xử lý xóa bình luận
    $(document).on('click', '.xoa-binh-luan', function(e) {
        e.preventDefault();
        
        const binhLuanId = $(this).data('id');
        const row = $(this).closest('tr');
        
        if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
            $.ajax({
                url: window.location.href,
                type: 'POST',
                data: {
                    'xoa_binh_luan': '1',
                    'comment_id': binhLuanId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        row.fadeOut(400, function() {
                            $(this).remove();
                        });
                        toastr.success('Xóa bình luận thành công');
                    } else {
                        toastr.error(response.message || 'Có lỗi xảy ra khi xóa bình luận');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Lỗi Ajax:', error);
                    toastr.error('Có lỗi xảy ra khi gửi yêu cầu');
                }
            });
        }
    });
}

// CÁC HÀM TIỆN ÍCH
function guiAjax({url, method, data, thanhCong, thatBai}) {
    $.ajax({
        url: url,
        type: method,
        data: data,
        processData: false,
        contentType: false,
        success: function(response) {
            try {
                const ketQua = typeof response === 'string' ? JSON.parse(response) : response;
                if (ketQua.success) {
                    if (thanhCong) thanhCong(ketQua);
                } else {
                    if (thatBai) thatBai(ketQua);
                    toastr.error(ketQua.message || 'Có lỗi xảy ra');
                }
            } catch (e) {
                console.error('Lỗi:', e);
                toastr.error('Có lỗi xảy ra khi xử lý phản hồi');
            }
        },
        error: function(xhr, status, error) {
            console.error('Lỗi Ajax:', error);
            toastr.error('Có lỗi xảy ra khi gửi yêu cầu');
        }
    });
}

function xoaFormChua() {
    $("#formChua")[0].reset();
    $("#chua_id").val("");
    xoaFormAnh();
    $("#trang_thai").val("1");
    $(".error-message").remove();
}

function xoaFormSuKien() {
    $('#eventForm')[0].reset();
    $('#event_id').val('');
}

function xoaFormAnh() {
    $("#hinh_anh").val('');
    $("#image-preview").empty();
    $("#remove-image").hide();
}

// Xử lý đóng modal
$(".close, .close-modal").click(function() {
    $(this).closest('.modal').hide();
});

// Đóng modal khi click bên ngoài
$(window).click(function(e) {
    if ($(e.target).hasClass('modal')) {
        $('.modal').hide();
    }
});

</script>

<?php
$conn->close();
?>

</body>
</html>