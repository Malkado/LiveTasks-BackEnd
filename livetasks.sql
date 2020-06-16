-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 17-Jun-2020 às 01:15
-- Versão do servidor: 10.4.11-MariaDB
-- versão do PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `livetasks`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `task`
--

CREATE TABLE `task` (
  `Id_Task` int(11) NOT NULL,
  `Name_Task` varchar(100) NOT NULL,
  `Description_Task` varchar(256) NOT NULL,
  `Id_Task_Type` int(11) NOT NULL,
  `Id_User` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `task`
--

INSERT INTO `task` (`Id_Task`, `Name_Task`, `Description_Task`, `Id_Task_Type`, `Id_User`) VALUES
(2, 'Task atualizada com updateTask', 'Segunda task criada como teste do .', 2, 27),
(4, 'Segunda task', 'Segunda task criada como teste do .', 1, 27),
(5, 'Segunda task', 'Segunda task criada como teste do .', 1, 27),
(6, 'Segunda task', 'Segunda task criada como teste do .', 1, 27),
(7, 'Segunda task', 'Segunda task criada como teste do .', 1, 27),
(8, 'Segunda task', 'Segunda task criada como teste do .', 1, 27),
(9, 'Segunda task', 'Segunda task criada como teste do .', 1, 27),
(10, 'Segunda task', 'Segunda task criada como teste do .', 1, 27),
(11, 'primeira task', 'descrição da primeira task', 1, 28),
(12, 'segunda task', 'descrição da segunda task', 1, 28),
(13, 'segunda task', 'descrição da segunda task', 1, 28),
(16, 'Exemplo de atividade usando o update', 'descrição da segunda task', 1, 29),
(19, 'segunda task', 'descrição da segunda task', 1, 29),
(20, 'segunda task', 'descrição da segunda task', 1, 29),
(21, 'segunda task', 'descrição da segunda task', 1, 29),
(22, 'segunda task', 'descrição da segunda task', 1, 29),
(23, 'segunda task', 'descrição da segunda task', 1, 29),
(24, 'segunda task', 'descrição da segunda task', 1, 29),
(25, 'segunda task', 'descrição da segunda task', 1, 29),
(26, '1', '2', 1, 29),
(27, '28484hugfufu', 'ukyyvvgilgliygl', 1, 29);

-- --------------------------------------------------------

--
-- Estrutura da tabela `task_type`
--

CREATE TABLE `task_type` (
  `Id_Task_Type` int(11) NOT NULL,
  `Name_Task_Type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `task_type`
--

INSERT INTO `task_type` (`Id_Task_Type`, `Name_Task_Type`) VALUES
(1, 'Não iniciado'),
(2, 'Iniciado'),
(3, 'Impedimento'),
(4, 'Finalizado');

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
  `Token_User` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `user`
--

INSERT INTO `user` (`Id_User`, `Name_User`, `Email_User`, `Login_User`, `Pass_User`, `Token_User`) VALUES
(27, 'Luiz', 'malkado12@email.com', 'luiz1234567', 'OTM5ODE4MTU=', '374ae0b2e44881d96a206f994f8c5f18'),
(28, 'luiz henrique', 'email@gmail.com', 'malkado', 'MTIz', NULL),
(29, 'luiz henrique santos ', 'luizluiz@gmail.com', 'malkado1', 'MTIzNDU2Nw==', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`Id_Task`),
  ADD KEY `Id_Task_Type` (`Id_Task_Type`),
  ADD KEY `Id_User` (`Id_User`);

--
-- Índices para tabela `task_type`
--
ALTER TABLE `task_type`
  ADD PRIMARY KEY (`Id_Task_Type`);

--
-- Índices para tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`Id_User`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `task`
--
ALTER TABLE `task`
  MODIFY `Id_Task` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `task_type`
--
ALTER TABLE `task_type`
  MODIFY `Id_Task_Type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `Id_User` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Restrições para despejos de tabelas
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
