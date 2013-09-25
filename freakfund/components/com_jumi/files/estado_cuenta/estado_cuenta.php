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
		jQuery("#form_cuenta").validationEngine();
		
		
	});
</script>
<h1><?php echo JText::_('ESTADO_CUENTA');  ?></h1>
<div>
	<form id="form_cuenta" action="<?php echo $action; ?>" method="POST">
	
		<select name="fechas" >
			  <option value="Enero">Enero</option>
			  <option value="Febrero">Febrero</option>
			  <option value="Marzo">Marzo</option>
			  <option value="Abril">Abril</option>
		</select>
		
		<?php echo JText::_('RANGO_FECHA_INICIO');  ?> <input type="text" name="fechaini"><br>
  		<?php echo JText::_('RANGO_FECHA_FIN');  ?> <input type="text" name="fechafin"><br>
		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
			<input type="button" class="button" value="Consultar" />
		</div>
	</form>
	
</div>