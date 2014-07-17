<?php 

defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
$usuario 	= JFactory::getUser();
$app 		= JFactory::getApplication();
$doc   	    = JFactory::getDocument();
$doc->addStyleSheet(JURI::base().'components/com_jumi/files/cashout/cashout.css');


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
$callback		= JURI::base().'index.php?option=com_jumi&view=application&fileid=24&from=37';
$confirmacion	= $input->get('confirmacion', 0, 'int');
$error			= $input->get('errorCode', null, 'int');
$amountWithdraw	= $input->get('amountWithdraw', null, 'float');
$mensaje		= '';
$botonCuenta	= '';
$accountNumber	= UserData::getBankAccount($idMiddleware->idMiddleware);
$datosUsuario->accountNumber 	= $accountNumber->clabe;

$total = strlen($datosUsuario->accountNumber);

if($datosUsuario->accountNumber != ''){
	$accountNumber 	= str_pad(substr($datosUsuario->accountNumber, $total-4, 4), $total-4, '*',STR_PAD_LEFT);
	$botonCuenta 	= JText::_('CASHOUT_MODIFICARCUENTA');
}else{
	$app->redirect(JURI::base().'index.php?option=com_jumi&view=application&fileid=36', JText::_('CASHOUT_MENSAJE'), 'message');
}

errorClass::manejoError($error, '37');

if($confirmacion==0){
	$action	= JURI::base().'index.php?option=com_jumi&view=application&fileid=37';
	$textBotton = JText::_('LBL_GUARDAR');
}else{
	$action	= MIDDLE.PUERTO.'/trama-middleware/rest/stp/registraOrden';
	$textBotton = JText::_('LABEL_CONFIRMAR');
}

?>
<script language="JavaScript">
	jQuery(document).ready(function(){
		jQuery("#form_cashout").validationEngine();
		jQuery('span.number').number(true,2);
		jQuery('.guarda').val('<?php echo $textBotton; ?>');
		
		jQuery("#btnCancel").click(function(){
			if( confirm('<?php echo JText::_('CONFIRMAR_CANCELAR'); ?>') )
				javascript:window.history.back();
		});
	});
</script>

<div>

	<form id="form_cashout" action="<?php echo $action; ?>" method="post">
<?php
if($confirmacion == 0){
?>
		<h1><?php echo JText::_('CASHOUT_TITULO');  ?></h1>
		
		<input type="hidden" name="confirmacion" value="1" />
		
		<div class="cashoutDatos">
			<?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_CUENTA').': <strong>'.$datosUsuario->account.'</strong>'; ?>
		</div>
		
		<div class="cashoutDatos">
			<?php echo JText::_('SALDO_FF').': <strong>$<span class="number">'.$datosUsuario->balance.'</span></strong>'; ?>
		</div>
		
		<div class="cashoutDatos">
			<?php echo JText::_('FORM_ALTA_TRASPASOS_CLABEFF').': <strong>'.$accountNumber.'</strong>'; ?>
			<div style="display: inline; margin-left:20px;">
					<a href="<?php echo JURI::base(); ?>index.php?option=com_jumi&view=application&fileid=36&numCuenta=<?php echo $datosUsuario->accountNumber; ?>" class="button">
						<?php echo $botonCuenta; ?>
					</a>
			</div>
		</div>
		
		<div class="cashoutDatos">
			<label for="amountWithdraw"><?php echo JText::_('CASHOUT_MONTO'); ?>: </label>
			<input type="text" class="validate[required, custom[number]]" name="amountWithdraw" />
		</div>
<?php
}else{
?>
		<h1><?php echo JText::_('CASHOUT_TITULO_CONFIRMACION');  ?></h1>
		
		<h2 style="color:#99ccff"><?php echo $mensaje; ?></h2>

		<div>
			<?php echo JText::_('CASHOUT_CONFIRMACION'); ?>
		</div>
		
		<div>
			<?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_CUENTA').': <strong>'.$datosUsuario->account.'</strong>'; ?>
		</div>
		
		<div>
			<?php echo JText::_('SALDO_FF').': <strong>$<span class="number">'.$datosUsuario->balance.'</span></strong>'; ?>
		</div>
		
		<div>
			<?php echo JText::_('FORM_ALTA_TRASPASOS_CLABEFF').': <strong>'.$accountNumber.'</strong>'; ?>
		</div>
		
		<div>
			<?php echo JText::_('CASHOUT_MONTO').': <strong>$<span class="number">'.$amountWithdraw.'<span></strong>'; ?>
		</div>
		
		<input type="hidden" name="userId" value="<?php echo $idMiddleware->idMiddleware; ?>">
		<input type="hidden" name="amount" value="<?php echo $amountWithdraw; ?>">
		<input type="hidden" name="token" value="<?php echo $token; ?>">
		<input type="hidden" name="callback" value="<?php echo $callback; ?>">
		
<?php
}
?>
		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR');  ?>" id="btnCancel">
			<input type="submit" class="button guarda" value="<?php echo JText::_('LBL_GUARDAR'); ?>" />
		</div>
	</form>

</div>