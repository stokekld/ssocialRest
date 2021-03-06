-- MySQL Script generated by MySQL Workbench
-- mar 10 nov 2015 14:02:23 CST
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema ssocial
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `ssocial` ;

-- -----------------------------------------------------
-- Schema ssocial
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `ssocial` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ssocial` ;

-- -----------------------------------------------------
-- Table `ssocial`.`admin`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ssocial`.`admin` ;

CREATE TABLE IF NOT EXISTS `ssocial`.`admin` (
  `id_admin` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `admin_nombre` VARCHAR(60) NOT NULL COMMENT '',
  `admin_user` VARCHAR(15) NOT NULL COMMENT '',
  `admin_pass` VARCHAR(32) NOT NULL COMMENT '',
  PRIMARY KEY (`id_admin`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ssocial`.`serv_social`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ssocial`.`serv_social` ;

CREATE TABLE IF NOT EXISTS `ssocial`.`serv_social` (
  `id_serv` BIGINT NOT NULL AUTO_INCREMENT COMMENT '',
  `serv_nombre` VARCHAR(30) NOT NULL COMMENT '',
  `serv_apaterno` VARCHAR(25) NOT NULL COMMENT '',
  `serv_amaterno` VARCHAR(25) NOT NULL COMMENT '',
  `serv_semestre` INT NULL COMMENT '',
  `serv_carrera` VARCHAR(30) NULL COMMENT '',
  `serv_datos` TEXT NULL COMMENT '',
  `serv_user` VARCHAR(15) NOT NULL COMMENT '',
  `serv_pass` VARCHAR(32) NOT NULL COMMENT '',
  `serv_activo` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '',
  PRIMARY KEY (`id_serv`)  COMMENT '',
  UNIQUE INDEX `serv_user_UNIQUE` (`serv_user` ASC)  COMMENT '')
ENGINE = InnoDB
PACK_KEYS = DEFAULT;


-- -----------------------------------------------------
-- Table `ssocial`.`registro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ssocial`.`registro` ;

CREATE TABLE IF NOT EXISTS `ssocial`.`registro` (
  `id_registro` BIGINT NOT NULL AUTO_INCREMENT COMMENT '',
  `id_serv` BIGINT NOT NULL COMMENT '',
  `reg_inicio` DATETIME NULL COMMENT '',
  `reg_fin` TIME NULL COMMENT '',
  `reg_actividad` TEXT NULL COMMENT '',
  `reg_validacion` TINYINT(1) NULL COMMENT '',
  PRIMARY KEY (`id_registro`)  COMMENT '',
  INDEX `fk_registro_serv_social_idx` (`id_serv` ASC)  COMMENT '',
  CONSTRAINT `fk_registro_serv_social`
    FOREIGN KEY (`id_serv`)
    REFERENCES `ssocial`.`serv_social` (`id_serv`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ssocial`.`ip_s`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ssocial`.`ip_s` ;

CREATE TABLE IF NOT EXISTS `ssocial`.`ip_s` (
  `id_ip` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `ip` VARCHAR(15) NOT NULL COMMENT '',
  PRIMARY KEY (`id_ip`)  COMMENT '',
  UNIQUE INDEX `ip_UNIQUE` (`ip` ASC)  COMMENT '')
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `ssocial`.`admin`
-- -----------------------------------------------------
START TRANSACTION;
USE `ssocial`;
INSERT INTO `ssocial`.`admin` (`id_admin`, `admin_nombre`, `admin_user`, `admin_pass`) VALUES (1, 'ADMINISTRADOR', 'admin', '27db7898211c8ccbeb4d5a97d198839a');

COMMIT;

