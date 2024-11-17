<?php
class ProductModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
        if (!$this->conn) {
            $this->logError(new Exception("Không thể kết nối cơ sở dữ liệu."));
            throw new Exception("Kết nối cơ sở dữ liệu thất bại.");
        }
    }

    // Lấy tất cả sản phẩm
    public function getAllProducts() {
        try {
            $sql = "SELECT id, ten_sach, gia_sach, hinh_anh FROM san_phams";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Trả về danh sách sản phẩm hoặc mảng rỗng
        } catch (Exception $e) {
            $this->logError($e);
            return [];
        }
    }

    // Lấy tất cả danh mục
    public function getAllCategories() {
        try {
            $sql = "SELECT id, ten_danh_muc FROM danh_mucs";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Trả về danh sách danh mục hoặc mảng rỗng
        } catch (Exception $e) {
            $this->logError($e);
            return [];
        }
    }

    // Lấy sản phẩm theo danh mục
    public function getProductsByCategory($categoryId) {
        try {
            $sql = "SELECT id, ten_sach, gia_sach, hinh_anh FROM san_phams WHERE danh_muc_id = :danh_muc_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':danh_muc_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Trả về danh sách sản phẩm hoặc mảng rỗng
        } catch (Exception $e) {
            $this->logError($e);
            return [];
        }
    }

    // Lấy thông tin chi tiết sản phẩm
    public function getProductById($id) {
        try {
            $sql = "SELECT id, ten_sach, gia_sach, hinh_anh, mo_ta, trang_thai, nha_xuat_ban, so_trang, ngay_xuat_ban 
                    FROM san_phams WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null; // Trả về sản phẩm hoặc null
        } catch (Exception $e) {
            $this->logError($e);
            return null;
        }
    }

    // Ghi log lỗi
    private function logError($exception) {
        $message = '[' . date('Y-m-d H:i:s') . '] ERROR: ' . $exception->getMessage() . PHP_EOL;
        $file = './logs/error.log';

        if (!file_exists('./logs')) {
            mkdir('./logs', 0777, true); // Tạo thư mục nếu chưa tồn tại
        }

        file_put_contents($file, $message, FILE_APPEND);
    }
}
