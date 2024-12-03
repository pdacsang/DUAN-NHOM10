-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 02, 2024 at 09:36 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `du_an_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `binh_luans`
--

CREATE TABLE `binh_luans` (
  `id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `tai_khoan_id` int NOT NULL,
  `noi_dung` text NOT NULL,
  `ngay_dang` date NOT NULL,
  `trang_thai` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `binh_luans`
--

INSERT INTO `binh_luans` (`id`, `san_pham_id`, `tai_khoan_id`, `noi_dung`, `ngay_dang`, `trang_thai`) VALUES
(1, 11, 1, 'Sản phẩm này còn hay không', '2024-11-20', 1),
(2, 12, 2, 'Sản phẩm này sắp ra bản mới hay chưa', '2024-11-19', 1),
(3, 14, 3, 'Sách hay', '2024-11-20', 1);

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_don_hangs`
--

CREATE TABLE `chi_tiet_don_hangs` (
  `id` int NOT NULL,
  `don_hang_id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `don_gia` decimal(10,2) NOT NULL,
  `so_luong` int NOT NULL,
  `thanh_tien` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chi_tiet_don_hangs`
--

INSERT INTO `chi_tiet_don_hangs` (`id`, `don_hang_id`, `san_pham_id`, `don_gia`, `so_luong`, `thanh_tien`) VALUES
(1, 1, 11, '75100.00', 42, '82000.00'),
(2, 2, 12, '55000.00', 12, '60000.00'),
(3, 5, 11, '80000.00', 5, '400000.00'),
(4, 6, 11, '80000.00', 2, '160000.00'),
(5, 6, 12, '75000.00', 2, '150000.00'),
(6, 7, 12, '75000.00', 3, '225000.00'),
(7, 8, 16, '250200.00', 3, '750600.00'),
(8, 9, 11, '80000.00', 3, '240000.00'),
(10, 12, 12, '75000.00', 3, '225000.00'),
(12, 14, 11, '80000.00', 2, '160000.00'),
(13, 15, 12, '75000.00', 1, '75000.00'),
(35, 33, 11, '80000.00', 4, '320000.00');

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_gio_hangs`
--

