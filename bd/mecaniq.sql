-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 25-Nov-2026 às 11:42
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mecaniq`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `oficinas`
--

CREATE TABLE `oficinas` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `telefone` int(9) NOT NULL,
  `dias_disponiveis` varchar(50) NOT NULL,
  `hora_abertura` time NOT NULL DEFAULT '09:00:00',
  `hora_fecho` time NOT NULL DEFAULT '18:00:00',
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `oficinas`
--

INSERT INTO `oficinas` (`id`, `name`, `address`, `mail`, `telefone`, `dias_disponiveis`, `hora_abertura`, `hora_fecho`, `pass`) VALUES
(1, 'Speed Motors', 'Rua das Corridas', 'teste@gmail.com', 0, '', '09:00:00', '18:00:00', 'wwdd'),
(2, 'jdifosoid', 'posdkfposkposk', 'owkdjej@gmail.com', 0, '', '09:00:00', '18:00:00', 'pljk'),
(3, 'muro', 'rua dos postes', 'asioduh@gmail.com', 0, '', '09:00:00', '18:00:00', '12345'),
(4, 'Admin', 'Rua dos Admin', 'naosei@gmail.com', 0, '', '09:00:00', '18:00:00', '@dm1n_2026!'),
(5, 'Diogogongas', 'Nogueira', 'dg@gmail.com', 0, '', '09:00:00', '18:00:00', 'wwdd'),
(6, 'teste2', 'nao sei o que colocar 2', 'testes@gmail.com', 0, '', '09:00:00', '18:00:00', '$2y$10$m2YEBQlqnV3ni8CjEIptUOuBf5FKsJwTh'),
(7, 'nao sei 3', 'nao sei o que colocar 3', 'teste3@gmail.com', 0, '', '09:00:00', '18:00:00', '$2y$10$fWAGzsUv3Ebqykc1exFpJu5cHHJj9eaNl'),
(8, 'nao sei 4', 'nao sei o que colocar 4', 'teste4@gmail.com', 0, '', '09:00:00', '18:00:00', '$2y$10$9YZswWv.RRl8athxrkcEfuQfx1tmLHpdCxmeCNTnjdkYwLBNfPxra'),
(9, 'Motors Speed', 'Rechousa', 'rechousa@gmail.com', 917398285, 'seg,ter,qua,qui,sex,sab', '09:00:00', '18:00:00', '$2y$10$adITkcLWqSREMu6Ro1q8a.LG6AxBEb/c6eIOO9rAjiYIpjUqlNHqi');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `oficinas`
--
ALTER TABLE `oficinas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `oficinas`
--
ALTER TABLE `oficinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
