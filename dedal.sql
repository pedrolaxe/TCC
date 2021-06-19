-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Jun-2021 às 18:22
-- Versão do servidor: 10.4.18-MariaDB
-- versão do PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dedal`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `colaborador`
--

CREATE TABLE `colaborador` (
  `id_colaborador` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `codigo` varchar(200) NOT NULL,
  `codexp` int(11) DEFAULT NULL,
  `nome_colaborador` varchar(255) DEFAULT NULL,
  `cpf` varchar(255) DEFAULT NULL,
  `rg` varchar(255) DEFAULT NULL,
  `telefone` varchar(255) DEFAULT NULL,
  `status_colaborador` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `colaborador`
--

INSERT INTO `colaborador` (`id_colaborador`, `login`, `senha`, `email`, `tipo`, `codigo`, `codexp`, `nome_colaborador`, `cpf`, `rg`, `telefone`, `status_colaborador`) VALUES
(52, 'Gustavo', '202cb962ac59075b964b07152d234b70', 'gbernal@outlook.com.br', 'colaborador', '', 0, 'Gustavo', '153.236.567-51', '26.466.330-3', '(35) 98807-4444', NULL),
(54, 'Lazaro', '202cb962ac59075b964b07152d234b70', 'laz@gmail.com', 'colaborador', '', 0, 'Lazaro', '123.456.785-68', '11.111.111-1', '(21) 98687-4632', 'inativo'),
(55, 'Gustavo', '202cb962ac59075b964b07152d234b70', 'G@c', 'colaborador', '', 0, '123', '', '', '', 'inativo'),
(56, 'Lazaro', '202cb962ac59075b964b07152d234b70', 'g@c', 'colaborador', '', 0, '1', '', '', '', 'inativo'),
(57, 'a', 'c20ad4d76fe97759aa27a0c99bff6710', 'a@c', 'colaborador', '', 0, 'a', '', '', '', 'inativo'),
(58, 'a', '202cb962ac59075b964b07152d234b70', 'a@c', 'colaborador', '', 0, 'a', '', '', '', 'inativo'),
(59, 'João', '202cb962ac59075b964b07152d234b70', 'g@c', 'colaborador', '', 0, 'João', '', '', '', 'inativo'),
(65, 'Gerente', '202cb962ac59075b964b07152d234b70', 'g@c.com', 'administrador', '', 0, 'Pedro', '312.321.321-32', '3213213213', '(42) 14214-2142', NULL),
(66, 'Ana2', '81dc9bdb52d04dc20036dbd8313ed055', 'ana2@gmail.com', 'colaborador', '', 0, 'Ana2', '312.312.412-42', '32.234.567-9', '(21) 90876-4712', 'inativo');

-- --------------------------------------------------------

--
-- Estrutura da tabela `comanda`
--

CREATE TABLE `comanda` (
  `id_comanda` int(11) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `desconto` decimal(10,2) DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fim` time DEFAULT NULL,
  `data_comanda` date DEFAULT NULL,
  `observacao` varchar(255) DEFAULT NULL,
  `pix` decimal(10,2) DEFAULT NULL,
  `cartao` decimal(10,2) DEFAULT NULL,
  `dinheiro` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `comanda`
--

