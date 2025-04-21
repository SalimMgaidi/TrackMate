-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 11:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trackmate`
--

-- --------------------------------------------------------

--
-- Table structure for table `bulletins`
--

CREATE TABLE `bulletins` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) NOT NULL,
  `moyenne_generale` float(5,2) NOT NULL,
  `semestre` varchar(10) NOT NULL,
  `date_generation` date NOT NULL DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bulletins`
--

INSERT INTO `bulletins` (`id`, `etudiant_id`, `moyenne_generale`, `semestre`, `date_generation`) VALUES
(21, 34, 17.10, 'S1', '2023-01-15'),
(22, 35, 16.40, 'S1', '2023-01-15'),
(23, 36, 17.60, 'S1', '2023-01-15'),
(24, 37, 17.10, 'S1', '2023-01-15'),
(25, 38, 17.30, 'S1', '2023-01-15'),
(26, 39, 17.60, 'S1', '2023-01-15'),
(27, 40, 16.70, 'S1', '2023-01-15'),
(28, 41, 16.90, 'S1', '2023-01-15'),
(29, 42, 18.40, 'S1', '2023-01-15'),
(30, 43, 18.00, 'S1', '2023-01-15'),
(31, 34, 16.50, 'S2', '2023-06-20'),
(32, 35, 17.00, 'S2', '2023-06-20'),
(33, 36, 17.30, 'S2', '2023-06-20'),
(34, 37, 17.60, 'S2', '2023-06-20'),
(35, 38, 16.90, 'S2', '2023-06-20'),
(36, 39, 17.80, 'S2', '2023-06-20'),
(37, 40, 17.40, 'S2', '2023-06-20'),
(38, 41, 17.10, 'S2', '2023-06-20'),
(39, 42, 18.70, 'S2', '2023-06-20'),
(40, 43, 18.20, 'S2', '2023-06-20');

-- --------------------------------------------------------

--
-- Table structure for table `emploi_temps`
--

