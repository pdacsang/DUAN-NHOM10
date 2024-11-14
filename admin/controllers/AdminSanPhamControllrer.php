<?php 
    class AdminSanPhamController{

        public $modelSanPham;
        public $modelDanhMuc;
        public function __construct()
        {
            $this->modelSanPham = new AdminSanPham();
            $this->modelDanhMuc = new AdminDanhMuc();
        }
        public function danhSachSanPham(){
            $listSanPham = $this->modelSanPham->getAllSanPham();
            require_once './views/sanpham/listSanPham.php';
        }

        public function formAddSanPham(){
            //hiển thị form nhập
            $listDanhMuc = $this->modelDanhMuc->getAllDanhMuc();
            require_once './views/sanpham/addSanPham.php';
        }

        
        public function postAddSanPham(){
            //thêm dữ liệu xử lý
            // var_dump($_POST);
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $ten_sach = $_POST['ten_sach'];
                $gia_sach = $_POST['gia_sach'];
                $gia_khuyen_mai = $_POST['gia_khuyen_mai'];
                $so_luong = $_POST['so_luong'];
                $ngay_xuat_ban = $_POST['ngay_xuat_ban'];
                $danh_muc_id = $_POST['danh_muc_id'];
                $trang_thai = $_POST['trang_thai'];
                $the_loai_id = $_POST['the_loai_id'];
                $mo_ta = $_POST['mo_ta'];

                $hinh_anh = $_FILES['hinh_anh'];
                // lưu ảnh
                $file_thumb = uploadFile($hinh_anh, './uploads');
                // mảng hình ảnh
                $img_array = $_FILES['img_array'];

                $errors = [];
                if(empty($ten_sach)){
                    $errors['ten_sach'] = 'Tên sản phẩm không được để trống.';
                }
                if(empty($gia_sach)){
                    $errors['gia_sach'] = 'Giá sách không được để trống.';
                }
                if(empty($gia_khuyen_mai)){
                    $errors['gia_khuyen_mai'] = 'Giá khuyến mái không được để trống.';
                }
                if(empty($so_luong)){
                    $errors['so_luong'] = 'Số lượng không được để trống.';
                }
                if(empty($ngay_xuat_ban)){
                    $errors['ngay_xuat_ban'] = 'Ngày xuất bản không được để trống.';
                }
                if(empty($danh_muc_id)){
                    $errors['danh_muc_id'] = 'Danh mục không được để trống.';
                }
                if(empty($trang_thai)){
                    $errors['trang_thai'] = 'Trạng thái không được để trống.';
                }
                if(empty($the_loai_id)){
                    $errors['the_loai_id'] = 'Thể loại không được để trống.';
                }
                // nếu không có lỗi 
                if(empty($errors)){
                    // nếu không có lỗi tiến hành tiếp
                    // var_dump("kjhk");die;
                    $this->modelSanPham->insertSanPham($ten_sach, $gia_sach, $gia_khuyen_mai, $so_luong, 
                                                        $ngay_xuat_ban, $danh_muc_id, $trang_thai, $the_loai_id ,$mo_ta, $file_thumb);
                    header("Location: " . BASE_URL_ADMIN . '?act=san-pham');
                    exit();
                }else{
                    // trả về form và lỗi
                    require_once './views/sanpham/addSanPham.php';
                }
            }
        }

        // public function formEditDanhMuc(){
        //     //hiển thị form nhập
        //     //lấy ra thông tin
        //     $id = $_GET['id_danh_muc'];
        //     $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);
        //     if($danhMuc){
        //         require_once './views/danhmuc/editDanhMuc.php';
        //     }else{
        //         header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
        //             exit();
        //     }
        // }

        
        // public function postEditDanhMuc(){
        //     //thêm dữ liệu xử lý
        //     // var_dump($_POST);
        //     if($_SERVER['REQUEST_METHOD'] == 'POST'){
        //         $id = $_POST['id'];
        //         $ten_danh_muc = $_POST['ten_danh_muc'];
        //         $mo_ta = $_POST['mo_ta'];
        //         $errors = [];
        //         if(empty($ten_danh_muc)){
        //             $errors['ten_danh_muc'] = 'Tên danh mục không được để trống.';
        //         }
        //         // nếu không có lỗi 
        //         if(empty($errors)){
        //             // nếu không có lỗi tiến hành tiếp
        //             // var_dump("kjhk");die;
        //             $this->modelDanhMuc->updateDanhMuc($id, $ten_danh_muc, $mo_ta);
        //             header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
        //             exit();
        //         }else{
        //             // trả về form và lỗi
        //             $danhMuc = ['id' => $id, 'ten_danh_muc' => $ten_danh_muc, 'mo_ta' => $mo_ta];
        //             require_once './views/danhmuc/editDanhMuc.php';
        //         }
        //     }
        // }

        // public function deleteDanhMuc(){
        //     $id = $_GET['id_danh_muc'];
        //     $danhMuc = $this->modelDanhMuc->getDetailDanhMuc($id);

        //     if($danhMuc){
        //         $this->modelDanhMuc->destroyDanhMuc($id);
        //     }

        //     header("Location: " . BASE_URL_ADMIN . '?act=danh-muc');
        //     exit();
        // }
    }
?>