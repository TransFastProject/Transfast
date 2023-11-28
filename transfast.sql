-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para transfast
CREATE DATABASE IF NOT EXISTS `transfast`;
USE `transfast`;

-- Copiando estrutura para tabela transfast.motorista
CREATE TABLE IF NOT EXISTS `motorista` (
  `moto_cpf` varchar(14) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` varchar(300) NOT NULL,
  `genero` varchar(9) DEFAULT NULL,
  `telefone` varchar(16) NOT NULL,
  `data_nascimento` varchar(10) NOT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `rua` varchar(30) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `numero` varchar(5) DEFAULT NULL,
  `complemento` varchar(20) DEFAULT NULL,
  `foto` longblob,
  PRIMARY KEY (`moto_cpf`)
);

-- Copiando dados para a tabela transfast.motorista: ~2 rows (aproximadamente)
INSERT INTO `motorista` (`moto_cpf`, `nome`, `email`, `senha`, `genero`, `telefone`, `data_nascimento`, `cep`, `rua`, `bairro`, `numero`, `complemento`, `foto`) VALUES
	('inexistente', 'inexistente', 'inexistente', '1234', 'inexistente', 'inexistente', '2000-02-02', '0', 'inexistente', 'inexistente', '00', NULL, NULL);

-- Copiando estrutura para tabela transfast.responsavel
CREATE TABLE IF NOT EXISTS `responsavel` (
  `res_cpf` varchar(14) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` varchar(300) NOT NULL,
  `genero` varchar(9) NOT NULL,
  `telefone` varchar(16) NOT NULL,
  `data_nascimento` varchar(10) NOT NULL,
  `cep` varchar(9) DEFAULT NULL,
  `rua` varchar(30) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `numero` varchar(5) DEFAULT NULL,
  `complemento` varchar(20) DEFAULT NULL,
  `foto` longblob,
  PRIMARY KEY (`res_cpf`)
);

-- Copiando dados para a tabela transfast.responsavel: ~2 rows (aproximadamente)
INSERT INTO `responsavel` (`res_cpf`, `nome`, `email`, `senha`, `genero`, `telefone`, `data_nascimento`, `cep`, `rua`, `bairro`, `numero`, `complemento`) VALUES
	('000.000.000-00', 'Sem Dados', 'SemDados@gmail.com', '123456', 'Sem Dados', '00 00000-0000', '0000-00-00', '00000-000', 'Sem Dados', 'Sem Dados', '00', NULL);

