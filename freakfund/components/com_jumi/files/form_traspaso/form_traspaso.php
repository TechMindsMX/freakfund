<?php 
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
$usuario 	= JFactory::getUser();
$app 		= JFactory::getApplication();
// if ($usuario->guest == 1) {
	// $return = JURI::getInstance()->toString();
	// $url    = 'index.php?option=com_users&view=login';
	// $url   .= '&return='.base64_encode($return);
	// $app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
// }
jimport('trama.class');
jimport('trama.usuario_class');
jimport('trama.error_class');

require_once 'libraries/trama/libreriasPP.php';

$input 			= JFactory::getApplication()->input;
$usuario		= JFactory::getUser();
$confirm		= $input->get("confirm",0,"int");

$params = new stdClass;
$params->token			= JTrama::token();
$params->ids			= UserData::getUserMiddlewareId($usuario->id);
$params->datosUsuario	= UserData::getUserBalance($params->ids->idMiddleware);
$params->errorCode	 	= $input->get("error",0,"int");
$params->from			= $input->get("from",0,"int");
$params->confirmUrl		= 'index.php?option=com_jumi&view=appliction&fileid=29&confirm=1';
$params->action 		= MIDDLE.PUERTO.'/trama-middleware/rest/tx/transferFunds';
$params->resumeUrl		= JURI::base().'index.php?option=com_jumi&view=appliction&from=29&fileid=29';
$params->cartera 		= JURI::base().'index.php?option=com_jumi&view=appliction&from=29&fileid=24';
$params->arregloEnvio   = '';

errorClass::manejoError($params->errorCode, $params->from);

$params->beneficiarios = UserData::getBeneficiarios($params->ids->idMiddleware);

$tx						= $input->get('response', null, 'int');
if (isset($tx)) {
	$params->tx			= UserData::getTxData($tx);
}
var_dump($confirm, $params->from);
if ($params->from == 0 && $confirm == 0) formTraspaso($params, $app, $usuario);
if ($confirm == 1) 					formConfirm($params, $app, $usuario);
if ($params->from == 29) 			formResumen($params);

function formTraspaso($params, $app, $usuario) {

	$action = $params->confirmUrl;
	
	$optionsHtml = '<select id="receiverId" name="receiverId">'.PHP_EOL.'<option>'.JText::_("Seleccione").'</option>'.PHP_EOL;
	if ( empty($params->beneficiarios) ) {
		$app->enqueueMessage('Ve a TELCEL y comprate un amigo pinche forever alone', 'notice');
	} else {
		foreach ($params->beneficiarios as $key => $value) {
			$optionsHtml .= '<option value="'.$value->destinationId.'">'.$value->account.' - '.$value->name.'</option>'.PHP_EOL;
		}
	}
	$optionsHtml .= '</select>'.PHP_EOL;

	?>
	
	<script>
		jQuery(document).ready(function(){
			jQuery("#form_traspaso").validationEngine();
			
			jQuery("input#cantidad").focusout(function(){
				var saldo = <?php echo $params->datosUsuario->balance; ?>;
				var monto = parseFloat(jQuery(this).val());
				if (jQuery(this).val() > saldo) {
					var html = '<pre><?php echo JText::_("MONTO_MAYOR_A_SALDO"); ?></pre>';
					jQuery(html).insertAfter(this).fadeOut(5000);
				}
			});
		});
	</script>
	
	<h1><?php echo $usuario->name; ?></h1>
	<h2><?php echo JText::_('TRASPASO_DINERO');  ?></h2>
	
	<p><?php echo JText::_('TRASPASO_LEGEND_1'); ?></p>
	
	<div>
		<form id="form_traspaso" action="<?php echo $action; ?>" method="post">
		<div>
			<p>
				<label><?php echo JText::_('NO_CUENTA_RETIRO'); ?></label>
				<span><?php echo $params->datosUsuario->account; ?></span>
			</p>
			<p>
				<label><?php echo JText::_('FREAKFUND_JUMI_ABONOSOCIO_BALANCE'); ?></label>
				$ <span class="number"><?php echo $params->datosUsuario->balance; ?></span>
			</p>
			<br />
			<p>
				<label><?php echo JText::_('NO_CUENTA_BENEFI'); ?></label>
				<span><?php echo $optionsHtml; ?></span>
			</p>
			<p>
				<label for="tag_traspaso"><?php echo JText::_('CANTIDAD_TRASPASO'); ?></label>
				<input class="input_monto validate[required,custom[number]]" type="number" id="cantidad" name="amount" />
			</p>
		</div>
		
		<input type="hidden" name="token" value="<?php echo $params->token; ?>"> 
		<input type="hidden" name="callback" value="<?php echo $params->confirmUrl; ?>">
		<input type="hidden" name="senderId" value="<?php echo $params->ids->idMiddleware; ?>"> 
		<input type="hidden" name="objeto" value='<?php echo serialize($params); ?>'>
		
		<pre><?php echo JText::_('TRASPASO_LEGEND_2'); ?></pre>
		
			<div style="margin: 10px;">
				<input type="button" class="button" value="<?php echo JText::_('CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
			javascript:window.history.back();">
				<input type="submit" class="button" id="enviar" value="Traspasar" />
			</div>
		</form>
		
	</div>
<?php
}

