/*
  Arquivo: petshop.sql
  Atribuído para: Apresentador 2
  Descrição geral: Este arquivo faz parte do site. Abaixo há comentários detalhados sobre as responsabilidades e o que cada bloco de código faz.
*/

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/09/2025 às 14:49
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `petshop`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `pets`
--

CREATE TABLE `pets` (
  `id` int(11) NOT NULL,
  `animal` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `raca` varchar(100) NOT NULL,
  `porte` varchar(100) NOT NULL,
  `idade` int(11) NOT NULL,
  `sexo` varchar(100) NOT NULL,
  `castrado` varchar(100) NOT NULL,
  `observacao` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pets`
--

INSERT INTO `pets` (`id`, `animal`, `nome`, `raca`, `porte`, `idade`, `sexo`, `castrado`, `observacao`) VALUES
(1, 'Cachorro', 'Dora Alice', 'SRD', 'Médio', 'Nove anos', 'Fêmea', 'Sim', 'Querida, doce, mas medrosa'),
(2, 'Cachorro', 'Shakira', 'SRD', 'Grande', 'Dezoito Anos', 'Fêmea', 'Não', 'Receosa, educada, obediente.'),
(3, 'Cachorro', 'Godzilla', 'SRD', 'Grande', 'Doze anos', 'Macho', 'Sim', 'Mimoso, simpático'),
(4, 'Cachorro', 'Nina', 'Pitbull', 'Grande', 'Um ano', 'Fêmea', 'Não', 'Brincalhona, esperta, dócil'),
(5, 'Gato', 'Mel', 'SRD', 'Pequeno', 'Cinco anos', 'Fêmea', 'Sim', 'Mansa, caseira, calma');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `pets`
--
ALTER TABLE `pets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO usuarios (nome, email, senha_hash)
VALUES (
  'Admin',
  'admin@petshop.com',
  '$2y$10$Zxg7/RjHtFZ64IymrA/JHukM5H3w4r3J3eHc4rgrHfPjNqzngdKWS'
);
-- senha: senha123

-- ADICIONANDO TABELA admins, coluna imagem em pets e pedidos
CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE pets ADD COLUMN IF NOT EXISTS imagem VARCHAR(255) DEFAULT NULL;

CREATE TABLE IF NOT EXISTS pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  pet_id INT NOT NULL,
  status VARCHAR(50) DEFAULT 'pendente',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
);
-- Obs: insira um admin manualmente usando password_hash em PHP ou via phpMyAdmin.

-- Atualização: adicionar colunas de contato na tabela pedidos
ALTER TABLE pedidos ADD COLUMN IF NOT EXISTS nome VARCHAR(200) DEFAULT NULL;
ALTER TABLE pedidos ADD COLUMN IF NOT EXISTS endereco VARCHAR(300) DEFAULT NULL;
ALTER TABLE pedidos ADD COLUMN IF NOT EXISTS telefone VARCHAR(80) DEFAULT NULL;
-- Status values: pendente, aprovado, recusado


-- ==== Atualização / criação das tabelas necessárias ====
-- Tabela pedidos (recria ou ajusta). Antes de rodar, faça backup se quiser.
CREATE TABLE IF NOT EXISTS pedidos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NULL,
  pet_id INT NOT NULL,
  status VARCHAR(50) DEFAULT 'pendente',
  nome VARCHAR(200) DEFAULT NULL,
  endereco VARCHAR(300) DEFAULT NULL,
  telefone VARCHAR(80) DEFAULT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT pedidos_ibfk_1 FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE SET NULL,
  CONSTRAINT pedidos_ibfk_2 FOREIGN KEY (pet_id) REFERENCES pets(id) ON DELETE CASCADE
);

-- Garante que usuario_id aceite NULL (tanto faz se já existir ou não)
ALTER TABLE pedidos MODIFY usuario_id INT NULL;

-- Cria tabela admins se não existir
CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insere um admin de exemplo (senha: admin123) se não existir
INSERT INTO admins (nome, email, senha_hash)
SELECT 'Administrador', 'admin@petshop.com', '$2y$10$JcL4kS0dT0QkMNOdIYliOOd2tyYrh5dtOj6/mRmlAQyMzX2aPPmWO'
WHERE NOT EXISTS (SELECT 1 FROM admins WHERE email = 'admin@petshop.com');
-- senha: admin123

-- Observação: importe esse SQL via phpMyAdmin para aplicar as alterações necessárias.
