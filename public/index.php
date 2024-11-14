<?php 
// $action = isset($_GET['act']) ? $_GET['act'] : "admin";
$action = isset($_GET['act']) ? $_GET['act'] : "index";

switch($action){
    case 'admin':
        include '../view/admin/index.php';
        break;
    case 'category':
        include '../view/admin/category/list.php';
        break;
    case 'category-edit':
        include '../view/admin/category/edit.php';
        break;
    case 'category-add':
        include '../view/admin/category/add.php';
        break;
    case 'product':
        include '../view/admin/product/list.php';
        break;
    case 'product-edit':
        include '../view/admin/product/edit.php';
        break;
    case 'product-add':
        include '../view/admin/product/add.php';
        break;
//----------------------------------------------------- Admin --------------------------------------------------------------
    case 'index':
        include '../view/client/index.php';
        break;

}