-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 14, 2021 lúc 05:04 AM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `glinkpay_payment`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `author_id` int(11) NOT NULL,
  `uuid` varchar(191) DEFAULT NULL,
  `language` varchar(191) DEFAULT NULL,
  `type` varchar(191) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `short_description` text NOT NULL,
  `description` text NOT NULL,
  `image_preview` text NOT NULL,
  `tags` varchar(191) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `news`
--

INSERT INTO `news` (`id`, `author_id`, `uuid`, `language`, `type`, `parent_id`, `title`, `short_description`, `description`, `image_preview`, `tags`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 1, '6116793ed8ee5', 'vi', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '1628868475.jpg', '', 0, NULL, '2021-08-13 08:39:48'),
(6, 1, '6116793ed8ee5', 'en', NULL, NULL, 'Thủ tướng yêu cầu ưu tiên vaccine về trong tháng 7 cho TP.HCMas d', 'Thủ tướng yêu cầu ưu tiên vaccine về trong tháng 7 cho TP.HCMas d', '<p>Thủ tướng yêu cầu ưu tiên vaccine về trong tháng 7 cho TP.HCMas d<br></p>', '1628868475.jpg', '', 0, NULL, '2021-08-13 08:39:48'),
(178, 1, '6116793ed8ee5', 'ar', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(179, 1, '6116793ed8ee5', 'fr', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(180, 1, '6116793ed8ee5', 'pt', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(181, 1, '6116793ed8ee5', 'ru', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(182, 1, '6116793ed8ee5', 'tr', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(183, 1, '6116793ed8ee5', 'ch', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(184, 1, '6116793ed8ee5', 'af', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(185, 1, '6116793ed8ee5', 'am', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(186, 1, '6116793ed8ee5', 'bg', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(187, 1, '6116793ed8ee5', 'bn', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(188, 1, '6116793ed8ee5', 'es', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(189, 1, '6116793ed8ee5', 'cn', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(190, 1, '6116793ed8ee5', 'de', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(191, 1, '6116793ed8ee5', 'el', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(192, 1, '6116793ed8ee5', 'fi', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(193, 1, '6116793ed8ee5', 'fil', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(194, 1, '6116793ed8ee5', 'ge', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(195, 1, '6116793ed8ee5', 'hi', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(196, 1, '6116793ed8ee5', 'id', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(197, 1, '6116793ed8ee5', 'it', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(198, 1, '6116793ed8ee5', 'ja', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(199, 1, '6116793ed8ee5', 'kur', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(200, 1, '6116793ed8ee5', 'lt', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(201, 1, '6116793ed8ee5', 'lv', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(202, 1, '6116793ed8ee5', 'ms', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(203, 1, '6116793ed8ee5', 'nl', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(204, 1, '6116793ed8ee5', 'pl', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(205, 1, '6116793ed8ee5', 'ro', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(206, 1, '6116793ed8ee5', 'sl', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(207, 1, '6116793ed8ee5', 'sr', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(208, 1, '6116793ed8ee5', 'sv', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48'),
(209, 1, '6116793ed8ee5', 'ur', NULL, NULL, 'Thông tin loại vaccine cho người dân trước khi tiêm', 'Thông tin loại vaccine cho người dân trước khi tiêm', '<p>\r\n\r\n<a target=\"_blank\" rel=\"nofollow\" href=\"https://zingnews.vn/bi-thu-tphcm-thong-tin-loai-vaccine-cho-nguoi-dan-truoc-khi-tiem-post1250723.html\">Thông tin loại vaccine cho người dân trước khi tiêm</a>\r\n\r\n<br></p>', '', '', 0, '2021-08-13 08:37:02', '2021-08-13 08:39:48');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
