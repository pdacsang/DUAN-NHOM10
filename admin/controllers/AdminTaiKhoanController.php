<?php 

class AdminTaiKhoanController
{
    public $modelTaiKhoan;
    public $modelDonHang;
    public $modelSanPham;
    public function __construct(){
        $this->modelTaiKhoan = new AdminTaiKhoan();
        $this->modelDonHang = new AdminDonHang();
        $this->modelSanPham = new AdminSanPham();
    }
    public function danhSachQuanTri(){
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);
        //var_dump($listQuanTri);die;
        require_once './views/taikhoan/quantri/listQuanTri.php';
    }
    public function formAddQuanTri(){
        require_once './views/taikhoan/quantri/addQuanTri.php';

        deleteSessionError();
    }
    public function postAddQuanTri(){
        //thêm dữ liệu xử lý
        // var_dump($_POST);
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $errors = [];
            if(empty($ho_ten)){
                $errors['ho_ten'] = 'Tên không được để trống.';
            }
            if(empty($email)){
                $errors['email'] = 'Email không được để trống.';
            }
            $_SESSION['error'] = $errors;
            // echo '<pre>';
            // print_r($_POST);
            // echo '<pre>';
            // nếu không có lỗi 
            if(empty($errors)){
                // nếu không có lỗi tiến hành tiếp
                // đặt passwword mặc định 123@321it
                $password = password_hash('123@321it', PASSWORD_BCRYPT);
                // khai báo chức vụ
                $chuc_vu_id = 1;
                //var_dump($password);die;
                $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $chuc_vu_id);
                header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            }else{
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-them-quan-tri');
                exit();
            }
        }
    }
    public function formEditQuanTri() {
        $id_quan_tri = $_GET['id_quan_tri'];
        $quanTri = $this->modelTaiKhoan->getDetailTaiKhoan($id_quan_tri);
        // var_dump($quanTri);die;
        require_once './views/taikhoan/quantri/editQuanTri.php';
        deleteSessionError();
    }
    public function postEditQuanTri() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $quan_tri_id = $_POST['quan_tri_id'] ?? '';

            $ho_ten = $_POST['ho_ten'] ?? '';
            $email = $_POST['email'] ?? '';
            $so_dien_thoai = $_POST['so_dien_thoai'] ?? '';
            $trang_thai = $_POST['trang_thai'] ?? '';

            $errors = [];
            if(empty($ho_ten)) {
                $errors['ho_ten'] = 'Điền họ tên';
            }
            if(empty($email)) {
                $errors['email'] = 'Điền email';
            }
            if(empty($trang_thai)) {
                $errors['trang_thai'] = 'Vui lòng chọn trạng thái';
            }

            $_SESSION['error'] = $errors;
            if(empty($errors)) {
                $this->modelTaiKhoan->updateTaiKhoan($quan_tri_id, $ho_ten, $email, $so_dien_thoai, $trang_thai);
                header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
                exit();
            }else {
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-quan-tri&id_quan_tri=' . $quan_tri_id);
                exit();
            }
        }
    }
    public function resetPassword(){
        $tai_khoan_id = $_GET['id_quan_tri'];
        $tai_khoan = $this->modelTaiKhoan->getDetailTaiKhoan($tai_khoan_id);
        $password = password_hash('123@321it', PASSWORD_BCRYPT);
        $status = $this->modelTaiKhoan->resetPassword($tai_khoan_id, $password);
        if($status && $tai_khoan['chuc_vu_id'] == 1){
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-quan-tri');
            exit();
        }elseif($status && $tai_khoan['chuc_vu_id'] == 2){
            header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
            exit();
        }else{
            var_dump('Lỗi reset tài khoản');die;
        }
    }

    // Khách hàng
    public function danhSachKhachHang(){
        $listKhachHang = $this->modelTaiKhoan->getAllTaiKhoan(2);
        //var_dump($listKhachHang);die;
        require_once './views/taikhoan/khachhang/listKhachHang.php';
    }
    public function formEditKhachHang() {
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);
        // var_dump($khachhang);die;
        require_once './views/taikhoan/khachhang/editKhachHang.php';
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
                header("Location: " . BASE_URL_ADMIN . '?act=list-tai-khoan-khach-hang');
                exit();
            }else {
                $_SESSION['flash'] = true;
                header("Location: " . BASE_URL_ADMIN . '?act=form-sua-khach-hang&id_khach_hang=' . $khach_hang_id);
                exit();
            }
        }
    }
    public function deltailKhachHang() {
        $id_khach_hang = $_GET['id_khach_hang'];
        $khachHang = $this->modelTaiKhoan->getDetailTaiKhoan($id_khach_hang);

        $listDonHang = $this->modelDonHang->getDonHangFromKhachHang(id: $id_khach_hang);

        $listBinhLuan = $this->modelSanPham->getBinhLuanFromKhachHang($id_khach_hang);
        require_once './views/taikhoan/khachhang/deltailKhachHang.php';
    }
    // auth
    public function formLogin() {
        require_once './views/auth/formLogin.php';
        deleteSessionError();
    }
    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            // lấy email và pass gửi lên form
            $email = $_POST['email'];
            $password = $_POST['password'];
            //var_dump($email);die;
            // xử lý kiểm tra thông tin đăng nhập
            $user = $this->modelTaiKhoan->checkLogin($email,$password);
            if($user == $email){ // trường hợp đn thành công
                // lưu thông tin vào session
                $_SESSION['user_admin'] = $user;
                header("Location: " .BASE_URL_ADMIN);
                exit();
            }else{
                // lỗi thì lưu lỗi vào session
                $_SESSION['error'] = $user;
                // var_dump($_SESSION['error']);die;
                $_SESSION['flash'] = true;
                header("Location: " .BASE_URL_ADMIN .'?act=login-admin');
                exit();
            }
        }
    }
    public function logout(){
        if(isset($_SESSION['user_admin'])){
            unset($_SESSION['user_admin']);
            header("Location: " .BASE_URL_ADMIN .'?act=login-admin');
        }
    }
}