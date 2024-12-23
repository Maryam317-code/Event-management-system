-- Set SQL mode and start transaction
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Uncomment these lines if needed
-- /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
-- /*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
-- /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
-- /*!40101 SET NAMES utf8mb4 */;

-- Database: `earthsavior`
CREATE DATABASE IF NOT EXISTS `earthsavior`;
USE `earthsavior`;

-- Table structure for `user`
CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `FullName` VARCHAR(50) NOT NULL,
  `Email` VARCHAR(50) NOT NULL,
  `CoNum` VARCHAR(15) NOT NULL,
  `Password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`Email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for `product`
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_name` VARCHAR(100) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `description` TEXT NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for `cart`
CREATE TABLE IF NOT EXISTS `cart` (
  `cart_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `product_id` INT(11) UNSIGNED NOT NULL,
  `quantity` INT(11) NOT NULL,
  `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cart_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `product`(`product_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for `order`
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `order_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `total_amount` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table structure for `donate`
CREATE TABLE IF NOT EXISTS `donate` (
  `donation_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `DonatorsName` VARCHAR(100) NOT NULL,
  `ContactNumber` VARCHAR(15) NOT NULL,
  `Address` VARCHAR(255) NOT NULL,
  `CollectionPoint` VARCHAR(255) NOT NULL,
  `Amount` DECIMAL(10,2) NOT NULL,
  `date_donated` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`donation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample data for `user` table
INSERT INTO `user` (`FullName`, `Email`, `CoNum`, `Password`) VALUES
('Ifadah', 'ifi@gmail.com', '777494050', 'Hiiiiiii'),
('Maryam Hussaina', 'MH@gmail.com', '2147483647', '123456789'),
('John', 'J@gmail.com', '982736123', '181104'),
('Rose', 'r@gmail.com', '2147483647', '987654321'),
('Perera', 'perera@gmail.com', '1233648972', 'perera@123');

-- Commit the transaction
COMMIT;
