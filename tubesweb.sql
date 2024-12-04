-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 11:43 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tubesweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `id_product`, `id_name`, `name`, `comment`) VALUES
(19, 7, 19, 'faizfasyah', 'Produk keren sekali, alhamdulillah sudah sampai dengan selamat laptopnya...'),
(21, 5, 17, 'John Doe', 'This is a great product!');

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `id_name` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `id_name`, `name`, `date`) VALUES
(3, 17, 'admin', '2023-12-29 16:22:45'),
(4, 17, 'admin', '2023-12-29 16:24:26'),
(5, 18, 'user', '2023-12-29 16:25:03'),
(6, 18, 'user', '2024-01-03 02:09:12'),
(7, 17, 'admin', '2024-01-03 02:09:36'),
(8, 18, 'user', '2024-01-03 02:21:48'),
(9, 17, 'admin', '2024-01-03 02:25:38'),
(10, 18, 'user', '2024-01-03 02:39:03'),
(11, 17, 'admin', '2024-01-03 02:39:17'),
(12, 18, 'user', '2024-01-03 02:42:43'),
(13, 17, 'admin', '2024-01-03 02:42:55'),
(14, 18, 'user', '2024-01-03 02:48:50'),
(15, 17, 'admin', '2024-01-03 02:49:01'),
(16, 19, 'faizfasyah', '2024-01-03 03:12:56'),
(17, 17, 'admin', '2024-01-03 03:13:19'),
(18, 19, 'faizfasyah', '2024-01-03 03:16:52'),
(19, 17, 'admin', '2024-01-03 05:03:28'),
(20, 19, 'faizfasyah', '2024-01-03 05:07:05'),
(21, 17, 'admin', '2024-01-03 05:09:59'),
(22, 17, 'admin', '2024-01-03 05:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(9) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `email`, `username`, `password`, `role`) VALUES
(17, 'admin', 'admin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1),
(18, 'user', 'user@gmail.com', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 0),
(19, 'faizfasyah', 'faizfasyah@gmail.com', 'faiz', '67f27ddf40a0dd24fe50fbe33c4460bb', 0);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stock` int(5) NOT NULL,
  `price` int(10) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `url`, `name`, `stock`, `price`, `description`) VALUES
(5, '../images/d971efe1e24941b9f63fcd102fbcf9ab.jpg_720x720q80.jpg', 'SATOO FANES Headset Earphone Handsfree High ', 496, 13500, 'SATOO Handsfree ini di design oleh SATOO dengan sangat istimewa, sangat pas di lubang telinga dan kaya akan suara bass yang cukup mendalam, dilengkapi dengan Call Button dan Microphone untuk menjawab dan menghubungi percakapan waktu kita sedang telepon, SATOO Earpods ini mempunyai pelindung dalam yang sangat baik dari cipratan air(keringat di kuping) dan debu(walaupun di anjurkan tidak untuk di bawah berenang :P ) Compatible dengan segala portable music player, iPhone, iPad, iPod Touch ,Notebook, MP3 Player Dan jenis Smartphone Android lain nya Seperti Samsung, Xiaomi,HTC dll\r\n\r\n* Kualitas Bass Powerful\r\nDengan Bass-driven stereo Anda akan merasakan kekuatan bass yang maksimal pada musik favorit Anda dan membuat pengalaman mendengarkan musik lebih hebat dari sebelumnya\r\n* Desain yang Ergonomis\r\n* Kompatible : iPhone, iPad, iPod Touch, MP3, iPod, dan media portabel, Serta segala jenis Smartphone lain nya seperti Samsung, Xiaomi, HTC, Dll'),
(6, '../images/0f4b5ecc-cd2c-4dfe-9065-03a9f3a0c457.jpeg', 'RajaPods Pro 2 Serial number detected ACTIVE NOISE CANCELLATION', 46, 299000, 'ALL NEW RajaPODS PRO ( 2ND GENERATION ) WITH H2 CHIP\r\n- FINAL UPGRADE + IMEI / SERIAL NUMBER VALID + ACTIVE NOISE CANCELLATION\r\n\r\nSuperclone 1:1\r\n\r\nFITUR LENGKAP :\r\n- New Chip Terbaik di dunia ( H2 CHIP )\r\n- IOS / android / windows / all device compatible\r\n- IPX4 Water And Sweat resistant\r\n- Real Pop Up battery indicator\r\n- Baterai Tahan 30 jam non stop\r\n- 2x Active Noise Cancellation And Transparency\r\n- Adaptive Transparency Mode\r\n- 2x Enchanced Bass And Treble\r\n- Personalized Spatial Audio\r\n- 9D surround Dolby Atmos Surround Sound\r\n- Vent system For pressure Equalization\r\n- Adaptive EQ\r\n- Touch Control\r\n- Dynamic Head Tracking\r\n- Find my\r\n- Rename Feature\r\n- Dual Microphone For clear calls and Recording\r\n- Support Wireless Charging\r\n- Bluetooth 5.3 Support\r\n- Live Listen Audio\r\n\r\nIn The Box\r\n1x unit RajaPods Pro 2nd Generation\r\n1x box with Logo\r\n1x Manual book\r\n1x Lightning Cable\r\n3x Set Earbuds + Cadangan ( XS , S , L )'),
(7, '../images/2834b15e-c048-4d18-bc9e-53e927a1a8e3.jpeg', 'Lenovo Yoga Pro 7i i7-13700H 512GB SSD 16GB Iris Xe Win+OHS', 83, 17500000, 'Lenovo Yoga Pro 7i i7-13700H 512GB SSD 16GB Iris Xe Win+OHS\r\n\r\nYoga Pro 7 14IRH8\r\n\r\nGARANSI RESMI LENOVO INDONESIA 3 TAHUN +ADP\r\n\r\nPart Number : 82Y7005XID\r\n\r\nIntel Core i7-13700H, 14C (6P + 8E) / 20T, P-core up to 5.0GHz, E-core up to 3.7GHz, 24MB\r\nIntegrated Intel Iris Xe Graphics\r\nMemory: 16GB Soldered LPDDR5-5200\r\nMemory Slots: Memory soldered to systemboard, no slots, dual-channel\r\nMax Memory: 16GB soldered memory, not upgradable\r\nStorage: 512GB SSD M.2 2280 PCIe 4.0x4 NVMe\r\nStorage Support: One drive, up to 512GB M.2 2242 SSD or 1TB M.2 2280 SSD\r\nStorage Slot: One M.2 2280 PCIe® 4.0 x4 slot\r\nCard Reader: None\r\nOptical: None\r\nAudio Chip: High Definition (HD) Audio, Realtek® ALC3306 codec\r\nSpeakers: Stereo speakers, 2W x4, optimized with Dolby® Atmos®, Smart Amplifier (AMP)\r\nCamera: FHD 1080p + IR with E-shutter, ToF Sensor\r\nMicrophone: 4x, Array\r\nBattery: Integrated 73Wh\r\nPower Adapter: 140W USB-C® Slim (3-pin)\r\nDisplay: 14.5\" 2.5K (2560x1600) IPS 350nits Anti-glare, 100% sRGB, 90Hz, Eyesafe, Dolby Vision\r\nTouchscreen: None\r\nKeyboard: Backlit, English\r\nCase Color: Tidal Teal\r\nSurface Treatment: Aluminium Stamping (Anodized with Sandblasting)\r\nCase Material: Aluminium (Top), Aluminium (Bottom)\r\nDimensions (WxDxH): 325.5 x 226.49 x 15.6 mm (12.81 x 8.92 x 0.61 inches)\r\nWeight: Starting at 1.49 kg (3.28 lbs)\r\nOperating System: Windows® 11 Home Single Language, English\r\nEthernet: No Onboard Ethernet\r\nWLAN + Bluetooth: Wi-Fi® 6E, 11ax 2x2 + BT5.1'),
(17, '../images/acer-nitro-v-15.webp', 'Acer Nitro V15', 10, 14999000, 'Garansi RESMI 2 Tahun ACER INDONESIA\r\nPastikan anda membeli PRODUK RESMI INDONESIA untuk kemudahan CLAIM GARANSI di Service Center Resmi Di Seluruh Indonesia\r\n\r\nSPECIFICATION:\r\n\r\nOperating System Windows 11 Home\r\nProcessor & Chipset\r\nProcessor Type Core™ i5\r\nProcessor Model Intel® Core™ i5-13420H processor\r\nProcessor Speed (turbo) 12MB cache, up to 4.60Ghz\r\nMemory\r\nStandard Memory 8 GB\r\nMemory Technology DDR 5\r\nStorage\r\nTotal Solid State Drive Capacity 512 GB\r\nSolid State Drive Interface NVMe\r\nDisplay & Graphics\r\nScreen Size 39.6 cm (15.6\")\r\nDisplay Screen Technology IPS 144Hz\r\nScreen Mode Full HD\r\nBacklight Technology LED\r\nScreen Resolution 1920 x 1080\r\nGraphics Controller Manufacturer NVIDIA®️\r\nGraphics Controller Model NVIDIA® GeForce® RTX 2050 with 4GB of GDDR6\r\nPorts :\r\nHDMI\r\nYa\r\nJumlah Keluaran HDMI\r\n1\r\nDisplayPort\r\nTidak Ada\r\nJumlah Port USB 3.2 Gen 1 Tipe-A\r\n3\r\nJumlah Port USB 3.2 Gen 2 Tipe-C\r\n1\r\nJumlah Total Port USB\r\n4\r\nJaringan (RJ-45)\r\nYa');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) NOT NULL,
  `id_product` int(11) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_price` int(10) NOT NULL,
  `id_name` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `id_product`, `p_name`, `p_price`, `id_name`, `name`, `date`) VALUES
(46, 5, 'SATOO FANES Headset Earphone Handsfree High ', 13500, 19, 'faizfasyah', '2024-01-03 05:09:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_comment` (`id_product`),
  ADD KEY `name_comment` (`id_name`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_history` (`id_name`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name_transaction` (`id_name`),
  ADD KEY `product_transaction` (`id_product`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `name_comment` FOREIGN KEY (`id_name`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `products_comment` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`);

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `name_history` FOREIGN KEY (`id_name`) REFERENCES `login` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `name_transaction` FOREIGN KEY (`id_name`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `product_transaction` FOREIGN KEY (`id_product`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
