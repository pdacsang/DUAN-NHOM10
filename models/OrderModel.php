<?php
class OrderModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Thêm đơn hàng
    public function createOrder($data) {
        try {
            $query = "INSERT INTO don_hangs 
                      (ma_don_hang, tai_khoan_id, ten_nguoi_nhan, email_nguoi_nhan, sdt_nguoi_nhan, dia_chi_nguoi_nhan, ngay_dat, tong_tien, ghi_chu, phuong_thuc_thanh_toan_id, trang_thai_id)
                      VALUES (:ma_don_hang, :tai_khoan_id, :ten_nguoi_nhan, :email_nguoi_nhan, :sdt_nguoi_nhan, :dia_chi_nguoi_nhan, :ngay_dat, :tong_tien, :ghi_chu, :phuong_thuc_thanh_toan_id, :trang_thai_id)";
            
            $stmt = $this->db->prepare($query);

            // Kiểm tra nếu truy vấn bị lỗi
            if (!$stmt->execute($data)) {
                throw new Exception("Lỗi khi thực thi truy vấn tạo đơn hàng.");
            }

            // Trả về ID của đơn hàng vừa tạo
            return $this->db->lastInsertId();
        } catch (PDOException $e) {
            // Log lỗi cụ thể từ PDO
            error_log("Lỗi khi tạo đơn hàng: " . $e->getMessage());

            // Ném lỗi thân thiện cho người dùng
            throw new Exception("Không thể tạo đơn hàng. Vui lòng kiểm tra thông tin và thử lại.");
        }
    }

    // Thêm chi tiết đơn hàng
    public function addOrderDetail($data) {
        try {
            $query = "INSERT INTO chi_tiet_don_hangs 
                      (don_hang_id, san_pham_id, don_gia, so_luong, thanh_tien)
                      VALUES (:don_hang_id, :san_pham_id, :don_gia, :so_luong, :thanh_tien)";
            
            $stmt = $this->db->prepare($query);

            // Kiểm tra nếu truy vấn bị lỗi
            if (!$stmt->execute($data)) {
                throw new Exception("Lỗi khi thực thi truy vấn thêm chi tiết đơn hàng.");
            }
        } catch (PDOException $e) {
            // Log lỗi cụ thể từ PDO
            error_log("Lỗi khi thêm chi tiết đơn hàng: " . $e->getMessage());

            // Ném lỗi thân thiện cho người dùng
            throw new Exception("Không thể thêm chi tiết đơn hàng. Vui lòng kiểm tra thông tin và thử lại.");
        }
    }
}
?>
