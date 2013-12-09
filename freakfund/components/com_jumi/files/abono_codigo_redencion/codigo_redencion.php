<?php 

defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}

jimport('trama.class');
require_once 'libraries/trama/libreriasPP.php';

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token 			= JTrama::token();
$input 			= JFactory::getApplication()->input;
$usuario		= JFactory::getUser();

//definicion de campos del formulario
$action = '#';
?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form_codigo").validationEngine();
		jQuery("#enviar").click(function(){
			
			var request = $.ajax({
     			url:"libraries/trama/js/ajax.php",
 				data: {
  					"recaptcha_challenge_field": jQuery("#form_codigo input[name='recaptcha_challenge_field']").val(),
  					"recaptcha_response_field": jQuery("#form_codigo input[name='recaptcha_response_field']").val(),
  					"fun": 4
 				},
 				type: 'post'
			});

			request.done(function(result){
	 			obj = eval('(' + result + ')');

	 			if(obj.mensaje) {
	 				var request = $.ajax({
	 	     			url:"libraries/trama/js/ajax.php",
	 	 				data: {
	 	  					"codigo": jQuery("#codigo").val(),
	 	  					"userId": '<?php echo $usuario->email; ?>',
	 	  					"fun": 5
	 	 				},
	 	 				type: 'post'
	 				});

	 				request.done(function(result){
	 		 			obj = eval('(' + result + ')');

						jQuery("#ajax_done").css("display","block");
 			 			jQuery("#producto").text(obj.nombreProy);
 			 			jQuery("#monto").text(obj.monto);
 			 			jQuery("#tasa").text(obj.tasa);
	 				});
		 		}else{
					alert(obj.error);
	 			}
			});
	
			request.fail(function (jqXHR, textStatus) {
	 			console.log('Error:' + jqXHR.status);
	    	});
		});
	});
</script>

<h1><?php echo JText::_('REDENCION_CODIGO');  ?></h1>
<div>
	<form id="form_codigo" action="<?php echo $action; ?>" method="POST">
	
	<div>
		<label for="proys"><?php echo JText::_('CODIGO_PROYECTOS'); ?></label>
		<select name="proys">
		<?php
			$proyectos = JTrama::getProyByStatus('5,6,7');
			foreach($proyectos as $key => $value){
				echo '<option value="'.$value->id.'">'.$value->name.'</option>';
			}
		?>
		</select>
	</div>
	
	<div>
		<label for="codigo" ><?php echo JText::_('CODIGO_PROMO');  ?></label> 
		<input type="text" class="validate[required,custom[onlyLetterNumber]]" id="codigo" name="codigo">
	</div>
	
	<script type="text/javascript"
       src="http://www.google.com/recaptcha/api/challenge?k=6LeDLOgSAAAAAIfown4LiNrDQgkwPVZ9FOG6moog">
    </script>
    
    <noscript>
       <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LeDLOgSAAAAAIfown4LiNrDQgkwPVZ9FOG6moog" height="300" width="500" frameborder="0"></iframe>
       <textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
       <input type="hidden" name="recaptcha_response_field" value="manual_challenge">
    </noscript>
		
	<div style="margin: 10px;">
		<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
	javascript:window.history.back();">
		<input type="button" class="button" id="enviar" value="Redimir" />
	</div>
	
	<div id="ajax_done" style="display: none">
		Producto invertido:	<span id="producto"></span><br>
		Monto invertido:	<span id="monto"></span><br>
		Tasa de retorno al momento:	<span id="tasa"></span>
	</div>
		
	</form>
	
</div>