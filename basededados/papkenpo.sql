-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01-Abr-2025 às 17:49
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
-- Banco de dados: `papkenpo`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `alunos`
--

CREATE TABLE `alunos` (
  `id_aluno` int(11) NOT NULL,
  `Nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(255) NOT NULL,
  `graduacao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `alunos`
--

INSERT INTO `alunos` (`id_aluno`, `Nome`, `email`, `telefone`, `graduacao`) VALUES
(1, 'edu teste1', 'edudinis44@gmail.com', '912414328', 'amarelo'),
(2, 'dinis test2', 'edudinis@sapo.pt', '987654321', 'purpura'),
(3, 'leonor', 'leonoremail@sapo.pt', '123456789', 'purpura');

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento`
--

CREATE TABLE `evento` (
  `id_evento` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `organizador` varchar(255) NOT NULL,
  `local` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `preco` decimal(10,2) NOT NULL DEFAULT 0.00,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `evento`
--

INSERT INTO `evento` (`id_evento`, `titulo`, `organizador`, `local`, `descricao`, `preco`, `data_inicio`, `data_fim`) VALUES
(5, 'Evento Teste', 'Organizador', 'Local', 'Descrição', 20.00, '2025-03-30', '2025-03-30'),
(6, 'evento top', 'eu', 'fixe', 'desc', 0.00, '2025-03-31', '2025-04-01'),
(7, 'teste', 'eu', 'forte', 'desc', 0.00, '2025-04-02', '2025-04-04');

-- --------------------------------------------------------

--
-- Estrutura da tabela `evento_participantes`
--

CREATE TABLE `evento_participantes` (
  `id_evento` int(11) NOT NULL,
  `id_utilizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `evento_participantes`
--

INSERT INTO `evento_participantes` (`id_evento`, `id_utilizador`) VALUES
(6, 1),
(6, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `utilizador`
--

CREATE TABLE `utilizador` (
  `id_utilizador` int(11) NOT NULL,
  `idaluno` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `graduacao` varchar(255) DEFAULT NULL,
  `admin` tinyint(4) DEFAULT NULL,
  `block` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `utilizador`
--

INSERT INTO `utilizador` (`id_utilizador`, `idaluno`, `email`, `password`, `nome`, `telefone`, `graduacao`, `admin`, `block`) VALUES
(1, 2, 'edudinis@sapo.pt', '$2y$10$gP3j0hD6bnGtfnp0TZb9ue97swY28nho3foQSD50CkCWosUKbY.0u', 'eduardo', NULL, 'branco', NULL, NULL),
(5, 1, 'edudinis44@gmail.com', '$2y$10$GW.tLgOvyACS1cSmrpGRTuvMLoZBA3uQG0OvkzmbV8WQPoUOSvc3i', 'dinis', NULL, 'castanho1', 1, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id_aluno`);

--
-- Índices para tabela `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id_evento`);

--
-- Índices para tabela `evento_participantes`
--
ALTER TABLE `evento_participantes`
  ADD PRIMARY KEY (`id_evento`,`id_utilizador`),
  ADD KEY `FK_idutilizador` (`id_utilizador`);

--
-- Índices para tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD PRIMARY KEY (`id_utilizador`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FK_idaluno` (`idaluno`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id_aluno` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `evento`
--
ALTER TABLE `evento`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `utilizador`
--
ALTER TABLE `utilizador`
  MODIFY `id_utilizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `evento_participantes`
--
ALTER TABLE `evento_participantes`
  ADD CONSTRAINT `FK_idevento` FOREIGN KEY (`id_evento`) REFERENCES `evento` (`id_evento`),
  ADD CONSTRAINT `FK_idutilizador` FOREIGN KEY (`id_utilizador`) REFERENCES `utilizador` (`id_utilizador`);

--
-- Limitadores para a tabela `utilizador`
--
ALTER TABLE `utilizador`
  ADD CONSTRAINT `FK_idaluno` FOREIGN KEY (`idaluno`) REFERENCES `alunos` (`id_aluno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
