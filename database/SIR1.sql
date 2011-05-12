-- SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
-- SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `SIR` ;
CREATE SCHEMA IF NOT EXISTS `SIR` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci ;
 USE `SIR` ;

-- -----------------------------------------------------
-- Table `SIR`.`Universidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Universidad` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Universidad` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(100) NOT NULL ,
  `pais` VARCHAR(45) NOT NULL ,
  `estado` VARCHAR(45) NOT NULL ,
  `ciudad` VARCHAR(45) NOT NULL ,
  `direccion` VARCHAR(255) NOT NULL ,
  `rector` VARCHAR(45) NOT NULL ,
  `url` VARCHAR(255) NOT NULL ,
  PRIMARY KEY (`id`, `nombre`) ,
  UNIQUE INDEX `nombre_UNIQUE` (`nombre` ASC) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) );



-- -----------------------------------------------------
-- Table `SIR`.`Estudiante`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Estudiante` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Estudiante` (
  `documento_id` VARCHAR(25) NOT NULL ,
  `carnet` DECIMAL(10,0)  NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `apellido` VARCHAR(45) NOT NULL ,
  `fecha_nac` DATE NOT NULL ,
  `colegio_origen` VARCHAR(100) NULL ,
  PRIMARY KEY (`documento_id`) ,
  UNIQUE INDEX `documento_id_UNIQUE` (`documento_id` ASC) );



-- -----------------------------------------------------
-- Table `SIR`.`AgrupacionEstudiantil`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`AgrupacionEstudiantil` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`AgrupacionEstudiantil` (
  `universidad` VARCHAR(45) NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `presidente` VARCHAR(45) NOT NULL ,
  `mision` TEXT NULL ,
  `vision` TEXT NULL ,
  PRIMARY KEY (`universidad`, `nombre`) );



-- -----------------------------------------------------
-- Table `SIR`.`Carrera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Carrera` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Carrera` (
  `codigo` VARCHAR(25) NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `direccion_coordinacion` VARCHAR(100) NOT NULL ,
  `coordinador` VARCHAR(100) NULL ,
  PRIMARY KEY (`codigo`) ,
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC) );



-- -----------------------------------------------------
-- Table `SIR`.`Departamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Departamento` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Departamento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `universidad_id` INT NOT NULL ,
  `universidad_nombre` VARCHAR(100) NOT NULL ,
  `codigo` VARCHAR(5) NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `direccion` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`, `universidad_id`, `universidad_nombre`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) );				 
 

-- -----------------------------------------------------
-- Table `SIR`.`Materia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Materia` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Materia` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `dpto` INT NOT NULL ,
  `codigo` DECIMAL(10,0)  NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`, `dpto`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC));


-- -----------------------------------------------------
-- Table `SIR`.`Profesor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Profesor` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Profesor` (
  `documento_id` VARCHAR(25) NOT NULL ,
  `dpto` INT NOT NULL ,
  `carnet` VARCHAR(45) NOT NULL ,
  `nombre` VARCHAR(45) NOT NULL ,
  `apellido` VARCHAR(45) NOT NULL ,
  `titulo` VARCHAR(45) NULL ,
  PRIMARY KEY (`documento_id`, `dpto`));



