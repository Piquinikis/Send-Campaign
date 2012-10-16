<!-- Formulario para alta en base de datos de boletines informativos -->
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="formulario.css">
</head>
<body class="boletin">
	<?php 
		include( 'suscribe.php' ); 	
	?>
		<!-- Muestro variables de control de errores y proceso -->
		<div id="message">
			<?php if( isset($error) ) { ?>
					<div class="error"><?php echo $error; ?></div>
				<?php }  ?>
			<?php if( isset($success) ) { ?>
			 		<div class="success"><?php echo $success; ?></div>
			 	<?php } ?>
		</div>

		<form id="newsletter" method="post">
			<label for="email" id="email">Inscribase al boletin:</label>
			<input id="email" name="email" type="email" placeholder="ejemplo@host.com" required="required" autofocus="true" />
			<input type="submit" value="Suscribirme" />
		</form>
</body>
</html>