function formConfirm($params, $app, $usuario) {
	
	$action = $params->action;
	
	$receiver 		= new stdClass;	
	$receiver->id	= $app->input->get('receiverId');
	$params 		= unserialize($app->input->get('objeto', '', 'str'));
	$senderId		= $app->input->get('senderId');
	$amount			= $app->input->get('amount');
	
	foreach ($params->beneficiarios as $key => $value) {
		if ($receiver->id == $value->destinationId) {
			$receiver->name = $value->name;
			$receiver->account = $value->account;
		}
	}

?>
	<h1><?php echo JText::_('TRASPASO_DINERO'); ?></h1>
	
	<form id="form_traspaso" action="<?php echo $action; ?>" method="post">
		<h3><?php echo JText::_('TRASPASO_CONFIRMA'); ?></h3>
		<div class="bloque">
			<div class="fila">
				<div><?php echo JText::_('LABEL_CONCEPTO'); ?></div>
				<div><?php echo JText::_('TRASPASO_DINERO'); ?></div>
			</div>
			<div class="fila">
				<div><?php echo JText::_('TRASPASO_BENEFICIARIO'); ?></div>
				<div><?php echo $receiver->name; ?></div>
			</div>
			<div class="fila">
				<div><?php echo JText::_('TRASPASO_BALANCE'); ?></div>
				<div><?php echo $params->datosUsuario->balance; ?></div>
			</div>
			<div class="fila">
				<div><?php echo JText::_('NO_CUENTA_BENEFI'); ?></div>
				<div><?php echo $receiver->account; ?></div>
			</div>
			<div class="fila">
				<div><?php echo JText::_('CANTIDAD_TRASPASO'); ?></div>
				<div>$ <?php echo $amount; ?></div>
			</div>
		</div>
		<input type="hidden" name="senderId" value="<?php echo $senderId; ?>"> 
		<input type="hidden" name="receiverId" value="<?php echo $receiver->id; ?>"> 
		<input type="hidden" name="amount" value="<?php echo $amount; ?>"> 
		<input type="hidden" name="token" value="<?php echo $params->token; ?>"> 
		<input type="hidden" name="callback" value="<?php echo $params->resumeUrl; ?>">

		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('CANCELAR'); ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR'); ?>'))
		javascript:window.history.back();">
			<input type="submit" class="button" id="enviar" value="<?php echo JText::_('LABEL_CONFIRMAR'); ?>" />
		</div>
	</form>

<?php
}

function formResumen($params) {
	$params->tx->id;
	$idJoomlaSender = UserData::getUserJoomlaId($params->tx->sender);
	$params->tx->senderData = UserData::getUserBalance($params->tx->sender);
	$idJoomlaReceiver = UserData::getUserJoomlaId($params->tx->receiver);
	$params->tx->receiverData = UserData::getUserBalance($params->tx->receiver);
	$params->tx->receiver;
	$params->tx->timestamp;
	$params->tx->amount;

	?>
	<h2><?php echo JText::_('RESUMEN_TRASPASO'); ?></h2>
			<p>
				<label><?php echo JText::_('TRASPASO_SENDER_NAME'); ?></label>
				<span><?php echo $params->tx->senderData->name; ?></span>
			</p>
			<p>
				<label><?php echo JText::_('NO_CUENTA_RETIRO'); ?></label>
				<span><?php echo $params->tx->senderData->account; ?></span>
			</p>
	
			<p>
				<label><?php echo JText::_('TRASPASO_BENEFICIARIO'); ?></label>
				<span><?php echo $params->tx->receiverData->name; ?></span>
			</p>
			<p>
				<label><?php echo JText::_('NO_CUENTA_BENEFI'); ?></label>
				<span><?php echo $params->tx->receiverData->account; ?></span>
			</p>
	
			<p>
				<label><?php echo JText::_('TRASPASO_AMOUNT'); ?></label>
				<span><?php echo $params->tx->amount; ?></span>
			</p>
			<p>
				<label><?php echo JText::_('TRASPASO_DATE'); ?></label>
				<span><?php echo date( 'd-m-Y h:m:s', $params->tx->timestamp/1000); ?></span>
			</p>
			<a class="button" href="<?php echo $params->cartera; ?>"><?php echo JText::_('ESCRIT'); ?></a>
	<?php
}
?>