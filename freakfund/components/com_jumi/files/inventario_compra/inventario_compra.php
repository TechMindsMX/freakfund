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
require_once 'components/com_jumi/files/crear_proyecto/classIncludes/libreriasPP.php';

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token = JTrama::token();

$input = JFactory::getApplication()->input;
$usuario= JFactory::getUser();
$proyid= $input->get("proyid",0,"int");
$pro=JTrama::getDatos($proyid);
$datosUsuario=JTrama::getUserBalance($usuario->id);

//definicion de campos del formulario
$action = MIDDLE.PUERTO.'/trama-middleware/rest/';
//$action = 'components/com_jumi/files/costos_variables/post.php';
?>

<script>
	jQuery(document).ready(function(){
		
	}	
</script>
<h3><?php echo JText::_('INVENTARIO_COMPRA');  ?></h3>
<div>
	<form id="form_compra" action="<?php echo $action; ?>" method="POST">
	
		<?php 	
		
		$boton = '<label>Cantidad a comprar:</label><input class="input_compra" type="text" id="nomProy"	name="compra" /> <input type="button" class="button" value="Invertir" />';
		
		foreach ($pro->projectUnitSales as $key => $value){
	
			echo '<div>'.JText::_('SECCION').':'. $value ->section .'</div>';
			echo '<div>'.JText::_('PRECIO_UNIDAD').':'. $value ->unitSale.'</div>';
			echo '<div>'.JText::_('INVENTARIOPP').':'. $value ->unit .'</div>';
			echo $boton;
		}
		
		echo '<div>'.JText::_('SALDO_FF').':'. $datosUsuario->balance .'</div>';
		
		?>
		<br />
		<div><input type="button" class="button" value="Cancelar" onclick="history.go(-1);" /> </div>
	</form>
	
</div>