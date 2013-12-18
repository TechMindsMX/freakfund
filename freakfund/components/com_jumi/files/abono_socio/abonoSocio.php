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
jimport('trama.usuario_class');
jimport('trama.error_class');

require_once 'libraries/trama/libreriasPP.php';

$token 				= JTrama::token();
$base 				= JUri::base();
$usuario 			= JFactory::getUser();
$document 			= JFactory::getDocument();
$app 				= JFactory::getApplication();
$idMiddleware		= UserData::getUserMiddlewareId($usuario->id);
$callback 			= $base.'index.php?option=com_jumi&view=application&fileid=32&from=32';
$pathJumi 			= $base.'components/com_jumi/files/classIncludes/';
$accion				= MIDDLE.PUERTO.'/trama-middleware/rest/paypal/payment';
$usuario->balance 	= UserData::getUserBalance($idMiddleware->idMiddleware)->balance;
$cuenta				= UserData::getUserBalance($idMiddleware->idMiddleware);
$jinput 			= $app->input;
$amount 			= $jinput->get('amount', '', 'INT');
$balance 			= $jinput->get('balance', '', 'INT');
$timestamp 			= $jinput->get('timestamp', '', 'INT');
$errorCode 			= $jinput->get('error', '', 'INT');
$from	 			= $jinput->get('from', '', 'INT');

errorClass::manejoError($errorCode, $from);
$html = '<div>
		 	<h3>'.JText::_('FREAKFUND_JUMI_ABONOSOCIO_TITLE_ABONAR').'</h3>
		
		 	<p><'.$usuario->name.'</p>
		
			<p>
				<span>'.JText::_('FREAKFUND_JUMI_ABONOSOCIO_BALANCE').'</span>
				$<span class="number">'.$usuario->balance.'</span>
			</p>
		
		 </div>';


echo '<script src="'.$base.'libraries/trama/js/jquery.number.min.js"> </script>';

if( $amount != '' && $balance != '' && $timestamp != '' ) {
	$saldoAnterior	= $balance - $amount;
	$fechaActual	= date('d-m-Y', ($timestamp/1000));
	
	$metodoPago = 'Paypal';
	
	$html = '<div>
			
		<h4>'.JText::_("FREAKFUND_JUMI_ABONOSOCIO_DATA").'</h4>
		
		<p>
			<span class="labelsconfirmacion">'.JText::_("FREAKFUND_JUMI_ABONOSOCIO_SALDO_ANTES").'</span>
			$<span class="number">'.$saldoAnterior.'</span>
		</p>
		
		<p>
			<span class="labelsconfirmacion">'.JText::_("FREAKFUND_JUMI_ABONOSOCIO_MONTO").'</span>
			$<span class="number">'.$amount.'</span>
		</p>
		
		<p>
			<span class="labelsconfirmacion">'.JText::_("FREAKFUND_JUMI_ABONOSOCIO_SALDO_ACTUAL").'</span>
			$<span class="number">'.$balance.'</span>
		</p>
		
		<p>
			<span class="labelsconfirmacion">'.JText::_("FREAKFUND_JUMI_ABONOSOCIO_FECHA").'</span>
			'.$fechaActual.'
		</p>
		
		<p>
			<span class="labelsconfirmacion">'.JText::_("FREAKFUND_JUMI_ABONOSOCIO_METEDO_PAGO").'</span>
			'.$metodoPago.'
					<img style="maregin-left: 30px;" width="200px" src="images/paypal.jpg" />
		</p>
		<p>
				<a href="index.php?option=com_jumi&view=application&fileid=24" class="button">'.JText::_("IR_A_CARTERA").'</a>	
		</p>
	</div>';
}else{
	$html='
		<div id="hiddens">
		<input type="hidden" name="callback" id="callback" value="'.$callback.'" />
		<input type="hidden" name="token" id="token" value="'.$token.'" />
		<input type="hidden" name="userId" id="userId" value="'.$idMiddleware->idMiddleware.'" />
		</div>
		<div>
		<label class="labelsconfirmacion" for="amount">'.JText::_("MONTO").' MXN  $</label>
				<input type="text" name="amount" id="amount" class="validate[custom[number], required]" />
				<img style="maregin-left: 30px;" width="110px" src="images/paypal.jpg" />
			</div>
				
			<div>
				<input type="button" class="button" value="'. JText::_("CANCELAR").' " onclick="javascript:window.history.back();" />
				<input type="button" class="button" id="abonar" value=" '.JText::_("FREAKFUND_JUMI_ABONOSOCIO_ABONAR").' " />		
			</div>';
}

?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		jQuery("#formAbono").validationEngine();
		
		
		jQuery('#abonar').click(function() {
			
			if(confirm('<?php echo JText::_("FREAKFUND_JUMI_ABONOSOCIO_SEGURO1"); ?>'+jQuery('#amount').val()+'<?php echo JText::_("FREAKFUND_JUMI_ABONOSOCIO_SEGURO2"); ?>')) {
				jQuery("#formAbono").validationEngine();
				jQuery("#formAbono").submit();
			} else {
				alert('<?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_BIEN'); ?>');
			}
		});
	});
</script>
	<h3><?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_TITLE_ABONAR'); ?></h3>
	
	<p>
			<span class="labelsconfirmacion"><?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_USER'); ?>: </span>
			<?php echo $usuario->name;?>
		</p>
		<p>
			<span class="labelsconfirmacion"><?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_CUENTA'); ?>: </span>
			<?php echo $cuenta->account;?>
		</p>
		
<form action="<?php echo $accion;  ?>" id="formAbono" method="post">
		
	<?php
		echo $html; 
	?>
	
</form>