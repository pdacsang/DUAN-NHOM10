<?php
class OrderModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Tạo đơn hàng
    public function createOrder($totalAmount, $statusId, $paymentMethodId, $userId, $recipientName, $email, $phone, $address) {
        $orderCode = uniqid('DH'); // Mã đơn hàng tự động tạo
    
        // SQL query tạo đơn hàng
        $sql = "INSERT INTO don_hangs (ma_don_hang, tong_tien, trang_thai_id, phuong_thuc_thanh_toan_id, tai_khoan_id, ten_nguoi_nhan, email_nguoi_nhan, sdt_nguoi_nhan, dia_chi_nguoi_nhan) 
                VALUES (:ma_don_hang, :tong_tien, :trang_thai_id, :phuong_thuc_thanh_toan_id, :tai_khoan_id, :ten_nguoi_nhan, :email_nguoi_nhan, :sdt_nguoi_nhan, :dia_chi)";
        $stmt = $this->db->prepare($sql);

        try {
            // Thực thi câu lệnh SQL
            $stmt->execute([
                ':ma_don_hang' => $orderCode,
                ':tong_tien' => $totalAmount,
                ':trang_thai_id' => $statusId,
                ':phuong_thuc_thanh_toan_id' => $paymentMethodId,
                ':tai_khoan_id' => $userId,
                ':ten_nguoi_nhan' => $recipientName,
                ':email_nguoi_nhan' => $email,
                ':sdt_nguoi_nhan' => $phone,
                ':dia_chi' => $address
            ]);

            return $this->db->lastInsertId(); // Trả về ID của đơn hàng vừa tạo
        } catch (PDOException $e) {
            error_log("Lỗi khi tạo đơn hàng: " . $e->getMessage());
            throw new Exception("Không thể tạo đơn hàng. Vui lòng thử lại.");
        }
    }

    // Thêm chi tiết đơn hàng
    public function addOrderDetails($orderId, $productId, $quantity, $price) {
        $sql = "INSERT INTO chi_tiet_don_hangs (don_hang_id, san_pham_id, so_luong, don_gia, thanh_tien) 
                VALUES (:don_hang_id, :san_pham_id, :so_luong, :don_gia, :thanh_tien)";
        $stmt = $this->db->prepare($sql);

        try {
            // Thực thi câu lệnh SQL để thêm chi tiết đơn hàng
            $stmt->execute([
                ':don_hang_id' => $orderId,
                ':san_pham_id' => $productId,
                ':so_luong' => $quantity,
                ':don_gia' => $price,
                ':thanh_tien' => $price * $quantity
            ]);
        } catch (PDOException $e) {
            error_log("Lỗi khi thêm chi tiết đơn hàng: " . $e->getMessage());
            throw new Exception("Không thể thêm chi tiết đơn hàng. Vui lòng thử lại.");
        }
    }

    // Lấy thông tin một đơn hàng
    public function getOrder($id) {
        $sql = "SELECT * FROM don_hangs WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về thông tin đơn hàng
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy thông tin đơn hàng: " . $e->getMessage());
            throw new Exception("Không thể lấy thông tin đơn hàng.");
        }
    }

    // Lấy chi tiết đơn hàng
    public function getOrderDetails($orderId) {
        $sql = "SELECT * FROM chi_tiet_don_hangs WHERE don_hang_id = :don_hang_id";
        $stmt = $this->db->prepare($sql);

        try {
            $stmt->execute([':don_hang_id' => $orderId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về tất cả chi tiết đơn hàng
        } catch (PDOException $e) {
            error_log("Lỗi khi lấy chi tiết đơn hàng: " . $e->getMessage());
            throw new Exception("Không thể lấy chi tiết đơn hàng.");
        }
    }
}
?>
