
<header id="header">
        <!-- header top -->
        <div class="header__top">
            <div class="container">
                <section class="row flex">
                    <div class="col-lg-5 col-md-0 col-sm-0 heade__top-left">
                        <span>EduBook - Cội nguồn của tri thức</span>
                    </div>

                    <nav class="col-lg-7 col-md-0 col-sm-0 header__top-right">
                        <ul class="header__top-list">
                            <li class="header__top-item">
                                <a href="#" class="header__top-link">

                                Hỏi đáp</a>
                            </li>
                            <li class="header__top-item">
                                <a href="#" class="header__top-link">Hướng dẫn</a>
                            </li>
                            <li class="header__top-item">
                                <a href="#" class="header__top-link">Đăng ký</a>
                            </li>
                            <li class="header__top-item">
                                <a href="#" class="header__top-link">Đăng nhập</a>
                            </li>
                        </ul>
                    </nav>
                </section>
            </div>
        </div>
        <!--end header top -->

        <!-- header bottom -->
        <div class="header__bottom">
            <div class="container">
                <section class="row">
                    <div class="col-lg-3 col-md-4 col-sm-12 header__logo">
                        <h1 class="header__heading">
                            <a href="#" class="header__logo-link">
                                <img src="./assets/images1/logo1.png" alt="Logo" class="header__logo-img">
                            </a>
                        </h1>
                    </div>

                    <div class="col-lg-6 col-md-7 col-sm-0 header__search">
                        <select name="" id="" class="header__search-select">
                            <option value="0">All</option>
                            <option value="1">Sách tiếng việt</option>
                            <option value="2">Sách sách nước ngoài</option>
                            <option value="3">Manga-Comic</option>
                            
                        </select>
                        <input type="text" class="header__search-input" placeholder="Tìm kiếm tại đây...">
                        <button class="header__search-btn">
                            <div class="header__search-icon-wrap">
                                <i class="fas fa-search header__search-icon"></i>
                            </div>
                        </button>
                    </div>

                    <div class="col-lg-2 col-md-0 col-sm-0 header__call">
                        <div class="header__call-icon-wrap">
                            <i class="fas fa-phone-alt header__call-icon"></i>  
                        </div>
                        <div class="header__call-info">
                            <div class="header__call-text">
                                Gọi điện tư vấn
                            </div>
                            <div class="header__call-number">
                                039.882.3232
                            </div>
                        </div>
                    </div>

                    <a href="cart.html" class="col-lg-1 col-md-1 col-sm-0 header__cart">
                        <div class="header__cart-icon-wrap">
                            <span class="header__notice">4</span>
                            <i class="fas fa-shopping-cart header__nav-cart-icon"></i>
                        </div>
                    </a>
                </section>
            </div>   
        </div>
        <!--end header bottom -->

        <!-- header nav -->
        <div class="header__nav">
            <div class="container">
                <section class="row">
                
                <div class="header__nav-menu-wrap col-lg-3 col-md-0 col-sm-0">
                <i class="fas fa-bars header__nav-menu-icon">
    <div id="dropdownMenu" class="header__nav-menu hidden">
        <select onchange="location = this.value;">
            <option value="index.php?act=productByCategory" <?= empty($_GET['danh_muc_id']) ? 'selected' : '' ?>>
                Tất cả
            </option>
            <?php if (isset($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <option 
                        value="index.php?act=productByCategory&danh_muc_id=<?= $category['id'] ?>" 
                        <?= (isset($_GET['danh_muc_id']) && $_GET['danh_muc_id'] == $category['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['ten_danh_muc']) ?>
                    </option>
                <?php endforeach; ?>
            <?php else: ?>
                <option disabled>Không có danh mục</option>
            <?php endif; ?>
        </select>
    </div>
</i>

<style>
    .header__nav-menu {
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        z-index: 1000;
    }

    .hidden {
        display: none;
    }

    .fas.fa-bars {
        cursor: pointer;
        font-size: 24px;
    }
</style>
<div class="header__nav-menu-title">Danh mục sản phẩm</div>
<script>
    const menuIcon = document.querySelector(".header__nav-menu-icon");
const dropdownMenu = document.getElementById("dropdownMenu");

menuIcon.addEventListener("mouseover", () => {
    dropdownMenu.classList.remove("hidden");
});

menuIcon.addEventListener("mouseout", (e) => {
    if (!menuIcon.contains(e.relatedTarget)) {
        dropdownMenu.classList.add("hidden");
    }
});
dropdownMenu.addEventListener("mouseout", (e) => {
    if (!menuIcon.contains(e.relatedTarget)) {
        dropdownMenu.classList.add("hidden");
    }
});
</script>
    
</div>




                    <div class="header__nav col-lg-9 col-md-0 col-sm-0">
                        <ul class="header__nav-list">
                            <li class="header__nav-item">
                                <a href="index.php" class="header__nav-link">Trang chủ</a>
                            </li>
                            <li class="header__nav-item">
                                <a href="index.php?act=productByCategory" class="header__nav-link">Danh mục sản phẩm</a>
                                
                            </li>
                            <li class="header__nav-item">
                                <a href="product.html" class="header__nav-link">Sản phẩm</a>
                            </li>
                            <li class="header__nav-item">
                                <a href="post.html" class="header__nav-link">Bài viết</a>
                            </li>
                            <li class="header__nav-item">
                                <a href="#" class="header__nav-link">Tuyển cộng tác viên</a>
                            </li>
                            <li class="header__nav-item">
                                <a href="contact.html" class="header__nav-link">Liên hệ</a>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </header>
    <!--end header nav -->