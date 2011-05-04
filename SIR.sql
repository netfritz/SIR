SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


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
  UNIQUE INDEX `documento_id_UNIQUE` (`documento_id` ASC) )
ENGINE = InnoDB;


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
  PRIMARY KEY (`universidad`, `nombre`) )
ENGINE = InnoDB;


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
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC) )
ENGINE = InnoDB;


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
  `direccion` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`, `universidad_id`, `universidad_nombre`) ,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_Departamento_Universidad` (`universidad_id` ASC, `universidad_nombre` ASC) ,
  CONSTRAINT `fk_Departamento_Universidad`
    FOREIGN KEY (`universidad_id` , `universidad_nombre` )
    REFERENCES `SIR`.`Universidad` (`id` , `nombre` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


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
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  INDEX `fk_Materia_pertenece_Departamento` (`dpto` ASC) ,
  CONSTRAINT `fk_Materia_pertenece_Departamento`
    FOREIGN KEY (`dpto` )
    REFERENCES `SIR`.`Departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COMMENT = '\n	' ;


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
  PRIMARY KEY (`documento_id`, `dpto`) ,
  INDEX `fk_Profesor_Departamento` (`dpto` ASC) ,
  CONSTRAINT `fk_Profesor_Departamento`
    FOREIGN KEY (`dpto` )
    REFERENCES `SIR`.`Departamento` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Agrupacion_pertenece_Universidad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Agrupacion_pertenece_Universidad` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Agrupacion_pertenece_Universidad` (
  `Agrupacion_universidad` VARCHAR(45) NOT NULL ,
  `Agrupacion_nombre` VARCHAR(45) NOT NULL ,
  `Universidad_id` INT NOT NULL ,
  `Universidad_nombre` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`Agrupacion_universidad`, `Agrupacion_nombre`, `Universidad_id`, `Universidad_nombre`) ,
  INDEX `fk_Agrupacion_pertenece_Universidad_Universidad` (`Universidad_id` ASC, `Universidad_nombre` ASC) ,
  INDEX `fk_Agrupacion_pertenece_Universidad_Agrupacion` (`Agrupacion_universidad` ASC, `Agrupacion_nombre` ASC) ,
  CONSTRAINT `fk_Agrupacion_pertenece_Universidad_Agrupacion`
    FOREIGN KEY (`Agrupacion_universidad` , `Agrupacion_nombre` )
    REFERENCES `SIR`.`AgrupacionEstudiantil` (`universidad` , `nombre` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Agrupacion_pertenece_Universidad_Universidad`
    FOREIGN KEY (`Universidad_id` , `Universidad_nombre` )
    REFERENCES `SIR`.`Universidad` (`id` , `nombre` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Estudiante_miembro_Agrupacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Estudiante_miembro_Agrupacion` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Estudiante_miembro_Agrupacion` (
  `Estudiante_documento_id` VARCHAR(25) NOT NULL ,
  `Agrupacion_universidad` VARCHAR(45) NOT NULL ,
  `Agrupacion_nombre` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`Estudiante_documento_id`, `Agrupacion_universidad`, `Agrupacion_nombre`) ,
  INDEX `fk_Estudiante_miembro_Agrupacion_Agrupacion` (`Agrupacion_universidad` ASC, `Agrupacion_nombre` ASC) ,
  INDEX `fk_Estudiante_miembro_Agrupacion_Estudiante` (`Estudiante_documento_id` ASC) ,
  CONSTRAINT `fk_Estudiante_miembro_Agrupacion_Estudiante`
    FOREIGN KEY (`Estudiante_documento_id` )
    REFERENCES `SIR`.`Estudiante` (`documento_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Estudiante_miembro_Agrupacion_Agrupacion`
    FOREIGN KEY (`Agrupacion_universidad` , `Agrupacion_nombre` )
    REFERENCES `SIR`.`AgrupacionEstudiantil` (`universidad` , `nombre` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Universidad_tiene_Estudiante`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Universidad_tiene_Estudiante` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Universidad_tiene_Estudiante` (
  `Universidad_id` INT NOT NULL ,
  `Universidad_nombre` VARCHAR(100) NOT NULL ,
  `Estudiante_documento_id` VARCHAR(25) NOT NULL ,
  PRIMARY KEY (`Universidad_id`, `Universidad_nombre`, `Estudiante_documento_id`) ,
  INDEX `fk_Universidad_tiene_Estudiante_Estudiante` (`Estudiante_documento_id` ASC) ,
  INDEX `fk_Universidad_tiene_Estudiante_Universidad` (`Universidad_id` ASC, `Universidad_nombre` ASC) ,
  CONSTRAINT `fk_Universidad_tiene_Estudiante_Universidad`
    FOREIGN KEY (`Universidad_id` , `Universidad_nombre` )
    REFERENCES `SIR`.`Universidad` (`id` , `nombre` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Universidad_tiene_Estudiante_Estudiante`
    FOREIGN KEY (`Estudiante_documento_id` )
    REFERENCES `SIR`.`Estudiante` (`documento_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Estudiante_estudia_Carrera`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Estudiante_estudia_Carrera` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Estudiante_estudia_Carrera` (
  `Estudiante_documento_id` VARCHAR(25) NOT NULL ,
  `Carrera_codigo` VARCHAR(25) NOT NULL ,
  PRIMARY KEY (`Estudiante_documento_id`, `Carrera_codigo`) ,
  INDEX `fk_Estudiante_estudia_Carrera_Carrera` (`Carrera_codigo` ASC) ,
  INDEX `fk_Estudiante_estudia_Carrera_Estudiante` (`Estudiante_documento_id` ASC) ,
  CONSTRAINT `fk_Estudiante_estudia_Carrera_Estudiante`
    FOREIGN KEY (`Estudiante_documento_id` )
    REFERENCES `SIR`.`Estudiante` (`documento_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Estudiante_estudia_Carrera_Carrera`
    FOREIGN KEY (`Carrera_codigo` )
    REFERENCES `SIR`.`Carrera` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `SIR`.`Profesor_dicta_Materia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `SIR`.`Profesor_dicta_Materia` ;

CREATE  TABLE IF NOT EXISTS `SIR`.`Profesor_dicta_Materia` (
  `Profesor_documento_id` VARCHAR(25) NOT NULL ,
  `Materia_id` INT NOT NULL ,
  `Materia_dpto` INT NOT NULL ,
  `Estudiante_documento_id` VARCHAR(25) NOT NULL ,
  PRIMARY KEY (`Profesor_documento_id`, `Materia_id`, `Materia_dpto`, `Estudiante_documento_id`) ,
  INDEX `fk_Profesor_dicta_Materia_Materia` (`Materia_id` ASC, `Materia_dpto` ASC) ,
  INDEX `fk_Profesor_dicta_Materia_Profesor` (`Profesor_documento_id` ASC) ,
  INDEX `fk_Profesor_dicta_Materia_Estudiante` (`Estudiante_documento_id` ASC) ,
  CONSTRAINT `fk_Profesor_dicta_Materia_Profesor`
    FOREIGN KEY (`Profesor_documento_id` )
    REFERENCES `SIR`.`Profesor` (`documento_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Profesor_dicta_Materia_Materia`
    FOREIGN KEY (`Materia_id` , `Materia_dpto` )
    REFERENCES `SIR`.`Materia` (`id` , `dpto` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Profesor_dicta_Materia_Estudiante`
    FOREIGN KEY (`Estudiante_documento_id` )
    REFERENCES `SIR`.`Estudiante` (`documento_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
