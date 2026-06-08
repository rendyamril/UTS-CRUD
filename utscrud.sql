CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` enum('Admin','User') NOT NULL,
  `dibuat_pada` timestamp DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO `users` (`username`, `password`, `status`) VALUES
('admin', '12345', 'Admin'),
('user1', '12345', 'User');
