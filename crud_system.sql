-- Credenciais do Banco de Dados
-- Username: user
-- Password: "test_user"
DROP SCHEMA IF EXISTS `crud_system`;

CREATE SCHEMA IF NOT EXISTS `crud_system`
DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE `crud_system`;

CREATE TABLE IF NOT EXISTS `crud_system`.`person` (
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`name` VARCHAR(40),
	`phone` VARCHAR(13),
	`email` VARCHAR(50)
) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `crud_system`.`person` (`name`, `phone`, `email`) VALUES 
	('Fulano', '1111111111', 'fulano@hotmail.com'),
	('Ciclano', '2222222222', 'ciclano@gmail.com'),
	('Beltrano', '3333333333', 'beltrano@outlook.com');