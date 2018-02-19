-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 18, 2018 at 11:32 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `SGVC`
--

-- --------------------------------------------------------

--
-- Table structure for table `itens`
--

CREATE TABLE `itens` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) NOT NULL,
  `preco` varchar(45) NOT NULL,
  `quantidade` varchar(45) DEFAULT NULL,
  `flag` tinyint(1) NOT NULL DEFAULT '1',
  `color` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `usuario` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `transacoes`
--

CREATE TABLE `transacoes` (
  `id` int(11) NOT NULL,
  `itens_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `hora` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `transacoes`
--
DELIMITER $$
CREATE TRIGGER `remove_itensqtd` AFTER INSERT ON `transacoes` FOR EACH ROW BEGIN
	UPDATE itens SET itens.quantidade = itens.quantidade - NEW.quantidade WHERE itens.id = NEW.itens_id;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `itens`
--
ALTER TABLE `itens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transacoes`
--
ALTER TABLE `transacoes`
  ADD PRIMARY KEY (`id`,`itens_id`,`staff_id`),
  ADD KEY `fk_transacoes_itens_idx` (`itens_id`),
  ADD KEY `fk_transacoes_staff1_idx` (`staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `itens`
--
ALTER TABLE `itens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `transacoes`
--
ALTER TABLE `transacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `transacoes`
--
ALTER TABLE `transacoes`
  ADD CONSTRAINT `fk_transacoes_itens` FOREIGN KEY (`itens_id`) REFERENCES `itens` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_transacoes_staff1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