CREATE TABLE `chi_tiet_gio_hangs` (
  `id` int NOT NULL,
  `gio_hang_id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `so_luong` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chuc_vus`
--

CREATE TABLE `chuc_vus` (
  `id` int NOT NULL,
  `ten_chuc_vu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chuc_vus`
--

INSERT INTO `chuc_vus` (`id`, `ten_chuc_vu`) VALUES
(1, 'Quản Trị Viên'),
(2, 'Khách Hàng');

-- --------------------------------------------------------

--
-- Table structure for table `danh_mucs`
--

CREATE TABLE `danh_mucs` (
  `id` int NOT NULL,
  `ten_danh_muc` varchar(255) NOT NULL,
  `mo_ta` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `danh_mucs`
--

INSERT INTO `danh_mucs` (`id`, `ten_danh_muc`, `mo_ta`) VALUES
(1, 'Sách Lập Trình', 'Dành Cho Người Mới\r\n'),
(2, 'Sách Về Code PHP', 'Nhập Môn PHP'),
(3, 'Sách Code JS', 'Dành Cho Người Mới Dùng JS'),
(7, 'Các cuốn sách giáo khoa', 'Những cuốn sách giáo khoa về lập trình, mạng máy, và hệ thống thông tin.'),
(8, 'Sách tham khảo', 'Những cuốn sách cung cấp kiến thức sâu rộng về các khái niệm'),
(9, 'Sách hướng dẫn', 'Những cuốn sách hướng dẫn cụ thể về cách thực hiện các dự án công nghệ thông tin'),
(10, 'Sách nghiên cứu và tham khảo', 'Những cuốn sách nghiên cứu sâu rộng về các tiêu chuẩn công nghệ'),
(11, 'Sách về công nghệ mới', 'Những cuốn sách nói về các xu hướng công nghệ mới như trí tuệ nhân tạo');

-- --------------------------------------------------------

--
-- Table structure for table `don_hangs`
--

CREATE TABLE `don_hangs` (
  `id` int NOT NULL,
  `tai_khoan_id` int DEFAULT NULL,
  `ma_don_hang` varchar(255) NOT NULL DEFAULT (concat(_utf8mb4'DH',convert(uuid() using utf8mb4))),
  `ten_nguoi_nhan` varchar(255) NOT NULL,
  `email_nguoi_nhan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sdt_nguoi_nhan` varchar(15) NOT NULL,
  `dia_chi_nguoi_nhan` text NOT NULL,
  `ngay_dat` date NOT NULL,
  `tong_tien` decimal(10,0) NOT NULL,
  `ghi_chu` text,
  `phuong_thuc_thanh_toan_id` int NOT NULL,
  `trang_thai_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `don_hangs`
--

INSERT INTO `don_hangs` (`id`, `tai_khoan_id`, `ma_don_hang`, `ten_nguoi_nhan`, `email_nguoi_nhan`, `sdt_nguoi_nhan`, `dia_chi_nguoi_nhan`, `ngay_dat`, `tong_tien`, `ghi_chu`, `phuong_thuc_thanh_toan_id`, `trang_thai_id`) VALUES
(1, 1, '', 'Phí Đắc Sang', 'promaxsang@gmail.com', '0147852396', 'Trịnh Văn Bô, Hà Nội', '2024-11-08', '255000', 'Ship nhanh', 1, 2),
(2, 2, '', 'Bùi Trọng Sơn', 'buitrongson@gmail.com', '0141254445', 'Mỹ Đình, Hà Nội', '2024-11-20', '120000', 'Ship hỏa tốc trong ngày', 2, 1),
(5, 1, 'DH0005', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-11-30', '400000', 'asdasd', 1, 1),
(6, 1, 'DH0006', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-11-30', '310000', '1231231', 1, 1),
(7, 6, 'DH0007', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-11-30', '225000', 'áđá', 1, 1),
(8, 6, 'DH0008', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-11-30', '750600', '123123', 1, 1),
(9, 6, 'DH0009', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-11-30', '240000', '123123', 1, 1),
(12, 6, 'DH0012', 'duy', '123123', '0348653702', 'Nam Từ Liêm', '2024-11-30', '225000', 'áđá', 1, 1),
(14, 6, 'DH0014', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-11-30', '160000', '1231231', 1, 1),
(15, 6, 'DH0015', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-12-01', '280000', '12341234', 1, 1),
(16, 6, 'DH0016', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-12-01', '155000', '123123', 1, 1),
(17, 6, 'DH0017', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-12-01', '240000', '12341234', 1, 1),
(18, 6, 'DH0018', '123412', 'hoangmacphong191223@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-12-01', '240000', '12341234', 1, 1),
(33, 6, 'DH0033', 'duy', 'chubenghocnghech@gmail.com', '0348653702', 'Nam Từ Liêm', '2024-12-01', '320000', '12313', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `gio_hangs`
--

CREATE TABLE `gio_hangs` (
  `id` int NOT NULL,
  `tai_khoan_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hinh_anh_san_phams`
--

CREATE TABLE `hinh_anh_san_phams` (
  `id` int NOT NULL,
  `san_pham_id` int NOT NULL,
  `link_hinh_anh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phuong_thuc_thanh_toans`
--

CREATE TABLE `phuong_thuc_thanh_toans` (
  `id` int NOT NULL,
  `ten_phuong_thuc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `phuong_thuc_thanh_toans`
--

INSERT INTO `phuong_thuc_thanh_toans` (`id`, `ten_phuong_thuc`) VALUES
(1, 'COD(Thanh toán khi nhận hàng)'),
(2, 'Thanh toán VNPay');

-- --------------------------------------------------------

--
-- Table structure for table `san_phams`
--

CREATE TABLE `san_phams` (
  `id` int NOT NULL,
  `ten_sach` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `gia_sach` decimal(10,0) NOT NULL,
  `gia_khuyen_mai` decimal(10,0) DEFAULT NULL,
  `hinh_anh` varchar(255) DEFAULT NULL,
  `so_luong` int NOT NULL,
  `nha_xuat_ban` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `so_trang` varchar(50) DEFAULT NULL,
  `luot_xem` int DEFAULT '0',
  `ngay_xuat_ban` date NOT NULL,
  `mo_ta` text,
  `danh_muc_id` int NOT NULL,
  `trang_thai` tinyint NOT NULL DEFAULT '1',
  `tac_gia_id` int DEFAULT NULL,
  `the_loai_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `san_phams`
--

INSERT INTO `san_phams` (`id`, `ten_sach`, `gia_sach`, `gia_khuyen_mai`, `hinh_anh`, `so_luong`, `nha_xuat_ban`, `so_trang`, `luot_xem`, `ngay_xuat_ban`, `mo_ta`, `danh_muc_id`, `trang_thai`, `tac_gia_id`, `the_loai_id`) VALUES
(11, 'Lập Trình và Cuộc Sống', '80000', '70000', './uploads/1732634140lap-trinh-va-cuoc-song-jeff-atwood-1085065.jpg', 12, 'EduBook', '260', 151, '2015-11-18', 'Sách Mới', 2, 1, 2, 2),
(12, 'Code HTML', '75000', '50000', './uploads/173263744281NBmxCR30L._AC_UF10001000_QL80_.jpg', 16, 'EduBook', '208', 158, '2024-11-01', '242', 1, 1, NULL, NULL),
(14, 'Node js  pro vip', '45000', '40000', './uploads/1732367861Screenshot 2024-06-29 125405.png', 18, 'EduBook', '156', 56, '2024-11-16', 'Hay quá', 3, 1, NULL, NULL),
(15, 'Sách Hướng Nghiệp: Ngành Công nghệ thông tin', '160000', '150000', './uploads/173263444575c43d6fd90a39ea2faf28a9cfc6cbca.jpg.webp', 421, 'EduBook', '265', 265, '2023-02-26', 'Sách Mới Nhập', 9, 1, NULL, NULL),
(16, 'Tiếng Nhật Công Nghệ Thông Tin Trong Ngành Phần Mềm', '250200', '230000', './uploads/1732634608f4562067b4e6461dfd0b829ed3e23d98.jpg.webp', 231, 'EduBook', '264', 322, '2024-11-02', 'Sách Mới', 10, 1, NULL, NULL),
(17, 'How Technology Works - Hiểu Hết Về Công Nghệ', '265942', '245200', './uploads/173263471792e7e40fa501996bf341573aa0a5ab83.jpg.webp', 142, 'EduBook', '253', 242, '2024-11-03', 'Sách Mới', 8, 1, NULL, NULL),
(18, 'Luật Công Nghệ Thông Tin Năm 2006', '20542', '20000', './uploads/17326349938935279163625.webp', 84, 'EduBook', '284', 154, '2023-02-10', 'Mới', 10, 1, NULL, NULL),
(19, 'Tiếng Nhật Công Nghệ Thông Tin Trong Ngành Phần Mềm', '232000', '222000', './uploads/17326351138935280914506.webp', 76, 'EduBook', '264', 231, '2024-11-04', 'Sách Mới', 7, 1, NULL, NULL),
(20, 'Sách Trắng Công Nghệ Thông Tin và Truyền Thông Việt Nam 2018', '79000', '70000', './uploads/1732635320p86544mscan0001_e0bde60f05b8402a8a26a340b90a9977_compact.webp', 45, 'EduBook', '235', 544, '2024-11-06', 'Sách Mới', 10, 1, NULL, NULL),
(21, 'Cuốn Sách Nhỏ - Ý Tưởng Lớn - Công Nghệ Là Gì?', '34800', '34800', './uploads/1732635413cuon-sach-nho-y-tuong-lon_cong-nghe-la-gi_bia.webp', 65, 'EduBook', '235', 232, '2024-11-05', 'Mới', 8, 1, NULL, NULL),
(22, 'Sách IS-BOK 2.0 - Bộ kiến thức cốt lõi về an toàn thông tin', '411389', '411000', './uploads/1732635574vn-11134207-7r98o-lx6mxfzd4ixn53.webp', 49, 'EduBook', '274', 322, '2024-11-07', 'Mới', 10, 1, NULL, NULL),
(23, 'Sách Chuẩn kỹ năng công nghệ thông tin cơ bản (Tập 1)', '91300', '91300', './uploads/1732635764vn-11134207-7r98o-lmft7woefkdbc7.webp', 35, 'EduBook', '235', 235, '2024-11-08', 'mới', 8, 1, NULL, NULL),
(24, 'Sách - An toàn thông tin - Bóng ma trên mạng', '169060', '169060', './uploads/173263592962fd6adc1a2f86efcacd89baee34a3bc.jpg.webp', 45, 'EduBook', '245', 636, '2024-11-09', 'mới', 11, 1, NULL, NULL),
(25, 'Gián Điệp Mạng', '199000', '179000', './uploads/1732635992fee77bfce92bd5aa8ffc24cabe462db4.jpg.webp', 57, 'EduBook', '225', 355, '2024-11-10', 'Mới', 11, 1, NULL, NULL),
(26, 'Lên Mạng Cũng Là Một Nghệ Thuật', '44600', '44600', './uploads/173263607172fedd29380a573671b1da1a0b4558ba.jpg.webp', 81, 'EduBook', '200', 122, '2024-11-11', 'mới', 8, 1, NULL, NULL),
(27, 'Sách - Ứng Dụng Công Nghệ Truy Dấu Tiếp Xúc Để Ứng Phó Với Covid-19 ', '142000', '142000', './uploads/1732636292545039114141553c8c6cac687d798884.jpg.webp', 24, 'EduBook', '242', 311, '2021-07-08', 'mới', 8, 1, NULL, NULL),
(28, 'Sách Hay Về Tin Học: The PARA Method – Phương Pháp Tổ Chức Thông Tin', '134150', '134150', './uploads/17326363830fbde53ad9262944148acb6c6f796aed.jpg.webp', 65, 'EduBook', '230', 244, '2024-11-13', 'Sách Mới', 11, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tac_gia`
--

CREATE TABLE `tac_gia` (
  `id` int NOT NULL,
  `ten_tac_gia` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tac_gia`
--

INSERT INTO `tac_gia` (`id`, `ten_tac_gia`) VALUES
(1, 'Nguyễn Văn A'),
(2, 'Nguyễn Thành B');

-- --------------------------------------------------------

--
-- Table structure for table `tai_khoans`
--

CREATE TABLE `tai_khoans` (
  `id` int NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `anh_dai_dien` varchar(255) DEFAULT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `so_dien_thoai` varchar(10) DEFAULT NULL,
  `gioi_tinh` tinyint(1) DEFAULT NULL,
  `dia_chi` text,
  `mat_khau` varchar(255) NOT NULL,
  `chuc_vu_id` int NOT NULL,
  `trang_thai` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tai_khoans`
--

INSERT INTO `tai_khoans` (`id`, `ho_ten`, `anh_dai_dien`, `ngay_sinh`, `email`, `so_dien_thoai`, `gioi_tinh`, `dia_chi`, `mat_khau`, `chuc_vu_id`, `trang_thai`) VALUES
(1, 'Nguyễn Văn Vũ ', NULL, '2005-02-15', 'nguyenvu@gmail.com', '0321654987', 1, 'Trịnh Văn Bô, Hà Nội', '$2y$10$kmilVXNvaEtKdmOOXmhlgOhnEAT3NLGdLY.bOAkrNoD3C3SMgJaKC', 1, 1),
(2, 'Nguyễn Tương Tú', NULL, '2005-03-20', 'tuongtu@gmail.com', '0123456789', 1, 'Chương Mỹ, Hà Nội', '123456', 2, 2),
(3, 'Phí Đắc Sang', NULL, '2005-06-27', 'phidacsang@gmail.com', '0987654321', 1, 'Hà Nội', '$2y$10$imT.Yo65SOsmBYlQnJWNqORsMQdxcpFKnAFXUfy3uYWSLcoRJ5slm', 2, 2),
(4, 'Lưu Tiến Duy', NULL, '2005-05-24', 'luutienduy@gmail.com', '0987654321', 1, 'Hà Nội', '$2y$10$j0rQ5wrgGLs6x38CSeLEcu3JfW/V3hF.PPT4Tyhwr3cyFlamHB6eu', 2, 2),
(6, 'Lưu Tiến Duy', NULL, NULL, 'chubenghocnghech@gmail.com', NULL, NULL, NULL, '$2y$10$ZJhx06R.H553xiwOOBnGMO2emlCD0XuLjLha6ZqTQzVW6Mz5wMHhy', 2, 1),
(7, 'Lưu Tiến Duy', NULL, NULL, 'nguyenvu1@gmail.com', NULL, NULL, NULL, '$2y$10$RLMYkNAmB6kUAZzCavns1.xEYx3NTAySPVNFdVHbPZ8FE3ABqiKNa', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `the_loai`
--

CREATE TABLE `the_loai` (
  `id` int NOT NULL,
  `ten_the_loai` varchar(225) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `the_loai`
--

INSERT INTO `the_loai` (`id`, `ten_the_loai`) VALUES
(1, 'Nhập Môn CNTT'),
(2, 'Ngành Hẹp CNTT');

-- --------------------------------------------------------

--
-- Table structure for table `trang_thai_don_hangs`
--

CREATE TABLE `trang_thai_don_hangs` (
  `id` int NOT NULL,
  `ten_trang_thai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `trang_thai_don_hangs`
--

INSERT INTO `trang_thai_don_hangs` (`id`, `ten_trang_thai`) VALUES
(1, 'Đã Xác Nhận'),
(2, 'Đang Giao Hàng'),
(3, 'Thành Công');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `binh_luans`
--
ALTER TABLE `binh_luans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lk_sp` (`san_pham_id`),
  ADD KEY `lk_tk` (`tai_khoan_id`);

--
-- Indexes for table `chi_tiet_don_hangs`
--
ALTER TABLE `chi_tiet_don_hangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lk_don_hang` (`don_hang_id`),
  ADD KEY `lk_san_pham` (`san_pham_id`);

--
-- Indexes for table `chi_tiet_gio_hangs`
--
ALTER TABLE `chi_tiet_gio_hangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lk_gio_hang_id` (`gio_hang_id`),
  ADD KEY `lk_spid` (`san_pham_id`);

--
-- Indexes for table `chuc_vus`
--
ALTER TABLE `chuc_vus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `danh_mucs`
--
ALTER TABLE `danh_mucs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `don_hangs`
--
ALTER TABLE `don_hangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ik_id` (`tai_khoan_id`),
  ADD KEY `lk_pttt` (`phuong_thuc_thanh_toan_id`),
  ADD KEY `lk_trang_thai` (`trang_thai_id`);

--
-- Indexes for table `gio_hangs`
--
ALTER TABLE `gio_hangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lk_tk1` (`tai_khoan_id`);

--
-- Indexes for table `hinh_anh_san_phams`
--
ALTER TABLE `hinh_anh_san_phams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lk_id_sp` (`san_pham_id`);

--
-- Indexes for table `phuong_thuc_thanh_toans`
--
ALTER TABLE `phuong_thuc_thanh_toans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `san_phams`
--
ALTER TABLE `san_phams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lk_dm` (`danh_muc_id`);

--
-- Indexes for table `tac_gia`
--
ALTER TABLE `tac_gia`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tai_khoans`
--
ALTER TABLE `tai_khoans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `lk_chuc_vu` (`chuc_vu_id`);

--
-- Indexes for table `trang_thai_don_hangs`
--
ALTER TABLE `trang_thai_don_hangs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `binh_luans`
--
ALTER TABLE `binh_luans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `chi_tiet_don_hangs`
--
ALTER TABLE `chi_tiet_don_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `chi_tiet_gio_hangs`
--
ALTER TABLE `chi_tiet_gio_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chuc_vus`
--
ALTER TABLE `chuc_vus`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `danh_mucs`
--
ALTER TABLE `danh_mucs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `don_hangs`
--
ALTER TABLE `don_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `gio_hangs`
--
ALTER TABLE `gio_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hinh_anh_san_phams`
--
ALTER TABLE `hinh_anh_san_phams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `phuong_thuc_thanh_toans`
--
ALTER TABLE `phuong_thuc_thanh_toans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `san_phams`
--
ALTER TABLE `san_phams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tac_gia`
--
ALTER TABLE `tac_gia`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tai_khoans`
--
ALTER TABLE `tai_khoans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `trang_thai_don_hangs`
--
ALTER TABLE `trang_thai_don_hangs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `binh_luans`
--
ALTER TABLE `binh_luans`
  ADD CONSTRAINT `lk_sp` FOREIGN KEY (`san_pham_id`) REFERENCES `san_phams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_tk` FOREIGN KEY (`tai_khoan_id`) REFERENCES `tai_khoans` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `chi_tiet_don_hangs`
--
ALTER TABLE `chi_tiet_don_hangs`
  ADD CONSTRAINT `lk_don_hang` FOREIGN KEY (`don_hang_id`) REFERENCES `don_hangs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_san_pham` FOREIGN KEY (`san_pham_id`) REFERENCES `san_phams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `chi_tiet_gio_hangs`
--
ALTER TABLE `chi_tiet_gio_hangs`
  ADD CONSTRAINT `lk_gio_hang_id` FOREIGN KEY (`gio_hang_id`) REFERENCES `gio_hangs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_spid` FOREIGN KEY (`san_pham_id`) REFERENCES `san_phams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `don_hangs`
--
ALTER TABLE `don_hangs`
  ADD CONSTRAINT `ik_id` FOREIGN KEY (`tai_khoan_id`) REFERENCES `tai_khoans` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_pttt` FOREIGN KEY (`phuong_thuc_thanh_toan_id`) REFERENCES `phuong_thuc_thanh_toans` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `lk_trang_thai` FOREIGN KEY (`trang_thai_id`) REFERENCES `trang_thai_don_hangs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `gio_hangs`
--
ALTER TABLE `gio_hangs`
  ADD CONSTRAINT `lk_tk1` FOREIGN KEY (`tai_khoan_id`) REFERENCES `tai_khoans` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `hinh_anh_san_phams`
--
ALTER TABLE `hinh_anh_san_phams`
  ADD CONSTRAINT `lk_id_sp` FOREIGN KEY (`san_pham_id`) REFERENCES `san_phams` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `san_phams`
--
ALTER TABLE `san_phams`
  ADD CONSTRAINT `lk_dm` FOREIGN KEY (`danh_muc_id`) REFERENCES `danh_mucs` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `tai_khoans`
--
ALTER TABLE `tai_khoans`
  ADD CONSTRAINT `lk_chuc_vu` FOREIGN KEY (`chuc_vu_id`) REFERENCES `chuc_vus` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
