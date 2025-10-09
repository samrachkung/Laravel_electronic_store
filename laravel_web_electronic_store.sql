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

 Date: 09/05/2025 20:53:19
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
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of addresses
-- ----------------------------
INSERT INTO `addresses` VALUES (12, 30, 'Reagan', 'Melendez', '+1 (949) 632-4582', 'Ut nostrum accusamus', 'Adipisicing aliquid', 'Modi aut non praesen', '90720', '2025-03-13 14:17:17', '2025-03-13 14:17:17');
INSERT INTO `addresses` VALUES (20, 38, 'Zeus', 'Page', '+1 (239) 705-7883', 'Amet modi voluptatu', 'Explicabo Perferend', 'Consequatur dolorem', '62559', '2025-03-16 14:57:27', '2025-03-16 14:57:27');
INSERT INTO `addresses` VALUES (24, 46, 'Graham', 'Parker', '+1 (311) 111-6096', 'Deserunt incidunt d', 'Ut et cillum placeat', 'Elit deleniti cupid', '80276', '2025-03-19 12:16:38', '2025-03-19 12:16:38');
INSERT INTO `addresses` VALUES (36, 65, 'Garrett', 'Martin', '+1 (913) 255-8385', 'Labore quis labore m', 'Sint officia non et', 'Facere molestiae sed', '68234', '2025-03-26 11:20:24', '2025-03-26 11:20:24');
INSERT INTO `addresses` VALUES (37, 67, 'Vance', 'Daniel', '+1 (257) 163-8499', 'Voluptas et id volup', 'Duis voluptatem magn', 'Sit pariatur Magna', '16880', '2025-04-01 12:19:08', '2025-04-01 12:19:08');
INSERT INTO `addresses` VALUES (38, 68, 'Ima', 'Mcneil', '+1 (977) 176-6261', 'Aut ullam voluptas v', 'In blanditiis error', 'Minus dolore autem p', '42506', '2025-04-09 11:34:43', '2025-04-09 11:34:43');
INSERT INTO `addresses` VALUES (39, 69, 'Benjamin', 'Walton', '+1 (261) 789-4176', 'Odit consectetur id', 'Illum veniam fuga', 'Praesentium numquam', '54091', '2025-04-21 12:01:12', '2025-04-21 12:01:12');
INSERT INTO `addresses` VALUES (41, 71, 'Abdul', 'Cote', '+1 (372) 406-4866', 'Magna optio numquam', 'Earum quo veniam ve', 'Sint consequatur con', '80295', '2025-04-25 13:33:38', '2025-04-25 13:33:38');
INSERT INTO `addresses` VALUES (42, 72, 'Jamalia', 'Bernard', '+1 (624) 485-6833', 'Et corporis nostrum', 'Ut magna ullamco qui', 'Voluptatem accusamus', '14614', '2025-04-26 05:27:25', '2025-04-26 05:27:25');
INSERT INTO `addresses` VALUES (43, 73, 'Quinn', 'Porter', '+1 (835) 689-6901', 'Pariatur Maxime rer', 'Perspiciatis dolore', 'Cupiditate eveniet', '28140', '2025-04-26 07:01:28', '2025-04-26 07:01:28');
INSERT INTO `addresses` VALUES (44, 74, 'Flynn', 'Price', '+1 (651) 169-7945', 'Incididunt eos qui', 'Alias deleniti ut vo', 'Placeat ea illo qua', '61913', '2025-04-29 05:50:34', '2025-04-29 05:50:34');
INSERT INTO `addresses` VALUES (45, 75, 'Maya', 'Romero', '+1 (606) 429-3432', 'Esse deserunt eiusmo', 'Vero non quaerat ut', 'Placeat sint repre', '18062', '2025-04-29 10:25:51', '2025-04-29 10:25:51');
INSERT INTO `addresses` VALUES (46, 76, 'Nayda', 'Drake', '+1 (884) 943-6324', 'Minus proident volu', 'Iste voluptatem exe', 'Qui quas impedit qu', '39881', '2025-04-29 12:03:44', '2025-04-29 12:03:44');
INSERT INTO `addresses` VALUES (47, 77, 'Kibo', 'Banks', '+1 (251) 225-9876', 'Et quidem reiciendis', 'Aperiam sit qui ulla', 'Repudiandae possimus', '38967', '2025-04-29 12:06:38', '2025-04-29 12:06:38');
INSERT INTO `addresses` VALUES (48, 78, 'Hedwig', 'Stevenson', '+1 (404) 191-2853', 'Quos commodo molesti', 'Aut qui impedit ame', 'Corporis alias quaer', '39053', '2025-04-30 08:15:55', '2025-04-30 08:15:55');
INSERT INTO `addresses` VALUES (49, 79, 'Kiara', 'Cash', '+1 (696) 112-5809', 'Nihil consequatur qu', 'Error ipsum quidem a', 'Molestiae fuga Quia', '54684', '2025-04-30 09:45:45', '2025-04-30 09:45:45');
INSERT INTO `addresses` VALUES (50, 80, 'Craig', 'Crawford', '+1 (944) 553-8785', 'Consequuntur est qu', 'Quo minima odio volu', 'Illo elit sapiente', '84932', '2025-04-30 11:20:56', '2025-04-30 11:20:56');
INSERT INTO `addresses` VALUES (51, 81, 'Phoebe', 'Hendrix', '+1 (602) 249-9258', 'Ut ut voluptatem qua', 'Placeat ad ducimus', 'Quia maiores quia ne', '72496', '2025-04-30 11:59:11', '2025-04-30 11:59:11');
INSERT INTO `addresses` VALUES (54, 84, 'Angela', 'Patel', '+1 (994) 681-6348', 'Deserunt animi quis', 'Earum magna deserunt', 'Qui suscipit dolores', '16912', '2025-05-09 06:20:47', '2025-05-09 06:20:47');
INSERT INTO `addresses` VALUES (55, 85, 'Isabella', 'Vaughan', '+1 (664) 881-4471', 'Dolore sapiente iure', 'Laboris aliquid nihi', 'Do quia ea laborum c', '98015', '2025-05-09 13:25:41', '2025-05-09 13:25:41');
INSERT INTO `addresses` VALUES (56, 86, 'Isabella', 'Vaughan', '6648814471', 'Dolore sapiente iure', 'Laboris aliquid nihi', 'Do quia ea laborum c', '98015', '2025-05-09 13:32:53', '2025-05-09 13:32:53');
INSERT INTO `addresses` VALUES (57, 87, 'Isabella', 'Vaughan', '6648814471', 'Dolore sapiente iure', 'Laboris aliquid nihi', 'Unknown', '98015', '2025-05-09 13:46:54', '2025-05-09 13:46:54');
INSERT INTO `addresses` VALUES (58, 88, 'Isabella', 'Vaughan', '6648814471', 'Dolore sapiente iure', 'Laboris aliquid nihi', 'Unknown', '98015', '2025-05-09 13:48:23', '2025-05-09 13:48:23');

