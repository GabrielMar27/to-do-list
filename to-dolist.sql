-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2023 at 10:52 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `to-dolist`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `idTaskCat` int(11) NOT NULL,
  `numeCategorie` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`idTaskCat`, `numeCategorie`) VALUES
(1, 'Personal'),
(2, 'Lucru'),
(3, 'Scoala'),
(4, 'Alta');

-- --------------------------------------------------------

--
-- Table structure for table `subtask`
--

CREATE TABLE `subtask` (
  `idSubtask` int(11) NOT NULL,
  `textSubtask` varchar(20) NOT NULL,
  `id_task` int(11) DEFAULT NULL,
  `stareSub` varchar(11) NOT NULL DEFAULT 'Ne Terminat'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subtask`
--

INSERT INTO `subtask` (`idSubtask`, `textSubtask`, `id_task`, `stareSub`) VALUES
(83, 'da', 135, 'Terminat'),
(84, '1', 136, 'Terminat'),
(85, '2', 136, 'Ne Terminat'),
(86, '3', 136, 'Ne Terminat'),
(87, '4', 136, 'Ne Terminat');

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE `task` (
  `id_task` int(11) NOT NULL,
  `titlu_task` varchar(50) NOT NULL DEFAULT 'Nume task',
  `descriere_task` varchar(255) NOT NULL,
  `data_creare` date NOT NULL DEFAULT current_timestamp(),
  `data_sfarsit` date NOT NULL,
  `stare` varchar(255) NOT NULL DEFAULT 'NeTerminat ',
  `email` varchar(50) NOT NULL,
  `idTaskCat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id_task`, `titlu_task`, `descriere_task`, `data_creare`, `data_sfarsit`, `stare`, `email`, `idTaskCat`) VALUES
(129, 'da', 'da', '2023-06-14', '2023-06-30', 'NeTerminat', 'GabrielMarin@gmail.com', 1),
(133, 'da', 'da', '2023-06-15', '2023-06-30', 'NeTerminat', '123@gmail.com', 1),
(135, 'da', 'da', '2023-06-15', '2023-06-30', 'Terminat', 'GabiMarin@gmail.com', 1),
(136, 'da', 'dada', '2023-06-15', '2023-06-22', 'NeTerminat', 'GabiMarin@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nume` varchar(50) NOT NULL,
  `prenume` varchar(50) NOT NULL,
  `tip_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`, `nume`, `prenume`, `tip_user`) VALUES
('123@gmail.com', '202cb962ac59075b964b07152d234b70', '1', '1', ''),
('321@gmail.com', 'caf1a3dfb505ffed0d024130f58c5cfa', '321', '321', ''),
('aCioar@gmail.com', '202cb962ac59075b964b07152d234b70', 'alex', 'ciornei', ''),
('da@gmail.com', '5ca2aa845c8cd5ace6b016841f100d82', 'da', 'da', ''),
('GabiMarin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'gabi', 'marin', ''),
('GabrielMarin@gmail.com', '202cb962ac59075b964b07152d234b70', 'gabriel', 'marin', ''),
('vasiEmil@gmail.com', '202cb962ac59075b964b07152d234b70', 'vasi', 'emil', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`idTaskCat`);

--
-- Indexes for table `subtask`
--
ALTER TABLE `subtask`
  ADD PRIMARY KEY (`idSubtask`),
  ADD KEY `subtask_taks_FK` (`id_task`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id_task`),
  ADD KEY `taks_user_FK` (`email`),
  ADD KEY `taks_categorie0_FK` (`idTaskCat`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idTaskCat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subtask`
--
ALTER TABLE `subtask`
  MODIFY `idSubtask` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id_task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=137;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `subtask`
--
ALTER TABLE `subtask`
  ADD CONSTRAINT `subtask_taks_FK` FOREIGN KEY (`id_task`) REFERENCES `task` (`id_task`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `taks_categorie0_FK` FOREIGN KEY (`idTaskCat`) REFERENCES `categorie` (`idTaskCat`),
  ADD CONSTRAINT `taks_user_FK` FOREIGN KEY (`email`) REFERENCES `user` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
