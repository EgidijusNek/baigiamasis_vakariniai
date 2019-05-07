SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `virtual-pet-db`
--
USE `virtual-pet-db`;

-- --------------------------------------------------------


DROP TABLE IF EXISTS `minigames`;
CREATE TABLE IF NOT EXISTS `minigames` (
  `idMinigame` int(11) NOT NULL AUTO_INCREMENT,
  `nameMinigame` varchar(50) NOT NULL,
  `score` int(11) DEFAULT NULL,
  `idPet` int(11) NOT NULL,
  PRIMARY KEY (`idMinigame`),
  KEY `idPet` (`idPet`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;


INSERT INTO `minigames` (`idMinigame`, `nameMinigame`, `score`, `idPet`) VALUES
(1, 'Akmuo - Popierius - Žirklės', 0, 1),
(2, 'Akmuo - Popierius - Žirklės', 0, 2),
(3, 'Akmuo - Popierius - Žirklės', 0, 3),
(4, 'Akmuo - Popierius - Žirklės', 0, 4),
(5, 'Akmuo - Popierius - Žirklės', 0, 5);

-- --------------------------------------------------------

DROP TABLE IF EXISTS `pet`;
CREATE TABLE IF NOT EXISTS `pet` (
  `idPet` int(11) NOT NULL AUTO_INCREMENT,
  `petName` varchar(100) NOT NULL,
  `happyPet` int(100) NOT NULL,
  `petHappiness` int(100) NOT NULL,
  `petHealth` int(100) NOT NULL,
  `petSleep` int(100) NOT NULL,
  `petState` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `userId` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`idPet`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(50) NOT NULL,
  `pasword` varchar(50) NOT NULL,
  `time` bigint(20) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

