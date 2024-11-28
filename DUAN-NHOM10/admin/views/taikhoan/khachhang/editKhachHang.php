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
                    <h1>Quản Lý Tài Khoản Khách Hàng</h1>
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
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Trạng Thái Tài Khoản : <?= $khachHang['ho_ten']; ?></h3>
                        </div>
                        <form action="<?= BASE_URL_ADMIN . '?act=sua-khach-hang' ?>" method="POST">
                            <input type="hidden" name="khach_hang_id" value="<?= $khachHang['id'] ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputStatus">Trạng thái tài khoản</label>
                                    <select name="trang_thai" id="inputStatus" class="form-control custom-select">
                                        <option <?= $khachHang['trang_thai'] == 1 ? 'selected': '' ?> value="1">Active</option>
                                        <option <?= $khachHang['trang_thai'] !== 1 ? 'selected': '' ?> value="2">Inactive</option>
                                    </select>
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