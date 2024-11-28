<?php 

class HomeController
{
    // public $modelSanPham;
    public $modelTaiKhoan;

    public function __construct()
    {
        // $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();     
    }

    public function home(){
        require_once './views/home.php';
    }

    public function trangChu(){
        echo "Trang Chủ";
    }

    // public function danhSachSanPham(){
    //     $listProduct = $this->modelSanPham->getAllProduct();
    //     require_once './views/listProduct.php';
    // }

    // login client
    public function formLogin() {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
        exit();
    }
    public function postLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy email và mật khẩu từ form
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            // Kiểm tra thông tin đăng nhập
            $user = $this->modelTaiKhoan->checkLogin($email);
    
            // Kiểm tra tài khoản khách hàng hoạt động
            if ($user && password_verify($password, $user['mat_khau']) && $user['chuc_vu_id'] == 2 && $user['trang_thai'] == 1) {
                // Đăng nhập thành công
                $_SESSION['user_client'] = $user;
                $_SESSION['success'] = 'Đăng nhập thành công!';
                header("Location: " . BASE_URL);
                exit();
            } else {
                // Nếu đăng nhập thất bại, lưu lỗi vào session
                $_SESSION['error'] = "Sai thông tin mật khẩu hoặc tài khoản hoặc tài khoản không hoạt động!";
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=login');
                exit();
            }
        }
    }
    
    
    
    public function logout(){
        if(isset($_SESSION['user_client'])){
            unset($_SESSION['user_client']);
            header("Location: " .BASE_URL);
            exit();
        }
    }

    // đăng ký
    public function formRegister() {
        require_once './views/auth/register.php';
        deleteSessionError();
        exit();
    }
    public function postAddUser(){
        // Xử lý thêm dữ liệu
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $password = $_POST['mat_khau'];
            $errors = [];
    
            // Kiểm tra dữ liệu đầu vào
            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Tên không được để trống.';
            }
            if (empty($email)) {
                $errors['email'] = 'Email không được để trống.';
            }
            if (empty($password)) {
                $errors['password'] = 'Mật khẩu không được để trống.';
            }
    
            // Lưu lỗi vào session
            $_SESSION['error'] = $errors;
    
            // Nếu không có lỗi, thực hiện lưu dữ liệu
            if (empty($errors)) {
                // Mã hóa mật khẩu
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
                // Chức vụ mặc định là 2 (Khách hàng)
                $chuc_vu_id = 2;
    
                // Lưu thông tin người dùng vào database
                $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $hashedPassword, $chuc_vu_id);
    
                // Thêm thông báo thành công vào session
                $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
    
                // Chuyển hướng đến trang đăng nhập
                header("Location: " . BASE_URL . '?act=login');
                exit();
            } else {
                // Lưu thông báo lỗi và chuyển hướng lại form
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL . '?act=register');
                exit();
            }
        }
    }
    
    
    // profile khách hàng
    public function formEditKhachHang() {
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        // var_dump($khachhang);die;
        require_once './views/auth/editUser.php';
        deleteSessionError();
    }
    public function postEditKhachHang() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $khach_hang_id = $_POST['khach_hang_id'] ?? '';

            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $ngay_sinh = $_POST['ngay_sinh'] ?? '';
            $gioi_tinh = $_POST['gioi_tinh'] ?? '';
            $dia_chi = $_POST['dia_chi'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';

            $errors = [];
            if(empty($ho_ten)) {
                $errors['ho_ten'] = 'Điền họ tên';
            }
            if(empty($email)) {
                $errors['email'] = 'Điền email';
            }
            if(empty($ngay_sinh)) {
                $errors['ngay_sinh'] = 'Chọn ngày sinh';
            }
            if(empty($gioi_tinh)) {
                $errors['gioi_tinh'] = 'Chọn giới tính';
            }
            if(empty($trang_thai)) {
                $errors['trang_thai'] = 'Vui lòng chọn trạng thái';
            }

            $_SESSION['error'] = $errors;
            if(empty($errors)) {
                $this->modelTaiKhoan->updateKhachHang($khach_hang_id, $ho_ten, $email, $so_dien_thoai, $ngay_sinh, $gioi_tinh, $dia_chi, $trang_thai);
                header("Location: " . BASE_URL . '?act=chi-tiet-khach-hang');
                exit();
            }else {
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL. '?act=form-sua-khach-hang&id_khach_hang=' . $khach_hang_id);
                exit();
            }
        }
    }
    public function deltailKhachHang() {
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        require_once './views/auth/deltailUser.php';
    }

}