<?php 
	include( '../classes/BD.class.php' ); 
	include( '../classes/Mailer.class.php' ); 
	$data_base = new BD(); 
	$arrayCampaigns = $data_base->listar_campaigns();
	$arrayEmails = $data_base->listar_emails();
/**
* Cambiar esto por el codigo preferido para seguridad del sistema
*/	$code = 'ESCOJA UN CODIGO DE 5 CARACTERES'; 
?>

<?php	
	if( $_POST && $_POST['codigo'] == $code )
	{
		switch ( $_POST['selector'] ) {
			case 'form1':
						if( $emaildeprueba = $_POST['test'] )
						{
							$mailing = new Mailer( "boletin" );
							 if ((($_FILES["archivo"]["type"] == "image/gif") ||  
						    	($_FILES["archivo"]["type"] == "image/jpeg") ||  
						    	($_FILES["archivo"]["type"] == "image/pjpeg")) &&  
						    	($_FILES["archivo"]["size"] < 500000)) 
						    {
							
								$varrand = substr(md5(uniqid(rand())),0,10);			
								$directorio = "/images/";  

								$varname = $_FILES["imagen"]['name'];
								$vartemp = $_FILES['imagen']['tmp_name'];
								$vartype = $_FILES['imagen']['type'];			
								
								$imgName = $varrand.".".$i;				
								$imagen = $directorio.$imgName;	
													 
								move_uploaded_file($_FILES["archivo"]["tmp_name"], "../images/" . $imgName );	
							}

							$mailing->enviar_prueba( $emaildeprueba, $_POST['asunto'], $_POST['mensaje'], $imagen );

							$mensaje = "El email de prueba fue enviado a ". $_POST['test'];
						} else {
							$correos = $data_base->listar_correos();
							$mailing = new Mailer( "boletin" );
							$entregados = 0;
							$rebotados = 0;

						// Hacemos una condicion en la que solo permitiremos que se suban imagenes y que sean menores a 20 KB
						    if ((($_FILES["archivo"]["type"] == "image/gif") ||  
						    	($_FILES["archivo"]["type"] == "image/jpeg") ||  
						    	($_FILES["archivo"]["type"] == "image/pjpeg")) &&  
						    	($_FILES["archivo"]["size"] < 50000)) 
						    {
							
								$varrand = substr(md5(uniqid(rand())),0,10);			
								$directorio = "/images/";  

								$varname = $_FILES["imagen"]['name'];
								$vartemp = $_FILES['imagen']['tmp_name'];
								$vartype = $_FILES['imagen']['type'];			
								
								$imgName = $varrand.".".$i;				
								$imagen = $directorio.$imgName;				

								move_uploaded_file($_FILES["archivo"]["tmp_name"], "../images/" . $imgName );			 
								
							}

							foreach ($correos as $valor ) 
							{
								if( $mailing->enviar_email( $valor['email'], $valor['id_email'], $_POST['asunto'], $_POST['mensaje'], $imagen ) )
								{
									$entregados = $entregados + 1;
								} else {
									$rebotados = $rebotados + 1;
								}
							}

							$data_base->guardar_campaigns( $entregados, $rebotados, $imagen );
							$data_base->database_close();

							$mensaje = "Campaña enviada con exito.";
						}
				break;
			
			case 'form2':
				if( $nuevosCorreos = $_POST['correos-nuevos'] )
				{
					$correos = explode( ',', $nuevosCorreos );
					list( $er, $ok ) = $data_base->guardar_correos( $correos );
					$mensaje = "Se guardaron ".$ok ;
					$mensaje .= " direccion/es de email y se conocieron ".$er." error/es.";					
				}
				break;
		} // final del switch			
		
	} elseif( $_POST && $_POST['codigo'] != $code ) { $mensaje = "El codigo ingresado no es correcto."; }
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <title>Administrador Newsletter Campaigns</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" type="text/css" href="styles.css" />
	<link href='http://fonts.googleapis.com/css?family=Economica:700,400italic' rel='stylesheet' type='text/css'>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.easing.1.3.js"></script>
