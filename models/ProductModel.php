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
            $sql = "SELECT id, ten_sach, gia_sach, hinh_anh FROM san_phams WHERE trang_thai = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            $this->logError($e);
            return [];
        }
    }

    // Lấy sản phẩm theo danh mục
    public function getProductsByCategory($categoryId) {
        try {
            $categoryId = intval($categoryId); // Đảm bảo dữ liệu là số nguyên
            $sql = "SELECT id, ten_sach, gia_sach, hinh_anh 
                    FROM san_phams 
                    WHERE danh_muc_id = :danh_muc_id AND trang_thai = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':danh_muc_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            $this->logError($e);
            return [];
        }
    }

    // Lấy thông tin chi tiết sản phẩm
    public function getProductById($id) {
        try {
            $id = intval($id); // Đảm bảo dữ liệu là số nguyên
            $sql = "SELECT id, ten_sach, gia_sach, hinh_anh, mo_ta, trang_thai, nha_xuat_ban, so_trang, ngay_xuat_ban 
                    FROM san_phams 
                    WHERE id = :id AND trang_thai = 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (Exception $e) {
            $this->logError($e);
            return null;
        }
    }

    // Hàm tìm kiếm sản phẩm
    public function searchProducts($keyword) {
        try {
            // Làm sạch dữ liệu đầu vào và tạo dấu % cho phép tìm kiếm toàn bộ từ khóa
            $keyword = '%' . trim(htmlspecialchars($keyword)) . '%'; 
            
            // SQL query để tìm kiếm sản phẩm theo tên hoặc mô tả
            $sql = "SELECT id, ten_sach, gia_sach, hinh_anh 
                    FROM san_phams 
                    WHERE (ten_sach LIKE :keyword OR mo_ta LIKE :keyword) AND trang_thai = 1";
            
            // Chuẩn bị câu truy vấn
            $stmt = $this->conn->prepare($sql);
            
            // Gắn tham số vào câu truy vấn
            $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            
            // Thực thi câu truy vấn
            $stmt->execute();
            
            // Trả về tất cả kết quả dưới dạng mảng hoặc mảng rỗng nếu không có kết quả
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (Exception $e) {
            // Ghi log lỗi nếu có
            $this->logError($e);
            return [];
        }
    }

    // Ghi log lỗi
    private function logError($exception) {
        $message = '[' . date('Y-m-d H:i:s') . '] ERROR: ' . $exception->getMessage() . PHP_EOL;
        $file = './logs/error.log';

        if (!file_exists('./logs')) {
            mkdir('./logs', 0777, true);
        }

        file_put_contents($file, $message, FILE_APPEND);
    }
}