-- ----------------------------
-- Table structure for admins
-- ----------------------------
DROP TABLE IF EXISTS `admins`;
CREATE TABLE `admins`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `admins_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of admins
-- ----------------------------
INSERT INTO `admins` VALUES (1, 'samrach', 'samrach@gmail.com', '$2y$10$HxZRnzb3GVcUAD/lMVGU8uFRdmyerogy1pvnYcADCw.27xNO9xPmi', '2025-05-07 18:19:43', '2025-05-07 18:19:47');

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
) ENGINE = InnoDB AUTO_INCREMENT = 25 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 103 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of carts
-- ----------------------------
INSERT INTO `carts` VALUES (48, 10, 1, 1, '2025-03-19 12:35:58', '2025-03-19 12:35:58');
INSERT INTO `carts` VALUES (49, 10, 2, 1, '2025-03-19 12:35:59', '2025-03-19 12:35:59');
INSERT INTO `carts` VALUES (50, 14, 1, 1, '2025-03-19 12:53:38', '2025-03-19 12:53:38');
INSERT INTO `carts` VALUES (86, 21, 1, 1, '2025-04-30 11:45:53', '2025-04-30 11:45:53');
INSERT INTO `carts` VALUES (87, 21, 3, 28, '2025-04-30 11:45:56', '2025-04-30 11:46:00');
INSERT INTO `carts` VALUES (97, 11, 2, 2, '2025-05-09 13:24:40', '2025-05-09 13:24:41');
INSERT INTO `carts` VALUES (101, 11, 7, 1, '2025-05-09 13:49:53', '2025-05-09 13:49:53');
INSERT INTO `carts` VALUES (102, 11, 8, 3, '2025-05-09 13:50:01', '2025-05-09 13:50:10');

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
) ENGINE = InnoDB AUTO_INCREMENT = 16 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
INSERT INTO `migrations` VALUES (12, '2025_04_26_045241_add_column_to_table_user_table', 2);
INSERT INTO `migrations` VALUES (13, '2025_04_26_045403_create_roles_table', 2);
INSERT INTO `migrations` VALUES (14, '2025_04_26_045421_create_permissions_table', 2);
INSERT INTO `migrations` VALUES (15, '2025_04_26_045441_create_role_user_table', 2);
INSERT INTO `migrations` VALUES (16, '2025_04_26_045452_create_permission_role_table', 2);
INSERT INTO `migrations` VALUES (17, '2025_05_07_105516_create_admins_table', 3);
INSERT INTO `migrations` VALUES (18, '2025_05_07_112402_create_role_admin_table', 4);

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
) ENGINE = InnoDB AUTO_INCREMENT = 101 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of order_items
-- ----------------------------
INSERT INTO `order_items` VALUES (9, 30, 1, 1, 999.99, 999.99, '2025-03-13 14:17:17', '2025-03-13 14:17:17');
INSERT INTO `order_items` VALUES (24, 38, 4, 1, 1399.99, 1399.99, '2025-03-16 14:57:27', '2025-03-16 14:57:27');
INSERT INTO `order_items` VALUES (25, 38, 7, 1, 299.99, 299.99, '2025-03-16 14:57:27', '2025-03-16 14:57:27');
INSERT INTO `order_items` VALUES (26, 38, 8, 1, 129.99, 129.99, '2025-03-16 14:57:27', '2025-03-16 14:57:27');
INSERT INTO `order_items` VALUES (27, 38, 9, 1, 79.99, 79.99, '2025-03-16 14:57:27', '2025-03-16 14:57:27');
INSERT INTO `order_items` VALUES (28, 38, 1, 1, 999.99, 999.99, '2025-03-16 14:57:27', '2025-03-16 14:57:27');
INSERT INTO `order_items` VALUES (29, 38, 2, 1, 899.99, 899.99, '2025-03-16 14:57:27', '2025-03-16 14:57:27');
INSERT INTO `order_items` VALUES (35, 46, 2, 1, 899.99, 899.99, '2025-03-19 12:16:38', '2025-03-19 12:16:38');
INSERT INTO `order_items` VALUES (58, 65, 1, 1, 999.99, 999.99, '2025-03-26 11:20:24', '2025-03-26 11:20:24');
INSERT INTO `order_items` VALUES (59, 65, 3, 2, 1599.99, 3199.98, '2025-03-26 11:20:24', '2025-03-26 11:20:24');
INSERT INTO `order_items` VALUES (60, 67, 1, 1, 999.99, 999.99, '2025-04-01 12:19:08', '2025-04-01 12:19:08');
INSERT INTO `order_items` VALUES (61, 67, 2, 1, 899.99, 899.99, '2025-04-01 12:19:08', '2025-04-01 12:19:08');
INSERT INTO `order_items` VALUES (62, 67, 3, 1, 1599.99, 1599.99, '2025-04-01 12:19:08', '2025-04-01 12:19:08');
INSERT INTO `order_items` VALUES (63, 67, 5, 1, 499.99, 499.99, '2025-04-01 12:19:08', '2025-04-01 12:19:08');
INSERT INTO `order_items` VALUES (64, 67, 6, 1, 799.99, 799.99, '2025-04-01 12:19:08', '2025-04-01 12:19:08');
INSERT INTO `order_items` VALUES (65, 67, 4, 1, 1399.99, 1399.99, '2025-04-01 12:19:08', '2025-04-01 12:19:08');
INSERT INTO `order_items` VALUES (66, 68, 1, 1, 999.99, 999.99, '2025-04-09 11:34:43', '2025-04-09 11:34:43');
INSERT INTO `order_items` VALUES (67, 68, 2, 1, 899.99, 899.99, '2025-04-09 11:34:43', '2025-04-09 11:34:43');
INSERT INTO `order_items` VALUES (68, 68, 3, 1, 1599.99, 1599.99, '2025-04-09 11:34:43', '2025-04-09 11:34:43');
INSERT INTO `order_items` VALUES (69, 69, 1, 1, 999.99, 999.99, '2025-04-21 12:01:12', '2025-04-21 12:01:12');
INSERT INTO `order_items` VALUES (71, 71, 1, 2, 999.99, 1999.98, '2025-04-25 13:33:38', '2025-04-25 13:33:38');
INSERT INTO `order_items` VALUES (72, 72, 1, 3, 999.99, 2999.97, '2025-04-26 05:27:25', '2025-04-26 05:27:25');
INSERT INTO `order_items` VALUES (73, 73, 1, 1, 999.99, 999.99, '2025-04-26 07:01:28', '2025-04-26 07:01:28');
INSERT INTO `order_items` VALUES (74, 73, 2, 1, 899.99, 899.99, '2025-04-26 07:01:28', '2025-04-26 07:01:28');
INSERT INTO `order_items` VALUES (75, 73, 3, 1, 1599.99, 1599.99, '2025-04-26 07:01:28', '2025-04-26 07:01:28');
INSERT INTO `order_items` VALUES (76, 74, 1, 2, 999.99, 1999.98, '2025-04-29 05:50:34', '2025-04-29 05:50:34');
INSERT INTO `order_items` VALUES (77, 74, 2, 2, 899.99, 1799.98, '2025-04-29 05:50:34', '2025-04-29 05:50:34');
INSERT INTO `order_items` VALUES (78, 75, 2, 1, 899.99, 899.99, '2025-04-29 10:25:51', '2025-04-29 10:25:51');
INSERT INTO `order_items` VALUES (79, 76, 1, 2, 999.99, 1999.98, '2025-04-29 12:03:44', '2025-04-29 12:03:44');
INSERT INTO `order_items` VALUES (80, 76, 2, 1, 899.99, 899.99, '2025-04-29 12:03:44', '2025-04-29 12:03:44');
INSERT INTO `order_items` VALUES (81, 76, 3, 1, 1599.99, 1599.99, '2025-04-29 12:03:44', '2025-04-29 12:03:44');
INSERT INTO `order_items` VALUES (82, 77, 1, 3, 999.99, 2999.97, '2025-04-29 12:06:38', '2025-04-29 12:06:38');
INSERT INTO `order_items` VALUES (83, 78, 1, 2, 999.99, 1999.98, '2025-04-30 08:15:55', '2025-04-30 08:15:55');
INSERT INTO `order_items` VALUES (84, 78, 2, 3, 899.99, 2699.97, '2025-04-30 08:15:55', '2025-04-30 08:15:55');
INSERT INTO `order_items` VALUES (85, 79, 2, 1, 899.99, 899.99, '2025-04-30 09:45:45', '2025-04-30 09:45:45');
INSERT INTO `order_items` VALUES (86, 79, 5, 1, 499.99, 499.99, '2025-04-30 09:45:45', '2025-04-30 09:45:45');
INSERT INTO `order_items` VALUES (87, 79, 1, 2, 999.99, 1999.98, '2025-04-30 09:45:45', '2025-04-30 09:45:45');
INSERT INTO `order_items` VALUES (88, 80, 1, 2, 999.99, 1999.98, '2025-04-30 11:20:56', '2025-04-30 11:20:56');
INSERT INTO `order_items` VALUES (89, 80, 2, 1, 899.99, 899.99, '2025-04-30 11:20:56', '2025-04-30 11:20:56');
INSERT INTO `order_items` VALUES (90, 81, 1, 3, 999.99, 2999.97, '2025-04-30 11:59:11', '2025-04-30 11:59:11');
INSERT INTO `order_items` VALUES (91, 81, 3, 1, 1599.99, 1599.99, '2025-04-30 11:59:11', '2025-04-30 11:59:11');
INSERT INTO `order_items` VALUES (94, 84, 1, 3, 999.99, 2999.97, '2025-05-09 06:20:47', '2025-05-09 06:20:47');
INSERT INTO `order_items` VALUES (95, 85, 4, 2, 1399.99, 2799.98, '2025-05-09 13:25:41', '2025-05-09 13:25:41');
INSERT INTO `order_items` VALUES (96, 85, 5, 2, 499.99, 999.98, '2025-05-09 13:25:41', '2025-05-09 13:25:41');
INSERT INTO `order_items` VALUES (97, 85, 1, 2, 999.99, 1999.98, '2025-05-09 13:25:41', '2025-05-09 13:25:41');
INSERT INTO `order_items` VALUES (98, 86, 1, 5, 999.99, 4999.95, '2025-05-09 13:32:53', '2025-05-09 13:32:53');
INSERT INTO `order_items` VALUES (99, 87, 1, 1, 999.99, 999.99, '2025-05-09 13:46:54', '2025-05-09 13:46:54');
INSERT INTO `order_items` VALUES (100, 88, 1, 1, 999.99, 999.99, '2025-05-09 13:48:23', '2025-05-09 13:48:23');

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
) ENGINE = InnoDB AUTO_INCREMENT = 89 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES (30, 7, 999.99, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-03-13 14:17:17', '2025-04-09 11:29:23', '2025-03-13 14:17:17');
INSERT INTO `orders` VALUES (38, 9, 3809.94, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-03-16 14:57:27', '2025-03-16 14:58:09', '2025-03-16 14:57:27');
INSERT INTO `orders` VALUES (46, 11, 899.99, 'Stripe', 'paid', 'shipped', 'USD', NULL, NULL, NULL, '2025-03-19 12:16:38', '2025-03-26 11:36:11', '2025-03-19 12:16:38');
INSERT INTO `orders` VALUES (65, 11, 4199.97, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-03-26 11:20:24', '2025-03-26 11:21:48', '2025-03-26 11:20:24');
INSERT INTO `orders` VALUES (67, 11, 6199.94, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-04-01 12:19:08', '2025-04-01 12:20:46', '2025-04-01 12:19:08');
INSERT INTO `orders` VALUES (68, 17, 3499.97, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-04-09 11:34:43', '2025-04-09 11:36:22', '2025-04-09 11:34:43');
INSERT INTO `orders` VALUES (69, 11, 999.99, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-04-21 12:01:12', '2025-04-21 12:01:34', '2025-04-21 12:01:12');
INSERT INTO `orders` VALUES (71, 8, 1999.98, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-04-25 13:33:38', '2025-04-25 13:35:27', '2025-04-25 13:33:38');
INSERT INTO `orders` VALUES (72, 18, 2999.97, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-04-26 05:27:25', '2025-04-26 05:27:43', '2025-04-26 05:27:25');
INSERT INTO `orders` VALUES (73, 18, 3499.97, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-04-26 07:01:28', '2025-04-26 07:02:25', '2025-04-26 07:01:28');
INSERT INTO `orders` VALUES (74, 16, 3799.96, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-04-29 05:50:34', '2025-04-29 05:50:59', '2025-04-29 05:50:34');
INSERT INTO `orders` VALUES (75, 11, 899.99, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-04-29 10:25:51', '2025-04-29 10:30:26', '2025-04-29 10:25:51');
INSERT INTO `orders` VALUES (76, 11, 4499.96, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-04-29 12:03:44', '2025-04-29 12:05:58', '2025-04-29 12:03:44');
INSERT INTO `orders` VALUES (77, 11, 2999.97, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-04-29 12:06:38', '2025-04-29 12:07:00', '2025-04-29 12:06:38');
INSERT INTO `orders` VALUES (78, 19, 4699.95, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-04-30 08:15:55', '2025-04-30 08:16:15', '2025-04-30 08:15:55');
INSERT INTO `orders` VALUES (79, 20, 3399.96, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-04-30 09:45:45', '2025-04-30 09:49:55', '2025-04-30 09:45:45');
INSERT INTO `orders` VALUES (80, 9, 2899.97, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-04-30 11:20:56', '2025-04-30 11:53:54', '2025-04-30 11:20:56');
INSERT INTO `orders` VALUES (81, 24, 4599.96, 'Stripe', 'paid', 'shipped', 'USD', NULL, NULL, NULL, '2025-04-30 11:59:11', '2025-05-09 06:16:13', '2025-04-30 11:59:11');
INSERT INTO `orders` VALUES (84, 11, 2999.97, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-05-09 06:20:47', '2025-05-09 06:22:58', '2025-05-09 06:20:47');
INSERT INTO `orders` VALUES (85, 26, 5799.94, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-05-09 13:25:41', '2025-05-09 13:32:15', '2025-05-09 13:25:41');
INSERT INTO `orders` VALUES (86, 26, 4999.95, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-05-09 13:32:53', '2025-05-09 13:33:49', '2025-05-09 13:32:53');
INSERT INTO `orders` VALUES (87, 26, 999.99, 'Stripe', 'paid', 'processing', 'USD', NULL, NULL, NULL, '2025-05-09 13:46:54', '2025-05-09 13:47:24', '2025-05-09 13:46:54');
INSERT INTO `orders` VALUES (88, 26, 999.99, 'Stripe', 'paid', 'delivered', 'USD', NULL, NULL, NULL, '2025-05-09 13:48:23', '2025-05-09 13:49:12', '2025-05-09 13:48:23');

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
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `permission_role_permission_id_foreign`(`permission_id` ASC) USING BTREE,
  INDEX `permission_role_role_id_foreign`(`role_id` ASC) USING BTREE,
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 14 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES (1, 1, 2, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (2, 2, 2, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (3, 3, 2, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (4, 4, 2, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (5, 5, 2, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (6, 6, 2, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (8, 1, 1, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (9, 4, 1, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (10, 5, 1, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (11, 4, 4, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (12, 5, 4, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permission_role` VALUES (13, 6, 4, '2025-04-30 15:36:34', '2025-04-30 15:36:34');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'view_users', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permissions` VALUES (2, 'edit_users', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permissions` VALUES (3, 'delete_users', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permissions` VALUES (4, 'create_posts', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permissions` VALUES (5, 'edit_posts', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `permissions` VALUES (6, 'delete_posts', '2025-04-30 15:36:34', '2025-04-30 15:36:34');

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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

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
) ENGINE = InnoDB AUTO_INCREMENT = 34 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES (1, 1, 1, 'iPhone 15', 'iphone-15-apple', '1742015513.jpg', 'Latest Apple smartphone with A16 chip.', 999.99, 50, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 05:52:24');
INSERT INTO `products` VALUES (2, 1, 2, 'Samsung Galaxy S23', 'samsung-galaxy-s23-ultra', '1738389501.jpg', 'Flagship Samsung smartphone with great camera.', 899.99, 40, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 05:58:21');
INSERT INTO `products` VALUES (3, 2, 5, 'Dell XPS 15', 'dell-xps-15-2024', '1738390051.png', 'Powerful Dell laptop with Intel i7 processor.', 1599.99, 30, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 06:07:31');
INSERT INTO `products` VALUES (4, 2, 6, 'HP Spectre x360', 'hp-spectre-x360-gen2', '1738390446.jpg', 'Improving on the best 2-in-1 laptop of the past few years,', 1399.99, 9, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-05-09 13:38:57');
INSERT INTO `products` VALUES (5, 3, 3, 'Sony Xperia Tablet', 'sony-xperia-tablet-2024', '1738390651.jpg', 'High-resolution display tablet from Sony.', 499.99, 0, 1, 0, 0, 0, '2025-02-01 12:35:42', '2025-05-09 13:39:11');
INSERT INTO `products` VALUES (6, 3, 7, 'Asus ROG Tablet', 'asus-rog-tablet-pro', '1738390940.jpg', 'ASUS ROG Flow Z13 (2023) Gaming Laptop Tablet', 799.99, 100, 1, 0, 1, 1, '2025-02-01 12:35:42', '2025-04-30 12:02:53');
INSERT INTO `products` VALUES (7, 4, 10, 'Microsoft Surface Watch', 'microsoft-surface-watch-2', '1738391562.jpg', 'Smartwatch with productivity features.', 299.99, 35, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 06:32:42');
INSERT INTO `products` VALUES (8, 4, 11, 'Xiaomi Mi Watch', 'xiaomi-mi-watch-lite', '1738391616.png', 'Affordable smartwatch with health tracking.', 129.99, 50, 1, 0, 1, 1, '2025-02-01 12:35:42', '2025-02-01 06:33:36');
INSERT INTO `products` VALUES (9, 5, 14, 'Realme Buds Wireless', 'realme-buds-wireless-v2', '1738393053.jpg', 'High-quality wireless earbuds.', 79.99, 100, 1, 1, 1, 1, '2025-02-01 12:35:42', '2025-02-01 06:57:33');
INSERT INTO `products` VALUES (10, 5, 12, 'OnePlus Buds Pro', 'oneplus-buds-pro-2', '1738393239.png', 'Premium earbuds with noise cancellation.', 149.99, 70, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:00:39');
INSERT INTO `products` VALUES (11, 6, 16, 'Google Stadia Controller', 'google-stadia-controller-elite', '1738393310.jpg', 'Cloud gaming controller from Google.', 69.99, 45, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:01:50');
INSERT INTO `products` VALUES (12, 6, 19, 'Nokia Streaming Box', 'nokia-streaming-box-4k', '1738393438.jpg', 'Smart TV streaming device.', 129.99, 60, 1, 0, 1, 1, '2025-02-01 12:35:42', '2025-02-01 07:03:58');
INSERT INTO `products` VALUES (13, 1, 18, 'HUAWEI PURA 70 PRO 4G', 'huawei-mirrorless-camera-x', '1738394788.png', 'High-end mirrorless camera from Huawei.', 299.99, 100, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-04-29 16:06:22');
INSERT INTO `products` VALUES (14, 7, 4, 'LG 4K Camera', 'lg-4k-camera-pro', '1738394877.jpg', '4K resolution camera from LG.', 899.99, 1000, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-04-30 12:03:06');
INSERT INTO `products` VALUES (15, 8, 9, 'Lenovo ThinkVision Monitor', 'lenovo-thinkvision-monitor-qhd', '1738395096.png', 'High-performance monitor for professionals.', 399.99, 25, 1, 1, 1, 1, '2025-02-01 12:35:42', '2025-02-01 07:31:36');
INSERT INTO `products` VALUES (16, 8, 7, 'Asus Gaming Monitor', 'asus-gaming-monitor-144hz', '1738395171.jpg', 'Curved gaming monitor with 144Hz.', 499.99, 30, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:32:51');
INSERT INTO `products` VALUES (17, 9, 6, 'HP Deskjet Colour Printer', 'razer-printer-x1', '1738396050.jpg', 'Gaming-themed printer from Razer.', 299.99, 100, 1, 1, 1, 0, '2025-02-01 12:35:42', '2025-05-09 06:02:37');
INSERT INTO `products` VALUES (18, 9, 6, 'HP Laser Printer', 'HP-laser-printer-fast', '1738395831.jpg', 'Fast laser printer for office use.', 199.99, 40, 1, 0, 1, 1, '2025-02-01 12:35:42', '2025-02-01 07:45:55');
INSERT INTO `products` VALUES (19, 10, 17, 'Amazon WiFi Router', 'amazon-wifi-router-max', '1738395859.jpg', 'High-speed router from Amazon.', 99.99, 100, 1, 1, 1, 1, '2025-02-01 12:35:42', '2025-02-01 07:44:19');
INSERT INTO `products` VALUES (20, 10, 15, 'Google Nest WiFi', 'google-nest-wifi-2ndgen', '1742015416.jpg', 'Smart home WiFi system.', 249.99, 50, 1, 0, 1, 0, '2025-02-01 12:35:42', '2025-02-01 07:45:15');

-- ----------------------------
-- Table structure for role_admin
-- ----------------------------
DROP TABLE IF EXISTS `role_admin`;
CREATE TABLE `role_admin`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `role_admin_role_id_foreign`(`role_id` ASC) USING BTREE,
  INDEX `role_admin_admin_id_foreign`(`admin_id` ASC) USING BTREE,
  CONSTRAINT `role_admin_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_admin_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_admin
-- ----------------------------
INSERT INTO `role_admin` VALUES (1, 2, 1, '2025-05-07 18:26:50', '2025-05-07 18:26:54');

-- ----------------------------
-- Table structure for role_user
-- ----------------------------
DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `role_user_role_id_foreign`(`role_id` ASC) USING BTREE,
  INDEX `role_user_user_id_foreign`(`user_id` ASC) USING BTREE,
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of role_user
-- ----------------------------
INSERT INTO `role_user` VALUES (1, 1, 1, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `role_user` VALUES (2, 2, 2, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `role_user` VALUES (3, 3, 3, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `role_user` VALUES (4, 4, 4, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `role_user` VALUES (5, 5, 5, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `role_user` VALUES (6, 6, 6, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `role_user` VALUES (7, 2, 9, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `role_user` VALUES (8, 3, 7, '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `role_user` VALUES (9, 2, 20, NULL, NULL);
INSERT INTO `role_user` VALUES (10, 2, 21, NULL, NULL);
INSERT INTO `role_user` VALUES (11, 2, 22, NULL, NULL);
INSERT INTO `role_user` VALUES (12, 6, 25, NULL, NULL);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, 'Manager', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `roles` VALUES (2, 'admin', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `roles` VALUES (3, 'Customer', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `roles` VALUES (4, 'Editor', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `roles` VALUES (5, 'Support', '2025-04-30 15:36:34', '2025-04-30 15:36:34');
INSERT INTO `roles` VALUES (6, 'Viewer', '2025-04-30 15:36:34', '2025-04-30 15:36:34');

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
  `level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `active` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `language` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `users_email_unique`(`email` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'Merrill Boone', 'jihynyneb@mailinator.com', NULL, '$2y$10$TE5FAQdrGwtoEMjTI.o9ou7S254YTQ7oC0b6qrvTgRb/97d4clv1e', NULL, NULL, NULL, NULL, '1', NULL);
INSERT INTO `users` VALUES (2, 'Donna Rowe', 'sosyz@mailinator.com', NULL, '$2y$10$aW56fCUQd52XLYzJ98iNsOP3Sv.gFeNQaJfuAnQph0ZvqVkGyrt4m', NULL, NULL, NULL, NULL, '1', NULL);
INSERT INTO `users` VALUES (3, 'Maggie Lyons', 'jyjopipy@mailinator.com', NULL, '$2y$10$6NhBiHR9AyjTNwP5IaIy0.E3JxSZfDtLXRfdP7/2tg6O5wXJNeQIW', NULL, NULL, NULL, NULL, '1', NULL);
INSERT INTO `users` VALUES (4, 'Ulysses Mann', 'lafyxesev@mailinator.com', NULL, '$2y$10$zqdExYzicOsHMZwEPNZTc.vuZBCP66HVWK5Xn0aJJh5Frc3Ag1s8i', NULL, NULL, NULL, NULL, '1', NULL);
INSERT INTO `users` VALUES (5, 'Byron Skinner', 'kahypamo@mailinator.com', NULL, '$2y$10$7nHdL4iYYVhDs4ijX01qreKiWXRGhyFdl0vgdn/uZJpN54PX3LttO', NULL, '2025-02-05 07:41:18', '2025-02-05 07:41:18', NULL, '1', NULL);
INSERT INTO `users` VALUES (6, 'Akeem Vincent', 'fufehi@mailinator.com', NULL, '$2y$10$1KLN4WOqiyQ08.c4HC86C.GvYfZAONbOAUOqOuR6jZw4tmaUr251a', NULL, '2025-02-05 07:54:53', '2025-02-05 07:54:53', NULL, '1', NULL);
INSERT INTO `users` VALUES (7, 'Hillary Wallace', 'hydar@mailinator.com', NULL, '$2y$10$WOTyqvWXHmmwzgJElkR05.y6gqyP5OJRAiR8zjvgSGAhdrfFAzqsi', NULL, '2025-02-05 08:00:24', '2025-02-05 08:00:24', NULL, '1', NULL);
INSERT INTO `users` VALUES (8, 'Kyla Houston', 'mupyqe@mailinator.com', NULL, '$2y$10$dJ5ADl4GrkkVJ5fkZhNN3eEH4VvC3nucIshhX2FUEVtMmSSt5roZK', NULL, '2025-02-05 09:14:25', '2025-02-05 09:14:25', NULL, '1', NULL);
INSERT INTO `users` VALUES (9, 'samrach', 'samrach088@gmail.com', NULL, '$2y$10$ODWql0WRzrtJpzD/o0CYLeDXlPkAiNm8YeViZ9uTNY5MvN1Mcl8f6', NULL, '2025-02-07 03:15:28', '2025-02-07 03:15:28', NULL, '1', NULL);
INSERT INTO `users` VALUES (10, 'Quamar Mccarty', 'digajidage@mailinator.com', NULL, '$2y$10$7aw/QDlE2S4s/rOeW/dXd.auClMPob6Xhs/2o7nak2hgFPIUZNuku', NULL, '2025-02-07 04:54:24', '2025-02-07 04:54:24', NULL, '1', NULL);
INSERT INTO `users` VALUES (11, 'Tucker York', 'buru@mailinator.com', NULL, '$2y$10$lBfviY48KzQLdMgldVc/Z.40f7X79KcCXO8v1gr8bKj3sHt31Mtmu', NULL, '2025-02-07 05:24:37', '2025-02-07 05:24:37', NULL, '1', NULL);
INSERT INTO `users` VALUES (12, 'Karleigh Warren', 'zupekicag@mailinator.com', NULL, '$2y$10$NVXb.vcGTV.anAe1agXuP.6y6331rsh/3NTbf2aTDQNTbacw2/26K', NULL, '2025-02-07 11:51:21', '2025-02-07 11:51:21', NULL, '1', NULL);
INSERT INTO `users` VALUES (13, 'Brody Irwin', 'qyba@mailinator.com', NULL, '$2y$10$RdErS8A5ow7zMDy2996jrOunDN17P8fBMkY.ZnCEtNe3yX/MgsOTS', NULL, '2025-02-07 12:08:41', '2025-02-07 12:08:41', NULL, '1', NULL);
INSERT INTO `users` VALUES (14, 'test', 'test@gmail.com', NULL, '$2y$10$yJonmXamF67p4/SEo1i9j.dVGtAHma/utERdy76R.ZOvzr38sNPyG', NULL, '2025-03-19 12:53:23', '2025-03-19 12:53:23', NULL, '1', NULL);
INSERT INTO `users` VALUES (15, 'Nina Owens', 'bunugub@mailinator.com', NULL, '$2y$10$lqjM4/cS24yeBP.c1hwcE.Ts3SgjfgloxvP1kPOV.y8Lbtl1sKShG', NULL, '2025-03-22 11:37:17', '2025-03-22 11:37:17', NULL, '1', NULL);
INSERT INTO `users` VALUES (16, 'Brynne Hardin', 'mejyza@mailinator.com', NULL, '$2y$10$/RhxwaLJ7q3HbDCPOwRiEOmMFEqpY46wsRhSbt.RwQLjQSixg25qW', NULL, '2025-03-26 11:17:01', '2025-03-26 11:17:01', NULL, '1', NULL);
INSERT INTO `users` VALUES (17, 'Mason Booth', 'pylucel@mailinator.com', NULL, '$2y$10$umvLHHC9FRnJYwcMnoQcqO5XQVft9MSKSxwXlyQbkiCYO1v5ouL4m', NULL, '2025-04-09 11:34:23', '2025-04-09 11:34:23', NULL, '1', NULL);
INSERT INTO `users` VALUES (18, 'Priscilla Craft', 'toqi@mailinator.com', NULL, '$2y$10$K1Ge1Jkq22FWU86Fd3Q.geuxmARAJ8lzeIufNAVYOEMEaz5pBJaYK', NULL, '2025-04-26 05:25:08', '2025-04-26 05:25:08', NULL, '1', NULL);
INSERT INTO `users` VALUES (19, 'Belle Griffin', 'cynejarezi@mailinator.com', NULL, '$2y$10$RqNnwfomDg8F2e8BToHRaud7HD9benljE5TLgtGbvbk079WSHWfNW', NULL, '2025-04-30 08:15:39', '2025-04-30 08:15:39', NULL, '1', NULL);
INSERT INTO `users` VALUES (20, 'Kung Samrach', 'samrach168@gmail.com', NULL, '$2y$10$HxZRnzb3GVcUAD/lMVGU8uFRdmyerogy1pvnYcADCw.27xNO9xPmi', NULL, '2025-04-30 08:52:23', '2025-04-30 08:52:23', NULL, '1', 'kh');
INSERT INTO `users` VALUES (21, 'Bo Flowers', 'vuqipalefi@mailinator.com', NULL, '$2y$10$oEdL9mdPysU.2WziKNRKMOOUhmnHKqqTCkSDHsbUCGzCaFDNOwuAC', NULL, '2025-04-30 09:11:21', '2025-04-30 09:11:21', NULL, '1', 'es');
INSERT INTO `users` VALUES (22, 'Miranda Webb', 'tapyvi@mailinator.com', NULL, '$2y$10$HMEq2NVEVxye3Jw4853YTeGrFDXtIkh4dKpFWo6q6y5n.BOXx3NSa', NULL, '2025-04-30 09:13:25', '2025-04-30 09:13:25', NULL, '1', 'zh');
INSERT INTO `users` VALUES (23, 'Cathleen Macdonald', 'tanahofeti@mailinator.com', NULL, '$2y$10$OJZaq8PDbWTaPt6MUKrWsuC979HSH56NjdhdKm.1AP3jrT69bqX/O', NULL, '2025-04-30 09:31:40', '2025-04-30 09:31:40', NULL, '1', NULL);
INSERT INTO `users` VALUES (24, 'Charde Benjamin', 'myfukyduwa@mailinator.com', NULL, '$2y$10$/rhbR.EKXHkczIIVBP46FOhCzhADVP0ICBPe2/mwF6ZyHl7he/hUK', NULL, '2025-04-30 11:58:38', '2025-04-30 11:58:38', NULL, '1', NULL);
INSERT INTO `users` VALUES (25, 'Indigo Wilkerson', 'kevifudug@mailinator.com', NULL, '$2y$10$RE6I7H3.I.N43OqHo.hqceC1y79WYUrvnVh3kE1gl5fx4knJ3N/xa', NULL, '2025-05-09 12:57:48', '2025-05-09 12:57:48', NULL, '1', 'en');
INSERT INTO `users` VALUES (26, 'Samrach', 'samrach08800@gmail.com', NULL, '$2y$10$nlQMokibv2VaP6baC.5ITul5PBvkIQptfZpU7txVyWgjEABLMjUCW', NULL, '2025-05-09 13:23:14', '2025-05-09 13:23:14', NULL, '1', NULL);

SET FOREIGN_KEY_CHECKS = 1;
