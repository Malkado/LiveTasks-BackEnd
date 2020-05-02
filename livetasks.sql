-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 02-Maio-2020 às 15:48
-- Versão do servidor: 10.1.36-MariaDB
-- versão do PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `livetasks`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `task`
--

CREATE TABLE `task` (
  `Id_Task` int(11) NOT NULL,
  `Name_Task` varchar(100) NOT NULL,
  `Description_Task` varchar(256) NOT NULL,
  `Status_Task` int(11) NOT NULL,
  `Id_Task_Type` int(11) NOT NULL,
  `Id_User` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `task_type`
--

CREATE TABLE `task_type` (
  `Id_Task_Type` int(11) NOT NULL,
  `Name_Task_Type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE `user` (
  `Id_User` int(11) NOT NULL,
  `Name_User` varchar(256) NOT NULL,
  `Email_User` varchar(256) NOT NULL,
  `Login_User` varchar(256) NOT NULL,
  `Pass_User` varchar(30) NOT NULL,
  `Token_User` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`Id_User`, `Name_User`, `Email_User`, `Login_User`, `Pass_User`, `Token_User`) VALUES
(3, 'Luiz', 'Luiz@email.com', 'Luiz123', '12345', NULL),
(4, 'Luiz2', 'Luiz3@email.com', 'Luiz112323', '1234445', NULL),
(6, 'Luiz232', 'Lui23z3@email.com', 'Luiz23112323', '52de44b19fb83a0eac135023fc744c', NULL),
(9, 'Luiz', 'Lui2z3@email.com', 'Luiz4', '52de44b19fb83a0eac135023fc744c', NULL),
(10, 'Luiz', '23@email.com', '23', '52de44b19fb83a0eac135023fc744c', NULL),
(12, 'Luiz', '21@email.com', 'luiz', 'c81e728d9d4c2f636f067f89cc1486', NULL),
(14, 'Luiz', '21@email.com', 'luiz234dfsdf', 'c81e728d9d4c2f636f067f89cc1486', NULL),
(16, 'Luiz', '21@email.com', 'carlos23', 'c81e728d9d4c2f636f067f89cc1486', NULL),
(18, 'Luiz', '21@email.com', 'luh12', 'c81e728d9d4c2f636f067f89cc1486', NULL),
(19, 'Luiz', '56@email.com', 'luh14', 'c81e728d9d4c2f636f067f89cc1486', NULL),
(20, 'Luiz', '536@email.com', 'luh144', 'c81e728d9d4c2f636f067f89cc1486', NULL),
(21, 'Luiz', '2536@email.com', 'luh1244', 'c81e728d9d4c2f636f067f89cc1486', NULL),
(22, 'Luiz', '226@email.com', 'luh1245', '827ccb0eea8a706c4c34a16891f84e', NULL),
(23, 'Luiz', '2345@email.com', 'lanny12', '$1$JtVPPTlW$q4jMrMmMq8SkjTfWxl', NULL),
(24, 'Luiz', '23145@email.com', 'lanny', '$1$a9Pdl7YW$RAYrlkzJ9Phsol3YyQ', NULL),
(25, 'Luiz', '2lanny@email.com', 'lanny1', 'MTIz', 'c393b2b19a0390037f571778065016');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`Id_Task`),
  ADD KEY `Id_Task_Type` (`Id_Task_Type`),
  ADD KEY `Id_User` (`Id_User`);

--
-- Indexes for table `task_type`
--
ALTER TABLE `task_type`
  ADD PRIMARY KEY (`Id_Task_Type`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id_User`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `Id_Task` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `task_type`
--
ALTER TABLE `task_type`
  MODIFY `Id_Task_Type` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `Id_User` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`Id_Task_Type`) REFERENCES `task_type` (`Id_Task_Type`),
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`Id_User`) REFERENCES `user` (`Id_User`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
