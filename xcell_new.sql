-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 14, 2018 at 02:12 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xcell_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `item_id` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dealer_authentication`
--

CREATE TABLE `dealer_authentication` (
  `id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `dealer_code` varchar(50) NOT NULL,
  `password` varchar(190) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2018_01_30_100313_create_tbl_role_table', 1),
(9, '2018_01_30_100451_create_tbl_permission_table', 1),
(10, '2018_01_30_100838_create_tbl_role_permission_table', 1),
(11, '2018_01_30_100932_create_tbl_user_role_table', 1),
(12, '2018_02_13_050025_create_tbl_product_category_table', 1),
(13, '2018_02_13_050302_create_tbl_product_table', 1),
(14, '2018_02_13_050532_create_tbl_product_color_table', 1),
(15, '2018_02_13_050622_create_tbl_product_image_table', 1),
(16, '2018_02_13_114606_tbl_retailer', 1),
(17, '2018_02_13_115419_tbl_city', 1),
(19, '2018_02_13_120022_tbl_retailer_outlet', 1),
(20, '2018_02_21_044651_create_tbl_department_table', 1),
(21, '2018_02_21_044747_create_tbl_staff_type_table', 1),
(22, '2018_02_21_044847_create_tbl_designation_table', 1),
(23, '2018_02_21_050155_create_tbl_staff_table', 1),
(24, '2018_02_22_092613_tbl_manufacturing_order', 1),
(25, '2018_02_22_093409_tbl_manufacturing_status', 1),
(26, '2018_02_22_094626_tbl_currency', 1),
(27, '2018_02_22_095727_tbl_payment_type', 1),
(28, '2018_02_22_100134_tbl_recieve_status', 1),
(29, '2018_02_22_100637_tbl_recieve_status_log', 1),
(30, '2018_02_22_100959_tbl_recieve', 1),
(31, '2018_02_22_101844_tbl_receive_products', 1),
(32, '2018_02_22_112738_tbl_manufacturing_order_product', 1),
(33, '2018_02_22_132546_tbl_manufacturing_payment', 1),
(34, '2018_02_27_063840_create_tbl_imei_table', 1),
(35, '2018_02_27_104629_create_tbl_warehouse_type_table', 1),
(37, '2018_03_05_063755_create_tbl_item_table', 1),
(38, '2018_03_06_103353_create_tbl_main_warehouse_receive_product_table', 1),
(39, '2018_03_06_103420_create_tbl_main_warehouse_receive_item_table', 1),
(40, '2018_03_06_103507_create_tbl_main_warehouse_receive_table', 1),
(41, '2018_03_06_103608_create_tbl_warehouse_stock_table', 1),
(42, '2018_03_07_064705_retailer_orders', 1),
(43, '2018_03_07_070030_retailer_order_products', 1),
(44, '2018_03_07_070658_retailer_order_status', 1),
(45, '2018_03_07_113918_create_tbl_warehouse_staff_table', 1),
(46, '2018_03_14_142258_create_tbl_warehouse_issue_table', 1),
(47, '2018_03_14_144715_create_tbl_warehouse_issue_items_table', 1),
(48, '2018_03_15_080521_tbl_invoice', 1),
(49, '2018_03_15_081337_tbl_discount_type', 1),
(50, '2018_03_15_081348_tbl_invoice_type', 1),
(51, '2018_03_15_085822_tbl_invoice_products', 1),
(52, '2018_03_15_111940_tbl_retailer_collection', 1),
(53, '2018_03_15_115152_tbl_ledger', 1),
(54, '2018_02_27_120632_create_tbl_warehouse_table', 1),
(55, '2018_03_28_091811_bank', 1),
(56, '2018_04_02_113028_create_tbl_invoice_reverse_items_table', 2),
(57, '2018_02_13_115626_tbl_region', 3),
(58, '2018_04_05_121333_create_tbl__warehouse__transfer_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('09a32d350052d58afa763c605a90b0786e1ce0a6fdf2b269b0053e47e6ed1368e94fe08c54febf65', 21, 1, 'MyApp', '[]', 1, '2018-05-24 05:44:28', '2018-05-24 05:44:28', '2019-05-24 10:44:28'),
('0d8fac1bcdd22bf3467ad31f8cd3253210cc5cbbbf60182f4dca8839a46deee48c8156de9067f033', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:23:26', '2018-05-31 05:23:26', '2019-05-31 10:23:26'),
('0e79353812fa2b2b0f2d9775ed9935ddc5a87561ff4d13ecc4f4199aa1eb5cb4a28295f6b2736991', 21, 1, 'MyApp', '[]', 0, '2018-05-31 06:24:46', '2018-05-31 06:24:46', '2019-05-31 11:24:46'),
('0f74c27208c9559e023ca162543e78149278d7f989fc8238fd51ae3ee34e5807fb7e0b021095fe7b', 21, 1, 'MyApp', '[]', 1, '2018-05-24 05:48:39', '2018-05-24 05:48:39', '2019-05-24 10:48:39'),
('13451342ed7e97e59dc48f5bdf4412f4d3a918c92582387f4f1c8686db089cb510041773404138cd', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:53:30', '2018-05-31 05:53:30', '2019-05-31 10:53:30'),
('1d51d858ee6d2d5bb0fa315fab253a76fa0accbf5016e3289b87b0dcff95cf55821cf300a7ca91ff', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:50:17', '2018-05-31 02:50:17', '2019-05-31 07:50:17'),
('1dcbd65892bc491fa192c08e9ea4ebe140c73930313ff411d4cf8d03cc5ce3595216be560618e849', 21, 1, 'MyApp', '[]', 0, '2018-06-01 01:17:27', '2018-06-01 01:17:27', '2019-06-01 06:17:27'),
('22565f43c6aaa709a8d82dea0559fa4d49fb6dabdcfec76e44b1583faca99f2de59ebd04246a6988', 21, 1, 'MyApp', '[]', 0, '2018-06-05 05:09:28', '2018-06-05 05:09:28', '2019-06-05 10:09:28'),
('2260a08af142b7515d96914ae3604471424e094c9fe57625e297a9187478083e1c9c6b1fe850e27b', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:24:15', '2018-05-31 05:24:15', '2019-05-31 10:24:15'),
('279cdf2728f6feeea32e4d80336b915756935c311345682d9430630c087062fc1ec2d43d7a6d2e59', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:53:16', '2018-05-31 02:53:16', '2019-05-31 07:53:16'),
('2889a25ab006f9b6f15e6628fa971ab0a50ec016febb7a75bc9c786ff73b7458e968acb186f3bf0c', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:51:26', '2018-05-31 02:51:26', '2019-05-31 07:51:26'),
('28c40dfa6b1bf1276d845cf625b3c11e13d14c6cc0208dc7ee0af8e85ba7069e3a1e2273bc2ea9c5', 21, 1, 'MyApp', '[]', 0, '2018-05-31 03:36:59', '2018-05-31 03:36:59', '2019-05-31 08:36:59'),
('2a1d533d82a9d2c11491a6e14364be4c0ba873f7fe13a966c3c7cbbcad83f22090eaee00db0179c7', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:55:47', '2018-05-31 02:55:47', '2019-05-31 07:55:47'),
('2a2d43ff3fc9c2ba84956c6eb75f662f7fd6d89c07a491db785fc6bb35933404eb53fa1cb4fb6544', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:56:50', '2018-05-31 05:56:50', '2019-05-31 10:56:50'),
('2c0742caf87cd2b11886ebb1b06e5fa5e17530f6eb00431ba52e76488aef0256117d1219770393b7', 21, 1, 'MyApp', '[]', 0, '2018-05-31 06:16:34', '2018-05-31 06:16:34', '2019-05-31 11:16:34'),
('313de1000ce71f4f17449bcb6e3396ac924950c541da2fb1167051de463865c8e95dea8453659680', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:07:59', '2018-05-31 05:07:59', '2019-05-31 10:07:59'),
('32a37f48f9f5bab1626815106e27d3a8fed40e96f1cfc31dad532d340feb071f17455228c5deb974', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:07:15', '2018-05-24 06:07:15', '2019-05-24 11:07:15'),
('36884491a4f9202745c1f1003226ce82edd4dee7e17beeae5c3f853c967264d66f07f431b6381000', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:41:42', '2018-05-31 02:41:42', '2019-05-31 07:41:42'),
('39dea10bf47b92b413ab5b541923bbfccf918e01fbc6d1b928ab608d07ac8af812344180eb61cd8d', 21, 1, 'MyApp', '[]', 0, '2018-05-29 04:54:13', '2018-05-29 04:54:13', '2019-05-29 09:54:13'),
('39edc60b792e15e2db6e0f8a2079db91d41ad122b65589af0bbbaf99ccc3c9f640bd3a57520e0cfb', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:06:08', '2018-05-24 06:06:08', '2019-05-24 11:06:08'),
('3b155df1135cd416269f8c88e332af8967be541ecc05b5c1f41574403a917827f917aff03864f9fd', 21, 1, 'MyApp', '[]', 0, '2018-05-30 05:13:16', '2018-05-30 05:13:16', '2019-05-30 10:13:16'),
('3b7a691925fccf2623ce3aeb68effb72ec88dfe38c36b0608babef48fdfdfcfa87a459830a1f6f37', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:51:37', '2018-05-24 06:51:37', '2019-05-24 11:51:37'),
('3c78d9a82fd2869cdf4bd4376a7a318497e4ab562255c57dc5b8106ff502cd0dc0ec533f8230a38d', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:37:16', '2018-05-31 05:37:16', '2019-05-31 10:37:16'),
('3e61aba7a338f8d8ae772f34f6b5028b08b9251ea65fe77157a35db48781328f57621d8ffc13aacb', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:08:54', '2018-05-24 06:08:54', '2019-05-24 11:08:54'),
('3f900562a3a469c54388ffc16d2cec9a0a3c805f447a1c55e8eeda7ce273b8a9596631f715b72dfb', 21, 1, 'MyApp', '[]', 0, '2018-05-31 03:49:12', '2018-05-31 03:49:12', '2019-05-31 08:49:12'),
('4239f5f6b3f1d663a035b5a9a08ca0e41e330fd3713bcbe518ec7ccfbd03359b052892ab47afb1f9', 21, 1, 'MyApp', '[]', 0, '2018-05-31 06:27:08', '2018-05-31 06:27:08', '2019-05-31 11:27:08'),
('4801b7afa4844c57ca4df6ba18a8cdad388993365bc69360fa9c36e9bf094ecd3bc36aa0cb0a1301', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:02:16', '2018-05-31 02:02:16', '2019-05-31 07:02:16'),
('4cd70715284797a7e51d9802fd066be2bbca2a664c9b0196f15abc64e71783ebf5d7e728161b99a9', 21, 1, 'MyApp', '[]', 0, '2018-06-01 05:35:04', '2018-06-01 05:35:04', '2019-06-01 10:35:04'),
('4d44ea71e94879a137c869d9c5d059ba9a46e4679ecf7151bd5660ecd5348e8e2752fb6cc07efb3f', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:02:25', '2018-05-31 02:02:25', '2019-05-31 07:02:25'),
('4ee69e731281319f509cd0d3e6fdc8311c9d424cc9da8794aae103359e12c1532e4fbaa509c466ba', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:08:00', '2018-05-24 06:08:00', '2019-05-24 11:08:00'),
('4ef9e286df5304425acac04c849f4beee1b1e65e7fa6f504cf6d1dca35991cb99d2c9f640d74b8bf', 21, 1, 'MyApp', '[]', 0, '2018-06-01 03:05:53', '2018-06-01 03:05:53', '2019-06-01 08:05:53'),
('50c296669fa7d90bdddbd67c36e1af573dd99c20fd9d046c3bd60437e93344fa6417409501aba8d0', 21, 1, 'MyApp', '[]', 0, '2018-05-30 03:38:20', '2018-05-30 03:38:20', '2019-05-30 08:38:20'),
('54ac6ab010c35b9b9d3ef64ce8e0ebded60f8c435a308552642ef3b32d32b0e1c778f40ee647db59', 21, 1, 'MyApp', '[]', 0, '2018-05-30 03:14:37', '2018-05-30 03:14:37', '2019-05-30 08:14:37'),
('5722c4b840386a56b45669e3128b3c556062b8fc2afe1fe3af43450e9f111ec9f9558d4f54311f1c', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:54:36', '2018-05-31 02:54:36', '2019-05-31 07:54:36'),
('576ebbd46e05cf16f1fe267bbda9878b2e7c00040221df3ce343ec78356396e5cc8c7bc0cf8180fb', 21, 1, 'MyApp', '[]', 0, '2018-06-01 05:40:04', '2018-06-01 05:40:04', '2019-06-01 10:40:04'),
('5af20f8af2c2f31e10b27000d2c133aa0467e5ff88d328c00c13d335c574a0867126f079b92ab3cc', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:46:13', '2018-05-31 02:46:13', '2019-05-31 07:46:13'),
('5fa6cae7a470a09224f690bbf89037b4a5899a6f1fb1b4fe1aa49fdd54bf9dceaea2152e4ed31930', 21, 1, 'MyApp', '[]', 0, '2018-06-01 03:03:16', '2018-06-01 03:03:16', '2019-06-01 08:03:16'),
('60e40bcb544f0f7f73df215caf5ba8d467335e1ad7818542c239831ead1e9982a5d7a400f7292706', 21, 1, 'MyApp', '[]', 0, '2018-06-01 01:19:07', '2018-06-01 01:19:07', '2019-06-01 06:19:07'),
('63ba7afc5c9e6713cfead83571db4b3c3ef452da835253ef719aa7d5d98f3578bc46b3cfbd264153', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:16:01', '2018-05-31 05:16:01', '2019-05-31 10:16:01'),
('686f6e2b45f12a93b1bcaf27359cf720236dcb0574ae13d7dcfde4bb3f8dae9ffbd86636826be641', 21, 1, 'MyApp', '[]', 0, '2018-05-31 03:31:16', '2018-05-31 03:31:16', '2019-05-31 08:31:16'),
('6e165e0cc958d2930d93cab8742b8d5d4fbe7ee3c3bbe9093fabe2e185543fbece0d628b9fcfcbdb', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:32:44', '2018-05-31 05:32:44', '2019-05-31 10:32:44'),
('6f85339d29791c3bd0e70774949647731e3074e851babb31d0626f95f17c40f830e71a244dfe4ab6', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:25:17', '2018-05-31 05:25:17', '2019-05-31 10:25:17'),
('729d653c24b345d6adcf0cf1a7b71d83663aed7d8ba8f3306f5414ca725f87d89495c02af3b8049b', 21, 1, 'MyApp', '[]', 0, '2018-06-01 03:04:47', '2018-06-01 03:04:47', '2019-06-01 08:04:47'),
('75cebc4ec37c901cfec1a6d2a7247cf3e5d8521adfd88848941bb9dc5264aac137bc77fada14ae18', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:38:39', '2018-05-31 02:38:39', '2019-05-31 07:38:39'),
('7a74f7776dabae4ade497dae24676fdbf5042f48a0e6e0d683bd8b9c6bcc61b84d1b716ade481d34', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:52:53', '2018-05-31 05:52:53', '2019-05-31 10:52:53'),
('7c9802f48381c81cc85e09fc0c5aadc8e524108012a67cac799df8dc6ac1d871bd056550ac3cbc12', 21, 1, 'MyApp', '[]', 1, '2018-05-24 05:48:37', '2018-05-24 05:48:37', '2019-05-24 10:48:37'),
('81e22dc43c3591a563fe3d177385f69fc2b6bafcc9d5c834470c65b1ff70465984e0708f98851d81', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:47:37', '2018-05-31 02:47:37', '2019-05-31 07:47:37'),
('820b3daaafa44a17a1433ec55cdc6fc5623e448741a4442a554b222b78727107bb1d4aaca34769ed', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:06:01', '2018-05-24 06:06:01', '2019-05-24 11:06:01'),
('82459720b129aacb7aa59f4d037a9d0a0032aed19e07f31f6410fdd673632786022eadd87925a969', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:34:48', '2018-05-31 05:34:48', '2019-05-31 10:34:48'),
('838c3a51fe893bd8fdc843e55275a65eb2e7920f735d0f0cbb864ee79b29dcdbe1ea1b9d6a329ed6', 21, 1, 'MyApp', '[]', 0, '2018-06-01 03:02:40', '2018-06-01 03:02:40', '2019-06-01 08:02:40'),
('83c748438429dfc6db1c691004f42668fb49343eb57b357524b78c4590d419839a1da83885dac9c1', 21, 1, 'MyApp', '[]', 0, '2018-05-31 03:12:34', '2018-05-31 03:12:34', '2019-05-31 08:12:34'),
('9689c50f0e1aae5967f943162a02f9f0648f3dd30cdb7b834276af909d087af21db48e257371ee61', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:07:24', '2018-05-24 06:07:24', '2019-05-24 11:07:24'),
('994fcf0629c19db8c9f8082f2491a269fc0a5c8964538475396586be7dcb670654d0d3f38401530a', 21, 1, 'MyApp', '[]', 0, '2018-05-24 07:37:39', '2018-05-24 07:37:39', '2019-05-24 12:37:39'),
('9c648b3c7a84d3f4bf50825d5edff52e64954a18191dae2bc21e1835f6546794c6f0af1b9a697c40', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:09:49', '2018-05-24 06:09:49', '2019-05-24 11:09:49'),
('a083fe4b490df50ffd4019f14220394f50ba1c1f8b856d60b8b83fa47904b1c5bc3b0485f3314a9a', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:59:02', '2018-05-31 05:59:02', '2019-05-31 10:59:02'),
('a715aec969b1dc85a57f1e18b477b3ea67fc024295bb25f05f752f6e67f09693e79a764136d40495', 21, 1, 'MyApp', '[]', 1, '2018-05-24 05:48:35', '2018-05-24 05:48:35', '2019-05-24 10:48:35'),
('af18d4e1e098c8aa773aa4758a01975fb0818bf4f3e72dba65118c00202846a5a4b76630e7d834d7', 21, 1, 'MyApp', '[]', 0, '2018-05-29 04:45:28', '2018-05-29 04:45:28', '2019-05-29 09:45:28'),
('afb1d13643643c3d38ee3c1b293398763116c5b2c5492836638594e705a6ab9a866c36145fca2d2b', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:35:57', '2018-05-31 05:35:57', '2019-05-31 10:35:57'),
('b2754807c6fc21e78f16c667ec186603f022414a232e44f08ecd613377d1311f0ad959ceff16379e', 21, 1, 'MyApp', '[]', 0, '2018-05-25 02:42:13', '2018-05-25 02:42:13', '2019-05-25 07:42:13'),
('b64a3eb0aacc172e96b9d2588811085d50e25157ca165f5c6b598b3d4924717e0b0c488769a2bbc9', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:14:17', '2018-05-24 06:14:17', '2019-05-24 11:14:17'),
('b69279f7ad78b722cb57a58d1dcd964a2baa42d52c88a12ec7a2221d03ed8ba5df99f7471e785bea', 21, 1, 'MyApp', '[]', 0, '2018-06-01 01:17:15', '2018-06-01 01:17:15', '2019-06-01 06:17:15'),
('b6e0e5e46691ad303ddadcc2084ba6883f2960671ddc882b60820c61816d6babf1fbf29a37c0f5d3', 21, 1, 'MyApp', '[]', 0, '2018-05-30 05:12:09', '2018-05-30 05:12:09', '2019-05-30 10:12:09'),
('c11e2d7563e975a2b6824d794df9d864b9a725295814faa670234f78cd257caac71def9a5522e2cc', 21, 1, 'MyApp', '[]', 0, '2018-05-24 07:36:37', '2018-05-24 07:36:37', '2019-05-24 12:36:37'),
('c7eefc9c8924cffb39a0de8232b774aa557c98d971223e54fbc63e94434309a032dafe5ff15c71e2', 21, 1, 'MyApp', '[]', 0, '2018-06-01 01:44:48', '2018-06-01 01:44:48', '2019-06-01 06:44:48'),
('c952d416424392c0c04d7a49a3024c2e1a5432a525391faeab0958c929bbf2dc34f839424038457c', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:06:19', '2018-05-24 06:06:19', '2019-05-24 11:06:19'),
('ca13c3c6a2bf0f32fa53800267c89ed174d7ddff78d848468944fd785cfa96933d387c6b39badf57', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:13:11', '2018-05-31 05:13:11', '2019-05-31 10:13:11'),
('cb82ff3a1f88ac153f74ee8c4ed027a195977178f8b99c635c8293953b9b7cc34fadf26488b66437', 21, 1, 'MyApp', '[]', 0, '2018-05-30 03:41:41', '2018-05-30 03:41:41', '2019-05-30 08:41:41'),
('d07d7f9b0f716c8a324a1bd1165782ac2bdceb912ee87d474fc1194d59400827ee01a683ea9ae1a2', 21, 1, 'MyApp', '[]', 0, '2018-05-30 03:14:48', '2018-05-30 03:14:48', '2019-05-30 08:14:48'),
('d173cadc8a77f2461502e806ccaeebdfedb2b4f6257c347942459aeaac9ff734e8d3ffd92124ac5d', 21, 1, 'MyApp', '[]', 0, '2018-06-01 05:13:36', '2018-06-01 05:13:36', '2019-06-01 10:13:36'),
('d267acb0e8ccc2930c2b6e149b069efc8fcacd50276a7dd6439c8d9e113b3caa2080c0ed5475ac7c', 21, 1, 'MyApp', '[]', 1, '2018-05-24 05:56:54', '2018-05-24 05:56:54', '2019-05-24 10:56:54'),
('d315d71460489274824f9f5a21651ca37e08947e6034bfc78de23e2a9994b42dddee39b24243813b', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:33:41', '2018-05-31 05:33:41', '2019-05-31 10:33:41'),
('d9bba0ec31d201b5bbe5c8e027d058797744b29ebb18324fd4ad6b2b8182605093a33e8ffca9cc96', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:20:45', '2018-05-31 05:20:45', '2019-05-31 10:20:45'),
('df88ccce4415161dd89b72b2853343a75e3c1be084c2c375ed5c095c1f8e13db2f5f2695577f1f1c', 21, 1, 'MyApp', '[]', 1, '2018-05-24 05:45:04', '2018-05-24 05:45:04', '2019-05-24 10:45:04'),
('e13c464c303499a36d7850323a85ad7c409731b7af1fb843e58b8c1bf148d1dc2d623a97b0156ae8', 21, 1, 'MyApp', '[]', 0, '2018-06-01 05:12:03', '2018-06-01 05:12:03', '2019-06-01 10:12:03'),
('e1fb8ec760f50e18ad04f960773ca3cf1e699504decfe2b6f730146a3865ba17ed3462793282ed92', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:53:54', '2018-05-24 06:53:54', '2019-05-24 11:53:54'),
('e34abfd628e97338a2b55b4cb3ccf4c89520acc18e1ead955045740ecaaeab52634dc83fde7c5608', 21, 1, 'MyApp', '[]', 0, '2018-05-31 04:38:37', '2018-05-31 04:38:37', '2019-05-31 09:38:37'),
('e6d9b4f991be213c5ce9becaba57860ebe4b94f51e9088e0b740ad7f9ee596d4a41926b15711bc8b', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:26:24', '2018-05-31 05:26:24', '2019-05-31 10:26:24'),
('ee4d3ee6b7d7469f81d639515edff42aa02b322297b17bd058dc2e69389026af59e5f73897c3674d', 21, 1, 'MyApp', '[]', 0, '2018-05-31 02:36:40', '2018-05-31 02:36:40', '2019-05-31 07:36:40'),
('f17b3e3e403856a7306b0a506e0743fa13d3fe4de3c38941bafb3474e2ba280add04407878795728', 21, 1, 'MyApp', '[]', 0, '2018-06-01 03:07:21', '2018-06-01 03:07:21', '2019-06-01 08:07:21'),
('f1c6f10979ae7632bd80e710af59e9169a6589dff0ffe1e52467a0aeb1eccc297170fe476c11615f', 21, 1, 'MyApp', '[]', 0, '2018-06-01 01:28:46', '2018-06-01 01:28:46', '2019-06-01 06:28:46'),
('f1ca24f969de380e83dc90564a41d09cf0285eca741b50c7dd30de110b51f9d39f036301a6ea5821', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:14:25', '2018-05-31 05:14:25', '2019-05-31 10:14:25'),
('f5e6cc4bc414d1c4b0059043346a47cb94d7c54b8b2885df733c00cb5692519b2fa27e9d51439016', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:50:07', '2018-05-24 06:50:07', '2019-05-24 11:50:07'),
('f63191248ff902f285b3e2cf1ad2fe606ab48765ffa8ef27ce973e015a8ee730484a6b4c7952f456', 21, 1, 'MyApp', '[]', 0, '2018-05-31 05:00:52', '2018-05-31 05:00:52', '2019-05-31 10:00:52'),
('fbc97eda73898c1fe4e6efc942323bde28bc1409e29464a8ebda499cdc1cfeced06b582d1f7ffac2', 21, 1, 'MyApp', '[]', 1, '2018-05-24 06:05:52', '2018-05-24 06:05:52', '2019-05-24 11:05:52'),
('fc3c48ad75b2dc9cb060832227698f2cdec9ccfb4221856ff3d92fafe89974bd2a35c9fbb8201789', 21, 1, 'MyApp', '[]', 0, '2018-05-31 06:12:40', '2018-05-31 06:12:40', '2019-05-31 11:12:40'),
('fe328abec10b5640501482da191c6664278342cb3e9232395c13586a9ad8bc3dba29404e7b5e56ca', 21, 1, 'MyApp', '[]', 0, '2018-06-05 05:10:33', '2018-06-05 05:10:33', '2019-06-05 10:10:33');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', '2IKLdCI5COxPeHYpFfcS8m91k4MiMlj9tVuYn5i6', 'http://localhost', 1, 0, 0, '2018-05-24 05:44:14', '2018-05-24 05:44:14'),
(2, NULL, 'Laravel Password Grant Client', 'gXyzUQowAUsD0x4Lbr55Jxu0usJoB88OK1A1ubgq', 'http://localhost', 0, 1, 0, '2018-05-24 05:44:14', '2018-05-24 05:44:14');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2018-05-24 05:44:14', '2018-05-24 05:44:14');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stock_status_history`
--

CREATE TABLE `stock_status_history` (
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `warehouse_id` int(11) NOT NULL,
  `old_status` int(11) NOT NULL,
  `new_status` int(11) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stock_status_history`
--

INSERT INTO `stock_status_history` (`id`, `item_id`, `warehouse_id`, `old_status`, `new_status`, `remarks`, `created_by`, `created_at`, `updated_at`) VALUES
(20, 548, 3, 1, 2, 'Damage sets', 8, '2018-06-12 11:51:21', '2018-06-12 11:51:21'),
(21, 536, 3, 1, 2, 'Damage sets', 8, '2018-06-12 11:51:22', '2018-06-12 11:51:22'),
(22, 514, 3, 1, 2, 'Damage sets', 8, '2018-06-12 11:51:22', '2018-06-12 11:51:22'),
(23, 533, 3, 1, 2, 'Damage sets', 8, '2018-06-12 11:51:22', '2018-06-12 11:51:22'),
(24, 515, 3, 1, 2, 'Damage sets', 8, '2018-06-12 11:51:22', '2018-06-12 11:51:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

CREATE TABLE `tbl_bank` (
  `id` int(10) UNSIGNED NOT NULL,
  `city_id` int(11) NOT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_uan` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`id`, `city_id`, `bank_name`, `bank_uan`, `created_at`, `updated_at`) VALUES
(1, 1, 'HBL', '111 111 110', '2018-03-27 19:00:00', NULL),
(2, 1, 'MCB', '121 100 001', '2018-03-27 19:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_city`
--

CREATE TABLE `tbl_city` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_city`
--

INSERT INTO `tbl_city` (`id`, `name`, `state_id`, `created_at`, `updated_at`) VALUES
(1, 'Karachi', 1, NULL, NULL),
(2, 'Islamabad', 2, NULL, NULL),
(3, 'Lahore', 2, NULL, NULL),
(4, 'Quetta', 3, NULL, NULL),
(5, 'Multan', 2, NULL, NULL),
(6, 'Peshawar', 4, NULL, NULL),
(11, 'karachi', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency`
--

CREATE TABLE `tbl_currency` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `iso` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `exchange_rate` decimal(13,2) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_currency`
--

INSERT INTO `tbl_currency` (`id`, `name`, `iso`, `exchange_rate`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(3, 'PKR', 'Rs', '1.00', 1, NULL, '2018-03-31 04:59:09', '2018-03-31 04:59:09'),
(4, 'USD', '$', '106.00', 1, NULL, '2018-03-31 04:59:26', '2018-03-31 04:59:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2018-03-27 03:03:23', '2018-03-27 03:03:23'),
(2, 'Finance', '2018-03-27 04:53:04', '2018-03-27 04:53:04'),
(3, 'Management', '2018-03-27 04:53:18', '2018-03-27 04:53:18'),
(4, 'Technical', '2018-03-30 01:43:22', '2018-03-30 01:43:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation`
--

CREATE TABLE `tbl_designation` (
  `id` int(10) UNSIGNED NOT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_designation`
--

INSERT INTO `tbl_designation` (`id`, `designation`, `created_at`, `updated_at`) VALUES
(1, 'Programmer', '2018-03-27 03:03:52', '2018-03-27 03:03:52'),
(2, 'Manager', '2018-03-27 04:54:49', '2018-03-27 04:54:49'),
(3, 'Accountant', '2018-03-27 04:54:57', '2018-03-27 04:54:57'),
(4, 'Regional Sales Manager', '2018-03-27 04:55:17', '2018-03-27 04:55:17');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_discount_type`
--

CREATE TABLE `tbl_discount_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `discount_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_imei`
--

CREATE TABLE `tbl_imei` (
  `id` int(10) UNSIGNED NOT NULL,
  `imei1` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imei2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_id` int(10) UNSIGNED DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_imei`
--

INSERT INTO `tbl_imei` (`id`, `imei1`, `imei2`, `item_id`, `product_id`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '111112341235499', '111112341235519', 514, 70, 8, NULL, '2018-06-12 06:31:37'),
(2, '111112341235500', '111112341235520', 533, 70, 8, NULL, '2018-06-12 06:31:39'),
(3, '111112341235501', '111112341235521', 515, 70, 8, NULL, '2018-06-12 06:31:37'),
(4, '111112341235502', '111112341235522', 516, 70, 8, NULL, '2018-06-12 06:31:38'),
(5, '111112341235503', '111112341235523', 517, 70, 8, NULL, '2018-06-12 06:31:38'),
(6, '111112341235504', '111112341235524', 518, 70, 8, NULL, '2018-06-12 06:31:38'),
(7, '111112341235505', '111112341235525', 519, 70, 8, NULL, '2018-06-12 06:31:38'),
(8, '111112341235506', '111112341235526', 520, 70, 8, NULL, '2018-06-12 06:31:38'),
(9, '111112341235507', '111112341235527', 521, 70, 8, NULL, '2018-06-12 06:31:38'),
(10, '111112341235508', '111112341235528', 522, 70, 8, NULL, '2018-06-12 06:31:38'),
(11, '111112341235509', '111112341235529', 523, 70, 8, NULL, '2018-06-12 06:31:38'),
(12, '111112341235510', '111112341235530', 524, 70, 8, NULL, '2018-06-12 06:31:38'),
(13, '111112341235511', '111112341235531', 525, 70, 8, NULL, '2018-06-12 06:31:38'),
(14, '111112341235512', '111112341235532', 526, 70, 8, NULL, '2018-06-12 06:31:38'),
(15, '111112341235513', '111112341235533', 527, 70, 8, NULL, '2018-06-12 06:31:38'),
(16, '111112341235514', '111112341235534', 528, 70, 8, NULL, '2018-06-12 06:31:39'),
(17, '111112341235515', '111112341235535', 529, 70, 8, NULL, '2018-06-12 06:31:39'),
(18, '111112341235516', '111112341235536', 530, 70, 8, NULL, '2018-06-12 06:31:39'),
(19, '111112341235517', '111112341235537', 531, 70, 8, NULL, '2018-06-12 06:31:39'),
(20, '111112341235518', '111112341235538', 532, 70, 8, NULL, '2018-06-12 06:31:39'),
(21, '111112341235444', '111112341235458', 534, 71, 8, NULL, '2018-06-12 06:31:39'),
(22, '111112341235445', '111112341235459', 535, 71, 8, NULL, '2018-06-12 06:31:39'),
(23, '111112341235446', '111112341235460', 536, 71, 8, NULL, '2018-06-12 06:31:40'),
(24, '111112341235447', '111112341235461', 537, 71, 8, NULL, '2018-06-12 06:31:40'),
(25, '111112341235448', '111112341235462', 538, 71, 8, NULL, '2018-06-12 06:31:40'),
(26, '111112341235449', '111112341235463', 539, 71, 8, NULL, '2018-06-12 06:31:40'),
(27, '111112341235450', '111112341235464', 540, 71, 8, NULL, '2018-06-12 06:31:40'),
(28, '111112341235451', '111112341235465', 541, 71, 8, NULL, '2018-06-12 06:31:40'),
(29, '111112341235452', '111112341235466', 542, 71, 8, NULL, '2018-06-12 06:31:41'),
(30, '111112341235453', '111112341235467', 543, 71, 8, NULL, '2018-06-12 06:31:41'),
(31, '111112341235454', '111112341235468', 544, 71, 8, NULL, '2018-06-12 06:31:41'),
(32, '111112341235455', '111112341235469', 545, 71, 8, NULL, '2018-06-12 06:31:41'),
(33, '111112341235456', '111112341235470', 546, 71, 8, NULL, '2018-06-12 06:31:41'),
(34, '111112341235457', '111112341235471', 547, 71, 8, NULL, '2018-06-12 06:31:41'),
(35, '111112341235400', '111112341235422', NULL, 73, 8, NULL, NULL),
(36, '111112341235401', '111112341235423', NULL, 73, 8, NULL, NULL),
(37, '111112341235402', '111112341235424', NULL, 73, 8, NULL, NULL),
(38, '111112341235403', '111112341235425', NULL, 73, 8, NULL, NULL),
(39, '111112341235404', '111112341235426', NULL, 73, 8, NULL, NULL),
(40, '111112341235405', '111112341235427', NULL, 73, 8, NULL, NULL),
(41, '111112341235406', '111112341235428', NULL, 73, 8, NULL, NULL),
(42, '111112341235407', '111112341235429', NULL, 73, 8, NULL, NULL),
(43, '111112341235408', '111112341235430', NULL, 73, 8, NULL, NULL),
(44, '111112341235409', '111112341235431', NULL, 73, 8, NULL, NULL),
(45, '111112341235410', '111112341235432', NULL, 73, 8, NULL, NULL),
(46, '111112341235411', '111112341235433', NULL, 73, 8, NULL, NULL),
(47, '111112341235412', '111112341235434', NULL, 73, 8, NULL, NULL),
(48, '111112341235413', '111112341235435', NULL, 73, 8, NULL, NULL),
(49, '111112341235414', '111112341235436', NULL, 73, 8, NULL, NULL),
(50, '111112341235415', '111112341235437', NULL, 73, 8, NULL, NULL),
(51, '111112341235416', '111112341235438', NULL, 73, 8, NULL, NULL),
(52, '111112341235417', '111112341235439', NULL, 73, 8, NULL, NULL),
(53, '111112341235418', '111112341235440', NULL, 73, 8, NULL, NULL),
(54, '111112341235419', '111112341235441', NULL, 73, 8, NULL, NULL),
(55, '111112341235420', '111112341235442', NULL, 73, 8, NULL, NULL),
(56, '111112341235421', '111112341235443', NULL, 73, 8, NULL, NULL),
(57, '181112341235421', '191112341235421', NULL, 73, 8, NULL, NULL),
(58, '111112341235477', '111112341235487', 548, 74, 8, NULL, '2018-06-12 06:31:42'),
(59, '111112341235478', '111112341235488', 549, 74, 8, NULL, '2018-06-12 06:31:42'),
(60, '111112341235479', '111112341235489', 550, 74, 8, NULL, '2018-06-12 06:31:42'),
(61, '111112341235480', '111112341235490', 551, 74, 8, NULL, '2018-06-12 06:31:42'),
(62, '111112341235481', '111112341235491', 552, 74, 8, NULL, '2018-06-12 06:31:42'),
(63, '111112341235482', '111112341235492', 553, 74, 8, NULL, '2018-06-12 06:31:42'),
(64, '111112341235483', '111112341235493', NULL, 74, 8, NULL, NULL),
(65, '111112341235484', '111112341235494', NULL, 74, 8, NULL, NULL),
(66, '111112341235485', '111112341235495', NULL, 74, 8, NULL, NULL),
(67, '111112341235486', '111112341235496', 554, 74, 8, NULL, '2018-06-12 06:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice`
--

CREATE TABLE `tbl_invoice` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` int(10) UNSIGNED NOT NULL,
  `invoice_type_id` int(10) UNSIGNED NOT NULL,
  `payment_type_id` int(10) UNSIGNED NOT NULL,
  `paid` decimal(13,0) NOT NULL,
  `is_pay` tinyint(4) NOT NULL DEFAULT '0',
  `is_invoice` tinyint(3) UNSIGNED DEFAULT '0',
  `total_amount` decimal(13,2) UNSIGNED NOT NULL,
  `final_amount` decimal(13,2) UNSIGNED NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_invoice`
--

INSERT INTO `tbl_invoice` (`id`, `invoice_no`, `order_id`, `invoice_type_id`, `payment_type_id`, `paid`, `is_pay`, `is_invoice`, `total_amount`, `final_amount`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '18KS000001', 116, 1, 2, '0', 3, 3, '0.00', '14000.00', NULL, 8, NULL, '2018-06-14 02:46:59', '2018-06-14 03:38:03'),
(2, '18KS000002', 117, 1, 2, '0', 0, 0, '0.00', '14000.00', NULL, 8, 8, '2018-06-14 02:52:10', '2018-06-14 02:53:14'),
(3, '18KS000003', 118, 1, 2, '0', 1, 0, '0.00', '14000.00', NULL, 8, 8, '2018-06-14 03:00:06', '2018-06-14 03:00:38'),
(4, '18KS000004', 119, 1, 2, '0', 1, 0, '0.00', '28000.00', NULL, 8, 8, '2018-06-14 03:01:49', '2018-06-14 03:02:22'),
(5, '18KS000005', 120, 1, 2, '0', 1, 0, '0.00', '28000.00', NULL, 8, 8, '2018-06-14 03:03:06', '2018-06-14 03:06:30'),
(6, '18KS000006', 121, 1, 2, '0', 3, 3, '42000.00', '70000.00', NULL, 8, 8, '2018-06-14 03:07:38', '2018-06-14 03:44:50'),
(7, '18KS000007', 122, 1, 2, '0', 3, 3, '14000.00', '14000.00', NULL, 8, NULL, '2018-06-14 03:11:11', '2018-06-14 03:33:54'),
(8, '18KS000008', 123, 1, 2, '0', 1, 0, '0.00', '28000.00', NULL, 8, 8, '2018-06-14 03:14:56', '2018-06-14 03:16:53'),
(9, '18KS000009', 124, 1, 2, '0', 3, 3, '28000.00', '28000.00', NULL, 8, NULL, '2018-06-14 03:22:00', '2018-06-14 03:23:27'),
(10, '18KS000010', 124, 1, 2, '0', 0, 2, '28000.00', '0.00', NULL, 8, NULL, '2018-06-14 03:23:27', '2018-06-14 03:23:27'),
(11, '18KS000011', 122, 1, 2, '0', 0, 2, '14000.00', '0.00', NULL, 8, NULL, '2018-06-14 03:33:54', '2018-06-14 03:33:54'),
(12, '18KS000012', 116, 1, 2, '0', 0, 2, '0.00', '0.00', NULL, 8, NULL, '2018-06-14 03:38:03', '2018-06-14 03:38:03'),
(13, '18KS000013', 121, 1, 2, '0', 0, 2, '42000.00', '0.00', NULL, 8, NULL, '2018-06-14 03:44:50', '2018-06-14 03:44:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_products`
--

CREATE TABLE `tbl_invoice_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `product_color_id` int(10) UNSIGNED NOT NULL,
  `product_qty` int(10) UNSIGNED NOT NULL,
  `product_price` decimal(13,2) NOT NULL,
  `discount_type_id` int(10) UNSIGNED DEFAULT NULL,
  `total_amount` decimal(13,2) NOT NULL,
  `extra` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_invoice_products`
--

INSERT INTO `tbl_invoice_products` (`id`, `invoice_id`, `product_color_id`, `product_qty`, `product_price`, `discount_type_id`, `total_amount`, `extra`, `is_deleted`, `created_by`, `updated_by`) VALUES
(1, 1, 51, 1, '14000.00', NULL, '14000.00', NULL, 0, 8, NULL),
(2, 2, 51, 1, '14000.00', NULL, '14000.00', NULL, 0, 8, NULL),
(3, 3, 51, 1, '14000.00', NULL, '14000.00', NULL, 0, 8, NULL),
(4, 4, 51, 2, '14000.00', NULL, '28000.00', NULL, 0, 8, NULL),
(5, 5, 51, 2, '14000.00', NULL, '28000.00', NULL, 0, 8, NULL),
(6, 6, 51, 5, '14000.00', NULL, '70000.00', NULL, 0, 8, NULL),
(7, 7, 51, 1, '14000.00', NULL, '14000.00', NULL, 0, 8, NULL),
(8, 8, 51, 2, '14000.00', NULL, '28000.00', NULL, 0, 8, NULL),
(9, 9, 51, 2, '14000.00', NULL, '28000.00', NULL, 0, 8, NULL),
(10, 10, 51, 2, '14000.00', NULL, '28000.00', NULL, 0, 8, NULL),
(11, 11, 51, 1, '14000.00', NULL, '14000.00', NULL, 0, 8, NULL),
(12, 12, 51, 1, '14000.00', NULL, '14000.00', NULL, 0, 8, NULL),
(13, 13, 51, 5, '14000.00', NULL, '70000.00', NULL, 0, 8, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_products_return`
--

CREATE TABLE `tbl_invoice_products_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `imei1` varchar(20) DEFAULT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `outlet_id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(11) UNSIGNED DEFAULT NULL,
  `invoice_no` varchar(15) DEFAULT NULL,
  `tbl_invoice_product` int(10) UNSIGNED DEFAULT NULL,
  `product_color_id` int(11) UNSIGNED DEFAULT NULL,
  `unit_price` decimal(13,2) DEFAULT NULL,
  `sale_officer_id` int(11) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_invoice_products_return`
--

INSERT INTO `tbl_invoice_products_return` (`id`, `imei1`, `item_id`, `outlet_id`, `invoice_id`, `invoice_no`, `tbl_invoice_product`, `product_color_id`, `unit_price`, `sale_officer_id`, `created_by`, `created_at`) VALUES
(1, '111112341235502', 516, 18, 1, '18KS000001', 1, 51, '14000.00', 5, 8, '2018-06-14 07:48:22'),
(2, '111112341235502', 516, 18, 2, '18KS000002', 2, 51, '14000.00', 5, 8, '2018-06-14 07:53:14'),
(3, '111112341235502', 516, 18, 3, '18KS000003', 3, 51, '14000.00', 5, 8, '2018-06-14 08:00:38'),
(4, '111112341235502', 516, 18, 4, '18KS000004', 4, 51, '14000.00', 5, 8, '2018-06-14 08:02:22'),
(5, '111112341235503', 517, 18, 4, '18KS000004', 4, 51, '14000.00', 5, 8, '2018-06-14 08:02:22'),
(6, '111112341235503', 517, 18, 5, '18KS000005', 5, 51, '14000.00', 5, 8, '2018-06-14 08:03:59'),
(7, '111112341235502', 516, 18, 5, '18KS000005', 5, 51, '14000.00', 5, 8, '2018-06-14 08:06:30'),
(8, '111112341235503', 517, 18, 6, '18KS000006', 6, 51, '14000.00', 5, 8, '2018-06-14 08:08:14'),
(9, '111112341235502', 516, 18, 6, '18KS000006', 6, 51, '14000.00', 5, 8, '2018-06-14 08:09:36'),
(10, '111112341235503', 517, 18, 8, '18KS000008', 8, 51, '14000.00', 5, 8, '2018-06-14 08:16:00'),
(11, '111112341235502', 516, 18, 8, '18KS000008', 8, 51, '14000.00', 5, 8, '2018-06-14 08:16:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_invoice_type`
--

CREATE TABLE `tbl_invoice_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_invoice_type`
--

INSERT INTO `tbl_invoice_type` (`id`, `invoice_name`, `is_deleted`, `created_by`, `updated_by`) VALUES
(1, 'General', 0, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item`
--

CREATE TABLE `tbl_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_color_id` int(10) UNSIGNED NOT NULL,
  `receive_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_item`
--

INSERT INTO `tbl_item` (`id`, `product_color_id`, `receive_id`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(514, 51, 97, 8, NULL, 0, '2018-06-12 06:31:37', '2018-06-12 06:31:37'),
(515, 51, 97, 8, NULL, 0, '2018-06-12 06:31:37', '2018-06-12 06:31:37'),
(516, 51, 97, 8, NULL, 0, '2018-06-12 06:31:37', '2018-06-12 06:31:37'),
(517, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(518, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(519, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(520, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(521, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(522, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(523, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(524, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(525, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(526, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(527, 51, 97, 8, NULL, 0, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(528, 51, 97, 8, NULL, 0, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(529, 51, 97, 8, NULL, 0, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(530, 51, 97, 8, NULL, 0, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(531, 51, 97, 8, NULL, 0, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(532, 51, 97, 8, NULL, 0, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(533, 51, 97, 8, NULL, 0, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(534, 53, 97, 8, NULL, 0, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(535, 53, 97, 8, NULL, 0, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(536, 53, 97, 8, NULL, 0, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(537, 53, 97, 8, NULL, 0, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(538, 53, 97, 8, NULL, 0, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(539, 53, 97, 8, NULL, 0, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(540, 53, 97, 8, NULL, 0, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(541, 52, 97, 8, NULL, 0, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(542, 52, 97, 8, NULL, 0, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(543, 52, 97, 8, NULL, 0, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(544, 52, 97, 8, NULL, 0, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(545, 52, 97, 8, NULL, 0, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(546, 52, 97, 8, NULL, 0, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(547, 52, 97, 8, NULL, 0, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(548, 60, 97, 8, NULL, 0, '2018-06-12 06:31:42', '2018-06-12 06:31:42'),
(549, 60, 97, 8, NULL, 0, '2018-06-12 06:31:42', '2018-06-12 06:31:42'),
(550, 60, 97, 8, NULL, 0, '2018-06-12 06:31:42', '2018-06-12 06:31:42'),
(551, 60, 97, 8, NULL, 0, '2018-06-12 06:31:42', '2018-06-12 06:31:42'),
(552, 60, 97, 8, NULL, 0, '2018-06-12 06:31:42', '2018-06-12 06:31:42'),
(553, 60, 97, 8, NULL, 0, '2018-06-12 06:31:42', '2018-06-12 06:31:42'),
(554, 60, 97, 8, NULL, 0, '2018-06-12 06:31:42', '2018-06-12 06:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ledger`
--

CREATE TABLE `tbl_ledger` (
  `id` int(10) UNSIGNED NOT NULL,
  `retailer_id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `collection_id` int(10) UNSIGNED DEFAULT NULL,
  `TransDate` datetime NOT NULL,
  `Collection` decimal(13,2) DEFAULT NULL,
  `Credit` decimal(13,2) DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_ledger`
--

INSERT INTO `tbl_ledger` (`id`, `retailer_id`, `invoice_id`, `collection_id`, `TransDate`, `Collection`, `Credit`, `description`, `created_at`, `updated_at`) VALUES
(1, 18, 1, NULL, '2018-06-14 07:46:59', NULL, '14000.00', 'invoice (18KS000001)', '2018-06-14 02:46:59', '2018-06-14 02:46:59'),
(2, 18, NULL, NULL, '2018-06-14 07:48:22', '14000.00', NULL, 'sale return (111112341235502 Nova Dark Black 14000)', '2018-06-14 02:48:22', '2018-06-14 02:48:22'),
(3, 18, 2, NULL, '2018-06-14 07:52:10', NULL, '14000.00', 'invoice (18KS000002)', '2018-06-14 02:52:10', '2018-06-14 02:52:10'),
(4, 18, NULL, NULL, '2018-06-14 07:53:14', '14000.00', NULL, 'sale return (111112341235502 Nova Dark Black 14000)', '2018-06-14 02:53:14', '2018-06-14 02:53:14'),
(5, 18, 3, NULL, '2018-06-14 08:00:07', NULL, '14000.00', 'invoice (18KS000003)', '2018-06-14 03:00:07', '2018-06-14 03:00:07'),
(6, 18, NULL, NULL, '2018-06-14 08:00:38', '14000.00', NULL, 'sale return (111112341235502 Nova Dark Black 14000)', '2018-06-14 03:00:38', '2018-06-14 03:00:38'),
(7, 18, 4, NULL, '2018-06-14 08:01:49', NULL, '28000.00', 'invoice (18KS000004)', '2018-06-14 03:01:49', '2018-06-14 03:01:49'),
(8, 18, NULL, NULL, '2018-06-14 08:02:22', '28000.00', NULL, 'sale return (111112341235502 Nova Dark Black 14000)(111112341235503 Nova Dark Black 14000)', '2018-06-14 03:02:22', '2018-06-14 03:02:22'),
(9, 18, 5, NULL, '2018-06-14 08:03:06', NULL, '28000.00', 'invoice (18KS000005)', '2018-06-14 03:03:06', '2018-06-14 03:03:06'),
(10, 18, NULL, NULL, '2018-06-14 08:03:59', '14000.00', NULL, 'sale return (111112341235503 Nova Dark Black 14000)', '2018-06-14 03:03:59', '2018-06-14 03:03:59'),
(11, 18, NULL, NULL, '2018-06-14 08:06:30', '14000.00', NULL, 'sale return (111112341235502 Nova Dark Black 14000)', '2018-06-14 03:06:30', '2018-06-14 03:06:30'),
(12, 18, 6, NULL, '2018-06-14 08:07:38', NULL, '70000.00', 'invoice (18KS000006)', '2018-06-14 03:07:38', '2018-06-14 03:07:38'),
(13, 18, NULL, NULL, '2018-06-14 08:08:14', '14000.00', NULL, 'sale return (111112341235503 Nova Dark Black 14000)', '2018-06-14 03:08:14', '2018-06-14 03:08:14'),
(14, 18, NULL, NULL, '2018-06-14 08:09:36', '14000.00', NULL, 'sale return (111112341235502 Nova Dark Black 14000)', '2018-06-14 03:09:36', '2018-06-14 03:09:36'),
(15, 18, 7, NULL, '2018-06-14 08:11:11', NULL, '14000.00', 'invoice (18KS000007)', '2018-06-14 03:11:11', '2018-06-14 03:11:11'),
(16, 18, 8, NULL, '2018-06-14 08:14:56', NULL, '28000.00', 'invoice (18KS000008)', '2018-06-14 03:14:56', '2018-06-14 03:14:56'),
(17, 18, NULL, NULL, '2018-06-14 08:16:00', '14000.00', NULL, 'sale return (111112341235503 Nova Dark Black 14000)', '2018-06-14 03:16:00', '2018-06-14 03:16:00'),
(18, 18, NULL, NULL, '2018-06-14 08:16:53', '14000.00', NULL, 'sale return (111112341235502 Nova Dark Black 14000)', '2018-06-14 03:16:53', '2018-06-14 03:16:53'),
(19, 18, 9, NULL, '2018-06-14 08:22:01', NULL, '28000.00', 'invoice (18KS000009)', '2018-06-14 03:22:01', '2018-06-14 03:22:01'),
(20, 18, 10, NULL, '2018-06-14 08:23:27', '28000.00', NULL, 'invoice  (18KS000009) Reversed', '2018-06-14 03:23:27', '2018-06-14 03:23:27'),
(21, 18, 11, NULL, '2018-06-14 08:33:54', '14000.00', NULL, 'invoice  (18KS000007) Reversed', '2018-06-14 03:33:54', '2018-06-14 03:33:54'),
(22, 18, 12, NULL, '2018-06-14 08:38:03', '0.00', NULL, 'invoice  (18KS000001) Reversed', '2018-06-14 03:38:03', '2018-06-14 03:38:03'),
(23, 18, 13, NULL, '2018-06-14 08:44:51', '42000.00', NULL, 'invoice  (18KS000006) Reversed', '2018-06-14 03:44:51', '2018-06-14 03:44:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_main_warehouse_receive`
--

CREATE TABLE `tbl_main_warehouse_receive` (
  `id` int(10) UNSIGNED NOT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `receive_id` int(10) UNSIGNED NOT NULL,
  `is_received` tinyint(4) NOT NULL DEFAULT '0',
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_main_warehouse_receive`
--

INSERT INTO `tbl_main_warehouse_receive` (`id`, `warehouse_id`, `created_by`, `receive_id`, `is_received`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(128, 3, 8, 97, 1, NULL, 0, '2018-06-12 06:26:00', '2018-06-12 06:31:42'),
(129, 3, 8, 98, 0, NULL, 0, '2018-06-12 06:31:46', '2018-06-12 06:31:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_main_warehouse_receive_item`
--

CREATE TABLE `tbl_main_warehouse_receive_item` (
  `id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `current_stock_status` int(11) NOT NULL DEFAULT '1',
  `is_sold` int(11) NOT NULL DEFAULT '0',
  `sold_to_outlet_id` int(11) DEFAULT NULL,
  `item_is_activate` tinyint(4) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `activated_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_main_warehouse_receive_item`
--

INSERT INTO `tbl_main_warehouse_receive_item` (`id`, `item_id`, `warehouse_id`, `current_stock_status`, `is_sold`, `sold_to_outlet_id`, `item_is_activate`, `is_deleted`, `activated_date`, `created_at`, `updated_at`) VALUES
(505, 514, 3, 2, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:37', '2018-06-12 06:51:22'),
(506, 515, 3, 2, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:37', '2018-06-12 06:51:22'),
(507, 516, 4, 1, 0, 18, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-14 03:22:47'),
(508, 517, 4, 1, 0, 18, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-14 03:22:47'),
(509, 518, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:59:04'),
(510, 519, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:59:04'),
(511, 520, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:59:05'),
(512, 521, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:59:05'),
(513, 522, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:59:05'),
(514, 523, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:59:05'),
(515, 524, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:59:05'),
(516, 525, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:59:05'),
(517, 526, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(518, 527, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:38', '2018-06-12 06:31:38'),
(519, 528, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(520, 529, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(521, 530, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(522, 531, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(523, 532, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(524, 533, 3, 2, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:39', '2018-06-12 06:51:22'),
(525, 534, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(526, 535, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(527, 536, 3, 2, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:40', '2018-06-12 06:51:22'),
(528, 537, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(529, 538, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(530, 539, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(531, 540, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(532, 541, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:40', '2018-06-12 06:59:05'),
(533, 542, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:41', '2018-06-12 06:59:05'),
(534, 543, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(535, 544, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(536, 545, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(537, 546, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(538, 547, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:41', '2018-06-12 06:31:41'),
(539, 548, 4, 2, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:42', '2018-06-12 06:59:05'),
(540, 549, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:42', '2018-06-12 06:31:42'),
(541, 550, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:42', '2018-06-12 06:59:05'),
(542, 551, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:42', '2018-06-12 06:31:42'),
(543, 552, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:42', '2018-06-12 06:31:42'),
(544, 553, 4, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:42', '2018-06-12 06:59:05'),
(545, 554, 3, 1, 0, NULL, 0, 0, NULL, '2018-06-12 06:31:42', '2018-06-12 06:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_main_warehouse_receive_product`
--

CREATE TABLE `tbl_main_warehouse_receive_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `main_receive_id` int(10) UNSIGNED NOT NULL,
  `product_color_id` int(10) UNSIGNED NOT NULL,
  `product_qty` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_main_warehouse_receive_product`
--

INSERT INTO `tbl_main_warehouse_receive_product` (`id`, `main_receive_id`, `product_color_id`, `product_qty`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(137, 128, 51, 20, 8, NULL, 0, '2018-06-12 06:31:37', '2018-06-12 06:31:37'),
(138, 128, 53, 7, 8, NULL, 0, '2018-06-12 06:31:39', '2018-06-12 06:31:39'),
(139, 128, 52, 7, 8, NULL, 0, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(140, 128, 60, 7, 8, NULL, 0, '2018-06-12 06:31:42', '2018-06-12 06:31:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufacturing_order`
--

CREATE TABLE `tbl_manufacturing_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `manufacture_order_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `eta` date NOT NULL,
  `total_cost` int(10) UNSIGNED NOT NULL,
  `remaining_payment` int(10) UNSIGNED NOT NULL,
  `transaction_closed` tinyint(4) NOT NULL DEFAULT '0',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_manufacturing_order`
--

INSERT INTO `tbl_manufacturing_order` (`id`, `manufacture_order_no`, `eta`, `total_cost`, `remaining_payment`, `transaction_closed`, `is_deleted`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(88, 'PO061800088', '2018-06-11', 876000, 876000, 0, 0, 8, NULL, '2018-06-12 06:24:10', '2018-06-12 06:24:10');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufacturing_order_product`
--

CREATE TABLE `tbl_manufacturing_order_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_color_id` int(10) UNSIGNED NOT NULL,
  `manufacture_order_id` int(10) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `remaining_qty` int(10) UNSIGNED NOT NULL,
  `unit_cost` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_manufacturing_order_product`
--

INSERT INTO `tbl_manufacturing_order_product` (`id`, `product_color_id`, `manufacture_order_id`, `quantity`, `remaining_qty`, `unit_cost`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(168, 51, 88, 20, 0, 14000, 8, NULL, '2018-06-12 06:24:10', '2018-06-12 06:25:18'),
(169, 53, 88, 7, 0, 13000, 8, NULL, '2018-06-12 06:24:10', '2018-06-12 06:25:18'),
(170, 52, 88, 7, 0, 12000, 8, NULL, '2018-06-12 06:24:10', '2018-06-12 06:25:18'),
(171, 60, 88, 7, 0, 7000, 8, NULL, '2018-06-12 06:24:10', '2018-06-12 06:25:18'),
(172, 61, 88, 3, 0, 8000, 8, NULL, '2018-06-12 06:24:10', '2018-06-12 06:25:29'),
(173, 57, 88, 12, 0, 15000, 8, NULL, '2018-06-12 06:24:10', '2018-06-12 06:25:29'),
(174, 58, 88, 8, 0, 15000, 8, NULL, '2018-06-12 06:24:10', '2018-06-12 06:25:29'),
(175, 59, 88, 3, 0, 16000, 8, NULL, '2018-06-12 06:24:10', '2018-06-12 06:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufacturing_payment`
--

CREATE TABLE `tbl_manufacturing_payment` (
  `id` int(10) UNSIGNED NOT NULL,
  `manufacture_order_id` int(10) UNSIGNED NOT NULL,
  `payment_amount` decimal(13,2) NOT NULL,
  `total_amount` decimal(13,2) NOT NULL,
  `payment_type_id` int(10) UNSIGNED NOT NULL,
  `currency_id` int(10) UNSIGNED NOT NULL,
  `exchange_rate` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_manufacturing_status`
--

CREATE TABLE `tbl_manufacturing_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `manufacturing_order_id` int(10) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_type`
--

CREATE TABLE `tbl_payment_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_payment_type`
--

INSERT INTO `tbl_payment_type` (`id`, `type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Cash', 1, NULL, '2018-03-27 19:00:00', '2018-03-27 19:00:00'),
(2, 'Credit', 1, NULL, NULL, NULL),
(3, 'Cheque', 1, NULL, '2018-03-27 19:00:00', '2018-03-27 19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permission`
--

CREATE TABLE `tbl_permission` (
  `id` int(10) UNSIGNED NOT NULL,
  `permission` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_permission`
--

INSERT INTO `tbl_permission` (`id`, `permission`, `description`, `url`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'demo description', '', '2018-04-04 19:00:00', NULL),
(2, 'progrmmer', 'sample', '', '2018-04-04 19:00:00', NULL),
(10, 'Assign Roles', 'it\'ll assign the roles to the users', '/userrole', '2018-06-14 06:25:52', '2018-06-14 06:25:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date` date NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`id`, `category_id`, `name`, `release_date`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(70, 50, 'Nova', '2018-04-20', 8, NULL, 0, '2018-04-18 05:41:30', '2018-04-18 05:41:30'),
(71, 50, 'Xcell Enia', '2018-04-28', 8, 8, 0, '2018-04-19 03:02:48', '2018-04-30 02:52:20'),
(72, 51, 'H7', '2019-04-20', 8, NULL, 0, '2018-04-26 02:16:06', '2018-04-26 02:16:06'),
(73, 50, 'Xcell Ace', '2018-05-03', 8, NULL, 0, '2018-04-30 02:17:35', '2018-04-30 02:17:35'),
(74, 51, 'Xcell G1', '2018-04-25', 8, NULL, 0, '2018-04-30 02:29:46', '2018-04-30 02:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_category`
--

CREATE TABLE `tbl_product_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_product_category`
--

INSERT INTO `tbl_product_category` (`id`, `name`, `description`, `image`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(50, 'Smart Phone', 'Smart Phone', 'Xl4Z04hC12bAhIn6.jpg', 8, NULL, 0, '2018-04-18 05:34:53', '2018-04-18 05:34:53'),
(51, 'Feature Phone', 'Small Basic Phone', 'Jc9pG6EuPIrDrN4s.jpg', 8, NULL, 0, '2018-04-26 02:09:13', '2018-04-26 02:09:13');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_color`
--

CREATE TABLE `tbl_product_color` (
  `id` int(10) UNSIGNED NOT NULL,
  `sku` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `discount` double NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_product_color`
--

INSERT INTO `tbl_product_color` (`id`, `sku`, `product_id`, `color`, `price`, `discount`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(50, 'NOLI70', 70, 'Light Blue', 13000, 0, 8, NULL, 0, '2018-04-18 05:41:30', '2018-04-18 05:41:30'),
(51, 'NODA70', 70, 'Dark Black', 14000, 0, 8, NULL, 0, '2018-04-18 05:41:30', '2018-04-18 05:41:30'),
(52, 'XCBL71', 71, 'White', 12000, 0, 8, 8, 0, '2018-04-19 03:02:48', '2018-04-30 02:52:20'),
(53, 'XCBL71', 71, 'Blue', 13000, 0, 8, 8, 0, '2018-04-19 03:02:48', '2018-04-30 02:52:20'),
(54, 'H7BL72', 72, 'Black', 8000, 0, 8, NULL, 0, '2018-04-26 02:16:06', '2018-04-26 02:16:06'),
(55, 'H7BL72', 72, 'Blue', 8000, 0, 8, NULL, 0, '2018-04-26 02:16:06', '2018-04-26 02:16:06'),
(56, 'H7WH72', 72, 'White', 8000, 0, 8, NULL, 0, '2018-04-26 02:16:06', '2018-04-26 02:16:06'),
(57, 'XCWH73', 73, 'White', 15000, 0, 8, NULL, 0, '2018-04-30 02:17:35', '2018-04-30 02:17:35'),
(58, 'XCBL73', 73, 'Black', 15000, 0, 8, NULL, 0, '2018-04-30 02:17:35', '2018-04-30 02:17:35'),
(59, 'XCBL73', 73, 'Blue', 16000, 0, 8, NULL, 0, '2018-04-30 02:17:35', '2018-04-30 02:17:35'),
(60, 'XCBL74', 74, 'Black', 7000, 0, 8, NULL, 0, '2018-04-30 02:29:46', '2018-04-30 02:29:46'),
(61, 'XCWH74', 74, 'White', 8000, 0, 8, NULL, 0, '2018-04-30 02:29:46', '2018-04-30 02:29:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_product_image`
--

CREATE TABLE `tbl_product_image` (
  `id` int(10) UNSIGNED NOT NULL,
  `product_color_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_product_image`
--

INSERT INTO `tbl_product_image` (`id`, `product_color_id`, `image`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(58, 50, 'sKIgJLIRfelDcT9s.jpg', 8, NULL, 0, '2018-04-18 05:41:30', '2018-04-18 05:41:30'),
(59, 51, 'wMpxjOyeBQzo1pVr.jpg', 8, NULL, 0, '2018-04-18 05:41:30', '2018-04-18 05:41:30'),
(62, 54, 'l6nejXtZVmJAYHCS.jpg', 8, NULL, 0, '2018-04-26 02:16:06', '2018-04-26 02:16:06'),
(63, 55, 'Dwj61jGVLrAEqow6.jpg', 8, NULL, 0, '2018-04-26 02:16:06', '2018-04-26 02:16:06'),
(64, 56, 'wXZQIS3L4hgXRU0O.jpg', 8, NULL, 0, '2018-04-26 02:16:06', '2018-04-26 02:16:06'),
(65, 57, 'i8S0yl8ZZuB2ms48.jpg', 8, NULL, 0, '2018-04-30 02:17:35', '2018-04-30 02:17:35'),
(66, 58, 'TNCaUmG4gMiCLZ7V.jpg', 8, NULL, 0, '2018-04-30 02:17:35', '2018-04-30 02:17:35'),
(67, 59, 'mQ5x1PTqaiznnT3o.jpg', 8, NULL, 0, '2018-04-30 02:17:35', '2018-04-30 02:17:35'),
(68, 60, 'HzWcSmCYWzfR5gzv.jpg', 8, NULL, 0, '2018-04-30 02:29:46', '2018-04-30 02:29:46'),
(69, 61, 'lsCQc3bVqSfTPZ8p.png', 8, NULL, 0, '2018-04-30 02:29:46', '2018-04-30 02:29:46'),
(70, 52, 'L9jBeovQDOTt9rkX.jpg', 8, NULL, 0, '2018-04-30 02:45:43', '2018-04-30 02:52:20'),
(71, 53, 'lIM1gOJFRA9RW77z.jpg', 8, NULL, 0, '2018-04-30 02:45:44', '2018-04-30 02:52:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receive`
--

CREATE TABLE `tbl_receive` (
  `id` int(10) UNSIGNED NOT NULL,
  `receive_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manufacturing_order_id` int(10) UNSIGNED NOT NULL,
  `collected_by` int(10) UNSIGNED NOT NULL,
  `is_qa_pass` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `qa_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `receive_status_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_receive`
--

INSERT INTO `tbl_receive` (`id`, `receive_no`, `manufacturing_order_id`, `collected_by`, `is_qa_pass`, `qa_description`, `receive_status_id`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(97, 'RR061800097', 88, 1, 1, NULL, 2, 8, NULL, 0, '2018-06-12 06:25:18', '2018-06-12 06:26:00'),
(98, 'RR061800098', 88, 1, 1, NULL, 2, 8, NULL, 0, '2018-06-12 06:25:29', '2018-06-12 06:31:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receive_products`
--

CREATE TABLE `tbl_receive_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `receive_id` int(10) UNSIGNED NOT NULL,
  `product_color_id` int(10) UNSIGNED NOT NULL,
  `product_qty` int(11) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_receive_products`
--

INSERT INTO `tbl_receive_products` (`id`, `receive_id`, `product_color_id`, `product_qty`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(196, 97, 51, 20, 8, NULL, '2018-06-12 06:25:18', '2018-06-12 06:25:18'),
(197, 97, 53, 7, 8, NULL, '2018-06-12 06:25:18', '2018-06-12 06:25:18'),
(198, 97, 52, 7, 8, NULL, '2018-06-12 06:25:18', '2018-06-12 06:25:18'),
(199, 97, 60, 7, 8, NULL, '2018-06-12 06:25:18', '2018-06-12 06:25:18'),
(200, 98, 61, 3, 8, NULL, '2018-06-12 06:25:29', '2018-06-12 06:25:29'),
(201, 98, 57, 12, 8, NULL, '2018-06-12 06:25:29', '2018-06-12 06:25:29'),
(202, 98, 58, 8, 8, NULL, '2018-06-12 06:25:29', '2018-06-12 06:25:29'),
(203, 98, 59, 2, 8, NULL, '2018-06-12 06:25:29', '2018-06-12 06:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receive_status`
--

CREATE TABLE `tbl_receive_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_receive_status`
--

INSERT INTO `tbl_receive_status` (`id`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'China Warehouse', 1, NULL, '2018-03-31 06:16:20', '2018-03-31 06:16:20'),
(2, 'Main Warehouse', 1, NULL, '2018-03-31 06:16:35', '2018-03-31 06:16:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receive_status_log`
--

CREATE TABLE `tbl_receive_status_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `recieve_id` int(10) UNSIGNED NOT NULL,
  `recieve_status_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_receive_status_log`
--

INSERT INTO `tbl_receive_status_log` (`id`, `recieve_id`, `recieve_status_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(97, 97, 1, 8, NULL, '2018-06-12 06:25:18', '2018-06-12 06:25:18'),
(98, 98, 1, 8, NULL, '2018-06-12 06:25:29', '2018-06-12 06:25:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_region`
--

CREATE TABLE `tbl_region` (
  `id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_region`
--

INSERT INTO `tbl_region` (`id`, `city_id`, `name`, `created_at`, `updated_at`) VALUES
(1, 2, 'GHQ', '2018-04-02 19:00:00', NULL),
(2, 1, 'Sadder', '2018-04-02 19:00:00', NULL),
(7, 1, 'Gulshan', '2018-04-03 07:09:55', '2018-04-03 07:09:55'),
(8, 1, 'PIDC', '2018-04-03 07:10:35', '2018-04-03 07:10:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retailer`
--

CREATE TABLE `tbl_retailer` (
  `id` int(10) UNSIGNED NOT NULL,
  `retailer_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cnic` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_retailer`
--

INSERT INTO `tbl_retailer` (`id`, `retailer_no`, `name`, `cnic`, `phone_no`, `image`, `is_deleted`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(23, 'DC041800023', 'Nabeel', '24242-4242432-4', '0322-1313131', 'qmplnN7YMfqZdIhL.jpg', 0, 8, NULL, '2018-04-18 05:55:47', '2018-04-18 05:55:47'),
(24, 'DC041800024', 'Umair', '11111-1155564-5', '0343-1111111', '2jsTThOmA0SxCHcd.png', 0, 12, NULL, '2018-04-30 08:39:09', '2018-04-30 08:39:09'),
(25, 'DC051800025', 'Muhammad Salman', '12345-6789101-1', '0123-456789_', 'cTvGU9NM4bNoKwyE.jpg', 0, 8, NULL, '2018-05-15 04:31:37', '2018-05-15 04:31:37'),
(26, 'DC051800026', 'fssdds', '32434-3243234-3', '2342-3423432', 'IcTvnXUFaaczau37.png', 0, 8, NULL, '2018-05-18 02:35:06', '2018-05-18 02:35:06'),
(27, 'DC051800027', '4ff', '23432-4234324-2', '2342-3423342', 'Xw0Z60baiAzX90IS.png', 0, 8, NULL, '2018-05-18 02:36:15', '2018-05-18 02:36:15'),
(28, 'DC051800028', '234232', '32424-4323432-3', '2343-2423432', 'stDQ5A2wt11MtK0y.png', 0, 8, NULL, '2018-05-18 02:38:25', '2018-05-18 02:38:25'),
(29, 'DC051800029', '43324234', '34343-4212143-3', '4433-2432432', 'phy5HOC5zi49Xyp0.png', 0, 8, NULL, '2018-05-18 02:39:23', '2018-05-18 02:39:23'),
(30, 'DC051800030', '42423423432', '43123-2132432-3', '2344-2454354', 'PYqtvXKIlphEc09P.png', 0, 8, NULL, '2018-05-18 02:40:27', '2018-05-18 02:40:27'),
(31, 'DC051800031', 'a', '11111-1111111-1', '1111-1111111', 'Sns7HJBfhhlZYjm3.png', 0, 8, NULL, '2018-05-18 02:42:21', '2018-05-18 02:42:21'),
(32, 'DC051800032', 'Muhammad Adil Moqeem', '42101-9752108-5', '0347-3099679', 'Fi0KFw12WgLTEYeA.jpg', 0, 8, NULL, '2018-05-18 05:17:30', '2018-05-18 05:17:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retailer_collection`
--

CREATE TABLE `tbl_retailer_collection` (
  `id` int(10) UNSIGNED NOT NULL,
  `bank_id` int(10) UNSIGNED NOT NULL,
  `collection_ds_id` int(11) NOT NULL,
  `currency_id` int(10) UNSIGNED NOT NULL,
  `payment_type_id` int(10) UNSIGNED NOT NULL,
  `retailer_id` int(10) UNSIGNED NOT NULL,
  `retailer_outlet_id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED NOT NULL,
  `amount` decimal(13,2) NOT NULL,
  `cheque_number` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deposit_slip_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_reversible` tinyint(4) NOT NULL DEFAULT '0',
  `remarks` longtext COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retailer_collection_deposit_slip`
--

CREATE TABLE `tbl_retailer_collection_deposit_slip` (
  `id` int(11) NOT NULL,
  `deposit_slip_number` varchar(20) NOT NULL,
  `total_amount` decimal(13,2) NOT NULL,
  `bank_id` int(11) NOT NULL,
  `currenct_id` int(11) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `retailer_id` int(11) NOT NULL,
  `retailer_outlet_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retailer_order`
--

CREATE TABLE `tbl_retailer_order` (
  `id` int(10) UNSIGNED NOT NULL,
  `order_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `retailer_id` int(10) UNSIGNED NOT NULL,
  `sales_officer_id` int(10) UNSIGNED NOT NULL,
  `outlet_id` int(10) UNSIGNED NOT NULL,
  `total_cost` int(10) UNSIGNED NOT NULL,
  `remaining_payment` int(10) UNSIGNED NOT NULL,
  `is_account_clearance` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `is_forcefully_approve` int(11) NOT NULL DEFAULT '0',
  `clearance_remarks` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `retailer_order_status_id` int(10) UNSIGNED NOT NULL,
  `is_delivered` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_retailer_order`
--

INSERT INTO `tbl_retailer_order` (`id`, `order_no`, `retailer_id`, `sales_officer_id`, `outlet_id`, `total_cost`, `remaining_payment`, `is_account_clearance`, `is_forcefully_approve`, `clearance_remarks`, `is_deleted`, `retailer_order_status_id`, `is_delivered`, `warehouse_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(115, 'CR06180000115', 23, 5, 18, 108000, 108000, 1, 1, 'ok', 0, 1, 0, 4, 12, 12, '2018-06-12 07:12:08', '2018-06-12 07:24:04'),
(116, 'CR06180000116', 23, 5, 18, 14000, 14000, 1, 0, NULL, 0, 1, 1, 4, 8, 8, '2018-06-14 02:46:42', '2018-06-14 03:38:03'),
(117, 'CR06180000117', 23, 5, 18, 14000, 14000, 1, 0, 'jh', 0, 1, 1, 4, 8, 8, '2018-06-14 02:51:39', '2018-06-14 02:52:10'),
(118, 'CR06180000118', 23, 5, 18, 14000, 14000, 1, 0, 'sdf', 0, 1, 1, 4, 8, 8, '2018-06-14 02:59:56', '2018-06-14 03:00:07'),
(119, 'CR06180000119', 23, 5, 18, 28000, 28000, 1, 1, 'ghj', 0, 1, 1, 4, 8, 8, '2018-06-14 03:01:36', '2018-06-14 03:01:49'),
(120, 'CR06180000120', 23, 5, 18, 28000, 28000, 1, 1, 'yu', 0, 1, 1, 4, 8, 8, '2018-06-14 03:02:52', '2018-06-14 03:03:06'),
(121, 'CR06180000121', 23, 5, 18, 70000, 70000, 1, 1, 'd', 0, 1, 1, 4, 8, 8, '2018-06-14 03:07:26', '2018-06-14 03:44:51'),
(122, 'CR06180000122', 23, 5, 18, 14000, 14000, 1, 0, '5', 0, 1, 1, 4, 8, 8, '2018-06-14 03:10:51', '2018-06-14 03:33:54'),
(123, 'CR06180000123', 23, 5, 18, 28000, 28000, 1, 1, 'sad', 0, 1, 1, 4, 8, 8, '2018-06-14 03:14:41', '2018-06-14 03:14:56'),
(124, 'CR06180000124', 23, 5, 18, 28000, 28000, 1, 1, 'asd', 0, 1, 1, 4, 8, 8, '2018-06-14 03:21:42', '2018-06-14 03:23:27'),
(125, 'CR06180000125', 23, 5, 18, 28000, 28000, 1, 1, 'sdf', 0, 1, 0, 4, 8, 8, '2018-06-14 03:25:50', '2018-06-14 03:26:01');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retailer_order_products`
--

CREATE TABLE `tbl_retailer_order_products` (
  `id` int(10) UNSIGNED NOT NULL,
  `retailer_order_id` int(10) UNSIGNED NOT NULL,
  `product_color_id` int(10) UNSIGNED NOT NULL,
  `product_qty` int(10) UNSIGNED NOT NULL,
  `unit_price` int(10) UNSIGNED NOT NULL,
  `remaining_qty` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `is_delivered` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `total_price` decimal(13,2) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_retailer_order_products`
--

INSERT INTO `tbl_retailer_order_products` (`id`, `retailer_order_id`, `product_color_id`, `product_qty`, `unit_price`, `remaining_qty`, `is_delivered`, `is_deleted`, `total_price`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(138, 115, 51, 5, 14000, 0, 0, 0, '70000.00', 12, NULL, '2018-06-12 07:12:08', '2018-06-12 07:12:08'),
(139, 115, 52, 2, 12000, 0, 0, 0, '24000.00', 12, NULL, '2018-06-12 07:12:08', '2018-06-12 07:12:08'),
(140, 115, 60, 2, 7000, 0, 0, 0, '14000.00', 12, NULL, '2018-06-12 07:12:08', '2018-06-12 07:12:08'),
(141, 116, 51, 1, 14000, 0, 1, 0, '14000.00', 8, NULL, '2018-06-14 02:46:42', '2018-06-14 02:46:59'),
(142, 117, 51, 1, 14000, 0, 1, 0, '14000.00', 8, NULL, '2018-06-14 02:51:39', '2018-06-14 02:52:10'),
(143, 118, 51, 1, 14000, 0, 1, 0, '14000.00', 8, NULL, '2018-06-14 02:59:56', '2018-06-14 03:00:07'),
(144, 119, 51, 2, 14000, 0, 1, 0, '28000.00', 8, NULL, '2018-06-14 03:01:36', '2018-06-14 03:01:49'),
(145, 120, 51, 2, 14000, 0, 1, 0, '28000.00', 8, NULL, '2018-06-14 03:02:52', '2018-06-14 03:03:06'),
(146, 121, 51, 5, 14000, 0, 1, 0, '70000.00', 8, NULL, '2018-06-14 03:07:26', '2018-06-14 03:07:38'),
(147, 122, 51, 1, 14000, 0, 1, 0, '14000.00', 8, NULL, '2018-06-14 03:10:51', '2018-06-14 03:11:11'),
(148, 123, 51, 2, 14000, 0, 1, 0, '28000.00', 8, NULL, '2018-06-14 03:14:41', '2018-06-14 03:14:56'),
(149, 124, 51, 2, 14000, 0, 1, 0, '28000.00', 8, NULL, '2018-06-14 03:21:42', '2018-06-14 03:22:01'),
(150, 125, 51, 2, 14000, 0, 0, 0, '28000.00', 8, NULL, '2018-06-14 03:25:51', '2018-06-14 03:25:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retailer_order_status`
--

CREATE TABLE `tbl_retailer_order_status` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_retailer_order_status`
--

INSERT INTO `tbl_retailer_order_status` (`id`, `status`) VALUES
(1, 'Order Received');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_retailer_outlet`
--

CREATE TABLE `tbl_retailer_outlet` (
  `id` int(10) UNSIGNED NOT NULL,
  `retailer_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `region_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `business_person_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_no` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_person_cnic` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `security_deposit_amount` int(11) NOT NULL,
  `security_deposit_image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_limit` int(11) NOT NULL,
  `credit_duration` int(11) NOT NULL,
  `credit_remaining` int(11) NOT NULL,
  `aging_amount` int(11) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_retailer_outlet`
--

INSERT INTO `tbl_retailer_outlet` (`id`, `retailer_id`, `city_id`, `region_id`, `name`, `phone_no`, `latitude`, `longitude`, `business_person_name`, `mobile_no`, `business_person_cnic`, `address`, `security_deposit_amount`, `security_deposit_image`, `credit_limit`, `credit_duration`, `credit_remaining`, `aging_amount`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(18, 23, 1, 2, 'Nabeel Outlet', '0312-313123_', NULL, NULL, 'Nabeel', '0322-1313131', '24242-4242432-4', 'Sadder, Karachi', 150000, 'qBxeSoMPlZHcsxZ0.jpg', 15000, 23, 15000, 0, 8, NULL, 0, '2018-04-18 05:55:47', '2018-04-18 05:55:47'),
(19, 24, 1, 7, 'Bismillah Mobile Shop', '0342-7860167', NULL, NULL, 'Umair', '0343-1111111', '11111-1155564-5', 'Block 13D, bismillah shop', 50000, 'mH06DFrIKNOgKm61.png', 100000, 25, 100000, 0, 12, NULL, 0, '2018-04-30 08:39:09', '2018-04-30 08:39:09'),
(20, 25, 1, 2, 'Mobile Galary', '0123-4567891', NULL, NULL, 'Muhammad Salman', '0123-456789_', '12345-6789101-1', 'Shop#15 Amma Tower Saddar Karachi.', 50000, 'TtFVGGFdnRP7Dz8k.jpg', 40000, 23, 40000, 0, 8, NULL, 0, '2018-05-15 04:31:38', '2018-05-15 04:31:38'),
(21, 26, 1, 7, 'Wad4432', '4323-4243243', NULL, NULL, 'fssdds', '2342-3423432', '32434-3243234-3', 'fdfsd', 0, 'lTqg3qxp3ZYgBP10.png', 0, 0, 0, 0, 8, NULL, 0, '2018-05-18 02:35:07', '2018-05-18 02:35:07'),
(22, 27, 2, 1, 'fsdds', '4223-3111123', NULL, NULL, '4ff', '2342-3423342', '23432-4234324-2', '234fefds', 24, 'AuQh62wpEmhC7eAE.png', 32432, 23432, 32432, 0, 8, NULL, 0, '2018-05-18 02:36:15', '2018-05-18 02:36:15'),
(23, 28, 1, 2, 'rere', '2343-2423423', NULL, NULL, '234232', '2343-2423432', '32424-4323432-3', '3432432432', 43, 'fNjEsKdwZ5EA1QAi.png', 43, 34, 43, 0, 8, NULL, 0, '2018-05-18 02:38:25', '2018-05-18 02:38:25'),
(24, 29, 1, 2, 'fdsf', '2432-4322343', NULL, NULL, '43324234', '4433-2432432', '34343-4212143-3', '3243342', 432, '9xcClh1LCMg0JMag.png', 432, 4, 432, 0, 8, NULL, 0, '2018-05-18 02:39:23', '2018-05-18 02:39:23'),
(25, 30, 1, 7, 'we2342', '4323-4343243', NULL, NULL, '42423423432', '2344-2454354', '43123-2132432-3', '432432432', 43, 'Xox2uezsGtLOTnbx.png', 32432, 24, 32432, 0, 8, NULL, 0, '2018-05-18 02:40:27', '2018-05-18 02:40:27'),
(26, 31, 1, 2, 'a', '1111-1111111', NULL, NULL, 'a', '1111-1111111', '11111-1111111-1', '111', 111, 'FOb3cAzpBTf0JZky.png', 111, 111, 111, 0, 8, NULL, 0, '2018-05-18 02:42:21', '2018-05-18 02:42:21'),
(27, 32, 1, 2, 'Xcell & co', '0347-3099679', NULL, NULL, 'Muhammad Adil Moqeem', '0347-3099679', '42101-9752108-5', 'A-40 gulberg square', 40000, 'MUooWPlYiBL02sY9.png', 100000, 25, 100000, 0, 8, NULL, 0, '2018-05-18 05:17:30', '2018-05-18 05:17:30');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`id`, `role`, `description`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Manager', 'This is our Manager', 8, 8, 0, '2018-06-13 07:20:05', '2018-06-14 06:26:15'),
(2, 'New role', 'DOne', 8, NULL, 0, '2018-06-14 03:03:23', '2018-06-14 03:03:23'),
(3, 'SO', 'dada', 8, NULL, 0, '2018-06-14 06:27:57', '2018-06-14 06:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role_permission`
--

CREATE TABLE `tbl_role_permission` (
  `id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `permission_id` int(10) UNSIGNED NOT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_role_permission`
--

INSERT INTO `tbl_role_permission` (`id`, `role_id`, `permission_id`, `is_deleted`, `created_at`, `updated_at`) VALUES
(3, 2, 1, 0, NULL, NULL),
(10, 1, 1, 0, NULL, NULL),
(11, 1, 2, 0, NULL, NULL),
(12, 1, 10, 0, NULL, NULL),
(13, 3, 1, 0, NULL, NULL),
(14, 3, 2, 0, NULL, NULL),
(15, 3, 10, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_specs_category`
--

CREATE TABLE `tbl_specs_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `specs_category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_specs_category`
--

INSERT INTO `tbl_specs_category` (`id`, `specs_category_name`) VALUES
(1, 'Network'),
(2, 'Camera'),
(4, 'Body'),
(5, 'Platform'),
(6, 'Memory'),
(7, 'Comms'),
(8, 'Battery'),
(9, 'Features'),
(10, 'Display'),
(11, 'Sound'),
(12, 'MISC');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_specs_product`
--

CREATE TABLE `tbl_specs_product` (
  `id` int(10) UNSIGNED NOT NULL,
  `specs_sub_category_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(11) NOT NULL,
  `detail_name` varchar(800) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_specs_product`
--

INSERT INTO `tbl_specs_product` (`id`, `specs_sub_category_id`, `product_id`, `detail_name`) VALUES
(1, 1, 70, 'GSM/HSPA/LTE'),
(2, 2, 70, 'GSM 850 / 900 / 1800 / 1900 - SIM 1 & SIM 2 (dual-SIM model only)'),
(3, 3, 70, 'HSDPA 850 / 900 / 1700(AWS) / 1900 / 2100'),
(4, 4, 70, 'LTE band 1(2100), 2(1900), 3(1800), 4(1700/2100), 5(850), 7(2600), 8(900), 12(700), 13(700), 17(700), 18(800), 19(800), 20(800), 26(850), 28(700), 38(2600), 40(2300), 41(2500), 66(1700/2100)'),
(5, 5, 70, 'Yes'),
(6, 6, 70, 'Yes'),
(7, 11, 70, '159.9 x 75.7 x 8.3 mm (6.30 x 2.98 x 0.33 in)'),
(8, 12, 70, '191 g (6.74 oz)'),
(9, 13, 70, 'Front/back glass, aluminum frame'),
(10, 14, 70, 'Single SIM (Nano-SIM) or Dual SIM (Nano-SIM, dual stand-by)'),
(11, 7, 70, '16 MP (f/1.7, 1/2.8”, 1.12µm), phase detection autofocus, LED flash'),
(12, 8, 70, 'Dual: 16 MP (f/1.9, 1/3.1”, 1.0µm) + 8 MP (f/1.9, 1/4.0”, 1.12µm), 1080p'),
(13, 9, 70, '1080p@30fps'),
(14, 10, 70, 'Geo-tagging, touch focus, face detection, panorama, HDR'),
(15, 16, 70, 'Android 7.1.1 (Nougat)'),
(16, 17, 70, 'Exynos 7885 Octa'),
(17, 18, 70, 'Octa-core (2x2.2 GHz Cortex-A73 & 6x1.6 GHz Cortex-A53)'),
(18, 19, 70, 'Mali-G71'),
(19, 20, 70, 'microSD, up to 256 GB (dedicated slot)'),
(20, 21, 70, '64 GB, 6 GB RAM or 32 GB, 4 GB RAM'),
(21, 22, 70, 'Wi-Fi 802.11 a/b/g/n/ac, dual-band, WiFi Direct, hotspot'),
(22, 23, 70, '5.0, A2DP, EDR, LE'),
(23, 24, 70, 'Yes, with A-GPS, GLONASS, BDS'),
(24, 25, 70, 'Yes'),
(25, 26, 70, 'FM radio'),
(26, 27, 70, '2.0, Type-C 1.0 reversible connector'),
(27, 29, 70, 'Non-removable Li-Ion 3500 mAh battery'),
(28, 30, 70, 'Up to 23 h (3G)'),
(29, 31, 70, 'Up to 73 h'),
(30, 32, 70, 'Fingerprint (rear-mounted), accelerometer, gyro, proximity, compass, barometer'),
(31, 33, 70, 'SMS(threaded view), MMS, Email, Push Email, IM'),
(32, 34, 70, 'HTML5'),
(33, 35, 70, 'Super AMOLED capacitive touchscreen, 16M colors'),
(34, 36, 70, '6.0 inches, 91.4 cm2 (~75.5% screen-to-body ratio)'),
(35, 37, 70, '1080 x 2220 pixels, 18.5:9 ratio (~411 ppi density)'),
(36, 38, 70, 'Yes'),
(37, 39, 70, 'Corning Gorilla Glass (unspecified version)'),
(38, 41, 70, 'Vibration; MP3, WAV ringtones'),
(39, 42, 70, 'Yes'),
(40, 43, 70, 'Yes'),
(41, 45, 70, 'Light Blue Dark Black '),
(42, 46, 70, '13000(0%) 14000(0%) '),
(43, 1, 71, 'GSM: B5(850)'),
(44, 2, 71, NULL),
(45, 3, 71, NULL),
(46, 4, 71, NULL),
(47, 5, 71, NULL),
(48, 6, 71, NULL),
(49, 11, 71, '141.45x71.7X9.35mm'),
(50, 12, 71, '0.319KG'),
(51, 13, 71, 'almunium Alloy'),
(52, 14, 71, 'Dual SIM, micor sim'),
(53, 7, 71, '5.0 MP FF'),
(54, 8, 71, '8.0 MP AF+2.0MP FF'),
(55, 9, 71, '1280x720'),
(56, 10, 71, 'Dual Rear Flash LED Support'),
(57, 16, 71, '7.0 Nougat'),
(58, 17, 71, NULL),
(59, 18, 71, 'MTK 6580A Quad core 1.3Ghz'),
(60, 19, 71, 'MALI - 400np2 500Mhz'),
(61, 20, 71, '256 GB micro SD'),
(62, 21, 71, 'Ram 2 GB, ROM 16 GB'),
(63, 22, 71, '2.4 G'),
(64, 23, 71, '4'),
(65, 24, 71, 'GPS+A-GPS'),
(66, 25, 71, NULL),
(67, 26, 71, 'Support'),
(68, 27, 71, NULL),
(69, 29, 71, '2600Mhz, Detachable lithuium-ion battery'),
(70, 30, 71, NULL),
(71, 31, 71, NULL),
(72, 32, 71, NULL),
(73, 33, 71, NULL),
(74, 34, 71, NULL),
(75, 35, 71, 'HD'),
(76, 36, 71, '5.0`'),
(77, 37, 71, '1280x720'),
(78, 38, 71, 'Two-point touch, G+F Technology'),
(79, 39, 71, NULL),
(80, 41, 71, NULL),
(81, 42, 71, NULL),
(82, 43, 71, 'Standard Interface'),
(83, 45, 71, 'Black Blue '),
(84, 46, 71, '12000(0%) 13000(0%) '),
(85, 1, 72, 'GSM'),
(86, 2, 72, NULL),
(87, 3, 72, NULL),
(88, 4, 72, NULL),
(89, 5, 72, 'Yes'),
(90, 6, 72, NULL),
(91, 11, 72, NULL),
(92, 12, 72, NULL),
(93, 13, 72, NULL),
(94, 14, 72, 'Dual SIM, Dual Standby SIM + SIM'),
(95, 7, 72, '0.08MP'),
(96, 8, 72, NULL),
(97, 9, 72, NULL),
(98, 10, 72, NULL),
(99, 16, 72, NULL),
(100, 17, 72, 'SC6531E'),
(101, 18, 72, NULL),
(102, 19, 72, NULL),
(103, 20, 72, 'Yes'),
(104, 21, 72, '32MB'),
(105, 22, 72, NULL),
(106, 23, 72, '4'),
(107, 24, 72, NULL),
(108, 25, 72, NULL),
(109, 26, 72, 'Yes'),
(110, 27, 72, NULL),
(111, 29, 72, '500mAh (4C)'),
(112, 30, 72, NULL),
(113, 31, 72, NULL),
(114, 32, 72, NULL),
(115, 33, 72, 'Yes'),
(116, 34, 72, NULL),
(117, 35, 72, 'QVGA'),
(118, 36, 72, '1.7\"'),
(119, 37, 72, '128x160'),
(120, 38, 72, NULL),
(121, 39, 72, NULL),
(122, 41, 72, NULL),
(123, 42, 72, NULL),
(124, 43, 72, NULL),
(125, 45, 72, 'Black Blue White '),
(126, 46, 72, '8000(0%) 8000(0%) 8000(0%) '),
(127, 1, 73, 'GSM/HSPA/LTE'),
(128, 2, 73, 'GSM 850 / 900 / 1800 / 1900 - SIM 1 & SIM 2 (dual-SIM model only)'),
(129, 3, 73, 'HSDPA 850 / 900 / 1900 / 2100'),
(130, 4, 73, 'LTE band 1(2100), 3(1800), 5(850), 7(2600), 8(900), 20(800), 38(2600), 40(2300)'),
(131, 5, 73, 'Yes'),
(132, 6, 73, 'No'),
(133, 11, 73, '151.7 x 75 x 8 mm (5.97 x 2.95 x 0.31 in)'),
(134, 12, 73, '167 g (5.89 oz)'),
(135, 13, 73, 'Front glass, aluminum body, plastic ends'),
(136, 14, 73, 'Single SIM (Nano-SIM) or Dual SIM (Nano-SIM, dual stand-by)'),
(137, 7, 73, '13 MP (f/1.9, 28mm), autofocus, LED flash'),
(138, 8, 73, '8 MP, f/1.9'),
(139, 9, 73, '1080p@30fps'),
(140, 10, 73, 'Geo-tagging, touch focus, face detection, panorama, HDR'),
(141, 16, 73, 'Android 6.0.1 (Marshmallow), upgradable to 7.0 (Nougat)'),
(142, 17, 73, 'Exynos 7870 Octa'),
(143, 18, 73, 'Octa-core 1.6 GHz Cortex-A53'),
(144, 19, 73, 'Mali-T830 MP1'),
(145, 20, 73, 'microSD, up to 256 GB (dedicated slot)'),
(146, 21, 73, '16/32 GB, 3 GB RAM'),
(147, 22, 73, 'Wi-Fi 802.11 b/g/n, Wi-Fi Direct, hotspot'),
(148, 23, 73, '4.1, A2DP, LE'),
(149, 24, 73, 'Yes, with A-GPS, GLONASS, BDS'),
(150, 25, 73, NULL),
(151, 26, 73, 'FM radio'),
(152, 27, 73, 'microUSB 2.0, USB On-The-Go'),
(153, 29, 73, 'Non-removable Li-Ion 3300 mAh battery'),
(154, 30, 73, 'Up to 21 h (3G)'),
(155, 31, 73, 'Up to 84 h'),
(156, 32, 73, 'Fingerprint (front-mounted), accelerometer, proximity'),
(157, 33, 73, 'SMS(threaded view), MMS, Email, Push Email, IM'),
(158, 34, 73, 'HTML5'),
(159, 35, 73, 'PLS TFT capacitive touchscreen, 16M colors'),
(160, 36, 73, '5.5 inches, 83.4 cm2 (~73.3% screen-to-body ratio)'),
(161, 37, 73, '1080 x 1920 pixels, 16:9 ratio (~401 ppi density)'),
(162, 38, 73, 'Yes'),
(163, 39, 73, 'Corning Gorilla Glass (market dependent)'),
(164, 41, 73, 'Vibration; MP3, WAV ringtones'),
(165, 42, 73, 'Yes'),
(166, 43, 73, 'Yes'),
(167, 45, 73, 'White Black Blue '),
(168, 46, 73, '15000(0%) 15000(0%) 16000(0%) '),
(169, 1, 74, 'GSM/GPRS'),
(170, 2, 74, 'GSM/GPRS 900: Tx: 880-915MHz, Rx: 925-960MHz'),
(171, 3, 74, 'GSM/GPRS 1800: Tx: 1710-1785MHz, Rx: 1805-1880MHz'),
(172, 4, 74, NULL),
(173, 5, 74, 'Yes'),
(174, 6, 74, 'No'),
(175, 11, 74, '128*160'),
(176, 12, 74, NULL),
(177, 13, 74, NULL),
(178, 14, 74, 'Dual Sim'),
(179, 7, 74, '0.08 MP'),
(180, 8, 74, NULL),
(181, 9, 74, NULL),
(182, 10, 74, NULL),
(183, 16, 74, NULL),
(184, 17, 74, 'SC6531E'),
(185, 18, 74, NULL),
(186, 19, 74, NULL),
(187, 20, 74, NULL),
(188, 21, 74, 'ROM: 32 MB'),
(189, 22, 74, NULL),
(190, 23, 74, 'Yes'),
(191, 24, 74, NULL),
(192, 25, 74, NULL),
(193, 26, 74, 'Supported'),
(194, 27, 74, NULL),
(195, 29, 74, '500mAh (4C)'),
(196, 30, 74, NULL),
(197, 31, 74, NULL),
(198, 32, 74, NULL),
(199, 33, 74, 'SMS'),
(200, 34, 74, NULL),
(201, 35, 74, 'QVGA'),
(202, 36, 74, '1.7\'\''),
(203, 37, 74, '128*160'),
(204, 38, 74, NULL),
(205, 39, 74, NULL),
(206, 41, 74, 'MP3, AAC, ASF, etc'),
(207, 42, 74, 'Yes'),
(208, 43, 74, '3.5MM standard interface'),
(209, 45, 74, 'Black White '),
(210, 46, 74, '7000(0%) 8000(0%) ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_specs_sub_category`
--

CREATE TABLE `tbl_specs_sub_category` (
  `id` int(10) UNSIGNED NOT NULL,
  `specs_category_id` int(10) UNSIGNED NOT NULL,
  `specs_sub_category_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_specs_sub_category`
--

INSERT INTO `tbl_specs_sub_category` (`id`, `specs_category_id`, `specs_sub_category_name`) VALUES
(1, 1, 'Technology'),
(2, 1, '2G bands'),
(3, 1, '3G Bands'),
(4, 1, '4G Bands'),
(5, 1, 'GPRS'),
(6, 1, 'EDGE'),
(7, 2, 'Primary'),
(8, 2, 'Secondary'),
(9, 2, 'Video'),
(10, 2, 'Features'),
(11, 4, 'Dimensions'),
(12, 4, 'Weight'),
(13, 4, 'Build'),
(14, 4, 'SIM'),
(16, 5, 'OS'),
(17, 5, 'Chipset'),
(18, 5, 'CPU'),
(19, 5, 'GPU'),
(20, 6, 'Card Slot'),
(21, 6, 'Internal'),
(22, 7, 'WLAN'),
(23, 7, 'Bluetooth'),
(24, 7, 'GPS'),
(25, 7, 'NFC'),
(26, 7, 'Radio'),
(27, 7, 'USB'),
(29, 8, 'Type'),
(30, 8, 'Talk time'),
(31, 8, 'Music play'),
(32, 9, 'Sensors'),
(33, 9, 'Messaging'),
(34, 9, 'Browser'),
(35, 10, 'Type'),
(36, 10, 'Size'),
(37, 10, 'Resolution'),
(38, 10, 'Multitouch'),
(39, 10, 'Protection'),
(41, 11, 'Alert Types'),
(42, 11, 'Loudspeaker'),
(43, 11, '3.5mm jack'),
(45, 12, 'Colors'),
(46, 12, 'Price');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phoneNumber` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CNIC` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `region_id` int(10) UNSIGNED NOT NULL,
  `department_id` int(10) UNSIGNED NOT NULL,
  `staff_type_id` int(10) UNSIGNED NOT NULL,
  `designation_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`id`, `name`, `phoneNumber`, `email`, `CNIC`, `address`, `city_id`, `region_id`, `department_id`, `staff_type_id`, `designation_id`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(1, 'Fahad Khan', '0333-3334448', 'fahad@gmail.com', '42324-8890877-7', 'Hina Garden', 1, 2, 2, 5, 3, 1, NULL, 0, '2018-03-27 03:07:08', '2018-03-31 05:01:06'),
(5, 'Ali Haider', '6546-5414554', 'syed_alihaider@live.com', '32123-1121212-3', 'abc road', 2, 2, 2, 5, 3, 8, 7, 0, '2018-03-28 02:18:22', '2018-04-13 07:03:07'),
(7, 'hammad', '1111-1111111', 'hmmdkhan18@gmail.com', '11111-1111111-1', 'abc', 1, 2, 1, 1, 1, 1, NULL, 0, '2018-03-29 00:31:04', '2018-03-29 00:31:04'),
(11, 'ali', '2222-2222222', 'admin1@admin.com', '23123-1231312-3', '1111', 1, 1, 2, 5, 4, 8, NULL, 0, '2018-03-29 00:59:21', '2018-04-13 06:59:13'),
(12, 'nabeel', '4444-4049409', 'nabeel@gmail.com', '12121-2121212-1', '121313', 1, 2, 2, 2, 2, 1, NULL, 0, '2018-03-29 01:23:01', '2018-03-31 05:02:30'),
(16, 'Ali', '0321-2112222', 'test123@test.com', '44557-7777789-4', 'Demo', 1, 2, 2, 3, 3, 1, NULL, 0, '2018-03-31 05:05:26', '2018-03-31 05:05:26'),
(17, 'Junaid Kaim khani', '2326-2362626', 'junaid@yahoo.com', '45455-4545454-5', 'gharo rahim yar khan karachi', 1, 1, 2, 2, 2, 8, NULL, 0, '2018-04-10 06:02:53', '2018-04-13 06:57:37'),
(20, 'Wajahat', '2112-3123123', 'wajahat@gmail.com', '12312-3123123-1', 'NIPA', 1, 7, 3, 2, 2, 8, NULL, 0, '2018-04-11 07:56:45', '2018-04-11 07:56:45'),
(21, 'Ali Khan', '4435-6436467', 'ali@gmail.com', '86764-3431346-7', 'Johar Mor', 1, 1, 1, 1, 1, 8, NULL, 0, '2018-04-13 06:45:08', '2018-04-13 06:45:08'),
(24, 'Maddy', '1312-3123123', 'maddy@gmail.com', '12312-3131231-2', 'sasdasda', 1, 1, 2, 1, 1, 8, NULL, 0, '2018-04-24 02:44:46', '2018-04-24 02:44:46'),
(27, 'Mohsin', '0300-1324567', 'mohsin@xsys.com', '13213-2456464-6', 'Gulshan', 1, 8, 3, 5, 2, 8, NULL, 0, '2018-05-11 05:43:03', '2018-05-11 05:43:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff_type`
--

CREATE TABLE `tbl_staff_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_staff_type`
--

INSERT INTO `tbl_staff_type` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Programmer', '2018-03-28 19:00:00', NULL),
(2, 'Manager', '2018-03-28 19:00:00', NULL),
(3, 'Accountant', '2018-03-28 19:00:00', NULL),
(4, 'Admin', '2018-03-28 19:00:00', NULL),
(5, 'Sales Person', '2018-03-28 19:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_state`
--

CREATE TABLE `tbl_state` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_state`
--

INSERT INTO `tbl_state` (`id`, `name`) VALUES
(1, 'Sindh'),
(2, 'Punjab'),
(3, 'Balochistan'),
(4, 'KPK');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_role`
--

CREATE TABLE `tbl_user_role` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_user_role`
--

INSERT INTO `tbl_user_role` (`id`, `user_id`, `role_id`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(17, 10, 2, NULL, NULL, 0, NULL, NULL),
(18, 8, 1, NULL, NULL, 0, NULL, NULL),
(19, 8, 2, NULL, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse`
--

CREATE TABLE `tbl_warehouse` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_type_id` int(10) UNSIGNED NOT NULL,
  `city_id` int(10) UNSIGNED NOT NULL,
  `region_id` int(10) UNSIGNED DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `warehouse_manager` int(10) UNSIGNED DEFAULT NULL,
  `warehouse_accountant` int(10) UNSIGNED DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_warehouse`
--

INSERT INTO `tbl_warehouse` (`id`, `name`, `warehouse_type_id`, `city_id`, `region_id`, `latitude`, `longitude`, `address`, `warehouse_manager`, `warehouse_accountant`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(3, 'DDL', 1, 1, 2, 24.9157, 67.0928, 'Zainab Market, Block 11', 12, 16, 1, NULL, 0, '2018-03-31 05:57:22', '2018-03-31 05:57:22'),
(4, 'Deploy', 1, 2, 2, 24.9157, 1233.125, 'Near Faysal Masjid', 12, 16, 3, NULL, 0, '2018-04-03 04:28:52', '2018-04-03 04:28:52'),
(5, 'Gulshan Warehouse', 1, 1, 7, NULL, NULL, 'Rashid Minhas Rd', 12, 16, 3, NULL, 0, '2018-04-10 09:41:48', '2018-04-11 04:39:18'),
(6, 'Johar Warehouse', 1, 1, 7, NULL, NULL, 'Millenium mall warehouse', 20, 16, 8, NULL, 0, '2018-04-11 08:13:55', '2018-04-11 08:13:55'),
(7, 'ABC warehouse', 1, 1, 7, NULL, NULL, 'asdad', 20, 16, 8, NULL, 0, '2018-04-11 08:16:00', '2018-04-11 08:16:00'),
(30, 'Abc warehouse', 1, 1, 8, NULL, NULL, 'II Chundrigarh', 17, 16, 10, NULL, 0, '2018-04-26 06:00:40', '2018-04-26 06:00:40'),
(31, 'South Warehouse', 1, 1, 7, NULL, NULL, 'St#11, Khayaban-e-Rahat', 20, 16, 8, NULL, 0, '2018-05-04 06:18:23', '2018-05-04 06:18:23'),
(32, 'Nazimabad R Warehouse', 2, 1, 1, NULL, NULL, 'Nazimabad B#2', 20, 16, 8, NULL, 0, '2018-05-11 02:36:55', '2018-05-11 02:36:55'),
(35, 'Scale Warehouse', 1, 1, 7, NULL, NULL, 'KDA society', 20, 16, 8, NULL, 0, '2018-05-17 05:50:48', '2018-05-17 05:50:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse_issue`
--

CREATE TABLE `tbl_warehouse_issue` (
  `id` int(10) UNSIGNED NOT NULL,
  `invoice_id` int(10) UNSIGNED DEFAULT NULL,
  `invoice_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` int(10) UNSIGNED DEFAULT NULL,
  `is_issued` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_warehouse_issue`
--

INSERT INTO `tbl_warehouse_issue` (`id`, `invoice_id`, `invoice_no`, `warehouse_id`, `is_issued`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '18KS000001', 4, 2, 8, '2018-06-14 02:46:59', '2018-06-14 03:38:03'),
(2, 2, '18KS000002', 4, 1, 8, '2018-06-14 02:52:10', '2018-06-14 02:52:27'),
(3, 3, '18KS000003', 4, 1, 8, '2018-06-14 03:00:07', '2018-06-14 03:00:26'),
(4, 4, '18KS000004', 4, 1, 8, '2018-06-14 03:01:49', '2018-06-14 03:02:09'),
(5, 5, '18KS000005', 4, 1, 8, '2018-06-14 03:03:06', '2018-06-14 03:03:35'),
(6, 6, '18KS000006', 4, 2, 8, '2018-06-14 03:07:38', '2018-06-14 03:44:50'),
(7, 7, '18KS000007', 4, 0, 8, '2018-06-14 03:11:11', '2018-06-14 03:11:11'),
(8, 8, '18KS000008', 4, 1, 8, '2018-06-14 03:14:56', '2018-06-14 03:15:25'),
(9, 9, '18KS000009', 4, 1, 8, '2018-06-14 03:22:01', '2018-06-14 03:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse_issue_items`
--

CREATE TABLE `tbl_warehouse_issue_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `warehouse_issue_id` int(10) UNSIGNED NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_warehouse_issue_items`
--

INSERT INTO `tbl_warehouse_issue_items` (`id`, `warehouse_issue_id`, `item_id`, `created_by`, `created_at`, `updated_at`) VALUES
(12, 9, 516, 8, '2018-06-14 03:22:47', '2018-06-14 03:22:47'),
(13, 9, 517, 8, '2018-06-14 03:22:47', '2018-06-14 03:22:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse_staff`
--

CREATE TABLE `tbl_warehouse_staff` (
  `id` int(10) UNSIGNED NOT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `staff_id` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_warehouse_staff`
--

INSERT INTO `tbl_warehouse_staff` (`id`, `warehouse_id`, `staff_id`, `created_by`, `updated_by`, `is_deleted`, `created_at`, `updated_at`) VALUES
(7, 3, 1, 1, 13, 0, '2018-03-31 05:59:14', '2018-05-11 06:35:52'),
(15, 3, 21, 1, 8, 0, '2018-04-16 19:00:00', '2018-04-24 02:45:09'),
(16, 4, 5, 1, 12, 0, '2018-04-16 19:00:00', '2018-06-12 07:11:20'),
(17, 4, 24, 8, 8, 0, '2018-04-24 02:45:20', '2018-04-30 07:59:25'),
(18, 3, 27, 8, NULL, 0, '2018-05-11 05:47:19', '2018-05-11 05:47:19'),
(19, 4, 12, 12, NULL, 0, '2018-06-12 07:09:02', '2018-06-12 07:09:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse_stock`
--

CREATE TABLE `tbl_warehouse_stock` (
  `id` int(10) UNSIGNED NOT NULL,
  `warehouse_id` int(10) UNSIGNED NOT NULL,
  `product_color_id` int(10) UNSIGNED NOT NULL,
  `product_qty` int(10) UNSIGNED NOT NULL,
  `is_deleted` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_warehouse_stock`
--

INSERT INTO `tbl_warehouse_stock` (`id`, `warehouse_id`, `product_color_id`, `product_qty`, `is_deleted`, `created_at`, `updated_at`) VALUES
(135, 3, 51, 10, 0, '2018-06-12 06:31:39', '2018-06-12 06:59:04'),
(136, 3, 53, 7, 0, '2018-06-12 06:31:40', '2018-06-12 06:31:40'),
(137, 3, 52, 5, 0, '2018-06-12 06:31:41', '2018-06-12 06:59:04'),
(138, 3, 60, 4, 0, '2018-06-12 06:31:42', '2018-06-12 06:59:04'),
(139, 4, 51, 8, 0, '2018-06-12 06:59:04', '2018-06-14 03:22:47'),
(140, 4, 52, 2, 0, '2018-06-12 06:59:04', '2018-06-12 06:59:04'),
(141, 4, 60, 3, 0, '2018-06-12 06:59:04', '2018-06-12 06:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_warehouse_type`
--

CREATE TABLE `tbl_warehouse_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl_warehouse_type`
--

INSERT INTO `tbl_warehouse_type` (`id`, `type`, `created_at`, `updated_at`) VALUES
(1, 'Main', '2018-03-27 04:55:34', '2018-03-27 04:55:34'),
(2, 'Regional', '2018-04-10 19:00:00', '2018-04-10 19:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl__warehouse__transfer`
--

CREATE TABLE `tbl__warehouse__transfer` (
  `id` int(10) UNSIGNED NOT NULL,
  `previous_warehouse_id` int(10) UNSIGNED NOT NULL,
  `product_color_id` int(10) UNSIGNED NOT NULL,
  `product_unit_price` double DEFAULT NULL,
  `resource_id` int(11) NOT NULL,
  `old_product_qty` int(11) NOT NULL,
  `remaining_qty` int(11) NOT NULL,
  `transfer_qty` int(11) NOT NULL,
  `new_warehouse_id` int(10) UNSIGNED NOT NULL,
  `new_transfer_qty` int(10) UNSIGNED NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tbl__warehouse__transfer`
--

INSERT INTO `tbl__warehouse__transfer` (`id`, `previous_warehouse_id`, `product_color_id`, `product_unit_price`, `resource_id`, `old_product_qty`, `remaining_qty`, `transfer_qty`, `new_warehouse_id`, `new_transfer_qty`, `created_by`, `created_at`, `updated_at`) VALUES
(46, 3, 51, 14000, 52, 10, 10, 10, 4, 10, 8, '2018-06-12 06:59:04', '2018-06-12 06:59:04'),
(47, 3, 52, 12000, 52, 2, 5, 2, 4, 2, 8, '2018-06-12 06:59:04', '2018-06-12 06:59:04'),
(48, 3, 60, 7000, 52, 3, 4, 3, 4, 3, 8, '2018-06-12 06:59:04', '2018-06-12 06:59:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `staff_id` int(10) UNSIGNED DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `staff_id`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.com', 11, '$2y$10$13xBY.FTsRoXPr8HfjXGCO33p.VXcAFYCruRZnXgJDOC6QpOeZ0Ea', 'DQt4mtCkNfdj6V7oXVvOky3PQatDvufvsfRkmMijGvxguTggSTHdu5Z3rZ5O', NULL, NULL),
(3, 'fahad khan', 'fahad@gmail.com', 1, '$2y$10$qX8H0pMegAAlVMVvMTGfHut4APmxajo29pLJPpDTkLpU6RQ/walk2', 'S7YemXEzLVqBoLgyu7uFo16AjVKO7ElTxHgcrFnbqPYXJCSdmwOGHEwiUfNz', '2018-03-27 04:34:52', '2018-03-27 04:34:52'),
(7, 'ali haider', 'syed_alihaider@live.com', 21, '$2y$10$cCF73LIAGD8YkeCU9gZFP.WQMIGu6Yy3NYEGoHqwalo.5w/LL4QIO', NULL, '2018-03-28 02:20:00', '2018-06-13 07:21:09'),
(8, 'ammad', 'ammad.baig66@yahoo.com', 5, '$2y$10$kwXcDtW7x5oPQGDiILGjQOtyMwRW46OtchvBA54YYZPhK4YzD7hre', 'S2pBBzNo7axSgxgRjwk49Id9KHNFtHXqFm8qun13kQKHKEArNVPVOocAannG', '2018-03-28 02:28:39', '2018-06-14 06:18:31'),
(10, 'hammad', 'hmmdkhan18@gmail.com', 7, '$2y$10$lKOY/EqH0nqU8CS2gcQXmuRUSjK6bVHfp5iSioVZ7jcL0EmZwzrnm', 'G0pM7nQL7te7WKTXSAYCmz16lXxHg49las4UxPYl5yHS7I9arF92SpzugNGk', '2018-03-29 00:53:51', '2018-06-14 05:22:14'),
(12, 'Maddy', 'maddy@gmail.com', 24, '$2y$10$JUfmEddAqw.Tx2iH8dKY2O6EsQvJbElV0BiHpVD/4oks5KDBeuAeG', 'sFGJdo1F0ZN73QI4DFl57mTGEVa7SBUptylT1C7gndxO271aAMmqp7m7NRO7', '2018-04-24 02:45:59', '2018-04-24 02:45:59'),
(13, 'mohsin', 'mohsin@xsys.com', 27, '$2y$10$hqtYgv0f/KNGUxcmbaAGsOhYiKKZzMdMiF8g7ufCDsSEH/sC9.RgK', 'eYkbVKJqNNdcZ2DoPQkwecK3ew1eBEX1mYKZwQZfBH1qQqpfEjnUy97OobMk', '2018-05-11 05:48:38', '2018-05-11 05:48:38');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_stock_details_by_warehouse`
-- (See below for the actual view)
--
CREATE TABLE `vw_stock_details_by_warehouse` (
`warehouse_stock_id` int(10) unsigned
,`product_color_id` int(10) unsigned
,`warehouse_id` int(10) unsigned
,`major` bigint(21)
,`mini` bigint(21)
,`damage` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_warehouse_stock_items`
-- (See below for the actual view)
--
CREATE TABLE `vw_warehouse_stock_items` (
`item_id` int(10) unsigned
,`warehouse_id` int(10) unsigned
,`stock_type` int(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_issue_note`
--

CREATE TABLE `warehouse_issue_note` (
  `id` int(11) NOT NULL,
  `warehouse_to` int(10) NOT NULL,
  `warehouse_from` int(10) NOT NULL,
  `is_approved` int(11) NOT NULL DEFAULT '0',
  `win_no` varchar(30) NOT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `stock_transfer` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse_issue_note`
--

INSERT INTO `warehouse_issue_note` (`id`, `warehouse_to`, `warehouse_from`, `is_approved`, `win_no`, `approved_by`, `stock_transfer`, `created_at`, `updated_at`) VALUES
(52, 4, 3, 1, 'WIN52', 8, 1, '2018-06-12 11:55:48', '2018-06-12 11:59:05');

-- --------------------------------------------------------

--
-- Table structure for table `warehouse_issue_note_items`
--

CREATE TABLE `warehouse_issue_note_items` (
  `id` int(11) NOT NULL,
  `issue_note_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_color_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warehouse_issue_note_items`
--

INSERT INTO `warehouse_issue_note_items` (`id`, `issue_note_id`, `product_id`, `product_color_id`, `quantity`, `price`) VALUES
(60, 52, 70, 51, 10, '14000'),
(61, 52, 71, 52, 2, '12000'),
(62, 52, 74, 60, 3, '7000');

-- --------------------------------------------------------

--
-- Structure for view `vw_stock_details_by_warehouse`
--
DROP TABLE IF EXISTS `vw_stock_details_by_warehouse`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_stock_details_by_warehouse`  AS  select `t1`.`id` AS `warehouse_stock_id`,`t1`.`product_color_id` AS `product_color_id`,`t1`.`warehouse_id` AS `warehouse_id`,(select count(0) from (`tbl_main_warehouse_receive_item` `t2` join `tbl_item` `t3` on((`t3`.`id` = `t2`.`item_id`))) where ((`t1`.`warehouse_id` = `t2`.`warehouse_id`) and (`t2`.`current_stock_status` = 1) and (`t3`.`product_color_id` = `t1`.`product_color_id`) and (`t2`.`is_sold` = 0))) AS `major`,(select count(0) from (`tbl_main_warehouse_receive_item` `t2` join `tbl_item` `t3` on((`t3`.`id` = `t2`.`item_id`))) where ((`t1`.`warehouse_id` = `t2`.`warehouse_id`) and (`t2`.`current_stock_status` = 2) and (`t3`.`product_color_id` = `t1`.`product_color_id`) and (`t2`.`is_sold` = 0))) AS `mini`,(select count(0) from (`tbl_main_warehouse_receive_item` `t2` join `tbl_item` `t3` on((`t3`.`id` = `t2`.`item_id`))) where ((`t1`.`warehouse_id` = `t2`.`warehouse_id`) and (`t2`.`current_stock_status` = 3) and (`t3`.`product_color_id` = `t1`.`product_color_id`) and (`t2`.`is_sold` = 0))) AS `damage` from `tbl_warehouse_stock` `t1` group by `t1`.`product_color_id`,`t1`.`warehouse_id` ;

-- --------------------------------------------------------

--
-- Structure for view `vw_warehouse_stock_items`
--
DROP TABLE IF EXISTS `vw_warehouse_stock_items`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_warehouse_stock_items`  AS  select `t1`.`item_id` AS `item_id`,`t1`.`warehouse_id` AS `warehouse_id`,`t1`.`current_stock_status` AS `stock_type` from (`tbl_main_warehouse_receive_item` `t1` left join `tbl_warehouse_issue_items` `t2` on((`t2`.`item_id` = `t1`.`item_id`))) where isnull(`t2`.`item_id`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `dealer_authentication`
--
ALTER TABLE `dealer_authentication`
  ADD PRIMARY KEY (`id`),
  ADD KEY `retailer_id` (`retailer_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `stock_status_history`
--
ALTER TABLE `stock_status_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `item_id` (`item_id`),
  ADD KEY `warehouse_id` (`warehouse_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_city`
--
ALTER TABLE `tbl_city`
  ADD PRIMARY KEY (`id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_currency_created_by_index` (`created_by`),
  ADD KEY `tbl_currency_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_discount_type`
--
ALTER TABLE `tbl_discount_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_discount_type_created_by_index` (`created_by`),
  ADD KEY `tbl_discount_type_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_imei`
--
ALTER TABLE `tbl_imei`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_imei_imei1_unique` (`imei1`),
  ADD UNIQUE KEY `tbl_imei_imei2_unique` (`imei2`),
  ADD KEY `tbl_imei_item_id_index` (`item_id`),
  ADD KEY `tbl_imei_created_by_index` (`created_by`);

--
-- Indexes for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_invoice_order_id_index` (`order_id`),
  ADD KEY `tbl_invoice_invoice_type_id_index` (`invoice_type_id`),
  ADD KEY `tbl_invoice_payment_type_id_index` (`payment_type_id`),
  ADD KEY `tbl_invoice_created_by_index` (`created_by`),
  ADD KEY `tbl_invoice_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_invoice_products`
--
ALTER TABLE `tbl_invoice_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_invoice_products_invoice_id_index` (`invoice_id`),
  ADD KEY `tbl_invoice_products_product_color_id_index` (`product_color_id`),
  ADD KEY `tbl_invoice_products_discount_type_id_index` (`discount_type_id`),
  ADD KEY `tbl_invoice_products_created_by_index` (`created_by`),
  ADD KEY `tbl_invoice_products_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_invoice_products_return`
--
ALTER TABLE `tbl_invoice_products_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_invoice_type`
--
ALTER TABLE `tbl_invoice_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_invoice_type_created_by_index` (`created_by`),
  ADD KEY `tbl_invoice_type_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_item_product_color_id_index` (`product_color_id`),
  ADD KEY `tbl_item_receive_id_index` (`receive_id`),
  ADD KEY `tbl_item_created_by_index` (`created_by`),
  ADD KEY `tbl_item_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_ledger`
--
ALTER TABLE `tbl_ledger`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_ledger_retailer_id_index` (`retailer_id`),
  ADD KEY `tbl_ledger_invoice_id_index` (`invoice_id`),
  ADD KEY `tbl_ledger_collection_id_index` (`collection_id`);

--
-- Indexes for table `tbl_main_warehouse_receive`
--
ALTER TABLE `tbl_main_warehouse_receive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_main_warehouse_receive_warehouse_id_index` (`warehouse_id`),
  ADD KEY `tbl_main_warehouse_receive_created_by_index` (`created_by`),
  ADD KEY `tbl_main_warehouse_receive_receive_id_index` (`receive_id`),
  ADD KEY `tbl_main_warehouse_receive_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_main_warehouse_receive_item`
--
ALTER TABLE `tbl_main_warehouse_receive_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_main_warehouse_receive_item_item_id_index` (`item_id`),
  ADD KEY `tbl_main_warehouse_receive_item_warehouse_id_index` (`warehouse_id`);

--
-- Indexes for table `tbl_main_warehouse_receive_product`
--
ALTER TABLE `tbl_main_warehouse_receive_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_main_warehouse_receive_product_main_receive_id_index` (`main_receive_id`),
  ADD KEY `tbl_main_warehouse_receive_product_product_color_id_index` (`product_color_id`),
  ADD KEY `tbl_main_warehouse_receive_product_created_by_index` (`created_by`),
  ADD KEY `tbl_main_warehouse_receive_product_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_manufacturing_order`
--
ALTER TABLE `tbl_manufacturing_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_manufacturing_order_created_by_index` (`created_by`),
  ADD KEY `tbl_manufacturing_order_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_manufacturing_order_product`
--
ALTER TABLE `tbl_manufacturing_order_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_manufacturing_order_product_product_color_id_index` (`product_color_id`),
  ADD KEY `tbl_manufacturing_order_product_manufacture_order_id_index` (`manufacture_order_id`),
  ADD KEY `tbl_manufacturing_order_product_created_by_index` (`created_by`),
  ADD KEY `tbl_manufacturing_order_product_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_manufacturing_payment`
--
ALTER TABLE `tbl_manufacturing_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_manufacturing_payment_manufacture_order_id_index` (`manufacture_order_id`),
  ADD KEY `tbl_manufacturing_payment_payment_type_id_index` (`payment_type_id`),
  ADD KEY `tbl_manufacturing_payment_currency_id_index` (`currency_id`),
  ADD KEY `tbl_manufacturing_payment_created_by_index` (`created_by`),
  ADD KEY `tbl_manufacturing_payment_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_manufacturing_status`
--
ALTER TABLE `tbl_manufacturing_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_manufacturing_status_manufacturing_order_id_index` (`manufacturing_order_id`),
  ADD KEY `tbl_manufacturing_status_created_by_index` (`created_by`),
  ADD KEY `tbl_manufacturing_status_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_payment_type_created_by_index` (`created_by`),
  ADD KEY `tbl_payment_type_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_permission`
--
ALTER TABLE `tbl_permission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_product_created_by_foreign` (`created_by`),
  ADD KEY `tbl_product_updated_by_foreign` (`updated_by`),
  ADD KEY `tbl_product_category_id_index` (`category_id`);

--
-- Indexes for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_product_category_created_by_foreign` (`created_by`),
  ADD KEY `tbl_product_category_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `tbl_product_color`
--
ALTER TABLE `tbl_product_color`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_product_color_created_by_foreign` (`created_by`),
  ADD KEY `tbl_product_color_updated_by_foreign` (`updated_by`),
  ADD KEY `tbl_product_color_product_id_index` (`product_id`),
  ADD KEY `tbl_product_color_color_index` (`color`);

--
-- Indexes for table `tbl_product_image`
--
ALTER TABLE `tbl_product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_product_image_created_by_foreign` (`created_by`),
  ADD KEY `tbl_product_image_updated_by_foreign` (`updated_by`),
  ADD KEY `tbl_product_image_product_color_id_index` (`product_color_id`);

--
-- Indexes for table `tbl_receive`
--
ALTER TABLE `tbl_receive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_receive_manufacturing_order_id_index` (`manufacturing_order_id`),
  ADD KEY `tbl_receive_collected_by_index` (`collected_by`),
  ADD KEY `tbl_receive_receive_status_id_index` (`receive_status_id`),
  ADD KEY `tbl_receive_created_by_index` (`created_by`),
  ADD KEY `tbl_receive_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_receive_products`
--
ALTER TABLE `tbl_receive_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_receive_products_receive_id_index` (`receive_id`),
  ADD KEY `tbl_receive_products_product_color_id_index` (`product_color_id`),
  ADD KEY `tbl_receive_products_created_by_index` (`created_by`),
  ADD KEY `tbl_receive_products_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_receive_status`
--
ALTER TABLE `tbl_receive_status`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_recieve_status_created_by_index` (`created_by`),
  ADD KEY `tbl_recieve_status_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_receive_status_log`
--
ALTER TABLE `tbl_receive_status_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_receive_status_log_recieve_id_index` (`recieve_id`),
  ADD KEY `tbl_receive_status_log_recieve_status_id_index` (`recieve_status_id`),
  ADD KEY `tbl_receive_status_log_created_by_index` (`created_by`),
  ADD KEY `tbl_receive_status_log_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_region`
--
ALTER TABLE `tbl_region`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_region_city_id_index` (`city_id`);

--
-- Indexes for table `tbl_retailer`
--
ALTER TABLE `tbl_retailer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_retailer_cnic_unique` (`cnic`),
  ADD KEY `tbl_retailer_created_by_foreign` (`created_by`),
  ADD KEY `tbl_retailer_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `tbl_retailer_collection`
--
ALTER TABLE `tbl_retailer_collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_retailer_collection_bank_id_index` (`bank_id`),
  ADD KEY `tbl_retailer_collection_currency_id_index` (`currency_id`),
  ADD KEY `tbl_retailer_collection_payment_type_id_index` (`payment_type_id`),
  ADD KEY `tbl_retailer_collection_retailer_id_index` (`retailer_id`),
  ADD KEY `tbl_retailer_collection_retailer_outlet_id_index` (`retailer_outlet_id`),
  ADD KEY `tbl_retailer_collection_invoice_id_index` (`invoice_id`),
  ADD KEY `tbl_retailer_collection_created_by_index` (`created_by`),
  ADD KEY `tbl_retailer_collection_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_retailer_collection_deposit_slip`
--
ALTER TABLE `tbl_retailer_collection_deposit_slip`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_id` (`bank_id`),
  ADD KEY `currenct_id` (`currenct_id`),
  ADD KEY `payment_type_id` (`payment_type_id`),
  ADD KEY `retailer_id` (`retailer_id`),
  ADD KEY `retailer_outlet_id` (`retailer_outlet_id`);

--
-- Indexes for table `tbl_retailer_order`
--
ALTER TABLE `tbl_retailer_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_retailer_order_retailer_id_index` (`retailer_id`),
  ADD KEY `tbl_retailer_order_sales_officer_id_index` (`sales_officer_id`),
  ADD KEY `tbl_retailer_order_outlet_id_index` (`outlet_id`),
  ADD KEY `tbl_retailer_order_retailer_order_status_id_index` (`retailer_order_status_id`),
  ADD KEY `tbl_retailer_order_warehouse_id_index` (`warehouse_id`),
  ADD KEY `tbl_retailer_order_created_by_index` (`created_by`),
  ADD KEY `tbl_retailer_order_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_retailer_order_products`
--
ALTER TABLE `tbl_retailer_order_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_retailer_order_products_retailer_order_id_index` (`retailer_order_id`),
  ADD KEY `tbl_retailer_order_products_product_color_id_index` (`product_color_id`),
  ADD KEY `tbl_retailer_order_products_created_by_index` (`created_by`),
  ADD KEY `tbl_retailer_order_products_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_retailer_order_status`
--
ALTER TABLE `tbl_retailer_order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_retailer_outlet`
--
ALTER TABLE `tbl_retailer_outlet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_retailer_outlet_retailer_id_index` (`retailer_id`),
  ADD KEY `tbl_retailer_outlet_city_id_index` (`city_id`),
  ADD KEY `tbl_retailer_outlet_region_id_index` (`region_id`),
  ADD KEY `tbl_retailer_outlet_created_by_index` (`created_by`),
  ADD KEY `tbl_retailer_outlet_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_role_created_by_foreign` (`created_by`),
  ADD KEY `tbl_role_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `tbl_role_permission`
--
ALTER TABLE `tbl_role_permission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_role_permission_role_id_index` (`role_id`),
  ADD KEY `tbl_role_permission_permission_id_index` (`permission_id`);

--
-- Indexes for table `tbl_specs_category`
--
ALTER TABLE `tbl_specs_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_specs_product`
--
ALTER TABLE `tbl_specs_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_specs_product` (`specs_sub_category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_specs_sub_category`
--
ALTER TABLE `tbl_specs_sub_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tbl_specs_sub_category` (`specs_category_id`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_staff_email_unique` (`email`),
  ADD UNIQUE KEY `tbl_staff_cnic_unique` (`CNIC`),
  ADD KEY `tbl_staff_city_id_index` (`city_id`),
  ADD KEY `tbl_staff_region_id_index` (`region_id`),
  ADD KEY `tbl_staff_department_id_index` (`department_id`),
  ADD KEY `tbl_staff_staff_type_id_index` (`staff_type_id`),
  ADD KEY `tbl_staff_designation_id_index` (`designation_id`),
  ADD KEY `tbl_staff_created_by_index` (`created_by`),
  ADD KEY `tbl_staff_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_staff_type`
--
ALTER TABLE `tbl_staff_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_state`
--
ALTER TABLE `tbl_state`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_user_role_created_by_foreign` (`created_by`),
  ADD KEY `tbl_user_role_updated_by_foreign` (`updated_by`),
  ADD KEY `tbl_user_role_user_id_index` (`user_id`),
  ADD KEY `tbl_user_role_role_id_index` (`role_id`);

--
-- Indexes for table `tbl_warehouse`
--
ALTER TABLE `tbl_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_warehouse_warehouse_type_id_foreign` (`warehouse_type_id`),
  ADD KEY `tbl_warehouse_city_id_foreign` (`city_id`),
  ADD KEY `tbl_warehouse_warehouse_manager_index` (`warehouse_manager`),
  ADD KEY `tbl_warehouse_warehouse_accountant_index` (`warehouse_accountant`),
  ADD KEY `tbl_warehouse_created_by_index` (`created_by`),
  ADD KEY `tbl_warehouse_updated_by_index` (`updated_by`),
  ADD KEY `tbl_warehouse_region_id_unique` (`region_id`);

--
-- Indexes for table `tbl_warehouse_issue`
--
ALTER TABLE `tbl_warehouse_issue`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_warehouse_issue_invoice_id_unique` (`invoice_id`),
  ADD KEY `tbl_warehouse_issue_created_by_index` (`created_by`),
  ADD KEY `tbl_warehouse_issue_warehouse_id_unique` (`warehouse_id`) USING BTREE;

--
-- Indexes for table `tbl_warehouse_issue_items`
--
ALTER TABLE `tbl_warehouse_issue_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_warehouse_issue_items_warehouse_issue_id_index` (`warehouse_issue_id`),
  ADD KEY `tbl_warehouse_issue_items_item_id_index` (`item_id`),
  ADD KEY `tbl_warehouse_issue_items_created_by_index` (`created_by`);

--
-- Indexes for table `tbl_warehouse_staff`
--
ALTER TABLE `tbl_warehouse_staff`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_warehouse_staff_warehouse_id_index` (`warehouse_id`),
  ADD KEY `tbl_warehouse_staff_staff_id_index` (`staff_id`),
  ADD KEY `tbl_warehouse_staff_created_by_index` (`created_by`),
  ADD KEY `tbl_warehouse_staff_updated_by_index` (`updated_by`);

--
-- Indexes for table `tbl_warehouse_stock`
--
ALTER TABLE `tbl_warehouse_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl_warehouse_stock_warehouse_id_index` (`warehouse_id`),
  ADD KEY `tbl_warehouse_stock_product_color_id_index` (`product_color_id`);

--
-- Indexes for table `tbl_warehouse_type`
--
ALTER TABLE `tbl_warehouse_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl__warehouse__transfer`
--
ALTER TABLE `tbl__warehouse__transfer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tbl__warehouse__transfer_previous_warehouse_id_index` (`previous_warehouse_id`),
  ADD KEY `tbl__warehouse__transfer_product_color_id_index` (`product_color_id`),
  ADD KEY `tbl__warehouse__transfer_new_warehouse_id_index` (`new_warehouse_id`),
  ADD KEY `tbl__warehouse__transfer_created_by_index` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_staff_id_index` (`staff_id`);

--
-- Indexes for table `warehouse_issue_note`
--
ALTER TABLE `warehouse_issue_note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `warehouse_to` (`warehouse_to`),
  ADD KEY `warehouse_from` (`warehouse_from`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Indexes for table `warehouse_issue_note_items`
--
ALTER TABLE `warehouse_issue_note_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_note_id` (`issue_note_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `product_color_id` (`product_color_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dealer_authentication`
--
ALTER TABLE `dealer_authentication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `stock_status_history`
--
ALTER TABLE `stock_status_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_bank`
--
ALTER TABLE `tbl_bank`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_city`
--
ALTER TABLE `tbl_city`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_discount_type`
--
ALTER TABLE `tbl_discount_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_imei`
--
ALTER TABLE `tbl_imei`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_invoice_products`
--
ALTER TABLE `tbl_invoice_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_invoice_products_return`
--
ALTER TABLE `tbl_invoice_products_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_invoice_type`
--
ALTER TABLE `tbl_invoice_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_item`
--
ALTER TABLE `tbl_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=555;

--
-- AUTO_INCREMENT for table `tbl_ledger`
--
ALTER TABLE `tbl_ledger`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_main_warehouse_receive`
--
ALTER TABLE `tbl_main_warehouse_receive`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `tbl_main_warehouse_receive_item`
--
ALTER TABLE `tbl_main_warehouse_receive_item`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=546;

--
-- AUTO_INCREMENT for table `tbl_main_warehouse_receive_product`
--
ALTER TABLE `tbl_main_warehouse_receive_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `tbl_manufacturing_order`
--
ALTER TABLE `tbl_manufacturing_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `tbl_manufacturing_order_product`
--
ALTER TABLE `tbl_manufacturing_order_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `tbl_manufacturing_payment`
--
ALTER TABLE `tbl_manufacturing_payment`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_manufacturing_status`
--
ALTER TABLE `tbl_manufacturing_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_permission`
--
ALTER TABLE `tbl_permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_product`
--
ALTER TABLE `tbl_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `tbl_product_color`
--
ALTER TABLE `tbl_product_color`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tbl_product_image`
--
ALTER TABLE `tbl_product_image`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `tbl_receive`
--
ALTER TABLE `tbl_receive`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `tbl_receive_products`
--
ALTER TABLE `tbl_receive_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=204;

--
-- AUTO_INCREMENT for table `tbl_receive_status`
--
ALTER TABLE `tbl_receive_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_receive_status_log`
--
ALTER TABLE `tbl_receive_status_log`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `tbl_region`
--
ALTER TABLE `tbl_region`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_retailer`
--
ALTER TABLE `tbl_retailer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `tbl_retailer_collection`
--
ALTER TABLE `tbl_retailer_collection`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_retailer_collection_deposit_slip`
--
ALTER TABLE `tbl_retailer_collection_deposit_slip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_retailer_order`
--
ALTER TABLE `tbl_retailer_order`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `tbl_retailer_order_products`
--
ALTER TABLE `tbl_retailer_order_products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `tbl_retailer_order_status`
--
ALTER TABLE `tbl_retailer_order_status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_retailer_outlet`
--
ALTER TABLE `tbl_retailer_outlet`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_role_permission`
--
ALTER TABLE `tbl_role_permission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_specs_category`
--
ALTER TABLE `tbl_specs_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_specs_product`
--
ALTER TABLE `tbl_specs_product`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;

--
-- AUTO_INCREMENT for table `tbl_specs_sub_category`
--
ALTER TABLE `tbl_specs_sub_category`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_staff_type`
--
ALTER TABLE `tbl_staff_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_state`
--
ALTER TABLE `tbl_state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_warehouse`
--
ALTER TABLE `tbl_warehouse`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_warehouse_issue`
--
ALTER TABLE `tbl_warehouse_issue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_warehouse_issue_items`
--
ALTER TABLE `tbl_warehouse_issue_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_warehouse_staff`
--
ALTER TABLE `tbl_warehouse_staff`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_warehouse_stock`
--
ALTER TABLE `tbl_warehouse_stock`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `tbl_warehouse_type`
--
ALTER TABLE `tbl_warehouse_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl__warehouse__transfer`
--
ALTER TABLE `tbl__warehouse__transfer`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `warehouse_issue_note`
--
ALTER TABLE `warehouse_issue_note`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `warehouse_issue_note_items`
--
ALTER TABLE `warehouse_issue_note_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  ADD CONSTRAINT `tbl_currency_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_currency_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_discount_type`
--
ALTER TABLE `tbl_discount_type`
  ADD CONSTRAINT `tbl_discount_type_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_discount_type_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_imei`
--
ALTER TABLE `tbl_imei`
  ADD CONSTRAINT `tbl_imei_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_imei_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`id`);

--
-- Constraints for table `tbl_invoice`
--
ALTER TABLE `tbl_invoice`
  ADD CONSTRAINT `tbl_invoice_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_invoice_invoice_type_id_foreign` FOREIGN KEY (`invoice_type_id`) REFERENCES `tbl_invoice_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_invoice_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `tbl_retailer_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_invoice_payment_type_id_foreign` FOREIGN KEY (`payment_type_id`) REFERENCES `tbl_payment_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_invoice_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_invoice_products`
--
ALTER TABLE `tbl_invoice_products`
  ADD CONSTRAINT `tbl_invoice_products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_invoice_products_discount_type_id_foreign` FOREIGN KEY (`discount_type_id`) REFERENCES `tbl_discount_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_invoice_products_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `tbl_invoice` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_invoice_products_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `tbl_product_color` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_invoice_products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_invoice_type`
--
ALTER TABLE `tbl_invoice_type`
  ADD CONSTRAINT `tbl_invoice_type_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_invoice_type_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD CONSTRAINT `tbl_item_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_item_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `tbl_product_color` (`id`),
  ADD CONSTRAINT `tbl_item_receive_id_foreign` FOREIGN KEY (`receive_id`) REFERENCES `tbl_receive` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_item_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_ledger`
--
ALTER TABLE `tbl_ledger`
  ADD CONSTRAINT `tbl_ledger_collection_id_foreign` FOREIGN KEY (`collection_id`) REFERENCES `tbl_retailer_collection` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_ledger_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `tbl_invoice` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_ledger_retailer_id_foreign` FOREIGN KEY (`retailer_id`) REFERENCES `tbl_retailer_outlet` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_main_warehouse_receive`
--
ALTER TABLE `tbl_main_warehouse_receive`
  ADD CONSTRAINT `tbl_main_warehouse_receive_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_main_warehouse_receive_receive_id_foreign` FOREIGN KEY (`receive_id`) REFERENCES `tbl_receive` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_main_warehouse_receive_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_main_warehouse_receive_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouse` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_main_warehouse_receive_item`
--
ALTER TABLE `tbl_main_warehouse_receive_item`
  ADD CONSTRAINT `tbl_main_warehouse_receive_item_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_main_warehouse_receive_item_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouse` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_main_warehouse_receive_product`
--
ALTER TABLE `tbl_main_warehouse_receive_product`
  ADD CONSTRAINT `tbl_main_warehouse_receive_product_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_main_warehouse_receive_product_main_receive_id_foreign` FOREIGN KEY (`main_receive_id`) REFERENCES `tbl_main_warehouse_receive` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_main_warehouse_receive_product_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `tbl_product_color` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_main_warehouse_receive_product_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_manufacturing_order`
--
ALTER TABLE `tbl_manufacturing_order`
  ADD CONSTRAINT `tbl_manufacturing_order_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_order_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_manufacturing_order_product`
--
ALTER TABLE `tbl_manufacturing_order_product`
  ADD CONSTRAINT `tbl_manufacturing_order_product_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_order_product_manufacture_order_id_foreign` FOREIGN KEY (`manufacture_order_id`) REFERENCES `tbl_manufacturing_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_order_product_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `tbl_product_color` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_order_product_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_manufacturing_payment`
--
ALTER TABLE `tbl_manufacturing_payment`
  ADD CONSTRAINT `tbl_manufacturing_payment_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_payment_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `tbl_currency` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_payment_manufacture_order_id_foreign` FOREIGN KEY (`manufacture_order_id`) REFERENCES `tbl_manufacturing_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_payment_payment_type_id_foreign` FOREIGN KEY (`payment_type_id`) REFERENCES `tbl_payment_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_payment_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_manufacturing_status`
--
ALTER TABLE `tbl_manufacturing_status`
  ADD CONSTRAINT `tbl_manufacturing_status_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_status_manufacturing_order_id_foreign` FOREIGN KEY (`manufacturing_order_id`) REFERENCES `tbl_manufacturing_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_manufacturing_status_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_payment_type`
--
ALTER TABLE `tbl_payment_type`
  ADD CONSTRAINT `tbl_payment_type_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_payment_type_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_product`
--
ALTER TABLE `tbl_product`
  ADD CONSTRAINT `tbl_product_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `tbl_product_category` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_product_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_product_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_product_category`
--
ALTER TABLE `tbl_product_category`
  ADD CONSTRAINT `tbl_product_category_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_product_category_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_product_color`
--
ALTER TABLE `tbl_product_color`
  ADD CONSTRAINT `tbl_product_color_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_product_color_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `tbl_product` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_product_color_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_product_image`
--
ALTER TABLE `tbl_product_image`
  ADD CONSTRAINT `tbl_product_image_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_product_image_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `tbl_product_color` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_product_image_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_receive`
--
ALTER TABLE `tbl_receive`
  ADD CONSTRAINT `tbl_receive_collected_by_foreign` FOREIGN KEY (`collected_by`) REFERENCES `tbl_staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_manufacturing_order_id_foreign` FOREIGN KEY (`manufacturing_order_id`) REFERENCES `tbl_manufacturing_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_receive_status_id_foreign` FOREIGN KEY (`receive_status_id`) REFERENCES `tbl_receive_status` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_receive_products`
--
ALTER TABLE `tbl_receive_products`
  ADD CONSTRAINT `tbl_receive_products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_products_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `tbl_product_color` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_products_receive_id_foreign` FOREIGN KEY (`receive_id`) REFERENCES `tbl_receive` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_receive_status`
--
ALTER TABLE `tbl_receive_status`
  ADD CONSTRAINT `tbl_recieve_status_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_recieve_status_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_receive_status_log`
--
ALTER TABLE `tbl_receive_status_log`
  ADD CONSTRAINT `tbl_receive_status_log_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_status_log_recieve_id_foreign` FOREIGN KEY (`recieve_id`) REFERENCES `tbl_receive` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_status_log_recieve_status_id_foreign` FOREIGN KEY (`recieve_status_id`) REFERENCES `tbl_receive_status` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_receive_status_log_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_region`
--
ALTER TABLE `tbl_region`
  ADD CONSTRAINT `tbl_region_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `tbl_city` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_retailer`
--
ALTER TABLE `tbl_retailer`
  ADD CONSTRAINT `tbl_retailer_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_retailer_collection`
--
ALTER TABLE `tbl_retailer_collection`
  ADD CONSTRAINT `tbl_retailer_collection_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `tbl_bank` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_collection_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_collection_currency_id_foreign` FOREIGN KEY (`currency_id`) REFERENCES `tbl_currency` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_collection_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `tbl_invoice` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_collection_payment_type_id_foreign` FOREIGN KEY (`payment_type_id`) REFERENCES `tbl_payment_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_collection_retailer_id_foreign` FOREIGN KEY (`retailer_id`) REFERENCES `tbl_retailer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_collection_retailer_outlet_id_foreign` FOREIGN KEY (`retailer_outlet_id`) REFERENCES `tbl_retailer_outlet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_collection_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_retailer_order`
--
ALTER TABLE `tbl_retailer_order`
  ADD CONSTRAINT `tbl_retailer_order_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_order_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `tbl_retailer_outlet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_order_retailer_id_foreign` FOREIGN KEY (`retailer_id`) REFERENCES `tbl_retailer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_order_retailer_order_status_id_foreign` FOREIGN KEY (`retailer_order_status_id`) REFERENCES `tbl_retailer_order_status` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_order_sales_officer_id_foreign` FOREIGN KEY (`sales_officer_id`) REFERENCES `tbl_staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_order_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_order_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouse` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_retailer_order_products`
--
ALTER TABLE `tbl_retailer_order_products`
  ADD CONSTRAINT `tbl_retailer_order_products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_order_products_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `tbl_product_color` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_order_products_retailer_order_id_foreign` FOREIGN KEY (`retailer_order_id`) REFERENCES `tbl_retailer_order` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_order_products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_retailer_outlet`
--
ALTER TABLE `tbl_retailer_outlet`
  ADD CONSTRAINT `tbl_retailer_outlet_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `tbl_city` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_outlet_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_outlet_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `tbl_region` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_outlet_retailer_id_foreign` FOREIGN KEY (`retailer_id`) REFERENCES `tbl_retailer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_retailer_outlet_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD CONSTRAINT `tbl_role_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_role_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_role_permission`
--
ALTER TABLE `tbl_role_permission`
  ADD CONSTRAINT `tbl_role_permission_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `tbl_permission` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_role_permission_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `tbl_role` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_specs_product`
--
ALTER TABLE `tbl_specs_product`
  ADD CONSTRAINT `FK_tbl_specs_product` FOREIGN KEY (`specs_sub_category_id`) REFERENCES `tbl_specs_sub_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_specs_sub_category`
--
ALTER TABLE `tbl_specs_sub_category`
  ADD CONSTRAINT `FK_tbl_specs_sub_category` FOREIGN KEY (`specs_category_id`) REFERENCES `tbl_specs_category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD CONSTRAINT `tbl_staff_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `tbl_city` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_staff_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_staff_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `tbl_department` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_staff_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `tbl_designation` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_staff_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `tbl_region` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_staff_staff_type_id_foreign` FOREIGN KEY (`staff_type_id`) REFERENCES `tbl_staff_type` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_staff_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_user_role`
--
ALTER TABLE `tbl_user_role`
  ADD CONSTRAINT `tbl_user_role_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_user_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `tbl_role` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_user_role_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_user_role_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_warehouse`
--
ALTER TABLE `tbl_warehouse`
  ADD CONSTRAINT `tbl_warehouse_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `tbl_city` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `tbl_region` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_warehouse_type_id_foreign` FOREIGN KEY (`warehouse_type_id`) REFERENCES `tbl_warehouse_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_warehouse_issue`
--
ALTER TABLE `tbl_warehouse_issue`
  ADD CONSTRAINT `tbl_warehouse_issue_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_issue_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `tbl_invoice` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_issue_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouse` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_warehouse_issue_items`
--
ALTER TABLE `tbl_warehouse_issue_items`
  ADD CONSTRAINT `tbl_warehouse_issue_items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_issue_items_item_id_foreign` FOREIGN KEY (`item_id`) REFERENCES `tbl_item` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_issue_items_warehouse_issue_id_foreign` FOREIGN KEY (`warehouse_issue_id`) REFERENCES `tbl_warehouse_issue` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_warehouse_staff`
--
ALTER TABLE `tbl_warehouse_staff`
  ADD CONSTRAINT `tbl_warehouse_staff_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_staff_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `tbl_staff` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_staff_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_staff_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouse` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_warehouse_stock`
--
ALTER TABLE `tbl_warehouse_stock`
  ADD CONSTRAINT `tbl_warehouse_stock_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `tbl_product_color` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_warehouse_stock_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `tbl_warehouse` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl__warehouse__transfer`
--
ALTER TABLE `tbl__warehouse__transfer`
  ADD CONSTRAINT `tbl__warehouse__transfer_new_warehouse_id_foreign` FOREIGN KEY (`new_warehouse_id`) REFERENCES `tbl_warehouse` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl__warehouse__transfer_previous_warehouse_id_foreign` FOREIGN KEY (`previous_warehouse_id`) REFERENCES `tbl_warehouse` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl__warehouse__transfer_product_color_id_foreign` FOREIGN KEY (`product_color_id`) REFERENCES `tbl_product_color` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_staff_id_foreign` FOREIGN KEY (`staff_id`) REFERENCES `tbl_staff` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `warehouse_issue_note_items`
--
ALTER TABLE `warehouse_issue_note_items`
  ADD CONSTRAINT `FK_warehouse_issue_note_items` FOREIGN KEY (`issue_note_id`) REFERENCES `warehouse_issue_note` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
