<?php require_once './views/layout/header.php' ?>
<?php require_once './views/layout/navbar.php' ?>
<?php require_once './views/layout/sidebar.php' ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-11">
                    <h1>Quản Lý Danh Sách Sản Phẩm</h1>
                </div>
                <div class="col-sm-1">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class=" col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Thêm Sản Phẩm</h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=them-san-pham' ?>" method="POST" enctype="multipart/form-data">
                            <div class="card-body row">
                                <div class="form-group col-6">
                                    <label">Tên sản phẩm</label>
                                        <input type="text" class="form-control" name="ten_sach" placeholder="Nhập tên sản phẩm">
                                        <?php if (isset($_SESSION['error']['ten_sach'])) { ?>
                                            <p class="text-danger"><?= $_SESSION['error']['ten_sach'] ?></p>
                                        <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label">Giá sản phẩm</label>
                                        <input type="number" class="form-control" name="gia_sach" placeholder="Nhập giá sản phẩm">
                                        <?php if (isset($_SESSION['error']['gia_sach'])) { ?>
                                            <p class="text-danger"><?= $_SESSION['error']['gia_sach'] ?></p>
                                        <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label">Giá khuyến mãi</label>
                                        <input type="number" class="form-control" name="gia_khuyen_mai" placeholder="Nhập giá khuyến mãi">
                                        <?php if (isset($_SESSION['error']['gia_khuyen_mai'])) { ?>
                                            <p class="text-danger"><?= $_SESSION['error']['gia_khuyen_mai'] ?></p>
                                        <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label">Số lượng</label>
                                        <input type="number" class="form-control" name="so_luong" placeholder="Nhập số lượng">
                                        <?php if (isset($_SESSION['error']['so_luong'])) { ?>
                                            <p class="text-danger"><?= $_SESSION['error']['so_luong'] ?></p>
                                        <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label">Hình ảnh</label>
                                        <input type="file" class="form-control" name="hinh_anh">
                                        <?php if (isset($_SESSION['error']['hinh_anh'])) { ?>
                                            <p class="text-danger"><?= $_SESSION['error']['hinh_anh'] ?></p>
                                        <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label">Album ảnh</label>
                                        <input type="file" class="form-control" name="img_array[]" multiple>
                                </div>

                                <div class="form-group col-6">
                                    <label">Ngày nhập</label>
                                        <input type="date" class="form-control" name="ngay_xuat_ban" placeholder="Ngày xuất bản">
                                        <?php if (isset($_SESSION['error']['ngay_xuat_ban'])) { ?>
                                            <p class="text-danger"><?= $_SESSION['error']['ngay_xuat_ban'] ?></p>
                                        <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label">Danh mục</label>
                                        <select class="form-control" name="danh_muc_id" id="exampleFromControlSelect1">
                                            <option selected disabled>Chọn danh mục sản phẩm</option>
                                            <?php foreach ($listDanhMuc as $danhMuc): ?>
                                                <option value="<?= $danhMuc['id'] ?>"><?= $danhMuc['ten_danh_muc'] ?></option>
                                            <?php endforeach ?>
                                        </select>
                                        <?php if (isset($_SESSION['error']['danh_muc_id'])) { ?>
                                            <p class="text-danger"><?= $_SESSION['error']['danh_muc_id'] ?></p>
                                        <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label">Trạng thái</label>
                                        <select class="form-control" name="trang_thai" id="exampleFromControlSelect1">
                                            <option selected disabled>Chọn danh mục trạng thái</option>
                                            <option value="1">Còn Hàng</option>
                                            <option value="2">Hết Hàng</option>
                                        </select>
                                        <?php if (isset($_SESSION['error']['trang_thai'])) { ?>
                                            <p class="text-danger"><?= $_SESSION['error']['trang_thai'] ?></p>
                                        <?php } ?>
                                </div>

                                <div class="form-group col-6">
                                    <label">Thể loại</label>
                                        <input type="text" class="form-control" name="the_loai_id" placeholder="Nhập thể loại">
                                        <?php if (isset($_SESSION['error']['the_loai_id'])) { ?>
                                            <p class="text-danger"><?= $_SESSION['error']['the_loai_id'] ?></p>
                                        <?php } ?>
                                </div>

                                <div class="form-group col-12">
                                    <label">Mô Tả</label>
                                        <textarea name="mo_ta" class="form-control" placeholder="Nhập mô tả"></textarea>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php require_once './views/layout/footer.php' ?>
</body>

</html>