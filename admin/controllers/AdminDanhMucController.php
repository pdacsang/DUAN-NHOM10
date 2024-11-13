<?php 
    class AdminDanhMucController{

        public $modelDanhMuc;
        public function __construct()
        {
            $this->modelDanhMuc = new AdminDanhMuc();
        }
        public function danhSachDanhMuc(){
            $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
            require_once './views/danhmuc/listDanhMuc.php';
        }

        public function formAddDanhMuc(){
            //hiển thị form nhập
            require_once './views/danhmuc/addDanhMuc.php';
        }

        
        public function postAddDanhMuc(){
            //thêm dữ liệu xử lý
            // var_dump($_POST);
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $ten_danh_muc = $_POST['ten_danh_muc'];
                $mo_ta = $_POST['mo_ta'];
                $errors = [];
                if(empty($ten_danh_muc)){
                    $errors['ten_danh_muc'] = 'Tên danh mục không được để trống.';
                }
                // nếu không có lỗi 
                if(empty($errors)){
                    // nếu không có lỗi tiến hành tiếp
                    // var_dump("kjhk");die;
                    $this->modelDanhMuc->insertDanhMuc($ten_danh_muc, $mo_ta);
                    header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
                    exit();
                }else{
                    // trả về form và lỗi
                    require_once './views/danhmuc/addDanhMuc.php';
                }
            }
        }
    }
?>