<?php 
	include( '../classes/BD.class.php' ); 
	$data_base = new BD(); 
	$arrayCampaigns = $data_base->listar_campaings();
?>

<?php
	if( $_POST )
	{
		$correos = $data_base->listar_correos();
		foreach ($variable as $key => $value) {
			# code...
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <title>Administrador Newsletter Campaign</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" type="text/css" href="styles.css" />
	<link href='http://fonts.googleapis.com/css?family=Economica:700,400italic' rel='stylesheet' type='text/css'>
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script type="text/javascript" src="jquery.easing.1.3.js"></script>
</head>
<body>	 
    <div id="header">
	<div id="logo"><a href="#"><img src="images/logo.png"></a></div>
		<ul id="main-menu">
	    	<li><a href="#campaigns">Campañas</a></li>
	        <li><a href="#new-campaign">Nueva campaña</a></li>
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
	            <h2>Ordenadas por fecha de envio.</h2>	
	            	<ul class="table-top">
	            		<li class="indice"></li>
	            		<li class="fecha">Fecha</li>
	            		<li class="enviados">Enviados</li>
	            		<li class="rebotados">Rebotados</li>
	            		<li class="porcentaje">Porcentaje de exito</li>
	            	</ul> 
	            	<ul>
	            	<?php if( !empty( $listado ) )
	            		{
		            		foreach ($listado as $indice) { ?>	            	
		            		<li><?php $indice['id_campaign'] ;?></li>
		            		<li><?php $indice['fecha'] ;?></li>
		            		<li><?php $indice['enviados'] ;?></li>
		            		<li><?php $indice['rebotados'] ;?></li>
		            		<li><?php ( $indice['rebotados'] * 100 ) / $indice['enviados']; ?></li>
		            		<?php } ?>
		            	<?php } ?>
	            	</ul>
	        </div>
	    <div class="bottom-divider"></div> 
	    </div>
	
		<div id="new-campaign">
	    	<h1>Nueva campaña</h1>	       
	        <div class="top-divider"></div>
	        <div class="content">	        	
	            <h2>Complete los datos de la nueva campaña</h2>
	            <form id="form" method="post">
	            	<label for="asunto">Asunto <img src="images/icon-user.png"></label>
	            	<input type="text" name="asunto" id="asunto">
	            	<label for="mensaje">Cuerpo del correo <img src="images/icon-message.png"></label>	
	            	<textarea name="mensaje" id="mensaje" cols="50" rows="10"></textarea>
	            	<input type="submit" value="enviar">
	            </form>
	        </div>
	    <div class="bottom-divider"></div> 
	    </div>

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