<?php
class ProductModel {
    private $conn;

     public function __construct()
        {
            $this->conn = connectDB();
        }


    // Lấy tất cả sản phẩm
    public function getAllProducts() {
        try {
            $sql = "SELECT id, ten_sach, gia_sach, hinh_anh FROM san_phams";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về danh sách sản phẩm
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về danh sách danh mục
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
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Trả về danh sách sản phẩm
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
            return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về chi tiết sản phẩm
        } catch (Exception $e) {
            $this->logError($e);
            return null;
        }
    }

    // Ghi log lỗi
    private function logError($exception) {
        file_put_contents('./logs/error.log', date('Y-m-d H:i:s') . ' - ' . $exception->getMessage() . PHP_EOL, FILE_APPEND);
    }
}
