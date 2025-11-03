-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/11/2025 às 19:13
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `idosos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alergias`
--

CREATE TABLE `alergias` (
  `id_dado` int(5) NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `alergia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alergias`
--

INSERT INTO `alergias` (`id_dado`, `id_usuario`, `alergia`) VALUES
(7, 6, 'camarão'),
(8, 6, 'pó'),
(9, 142, 'dfs'),
(10, 142, 'dfs'),
(11, 3, 'ss'),
(12, 3, 'ss'),
(13, 3, 'ss'),
(14, 3, 'ss'),
(15, 3, 'ss'),
(16, 3, 'ss'),
(17, 3, 'ss'),
(18, 3, 'ss'),
(19, 3, 'ss'),
(28, 1, 'iiiii'),
(29, 1, 'aaaaa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes`
--

CREATE TABLE `avaliacoes` (
  `id` int(11) NOT NULL,
  `id_voluntario` int(11) NOT NULL,
  `estrela` int(11) NOT NULL CHECK (`estrela` between 1 and 5),
  `data_avaliacao` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `avaliacoes`
--

INSERT INTO `avaliacoes` (`id`, `id_voluntario`, `estrela`, `data_avaliacao`) VALUES
(45, 124, 3, '2025-09-08 13:44:12'),
(46, 124, 2, '2025-09-08 13:44:19'),
(47, 124, 1, '2025-09-08 13:44:21'),
(48, 124, 1, '2025-09-08 13:44:23'),
(49, 124, 1, '2025-09-08 13:44:25'),
(50, 124, 2, '2025-09-08 13:44:37'),
(51, 125, 5, '2025-09-08 18:04:33'),
(52, 125, 1, '2025-09-08 18:04:38'),
(78, 132, 3, '2025-10-10 13:35:47'),
(79, 132, 3, '2025-10-10 20:42:10'),
(80, 132, 3, '2025-10-13 19:45:59'),
(81, 125, 4, '2025-10-30 12:11:37'),
(82, 142, 5, '2025-10-31 16:02:09');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro`
--

CREATE TABLE `cadastro` (
  `id` int(11) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `nome` varchar(15) NOT NULL,
  `sobrenome` varchar(30) NOT NULL,
  `data_nasc` varchar(10) NOT NULL,
  `senha` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cadastro`
--

INSERT INTO `cadastro` (`id`, `cpf`, `nome`, `sobrenome`, `data_nasc`, `senha`) VALUES
(1, '513.651.718-25', 'Nicole', 'Torres', '09/06/2007', '123'),
(2, '544.546.198-08', 'Davi', 'Silva', '04/06/2007', '99944528'),
(3, '407.900.988-73', 'Lincon', 'Correa', '15/02/2007', '123');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_eventos`
--

CREATE TABLE `cadastro_eventos` (
  `titulo` varchar(80) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `data_evento` varchar(10) NOT NULL,
  `horario` varchar(5) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `detalhes` varchar(500) NOT NULL,
  `img` varchar(500) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cadastro_voluntarios`
--

CREATE TABLE `cadastro_voluntarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `rg` text NOT NULL,
  `cpf` text NOT NULL,
  `data_nasc` varchar(10) NOT NULL,
  `cep` text NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `numero` int(10) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `comprovante_resid` varchar(50) NOT NULL,
  `hora1` varchar(5) NOT NULL,
  `hora2` varchar(5) NOT NULL,
  `telefone` text NOT NULL,
  `valor` int(10) NOT NULL,
  `foto` varchar(50) NOT NULL,
  `texto` varchar(200) NOT NULL,
  `sexo` text NOT NULL,
  `face` varchar(50) NOT NULL,
  `perfil` varchar(50) NOT NULL,
  `validado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cadastro_voluntarios`
--

INSERT INTO `cadastro_voluntarios` (`id`, `nome`, `rg`, `cpf`, `data_nasc`, `cep`, `endereco`, `bairro`, `numero`, `cidade`, `estado`, `comprovante_resid`, `hora1`, `hora2`, `telefone`, `valor`, `foto`, `texto`, `sexo`, `face`, `perfil`, `validado`) VALUES
(124, 'Nathália da Silva Rocha', '58.099.311-5', '477.114.098-77', '10/09/1987', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 221, 'Araraquara', 'São Paulo', './img/comprovante.webp', '10:00', '13:30', '(16) 32144-732', 150, './img2/rg.png', ' Sou cuidadora de idosos a 7 anos. Além disso, sou formada em enfermagem, e fiz um curso de especialização na parte de idosos.', 'Feminino', 'uploads/foto_1757337315.png', './perfil/perfil1.jpg', 0),
(125, 'Nicole Camile Martins Torres', '89.796.796-9', '513.651.718-25', '09/06/2007', '14804-406', 'Rua Luiz Corbi', 'Parque Igaçaba', 67, 'Araraquara', 'São Paulo', './img/comprovante.webp', '14:00', '22:00', '(16) 99876-6866', 40, './img2/rg.png', 'Acabei de me formar em um curso técnico de cuidados com idosos, estou a procura de uma oportunidade de emprego.', 'Feminino', 'uploads/foto_1757354530.png', './perfil/perfil 4.jpeg', 0),
(132, 'Luana Soares Santos', '98.878.968-7', '477.114.098-77', '15/02/1995', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 221, 'Araraquara', 'São Paulo', './img/comprovante.webp', '17:53', '17:53', '(16) 32144-732', 150, './img2/rg.png', '                    Sou formada em enfermagem a 4 anos', 'Masculino', 'uploads/foto_1757883718.png', './perfil/perfil1.jpg', 0),
(133, 'Luana Soares Santos', '66.576.565-6', '477.114.098-77', '15/02/1995', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 221, 'Araraquara', 'São Paulo', './img/comprovante.webp', '21:23', '23:23', '(16) 99764-6331', 250, './img2/rg.png', '                    Trabalho com idosos há 14 anos', 'Masculino', '', './perfil/perfil1.jpg', 0),
(137, 'gfd', '43.224.242-3', '477.114.098-77', '15/02/1995', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 221, 'Araraquara', 'São Paulo', './img/133878880499800499.jpg', '04:22', '04:32', '(16) 32144-732', 4, './img2/133878880505157713.jpg', 'fsvfsv', 'Masculino', '', './perfil/perfil1.jpg', 1),
(138, 'gfd', '43.224.242-3', '477.114.098-77', '15/02/1995', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 221, 'Araraquara', 'São Paulo', './img/133878880499800499.jpg', '04:22', '04:32', '(16) 32144-732', 4, './img2/133878880505157713.jpg', 'fsvfsv', 'Masculino', '', './perfil/perfil 4.jpeg', 0),
(141, 'Geraldo ccjkeho', '22.423.424-2', '477.114.098-77', '15/02/1995', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 2212, 'Araraquara', 'São Paulo', './img/Captura de tela 2024-05-12 210056.png', '15:48', '19:45', '(16) 32144-732', 4, './img2/133878880510089464.jpg', 'hceduvheiuveruivreviegvri', 'Masculino', '', './perfil/133878880510089464.jpg', 0),
(142, 'Geraldo ccjkeho', '22.423.424-2', '477.114.098-77', '15/02/1995', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 2212, 'Araraquara', 'São Paulo', './img/Captura de tela 2024-08-15 124445.png', '15:48', '19:45', '(16) 32144-732', 4, './img2/Captura de tela 2024-05-12 210056.png', 'atualizado', 'Masculino', '', './perfil/perfil1.jpg', 1),
(143, 'Jessica huukgukfgw', '78.767.868-7', '477.114.098-77', '10/09/2006', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 221, 'Araraquara', 'São Paulo', './img/Captura de tela 2024-09-05 085615.png', '18:08', '20:08', '(16) 32144-732', 1500, './img2/perfil1.jpg', 'uivgefuigvervuevie', 'Feminino', '', './perfil/perfil1.jpg', 1),
(144, 'Geraldo ccjkeho', '22.423.424-2', '477.114.098-77', '15/02/1995', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 2212, 'Araraquara', 'São Paulo', './img/133878880505157713.jpg', '15:48', '19:45', '(16) 32144-732', 250, './img2/133878880510089464.jpg', 'agora foi', 'Masculino', '', './perfil/perfil 4.jpeg', 0),
(146, 'Geraldo ccjkeho', '22.423.424-2', '477.114.098-77', '15/02/1995', '14808-261', 'Rua Sebastião Ferreira Delfino', 'Parque Residencial Iguatemi', 2212, 'Araraquara', 'São Paulo', './img/Captura de tela 2024-08-15 124445.png', '15:48', '19:45', '(16) 32144-732', 250, './img2/Captura de tela 2024-09-05 085537.png', 'agora foi', 'Masculino', '', './perfil/perfil3.jpeg', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `comentarios`
--

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL,
  `coment` varchar(150) NOT NULL,
  `id_voluntario` int(11) NOT NULL,
  `nome_coment` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `comentarios`
--

INSERT INTO `comentarios` (`id`, `coment`, `id_voluntario`, `nome_coment`) VALUES
(132, 'jhh', 52, 'bvhfsflblv sf'),
(133, 'hkhkh', 52, 'bvhfsflblv sf'),
(134, 'jnj', 52, 'bvhfsflblv sf'),
(135, 'kjhkj', 52, 'bvhfsflblv sf'),
(136, 'kguikbkb', 57, 'bvhfsflblv sf'),
(137, 'Já fui 2 vezes assistir vcs e curti muito!', 57, 'bvhfsflblv sf'),
(138, 'jhhh', 73, 'bvhfsflblv'),
(143, 'khvfuisgvuwguv', 59, 'bvhfsflblv'),
(159, 'jno´', 0, 'kufywruekvg'),
(160, 'oop', 0, 'kufywruekvg'),
(166, 'çji', 60, '32'),
(167, 'knl', 60, '32'),
(170, 'iugfirgfiw', 121, 'uuuuuuu'),
(171, 'jkjbvkw', 121, 'uuuuuuu'),
(175, 'Recomendo muito, excelente profissional!', 124, 'Vivian'),
(176, 'Ela já cuidou do meu tio. Muito boa!', 124, 'Júnior'),
(178, 'ótima cuidadora!', 125, 'Nicole Camile Martins Torres'),
(186, 'O trabalho ddela é simoplesmente extraordiunario', 132, 'Luana Soares Santos'),
(189, 'ljbnsflbs', 132, 'Luana Soares Santos'),
(190, 'ihfsdbh', 132, 'Luana Soares Santos'),
(191, 'nifsobisp', 132, 'Luana Soares Santos'),
(198, 'khkgk', 125, 'gfd'),
(199, 'jkhjvksf', 141, 'gfd'),
(201, 'mmbmtmbp', 145, 'gfd'),
(202, 'teste', 142, 'Nicole'),
(206, 'top', 146, 'Davi'),
(207, 'febe', 146, 'Davi'),
(211, 'REY', 143, 'Davi'),
(212, 'TTN', 143, 'Nicole'),
(213, 'TTN', 143, 'Nicole'),
(214, 'TTN', 143, 'Nicole'),
(215, 'TTN', 143, 'Nicole'),
(216, 'ihiohl', 143, 'Nicole'),
(217, 'rtur', 143, 'Nicole'),
(219, 'df', 143, 'Nicole'),
(221, 'gg3g3', 143, 'Nicole'),
(222, 'y3353', 143, 'Nicole'),
(223, 'lalala', 143, 'Nicole'),
(224, 'h45h44', 143, 'Nicole'),
(225, '54444', 143, 'Nicole'),
(228, 'wegwgw', 143, 'Nicole'),
(229, 'gewg', 143, 'Nicole'),
(233, 'bdnbenen', 143, 'Nicole'),
(236, 'teste', 143, 'Nicole'),
(237, 'aaaaaaaaaa', 142, 'Lincon');

-- --------------------------------------------------------

--
-- Estrutura para tabela `consultas`
--

CREATE TABLE `consultas` (
  `id_dado` int(5) NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `consulta` varchar(50) NOT NULL,
  `data` varchar(10) NOT NULL,
  `horario` varchar(5) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `contato` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `consultas`
--

INSERT INTO `consultas` (`id_dado`, `id_usuario`, `consulta`, `data`, `horario`, `endereco`, `contato`) VALUES
(5, 6, 'aaaaaaaaai', '52/69/00', '19:30', 'rua taabom', '0000000000'),
(6, 142, 'ssbs', 'vbb', 'dcb', 'cxbfb', 'bfd'),
(7, 142, 'ssbs', 'vbb', 'dcb', 'cxbfb', 'bfd'),
(9, 143, 'a', '2025-11-08', '12:00', 'ruaa sla', '55787841'),
(10, 143, 'a', '2025-11-08', '12:00', 'ruaa sla', '55787841'),
(11, 143, 'a', '2025-11-08', '12:00', 'ruaa sla', '55787841'),
(12, 143, 'a', '2025-11-08', '12:00', 'ruaa sla', '55787841'),
(19, 3, 'sss', '2025-11-06', '04:05', 'ss', 'ss'),
(20, 3, 'sss', '2025-11-06', '04:05', 'ss', 'ss'),
(27, 1, 'aaaaa', '2025-11-22', '18:26', 'aaa', 'aaa'),
(28, 1, 'aaaa', '2025-11-05', '12:00', 'aaa', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contatos`
--

CREATE TABLE `contatos` (
  `id_dado` int(5) NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `nome_contato` varchar(20) NOT NULL,
  `numero` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `contatos`
--

INSERT INTO `contatos` (`id_dado`, `id_usuario`, `nome_contato`, `numero`) VALUES
(1, 6, 'lincon', '16988531766'),
(2, 6, 'ta', '00000000'),
(9, 8, 'Lincon', '16 999635069'),
(10, 6, 'teste', '1458222699'),
(12, 142, 'eeeee', '2550651'),
(13, 143, 'teste', '16988531766'),
(14, 143, 'teste', '16988531766'),
(15, 143, 'teste', '16988531766'),
(16, 143, 'teste', '16988531766'),
(17, 143, 'teste', '16988531766'),
(18, 3, 'ss', 'd'),
(19, 3, 'ss', 'd'),
(20, 3, 'ss', 'd'),
(21, 3, 'ss', 'd'),
(22, 3, 'ss', 'd'),
(23, 3, 'ss', 'd'),
(24, 3, 'ss', 'd'),
(25, 3, 'ss', 'd'),
(26, 3, 'ss', 'd'),
(38, 1, 'xxxxxx', 'xxx'),
(41, 1, 'a', 'aaa'),
(42, 1, 'aa', 'aaa'),
(43, 1, 'hhhh', 'hhh'),
(44, 1, 'ddddd', 'dddddd');

-- --------------------------------------------------------

--
-- Estrutura para tabela `doencas`
--

CREATE TABLE `doencas` (
  `id_dado` int(5) NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `doenca` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `doencas`
--

INSERT INTO `doencas` (`id_dado`, `id_usuario`, `doenca`) VALUES
(8, 6, 'teste'),
(10, 6, 'pressão alta'),
(11, 142, 'fgs'),
(12, 142, 'fgs'),
(13, 143, 'aaaaaaaaaaaaa'),
(14, 143, 'aaaaaaaaaaaaa'),
(15, 143, 'aaaaaaaaaaaaa'),
(16, 143, 'aaaaaaaaaaaaa'),
(17, 143, 'aaaaaaaaaaaaa'),
(18, 3, 'ss'),
(19, 3, 'ss'),
(20, 3, 'ss'),
(21, 3, 'ss'),
(22, 3, 'ss'),
(23, 3, 'ss'),
(24, 3, 'ss'),
(25, 3, 'ss'),
(26, 3, 'ss'),
(32, 1, 'aaa');

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `id` int(10) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `local` varchar(100) NOT NULL,
  `data` varchar(8) NOT NULL,
  `horario` varchar(5) NOT NULL,
  `descricao` varchar(500) NOT NULL,
  `img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id`, `nome`, `local`, `data`, `horario`, `descricao`, `img`) VALUES
(1, 'teste', 'rua lalalaa, 86', '21/08/20', '12:00', 'slaaaaaaa', ''),
(2, 'teste 2', 'rua peipeipei,953', '204/09/2', '12:00', 'pago', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `informacoes`
--

CREATE TABLE `informacoes` (
  `id_dado` int(5) NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `sangue` varchar(3) NOT NULL,
  `cartao` varchar(20) NOT NULL,
  `historico` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `informacoes`
--

INSERT INTO `informacoes` (`id_dado`, `id_usuario`, `foto`, `nome`, `sangue`, `cartao`, `historico`) VALUES
(9, 6, './img/DSCF5772.JPG', 'Nicole Camile Martins  Torres', 'A+', '17000', '                                                                                                    ok                                                                             '),
(12, 8, './img/DSCF5770.JPG', 'Lincon Matheus Borges Correa', 'O-', '123', ''),
(13, 142, './img/images.jpeg', 'teste', 'A+', '15415014', '                                                            dssb                                    '),
(14, 142, './img/IFSP-Wallpaper-1920x1080.png', 'teste', 'A+', '15415014', 'dssb'),
(15, 143, './img/images.jpeg', 'Nicole Camile Martins Torres', 'A+', '524757850700', '                                                  aaaaaaaaaaaaaoiiiiiiiiiiiiaaaaaaaaaaa                              '),
(16, 143, './img/images.jpeg', 'Nicole Camile Martins Torres', 'AB+', '52475785', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(17, 143, './img/images.jpeg', 'Nicole Camile Martins Torres', 'AB+', '52475785', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(18, 143, './img/images.jpeg', 'Nicole Camile Martins Torres', 'AB+', '52475785', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(19, 143, './img/images.jpeg', 'Nicole Camile Martins Torres', 'AB+', '52475785', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),
(20, 3, './img/images.jpeg', 'teste', 'A+', 'sss', 'sss'),
(21, 3, './img/images.jpeg', 'teste', 'A+', 'sss', 'sss'),
(22, 3, './img/images.jpeg', 'teste', 'A+', 'sss', 'sss'),
(23, 3, './img/images.jpeg', 'teste', 'A+', 'sss', 'sss'),
(24, 3, './img/images.jpeg', 'teste', 'A+', 'sss', 'sss'),
(25, 3, './img/images.jpeg', 'teste', 'A+', 'sss', 'sss'),
(26, 3, './img/images.jpeg', 'teste', 'A+', 'sss', 'sss'),
(27, 3, './img/images.jpeg', 'teste', 'A+', 'sss', 'sss'),
(28, 3, './img/images.jpeg', 'teste', 'A+', 'sss', 'sss'),
(29, 1, './img/Sem título.jpeg', 'testeeee', 'A+', 'aaddddsssssdd', '                                                                                                                                                     aaaaaaappssssaaaaaaasssssspoiiii                                                                                    ');

-- --------------------------------------------------------

--
-- Estrutura para tabela `login`
--

CREATE TABLE `login` (
  `cpf_cad` varchar(14) NOT NULL,
  `senha` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `medicamentos`
--

CREATE TABLE `medicamentos` (
  `id_dado` int(5) NOT NULL,
  `id_usuario` int(5) NOT NULL,
  `medicamento` varchar(30) NOT NULL,
  `dose` varchar(15) NOT NULL,
  `horario` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `medicamentos`
--

INSERT INTO `medicamentos` (`id_dado`, `id_usuario`, `medicamento`, `dose`, `horario`) VALUES
(1, 6, 'anticoncepcional', '1 comprimido', '23:00'),
(6, 142, 'dss', 'sds', 'gsgf'),
(7, 142, 'dss', 'sds', 'gsgf'),
(8, 143, 'aaaaaaaa', 'aaaaaaa', '12:00'),
(9, 143, 'aaaaaaaa', 'aaaaaaa', '12:00'),
(10, 143, 'aaaaaaaa', 'aaaaaaa', '12:00'),
(11, 143, 'aaaaaaaa', 'aaaaaaa', '12:00'),
(12, 143, 'aaaaaaaa', 'aaaaaaa', '12:00'),
(16, 3, 'sss', 'sss', '04:51'),
(17, 3, 'sss', 'sss', '04:51'),
(18, 3, 'sss', 'sss', '04:51'),
(19, 3, 'sss', 'sss', '04:51'),
(20, 3, 'sss', 'sss', '04:51'),
(21, 3, 'sss', 'sss', '04:51'),
(26, 1, 'qqq', 'qqq', '10:00');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alergias`
--
ALTER TABLE `alergias`
  ADD PRIMARY KEY (`id_dado`),
  ADD KEY `fk_alergias_usuario` (`id_usuario`);

--
-- Índices de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_voluntario` (`id_voluntario`);

--
-- Índices de tabela `cadastro`
--
ALTER TABLE `cadastro`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cadastro_eventos`
--
ALTER TABLE `cadastro_eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cadastro_voluntarios`
--
ALTER TABLE `cadastro_voluntarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_voluntario` (`id_voluntario`);

--
-- Índices de tabela `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id_dado`),
  ADD KEY `fk_consultas_usuario` (`id_usuario`);

--
-- Índices de tabela `contatos`
--
ALTER TABLE `contatos`
  ADD PRIMARY KEY (`id_dado`),
  ADD KEY `fk_contatos_usuario` (`id_usuario`);

--
-- Índices de tabela `doencas`
--
ALTER TABLE `doencas`
  ADD PRIMARY KEY (`id_dado`),
  ADD KEY `fk_doencas_usuario` (`id_usuario`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `informacoes`
--
ALTER TABLE `informacoes`
  ADD PRIMARY KEY (`id_dado`),
  ADD KEY `fk_informacoes_usuario` (`id_usuario`);

--
-- Índices de tabela `login`
--
ALTER TABLE `login`
  ADD UNIQUE KEY `cpf_cad` (`cpf_cad`);

--
-- Índices de tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  ADD PRIMARY KEY (`id_dado`),
  ADD KEY `fk_medicamentos_usuario` (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alergias`
--
ALTER TABLE `alergias`
  MODIFY `id_dado` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `avaliacoes`
--
ALTER TABLE `avaliacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT de tabela `cadastro`
--
ALTER TABLE `cadastro`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `cadastro_eventos`
--
ALTER TABLE `cadastro_eventos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `cadastro_voluntarios`
--
ALTER TABLE `cadastro_voluntarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

--
-- AUTO_INCREMENT de tabela `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=238;

--
-- AUTO_INCREMENT de tabela `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id_dado` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `contatos`
--
ALTER TABLE `contatos`
  MODIFY `id_dado` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `doencas`
--
ALTER TABLE `doencas`
  MODIFY `id_dado` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `informacoes`
--
ALTER TABLE `informacoes`
  MODIFY `id_dado` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `medicamentos`
--
ALTER TABLE `medicamentos`
  MODIFY `id_dado` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `avaliacoes`
--
ALTER TABLE `avaliacoes`
  ADD CONSTRAINT `avaliacoes_ibfk_1` FOREIGN KEY (`id_voluntario`) REFERENCES `cadastro_voluntarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
