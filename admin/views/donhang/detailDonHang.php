<!-- header -->
<?php include './views/layout/header.php'; ?>
<!-- Navbar -->
<?php include './views/layout/navbar.php'; ?>

<!-- /.navbar -->

<!-- Main Sidebar Container -->
<?php include './views/layout/sidebar.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản Lý - Đơn Hàng: <?= $donHang['ma_don_hang'] ?></h1>
                </div>
                <div>
                    <form action="" method="POST">
                        <select name="" id="">
                            <option value=""></option>
                        </select>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <?php
                        if($donHang['trang_thai_id'] == 1){
                            $colorAlerts = 'primary';
                        }elseif($donHang['trang_thai_id'] == 2){
                            $colorAlerts = 'success';
                        }else{
                            $colorAlerts = 'danger';
                        }
                    ?>
                    <div class="alert alert-<?= $colorAlerts; ?>" role="alert">
                        Đơn Hàng: <?= $donHang['ten_trang_thai'] ?>
                    </div>


                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-book-open"></i> Shop Bán Sách Chuyên Ngành CNTT
                                    <small class="float-right">Ngày Đặt: <?= $donHang['ngay_dat'] ?></small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                <h3>Thông Tin Người Đặt</h3>
                                <address>
                                    <strong><?= $donHang['ho_ten'] ?></strong><br>
                                    Email: <?= $donHang['email'] ?><br>
                                    Số Điện Thoại: <?= $donHang['so_dien_thoai'] ?><br>
                                    Địa Chỉ: <?= $donHang['dia_chi'] ?><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <h3>Người Nhận</h3>
                                <address>
                                    <strong><?= $donHang['ten_nguoi_nhan'] ?></strong><br>
                                    Email: <?= $donHang['email_nguoi_nhan'] ?><br>
                                    Số Điện Thoại: <?= $donHang['sdt_nguoi_nhan'] ?><br>
                                    Địa Chỉ: <?= $donHang['dia_chi_nguoi_nhan'] ?><br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <h3>Thông Tin Đơn Hàng</h3>
                                <address>
                                    <strong>Mã Đơn Hàng: <?= $donHang['ma_don_hang'] ?></strong><br>
                                    Tổng Tiền: <?= $donHang['tong_tien'] ?><br>
                                    Ghi Chú: <?= $donHang['ghi_chu'] ?><br>
                                    PT Thanh Toán: <?= $donHang['ten_phuong_thuc'] ?><br>
                                </address>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tên Sách</th>
                                            <th>Đơn Giá</th>
                                            <th>Số Lượng</th>
                                            <th>Thành Tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $tong_tien = 0; ?>
                                        <?php foreach($sanPhamDonHang as $key=>$sanPham) : ?>
                                            <tr>
                                                <td><?= $key+1 ?></td>
                                                <td><?= $sanPham['ten_sach'] ?></td>
                                                <td><?= $sanPham['don_gia'] ?></td>
                                                <td><?= $sanPham['so_luong'] ?></td>
                                                <td><?= $sanPham['thanh_tien'] ?></td>
                                            </tr>
                                            <?php $tong_tien += $sanPham['thanh_tien']; ?>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            
                            <!-- /.col -->
                            <div class="col-6">
                                <p class="lead">Ngày Đặt Hàng: <?= $donHang['ngay_dat'] ?></p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Thành Tiền:</th>
                                            <td>
                                                <?= $tong_tien ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Vận Chuyển:</th>
                                            <td>50.000</td>
                                        </tr>
                                        <tr>
                                            <th>Tổng Tiền:</th>
                                            <td><?= $tong_tien + 50000 ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->


<!-- Footer -->
<?php include './views/layout/footer.php'; ?>
<!-- End footer -->


<!-- Page specific script -->
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>
<!-- Code injected by live-server -->

</body>

</html>