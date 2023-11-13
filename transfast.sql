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
  `senha` varchar(150) NOT NULL,
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
	('12', 'Gabriel', 'gabriel12far@gmail.com', '$2y$10$2Tr7WQOsO3453jvLZIFK1eYQfIIFdZGLoljNbLV5sBMyoIUMIkOaa', NULL, '123456', '2023-10-19', '121', '1212', '12', '12', '12', NULL),
	('inexistente', 'inexistente', 'inexistente', '1234', 'inexisten', 'inexistente', '2000-02-02', '0', 'inexistente', 'inexistente', '00', NULL, NULL);

-- Copiando estrutura para tabela transfast.responsavel
CREATE TABLE IF NOT EXISTS `responsavel` (
  `res_cpf` varchar(14) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `genero` varchar(9) NOT NULL,
  `telefone` varchar(16) NOT NULL,
  `data_nascimento` varchar(10) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `rua` varchar(30) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `numero` varchar(5) NOT NULL,
  `complemento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`res_cpf`)
);

-- Copiando dados para a tabela transfast.responsavel: ~2 rows (aproximadamente)
INSERT INTO `responsavel` (`res_cpf`, `nome`, `email`, `senha`, `genero`, `telefone`, `data_nascimento`, `cep`, `rua`, `bairro`, `numero`, `complemento`) VALUES
	('000.000.000-00', 'Sem Dados', 'SemDados@gmail.com', '123456', 'Sem Dados', '00 00000-0000', '0000-00-00', '00000-000', 'Sem Dados', 'Sem Dados', '00', NULL),
	('200.200.200-20', 'Paulão', 'paulãorubbens@gmail.com', '12abc', 'masculino', '11 97865-0000', '1900-02-02', '6504', 'rua alameda caramba', 'caramba', '23A', NULL);

-- Copiando estrutura para tabela transfast.transporte
CREATE TABLE IF NOT EXISTS `transporte` (
  `trans_id` int NOT NULL AUTO_INCREMENT,
  `moto_cpf` varchar(14) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `placa` varchar(10) NOT NULL,
  `n_assentos` int NOT NULL,
  `estado` varchar(20) NOT NULL,
  `cidade` varchar(20) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `nota` int DEFAULT NULL,
  PRIMARY KEY (`trans_id`),
  KEY `moto_cpf` (`moto_cpf`),
  FOREIGN KEY (`moto_cpf`) REFERENCES `motorista` (`moto_cpf`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Copiando dados para a tabela transfast.transporte: ~2 rows (aproximadamente)
INSERT INTO `transporte` (`trans_id`, `moto_cpf`, `nome`, `placa`, `n_assentos`, `estado`, `cidade`, `cep`, `bairro`, `nota`) VALUES
	(1, 'inexistente', 'tia souza', 'ghd-2310', 15, 'indefinido', 'indefinido', '22000', 'indefinido', 0),
	(2, '12', 'Gabriel Araujo', '23', 12, '12', '12', '12', '12', NULL);

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
  `tipo_sanguineo` varchar(3) NOT NULL,
  `alergias` varchar(30) NOT NULL,
  `peso` varchar(6) NOT NULL,
  `medicamentos` varchar(30) DEFAULT NULL,
  `valor` decimal(7,2) NOT NULL,
  PRIMARY KEY (`cria_id`),
  KEY `res_cpf` (`res_cpf`),
  KEY `trans_id` (`trans_id`),
  FOREIGN KEY (`res_cpf`) REFERENCES `responsavel` (`res_cpf`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`trans_id`) REFERENCES `transporte` (`trans_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Copiando dados para a tabela transfast.crianca: ~3 rows (aproximadamente)
INSERT INTO `crianca` (`cria_id`, `res_cpf`, `trans_id`, `nome`, `idade`, `genero`, `data_nascimento`, `escola`, `tipo_sanguineo`, `alergias`, `peso`, `medicamentos`, `valor`) VALUES
	(1, '000.000.000-00', 1, 'Sem Dados', 0, 'Sem Dados', '0000-00-00', 'Sem Dados', 'A+', 'Inexistente', '00kg', 'Inexistente', 0.00),
	(2, '200.200.200-20', 1, 'samantha', 6, 'feminino', '2005-02-05', 'josefina pereira', 'O+', 'Poeira', '17kg', 'loratadina de 6 em 6 horas', 100.00),
	(3, '200.200.200-20', 1, 'samantha', 6, 'feminino', '2005-02-05', 'josefina pereira', 'O+', 'Poeira', '17kg', 'loratadina de 6 em 6 horas', 150.00);

CREATE TABLE `gastos` (
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

CREATE TABLE IF NOT EXISTS `mes` (
  `mes_id` int NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`mes_id`),
  KEY `cria_id` (`cria_id`),
  FOREIGN KEY (`cria_id`) REFERENCES `crianca` (`cria_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Copiando estrutura para tabela transfast.monitor
CREATE TABLE IF NOT EXISTS `monitor` (
  `mon_cpf` varchar(14) NOT NULL,
  `trans_id` int NOT NULL,
  `nome` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `senha` varchar(20) NOT NULL,
  `data_nascimento` varchar(10) NOT NULL,
  `genero` varchar(9) DEFAULT NULL,
  PRIMARY KEY (`mon_cpf`),
  KEY `trans_id` (`trans_id`),
  FOREIGN KEY (`trans_id`) REFERENCES `transporte` (`trans_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Copiando dados para a tabela transfast.monitor: ~1 rows (aproximadamente)
INSERT INTO `monitor` (`mon_cpf`, `trans_id`, `nome`, `email`, `senha`, `data_nascimento`, `genero`) VALUES
	('344.988.388.94', 1, 'Tia sara', 'tiasaramonitora@gmail.com', '1234567891', '1999-04-10', 'Feminino');

CREATE TABLE `vistoria` (
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

INSERT INTO vistoria VALUES('12','false','false','false','false','false','false','false','false','false','false');

-- Copiando estrutura para tabela transfast.utilizacao
CREATE TABLE IF NOT EXISTS `utilizacao` (
  `util_id` int NOT NULL AUTO_INCREMENT,
  `cria_id` int NOT NULL,
  `trans_id` int NOT NULL,
  `embarque` varchar(5) DEFAULT NULL,
  `desembarque` varchar(5) DEFAULT NULL,
  `data` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`util_id`),
  KEY `cria_id` (`cria_id`),
  KEY `trans_id` (`trans_id`),
  FOREIGN KEY (`cria_id`) REFERENCES `crianca` (`cria_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`trans_id`) REFERENCES `transporte` (`trans_id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Copiando dados para a tabela transfast.utilizacao: ~1 rows (aproximadamente)
INSERT INTO `utilizacao` (`util_id`, `cria_id`, `trans_id`, `embarque`, `desembarque`, `data`) VALUES
	(1, 3, 1, '10:00', '17:00', '2023-05-18');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
