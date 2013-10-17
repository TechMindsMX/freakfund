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

$token 				= JTrama::token();
$base 				= JUri::base();
$usuario 			= JFactory::getUser();
$document 			= JFactory::getDocument();
$app 				= JFactory::getApplication();
$callback 			= $base.'index.php?option=com_jumi&view=application&fileid=32';
$errorCallback 		= $base.'index.php?option=com_jumi&view=application&fileid=32';
$pathJumi 			= $base.'components/com_jumi/files/classIncludes/';
$accion				= 'http://192.168.0.107:7171/trama-middleware/rest/paypal/payment';
$usuario->balance 	= JTrama::getUserBalance($usuario->email)->balance;
$jinput 			= $app->input;
$amount 			= $jinput->get('amount', '', 'INT');
$balance 			= $jinput->get('balance', '', 'INT');
$timestamp 			= $jinput->get('timestamp', '', 'INT');

$html = '<div>
		 	<h3>'.JText::_('FREAKFUND_JUMI_ABONOSOCIO_TITLE_ABONAR').'</h3>
		
		 	<p><'.$usuario->name.'</p>
		
			<p>
				<span>'.JText::_('FREAKFUND_JUMI_ABONOSOCIO_BALANCE').'</span>
				$<span class="number">'.$usuario->balance.'</span>
			</p>
		
		 </div>';

$document->addStyleSheet($pathJumi.'css/validationEngine.jquery.css');
echo '<script src="'.$pathJumi.'js/jquery.validationEngine-es.js"> </script>';
echo '<script src="'.$pathJumi.'js/jquery.validationEngine.js"> </script>';
echo '<script src="'.$base.'libraries/trama/js/jquery.number.min.js"> </script>';

if( $amount != '' && $balance != '' && $timestamp != '' ) {
	$saldoAnterior	= $balance - $amount;
	$fechaActual	= date('d-m-Y', ($timestamp/1000));
	
	$metodoPago = 'Paypal';
	
	$html = '<div>
		<h3>'.JText::_('FREAKFUND_JUMI_ABONOSOCIO_TITLE_ABONAR').'</h3>
		
		<h4>Datos Capturados</h4>
		
		<p>
			<span>Usuario: </span>
			'.$usuario->name.'
		</p>
		
		<p>
			<span>Saldo Anterior</span>
			$<span class="number">'.$saldoAnterior.'</span>
		</p>
		
		<p>
			<span>Monto abonado</span>
			$<span class="number">'.$amount.'</span>
		</p>
		
		<p>
			<span>Saldo Actual</span>
			$<span class="number">'.$balance.'</span>
		</p>
		
		<p>
			<span>Fecha de la transacción</span>
			'.$fechaActual.'
		</p>
		
		<p>
			<span>Metodo de pago</span>
			'.$metodoPago.'
		</p>
		
	</div>';
}

?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		jQuery("#formAbono").validationEngine();
		jQuery("span.number").number(true,2,',','.');
		
		
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
<form action="<?php echo $accion;  ?>" id="formAbono" method="post">
		
	<?php
		echo $html; 
	?>
	<div id="hiddens">
		<input type="hidden" name="callback" id="callback" value="<?php echo $callback; ?>" />
		<input type="hidden" name="errorCallback" id="errorCallback" value="<?php echo $errorCallback; ?>" />
		<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
		<input type="hidden" name="email" id="email" value="<?php echo $usuario->email; ?>" />
	</div>
	<div>
		<label for="amount"><?php echo JText::_('MONTO'); ?></label>
		<input type="text" name="amount" id="amount" class="validate[custom[number], required]" />
	</div>
	<div>
		<input type="button" class="button" id="abonar" value="<?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_ABONAR'); ?>" />
		<input type="button" class="button" value="<?php echo JText::_('CANCELAR'); ?>" onclick="javascript:window.history.back();" />
	</div>
</form>