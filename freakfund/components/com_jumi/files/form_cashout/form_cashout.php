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
jimport('trama.usuario_class');
jimport('trama.error_class');

require_once 'libraries/trama/libreriasPP.php';

$token 			= JTrama::token();
$input 			= JFactory::getApplication()->input;
$usuario		= JFactory::getUser();
$idMiddleware	= UserData::getUserMiddlewareId($usuario->id);
$datosUsuario	= UserData::getUserBalance($idMiddleware->idMiddleware);

$action 		= '#';

?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		jQuery("#form_cashout").validationEngine();
		
		jQuery('#retirar').click(function() {
			
			if(confirm('<?php echo JText::_("FREAKFUND_JUMI_CASHOUT_SEGURO1"); ?>'+jQuery('#cantidad').val()+'<?php echo JText::_("FREAKFUND_JUMI_ABONOSOCIO_SEGURO2"); ?>')) {
				jQuery("#form_cashout").validationEngine();
				jQuery("#form_cashout").submit();
			} else {
				alert('<?php echo JText::_("FREAKFUND_JUMI_ABONOSOCIO_BIEN"); ?>');
			}
		});
	});
</script>
<h1><?php echo JText::_('TRANSFERIR_DINERO');  ?></h1>
<div>
	<form id="form_cashout" action="<?php echo $action; ?>" method="POST">
	
		<?php
		$saldo = $datosUsuario->balance == null ? 0 : $datosUsuario->balance;
		$cuenta = $datosUsuario->account == null ? 0 : $datosUsuario->account;
		$name = $datosUsuario->name == null ? 0 : $datosUsuario->name;
		
		echo '<div ><span class="labelsconfirmacion">'.JText::_('FREAKFUND_JUMI_ABONOSOCIO_USER').':</span> <span>'. $name .'</span></div><br / >';
		echo '<div ><span class="labelsconfirmacion">'.JText::_('SALDO_FF').':</span> $<span class="number">'. $saldo .'</span></div><br / >';
		echo '<div ><span class="labelsconfirmacion">'.JText::_('FREAKFUND_JUMI_ABONOSOCIO_CUENTA').':</span><span >'. $cuenta .'</span></div> <br />';
		$campo = '<label class="labelsconfirmacion">'.JText::_('CANTIDAD_TRANSFERENCIA').':</label>MXN $<input class="input_monto validate[required,custom[number]]" type="text" id="cantidad" name="cantidad" /><br /> ';
		
		echo $campo;
		
		?>
		<br />
		<img style="maregin-left: 30px;" width="200px" src="images/paypalbanorte.jpg" />
		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
			<input type="button" id="retirar" class="button" value="<?php echo JText::_('LBL_TRANSFERIR'); ?>" />
			
		</div>
		
	</form>
	
</div>