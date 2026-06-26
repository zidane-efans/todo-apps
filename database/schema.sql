CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `role` enum('User','Admin') DEFAULT 'User',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Active',
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `priority` varchar(50) DEFAULT 'Medium',
  `deadline` date DEFAULT NULL,
  `progress` int(11) DEFAULT 0,
  `status` enum('To Do', 'In Progress', 'Review', 'Completed') DEFAULT 'To Do',
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`created_by`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('Unread', 'Read') DEFAULT 'Unread',
  `type` enum('Success', 'Warning', 'Critical', 'Info') DEFAULT 'Info',
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert a default admin and user for testing
INSERT INTO `users` (`name`, `email`, `password`, `role`) VALUES
('Admin User', 'admin@taskflow.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin'), -- password is 'password'
('Demo User', 'user@taskflow.local', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'User');

-- Insert sample projects
INSERT INTO `projects` (`name`, `description`, `start_date`, `end_date`, `status`, `user_id`) VALUES
('Website Redesign', 'Redesigning the corporate website', '2023-10-01', '2023-12-31', 'Active', 2),
('Mobile App Launch', 'Launch iOS and Android apps', '2023-11-01', '2024-02-28', 'Active', 2);

-- Insert sample tasks
INSERT INTO `tasks` (`project_id`, `title`, `description`, `priority`, `deadline`, `progress`, `status`, `created_by`) VALUES
(1, 'Create wireframes', 'Design initial wireframes', 'High', '2023-10-15', 100, 'Completed', 2),
(1, 'Develop homepage', 'Implement homepage UI', 'Medium', '2023-11-15', 50, 'In Progress', 2),
(1, 'Write copy', 'Draft website copy', 'Low', '2023-10-30', 0, 'To Do', 2),
(2, 'App Store Optimization', 'Optimize keywords', 'Medium', '2023-12-15', 0, 'To Do', 2);