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
		
		
	});
</script>
<h1><?php echo JText::_('REDENCION_CODIGO');  ?></h1>
<div>
	<form id="form_codigo" action="<?php echo $action; ?>" method="POST">
	
		<?php echo JText::_('CODIGO_PROMO');  ?> <input type="text" name="fname">
		
		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
			<input type="button" class="button" value="Consultar" />
		</div>
	</form>
	
</div>