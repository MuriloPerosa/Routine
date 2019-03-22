-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 06-Jun-2017 às 00:19
-- Versão do servidor: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_routine`
--
CREATE DATABASE IF NOT EXISTS `db_routine` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_routine`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `locais`
--

CREATE TABLE `locais` (
  `codigoLocal` int(11) NOT NULL,
  `descricaoLocal` varchar(50) NOT NULL,
  `codigoUsuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `locais`
--

INSERT INTO `locais` (`codigoLocal`, `descricaoLocal`, `codigoUsuario`) VALUES
(12, 'Passo Fundo, RS', 2),
(15, 'Porto Alegre, RS', 2),
(19, 'UPF - Campus Casca', 2),
(22, 'Shopping Center', 3),
(23, 'Praça de Nova Bassano - RS', 3),
(25, 'UPF - Campus Principal', 5),
(26, 'Caxias do Sul, RS', 5),
(27, 'Casca, RS', 4),
(28, 'São Paulo, SP', 4),
(29, 'Restaurante Italiano', 4),
(30, 'Minha Casa', 6),
(31, 'Ginásio de Esportes de Nova Bassano, RS', 7),
(32, 'Casa do Pedrinho', 8),
(33, 'Casa de Shows - Passo Fundo', 9),
(34, 'Disney', 10),
(35, 'Orlando, Flórida - EUA', 10),
(36, 'Supermercado', 11),
(37, 'Praia de Copacabana - RJ', 12),
(38, 'Estádio Maracanã', 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tarefas`
--

CREATE TABLE `tarefas` (
  `codigoTarefa` int(11) NOT NULL,
  `descricaoTarefa` varchar(50) NOT NULL,
  `data` date NOT NULL,
  `codigoLocal` int(11) NOT NULL,
  `codigoUsuario` int(11) NOT NULL,
  `codigoTipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tarefas`
--

INSERT INTO `tarefas` (`codigoTarefa`, `descricaoTarefa`, `data`, `codigoLocal`, `codigoUsuario`, `codigoTipo`) VALUES
(3, 'Prova II', '2017-06-12', 19, 3, 14),
(4, 'Prova', '2017-06-09', 19, 3, 11),
(5, 'Passeio', '2017-09-18', 23, 3, 3),
(6, 'Viagem de Estudos', '2017-06-30', 25, 5, 17),
(7, 'Festa de Aniversário Surpresa para o Usuário 1', '2017-06-09', 12, 5, 7),
(8, 'Reunião com Investidores', '2017-06-09', 28, 4, 18),
(9, 'Encontro com Usuário 3', '2017-11-15', 29, 4, 10),
(10, 'Comprar Roupa', '2017-11-14', 22, 4, 6),
(11, 'Cortar o Cabelo', '2017-11-14', 12, 4, 19),
(12, 'Festa de Aniversário Surpresa para o Usuário 1', '2017-06-09', 12, 6, 7),
(13, 'Prova ', '2017-06-08', 19, 6, 12),
(14, 'ENEM 2017 ', '2017-12-05', 15, 6, 1),
(15, 'Assistir - Velozes e Furiosos 8', '2018-05-01', 22, 7, 4),
(16, 'Colocar a carne no forno - 11:00', '2017-06-07', 30, 7, 20),
(17, 'Jogar Futsal', '2017-06-20', 31, 7, 2),
(18, 'Aula', '2017-07-06', 28, 8, 9),
(19, 'Visitar o Pedrinho', '2017-07-03', 32, 8, 17),
(20, 'Apresentar Trabalho', '2017-06-20', 25, 9, 14),
(21, 'Entregar Códigos Java', '2017-06-25', 25, 9, 15),
(22, 'Show de Rock', '2017-11-30', 33, 9, 3),
(23, 'Conhecer a Disney', '2017-12-15', 34, 10, 21),
(24, 'Passear pela Cidade', '2017-12-16', 35, 10, 21),
(25, 'Comprar passagens para Orlando', '2017-11-10', 28, 10, 6),
(26, 'Comprar comida', '2017-06-06', 36, 11, 6),
(27, 'Cuidar do Pedro', '2017-08-15', 26, 11, 5),
(28, 'Descansar', '2018-02-01', 37, 12, 21),
(29, 'Voltar para Casa', '2018-02-28', 27, 12, 17),
(30, 'Assistir partida do Flamengo', '2017-06-25', 38, 13, 3),
(31, 'Escrever Crônica da Partida do Flamengo', '2017-06-25', 30, 13, 22);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipostarefas`
--

CREATE TABLE `tipostarefas` (
  `codigoTipo` int(11) NOT NULL,
  `descricaoTipo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tipostarefas`
--

INSERT INTO `tipostarefas` (`codigoTipo`, `descricaoTipo`) VALUES
(12, 'Banco de Dados Avançados'),
(11, 'Desenvolvimento para Web '),
(3, 'Diversão'),
(14, 'Engenharia de Requisitos'),
(13, 'Engenharia de Software II'),
(19, 'Estética'),
(1, 'Estudar'),
(20, 'Fazer Almoço'),
(6, 'Fazer Compras'),
(7, 'Festa de Aniversário'),
(4, 'Ir ao Cinema'),
(9, 'Ir para a Escola'),
(10, 'Jantar'),
(5, 'Passeio no Parque'),
(2, 'Praticar Esporte'),
(15, 'Programação Orientada a Objetos'),
(18, 'Reunião de Negócios'),
(22, 'Trabalho'),
(21, 'Turismo'),
(17, 'Viagem');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `codigoUsuario` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`codigoUsuario`, `nome`, `email`, `senha`) VALUES
(2, 'Routine', 'routine_web@gmail.com', '$2y$10$UrTcDR63VHbo7mQDuf8LKuXb2W4KUawH0uSQMyhkN3tRhh1g5nr5e'),
(3, 'Murilo', 'perosamurilo@gmail.com', '$2y$10$KFlH8gDAWqy3SIYYI/Qy5ekIBmc//RLXMWtg6oRoAkqGHsjKP.4MC'),
(4, 'Usuário 1', 'usuario1@usr.com', '$2y$10$p9VY5ILwJ.QyiOBCrsVfq.Z9XY7mVnSm6/EDFNISC5qbEAWuVNR5i'),
(5, 'Usuário 2', 'usuario2@usr.com', '$2y$10$N8dmoLzpCh3kv1lE9FqHyOmbSthFGnjvLq8CWGX4cQJf2F6kCuOQG'),
(6, 'Usuário 3', 'usuario3@usr.com', '$2y$10$PiPqjJ1pJk35PJ2HmNni.O3eYig0RFAIITjbF/CwYuHUsvmhwXV9a'),
(7, 'Usuário 4', 'usuario4@usr.com', '$2y$10$WWQTdhZtTmOmPTbZi9uSiOBo3WmEA6u/nbpSJOHr.MsTaWm5/K3Q2'),
(8, 'Usuário 5', 'usuario5@usr.com', '$2y$10$3HXSzzSW.pHNjm3AsJWS7OHqAdCx8zh2zVzyaMHqrGhG2IGcRxXp6'),
(9, 'Usuário 6', 'usuario6@usr.com', '$2y$10$9imdZXf9SCtHynsb9U0qTOu8CKs/YdEQlEfgrdIOcJn4h5s2YiZuG'),
(10, 'Usuário 7', 'usuario7@usr.com', '$2y$10$POw7w35dqDL8z/khLhcQ/ecqHYwDxwuV5cjxBSJXL9qou2vVSK5Mu'),
(11, 'Usuário 8', 'usuario8@usr.com', '$2y$10$1GIwYuubdL.bssVlUDn5u.UHBZs8Lu5tdYmvOwQFne4gJrunyEh/u'),
(12, 'Usuário 9', 'usuario9@usr.com', '$2y$10$JpZkmFKZ01b2lI4nuTmGoOfgrMizNrXv.AWgZM7ilNutXYHBhScIK'),
(13, 'Usuário 10', 'usuario10@usr.com', '$2y$10$aItLBY8ZkwDD.pi4eBI1.OGnzMT9ncKK7lyOvQfewcAqOS.k6tLAi');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `locais`
--
ALTER TABLE `locais`
  ADD PRIMARY KEY (`codigoLocal`),
  ADD UNIQUE KEY `descricaoLocal` (`descricaoLocal`),
  ADD KEY `codigoUsuario` (`codigoUsuario`);

--
-- Indexes for table `tarefas`
--
ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`codigoTarefa`),
  ADD KEY `codigoLocal` (`codigoLocal`),
  ADD KEY `codigoUsuario` (`codigoUsuario`),
  ADD KEY `codigoTipo` (`codigoTipo`);

--
-- Indexes for table `tipostarefas`
--
ALTER TABLE `tipostarefas`
  ADD PRIMARY KEY (`codigoTipo`),
  ADD UNIQUE KEY `descricaoTipo` (`descricaoTipo`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`codigoUsuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `locais`
--
ALTER TABLE `locais`
  MODIFY `codigoLocal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `tarefas`
--
ALTER TABLE `tarefas`
  MODIFY `codigoTarefa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `tipostarefas`
--
ALTER TABLE `tipostarefas`
  MODIFY `codigoTipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `codigoUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `locais`
--
ALTER TABLE `locais`
  ADD CONSTRAINT `locais_ibfk_1` FOREIGN KEY (`codigoUsuario`) REFERENCES `usuarios` (`codigoUsuario`);

--
-- Limitadores para a tabela `tarefas`
--
ALTER TABLE `tarefas`
  ADD CONSTRAINT `tarefas_ibfk_1` FOREIGN KEY (`codigoLocal`) REFERENCES `locais` (`codigoLocal`),
  ADD CONSTRAINT `tarefas_ibfk_2` FOREIGN KEY (`codigoUsuario`) REFERENCES `usuarios` (`codigoUsuario`),
  ADD CONSTRAINT `tarefas_ibfk_3` FOREIGN KEY (`codigoTipo`) REFERENCES `tipostarefas` (`codigoTipo`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
