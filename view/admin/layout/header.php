<!doctype html>
<html lang="en" class="minimal-theme">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="admin/assets/images/favicon-32x32.png" type="image/png" />
  <link href="admin/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
  <link href="admin/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="admin/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <link href="admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
  <link href="admin/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="admin/assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="admin/assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="admin/assets/css/style.css" rel="stylesheet" />
  <link href="admin/assets/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../../../../../cdn.jsdelivr.net/npm/bootstrap-icons%401.9.1/font/bootstrap-icons.css">
  <!-- loader-->
	<link href="admin/assets/css/pace.min.css" rel="stylesheet" />
  <!--Theme Styles-->
  <link href="admin/assets/css/dark-theme.css" rel="stylesheet" />
  <link href="admin/assets/css/light-theme.css" rel="stylesheet" />
  <link href="admin/assets/css/semi-dark.css" rel="stylesheet" />
  <link href="admin/assets/css/header-colors.css" rel="stylesheet" />
  <title>NHÓM 10 - Admin </title>
</head>
<body>
  <!--start wrapper-->
  <div class="wrapper">
    <!--start top header-->
      <header class="top-header">        
        <nav class="navbar navbar-expand">
          <div class="mobile-toggle-icon d-xl-none">
              <i class="bi bi-list"></i>
            </div>
            <div class="top-navbar d-none d-xl-block">
            <ul class="navbar-nav align-items-center">
              <li class="nav-item">
              <a class="nav-link" href="index.html">BẢNG ĐIỀU KHIỂN</a>
              </li>
            </ul>
            </div>
            <div class="search-toggle-icon d-xl-none ms-auto">
              <i class="bi bi-search"></i>
            </div>
            <form class="searchbar d-none d-xl-flex ms-auto">
                <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><i class="bi bi-search"></i></div>
                <input class="form-control" type="text" placeholder="Type here to search">
                <div class="position-absolute top-50 translate-middle-y d-block d-xl-none search-close-icon"><i class="bi bi-x-lg"></i></div>
            </form>
            <div class="top-navbar-right ms-3">
              <ul class="navbar-nav align-items-center">
              <li class="nav-item dropdown dropdown-large">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                  <div class="user-setting d-flex align-items-center gap-1">
                    <img src="admin/assets/images/avatars/avatar-1.png" class="user-img" alt="">
                    <div class="user-name d-none d-sm-block">Admin</div>
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                     <a class="dropdown-item" href="#">
                       <div class="d-flex align-items-center">
                          <img src="admin/assets/images/avatars/avatar-1.png" alt="" class="rounded-circle" width="60" height="60">
                          <div class="ms-3">
                            <h6 class="mb-0 dropdown-user-name">Admin</h6>
                            <small class="mb-0 dropdown-user-designation text-secondary">HR Manager</small>
                          </div>
                       </div>
                     </a>
                   </li>
                   <li><hr class="dropdown-divider"></li>
                   <li>
                      <a class="dropdown-item" href="pages-user-profile.html">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="bi bi-person-fill"></i></div>
                           <div class="setting-text ms-3"><span>Hồ sơ</span></div>
                         </div>
                       </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="bi bi-gear-fill"></i></div>
                           <div class="setting-text ms-3"><span>Setting</span></div>
                         </div>
                       </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item" href="authentication-signup-with-header-footer.html">
                         <div class="d-flex align-items-center">
                           <div class="setting-icon"><i class="bi bi-lock-fill"></i></div>
                           <div class="setting-text ms-3"><span>Logout</span></div>
                         </div>
                       </a>
                    </li>
                </ul>
              </li>
              </ul>
              </div>
        </nav>
      </header>
       <!--end top header-->
        <!--start sidebar -->
        <aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
            <div>
              <img src="admin/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
            </div>
            <div>
              <h4 class="logo-text">NHÓM 10</h4>
            </div>
            <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i>
            </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-house-door"></i>
                </div>
                <div class="menu-title">BẢNG ĐIỀU KHIỂN</div>
              </a>
              <ul>
                <li> <a href="index.php?act=admin"><i class="bi bi-arrow-right-short"></i>TỔNG QUAN</a>
                </li>
              </ul>
            </li>
            <li class="menu-label">CHỨC NĂNG</li>
            <li>
              <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-bag-check"></i>
                </div>
                <div class="menu-title">QUẢN LÝ</div>
              </a>
              <ul>
                <li> <a href="index.php?act=category"><i class="bi bi-arrow-right-short"></i>Danh Mục</a></li>
                <li> <a href="index.php?act=category-edit"><i class="bi bi-arrow-right-short"></i>Sửa Danh Mục</a></li>
                <li> <a href="index.php?act=category-add"><i class="bi bi-arrow-right-short"></i>Thêm Danh Mục</a></li>     
                <li> <a href="index.php?act=product"><i class="bi bi-arrow-right-short"></i>Lưới list Sản Phẩm</a></li>
                <!-- <li> <a href="ecommerce-orders.html"><i class="bi bi-arrow-right-short"></i>Đơn Đặt Hàng</a></li> -->
                <!-- <li> <a href="ecommerce-orders-detail.html"><i class="bi bi-arrow-right-short"></i>Chi Tiết Đơn Hàng</a></li> -->
                <li> <a href="index.php?act=product-add"><i class="bi bi-arrow-right-short"></i>Thêm Sản Phẩm</a></li>
                <li> <a href="index.php?act=product-edit"><i class="bi bi-arrow-right-short"></i>Sửa Sản Phẩm</a></li>
                <!-- <li> <a href="ecommerce-transactions.html"><i class="bi bi-arrow-right-short"></i>Giao Dịch</a></li> -->
              </ul>
            </li>
            <li class="menu-label">FORM MẪU</li> 
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-file-earmark-break"></i>
                </div>
                <div class="menu-title">Forms</div>
              </a>
              <ul>
                <li> <a href="form-layouts.html"><i class="bi bi-arrow-right-short"></i>Forms Layouts</a>
                </li>
              </ul>
            </li>
            <li class="menu-label">USER</li>
            <li>
              <a class="has-arrow" href="javascript:;">
                <div class="parent-icon"><i class="bi bi-lock"></i>
                </div>
                <div class="menu-title">Xác Thực</div>
              </a>
              <ul>
                <li> <a href="authentication-signin.html"><i class="bi bi-arrow-right-short"></i>Đăng Nhập</a>
                </li>
                <li> <a href="authentication-signup.html"><i class="bi bi-arrow-right-short"></i>Đăng Ký</a>
                </li>
                <li> <a href="authentication-signin-with-header-footer.html"><i class="bi bi-arrow-right-short"></i>Sign In with Header & Footer</a>
                </li>
                <li> <a href="authentication-signup-with-header-footer.html"><i class="bi bi-arrow-right-short"></i>Sign Up with Header & Footer</a>
                </li>
                <li> <a href="authentication-forgot-password.html"><i class="bi bi-arrow-right-short"></i>Quên Mật Khẩu</a>
                </li>
                <li> <a href="authentication-reset-password.html"><i class="bi bi-arrow-right-short"></i>Đổi Mật Khẩu</a>
                </li>
              </ul>
            </li>
            <li>
              <a href="pages-user-profile.html">
                <div class="parent-icon"><i class="bi bi-person-check"></i>
                </div>
                <div class="menu-title">Tài Khoản</div>
              </a>
            </li>
          </ul>
          <!--end navigation-->
       </aside>
       <!--end sidebar -->
       <!--start content-->