INSERT INTO `comanda` (`id_comanda`, `nome`, `status`, `desconto`, `hora_inicio`, `hora_fim`, `data_comanda`, `observacao`, `pix`, `cartao`, `dinheiro`) VALUES
(786, 'João', 'fechado', '0.00', '00:34:05', '00:34:46', '2021-06-16', NULL, '6.35', '15.00', '10.00'),
(787, 'Ana', 'fechado', '5.00', '00:36:06', '00:36:30', '2021-06-16', NULL, '0.00', '0.50', '0.00'),
(788, 'Pedro', 'fechado', '22.38', '00:38:59', '00:47:17', '2021-06-16', NULL, '0.00', '0.00', '0.00'),
(789, 'Pedro', 'fechado', '0.00', '00:50:32', '00:55:17', '2021-06-16', NULL, '0.00', '0.00', '0.00'),
(790, 'Pedro', 'cancelado', '0.00', '00:55:39', '00:55:59', '2021-06-16', 'calote', NULL, NULL, NULL),
(792, 'Jaqueline', 'fechado', '0.00', '08:10:20', '08:12:42', '2021-06-16', NULL, '0.00', '10.00', '2.65'),
(793, 'Jaqueline', 'fechado', '0.00', '08:13:57', '09:15:23', '2021-06-16', NULL, '0.00', '605.00', '0.00'),
(794, 'Pedro', 'fechado', '0.00', '09:16:18', '09:16:35', '2021-06-16', NULL, '0.00', '0.00', '302.50'),
(795, 'Clara', 'fechado', '0.00', '09:54:26', '09:54:56', '2021-06-16', NULL, '0.00', '178.75', '0.00'),
(796, 'João', 'fechado', '17.19', '10:24:37', '12:49:16', '2021-06-16', NULL, '75.00', '0.00', '3.00'),
(801, 'Ana', 'fechado', '0.00', '18:36:40', '18:43:19', '2021-06-16', NULL, '0.00', '10.00', '8.70'),
(803, 'Jessica', 'fechado', '10.00', '18:43:40', '03:22:28', '2021-06-16', NULL, '0.00', '83.00', '0.00'),
(804, 'João', 'fechado', '0.00', '03:23:44', '03:23:56', '2021-06-17', NULL, '0.00', '40.00', '0.00'),
(805, 'Ana', 'fechado', '0.00', '03:24:03', '03:24:29', '2021-06-17', NULL, '100.00', '0.00', '0.00'),
(806, 'Ivo', 'fechado', '0.00', '03:24:41', '03:25:02', '2021-06-17', NULL, '0.00', '27.00', '0.00'),
(807, 'Ana', 'fechado', '2.55', '03:46:33', '11:19:02', '2021-06-17', NULL, '0.00', '20.00', '5.25'),
(808, 'José', 'fechado', '0.00', '03:46:58', '04:07:39', '2021-06-17', NULL, '0.00', '20.00', '0.00'),
(811, 'João', 'cancelado', '0.00', '11:19:18', '11:20:33', '2021-06-19', 'Cliente insatisfeito', NULL, NULL, NULL),
(812, 'Joana', 'fechado', '0.00', '11:20:51', '11:34:44', '2021-06-19', NULL, '0.00', '18.70', '0.00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `config`
--

CREATE TABLE `config` (
  `id_config` int(11) NOT NULL,
  `nome_empresa` varchar(255) DEFAULT NULL,
  `nome_impressora` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `config`
--

INSERT INTO `config` (`id_config`, `nome_empresa`, `nome_impressora`, `logo`) VALUES
(1, 'Bar do Bigode', 'Bematech', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pedido`
--

CREATE TABLE `pedido` (
  `id_pedido` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `id_comanda` int(11) DEFAULT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `status_pedido` varchar(255) DEFAULT NULL,
  `id_colaborador` int(11) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `pedido`
--

INSERT INTO `pedido` (`id_pedido`, `quantidade`, `id_comanda`, `id_produto`, `data`, `status_pedido`, `id_colaborador`, `valor`) VALUES
(1086, 1, 786, 55, '2021-06-16 00:34:19', NULL, 52, '5.50'),
(1092, 1, 792, 11, '2021-06-16 08:10:36', NULL, 52, '11.50'),
(1095, 50, 794, 55, '2021-06-16 09:16:26', NULL, 59, '5.50'),
(1096, 5, 795, 15, '2021-06-16 09:54:37', NULL, 52, '8.50'),
(1097, 10, 795, 16, '2021-06-16 09:54:47', NULL, 52, '12.00'),
(1104, 5, 796, 39, '2021-06-16 12:40:08', NULL, 52, '6.00'),
(1106, 4, 796, 39, '2021-06-16 12:47:08', NULL, 52, '6.00'),
(1107, 2, 801, 15, '2021-06-16 18:36:59', NULL, 52, '8.50'),
(1109, 2, 803, 6, '2021-06-16 18:43:33', NULL, 59, '21.00'),
(1114, 2, 808, 15, '2021-06-17 04:07:15', NULL, 52, '8.50'),
(1116, 3, 807, 15, '2021-06-19 11:15:27', NULL, 65, '8.50'),
(1117, 2, 807, 4, '2021-06-19 11:17:47', 'cancelado', 52, '13.50'),
(1118, 2, 811, 16, '2021-06-19 11:19:27', NULL, 52, '12.00'),
(1119, 2, 812, 15, '2021-06-19 11:34:36', NULL, 52, '8.50');

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

CREATE TABLE `produto` (
  `id_produto` int(11) NOT NULL,
  `nome_produto` varchar(100) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `status_produto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`id_produto`, `nome_produto`, `preco`, `descricao`, `status_produto`) VALUES
(2, 'Feijão', '11.19', '', 'inativo'),
(4, 'Heineken 1L', '13.50', NULL, NULL),
(6, 'Batata Frita', '21.00', '', NULL),
(11, 'Canjica', '11.50', '', 'inativo'),
(15, 'Hamburguer', '8.50', NULL, NULL),
(16, 'Original', '12.00', '', NULL),
(39, 'Guaraná', '6.00', '', 'inativo'),
(44, 'Prato Feito', '10.00', 'Arroz, Feijão, Farofa, Batata Frita, Carne (Boi, Porco, Frango) e Salada', 'inativo'),
(55, 'Coca Light', '5.50', '', 'inativo'),
(56, 'Coca Light', '5.50', '', 'inativo'),
(57, 'Guaraná', '5.00', '', 'inativo');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `colaborador`
--
ALTER TABLE `colaborador`
  ADD PRIMARY KEY (`id_colaborador`);

--
-- Índices para tabela `comanda`
--
ALTER TABLE `comanda`
  ADD PRIMARY KEY (`id_comanda`);

--
-- Índices para tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id_config`);

--
-- Índices para tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_mesa` (`id_comanda`),
  ADD KEY `id_produto` (`id_produto`),
  ADD KEY `id_colaborador` (`id_colaborador`);

--
-- Índices para tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`id_produto`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `colaborador`
--
ALTER TABLE `colaborador`
  MODIFY `id_colaborador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de tabela `comanda`
--
ALTER TABLE `comanda`
  MODIFY `id_comanda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=813;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1120;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `id_produto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`id_comanda`) REFERENCES `comanda` (`id_comanda`),
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`id_produto`) REFERENCES `produto` (`id_produto`),
  ADD CONSTRAINT `pedido_ibfk_3` FOREIGN KEY (`id_colaborador`) REFERENCES `colaborador` (`id_colaborador`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