-- Copiando estrutura para tabela transfast.transporte
CREATE TABLE IF NOT EXISTS `transporte` (
  `trans_id` int NOT NULL AUTO_INCREMENT,
  `moto_cpf` varchar(14) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `monitor` varchar(100) DEFAULT NULL,
  `placa` varchar(10) NOT NULL,
  `n_assentos` int NOT NULL,
  `estado` varchar(20) NOT NULL,
  `cidade` varchar(20) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `nota` int DEFAULT NULL,
  `foto` longblob,
  PRIMARY KEY (`trans_id`),
  KEY `moto_cpf` (`moto_cpf`),
  FOREIGN KEY (`moto_cpf`) REFERENCES `motorista` (`moto_cpf`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Copiando dados para a tabela transfast.transporte: ~2 rows (aproximadamente)
INSERT INTO `transporte` (`trans_id`, `moto_cpf`, `nome`, `monitor`, `placa`, `n_assentos`, `estado`, `cidade`, `cep`, `bairro`, `nota`) VALUES
	(1, 'inexistente', 'inexistente', 'inexistente', 'ghd-2310', 15, 'indefinido', 'indefinido', '22000', 'indefinido', 0);

-- Copiando estrutura para tabela transfast.crianca
CREATE TABLE IF NOT EXISTS `crianca` (
  `cria_id` int NOT NULL AUTO_INCREMENT,
  `res_cpf` varchar(14) NOT NULL,
  `trans_id` int NOT NULL,
  `nome` varchar(30) NOT NULL,
  `idade` int NOT NULL,
  `genero` varchar(10) NOT NULL,
  `data_nascimento` varchar(10) NOT NULL,
  `escola` varchar(20) NOT NULL,
  `deficiencia` varchar(20) NOT NULL,
  `presenca` varchar(8) DEFAULT NULL,
  `valor` decimal(7,2) DEFAULT NULL,
  `foto` longblob,
  PRIMARY KEY (`cria_id`),
  KEY `res_cpf` (`res_cpf`),
  KEY `trans_id` (`trans_id`),
  FOREIGN KEY (`res_cpf`) REFERENCES `responsavel` (`res_cpf`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`trans_id`) REFERENCES `transporte` (`trans_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Copiando dados para a tabela transfast.crianca: ~3 rows (aproximadamente)
INSERT INTO `crianca` (`cria_id`, `res_cpf`, `trans_id`, `nome`, `idade`, `genero`, `data_nascimento`, `escola`, `deficiencia`, `presenca`, `valor`) VALUES
	(1, '000.000.000-00', 1, 'Sem Dados', 0, 'Sem Dados', '0000-00-00', 'Sem Dados', 'visual','ausente',' 0.00'),
	(2, '200.200.200-20', 1, 'samantha', 6, 'feminino', '2005-02-05', 'josefina pereira','cognitiva', 'presente', 100.00),
	(3, '200.200.200-20', 1, 'samantha', 6, 'feminino', '2005-02-05', 'josefina pereira','tetraplegico', 'presente', 150.00);

CREATE TABLE IF NOT EXISTS `gastos` (
	`gastos_id` INT(10) NOT NULL AUTO_INCREMENT,
	`moto_cpf` VARCHAR(14) NOT NULL,
	`data_compra` VARCHAR(10) NOT NULL,
	`mes` VARCHAR(50) NOT NULL,
	`produtos` VARCHAR(200) NOT NULL,
	`valor` DECIMAL(7,2) NOT NULL,
	PRIMARY KEY (`gastos_id`),
	KEY `moto_cpf` (`moto_cpf`),
  FOREIGN KEY (`moto_cpf`) REFERENCES `motorista` (`moto_cpf`) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO `gastos` (`gastos_id`, `moto_cpf`, `data_compra`, `mes`, `produtos`, `valor`) VALUES 
(1, '12', '10/08/2022', 'janeiro', 'diesel, bateria', '350'),
(2, '12', '15/08/2012', 'fevereiro', 'diesel, bateria', '550'),
(3, '12', '18/08/2022', 'março', 'diesel, bateria', '850');

CREATE TABLE IF NOT EXISTS `verificacao` (
  `ver_id` int NOT NULL AUTO_INCREMENT,
  `cria_id` int NOT NULL,
  `janeiro` varchar(50) DEFAULT NULL,
  `fevereiro` varchar(50) DEFAULT NULL,
  `marco` varchar(50) DEFAULT NULL,
  `abril` varchar(50) DEFAULT NULL,
  `maio` varchar(50) DEFAULT NULL,
  `junho` varchar(50) DEFAULT NULL,
  `julho` varchar(50) DEFAULT NULL,
  `agosto` varchar(50) DEFAULT NULL,
  `setembro` varchar(50) DEFAULT NULL,
  `outubro` varchar(50) DEFAULT NULL,
  `novembro` varchar(50) DEFAULT NULL,
  `dezembro` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ver_id`),
  KEY `cria_id` (`cria_id`),
  FOREIGN KEY (`cria_id`) REFERENCES `crianca` (`cria_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `vistoria` (
  `moto_cpf` varchar(14) NOT NULL,
  `item01` varchar(5) DEFAULT NULL,
  `item02` varchar(5) DEFAULT NULL,
  `item03` varchar(5) DEFAULT NULL,
  `item04` varchar(5) DEFAULT NULL,
  `item05` varchar(5) DEFAULT NULL,
  `item06` varchar(5) DEFAULT NULL,
  `item07` varchar(5) DEFAULT NULL,
  `item08` varchar(5) DEFAULT NULL,
  `item09` varchar(5) DEFAULT NULL,
  `item10` varchar(5) DEFAULT NULL,
  FOREIGN KEY (`moto_cpf`) REFERENCES `motorista` (`moto_cpf`) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `chat`(
  `chat_id` INTEGER NOT NULL AUTO_INCREMENT,
  `moto_cpf` VARCHAR(14) NOT NULL,
  `res_cpf` VARCHAR(14) NOT NULL,
  `nome` VARCHAR(500) NOT NULL,
  `mensagem` VARCHAR(500) NOT NULL,
  PRIMARY KEY (`chat_id`),
  FOREIGN KEY (`moto_cpf`) REFERENCES `motorista` (`moto_cpf`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`res_cpf`) REFERENCES `responsavel` (`res_cpf`) ON DELETE CASCADE ON UPDATE CASCADE
);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
