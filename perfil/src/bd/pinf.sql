SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `pinf` ;
CREATE SCHEMA IF NOT EXISTS `pinf` DEFAULT CHARACTER SET latin1 ;
USE `pinf` ;

-- -----------------------------------------------------
-- Table `pinf`.`Seguridad`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Seguridad` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Seguridad` (
  `ID` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `preguntaSecreta` VARCHAR(128) NOT NULL ,
  `respuestaSecreta` VARCHAR(32) NOT NULL ,
  `privac_Fotos` TINYINT(1)  NOT NULL ,
  `privac_Muro` TINYINT(1)  NOT NULL ,
  `privac_Datos` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Muro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Muro` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Muro` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `Num_max_pub` INT(10) NOT NULL ,
  `Num_pub` INT(10) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Perfil`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Perfil` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Perfil` (
  `usrname` VARCHAR(20) NOT NULL ,
  `passwd` VARCHAR(40) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `fechaNac` DATE NOT NULL ,
  `carnet` VARCHAR(8) NOT NULL ,
  `tipo` VARCHAR(10) NOT NULL ,
  `nombre` VARCHAR(30) NULL ,
  `apellido` VARCHAR(30) NULL ,
  `sexo` VARCHAR(1) NOT NULL ,
  `telefono` VARCHAR(15) NULL ,
  `emailAlt` VARCHAR(100) NULL ,
  `tweeter` VARCHAR(50) NULL ,
  `ciudad` VARCHAR(50) NULL ,
  `carrera` VARCHAR(100) NULL ,
  `colegio` VARCHAR(45) NULL ,
  `actividadesExtra` TEXT NULL ,
  `foto` BLOB NULL ,
  `trabajo` VARCHAR(100) NULL ,
  `bio` TEXT NULL ,
  `seguridadId` INT UNSIGNED NOT NULL ,
  `muroId` INT(10) NOT NULL ,
  `esAdmin` TINYINT(1) NOT NULL ,
  `estado` VARCHAR(10) NOT NULL DEFAULT 'activo' ,
  PRIMARY KEY (`usrname`) ,
  UNIQUE INDEX `usrname_UNIQUE` (`usrname` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  UNIQUE INDEX `emailAlt_UNIQUE` (`emailAlt` ASC) ,
  INDEX `fk_Perfil_Seguridad` (`seguridadId` ASC) ,
  INDEX `fk_Perfil_Muro` (`muroId` ASC) ,
  UNIQUE INDEX `Muro_ID_UNIQUE` (`muroId` ASC) ,
  CONSTRAINT `fk_Perfil_Seguridad`
    FOREIGN KEY (`seguridadId` )
    REFERENCES `pinf`.`Seguridad` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Perfil_Muro`
    FOREIGN KEY (`muroId` )
    REFERENCES `pinf`.`Muro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `pinf`.`esAmigo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`esAmigo` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`esAmigo` (
  `usuarioA` VARCHAR(20) NOT NULL ,
  `usuarioB` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`usuarioA`, `usuarioB`) ,
  INDEX `fk_esAmigo_A` (`usuarioA` ASC) ,
  INDEX `fk_esAmigo_B` (`usuarioB` ASC) ,
  CONSTRAINT `fk_esAmigo_A`
    FOREIGN KEY (`usuarioA` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_esAmigo_B`
    FOREIGN KEY (`usuarioB` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Publicacion`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Publicacion` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Publicacion` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `autor` VARCHAR(20) NOT NULL ,
  `muro` INT NOT NULL ,
  `nombre` VARCHAR(20) NOT NULL ,
  `contenido` VARCHAR(255) NOT NULL ,
  `imagen` MEDIUMBLOB NULL ,
  `nom_Img` VARCHAR(50) NULL ,
  `tipo_Img` VARCHAR(50) NULL ,
  `tam_Img` INT NULL ,
  `fechaRealizacion` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  `visible` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Publicacion_Perfil` (`autor` ASC) ,
  INDEX `fk_Publicacion_Muro` (`muro` ASC) ,
  CONSTRAINT `fk_Publicacion_Perfil`
    FOREIGN KEY (`autor` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Publicacion_Muro`
    FOREIGN KEY (`muro` )
    REFERENCES `pinf`.`Muro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Comentario`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Comentario` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Comentario` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `autor` VARCHAR(20) NULL ,
  `publicacion` INT NOT NULL ,
  `contenido` VARCHAR(255) NOT NULL ,
  `fechaRealizacion` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `visible` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Comentario_Publicacion` (`publicacion` ASC) ,
  INDEX `fk_Comentario_Perfil` (`autor` ASC) ,
  CONSTRAINT `fk_Comentario_Publicacion`
    FOREIGN KEY (`publicacion` )
    REFERENCES `pinf`.`Publicacion` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Comentario_Perfil`
    FOREIGN KEY (`autor` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Solicitud`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Solicitud` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Solicitud` (
  `idEmisor` VARCHAR(20) NOT NULL ,
  `idReceptor` VARCHAR(20) NOT NULL ,
  `descripcion` VARCHAR(255) NOT NULL ,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`idEmisor`, `idReceptor`) ,
  INDEX `fk_Solicitud_Emisor` (`idEmisor` ASC) ,
  INDEX `fk_Solicitud_Receptor` (`idReceptor` ASC) ,
  CONSTRAINT `fk_Solicitud_Emisor`
    FOREIGN KEY (`idEmisor` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Solicitud_Receptor`
    FOREIGN KEY (`idReceptor` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Grupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Grupo` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Grupo` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  `ID_Lider` VARCHAR(20) NOT NULL ,
  `ID_Muro` INT UNSIGNED NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `num_miembros` INT(11)  NOT NULL DEFAULT 1 ,
  `visible` INT(11)  NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_Grupo_Perfil` (`ID_Lider` ASC) ,
  INDEX `fk_Grupo_Muro` (`ID_Muro` ASC) ,
  CONSTRAINT `fk_Grupo_Perfil`
    FOREIGN KEY (`ID_Lider` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Grupo_Muro`
    FOREIGN KEY (`ID_Muro` )
    REFERENCES `pinf`.`Muro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`documento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`documento` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`documento` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(50) NOT NULL ,
  `tipo` VARCHAR(50) NOT NULL ,
  `tamano` DECIMAL(10,0)  NOT NULL ,
  `contenido` MEDIUMBLOB NOT NULL ,
  `id_Perfil` VARCHAR(20) NOT NULL ,
  `id_Grupo` INT(10) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Documento_Perfil` (`id_Perfil` ASC) ,
  INDEX `fk_Documento_Grupo` (`id_Grupo` ASC) ,
  CONSTRAINT `fk_Documento_Perfil`
    FOREIGN KEY (`id_Perfil` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Documento_Grupo`
    FOREIGN KEY (`id_Grupo` )
    REFERENCES `pinf`.`Grupo` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`abuso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`abuso` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`abuso` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_denunciante` VARCHAR(20) NOT NULL ,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `descripcion` VARCHAR(255) NOT NULL ,
  `tipo` VARCHAR(30) NOT NULL ,
  `URL` VARCHAR(80) NOT NULL ,
  `estado` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Abuso_Denunciante` (`id_denunciante` ASC) ,
  CONSTRAINT `fk_Abuso_Denunciante`
    FOREIGN KEY (`id_denunciante` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`EsMiembro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`EsMiembro` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`EsMiembro` (
  `ID_Perfil` VARCHAR(20) NOT NULL ,
  `ID_Grupo` INT(10) NOT NULL ,
  PRIMARY KEY (`ID_Perfil`, `ID_Grupo`) ,
  INDEX `fk_esMiembro_Perfil` (`ID_Perfil` ASC) ,
  INDEX `fk_esMiembro_Grupo` (`ID_Grupo` ASC) ,
  CONSTRAINT `fk_esMiembro_Perfil`
    FOREIGN KEY (`ID_Perfil` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_esMiembro_Grupo`
    FOREIGN KEY (`ID_Grupo` )
    REFERENCES `pinf`.`Grupo` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`invitaAGrupo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`invitaAGrupo` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`invitaAGrupo` (
  `ID_Perfil` VARCHAR(20) NOT NULL ,
  `ID_Perfil2` VARCHAR(20) NOT NULL ,
  `ID_Grupo` INT(10) NOT NULL ,
  PRIMARY KEY (`ID_Perfil`, `ID_Perfil2`, `ID_Grupo`) ,
  INDEX `fk_invita_a_grupo_Perfil` (`ID_Perfil` ASC) ,
  INDEX `fk_invita_a_grupo_Perfil2` (`ID_Perfil2` ASC) ,
  INDEX `fk_invita_a_grupo_Grupo` (`ID_Grupo` ASC) ,
  CONSTRAINT `fk_invita_a_grupo_Perfil`
    FOREIGN KEY (`ID_Perfil` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_invita_a_grupo_Perfil2`
    FOREIGN KEY (`ID_Perfil2` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_invita_a_grupo_Grupo`
    FOREIGN KEY (`ID_Grupo` )
    REFERENCES `pinf`.`Grupo` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Album`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Album` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Album` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(100) NOT NULL ,
  `lugar` VARCHAR(100) NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`grupo_album`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`grupo_album` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`grupo_album` (
  `ID_Grupo` INT(10) NOT NULL ,
  `ID_Album` INT(10) NOT NULL ,
  PRIMARY KEY (`ID_Grupo`, `ID_Album`) ,
  INDEX `fk_grupo_album_Grupo` (`ID_Grupo` ASC) ,
  INDEX `fk_grupo_album_Album` (`ID_Album` ASC) ,
  CONSTRAINT `fk_grupo_album_Grupo`
    FOREIGN KEY (`ID_Grupo` )
    REFERENCES `pinf`.`Grupo` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_album_Album`
    FOREIGN KEY (`ID_Album` )
    REFERENCES `pinf`.`Album` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Evento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Evento` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Evento` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(128) NOT NULL ,
  `ID_Organizador` VARCHAR(20) NOT NULL ,
  `ID_Muro` INT UNSIGNED NOT NULL ,
  `descripcion` TEXT NOT NULL ,
  `ubicacion` TEXT NOT NULL ,
  `fecha` DATE NOT NULL ,
  `num_gusta` INT(10) UNSIGNED NOT NULL ,
  `num_nogusta` INT(10) UNSIGNED NOT NULL ,
  `num_miembros` INT(10) UNSIGNED NOT NULL ,
  `visible` INT UNSIGNED NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_Evento_Organizador` (`ID_Organizador` ASC) ,
  INDEX `fk_Evento_Muro` (`ID_Muro` ASC) ,
  CONSTRAINT `fk_Evento_Organizador`
    FOREIGN KEY (`ID_Organizador` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Evento_Muro`
    FOREIGN KEY (`ID_Muro` )
    REFERENCES `pinf`.`Muro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`evento_album`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`evento_album` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`evento_album` (
  `ID_Evento` INT(10) NOT NULL ,
  `ID_Album` INT(10) NOT NULL ,
  PRIMARY KEY (`ID_Evento`, `ID_Album`) ,
  INDEX `fk_evento_album_Evento` (`ID_Evento` ASC) ,
  INDEX `fk_evento_album_Album` (`ID_Album` ASC) ,
  CONSTRAINT `fk_evento_album_Evento`
    FOREIGN KEY (`ID_Evento` )
    REFERENCES `pinf`.`Evento` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_evento_album_Album`
    FOREIGN KEY (`ID_Album` )
    REFERENCES `pinf`.`Album` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`esInvitado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`esInvitado` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`esInvitado` (
  `ID_Miembro` VARCHAR(20) NOT NULL ,
  `ID_Evento` INT(10) NOT NULL ,
  `RSVP` VARCHAR(1) NOT NULL ,
  PRIMARY KEY (`ID_Miembro`, `ID_Evento`) ,
  INDEX `fk_es_invitado_Miembro` (`ID_Miembro` ASC) ,
  INDEX `fk_es_invitado_Evento` (`ID_Evento` ASC) ,
  CONSTRAINT `fk_es_invitado_Miembro`
    FOREIGN KEY (`ID_Miembro` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_es_invitado_Evento`
    FOREIGN KEY (`ID_Evento` )
    REFERENCES `pinf`.`Evento` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`sugiereEvento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`sugiereEvento` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`sugiereEvento` (
  `ID_Miembro1` VARCHAR(20) NOT NULL ,
  `ID_Miembro2` VARCHAR(20) NOT NULL ,
  `ID_Evento` INT(10) NOT NULL ,
  PRIMARY KEY (`ID_Miembro1`, `ID_Miembro2`, `ID_Evento`) ,
  INDEX `fk_sugiere_evento_Miembro1` (`ID_Miembro1` ASC) ,
  INDEX `fk_sugiere_evento_Miembro2` (`ID_Miembro2` ASC) ,
  INDEX `fk_sugiere_evento_Evento` (`ID_Evento` ASC) ,
  CONSTRAINT `fk_sugiere_evento_Miembro1`
    FOREIGN KEY (`ID_Miembro1` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sugiere_evento_Miembro2`
    FOREIGN KEY (`ID_Miembro2` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_sugiere_evento_Evento`
    FOREIGN KEY (`ID_Evento` )
    REFERENCES `pinf`.`Evento` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Cuerpo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Cuerpo` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Cuerpo` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `contenido` TEXT NOT NULL ,
  PRIMARY KEY (`ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Noticia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Noticia` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Noticia` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `titulo` VARCHAR(128) NOT NULL ,
  `autor` VARCHAR(40) NOT NULL ,
  `fecha` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `descripcion` TEXT NOT NULL ,
  `num_gusta` INT UNSIGNED NOT NULL ,
  `num_nogusta` INT UNSIGNED NOT NULL ,
  `ID_Cuerpo` INT(10) NOT NULL ,
  `ID_Muro` INT UNSIGNED NOT NULL ,
  `ID_Admin` VARCHAR(20) NOT NULL ,
  `visible` INT UNSIGNED NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_Noticia_Cuerpo` (`ID_Cuerpo` ASC) ,
  INDEX `fk_Noticia_Muro` (`ID_Muro` ASC) ,
  INDEX `fk_Noticia_Admin` (`ID_Admin` ASC) ,
  CONSTRAINT `fk_Noticia_Cuerpo`
    FOREIGN KEY (`ID_Cuerpo` )
    REFERENCES `pinf`.`Cuerpo` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Noticia_Muro`
    FOREIGN KEY (`ID_Muro` )
    REFERENCES `pinf`.`Muro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Noticia_Admin`
    FOREIGN KEY (`ID_Admin` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`noticiaAlbum`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`noticiaAlbum` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`noticiaAlbum` (
  `ID_Noticia` INT(10) NOT NULL ,
  `ID_Album` INT(10) NOT NULL ,
  PRIMARY KEY (`ID_Noticia`, `ID_Album`) ,
  INDEX `fk_noticia_album_Noticia` (`ID_Noticia` ASC) ,
  INDEX `fk_noticia_album_Album` (`ID_Album` ASC) ,
  CONSTRAINT `fk_noticia_album_Noticia`
    FOREIGN KEY (`ID_Noticia` )
    REFERENCES `pinf`.`Noticia` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_noticia_album_Album`
    FOREIGN KEY (`ID_Album` )
    REFERENCES `pinf`.`Album` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Tema`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Tema` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Tema` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `fecha_creacion` DATE NOT NULL ,
  `titulo` VARCHAR(50) NOT NULL ,
  `visible` INT(11)  NOT NULL DEFAULT 1 ,
  `fecha_ult_modif` DATE NULL ,
  `cantidad_comentarios` INT(11)  NOT NULL DEFAULT 0 ,
  `foroID` INT(11)  NOT NULL ,
  `muroID` INT UNSIGNED NOT NULL ,
  `nGusta` INT NULL DEFAULT 0 ,
  `nNoGusta` INT NULL DEFAULT 0 ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_Tema_Muro` (`muroID` ASC) ,
  CONSTRAINT `fk_Tema_Muro`
    FOREIGN KEY (`muroID` )
    REFERENCES `pinf`.`Muro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Departamento`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Departamento` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Departamento` (
  `codigo` VARCHAR(7) NOT NULL ,
  `nombre` VARCHAR(100) NOT NULL ,
  `direccion` VARCHAR(200) NOT NULL ,
  PRIMARY KEY (`codigo`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Materia`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Materia` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Materia` (
  `codigo` VARCHAR(7) NOT NULL ,
  `nombre` VARCHAR(100) NOT NULL ,
  `creditos` INT(2) NOT NULL ,
  `depCod` VARCHAR(7) NOT NULL ,
  PRIMARY KEY (`codigo`) ,
  INDEX `fk_Materia_Departamento` (`depCod` ASC) ,
  CONSTRAINT `fk_Materia_Departamento`
    FOREIGN KEY (`depCod` )
    REFERENCES `pinf`.`Departamento` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Mensaje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Mensaje` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Mensaje` (
  `mid` INT(10) NOT NULL AUTO_INCREMENT ,
  `asunto` VARCHAR(100) NULL ,
  `mensaje` TEXT NOT NULL ,
  `eliminado` TINYINT(1) NOT NULL ,
  `emisor` VARCHAR(20) NOT NULL ,
  `fecha_enviado` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`mid`) ,
  INDEX `fk_Mensaje_Emisor` (`emisor` ASC) ,
  CONSTRAINT `fk_Mensaje_Emisor`
    FOREIGN KEY (`emisor` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`RecibeMensaje`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`RecibeMensaje` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`RecibeMensaje` (
  `mid` INT(10) NOT NULL ,
  `destinatario` VARCHAR(20) NOT NULL ,
  `leido` TINYINT(1)  NOT NULL ,
  `eliminado` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`mid`, `destinatario`) ,
  INDEX `fk_RecibeMensaje_Mensaje` (`mid` ASC) ,
  INDEX `fk_RecibeMensaje_Destinatario` (`destinatario` ASC) ,
  CONSTRAINT `fk_RecibeMensaje_Mensaje`
    FOREIGN KEY (`mid` )
    REFERENCES `pinf`.`Mensaje` (`mid` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_RecibeMensaje_Destinatario`
    FOREIGN KEY (`destinatario` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`AlbumEsDePerfil`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`AlbumEsDePerfil` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`AlbumEsDePerfil` (
  `ID_Album` INT(10) NOT NULL ,
  `ID_Perfil` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`ID_Album`, `ID_Perfil`) ,
  INDEX `fk_AlbumEsDePerfil_Album` (`ID_Album` ASC) ,
  INDEX `fk_AlbumEsDePerfil_Perfil` (`ID_Perfil` ASC) ,
  CONSTRAINT `fk_AlbumEsDePerfil_Album`
    FOREIGN KEY (`ID_Album` )
    REFERENCES `pinf`.`Album` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_AlbumEsDePerfil_Perfil`
    FOREIGN KEY (`ID_Perfil` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Foto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Foto` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Foto` (
  `ID` INT(10) NOT NULL AUTO_INCREMENT ,
  `nombre` VARCHAR(100) NOT NULL ,
  `album` INT(10) NOT NULL ,
  `imagen` BLOB NOT NULL ,
  `tam` INT(7) NOT NULL ,
  `formato` VARCHAR(6) NOT NULL ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_Foto_Album` (`album` ASC) ,
  CONSTRAINT `fk_Foto_Album`
    FOREIGN KEY (`album` )
    REFERENCES `pinf`.`Album` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`MuroTieneFoto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`MuroTieneFoto` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`MuroTieneFoto` (
  `IDMuro` INT UNSIGNED NOT NULL ,
  `IDFoto` INT(10) NOT NULL ,
  PRIMARY KEY (`IDMuro`, `IDFoto`) ,
  INDEX `fk_MuroTieneFoto_Muro` (`IDMuro` ASC) ,
  INDEX `fk_MuroTieneFoto_Foto` (`IDFoto` ASC) ,
  CONSTRAINT `fk_MuroTieneFoto_Muro`
    FOREIGN KEY (`IDMuro` )
    REFERENCES `pinf`.`Muro` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_MuroTieneFoto_Foto`
    FOREIGN KEY (`IDFoto` )
    REFERENCES `pinf`.`Foto` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Periodo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Periodo` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Periodo` (
  `mesIni` VARCHAR(3) NOT NULL ,
  `mesFin` VARCHAR(3) NOT NULL ,
  `anio` INT(4) NOT NULL ,
  PRIMARY KEY (`mesIni`, `mesFin`, `anio`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Curso`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Curso` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Curso` (
  `estudiante` VARCHAR(20) NOT NULL ,
  `materia` VARCHAR(7) NOT NULL ,
  `mesIni` VARCHAR(3) NOT NULL ,
  `mesFin` VARCHAR(3) NOT NULL ,
  `anio` INT(4) NOT NULL ,
  `calificacion` INT(1) NULL ,
  `profesorId` VARCHAR(20) NULL ,
  `nombreProfesor` VARCHAR(100) NULL ,
  `apellidoProfesor` VARCHAR(100) NULL ,
  PRIMARY KEY (`estudiante`, `materia`, `mesIni`, `mesFin`, `anio`) ,
  INDEX `fk_Curso_Estudiante` (`estudiante` ASC) ,
  INDEX `fk_Curso_Materia` (`materia` ASC) ,
  INDEX `fk_Curso_Periodo` (`mesIni` ASC, `mesFin` ASC, `anio` ASC) ,
  INDEX `fk_Curso_Profesor` (`profesorId` ASC) ,
  CONSTRAINT `fk_Curso_Estudiante`
    FOREIGN KEY (`estudiante` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Curso_Materia`
    FOREIGN KEY (`materia` )
    REFERENCES `pinf`.`Materia` (`codigo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Curso_Periodo`
    FOREIGN KEY (`mesIni` , `mesFin` , `anio` )
    REFERENCES `pinf`.`Periodo` (`mesIni` , `mesFin` , `anio` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Curso_Profesor`
    FOREIGN KEY (`profesorId` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Foro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Foro` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Foro` (
  `ID` INT(11)  NOT NULL AUTO_INCREMENT ,
  `administrador` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`ID`) ,
  INDEX `fk_Foro_Administrador` (`administrador` ASC) ,
  CONSTRAINT `fk_Foro_Administrador`
    FOREIGN KEY (`administrador` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`Persona_Foto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`Persona_Foto` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`Persona_Foto` (
  `persona` VARCHAR(20) NOT NULL ,
  `IDFoto` INT(10) NOT NULL ,
  PRIMARY KEY (`persona`, `IDFoto`) ,
  INDEX `fk_Persona_Foto_Perfil` (`persona` ASC) ,
  INDEX `fk_Persona_Foto_Foto` (`IDFoto` ASC) ,
  CONSTRAINT `fk_Persona_Foto_Perfil`
    FOREIGN KEY (`persona` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Persona_Foto_Foto`
    FOREIGN KEY (`IDFoto` )
    REFERENCES `pinf`.`Foto` (`ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pinf`.`bloqueaMensajes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pinf`.`bloqueaMensajes` ;

CREATE  TABLE IF NOT EXISTS `pinf`.`bloqueaMensajes` (
  `bloqueado` VARCHAR(20) NOT NULL ,
  `bloqueador` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`bloqueado`, `bloqueador`) ,
  INDEX `fk_bloqueaMensajes_bloqueado` (`bloqueado` ASC) ,
  INDEX `fk_bloqueaMensajes_bloqueador` (`bloqueador` ASC) ,
  CONSTRAINT `fk_bloqueaMensajes_bloqueado`
    FOREIGN KEY (`bloqueado` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bloqueaMensajes_bloqueador`
    FOREIGN KEY (`bloqueador` )
    REFERENCES `pinf`.`Perfil` (`usrname` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `pinf`.`Seguridad`
-- -----------------------------------------------------
START TRANSACTION;
USE `pinf`;
INSERT INTO `pinf`.`Seguridad` (`ID`, `preguntaSecreta`, `respuestaSecreta`, `privac_Fotos`, `privac_Muro`, `privac_Datos`) VALUES (1, 'pregunta secreta?', 'pichi', 1, 1, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `pinf`.`Muro`
-- -----------------------------------------------------
START TRANSACTION;
USE `pinf`;
INSERT INTO `pinf`.`Muro` (`id`, `Num_max_pub`, `Num_pub`) VALUES (1, 15, 0);
INSERT INTO `pinf`.`Muro` (`id`, `Num_max_pub`, `Num_pub`) VALUES (2, 15, 0);
INSERT INTO `pinf`.`Muro` (`id`, `Num_max_pub`, `Num_pub`) VALUES (3, 15, 0);

COMMIT;

-- -----------------------------------------------------
-- Data for table `pinf`.`Perfil`
-- -----------------------------------------------------
START TRANSACTION;
USE `pinf`;
INSERT INTO `pinf`.`Perfil` (`usrname`, `passwd`, `email`, `fechaNac`, `carnet`, `tipo`, `nombre`, `apellido`, `sexo`, `telefono`, `emailAlt`, `tweeter`, `ciudad`, `carrera`, `colegio`, `actividadesExtra`, `foto`, `trabajo`, `bio`, `seguridadId`, `muroId`, `esAdmin`, `estado`) VALUES ('admin', 'pinfadmin', 'admin@pinf.com', '0000-00-00', '00-00000', 'Estudiante', 'Administrador', 'Pinf', 'M', '+000000000000', 'adminAlt@ping.com', '@pinfadmin', 'Caracas', 'Ing de Computación', 'USB', 'administrar la red social pinf', NULL, 'administrador de pinf', 'Soy el administrador de pinf', 1, 1, 1, '\'activo\'');

COMMIT;
