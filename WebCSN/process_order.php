<?php
session_start();

// Kết nối database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ban_hang";

try {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('Vui lòng đăng nhập để đặt hàng');
    }

    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");
    
    // Lấy dữ liệu từ request
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Kiểm tra dữ liệu
    if (!isset($data['total']) || !isset($data['phone']) || !isset($data['address']) || !isset($data['paymentMethod'])) {
        throw new Exception('Thiếu thông tin đơn hàng');
    }
    
    // Bắt đầu transaction
    $conn->beginTransaction();
    
    // Thêm vào bảng don_hang với user_id từ session
    $sql = "INSERT INTO don_hang (nguoi_dung_id, ngay_dat, tong_tien, trang_thai, 
            phuong_thuc_thanh_toan, dia_chi, sdt) 
            VALUES (:nguoi_dung_id, NOW(), :tong_tien, 'Chờ xử lý', 
            :thanh_toan, :dia_chi, :sdt)";
    
    $stmt = $conn->prepare($sql);
    
    $params = [
        ':nguoi_dung_id' => $_SESSION['user_id'], // Lấy ID từ session
        ':tong_tien' => $data['total'],
        ':thanh_toan' => $data['paymentMethod'],
        ':dia_chi' => $data['address'],
        ':sdt' => $data['phone']
    ];
    
    $stmt->execute($params);
    
    $donHangId = $conn->lastInsertId();
    
    // Kiểm tra items
    if (empty($data['items'])) {
        throw new Exception('Giỏ hàng trống');
    }
    
    // Thêm chi tiết đơn hàng
    $stmt = $conn->prepare("INSERT INTO chi_tiet_don_hang (id_don_hang, san_pham_id, so_luong, gia_ban) 
                           VALUES (:id_don_hang, :san_pham_id, 1, :gia_ban)");
                           
    foreach ($data['items'] as $item) {
        if (!isset($item['id'])) {
            throw new Exception('Thiếu ID sản phẩm');
        }
        
        $stmt->execute([
            ':id_don_hang' => $donHangId,
            ':san_pham_id' => $item['id'],
            ':gia_ban' => $item['price']
        ]);
    }
    
    // Hoàn tất transaction
    $conn->commit();
    
    // Trả về kết quả thành công
    echo json_encode([
        'success' => true,
        'message' => 'Đặt hàng thành công'
    ]);
    
} catch(Exception $e) {
    // Nếu có lỗi, rollback transaction
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }
    
    // Trả về thông báo lỗi
    echo json_encode([
        'success' => false,
        'message' => 'Lỗi: ' . $e->getMessage()
    ]);
}

// Đóng kết nối
$conn = null;
?>