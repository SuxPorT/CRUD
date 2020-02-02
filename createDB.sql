DROP DATABASE IF EXISTS `crud_pdo`;

CREATE DATABASE `crud_pdo`;

USE `crud_pdo`;

CREATE TABLE `crud_pdo`.`pessoa` (
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`nome` VARCHAR(40),
	`telefone` VARCHAR(15),
	`email` VARCHAR(50)
);

INSERT INTO `crud_pdo`.`pessoa` (`nome`, `telefone`, `email`) VALUES 
	('Fulano', '11 1111-1111', 'fulano@hotmail.com'),
	('Ciclano', '22 2222-2222', 'ciclano@gmail.com'),
	('Beltrano', '33 3333-3333', 'beltrano@outlook.com');