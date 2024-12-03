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
    public function getProductsByCategoryWithPagination($categoryId, $offset, $perPage) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM san_phams WHERE danh_muc_id = :categoryId LIMIT :offset, :perPage");
            $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
            $stmt->execute();
    
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Lấy tổng số sản phẩm
            $countStmt = $this->conn->prepare("SELECT COUNT(*) FROM san_phams WHERE danh_muc_id = :categoryId");
            $countStmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
            $countStmt->execute();
    
            $total = $countStmt->fetchColumn();
    
            return ['products' => $products, 'total' => $total];
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi truy vấn cơ sở dữ liệu: " . $e->getMessage());
        }
    }
    public function getAllProductsWithPagination($offset, $perPage) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM san_phams LIMIT :offset, :perPage");
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
            $stmt->execute();
    
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            // Lấy tổng số sản phẩm
            $countStmt = $this->conn->prepare("SELECT COUNT(*) FROM san_phams");
            $countStmt->execute();
    
            $total = $countStmt->fetchColumn();
    
            return ['products' => $products, 'total' => $total];
        } catch (PDOException $e) {
            throw new Exception("Lỗi khi truy vấn cơ sở dữ liệu: " . $e->getMessage());
        }
    }

    // Bình luận
    // Lấy bình luận cho sản phẩm
    // public function getCommentsForProduct($sanPhamId) {
    //     $stmt = $this->db->prepare("SELECT b.id, b.noi_dung, b.ngay_dang, u.ten AS user_name
    //                                 FROM binh_luan b
    //                                 LEFT JOIN tai_khoan u ON b.tai_khoan_id = u.id
    //                                 WHERE b.san_pham_id = ? AND b.trang_thai = 1
    //                                 ORDER BY b.ngay_dang DESC");
    //     $stmt->bind_param("i", $sanPhamId);
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    
    //     $comments = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $comments[] = $row;
    //     }
    //     return $comments;
    // }
    
    // Lấy chi tiết bình luận
    public function getCommentsByProductId($productId) {
        try {
            $sql = "SELECT binh_luans.*, tai_khoans.ho_ten
                    FROM binh_luans
                    INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
                    WHERE binh_luans.san_pham_id = :san_pham_id AND binh_luans.trang_thai = 1";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':san_pham_id', $productId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->logError($e);
            return [];
        }
    }
    // Thêm bình luận
    public function addComment($productId, $userId, $commentContent) {
        try {
            $sql = "INSERT INTO binh_luans (san_pham_id, tai_khoan_id, noi_dung, ngay_dang, trang_thai)
                    VALUES (:san_pham_id, :tai_khoan_id, :noi_dung, NOW(), 1)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':san_pham_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':tai_khoan_id', $userId, PDO::PARAM_INT);
            $stmt->bindParam(':noi_dung', $commentContent, PDO::PARAM_STR);
            
            return $stmt->execute();
        } catch (Exception $e) {
            $this->logError($e);
            return false;
        }
    }
    
}
