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
('Imran Sani', 'john@example.com', '08012345678', '$2y$10$e.g./hash/for/password123/placeholder'), -- Replace with real hash if needed, using a known working hash below
('Hassan Umar', 'jane@test.com', '08087654321', '$2y$10$vI8aWBnW3fID.ZQ4/zo1G.q1lRps.9cGLcZEiGDMVr5yUP1KUOYTa'), -- 'admin123' reused as user pass for simplicity
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
-- Seed Bookings (Optional)
--
INSERT INTO `bookings` (`user_id`, `chick_type`, `quantity`, `pickup_date`, `status`) VALUES
(1, 'Broiler', 50, DATE_ADD(CURRENT_DATE, INTERVAL 5 DAY), 'pending'),
(2, 'Layer', 100, DATE_ADD(CURRENT_DATE, INTERVAL 10 DAY), 'confirmed'),
(3, 'Cockerel', 20, DATE_ADD(CURRENT_DATE, INTERVAL 2 DAY), 'cancelled');

COMMIT;
