<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es-VE">

<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta HTTP-EQUIV="Pragma" CONTENT="no-cache"/>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>PINF</title>
    <link href="style.css" rel="stylesheet" type="text/css" media="screen" />
</head>

<body>
<div id="wrapper">
	
    <!-- inicio encabezado -->
    <div id="encab">
	    <div id="logo">
		    <h1><a href="#">PINF</a></h1>
	    </div>
		<div id="busq">
			<form method="get" action="">
				<fieldset>
		            <input type="text" name="s" id="busq-texto" size="15" value="introduzca datos a buscar..." />
					<input type="submit" id="busq-enviar" value="GO" />
				</fieldset>
			</form>
		</div>
    </div>
	<!-- fin encabezado -->
	
	<!-- inicio pagina -->
	<div id="pag">
		<div id="pag-bgarriba">
			<div id="pag-bgabajo">
				
				<!-- inicio menu -->
				<div id="menu">
					<ul>
						<li class="current_page_item"><a href="#">Inicio</a></li>
						<li><a href="http://localhost:8080/web/perfil.html">Perfil</a></li>
						<li><a href="http://localhost:8080/web/enConstruccion.html">Amigos</a></li>
						<li><a href="http://localhost:8080/web/enConstruccion.html">Fotos</a></li>
						<li><a href="http://localhost:8080/web/evento.html">Eventos</a></li>
						<li><a href="http://localhost:8080/web/buscar.html">Buscar</a></li>
					</ul>
				</div>
				<!-- fin menu -->
				
				<!-- inicio contenido -->
				<div id="contenido">

<table>
<?php
   echo "<tr><td>Asunto</td><td> {$m->getAsunto()} </td></tr>";
   echo "<tr><td>Enviado por</td><td> {$m->getEmisor()->getUsername()} </td></tr>";
   echo "<tr><td>Mensaje</td><td> {$m->getMensaje()} </td></tr>";
?>
</table>
				  <div style="clear: both;">&nbsp;</div>
				</div>
				<!-- fin contenido -->
				
				<!-- inicio barra lateral -->
				<div id="barlateral">
				 <ul>
<li><a href="/ListarMensajes.php?tipo=recibidos">Ver mensajes recibidos</a></li>
<li><a href="/ListarMensajes.php?tipo=enviados">Ver mensajes enviados</a></li>
<li><a href="/EnviarMensaje.php">Enviar mensaje</a></li>
</ul>
				</div>
				<!-- fin barra lateral -->
				
				<div style="clear: both;">&nbsp;</div>
			</div>
		</div>
	</div>
</div>
<!-- fin de pagina -->

<!-- inicio pie de pagina -->
<div id="pie-wrapper">
	<div id="pie">
		<p><a href="http://localhost:8080/web/home.html">Inicio&nbsp;&nbsp;&nbsp;</a>
		<a href="http://www.usb.ve/">USB&nbsp;&nbsp;&nbsp;</a>
		<a href="http://www.dace.usb.ve/">DACE&nbsp;&nbsp;&nbsp;</a>
		<a href="http://www.generales.usb.ve/">Estudios Generales&nbsp;&nbsp;&nbsp;</a>
		<a href="http://asignaturas.usb.ve/">Aula Virtual</a>
		<a href="http://localhost:8080/web/enConstruccion.html">Salir</a><br><br>
		DiseÃ±ado por Manghoo!</p>
	</div>
</div>
<!-- fin pie de pagina -->
</body>

</html>
