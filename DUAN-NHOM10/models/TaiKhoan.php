<?php 

class TaiKhoan
{
    public $conn;
    public function __construct(){
        $this->conn = connectDB();
    }
    public function checkLogin($email) {
        try {
            // Truy vấn lấy thông tin tài khoản từ email
            $sql = "SELECT * FROM tai_khoans WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();
    
            if ($user) {
                return $user;  // Trả về thông tin người dùng
            } else {
                return false;  // Không tìm thấy người dùng
            }
        } catch (\Exception $e) {
            // Xử lý lỗi
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }
    
    // đăng ký :
    public function insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id){
        try {
            // Truy vấn chèn dữ liệu vào bảng tai_khoans
            $sql = 'INSERT INTO tai_khoans(ho_ten, email, mat_khau, chuc_vu_id)
                    VALUES (:ho_ten, :email, :password, :chuc_vu_id)';
    
            $stmt = $this->conn->prepare($sql);
    
            // Thực thi truy vấn với dữ liệu từ form
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':password' => $password,  // Mật khẩu đã mã hóa
                ':chuc_vu_id' => $chuc_vu_id,  // Chức vụ mặc định là khách hàng (2)
            ]);
    
            return true;  // Trả về true nếu thành công
        } catch (Exception $e) {
            // Xử lý lỗi
            echo "Lỗi: " . $e->getMessage();
        }
    }
    
    // profile
    public function getDetailTaiKhoan($id){
        try{
            $sql = 'SELECT * FROM tai_khoans WHERE id = :id';

            $stml = $this->conn->prepare($sql);

            $stml->execute([
                ':id' => $id
            ]);

            return $stml->fetch();
        }catch(Exception $e){
            echo "Lỗi" . $e->getMessage();
        }
    }
    public function updateKhachHang($id, $ho_ten, $email, $so_dien_thoai, $ngay_sinh, $gioi_tinh, $dia_chi){
        try{
            $sql = 'UPDATE tai_khoans
                    SET
                        ho_ten = :ho_ten,
                        email = :email,
                        so_dien_thoai = :so_dien_thoai,
                        ngay_sinh = :ngay_sinh,
                        gioi_tinh = :gioi_tinh,
                        dia_chi = :dia_chi
                    WHERE id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':so_dien_thoai' => $so_dien_thoai,
                ':ngay_sinh' => $ngay_sinh,
                ':gioi_tinh' => $gioi_tinh,
                ':dia_chi' => $dia_chi,
                ':id' => $id
            ]);
            return true;
        } catch (Exception $e) {
            echo "lỗi" . $e->getMessage();
        }
    }
}