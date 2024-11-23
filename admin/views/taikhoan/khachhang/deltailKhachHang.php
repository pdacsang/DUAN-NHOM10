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
                <div class="col-6">
                    <img src="<?= BASE_URL . $khachHang['anh_dai_dien'] ?>" style="width: 70%" alt=""
                    onerror="this.onerror=null; this.src='https://e7.pngegg.com/pngimages/178/595/png-clipart-user-profile-computer-icons-login-user-avatars-monochrome-black.png'">
                </div>
                <div class="col-6">
                    <div class="container">
                    <table class="table table-borderless">
                        <tbody style="font-size: large;">
                            <tr>
                                <th>Họ tên :</th>
                                <td><?= $khachHang['ho_ten'] ?? '' ?></td>
                            </tr>
                            <tr>
                                <th>Ngày sinh :</th>
                                <td><?= $khachHang['ngay_sinh'] ?? '' ?></td>
                            </tr>
                            <tr>
                                <th>Email : </th>
                                <td><?= $khachHang['email'] ?? '' ?></td>
                            </tr>
                            <tr>
                                <th>Số điện thoại : </th>
                                <td><?= $khachHang['so_dien_thoai'] ?? '' ?></td>
                            </tr>
                            <tr>
                                <th>Giới tính : </th>
                                <td><?= $khachHang['gioi_tinh'] == 1 ? 'Nam': 'Nữ'; ?></td>
                            </tr>
                            <tr>
                                <th>Địa chỉ : </th>
                                <td><?= $khachHang['dia_chi'] ?? '' ?></td>
                            </tr>
                            <tr>
                                <th>Trạng thái : </th>
                                <td><?= $khachHang['trang_thai'] == 1 ? 'Active': 'Inactive'; ?></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                    <h2>Lịch Sử Mua Hàng</h2>
                    <div>
                    <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Mã Đơn Hàng</th>
                    <th>Tên Người Nhận</th>
                    <th>Số Điện Thoại</th>
                    <th>Ngày Đặt</th>
                    <th>Tổng Tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listDonHang as $key => $donHang) : ?>
                    <tr>
                      <td><?= $key + 1 ?></td>
                      <td><?= $donHang['ma_don_hang'] ?></td>
                      <td><?= $donHang['ten_nguoi_nhan'] ?></td>
                      <td><?= $donHang['sdt_nguoi_nhan'] ?></td>
                      <td><?= $donHang['ngay_dat'] ?></td>
                      <td><?= $donHang['tong_tien'] ?></td>
                      <td><?= $donHang['ten_trang_thai'] ?></td>
                      <td>
                        <div class="btn-group">
                          <a href="<?= BASE_URL_ADMIN . '?act=chi-tiet-don-hang&id_don_hang=' . $donHang['id'] ?>">
                            <button class="btn btn-primary"><i class="far fa-eye"></i></button>
                          </a>
                          <a href="<?= BASE_URL_ADMIN . '?act=form-sua-don-hang&id_don_hang=' . $donHang['id'] ?>">
                            <button class="btn btn-warning"><i class="fas fa-cog"></i></button>
                          </a>
                        </div>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                    <h2>Lịch Sử Bình Luận Khách Hàng</h2>
                    <div>
                    <table id="example2" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Sản Phẩm</th>
                    <th>Nội dung</th>
                    <th>Ngày bình luận</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($listBinhLuan as $key => $binhLuan) : ?>
                    <tr>
                      <td><?= $key + 1 ?></td>
                      <td><a target="_blank" href="<?= BASE_URL_ADMIN . '?act=chi-tiet-san-pham&id_san_pham=' .$binhLuan['san_pham_id']; ?>"><?= $binhLuan['ten_sach'] ?></a></td>
                      <td><?= $binhLuan['noi_dung'] ?></td>
                      <td><?= $binhLuan['ngay_dang'] ?></td>
                      <td><?= $binhLuan['trang_thai'] == 1 ? 'Hiển thị' : 'Bị Ẩn' ?></td>
                      <td>
                        <form action="<?= BASE_URL_ADMIN . '?act=update-trang-thai-binh-luan' ?>" method="POST">
                          <input type="hidden" name="id_binh_luan" value="<?= $binhLuan['id'] ?>">
                          <input type="hidden" name="name_view" value="detail_khach">
                          <button onclick="return confirm('Bạn Có muốn ẩn bình luận này  không?')" class="btn btn-warning">
                            <?= $binhLuan['trang_thai'] == 1 ? 'Ẩn': 'Bỏ ẩn' ?>
                          </button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
                    </div>
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
<script>
    $(function () {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $("#example2").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
    });
});
</script>
</html>