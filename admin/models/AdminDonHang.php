<?php
class AdminDonHang
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllDonHang()
    {
        try {
            $sql = 'SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai
                    FROM don_hangs
                    INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
                ';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getAllTrangThaiDonHang()
    {
        try {
            $sql = 'SELECT * FROM trang_thai_don_hangs';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getDetailDonHang($id)
    {
        try {
            $sql = 'SELECT don_hangs.*, trang_thai_don_hangs.ten_trang_thai, 
                                        tai_khoans.ho_ten, tai_khoans.email, 
                                        tai_khoans.so_dien_thoai, tai_khoans.dia_chi, 
                                        phuong_thuc_thanh_toans.ten_phuong_thuc
                 FROM don_hangs
                 INNER JOIN trang_thai_don_hangs ON don_hangs.trang_thai_id = trang_thai_don_hangs.id
                 INNER JOIN tai_khoans ON don_hangs.tai_khoan_id = tai_khoans.id
                 INNER JOIN phuong_thuc_thanh_toans ON don_hangs.phuong_thuc_thanh_toan_id = phuong_thuc_thanh_toans.id
                 WHERE don_hangs.id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }

    public function getListSpDonHang($id)
    {
        try {
            $sql = 'SELECT chi_tiet_don_hangs.*, san_phams.ten_sach 
            FROM chi_tiet_don_hangs
            INNER JOIN san_phams ON chi_tiet_don_hangs.san_pham_id = san_phams.id
            WHERE chi_tiet_don_hangs.don_hang_id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }


    // public function insertSanPham($ten_sach, $gia_sach, $gia_khuyen_mai, $so_luong, $ngay_xuat_ban, $danh_muc_id, $trang_thai, $mo_ta, $hinh_anh)
    // {
    //     try {
    //         $sql = "INSERT INTO san_phams (ten_sach, gia_sach, gia_khuyen_mai, so_luong, ngay_xuat_ban, danh_muc_id, trang_thai, mo_ta, hinh_anh) 
    //                     VALUES (:ten_sach, :gia_sach, :gia_khuyen_mai, :so_luong, :ngay_xuat_ban, :danh_muc_id, :trang_thai, :mo_ta, :hinh_anh)";

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':ten_sach' => $ten_sach,
    //             ':gia_sach' => $gia_sach,
    //             ':gia_khuyen_mai' => $gia_khuyen_mai,
    //             ':so_luong' => $so_luong,
    //             ':ngay_xuat_ban' => $ngay_xuat_ban,
    //             ':danh_muc_id' => $danh_muc_id,
    //             ':trang_thai' => $trang_thai,
    //             ':mo_ta' => $mo_ta,
    //             ':hinh_anh' => $hinh_anh
    //         ]);
    //         // lấy id sản phẩm vừa thêm
    //         return $this->conn->lastInsertId();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function insertAlbumAnhSanPham($san_pham_id, $link_hinh_anh)
    // {
    //     try {
    //         $sql = "INSERT INTO hinh_anh_san_phams (san_pham_id, link_hinh_anh) 
    //                     VALUES (:san_pham_id, :link_hinh_anh)";

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':san_pham_id' => $san_pham_id,
    //             ':link_hinh_anh' => $link_hinh_anh,
    //         ]);
    //         // lấy id sản phẩm vừa thêm
    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }



    // public function getListAnhSanPham($id)
    // {
    //     try {
    //         $sql = 'SELECT * FROM hinh_anh_san_phams WHERE san_pham_id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([':id' => $id]);

    //         return $stmt->fetchAll();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function updateSanPham($san_pham_id, $ten_sach, $gia_sach, $gia_khuyen_mai, $so_luong, $ngay_xuat_ban, $danh_muc_id, $trang_thai, $mo_ta, $hinh_anh)
    // {
    //     try {
    //         $sql = 'UPDATE san_phams
    //                     SET
    //                         ten_sach = :ten_sach,
    //                         gia_sach = :gia_sach,
    //                         gia_khuyen_mai = :gia_khuyen_mai,
    //                         so_luong = :so_luong,
    //                         ngay_xuat_ban = :ngay_xuat_ban,
    //                         danh_muc_id = :danh_muc_id,
    //                         trang_thai = :trang_thai,   
    //                         mo_ta = :mo_ta,
    //                         hinh_anh = :hinh_anh
    //                     WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':ten_sach' => $ten_sach,
    //             ':gia_sach' => $gia_sach,
    //             ':gia_khuyen_mai' => $gia_khuyen_mai,
    //             ':so_luong' => $so_luong,
    //             ':ngay_xuat_ban' => $ngay_xuat_ban,
    //             ':danh_muc_id' => $danh_muc_id,
    //             ':trang_thai' => $trang_thai,
    //             ':mo_ta' => $mo_ta,
    //             ':hinh_anh' => $hinh_anh,
    //             ':id' => $san_pham_id
    //         ]);
    //         // lấy id sản phẩm vừa thêm
    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function getDetailAnhSanPham($id)
    // {
    //     try {
    //         $sql = 'SELECT * FROM hinh_anh_san_phams WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([':id' => $id]);

    //         return $stmt->fetch();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function updateAnhSanPham($id, $new_file)
    // {
    //     try {
    //         $sql = 'UPDATE hinh_anh_san_phams
    //                     SET
    //                         link_hinh_anh = :new_file
    //                     WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':new_file' => $new_file,
    //             ':id' => $id
    //         ]);
    //         // lấy id sản phẩm vừa thêm
    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function destroyAnhSanPham($id)
    // {
    //     try {
    //         $sql = 'DELETE FROM hinh_anh_san_phams WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':id' => $id
    //         ]);

    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function destroySanPham($id)
    // {
    //     try {
    //         $sql = 'DELETE FROM san_phams WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':id' => $id
    //         ]);

    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // // Bình luận
    // public function getBinhLuanFromKhachHang($id)
    // {
    //     try {
    //         $sql = 'SELECT binh_luans.*, san_phams.ten_sach
    //                 FROM binh_luans
    //                 INNER JOIN san_phams ON binh_luans.san_pham_id = san_phams.id
    //                 WHERE binh_luans.tai_khoan_id = :id;
    //             ';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':id' => $id
    //         ]);

    //         return $stmt->fetchAll();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function getDetailBinhLuan($id)
    // {
    //     try {
    //         $sql = 'SELECT * FROM binh_luans WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([':id' => $id]);

    //         return $stmt->fetch();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function updateTrangThaiBinhLuan($id, $trang_thai)
    // {
    //     try {
    //         $sql = 'UPDATE binh_luans
    //                     SET
    //                         trang_thai = :trang_thai
    //                     WHERE id = :id';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':trang_thai' => $trang_thai,
    //             ':id' => $id
    //         ]);
    //         // lấy id sản phẩm vừa thêm
    //         return true;
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }

    // public function getBinhLuanFromSanPham($id)
    // {
    //     try {
    //         $sql = 'SELECT binh_luans.*, tai_khoans.ho_ten
    //                 FROM binh_luans
    //                 INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
    //                 WHERE binh_luans.san_pham_id = :id;
    //             ';

    //         $stmt = $this->conn->prepare($sql);

    //         $stmt->execute([
    //             ':id' => $id
    //         ]);

    //         return $stmt->fetchAll();
    //     } catch (Exception $e) {
    //         echo "Lỗi" . $e->getMessage();
    //     }
    // }
}
