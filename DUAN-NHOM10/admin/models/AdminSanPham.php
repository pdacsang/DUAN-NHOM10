<?php
class AdminSanPham
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllSanPham()
    {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc, the_loai.ten_the_loai
                FROM san_phams
                INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                INNER JOIN the_loai ON san_phams.the_loai_id = the_loai.id';
            $stml = $this->conn->prepare($sql);
            $stml->execute();

            return $stml->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function insertSanPham(
        $ten_sach,
        $gia_sach,
        $gia_khuyen_mai,
        $so_luong,
        $ngay_xuat_ban,
        $danh_muc_id,
        $trang_thai,
        $the_loai_id,
        $mo_ta,
        $hinh_anh
    ) {
        try {
            $sql = 'INSERT INTO san_phams(ten_sach, gia_sach, 
                                    gia_khuyen_mai, so_luong, 
                                    ngay_xuat_ban, danh_muc_id, 
                                    trang_thai, the_loai_id ,
                                    mo_ta, hinh_anh)
                        VALUES (san_phams(:ten_sach, :gia_sach, 
                                    :gia_khuyen_mai, :so_luong, 
                                    :ngay_xuat_ban, :danh_muc_id, 
                                    :trang_thai, :the_loai_id ,
                                    :mo_ta, :hinh_anh)';
            // var_dump($sql); die;
            $stml = $this->conn->prepare($sql);

            $stml->execute([
                ':ten_sach' => $ten_sach,
                ':gia_sach' => $gia_sach,
                ':gia_khuyen_mai' => $gia_khuyen_mai,
                ':so_luong' => $so_luong,
                ':ngay_xuat_ban' => $ngay_xuat_ban,
                ':danh_muc_id' => $danh_muc_id,
                ':trang_thai' => $trang_thai,
                ':the_loai_id' => $the_loai_id,
                ':mo_ta' => $mo_ta,
                ':hinh_anh' => $hinh_anh,
            ]);
            // lấy id sản phẩm vừa thêm
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}
