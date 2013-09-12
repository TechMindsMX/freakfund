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


$token = JTrama::token();

$input = JFactory::getApplication()->input;
$usuario= JFactory::getUser();
$datosUsuario=JTrama::getUserBalance($usuario->id);

$friends=JTrama::searchFriends($usuario->id);
$arrayFriends=explode(',',$friends->friends);

foreach($arrayFriends as $key => $value){
	if($value!=378){
	echo JFactory::getUser($value)->name.'<br />';}
}
//definicion de campos del formulario
$action = '#';
//$action = 'components/com_jumi/files/costos_variables/post.php';
?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form_traspaso").validationEngine();
		
		
	});
</script>
<h3><?php echo JText::_('TRASPASO_DINERO');  ?></h3>
<div>
	<form id="form_traspaso" action="<?php echo $action; ?>" method="POST">
	
		<?php 	
		if ($datosUsuario->balance == null ){
			$saldo= "0";
		}else{
			$saldo= $datosUsuario->balance;
		}
		echo '<div>'.JText::_('SALDO_FF').':'. $saldo .'</div>';
		$campo = '<label>'.JText::_('CANTIDAD_TRASPASO').':</label>MXN $<input class="input_monto validate[required,custom[number]]" type="text" id="cantidad" name="cantidad" /> ';
		
		echo $campo;
		
		?>
		
		<div style="margin: 10px;">
			<input type="button" class="button" value="Cancelar" onclick="history.go(-1);" /> 
			<input type="button" class="button" value="Traspasar" />
		</div>
	</form>
	
</div>