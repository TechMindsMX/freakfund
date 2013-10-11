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
$token = JTrama::token();
$callback = JURI::base().'index.php?option=com_jumi&view=application&fileid=29&proyid=';
$errorCallback =JURI::base().'index.php?option=com_jumi&view=application&fileid=29&proyid=';
$usuario = JFactory::getUser();
?>

<form>
	<div id="hiddens">
		<input type="hidden" name="callback" id="callback" value="<?php echo $callback; ?>" />
		<input type="hidden" name="errorCallback" id="errorCallback" value="<?php echo $errorCallback; ?>" />
		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
		<input type="hidden" name="userId" id="userId" value="<?php echo $usuario->id; ?>" />
	</div>
	<div>
		<label for="amount"><?php echo JText::_('MONTO'); ?></label><input type="text" name="amount" id="amount" />
	</div>
	<div>
		<input type="button" id="abonar" value="<?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_ABONAR'); ?>"/>
	</div>
</form>