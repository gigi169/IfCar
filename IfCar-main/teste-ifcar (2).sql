-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Set-2026 às 22:46
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
-- Banco de dados: `teste-ifcar`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `carona`
--

CREATE TABLE `caronas` (
  `ID` int NOT NULL,
  `IDusuario` int NOT NULL,
  `Enderecosaida` varchar(100) NOT NULL,
  `Enderecodestino` varchar(100) NOT NULL,
  `Numeropassageiros` tinyint unsigned NOT NULL,
  `Data` date NOT NULL,
  `Hora` time NOT NULL,
  `categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuarios` (
  `ID` int NOT NULL,
  `Nomeusuario` varchar(50) NOT NULL,
  `Emailusuario` varchar(255) NOT NULL,
  `Telefoneusuario` varchar(20) NOT NULL,
  `Senhausuario` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Estrutura da tabela `solicitacoes`
--

CREATE TABLE `solicitacoes` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `IDcarona` int NOT NULL,
  `IDusuario` int NOT NULL,
  `Status` varchar(20) NOT NULL DEFAULT 'pendente',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `solicitacao_unica` (`IDcarona`,`IDusuario`),
  KEY `IDusuario` (`IDusuario`),
  CONSTRAINT `solicitacoes_caronas_fk` FOREIGN KEY (`IDcarona`) REFERENCES `caronas` (`ID`),
  CONSTRAINT `solicitacoes_usuarios_fk` FOREIGN KEY (`IDusuario`) REFERENCES `usuarios` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuarios` (`ID`, `Nomeusuario`, `Emailusuario`, `Telefoneusuario`, `Senhausuario`) VALUES
(5, 'GIOVANA DECHAMP SEDLAK', '20241tbor0020038@estudantes.ifpr.edu.br', '42999438758', '202cb962ac59075b964b07152d234b70');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `carona`
--
ALTER TABLE `caronas`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDusuario` (`IDusuario`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carona`
--
ALTER TABLE `caronas`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `carona`
--
ALTER TABLE `caronas`
  ADD CONSTRAINT `caronas_usuarios_fk` FOREIGN KEY (`IDusuario`) REFERENCES `usuarios` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
