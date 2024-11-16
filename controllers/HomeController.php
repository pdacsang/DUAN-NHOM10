<?php 

class HomeController
{
    public $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();    
    }

    public function home() {
        require_once './views/home.php';
    }

    public function trangChu(){
        echo "Trang Chủ";
    }

    public function danhSachSanPham(){
        $listProduct = $this->modelProduct->getAllProducts();
        require_once './views/listProduct.php';
    }

}