</head>
<body>	 
    <div id="header">
	<div id="logo"><a href="#"><img src="images/logo.png"></a></div>
	<h3><?php echo $mensaje; ?></h3>
		<ul id="main-menu">
	    	<li><a href="#campaigns">Campañas</a></li>
	        <li><a href="#new-campaign">Nueva campaña</a></li>
	        <li><a href="#suscriber">Listado de emails</a></li>
	        <li><a href="#agregar-correos">Agregar emails</a></li>
	    </ul>
	    <ul id="top-social">
	     	<li><a href="http://www.facebook.com/freelance.desarrollosweb" class="facebook">Facebook</a></li>
	        <li><a href="https://twitter.com/danielfreedev" class="twitter">Twitter</a></li>
	        <li><a href="http://www.linkedin.com/in/danielrussian" class="linkedin">LinkedIn</a></li>
	    </ul> 
	</div>

	<div id="container">

	    <div id="campaigns">
	    	<h1>Listado de campañas</h1>	    
	    	   
	        <div class="top-divider"></div>
	        <div class="content">	        	
	            	<ul class="table-top">
	            		<li class="indice">Identificador</li>
	            		<li class="fecha">Fecha</li>
	            		<li class="enviados">Enviados</li>
	            		<li class="rebotados">Rebotados</li>
	            		<li class="porcentaje">Porcentaje de exito</li>
	            	</ul> 
	            	<ul class="table-top">
	            	<?php if( !empty( $arrayCampaigns ) )	            		{	        			

		            		foreach ($arrayCampaigns as $valor ) { ?>	            	
			            		<li><?php echo $valor['id_campaign'] ;?></li>
			            		<li><?php echo date( 'd-m-Y', $valor['fecha'] ) ;?></li>
			            		<li><?php echo $valor['enviados'] ;?></li>
			            		<li><?php echo $valor['rebotados'] ;?></li>
			            		<li><?php if( $valor['enviados']>0 ) { echo 100-(($valor['rebotados']*100)/$valor['enviados']); } else { echo 0; } ?>%</li>		            		
		            		<?php } ?>
		            <?php } ?>
	            	</ul>
	        </div>
	    <div class="bottom-divider"></div> 
	    </div> <!-- #campaigns -->
	
		<div id="new-campaign">
	    	<h1>Nueva campaña</h1>	       
	        <div class="top-divider"></div>
	        <div class="content">	        	
	            <h2>Complete los datos de la nueva campaña</h2>
	            <form id="form" method="post" enctype="multipart/form-data">
	            	<label for="asunto">Asunto <img src="images/icon-user.png"></label>
	            	<input type="text" name="asunto" id="asunto">
	            	<label for="archivo">Imagen de cabecera </label>
	            	<input type="file" name="archivo" id="archivo"> 
	            	<label for="mensaje">Cuerpo del correo <img src="images/icon-message.png"></label>		            	
	            	<textarea name="mensaje" id="mensaje" cols="50" rows="10"></textarea>
	            	<label for="test">Enviar primero una copia a este correo</label>
	            	<input type="email" id="test" name="test" required="false">
	            	<label for="codigo">Ingrese el código de seguridad</label>
	            	<input id="codigo" name="codigo" type="text" size="5" maxlength="5">
	            	<input id="selector" name="selector"  type="hidden" value="form1">
	            	<input type="submit" value="enviar">
	            </form>
	        </div>
	   		<div class="bottom-divider"></div> 
	    </div> <!-- #new-campaign -->

	     <div id="suscriber">
	    	<h1>Listado de suscriptos al newsletter</h1>	    
	    	   
	        <div class="top-divider"></div>
	        <div class="content">	        	
	            	<ul class="list-email">
	            		<li class="fecha">Fecha de suscripción</li>
	            		<li class="enviados">Dirección de email</li>
	            		<li class="rebotados">Estado de la suscripción</li>
	            		
	            	</ul> 
	            	<ul class="list-email">
	            	<?php if( !empty( $arrayEmails ) ) {	        			
	            		$activos = $borrados = 0;
		            		foreach ($arrayEmails as $valor ) { ?>       	
			    				
			            		<li class="<?php echo $valor['status']; ?>"><?php echo date( 'd-m-Y', $valor['created'] ) ;?></li>
			            		<li class="<?php echo $valor['status']; ?>"><?php echo $valor['email'] ;?></li>
			            		<li class="<?php echo $valor['status']; ?>"><?php echo $valor['status'] ;?></li>
			            		<?php if( $valor['status']=='active') { $activos=$activos+1; } else { $borrados=$borrados+1; } ?>
		            		<?php } ?>
		            <?php } ?>
		            </ul>
		            <p>&nbsp;</p>
		            <p>En total hay <span class="resaltar"><?php echo ($activos+$borrados); ?></span> en la base de datos.</p>
		            <p><span class="resaltar"><?php echo $activos; ?></span> están suscriptos y <span class="resaltar"><?php echo $borrados; ?></span> que se dieron de baja.</p>
	        </div>
	    <div class="bottom-divider"></div> 
	    </div><!-- listado de suscriptos al newsletter -->

	    <div id="agregar-correos">
	    	<h1>Agregar suscriptores</h1>	       
	        <div class="top-divider"></div>
	        <div class="content">	        	
	            <form id="form" method="post">
	            	<label for="nuevos">Ingrese el listado de correos, separados por coma</label>
	            	<textarea name="correos-nuevos" id="correos-nuevos" cols="50" rows="20"></textarea>
	            	<label for="codigo">Ingrese el código de seguridad</label>
	            	<input id="codigo" name="codigo" type="text" size="5" maxlength="5">
	            	<input id="selector" name="selector" type="hidden" value="form2">
	            	<input type="submit" value="Guardar">
	            </form>
	        </div>
	   		<div class="bottom-divider"></div> 
	    </div> <!-- formulario para agregar más suscriptores -->

        <script type="text/javascript">
    		$(function() {
                $('#main-menu li a').bind('click',function(event){
                    var $anchor = $(this);
                    
                    $('html, body').stop().animate({
                        scrollTop: $($anchor.attr('href')).offset().top
                    }, 1500,'easeInOutExpo');

                    event.preventDefault();
                });
            });
			
 			 $(document).ready(function(){
    		$("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false, deeplinking: false});
  			});

        </script>

</body>
</html>