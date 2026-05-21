-- SauceToGo Database Schema Initialization
-- Import this SQL file into your MySQL database server (e.g., via phpMyAdmin)

CREATE DATABASE IF NOT EXISTS `saucetogodb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `saucetogodb`;

-- --------------------------------------------------------
-- Table structure for table `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(20) DEFAULT 'user',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `products`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `image` VARCHAR(100) NOT NULL,
  `category` VARCHAR(50) NOT NULL -- 'spicy' or 'non-spicy'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `cart`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cart` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `orders`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `fullname` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `address` TEXT NOT NULL,
  `total_price` DECIMAL(10, 2) NOT NULL,
  `status` VARCHAR(50) DEFAULT 'Pending', -- 'Pending', 'Preparing', 'Out for Delivery', 'Delivered'
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `order_items`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_id` INT NOT NULL,
  `product_id` INT NOT NULL,
  `quantity` INT NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table structure for table `contact_messages`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `message` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Seed Initial Products (Dynamic Catalog)
-- --------------------------------------------------------
SET FOREIGN_KEY_CHECKS = 0;
DELETE FROM `products`;
ALTER TABLE `products` AUTO_INCREMENT = 1;
SET FOREIGN_KEY_CHECKS = 1;

-- Spicy Sauces
INSERT INTO `products` (`name`, `description`, `price`, `image`, `category`) VALUES
('The Original Chili Blend', 'A spicy blend to spice up any meal. Hand-crafted with select premium sun-ripened red chili peppers and secret herbs.', 199.00, 'spr.png', 'spicy'),
('Spicy Sweet Vinegar Sauce', 'A vibrant, sustained heat from red chili flakes combined with naturally aged sugarcane vinegar and brown sugar.', 249.00, 'vins.png', 'spicy'),
('Rich Spicy Gravy Blend', 'A rich, deeply roasted and savory gravy blend with bold smoky notes and a balanced, lingering fiery kick.', 229.00, 'gravy.png', 'spicy'),
('Avocado Wasabi Blend', 'A smooth, dynamic, zesty blend designed for sophisticated heat. Fresh creamy avocado meets organic horseradish wasabi.', 299.00, 'avowa.png', 'spicy'),
('Gourmet Spicy Mustard Blend', 'A tangier, complex gourmet spicy mustard blend. Rich mustard seeds crushed and spiked with habanero extract.', 249.00, 'mustard.png', 'spicy'),
('Spicy Tomato Blend', 'A bold, savory tomato reduction blend spiked with premium chilis, fresh garlic, and Mediterranean herbs.', 199.00, 'tomato.png', 'spicy');

-- Non-Spicy Sauces
INSERT INTO `products` (`name`, `description`, `price`, `image`, `category`) VALUES
('The Original Mild Chili Blend', 'A mild, sweet chili blend designed to add depth of flavor and appetizing tang to any meal without the intense heat.', 199.00, 'spr.png', 'non-spicy'),
('Sweet Honey Vinegar Sauce', 'A vibrant, sweet vinegar glaze infused with aromatic spices, fresh local honey, and tang, with absolutely zero heat.', 249.00, 'vins.png', 'non-spicy'),
('Rich Savory Gravy Blend', 'A classic rich, savory gravy blend cooked slowly to lock in deep, slow-roasted caramelized onion and garlic flavors.', 229.00, 'gravy.png', 'non-spicy'),
('Avocado Cream Blend', 'A beautifully smooth, creamy, and refreshing avocado spread blended with subtle coriander and key lime juice.', 299.00, 'avowa.png', 'non-spicy'),
('Gourmet Honey Mustard Blend', 'A smooth, sweet, and tangy gourmet mustard blend made with organic yellow mustard seeds and real wild honey.', 249.00, 'mustard.png', 'non-spicy'),
('Classic Herb Tomato Blend', 'A rich, thick, and bold Italian tomato reduction infused with extra virgin olive oil, sweet basil, oregano, and garlic.', 199.00, 'tomato.png', 'non-spicy');
