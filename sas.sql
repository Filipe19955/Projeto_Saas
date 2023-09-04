-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/09/2023 às 21:48
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `acessos`
--

CREATE TABLE `acessos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `chave` varchar(50) NOT NULL,
  `grupo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `acessos`
--

INSERT INTO `acessos` (`id`, `nome`, `chave`, `grupo`) VALUES
(1, 'Home', 'home', 0),
(2, 'Clientes', 'clientes', 2),
(3, 'Usuários', 'usuarios', 2),
(4, 'Funcionários', 'funcionarios', 2),
(5, 'Fornecedores', 'fornecedores', 2),
(6, 'Cargos', 'cargos', 3),
(7, 'Frequências', 'frequencias', 3),
(8, 'Caixas', 'caixas', 3),
(9, 'Formas Pgto', 'formas_pgto', 3),
(10, 'Categorias', 'categorias', 4),
(11, 'Produtos', 'produtos', 4),
(12, 'Entradas', 'entradas', 4),
(13, 'Saídas', 'saidas', 4),
(14, 'Estoque', 'estoque', 4),
(15, 'Trocas', 'trocas', 4),
(16, 'Contas à Receber', 'receber', 5),
(17, 'Despesas', 'pagar', 5),
(18, 'Compras', 'compras', 5),
(19, 'Vendas', 'vendas', 5),
(20, 'Fluxo de Caixa', 'fluxo', 5),
(21, 'Comissões', 'comissoes', 5),
(22, 'Relatório de Vendas', 'rel_vendas', 6),
(23, 'Relatório de Clientes', 'rel_clientes', 6),
(24, 'Relatório de Recebimentos', 'rel_recebimentos', 6),
(25, 'Relatório de Despesas', 'rel_despesas', 6),
(26, 'Relatório de Lucro', 'rel_lucro', 6),
(27, 'Relatório de Produtos', 'rel_produtos', 6),
(28, 'Relatório de Estoque', 'rel_estoque', 6),
(29, 'Relatório de Entrada/Saída', 'rel_entradas_saidas', 6),
(30, 'Relatório de Caixas', 'rel_caixas', 6),
(31, 'Relatório de Comissões', 'rel_comissoes', 6),
(32, 'Caixa PDV', 'abertura', 0),
(33, 'Minhas Comissões', 'minhas_comissoes', 0),
(34, 'Configurações', 'config', 0),
(35, 'Relatório de Trocas', 'rel_trocas', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `arquivos`
--

CREATE TABLE `arquivos` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `tipo` varchar(25) NOT NULL,
  `usuario` int(11) NOT NULL,
  `data_cad` date NOT NULL,
  `data_validade` date DEFAULT NULL,
  `foto` varchar(100) NOT NULL,
  `id_ref` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `caixa`
--

CREATE TABLE `caixa` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `data_ab` date NOT NULL,
  `hora_ab` time NOT NULL,
  `valor_ab` decimal(8,2) NOT NULL,
  `gerente_ab` int(11) NOT NULL,
  `data_fec` date DEFAULT NULL,
  `hora_fec` time DEFAULT NULL,
  `valor_fec` decimal(8,2) DEFAULT NULL,
  `valor_vendido` decimal(8,2) DEFAULT NULL,
  `valor_quebra` decimal(8,2) DEFAULT NULL,
  `gerente_fec` int(11) DEFAULT NULL,
  `caixa` int(11) NOT NULL,
  `operador` int(11) DEFAULT NULL,
  `status` varchar(35) DEFAULT NULL,
  `valor_sangrias` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `caixa`
--

INSERT INTO `caixa` (`id`, `empresa`, `data_ab`, `hora_ab`, `valor_ab`, `gerente_ab`, `data_fec`, `hora_fec`, `valor_fec`, `valor_vendido`, `valor_quebra`, `gerente_fec`, `caixa`, `operador`, `status`, `valor_sangrias`) VALUES
(22, 18, '2023-09-04', '16:46:44', 100.00, 37, NULL, NULL, NULL, NULL, NULL, NULL, 9, 37, 'Aberto', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `caixas`
--

CREATE TABLE `caixas` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `empresa` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `caixas`
--

INSERT INTO `caixas` (`id`, `nome`, `empresa`, `status`, `usuario`) VALUES
(9, 'teste', 18, 'Aberto', 37);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cargos`
--

CREATE TABLE `cargos` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `nome` varchar(35) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `cargos`
--

INSERT INTO `cargos` (`id`, `empresa`, `nome`) VALUES
(31, 17, 'Gerente'),
(32, 17, 'Vendedor'),
(33, 18, 'Administrador'),
(34, 18, 'Gerente'),
(35, 18, 'Vendedor');

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `ativo` varchar(5) NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `cat_grade`
--

CREATE TABLE `cat_grade` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `comissoes`
--

CREATE TABLE `comissoes` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `data_lanc` date NOT NULL,
  `data_pgto` date DEFAULT NULL,
  `usuario_lanc` int(11) NOT NULL,
  `usuario_pgto` int(11) DEFAULT NULL,
  `id_ref` int(11) NOT NULL,
  `vendedor` int(11) NOT NULL,
  `pago` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `nome_sistema` varchar(50) NOT NULL,
  `telefone_sistema` varchar(20) DEFAULT NULL,
  `email_sistema` varchar(50) DEFAULT NULL,
  `tipo_rel` varchar(5) NOT NULL,
  `dias_bloqueio` int(11) NOT NULL,
  `msg_bloqueio` varchar(255) DEFAULT NULL,
  `foto_rel` varchar(100) DEFAULT NULL,
  `tipo_desconto` varchar(20) DEFAULT NULL,
  `comissao` int(11) NOT NULL,
  `endereco_sistema` varchar(100) DEFAULT NULL,
  `cnpj_sistema` varchar(25) DEFAULT NULL,
  `teste` varchar(5) NOT NULL,
  `dias_teste` int(11) NOT NULL,
  `horario_mensagens` time NOT NULL,
  `data` date DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `config`
--

INSERT INTO `config` (`id`, `empresa`, `nome_sistema`, `telefone_sistema`, `email_sistema`, `tipo_rel`, `dias_bloqueio`, `msg_bloqueio`, `foto_rel`, `tipo_desconto`, `comissao`, `endereco_sistema`, `cnpj_sistema`, `teste`, `dias_teste`, `horario_mensagens`, `data`, `token`) VALUES
(11, 0, 'Sistema de Vendas', NULL, NULL, 'PDF', 0, NULL, NULL, NULL, 0, NULL, NULL, 'Sim', 3, '00:00:00', NULL, NULL),
(12, 18, 'Sistema de Vendas', NULL, NULL, 'PDF', 0, NULL, 'logo-rel.jpg', '%', 0, NULL, NULL, '', 0, '00:00:00', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `contratos`
--

CREATE TABLE `contratos` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `texto` text NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `detalhes_grade`
--

CREATE TABLE `detalhes_grade` (
  `id` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `id_ref` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `cat_grade` int(11) DEFAULT NULL,
  `itens_grade` int(11) DEFAULT NULL,
  `cat_grade2` int(11) DEFAULT NULL,
  `itens_grade2` int(11) DEFAULT NULL,
  `tipo` varchar(20) NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `empresas`
--

CREATE TABLE `empresas` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `cnpj` varchar(20) DEFAULT NULL,
  `ativo` varchar(5) NOT NULL,
  `data_cad` date DEFAULT NULL,
  `data_pgto` date DEFAULT NULL,
  `valor` decimal(8,2) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `teste` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `empresas`
--

INSERT INTO `empresas` (`id`, `nome`, `telefone`, `email`, `cpf`, `cnpj`, `ativo`, `data_cad`, `data_pgto`, `valor`, `endereco`, `teste`) VALUES
(18, 'Empresa Teste', '(00)00000-0000', 'teste@hotmail.com', NULL, NULL, 'Sim', '2023-09-04', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `entradas`
--

CREATE TABLE `entradas` (
  `id` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `usuario` int(11) NOT NULL,
  `data` date NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `forma_pgtos`
--

CREATE TABLE `forma_pgtos` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `acrescimo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `forma_pgtos`
--

INSERT INTO `forma_pgtos` (`id`, `empresa`, `nome`, `acrescimo`) VALUES
(11, 18, 'Dinheiro', 0),
(12, 18, 'Parcelado', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `fornecedores`
--

CREATE TABLE `fornecedores` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `data` date NOT NULL,
  `pessoa` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `frequencias`
--

CREATE TABLE `frequencias` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `frequencia` varchar(30) NOT NULL,
  `dias` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `frequencias`
--

INSERT INTO `frequencias` (`id`, `empresa`, `frequencia`, `dias`) VALUES
(23, 18, 'Nenhuma', 0),
(24, 18, 'Mensal', 30);

-- --------------------------------------------------------

--
-- Estrutura para tabela `grupo_acessos`
--

CREATE TABLE `grupo_acessos` (
  `id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `grupo_acessos`
--

INSERT INTO `grupo_acessos` (`id`, `nome`) VALUES
(2, 'Pessoas'),
(3, 'Cadastros'),
(4, 'Produtos'),
(5, 'Financeiro'),
(6, 'Relatórios');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_grade`
--

CREATE TABLE `itens_grade` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `cat_grade` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `estoque` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_venda`
--

CREATE TABLE `itens_venda` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `valor_unitario` decimal(8,2) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `venda` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagar`
--

CREATE TABLE `pagar` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `pessoa` int(11) DEFAULT NULL,
  `valor` decimal(8,2) NOT NULL,
  `data_lanc` date NOT NULL,
  `data_venc` date DEFAULT NULL,
  `data_pgto` date DEFAULT NULL,
  `usuario_lanc` int(11) NOT NULL,
  `usuario_pgto` int(11) DEFAULT NULL,
  `frequencia` int(11) NOT NULL,
  `saida` varchar(50) DEFAULT NULL,
  `arquivo` varchar(100) NOT NULL,
  `pago` varchar(5) NOT NULL,
  `id_ref` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `estoque` int(11) DEFAULT NULL,
  `valor_venda` decimal(8,2) DEFAULT NULL,
  `valor_compra` decimal(8,2) DEFAULT NULL,
  `lucro` decimal(8,2) DEFAULT NULL,
  `fornecedor` int(11) NOT NULL,
  `categoria` int(11) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `ativo` varchar(5) NOT NULL,
  `empresa` int(11) NOT NULL,
  `nivel_estoque` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `receber`
--

CREATE TABLE `receber` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `descricao` varchar(50) DEFAULT NULL,
  `pessoa` int(11) DEFAULT NULL,
  `valor` decimal(8,2) NOT NULL,
  `data_lanc` date NOT NULL,
  `data_venc` date DEFAULT NULL,
  `data_pgto` date DEFAULT NULL,
  `usuario_lanc` int(11) NOT NULL,
  `usuario_pgto` int(11) DEFAULT NULL,
  `frequencia` int(11) NOT NULL,
  `saida` varchar(50) DEFAULT NULL,
  `arquivo` varchar(100) NOT NULL,
  `pago` varchar(5) NOT NULL,
  `id_ref` int(11) DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `valor_recebido` decimal(8,2) DEFAULT NULL,
  `troco` decimal(8,2) DEFAULT NULL,
  `desconto` decimal(8,2) DEFAULT NULL,
  `acrescimo` int(11) DEFAULT NULL,
  `vendedor` int(11) DEFAULT NULL,
  `garantia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `saidas`
--

CREATE TABLE `saidas` (
  `id` int(11) NOT NULL,
  `produto` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `motivo` varchar(255) NOT NULL,
  `usuario` int(11) NOT NULL,
  `data` date NOT NULL,
  `empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `sangrias`
--

CREATE TABLE `sangrias` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `valor` decimal(8,2) NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `usuario` int(11) NOT NULL,
  `caixa` int(11) NOT NULL,
  `id_caixa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `trocas`
--

CREATE TABLE `trocas` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `produto_saida` int(11) NOT NULL,
  `produto_entrada` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `cliente` int(11) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `empresa` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cpf` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `senha` varchar(25) NOT NULL,
  `senha_crip` varchar(100) NOT NULL,
  `endereco` varchar(100) DEFAULT NULL,
  `ativo` varchar(5) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `nivel` varchar(50) NOT NULL,
  `data` date DEFAULT NULL,
  `comissao` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `empresa`, `nome`, `telefone`, `cpf`, `email`, `senha`, `senha_crip`, `endereco`, `ativo`, `foto`, `nivel`, `data`, `comissao`) VALUES
(36, 0, 'Administrador SAS', NULL, '000.000.000-00', 'teste@gmail.com', '123', '202cb962ac59075b964b07152d234b70', NULL, 'Sim', 'sem-foto.jpg', 'SAS', '2023-09-04', NULL),
(37, 18, 'Administrador', NULL, '111.111.111-11', 'teste@hotmail.com', '123', '202cb962ac59075b964b07152d234b70', NULL, 'Sim', 'sem-foto.jpg', 'Administrador', '2023-09-04', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios_permissoes`
--

CREATE TABLE `usuarios_permissoes` (
  `id` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `permissao` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `acessos`
--
ALTER TABLE `acessos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `arquivos`
--
ALTER TABLE `arquivos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `caixa`
--
ALTER TABLE `caixa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `caixas`
--
ALTER TABLE `caixas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `cat_grade`
--
ALTER TABLE `cat_grade`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `comissoes`
--
ALTER TABLE `comissoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `contratos`
--
ALTER TABLE `contratos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `detalhes_grade`
--
ALTER TABLE `detalhes_grade`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `empresas`
--
ALTER TABLE `empresas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `entradas`
--
ALTER TABLE `entradas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `forma_pgtos`
--
ALTER TABLE `forma_pgtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `frequencias`
--
ALTER TABLE `frequencias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `grupo_acessos`
--
ALTER TABLE `grupo_acessos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itens_grade`
--
ALTER TABLE `itens_grade`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pagar`
--
ALTER TABLE `pagar`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `receber`
--
ALTER TABLE `receber`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `saidas`
--
ALTER TABLE `saidas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `sangrias`
--
ALTER TABLE `sangrias`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `trocas`
--
ALTER TABLE `trocas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuarios_permissoes`
--
ALTER TABLE `usuarios_permissoes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `acessos`
--
ALTER TABLE `acessos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `arquivos`
--
ALTER TABLE `arquivos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `caixa`
--
ALTER TABLE `caixa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de tabela `caixas`
--
ALTER TABLE `caixas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `cat_grade`
--
ALTER TABLE `cat_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `comissoes`
--
ALTER TABLE `comissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de tabela `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `contratos`
--
ALTER TABLE `contratos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `detalhes_grade`
--
ALTER TABLE `detalhes_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT de tabela `empresas`
--
ALTER TABLE `empresas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `entradas`
--
ALTER TABLE `entradas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de tabela `forma_pgtos`
--
ALTER TABLE `forma_pgtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `fornecedores`
--
ALTER TABLE `fornecedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `frequencias`
--
ALTER TABLE `frequencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de tabela `grupo_acessos`
--
ALTER TABLE `grupo_acessos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `itens_grade`
--
ALTER TABLE `itens_grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de tabela `itens_venda`
--
ALTER TABLE `itens_venda`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=225;

--
-- AUTO_INCREMENT de tabela `pagar`
--
ALTER TABLE `pagar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `receber`
--
ALTER TABLE `receber`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT de tabela `saidas`
--
ALTER TABLE `saidas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `sangrias`
--
ALTER TABLE `sangrias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `trocas`
--
ALTER TABLE `trocas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de tabela `usuarios_permissoes`
--
ALTER TABLE `usuarios_permissoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=158;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
