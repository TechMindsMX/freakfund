
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

$token 			= JTrama::token();
$input 			= JFactory::getApplication()->input;
$usuario		= JFactory::getUser();
$datosUsuario	= JTrama::getUserBalance($usuario->email);
$friends		= JTrama::searchFriends($usuario->id);
$callback 		= JURI::base().'index.php?option=com_jumi&view=appliction&fileid=29';
$errorCallback 	= JURI::base().'index.php?option=com_jumi&view=appliction&fileid=29';
$action 		= MIDDLE.PUERTO.'/trama-middleware/rest/tx/transferFunds';
$arrayFriends	= explode(',',$friends->friends);
$arregloEnvio   = '';

foreach($arrayFriends as $key => $value){
	if($value!=378){
		$arregloEnvio .= 'arregloEnvio["'.JFactory::getUser($value)->name.'"] = "'.JFactory::getUser($value)->email.'";';
		$arregloAmigos[] = '"'.JFactory::getUser($value)->name.'"';
	}
}
$amigosJs = implode(',' ,$arregloAmigos);

?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>
	jQuery(function() {
  	var availableTags = [<?php echo $amigosJs;?>];
    jQuery( "#tag_traspaso" ).autocomplete({
	    	source: availableTags
		});
	});
	
	jQuery(document).ready(function(){
		jQuery("#form_traspaso").validationEngine();

		var arregloEnvio = new Array();
		<?php echo $arregloEnvio; ?>

		jQuery("#enviar").click(function(){
			var receiverEmail = arregloEnvio[jQuery('#tag_traspaso').val()];
			jQuery('#receiverEmail').val(receiverEmail);
			
			jQuery('#form_traspaso').submit();
		});
	});
</script>

<h1><?php echo JText::_('TRASPASO_DINERO');  ?></h1>

<div>
	<form id="form_traspaso" action="<?php echo $action; ?>" method="post">
	<div >
	  <label for="tag_traspaso">Nombre de amigo a traspasar dinero: </label>
	  <input id="tag_traspaso" />
	</div>
	
	<input type="hidden" name="receiverEmail" id="receiverEmail" >
	<input type="hidden" name="token" value="<?php echo $token?>"> 
	<input type="hidden" name="senderEmail" value="<?php echo $usuario->email; ?>"> 
	<input type="hidden" name="callback" value="<?php echo $callback ?>"> 
	<input type="hidden" name="errorCallback" value="<?php echo $errorCallback ?>"> 
	
		<?php 	
		if ($datosUsuario->balance == null ){
			$saldo = "0";
		}else{
			$saldo = $datosUsuario->balance;
		}
		echo '<div style="margin-top: 35px;">'.JText::_('SALDO_FF').': '. $saldo .'</div>';
		$campo = '<label>'.JText::_('CANTIDAD_TRASPASO').':</label>MXN $<input class="input_monto validate[required,custom[number]]" type="text" id="cantidad" name="amount" /> ';
		
		echo $campo;
		
		?>
		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
			<input type="button" class="button" id="enviar" value="Traspasar" />
		</div>
	</form>
	
</div>