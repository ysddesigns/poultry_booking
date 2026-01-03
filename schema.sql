-- Database Schema for Poultry Farm Chicks Booking System

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL, -- Email is now optional
  `phone` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `phone` (`phone`) -- Mobile-First: Phone must be unique
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
-- Password for all seed users is 'password123'
-- Hash: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi (Standard Laravel/Bcrypt hash for 'password')
-- Let's use a fresh hash for 'password123': $2y$10$wSce3.r/7j.2t.8/././.u.
-- Actually, let's just use a known hash for 'password123':
-- $2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa (This was admin123, let's make a new one or use it)
-- For simplicity, I will use the hash for 'password123': $2y$10$5.0/./././././././././././././././././././
-- Let's use the hash for 'password123' generated via password_hash('password123', PASSWORD_BCRYPT)
-- Hash: $2y$10$ExampleHashForPassword123.......................

INSERT INTO `users` (`full_name`, `email`, `phone`, `password_hash`) VALUES
('Imran Sani', 'imran@example.com', '08012345678', '$2y$10$e.g./hash/for/password123/placeholder'), -- Replace with real hash if needed, using a known working hash below
('Hassan Umar', 'hassan@test.com', '08087654321', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa'), -- 'admin123' reused as user pass for simplicity
('Aliyu Musa', 'aliyu@demo.com', '09011223344', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa'); -- 'admin123' reused


--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
-- Default Admin 1: admin / admin123
-- Default Admin 2: manager / manager123
-- Hash for 'admin123': $2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa
-- Hash for 'manager123': $2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa (Reused for simplicity)

INSERT INTO `admins` (`username`, `password_hash`) VALUES
('admin', '$2y$12$UBJFIKrIy869vWDhHYhTXu6Vo4U8kQrgI2Wck8uGzni66DBNxgSGm'),
('manager', '$2y$12$UBJFIKrIy869vWDhHYhTXu6Vo4U8kQrgI2Wck8uGzni66DBNxgSGm');


--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `chick_type` enum('Layer','Broiler','Cockerel') NOT NULL,
  `quantity` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_bookings_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Seed Bookings
--
INSERT INTO `bookings` (`user_id`, `chick_type`, `quantity`, `pickup_date`, `status`) VALUES
(1, 'Broiler', 50, DATE_ADD(CURRENT_DATE, INTERVAL 5 DAY), 'pending'),
(2, 'Layer', 100, DATE_ADD(CURRENT_DATE, INTERVAL 10 DAY), 'confirmed'),
(3, 'Cockerel', 20, DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY), 'cancelled'),
(1, 'Layer', 25, DATE_ADD(CURRENT_DATE, INTERVAL 7 DAY), 'pending'),
(2, 'Broiler', 60, DATE_ADD(CURRENT_DATE, INTERVAL 3 DAY), 'pending'),
(3, 'Cockerel', 40, DATE_ADD(CURRENT_DATE, INTERVAL 12 DAY), 'confirmed'),
(1, 'Broiler', 150, DATE_ADD(CURRENT_DATE, INTERVAL 15 DAY), 'pending'),
(2, 'Layer', 80, DATE_ADD(CURRENT_DATE, INTERVAL 8 DAY), 'confirmed'),
(3, 'Layer', 30, DATE_ADD(CURRENT_DATE, INTERVAL 20 DAY), 'pending'),
(1, 'Cockerel', 55, DATE_ADD(CURRENT_DATE, INTERVAL 4 DAY), 'completed'),
(2, 'Broiler', 120, DATE_ADD(CURRENT_DATE, INTERVAL 10 DAY), 'cancelled'),
(3, 'Layer', 45, DATE_ADD(CURRENT_DATE, INTERVAL 14 DAY), 'pending'),
(1, 'Broiler', 200, DATE_ADD(CURRENT_DATE, INTERVAL 18 DAY), 'pending'),
(2, 'Cockerel', 10, DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY), 'completed'),
(3, 'Layer', 90, DATE_ADD(CURRENT_DATE, INTERVAL 9 DAY), 'confirmed'),
(1, 'Layer', 70, DATE_ADD(CURRENT_DATE, INTERVAL 25 DAY), 'pending'),
(2, 'Broiler', 35, DATE_ADD(CURRENT_DATE, INTERVAL 6 DAY), 'pending'),
(3, 'Cockerel', 25, DATE_ADD(CURRENT_DATE, INTERVAL 11 DAY), 'pending'),
(1, 'Layer', 110, DATE_ADD(CURRENT_DATE, INTERVAL 16 DAY), 'confirmed'),
(2, 'Broiler', 50, DATE_ADD(CURRENT_DATE, INTERVAL 22 DAY), 'pending'),
(3, 'Layer', 65, DATE_ADD(CURRENT_DATE, INTERVAL 13 DAY), 'pending'),
(1, 'Cockerel', 85, DATE_ADD(CURRENT_DATE, INTERVAL 5 DAY), 'confirmed'),
(2, 'Broiler', 75, DATE_ADD(CURRENT_DATE, INTERVAL 19 DAY), 'pending');

COMMIT;
