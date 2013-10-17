<?php 

defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
$usuario 	= JFactory::getUser();
$app 		= JFactory::getApplication();

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
$action 		= '#';
echo '<script src="'.$base.'libraries/trama/js/jquery.number.min.js"> </script>';
?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form_cashout").validationEngine();
		jQuery("span.number").number(true,2,',','.');
	});
</script>
<h1><?php echo JText::_('TRANSFERIR_DINERO');  ?></h1>
<div>
	<form id="form_cashout" action="<?php echo $action; ?>" method="POST">
	
		<?php 	
		if ($datosUsuario->balance == null ){
			$saldo= "0";
		}else{
			$saldo= $datosUsuario->balance;
		}
		echo '<div>'.JText::_('SALDO_FF').': $<span class="number">'. $saldo .'</span></div>';
		$campo = '<label>'.JText::_('CANTIDAD_TRANSFERENCIA').':</label>MXN $<input class="input_monto validate[required,custom[number]]" type="text" id="cantidad" name="cantidad" /> ';
		
		echo $campo;
		
		?>
		
		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
			<input type="button" class="button" value="Transferir" />
		</div>
	</form>
	
</div>