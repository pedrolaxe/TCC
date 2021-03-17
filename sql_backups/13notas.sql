-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 28, 2020 at 07:08 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `13notas`
--

-- --------------------------------------------------------

--
-- Table structure for table `zn_backups`
--

CREATE TABLE `zn_backups` (
  `id` int(11) NOT NULL,
  `caminho` varchar(255) NOT NULL,
  `arquivo` varchar(255) NOT NULL,
  `data` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zn_categories`
--

CREATE TABLE `zn_categories` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `data` varchar(255) NOT NULL,
  `hora` int(11) NOT NULL,
  `autor` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zn_clients`
--

CREATE TABLE `zn_clients` (
  `id` int(11) NOT NULL,
  `razao` varchar(255) NOT NULL,
  `nome_fan` varchar(255) NOT NULL,
  `cnpj` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `comp` varchar(255) NOT NULL,
  `bairro` varchar(255) NOT NULL,
  `cidade` varchar(255) NOT NULL,
  `uf` varchar(2) NOT NULL,
  `zn_categories` int(11) NOT NULL,
  `data` varchar(10) NOT NULL,
  `hora` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_clients`
--

INSERT INTO `zn_clients` (`id`, `razao`, `nome_fan`, `cnpj`, `email`, `telefone`, `celular`, `cep`, `endereco`, `comp`, `bairro`, `cidade`, `uf`, `zn_categories`, `data`, `hora`) VALUES
(7, 'Trezenotas', '13 Notas', '01.233.333/3333-33', 'treze@notas.com', '(21) 8888-8888', '(21) 88888-8888', '20040-912', 'Avenida Rio Branco 135', '312', 'Centro', 'Rio de Janeiro', 'RJ', 0, '10/04/2017', '17:51:04'),
(8, 'teste de empresa', 'Megateste', '01.345.678/9999-77', 'mega@teste.com.br', '(21) 5555-5555', '(21) 99999-9111', '20040-912', 'Avenida Rio Branco 135', '312', 'Centro', 'Rio de Janeiro', 'RJ', 0, '18/07/2020', '16:28:28');

-- --------------------------------------------------------

--
-- Table structure for table `zn_cobrancas`
--

CREATE TABLE `zn_cobrancas` (
  `id` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `categoria` int(11) NOT NULL,
  `data_pref` varchar(255) NOT NULL,
  `data_pag` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `status` varchar(1) NOT NULL DEFAULT '0',
  `datahora` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zn_contracheques`
--

CREATE TABLE `zn_contracheques` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `caminho` varchar(255) NOT NULL,
  `data` varchar(255) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_contracheques`
--

INSERT INTO `zn_contracheques` (`id`, `id_user`, `tipo`, `nome`, `caminho`, `data`, `status`) VALUES
(9, 29, 'pdf', 'sistatac.pdf', 'uploads/contra-cheques/12345678911/sistatac.pdf', '11/01/2017 17:07', 1);

-- --------------------------------------------------------

--
-- Table structure for table `zn_entradasaida`
--

CREATE TABLE `zn_entradasaida` (
  `id` int(11) NOT NULL,
  `codpat` varchar(100) NOT NULL,
  `dt_ent` varchar(20) NOT NULL,
  `dt_sai` varchar(20) NOT NULL,
  `projeto` varchar(200) NOT NULL,
  `status` varchar(5) NOT NULL,
  `usuario` varchar(100) NOT NULL,
  `data` varchar(20) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zn_equipamentos`
--

CREATE TABLE `zn_equipamentos` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cliente` varchar(50) NOT NULL,
  `valor` varchar(50) NOT NULL,
  `obs` varchar(255) NOT NULL,
  `status` varchar(5) NOT NULL DEFAULT '3',
  `data` varchar(20) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_equipamentos`
--

INSERT INTO `zn_equipamentos` (`id`, `nome`, `cliente`, `valor`, `obs`, `status`, `data`, `hora`) VALUES
(52, 'Autenticações', '', '8,47', '', '3', '28/07/2020', '01:53:32'),
(53, 'Reconhecimento de firmas - Autenticidade', '', '8,41', '', '3', '28/07/2020', '01:54:18'),
(55, 'Abertura de firmas', '', '33.30', '', '3', '28/07/2020', '01:52:57'),
(56, 'Reconhecimento de firmas - Semelhança', '', '8.20', '', '3', '28/07/2020', '01:54:45');

-- --------------------------------------------------------

--
-- Table structure for table `zn_maps`
--

CREATE TABLE `zn_maps` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `lat` varchar(50) NOT NULL,
  `lnt` varchar(50) NOT NULL,
  `referencia` varchar(255) NOT NULL,
  `autoshow` varchar(20) NOT NULL DEFAULT 'false',
  `cep` varchar(9) NOT NULL,
  `cidade` varchar(255) NOT NULL DEFAULT '',
  `bairro` varchar(255) NOT NULL DEFAULT '',
  `tel` varchar(255) NOT NULL DEFAULT '',
  `website` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_maps`
--

INSERT INTO `zn_maps` (`id`, `nome`, `rua`, `lat`, `lnt`, `referencia`, `autoshow`, `cep`, `cidade`, `bairro`, `tel`, `website`) VALUES
(1, 'Spacetec - Soluções Tecnologicas', 'Av. Rio Branco 37, sala 1502', '-22.899013', '-43.179831', '', 'false', '20090-003', 'Rio de Janeiro', 'Centro', '(21) 2213-0548', 'http://spacetec.com.br'),
(2, 'teste de local', 'av rio branco', '-22.9004374', '-43.1790763', '', 'false', '20041-004', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `zn_marcas`
--

CREATE TABLE `zn_marcas` (
  `id` int(11) NOT NULL,
  `marca` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `data` varchar(255) NOT NULL,
  `hora` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zn_options`
--

CREATE TABLE `zn_options` (
  `id` int(11) NOT NULL,
  `nome_site` varchar(255) NOT NULL DEFAULT '',
  `desc_site` varchar(255) NOT NULL DEFAULT '',
  `bemvindo` varchar(20) NOT NULL,
  `url_logo` varchar(255) NOT NULL,
  `apikey` varchar(1000) NOT NULL,
  `retcode` int(3) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_options`
--

INSERT INTO `zn_options` (`id`, `nome_site`, `desc_site`, `bemvindo`, `url_logo`, `apikey`, `retcode`) VALUES
(1, 'SUPERADMIN', 'Painel', '1', 'http://localhost/spaceadmin/img/logo_sistema.png', '8aa1ac196d59ccde3615e63a86f76a0be724fe44', 100);

-- --------------------------------------------------------

--
-- Table structure for table `zn_pedidos`
--

CREATE TABLE `zn_pedidos` (
  `id` int(11) NOT NULL,
  `codcliente` varchar(50) NOT NULL,
  `numboleta` varchar(50) NOT NULL,
  `datapedido` varchar(50) NOT NULL,
  `save_cart` mediumtext NOT NULL,
  `observacao` mediumtext NOT NULL,
  `data` varchar(20) NOT NULL,
  `hora` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_pedidos`
--

INSERT INTO `zn_pedidos` (`id`, `codcliente`, `numboleta`, `datapedido`, `save_cart`, `observacao`, `data`, `hora`) VALUES
(18, '7', '1313', '28/07/2020', '[{\"servico\":\"\",\"quant\":\"\",\"vunitario\":\"\",\"vtotal\":\"\"},{\"servico\":\"52\",\"quant\":\"5\",\"vunitario\":\"8,47\",\"vtotal\":\"40.00\"},{\"servico\":\"55\",\"quant\":\"3\",\"vunitario\":\"33.30\",\"vtotal\":\"99.90\"},{\"servico\":\"56\",\"quant\":\"7\",\"vunitario\":\"8.20\",\"vtotal\":\"57.40\"},{\"servico\":\"53\",\"quant\":\"4\",\"vunitario\":\"8,41\",\"vtotal\":\"32.00\"}]', '', '28/07/2020', '02:00:17'),
(19, '8', '1424', '06/05/2020', '[{\"servico\":\"\",\"quant\":\"\",\"vunitario\":\"\",\"vtotal\":\"\"},{\"servico\":\"53\",\"quant\":\"5\",\"vunitario\":\"8,41\",\"vtotal\":\"40.00\"},{\"servico\":\"56\",\"quant\":\"3\",\"vunitario\":\"8.20\",\"vtotal\":\"24.60\"}]', '', '28/07/2020', '02:00:46');

-- --------------------------------------------------------

--
-- Table structure for table `zn_plugins`
--

CREATE TABLE `zn_plugins` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `caminho` varchar(255) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_plugins`
--

INSERT INTO `zn_plugins` (`id`, `nome`, `slug`, `caminho`, `ativo`) VALUES
(1, 'Clientes', 'clientes', 'zn-clientes', 1),
(2, 'Cobranças', 'cobrancas', 'zn-clientes', 0),
(3, 'Serviços', 'servicos', 'zn-clientes', 0),
(4, 'Equipamentos', 'equipamentos', 'zn-clientes', 1),
(5, 'Calendário', 'calendario', 'zn-clientes', 0),
(6, 'Contracheques', 'contracheques', 'zn-clientes', 1),
(8, 'Entrada / Saída', 'entradasaida', 'zn-clientes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `zn_posts`
--

CREATE TABLE `zn_posts` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL DEFAULT '',
  `slug` varchar(50) NOT NULL DEFAULT '',
  `categoria` varchar(255) DEFAULT '',
  `data` varchar(20) NOT NULL DEFAULT '',
  `hora` varchar(25) NOT NULL DEFAULT '',
  `texto` mediumtext NOT NULL,
  `ativo` varchar(1) NOT NULL DEFAULT '',
  `imgdst` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zn_recover`
--

CREATE TABLE `zn_recover` (
  `id` int(11) NOT NULL,
  `pergunta` mediumtext NOT NULL,
  `resposta` varchar(255) NOT NULL DEFAULT '',
  `id_user` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_recover`
--

INSERT INTO `zn_recover` (`id`, `pergunta`, `resposta`, `id_user`) VALUES
(1, 'Nome do Cachorro da Infância?', 'dread', 3);

-- --------------------------------------------------------

--
-- Table structure for table `zn_services`
--

CREATE TABLE `zn_services` (
  `id` int(11) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `val_uni` varchar(255) NOT NULL,
  `desconto` varchar(255) NOT NULL,
  `data` varchar(50) NOT NULL,
  `hora` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_services`
--

INSERT INTO `zn_services` (`id`, `descricao`, `val_uni`, `desconto`, `data`, `hora`) VALUES
(1, 'Hospedagem Mensal', '40,00', '', '01/09/2016', '15:29:37'),
(2, 'Hospedagem Trimestral', '120,00', '', '01/09/2016', '15:30:12'),
(3, 'Hospedagem Semestral', '240,00', '', '01/09/2016', '15:30:28'),
(4, 'Hospedagem Anual', '480,00', '', '01/09/2016', '15:30:53');

-- --------------------------------------------------------

--
-- Table structure for table `zn_themes`
--

CREATE TABLE `zn_themes` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `pasta` varchar(255) NOT NULL,
  `ativo` int(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_themes`
--

INSERT INTO `zn_themes` (`id`, `nome`, `pasta`, `ativo`) VALUES
(3, 'Zion Theme', '2015', 1);

-- --------------------------------------------------------

--
-- Table structure for table `zn_ticket`
--

CREATE TABLE `zn_ticket` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `mensagem` varchar(1000) NOT NULL,
  `tipo` int(11) NOT NULL,
  `data` varchar(255) NOT NULL,
  `hora` varchar(255) NOT NULL,
  `situacao` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `zn_users`
--

CREATE TABLE `zn_users` (
  `id` int(11) NOT NULL,
  `usuario` varchar(255) NOT NULL DEFAULT '',
  `senha` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `nome_inteiro` varchar(100) NOT NULL DEFAULT '',
  `nascimento` varchar(255) NOT NULL DEFAULT '',
  `url_img` varchar(255) NOT NULL,
  `funcao` varchar(255) NOT NULL,
  `data` varchar(50) NOT NULL DEFAULT '',
  `ativo` int(1) NOT NULL DEFAULT '0',
  `codigo` varchar(255) NOT NULL DEFAULT '',
  `codexp` int(1) NOT NULL DEFAULT '0',
  `caminho` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `zn_users`
--

INSERT INTO `zn_users` (`id`, `usuario`, `senha`, `email`, `nome_inteiro`, `nascimento`, `url_img`, `funcao`, `data`, `ativo`, `codigo`, `codexp`, `caminho`) VALUES
(3, 'pedro', '0b8d87a590d960b55512503c0fe89c5e8ce7e34c', 'pedrolaxe@gmail.com', 'Pedro Laxe', '14/07/1995', '', '1', '23/02/2020 22:35:30', 1, '2eb0204e707c0e2f915273d274396f4d', 1, ''),
(42, 'teste', '47e1b47ca75468674e15598efb3788a22d116c95', '1111@1111.com', 'Teste', '11/11/1111', '', '2', '22/07/2020 23:28:11', 1, '', 0, ''),
(43, '12344522222', '47e1b47ca75468674e15598efb3788a22d116c95', 'ppp@pp.ocm', 'user', '', '', '4', '18/07/2020 16:20:06', 1, '', 0, 'uploads/contra-cheques/12344522222/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zn_backups`
--
ALTER TABLE `zn_backups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_categories`
--
ALTER TABLE `zn_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_clients`
--
ALTER TABLE `zn_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_cobrancas`
--
ALTER TABLE `zn_cobrancas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_contracheques`
--
ALTER TABLE `zn_contracheques`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_entradasaida`
--
ALTER TABLE `zn_entradasaida`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_equipamentos`
--
ALTER TABLE `zn_equipamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_maps`
--
ALTER TABLE `zn_maps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_marcas`
--
ALTER TABLE `zn_marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_options`
--
ALTER TABLE `zn_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_pedidos`
--
ALTER TABLE `zn_pedidos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_plugins`
--
ALTER TABLE `zn_plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_posts`
--
ALTER TABLE `zn_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_recover`
--
ALTER TABLE `zn_recover`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_services`
--
ALTER TABLE `zn_services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_themes`
--
ALTER TABLE `zn_themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_ticket`
--
ALTER TABLE `zn_ticket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zn_users`
--
ALTER TABLE `zn_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `zn_backups`
--
ALTER TABLE `zn_backups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zn_categories`
--
ALTER TABLE `zn_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `zn_clients`
--
ALTER TABLE `zn_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `zn_cobrancas`
--
ALTER TABLE `zn_cobrancas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `zn_contracheques`
--
ALTER TABLE `zn_contracheques`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zn_entradasaida`
--
ALTER TABLE `zn_entradasaida`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `zn_equipamentos`
--
ALTER TABLE `zn_equipamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `zn_maps`
--
ALTER TABLE `zn_maps`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zn_marcas`
--
ALTER TABLE `zn_marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `zn_options`
--
ALTER TABLE `zn_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zn_pedidos`
--
ALTER TABLE `zn_pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `zn_plugins`
--
ALTER TABLE `zn_plugins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `zn_posts`
--
ALTER TABLE `zn_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `zn_recover`
--
ALTER TABLE `zn_recover`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `zn_services`
--
ALTER TABLE `zn_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `zn_themes`
--
ALTER TABLE `zn_themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `zn_ticket`
--
ALTER TABLE `zn_ticket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zn_users`
--
ALTER TABLE `zn_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