CREATE TABLE `emploi_temps` (
  `id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `filiere_id` int(11) NOT NULL,
  `jour` enum('Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi') NOT NULL,
  `heure_debut` time NOT NULL,
  `heure_fin` time NOT NULL,
  `salle` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `emploi_temps`
--

INSERT INTO `emploi_temps` (`id`, `matiere_id`, `filiere_id`, `jour`, `heure_debut`, `heure_fin`, `salle`) VALUES
(26, 1, 2, 'Lundi', '08:30:00', '10:30:00', 'CS101'),
(27, 2, 2, 'Lundi', '10:45:00', '12:45:00', 'CS102'),
(28, 3, 2, 'Mercredi', '08:30:00', '10:30:00', 'CS103'),
(29, 4, 2, 'Mercredi', '10:45:00', '12:45:00', 'CS104'),
(30, 5, 2, 'Vendredi', '08:30:00', '10:30:00', 'CS105'),
(31, 6, 3, 'Mardi', '08:30:00', '10:30:00', 'FIN201'),
(32, 7, 3, 'Mardi', '10:45:00', '12:45:00', 'FIN202'),
(33, 8, 3, 'Jeudi', '08:30:00', '10:30:00', 'FIN203'),
(34, 9, 3, 'Jeudi', '10:45:00', '12:45:00', 'FIN204'),
(35, 10, 1, 'Lundi', '13:30:00', '15:30:00', 'MGMT301'),
(36, 11, 1, 'Mercredi', '13:30:00', '15:30:00', 'MGMT302'),
(37, 12, 1, 'Vendredi', '13:30:00', '15:30:00', 'MGMT303'),
(38, 13, 1, 'Vendredi', '15:45:00', '17:45:00', 'MGMT304'),
(39, 14, 5, 'Mardi', '13:30:00', '15:30:00', 'MKT401'),
(40, 15, 5, 'Jeudi', '13:30:00', '15:30:00', 'MKT402'),
(41, 16, 5, 'Jeudi', '15:45:00', '17:45:00', 'MKT403'),
(42, 17, 6, 'Lundi', '08:30:00', '10:30:00', 'CYB501'),
(43, 18, 6, 'Mercredi', '08:30:00', '10:30:00', 'CYB502'),
(44, 19, 6, 'Vendredi', '08:30:00', '10:30:00', 'CYB503'),
(45, 20, 7, 'Mardi', '08:30:00', '10:30:00', 'ECON601'),
(46, 21, 7, 'Jeudi', '08:30:00', '10:30:00', 'ECON602'),
(47, 22, 7, 'Samedi', '08:30:00', '10:30:00', 'ECON603'),
(48, 23, 2, 'Vendredi', '13:30:00', '15:30:00', 'AUD1'),
(49, 24, 3, 'Vendredi', '13:30:00', '15:30:00', 'AUD2'),
(50, 25, 7, 'Vendredi', '13:30:00', '15:30:00', 'AUD3');

-- --------------------------------------------------------

--
-- Table structure for table `etudiant`
--

CREATE TABLE `etudiant` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_naissance` date NOT NULL,
  `filiere_id` int(11) NOT NULL,
  `cin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `etudiant`
--

INSERT INTO `etudiant` (`id`, `user_id`, `date_naissance`, `filiere_id`, `cin`) VALUES
(34, 3, '2000-05-15', 1, 25032102),
(35, 4, '2001-03-22', 1, 20035690),
(36, 5, '1999-11-30', 2, 24245896),
(37, 6, '2000-07-18', 6, 32321052),
(38, 7, '2001-01-25', 3, 58589320),
(39, 8, '2000-09-12', 3, 42150001),
(40, 9, '1999-12-05', 7, 36236253),
(41, 10, '2000-08-20', 7, 98812580),
(42, 11, '2001-04-15', 5, 96962512),
(43, 12, '2000-02-28', 5, 52358931);

-- --------------------------------------------------------

--
-- Table structure for table `filieres`
--

CREATE TABLE `filieres` (
  `id` int(11) NOT NULL,
  `nom_filiere` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `filieres`
--

INSERT INTO `filieres` (`id`, `nom_filiere`) VALUES
(2, 'Computer Science'),
(6, 'Cyber Security'),
(7, 'Economics'),
(3, 'Finance'),
(1, 'Managment'),
(5, 'Marketing');

-- --------------------------------------------------------

--
-- Table structure for table `matieres`
--

CREATE TABLE `matieres` (
  `id` int(11) NOT NULL,
  `nom_matiere` varchar(100) NOT NULL,
  `coefficient` float(5,2) NOT NULL,
  `credit` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `matieres`
--

INSERT INTO `matieres` (`id`, `nom_matiere`, `coefficient`, `credit`) VALUES
(1, 'reseau', 2.00, 0),
(2, 'Database Systems', 3.00, 4),
(3, 'Programming Fundamentals', 2.50, 3),
(4, 'Algorithms', 3.00, 4),
(5, 'Computer Architecture', 2.50, 3),
(6, 'Software Engineering', 3.00, 4),
(7, 'Financial Accounting', 3.00, 4),
(8, 'Corporate Finance', 3.00, 4),
(9, 'Investment Analysis', 2.50, 3),
(10, 'Risk Management', 2.50, 3),
(11, 'Financial Markets', 2.00, 3),
(12, 'Organizational Behavior', 2.50, 3),
(13, 'Project Management', 3.00, 4),
(14, 'Strategic Management', 3.00, 4),
(15, 'Operations Management', 2.50, 3),
(16, 'Leadership', 2.00, 3),
(17, 'Marketing Principles', 2.50, 3),
(18, 'Consumer Behavior', 2.50, 3),
(19, 'Digital Marketing', 3.00, 4),
(20, 'Market Research', 2.50, 3),
(21, 'Brand Management', 2.00, 3),
(22, 'Network Security', 3.00, 4),
(23, 'Ethical Hacking', 3.00, 4),
(24, 'Cryptography', 3.00, 4),
(25, 'Cyber Laws', 2.00, 3),
(26, 'Digital Forensics', 2.50, 3),
(27, 'Microeconomics', 3.00, 4),
(28, 'Macroeconomics', 3.00, 4),
(29, 'Econometrics', 3.00, 4),
(30, 'International Economics', 2.50, 3),
(31, 'Development Economics', 2.00, 3);

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `etudiant_id` int(11) NOT NULL,
  `matiere_id` int(11) NOT NULL,
  `note` float(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`id`, `etudiant_id`, `matiere_id`, `note`) VALUES
(31, 34, 1, 17.10),
(32, 34, 2, 15.60),
(33, 36, 3, 18.50),
(34, 38, 1, 16.40),
(35, 35, 4, 17.70),
(36, 36, 5, 15.20),
(37, 40, 6, 18.20),
(38, 41, 7, 16.90),
(39, 39, 26, 17.80),
(40, 40, 6, 15.70),
(41, 41, 8, 18.40),
(42, 40, 9, 17.10),
(43, 36, 11, 17.60),
(44, 35, 12, 15.90),
(45, 35, 27, 18.30),
(46, 36, 11, 18.80),
(47, 38, 13, 16.50),
(48, 36, 14, 17.40),
(49, 38, 16, 16.70),
(50, 37, 17, 15.20),
(51, 37, 18, 18.10),
(52, 38, 21, 17.80),
(53, 38, 22, 16.30),
(54, 38, 23, 16.80),
(55, 39, 26, 19.00),
(56, 39, 27, 17.70),
(57, 39, 28, 18.40),
(58, 40, 26, 17.50),
(59, 40, 28, 18.60),
(60, 40, 29, 17.90);

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role_id` tinyint(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `sexe` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `email`, `mot_de_passe`, `role_id`, `created_at`, `sexe`) VALUES
(1, 'salim magidi', 'salimmgaidi@gmail.com', 'salim750', 0, '2025-04-15 12:27:54', 'homme'),
(2, 'salim admin', 'salimadmin@gmail.com', 'salim750', 1, '2025-04-15 12:46:45', 'homme'),
(3, 'admin principal', 'admin1@school.com', '$2y$10$HvZ1ZJYq3lX9eKkQYVrBZuYJz9cLmNfLkZwXr2d3v4w5x6y7A8B9C', 1, '2025-04-20 14:15:39', 'homme'),
(4, 'Admin Secondaire', 'admin2@school.com', '$2y$10$IjKlMnOpQrStUvWxYz0123e4r5t6y7u8v9w0x1y2z3a4b5c6d7e8f', 1, '2025-04-20 14:15:39', 'femme'),
(5, 'adem hamoudi', 'adem.hamoudi@student.com', '$2y$10$AbCdEfGhIjKlMnOpQrStUvWxYz0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'homme'),
(6, 'Meryem jameli', 'meryem.jameli@student.com', '$2y$10$BcDeFgHiJkLmNoPqRsTuVwXyZ0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'femme'),
(7, 'mourad khalil', 'mourad khalil@student.com', '$2y$10$CdEfGhIjKlMnOpQrStUvWxYz0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'homme'),
(8, 'samira ben said', 'samirabensaid5@student.com', '$2y$10$DeFgHiJkLmNoPqRsTuVwXyZ0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'femme'),
(9, 'ali nafati', 'ali.nafati22@student.com', '$2y$10$EfGhIjKlMnOpQrStUvWxYz0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'homme'),
(10, 'nourhen sadki', 'nourhen25sadaki@student.com', '$2y$10$FgHiJkLmNoPqRsTuVwXyZ0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'femme'),
(11, 'kamel mgaidi', 'kamel3.mgaidi@student.com', '$2y$10$GhIjKlMnOpQrStUvWxYz0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'homme'),
(12, 'emna masmoudi', 'emnamasmoudi20@student.com', '$2y$10$HiJkLmNoPqRsTuVwXyZ0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'femme'),
(13, 'ahmed dalel', 'ahmed75dalel@student.com', '$2y$10$IjKlMnOpQrStUvWxYz0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'homme'),
(14, 'aya alili', 'alili2aya@student.com', '$2y$10$JkLmNoPqRsTuVwXyZ0123e4r5t6y7u8v9w0x1y2z3a4b5', 0, '2025-04-20 14:15:39', 'femme');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulletins`
--
ALTER TABLE `bulletins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiant_id` (`etudiant_id`);

--
-- Indexes for table `emploi_temps`
--
ALTER TABLE `emploi_temps`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matiere_id` (`matiere_id`),
  ADD KEY `filiere_id` (`filiere_id`);

--
-- Indexes for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `filiere_id` (`filiere_id`);

--
-- Indexes for table `filieres`
--
ALTER TABLE `filieres`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nom_filiere` (`nom_filiere`);

--
-- Indexes for table `matieres`
--
ALTER TABLE `matieres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `etudiant_id` (`etudiant_id`),
  ADD KEY `matiere_id` (`matiere_id`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulletins`
--
ALTER TABLE `bulletins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `emploi_temps`
--
ALTER TABLE `emploi_temps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `etudiant`
--
ALTER TABLE `etudiant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `filieres`
--
ALTER TABLE `filieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `matieres`
--
ALTER TABLE `matieres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bulletins`
--
ALTER TABLE `bulletins`
  ADD CONSTRAINT `bulletins_ibfk_1` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiant` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `emploi_temps`
--
ALTER TABLE `emploi_temps`
  ADD CONSTRAINT `emploi_temps_ibfk_1` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `emploi_temps_ibfk_2` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`);

--
-- Constraints for table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `etudiant_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `etudiant_ibfk_2` FOREIGN KEY (`filiere_id`) REFERENCES `filieres` (`id`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`etudiant_id`) REFERENCES `etudiant` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`matiere_id`) REFERENCES `matieres` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
