-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.33 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Copiando estrutura do banco de dados para transfast
CREATE DATABASE IF NOT EXISTS `transfast` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `transfast`;

-- Copiando estrutura para tabela transfast.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `moto_cpf` varchar(14) NOT NULL,
  `res_cpf` varchar(14) NOT NULL,
  `nome` varchar(500) NOT NULL,
  `mensagem` varchar(500) NOT NULL,
  PRIMARY KEY (`chat_id`),
  KEY `moto_cpf` (`moto_cpf`),
  KEY `res_cpf` (`res_cpf`),
  CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`moto_cpf`) REFERENCES `motorista` (`moto_cpf`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`res_cpf`) REFERENCES `responsavel` (`res_cpf`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela transfast.chat: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `chat` ENABLE KEYS */;

-- Copiando estrutura para tabela transfast.crianca
CREATE TABLE IF NOT EXISTS `crianca` (
  `cria_id` int(11) NOT NULL AUTO_INCREMENT,
  `res_cpf` varchar(14) NOT NULL,
  `trans_id` int(11) NOT NULL,
  `nome` varchar(160) NOT NULL,
  `idade` int(11) NOT NULL,
  `genero` varchar(10) NOT NULL,
  `data_nascimento` varchar(10) NOT NULL,
  `escola` varchar(160) NOT NULL,
  `deficiencia` varchar(20) NOT NULL,
  `presenca` varchar(8) DEFAULT NULL,
  `valor` decimal(7,2) DEFAULT NULL,
  `foto` longblob,
  PRIMARY KEY (`cria_id`),
  KEY `res_cpf` (`res_cpf`),
  KEY `trans_id` (`trans_id`),
  CONSTRAINT `crianca_ibfk_1` FOREIGN KEY (`res_cpf`) REFERENCES `responsavel` (`res_cpf`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `crianca_ibfk_2` FOREIGN KEY (`trans_id`) REFERENCES `transporte` (`trans_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela transfast.crianca: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `crianca` DISABLE KEYS */;
INSERT INTO `crianca` (`cria_id`, `res_cpf`, `trans_id`, `nome`, `idade`, `genero`, `data_nascimento`, `escola`, `deficiencia`, `presenca`, `valor`, `foto`) VALUES
	(1, '000.000.000-00', 1, 'Sem Dados', 0, 'Sem Dados', '0000-00-00', 'Sem Dados', 'visual', NULL, 0.00, NULL),
	(2, '000.000.000-00', 1, 'samantha', 6, 'feminino', '2005-02-05', 'josefina pereira', 'cognitiva', NULL, 100.00, NULL),
	(3, '200.200.200-20', 1, 'samantha', 6, 'feminino', '2005-02-05', 'josefina pereira', 'tetraplegico', NULL, 150.00, NULL),
	(4, '12232243303', 1, 'winnhi', 7, 'feminino', '2016-03-30', 'emef', 'visual', NULL, NULL, NULL);
/*!40000 ALTER TABLE `crianca` ENABLE KEYS */;

-- Copiando estrutura para tabela transfast.gastos
CREATE TABLE IF NOT EXISTS `gastos` (
  `gastos_id` int(10) NOT NULL AUTO_INCREMENT,
  `moto_cpf` varchar(14) NOT NULL,
  `data_compra` varchar(10) NOT NULL,
  `mes` varchar(50) NOT NULL,
  `produtos` varchar(200) NOT NULL,
  `valor` decimal(7,2) NOT NULL,
  PRIMARY KEY (`gastos_id`),
  KEY `moto_cpf` (`moto_cpf`),
  CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`moto_cpf`) REFERENCES `motorista` (`moto_cpf`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela transfast.gastos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `gastos` DISABLE KEYS */;
INSERT INTO `gastos` (`gastos_id`, `moto_cpf`, `data_compra`, `mes`, `produtos`, `valor`) VALUES
	(1, '12', '10/08/2022', 'janeiro', 'diesel, bateria', 350.00),
	(2, '12', '15/08/2012', 'fevereiro', 'diesel, bateria', 550.00),
	(3, '12', '18/08/2022', 'março', 'diesel, bateria', 850.00);
/*!40000 ALTER TABLE `gastos` ENABLE KEYS */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela transfast.motorista: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `motorista` DISABLE KEYS */;
INSERT INTO `motorista` (`moto_cpf`, `nome`, `email`, `senha`, `genero`, `telefone`, `data_nascimento`, `cep`, `rua`, `bairro`, `numero`, `complemento`, `foto`) VALUES
	('inexistente', 'inexistente', 'inexistente', '1234', 'inexisten', 'inexistente', '2000-02-02', '0', 'inexistente', 'inexistente', '00', NULL, NULL);
/*!40000 ALTER TABLE `motorista` ENABLE KEYS */;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela transfast.responsavel: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `responsavel` DISABLE KEYS */;
INSERT INTO `responsavel` (`res_cpf`, `nome`, `email`, `senha`, `genero`, `telefone`, `data_nascimento`, `cep`, `rua`, `bairro`, `numero`, `complemento`, `foto`) VALUES
	('000.000.000-00', 'Sem Dados', 'SemDados@gmail.com', '123456', 'Sem Dados', '00 00000-0000', '0000-00-00', '00000-000', 'Sem Dados', 'Sem Dados', '00', NULL, NULL),
	('12232243303', 'winnhi', 'teste@gmail.com', '$2y$10$JR1lT1tIskeJGm6Ks4tDZ.n3ATN91RLOQorFS14xdBXgDit9UHWCe', 'feminino', '11943864923', '2006-03-30', '12345220', 'Rua N Sei Oq', 'Jardim N Sei Oq', '42', 'Casa 2', NULL),
	('12232243304', 'Winnie', 'winniestefany303@gmail.com', '$2y$10$v2m2w5.T6wFQRhy4yDdaiekg8yzXXNFOJLGO5rucCqG7NQB3K4GR2', 'feminino', '11943864922', '2006-03-30', '12345220', 'Rua N Sei Oq', 'Jardim N Sei Oq', '42', 'Casa 2', NULL);
/*!40000 ALTER TABLE `responsavel` ENABLE KEYS */;

-- Copiando estrutura para tabela transfast.transporte
CREATE TABLE IF NOT EXISTS `transporte` (
  `trans_id` int(11) NOT NULL AUTO_INCREMENT,
  `moto_cpf` varchar(14) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `monitor` varchar(100) DEFAULT NULL,
  `placa` varchar(10) NOT NULL,
  `n_assentos` int(11) NOT NULL,
  `estado` varchar(20) NOT NULL,
  `cidade` varchar(20) NOT NULL,
  `cep` varchar(9) NOT NULL,
  `bairro` varchar(30) NOT NULL,
  `nota` int(11) DEFAULT NULL,
  `foto` longblob,
  PRIMARY KEY (`trans_id`),
  KEY `moto_cpf` (`moto_cpf`),
  CONSTRAINT `transporte_ibfk_1` FOREIGN KEY (`moto_cpf`) REFERENCES `motorista` (`moto_cpf`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela transfast.transporte: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `transporte` DISABLE KEYS */;
INSERT INTO `transporte` (`trans_id`, `moto_cpf`, `nome`, `monitor`, `placa`, `n_assentos`, `estado`, `cidade`, `cep`, `bairro`, `nota`, `foto`) VALUES
	(1, 'inexistente', 'inexistente', 'inexistente', 'ghd-2310', 15, 'indefinido', 'indefinido', '22000', 'indefinido', 0, NULL);
/*!40000 ALTER TABLE `transporte` ENABLE KEYS */;

-- Copiando estrutura para tabela transfast.verificacao
CREATE TABLE IF NOT EXISTS `verificacao` (
  `ver_id` int(11) NOT NULL AUTO_INCREMENT,
  `cria_id` int(11) NOT NULL,
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
  CONSTRAINT `verificacao_ibfk_1` FOREIGN KEY (`cria_id`) REFERENCES `crianca` (`cria_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela transfast.verificacao: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `verificacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `verificacao` ENABLE KEYS */;

-- Copiando estrutura para tabela transfast.vistoria
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
  KEY `moto_cpf` (`moto_cpf`),
  CONSTRAINT `vistoria_ibfk_1` FOREIGN KEY (`moto_cpf`) REFERENCES `motorista` (`moto_cpf`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela transfast.vistoria: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `vistoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `vistoria` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
