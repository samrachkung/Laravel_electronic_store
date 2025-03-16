/*
 Navicat Premium Data Transfer

 Source Server         : samrach
 Source Server Type    : MySQL
 Source Server Version : 90100
 Source Host           : localhost:3306
 Source Schema         : laravel_web_electronic_store

 Target Server Type    : MySQL
 Target Server Version : 90100
 File Encoding         : 65001

 Date: 15/03/2025 11:34:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for addresses
-- ----------------------------
DROP TABLE IF EXISTS `addresses`;
CREATE TABLE `addresses`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `first_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `street_address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `zip_code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `addresses_order_id_foreign`(`order_id` ASC) USING BTREE,
  CONSTRAINT `addresses_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of addresses
-- ----------------------------
INSERT INTO `addresses` VALUES (5, 21, 'Kibo', 'Mcleod', '+1 (456) 818-4594', 'Aut id neque harum', 'Iure lorem proident', 'Unknown', '00000', '2025-02-07 12:08:58', '2025-02-07 12:08:58');
INSERT INTO `addresses` VALUES (7, 23, 'Ignatius', 'Gallagher', '+1 (622) 555-7463', 'Animi adipisci exce', 'Sunt sit exercitati', 'Unknown', '00000', '2025-03-13 10:57:20', '2025-03-13 10:57:20');
INSERT INTO `addresses` VALUES (8, 24, 'Joy', 'Dyer', '+1 (594) 492-2071', 'Minus quis incididun', 'Ex ut accusamus natu', 'Unknown', '00000', '2025-03-13 11:42:51', '2025-03-13 11:42:51');
INSERT INTO `addresses` VALUES (10, 26, 'Zeus', 'Kelly', '+1 (481) 214-3156', 'Aut nisi aperiam dol', 'Eius ex voluptatem', 'Quis velit eos est', '00000', '2025-03-13 14:06:06', '2025-03-13 14:06:06');
INSERT INTO `addresses` VALUES (12, 30, 'Reagan', 'Melendez', '+1 (949) 632-4582', 'Ut nostrum accusamus', 'Adipisicing aliquid', 'Modi aut non praesen', '90720', '2025-03-13 14:17:17', '2025-03-13 14:17:17');
INSERT INTO `addresses` VALUES (13, 31, 'Colby', 'Baker', '+1 (881) 627-5135', 'Consequuntur dolorem', 'Dolores quisquam qui', 'Voluptate voluptas q', '46331', '2025-03-14 02:04:23', '2025-03-14 02:04:23');
INSERT INTO `addresses` VALUES (16, 34, 'Guinevere', 'Hodge', '+1 (595) 403-5299', 'Id officia veniam', 'Quidem pariatur Rec', 'Inventore sed est e', '27377', '2025-03-14 02:10:02', '2025-03-14 02:10:02');

-- ----------------------------
-- Table structure for brands
-- ----------------------------
DROP TABLE IF EXISTS `brands`;
CREATE TABLE `brands`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `brands_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of brands
-- ----------------------------
INSERT INTO `brands` VALUES (1, 'Apple', 'apple', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (2, 'Samsung', 'samsung', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (3, 'Sony', 'sony', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (4, 'LG', 'lg', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (5, 'Dell', 'dell', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (6, 'HP', 'hp', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (7, 'Asus', 'asus', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (8, 'Acer', 'acer', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (9, 'Lenovo', 'lenovo', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (10, 'Microsoft', 'microsoft', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (11, 'Xiaomi', 'xiaomi', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (12, 'OnePlus', 'oneplus', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (13, 'Oppo', 'oppo', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (14, 'Realme', 'realme', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (15, 'Google', 'google', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (16, 'Razer', 'razer', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (17, 'Amazon', 'amazon', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (18, 'Huawei', 'huawei', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (19, 'Nokia', 'nokia', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `brands` VALUES (20, 'Canon', 'canon', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');

-- ----------------------------
-- Table structure for carts
-- ----------------------------
DROP TABLE IF EXISTS `carts`;
CREATE TABLE `carts`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NULL DEFAULT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `carts_user_id_foreign`(`user_id` ASC) USING BTREE,
  INDEX `carts_product_id_foreign`(`product_id` ASC) USING BTREE,
  CONSTRAINT `carts_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 23 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of carts
-- ----------------------------

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `categories_slug_unique`(`slug` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES (1, 'Smartphones', 'smartphones', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `categories` VALUES (2, 'Laptops', 'laptops', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `categories` VALUES (3, 'Tablets', 'tablets', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `categories` VALUES (4, 'Smartwatches', 'smartwatches', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `categories` VALUES (5, 'Earphones', 'earphones', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `categories` VALUES (6, 'Gaming', 'gaming', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `categories` VALUES (7, 'Cameras', 'cameras', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `categories` VALUES (8, 'Monitors', 'monitors', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `categories` VALUES (9, 'Printers', 'printers', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');
INSERT INTO `categories` VALUES (10, 'Networking', 'networking', NULL, 1, '2025-02-01 12:35:42', '2025-02-01 12:35:42');

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `failed_jobs_uuid_unique`(`uuid` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO `migrations` VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO `migrations` VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO `migrations` VALUES (4, '2019_12_14_000001_create_personal_access_tokens_table', 1);
INSERT INTO `migrations` VALUES (5, '2025_01_30_032006_create_categories_table', 1);
INSERT INTO `migrations` VALUES (6, '2025_01_30_032026_create_brands_table', 1);
INSERT INTO `migrations` VALUES (7, '2025_01_30_032040_create_products_table', 1);
INSERT INTO `migrations` VALUES (8, '2025_01_30_032121_create_orders_table', 1);
INSERT INTO `migrations` VALUES (9, '2025_01_30_032132_create_order_items_table', 1);
INSERT INTO `migrations` VALUES (10, '2025_01_30_032143_create_addresses_table', 1);
INSERT INTO `migrations` VALUES (11, '2025_02_05_083214_create_carts_table', 1);

-- ----------------------------
-- Table structure for order_items
-- ----------------------------
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL DEFAULT 1,
  `unit_amount` decimal(10, 2) NULL DEFAULT NULL,
  `total_amount` decimal(10, 2) NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_items_order_id_foreign`(`order_id` ASC) USING BTREE,
  INDEX `order_items_product_id_foreign`(`product_id` ASC) USING BTREE,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of order_items
-- ----------------------------
INSERT INTO `order_items` VALUES (1, 23, 1, 1, 999.99, 999.99, '2025-03-13 10:57:20', '2025-03-13 10:57:20');
INSERT INTO `order_items` VALUES (2, 24, 1, 1, 999.99, 999.99, '2025-03-13 11:42:51', '2025-03-13 11:42:51');
INSERT INTO `order_items` VALUES (3, 24, 2, 1, 899.99, 899.99, '2025-03-13 11:42:51', '2025-03-13 11:42:51');
INSERT INTO `order_items` VALUES (5, 26, 1, 1, 999.99, 999.99, '2025-03-13 14:06:06', '2025-03-13 14:06:06');
INSERT INTO `order_items` VALUES (6, 26, 2, 1, 899.99, 899.99, '2025-03-13 14:06:06', '2025-03-13 14:06:06');
INSERT INTO `order_items` VALUES (7, 26, 3, 1, 1599.99, 1599.99, '2025-03-13 14:06:06', '2025-03-13 14:06:06');
INSERT INTO `order_items` VALUES (9, 30, 1, 1, 999.99, 999.99, '2025-03-13 14:17:17', '2025-03-13 14:17:17');
INSERT INTO `order_items` VALUES (10, 31, 2, 1, 899.99, 899.99, '2025-03-14 02:04:23', '2025-03-14 02:04:23');
INSERT INTO `order_items` VALUES (13, 34, 1, 2, 999.99, 1999.98, '2025-03-14 02:10:02', '2025-03-14 02:10:02');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `grand_total` decimal(10, 2) NULL DEFAULT NULL,
  `payment_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `payment_status` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `status` enum('new','processing','shipped','delivered','canceled') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `currency` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `shipping_amount` decimal(10, 2) NULL DEFAULT NULL,
  `shipping_method` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expected_arrival` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `orders_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (21, 13, 3499.97, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-02-07 12:08:58', '2025-02-07 12:09:18', NULL);
INSERT INTO `orders` VALUES (23, 11, 999.99, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-03-13 10:57:20', '2025-03-14 02:01:53', '2025-03-13 10:57:20');
INSERT INTO `orders` VALUES (24, 11, 1899.98, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-03-13 11:42:51', '2025-03-13 13:33:20', NULL);
INSERT INTO `orders` VALUES (26, 11, 3499.97, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-03-13 14:06:06', '2025-03-13 14:08:46', '2025-03-13 14:06:06');
INSERT INTO `orders` VALUES (30, 7, 999.99, 'Stripe', 'paid', 'shipped', 'USD', NULL, NULL, NULL, '2025-03-13 14:17:17', '2025-03-13 14:45:33', '2025-03-13 14:17:17');
INSERT INTO `orders` VALUES (31, 11, 899.99, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-03-14 02:04:23', '2025-03-14 02:05:01', '2025-03-14 02:04:23');
INSERT INTO `orders` VALUES (34, 11, 1999.98, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-03-14 02:10:02', '2025-03-14 02:10:25', '2025-03-14 02:10:02');

-- ----------------------------
-- Table structure for password_reset_tokens
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens`  (
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for personal_access_tokens
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `personal_access_tokens_token_unique`(`token` ASC) USING BTREE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type` ASC, `tokenable_id` ASC) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for products
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint UNSIGNED NULL DEFAULT NULL,
  `brand_id` bigint UNSIGNED NULL DEFAULT NULL,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `slug` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `image` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `price` decimal(10, 2) NULL DEFAULT NULL,
  `quantity` int NULL DEFAULT 0,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `is_featured` tinyint(1) NULL DEFAULT 0,
  `in_stock` tinyint(1) NULL DEFAULT 0,
  `on_sale` tinyint(1) NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `products_slug_unique`(`slug` ASC) USING BTREE,
  INDEX `products_category_id_foreign`(`category_id` ASC) USING BTREE,
  INDEX `products_brand_id_foreign`(`brand_id` ASC) USING BTREE,
  CONSTRAINT `products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 1, 1, 'iPhone 15', 'iphone-15-apple', 'frontend/images/product_images/1738389144.jpg', 'Latest Apple smartphone with A16 chip.', 999.99, 50, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 05:52:24');
INSERT INTO `products` VALUES (2, 1, 2, 'Samsung Galaxy S23', 'samsung-galaxy-s23-ultra', 'frontend/images/product_images/1738389501.jpg', 'Flagship Samsung smartphone with great camera.', 899.99, 40, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 05:58:21');
INSERT INTO `products` VALUES (3, 2, 5, 'Dell XPS 15', 'dell-xps-15-2024', 'frontend/images/product_images/1738390051.png', 'Powerful Dell laptop with Intel i7 processor.', 1599.99, 30, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 06:07:31');
INSERT INTO `products` VALUES (4, 2, 6, 'HP Spectre x360', 'hp-spectre-x360-gen2', 'frontend/images/product_images/1738390446.jpg', 'Improving on the best 2-in-1 laptop of the past few years,', 1399.99, 20, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 06:15:35');
INSERT INTO `products` VALUES (5, 3, 3, 'Sony Xperia Tablet', 'sony-xperia-tablet-2024', 'frontend/images/product_images/1738390651.jpg', 'High-resolution display tablet from Sony.', 499.99, 25, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 06:17:31');
INSERT INTO `products` VALUES (6, 3, 7, 'Asus ROG Tablet', 'asus-rog-tablet-pro', 'frontend/images/product_images/1738390940.jpg', 'ASUS ROG Flow Z13 (2023) Gaming Laptop Tablet', 799.99, 15, 1, 0, 1, 1, '2025-02-01 12:35:42', '2025-02-01 06:30:57');
INSERT INTO `products` VALUES (7, 4, 10, 'Microsoft Surface Watch', 'microsoft-surface-watch-2', 'frontend/images/product_images/1738391562.jpg', 'Smartwatch with productivity features.', 299.99, 35, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 06:32:42');
INSERT INTO `products` VALUES (8, 4, 11, 'Xiaomi Mi Watch', 'xiaomi-mi-watch-lite', 'frontend/images/product_images/1738391616.png', 'Affordable smartwatch with health tracking.', 129.99, 50, 1, 0, 1, 1, '2025-02-01 12:35:42', '2025-02-01 06:33:36');
INSERT INTO `products` VALUES (9, 5, 14, 'Realme Buds Wireless', 'realme-buds-wireless-v2', 'frontend/images/product_images/1738393053.jpg', 'High-quality wireless earbuds.', 79.99, 100, 1, 1, 1, 1, '2025-02-01 12:35:42', '2025-02-01 06:57:33');
INSERT INTO `products` VALUES (10, 5, 12, 'OnePlus Buds Pro', 'oneplus-buds-pro-2', 'frontend/images/product_images/1738393239.png', 'Premium earbuds with noise cancellation.', 149.99, 70, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:00:39');
INSERT INTO `products` VALUES (11, 6, 16, 'Google Stadia Controller', 'google-stadia-controller-elite', 'frontend/images/product_images/1738393310.jpg', 'Cloud gaming controller from Google.', 69.99, 45, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:01:50');
INSERT INTO `products` VALUES (12, 6, 19, 'Nokia Streaming Box', 'nokia-streaming-box-4k', 'frontend/images/product_images/1738393438.jpg', 'Smart TV streaming device.', 129.99, 60, 1, 0, 1, 1, '2025-02-01 12:35:42', '2025-02-01 07:03:58');
INSERT INTO `products` VALUES (13, 1, 18, 'HUAWEI PURA 70 PRO 4G', 'huawei-mirrorless-camera-x', 'frontend/images/product_images/1738394788.png', 'High-end mirrorless camera from Huawei.', 299.99, 10, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:26:28');
INSERT INTO `products` VALUES (14, 7, 4, 'LG 4K Camera', 'lg-4k-camera-pro', 'frontend/images/product_images/1738394877.jpg', '4K resolution camera from LG.', 899.99, 15, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:27:57');
INSERT INTO `products` VALUES (15, 8, 9, 'Lenovo ThinkVision Monitor', 'lenovo-thinkvision-monitor-qhd', 'frontend/images/product_images/1738395096.png', 'High-performance monitor for professionals.', 399.99, 25, 1, 1, 1, 1, '2025-02-01 12:35:42', '2025-02-01 07:31:36');
INSERT INTO `products` VALUES (16, 8, 7, 'Asus Gaming Monitor', 'asus-gaming-monitor-144hz', 'frontend/images/product_images/1738395171.jpg', 'Curved gaming monitor with 144Hz.', 499.99, 30, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:32:51');
INSERT INTO `products` VALUES (17, 9, 6, 'HP Deskjet Colour Printer', 'razer-printer-x1', 'frontend/images/product_images/1738396050.jpg', 'Gaming-themed printer from Razer.', 299.99, 15, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:47:30');
INSERT INTO `products` VALUES (18, 9, 6, 'HP Laser Printer', 'HP-laser-printer-fast', 'frontend/images/product_images/1738395831.jpg', 'Fast laser printer for office use.', 199.99, 40, 1, 0, 1, 1, '2025-02-01 12:35:42', '2025-02-01 07:45:55');
INSERT INTO `products` VALUES (19, 10, 17, 'Amazon WiFi Router', 'amazon-wifi-router-max', 'frontend/images/product_images/1738395859.jpg', 'High-speed router from Amazon.', 99.99, 100, 1, 1, 1, 1, '2025-02-01 12:35:42', '2025-02-01 07:44:19');
INSERT INTO `products` VALUES (20, 10, 15, 'Google Nest WiFi', 'google-nest-wifi-2ndgen', 'frontend/images/product_images/1738395915.jpg', 'Smart home WiFi system.', 249.99, 50, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:45:15');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Merrill Boone', 'jihynyneb@mailinator.com', NULL, '$2y$10$TE5FAQdrGwtoEMjTI.o9ou7S254YTQ7oC0b6qrvTgRb/97d4clv1e', NULL, NULL, NULL);
INSERT INTO `users` VALUES (2, 'Donna Rowe', 'sosyz@mailinator.com', NULL, '$2y$10$aW56fCUQd52XLYzJ98iNsOP3Sv.gFeNQaJfuAnQph0ZvqVkGyrt4m', NULL, NULL, NULL);
INSERT INTO `users` VALUES (3, 'Maggie Lyons', 'jyjopipy@mailinator.com', NULL, '$2y$10$6NhBiHR9AyjTNwP5IaIy0.E3JxSZfDtLXRfdP7/2tg6O5wXJNeQIW', NULL, NULL, NULL);
INSERT INTO `users` VALUES (4, 'Ulysses Mann', 'lafyxesev@mailinator.com', NULL, '$2y$10$zqdExYzicOsHMZwEPNZTc.vuZBCP66HVWK5Xn0aJJh5Frc3Ag1s8i', NULL, NULL, NULL);
INSERT INTO `users` VALUES (5, 'Byron Skinner', 'kahypamo@mailinator.com', NULL, '$2y$10$7nHdL4iYYVhDs4ijX01qreKiWXRGhyFdl0vgdn/uZJpN54PX3LttO', NULL, '2025-02-05 07:41:18', '2025-02-05 07:41:18');
INSERT INTO `users` VALUES (6, 'Akeem Vincent', 'fufehi@mailinator.com', NULL, '$2y$10$1KLN4WOqiyQ08.c4HC86C.GvYfZAONbOAUOqOuR6jZw4tmaUr251a', NULL, '2025-02-05 07:54:53', '2025-02-05 07:54:53');
INSERT INTO `users` VALUES (7, 'Hillary Wallace', 'hydar@mailinator.com', NULL, '$2y$10$WOTyqvWXHmmwzgJElkR05.y6gqyP5OJRAiR8zjvgSGAhdrfFAzqsi', NULL, '2025-02-05 08:00:24', '2025-02-05 08:00:24');
INSERT INTO `users` VALUES (8, 'Kyla Houston', 'mupyqe@mailinator.com', NULL, '$2y$10$dJ5ADl4GrkkVJ5fkZhNN3eEH4VvC3nucIshhX2FUEVtMmSSt5roZK', NULL, '2025-02-05 09:14:25', '2025-02-05 09:14:25');
INSERT INTO `users` VALUES (9, 'samrach', 'samrach088@gmail.com', NULL, '$2y$10$ODWql0WRzrtJpzD/o0CYLeDXlPkAiNm8YeViZ9uTNY5MvN1Mcl8f6', NULL, '2025-02-07 03:15:28', '2025-02-07 03:15:28');
INSERT INTO `users` VALUES (10, 'Quamar Mccarty', 'digajidage@mailinator.com', NULL, '$2y$10$7aw/QDlE2S4s/rOeW/dXd.auClMPob6Xhs/2o7nak2hgFPIUZNuku', NULL, '2025-02-07 04:54:24', '2025-02-07 04:54:24');
INSERT INTO `users` VALUES (11, 'Tucker York', 'buru@mailinator.com', NULL, '$2y$10$lBfviY48KzQLdMgldVc/Z.40f7X79KcCXO8v1gr8bKj3sHt31Mtmu', NULL, '2025-02-07 05:24:37', '2025-02-07 05:24:37');
INSERT INTO `users` VALUES (12, 'Karleigh Warren', 'zupekicag@mailinator.com', NULL, '$2y$10$NVXb.vcGTV.anAe1agXuP.6y6331rsh/3NTbf2aTDQNTbacw2/26K', NULL, '2025-02-07 11:51:21', '2025-02-07 11:51:21');
INSERT INTO `users` VALUES (13, 'Brody Irwin', 'qyba@mailinator.com', NULL, '$2y$10$RdErS8A5ow7zMDy2996jrOunDN17P8fBMkY.ZnCEtNe3yX/MgsOTS', NULL, '2025-02-07 12:08:41', '2025-02-07 12:08:41');

SET FOREIGN_KEY_CHECKS = 1;
