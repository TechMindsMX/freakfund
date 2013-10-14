<?php
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
jimport('trama.class');

$token 			= JTrama::token();
$base 			= JUri::base();
$usuario 		= JFactory::getUser();
$document 		= JFactory::getDocument();
$callback 		= $base.'index.php?option=com_jumi&view=application&fileid=29&proyid=';
$errorCallback 	= $base.'index.php?option=com_jumi&view=application&fileid=29&proyid=';
$pathJumi 		= $base.'components/com_jumi/files/classIncludes/';

$document->addStyleSheet($pathJumi.'css/validationEngine.jquery.css');
echo '<script src="'.$pathJumi.'js/jquery.validationEngine-es.js"> </script>';
echo '<script src="'.$pathJumi.'js/jquery.validationEngine.js"> </script>';
?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		jQuery("#formAbono").validationEngine();
		
		jQuery('#abonar').click(function() {
			if(confirm('¿Esta seguro que quiere abonar la cantidad de $'+jQuery('#amount').val()+'? ¡Esta accion es IRREVERSIBLE!')) {
				jQuery("#formAbono").validationEngine();
				jQuery("#formAbono").submit();
			} else {
				alert('Bien hecho');
			}
		});
	});
</script>
<form action="#" id="formAbono">
	<div>
		<h3><?php echo strtoupper('Abono de cuenta de Socio'); ?></h3>
	</div>
	<div id="hiddens">
		<input type="hidden" name="callback" id="callback" value="<?php echo $callback; ?>" />
		<input type="hidden" name="errorCallback" id="errorCallback" value="<?php echo $errorCallback; ?>" />
		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
		<input type="hidden" name="userId" id="userId" value="<?php echo $usuario->id; ?>" />
	</div>
	<div>
		<label for="amount"><?php echo JText::_('MONTO'); ?></label>
		<input type="text" name="amount" id="amount" class="validate[required]" />
	</div>
	<div>
		<input type="button" id="abonar" value="<?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_ABONAR'); ?>" />
	</div>
</form>