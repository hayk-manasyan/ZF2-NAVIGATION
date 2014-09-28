SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `label` varchar(50) COLLATE utf8_bin NOT NULL,
  `uri` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `route` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `parent_menu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `parent_menu_id` (`parent_menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `name`, `label`, `uri`, `route`, `icon`, `parent_menu_id`) VALUES
(1, 'Home', 'Home', '/', NULL, 'glyphicon glyphicon-home', NULL),
(2, 'Menu', 'Menu', '/menu', NULL, 'glyphicon glyphicon-th', NULL),
(3, 'Menu List', 'Menu List', '/menu/manage/index', NULL, NULL, 2),
(4, 'Add Menu', 'Add Menu', '/menu/manage/create', NULL, NULL, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
