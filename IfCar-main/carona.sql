-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 05-Ago-2026 às 22:41
-- Versão do servidor: 8.0.29
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ifcar-main`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carona`
--

CREATE TABLE `carona` (
  `ID` int NOT NULL,
  `Nomeusuario` varchar(50) NOT NULL,
  `Enderecosaida` text NOT NULL,
  `Enderecodestino` text NOT NULL,
  `Bairros` varchar(500) NOT NULL,
  `Numerocarona` char(4) NOT NULL,
  `Caronatime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `carona`
--

INSERT INTO `carona` (`ID`, `Nomeusuario`, `Enderecosaida`, `Enderecodestino`, `Bairros`, `Numerocarona`, `Caronatime`) VALUES
(1, 'GIOVANA DECHAMP SEDLAK', 'cem casas', 'bfdh', '', '2', '2026-08-27 22:31:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carona`
--
ALTER TABLE `carona`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carona`
--
ALTER TABLE `carona`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
