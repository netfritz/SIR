INSERT INTO Seguridad (ID, preguntaSecreta, respuestaSecreta, privacFotos, privacMuro, privacDatos) VALUES (1, 'Nombre de mi primera mascota?', 'pichi', 1,1,1);

INSERT INTO Muro (ID, Num_max_Publicaciones, Num_Publicaciones) VALUES (1, 999999999, 0);

INSERT INTO Perfil (usrname, passwd, email, fechaNac, carnet, tipo, nombre, apellido, sexo, telefono, emailAlt, tweeter, ciudad, carrera, colegio, actividadesExtra, foto, trabajo, bio, Seguridad_ID, Muro_ID, esAdmin) VALUES ('throoze','throoze','victor.dpo@gmail.com', '1988-08-19', '05-38087', 'Estudiante', 'Victor Manuel', 'De Ponte Olivares', 'M', '+584168075871', 'rdbvictor19@gmail.com', '@throoze', 'Caracas', 'Ing. De Computación', 'Josefa Irauzquín López', 'Capoeira, Windsurf', NULL, 'Vitoquen C.A.', 'Wepale!!!! =)', 1, 1, 1);