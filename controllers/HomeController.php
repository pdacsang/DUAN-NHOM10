<?php 

class HomeController
{
    public $modelSanPham;

    public function __construct()
    {
        $this->modelSanPham = new SanPham();    
    }

    public function home(){
        require_once './views/home.php';
    }

    public function trangChu(){
        echo "Trang Chủ";
    }

    public function danhSachSanPham(){
        $listProduct = $this->modelSanPham->getAllProduct();
        require_once './views/listProduct.php';
    }

}