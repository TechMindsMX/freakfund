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
require_once 'components/com_jumi/files/classIncludes/libreriasPP.php';

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token = JTrama::token();

$input = JFactory::getApplication()->input;
$usuario= JFactory::getUser();
$datosUsuario=JTrama::getUserBalance($usuario->id);

//definicion de campos del formulario
$action = '#';
//$action = 'components/com_jumi/files/costos_variables/post.php';
?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form_codigo").validationEngine();
		jQuery("#enviar").click(function(){
			
			var request = $.ajax({
     			url:"libraries/trama/js/ajax2.php",
 				data: {
  					"codigo": jQuery("#codigo").val(),
  					"userId": <?php echo $usuario->id; ?>,
  					"fun": 4
 				},
 				type: 'post'
			});

			request.done(function(result){
	 			obj = eval('(' + result + ')');
	 			
	 			
	 			
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
	
		<?php echo JText::_('CODIGO_PROMO');  ?> <input type="text" id="codigo"name="codigo">
		
		 <script type="text/javascript"
       src="http://www.google.com/recaptcha/api/challenge?k=6LfC7OcSAAAAAB9GjWlswYzG7UyuWR6lonUy1h85">
    </script>
    <noscript>
       <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LfC7OcSAAAAAB9GjWlswYzG7UyuWR6lonUy1h85"
           height="300" width="500" frameborder="0"></iframe><br>
       <textarea name="recaptcha_challenge_field" rows="3" cols="40">
       </textarea>
       <input type="hidden" name="recaptcha_response_field"
           value="manual_challenge">
    </noscript>
		
		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
			<input type="button" class="button" id="enviar" value="Redimir" />
		</div>
		
		
	</form>
	
</div>