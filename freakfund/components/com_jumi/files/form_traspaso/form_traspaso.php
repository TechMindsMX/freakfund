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

require_once 'components/com_jumi/files/classIncludes/libreriasPP.php';

$input 			= JFactory::getApplication()->input;
$usuario		= JFactory::getUser();
$confirm		= $input->get("confirm",0,"int");

$params = new stdClass;
$params->token			= JTrama::token();
$params->idMiddleware	= UserData::getUserMiddlewareId($usuario->id);
$params->datosUsuario	= UserData::getUserBalance($params->idMiddleware->idMiddleware);
$params->errorCode	 	= $input->get("error",0,"int");
$params->from			= $input->get("from",0,"int");
$params->confirmUrl		= 'index.php?option=com_jumi&view=appliction&fileid=29&confirm=1';
$params->callback 		= JURI::base().'index.php?option=com_jumi&view=appliction&from=29&fileid=24';
$params->action 		= MIDDLE.PUERTO.'/trama-middleware/rest/tx/transferFunds';
$params->arregloEnvio   = '';

errorClass::manejoError($params->errorCode, $params->from);

$beneficiarios = array();

$db =& JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('idJoomla, idMiddleware');
	$query->from($db->quoteName('#__users_middleware'));
		$db->setQuery( $query );
		$ids = $db->loadObjectList();


foreach ($ids as $key => $benef) {
//	$benef->idJoomla 	= UserData::getUserJoomlaId($benef->idMiddleware);
	$benef->nombre		= JFactory::getUser($benef->idJoomla)->name;
	$benef->no_cuenta 	= 9876543210 + $key;
	array_push($beneficiarios, $benef);
}
$params->beneficiarios = $beneficiarios;

if ($confirm == 0) formTraspaso($params, $app, $usuario);
if ($confirm == 1) formConfirm($params, $app, $usuario);

function formTraspaso($params, $app, $usuario) {

	$action = $params->confirmUrl;
	
	$optionsHtml = '<select name="receiverId">'.PHP_EOL.'<option>'.JText::_("Seleccione").'</option>'.PHP_EOL;
	if ( empty($params->beneficiarios) ) {
		$app->enqueueMessage('Ve a TELCEL y comprate un amigo pinche forever alone', 'notice');
	} else {
		foreach ($params->beneficiarios as $key => $value) {
			$optionsHtml .= '<option value="'.$value->idMiddleware.'">'.$value->no_cuenta.' - '.$value->nombre.'</option>'.PHP_EOL;
		}
	}
	$optionsHtml .= '</select>'.PHP_EOL;

	?>
	
	<script>
		jQuery(document).ready(function(){
			jQuery("#form_traspaso").validationEngine();
			jQuery("span.number").number( true, 2, ".","," );
			var arregloEnvio = new Array();
			<?php echo $arregloEnvio; ?>
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
				<span><?php echo $params->datosUsuario->no_cuenta; ?></span>
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
		<input type="hidden" name="callback" value="<?php echo $params->callback; ?>">
		<input type="hidden" name="senderId" value="<?php echo $params->idMiddleware->idMiddleware; ?>"> 
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
function formConfirm($params, $app, $usuario){
	
	$action = $params->callback;
	
	$receiver 		= new stdClass;	
	$receiver->id	= $app->input->get('receiverId');
	$params 		= unserialize($app->input->get('objeto', '', 'str'));
	$senderId		= $app->input->get('senderId');
	$amount			= $app->input->get('amount');
	
	// var_dump($params->beneficiarios);
	foreach ($params->beneficiarios as $key => $value) {
		if ($receiver->id == $value->idMiddleware) {
			$receiver->name = $value->nombre;
			$receiver->no_cuenta = $value->no_cuenta;
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
				<div><?php echo JText::_('NO_CUENTA_BENEFI'); ?></div>
				<div><?php echo $receiver->no_cuenta; ?></div>
			</div>
			<div class="fila">
				<div><?php echo JText::_('CANTIDAD_TRASPASO'); ?></div>
				<div>$ <?php echo $amount; ?></div>
			</div>
		</div>
		<input type="hidden" name="token" value="<?php echo $params->token; ?>"> 
		<input type="hidden" name="callback" value="<?php echo $params->callback; ?>">

		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('CANCELAR'); ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR'); ?>'))
		javascript:window.history.back();">
			<input type="submit" class="button" id="enviar" value="<?php echo JText::_('LABEL_CONFIRMAR'); ?>" />
		</div>
	</form>

<?php
}

?>