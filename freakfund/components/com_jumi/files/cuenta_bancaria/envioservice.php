<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
$usuario 	= JFactory::getUser();
$app 		= JFactory::getApplication();
$doc   	    = JFactory::getDocument();
$doc->addStyleSheet(JURI::base().'components/com_jumi/files/cuenta_bancaria/cuenta_bancaria.css');

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

$input	 			= $app->input;
$action				= JURI::base().'index.php?option=com_jumi&view=application&fileid=38';
$bancos  			= JTrama::catalogoBancos();
$clabe 				= $input->get('clabe', null, 'string');
$claveBanco 		= $input->get('bankCode', null, 'string');
$token				= $input->get('token', null, 'string');
$userId				= $input->get('userId', null, 'string');
$callback			= $input->get('callback', null, 'string');
$usuario			= JFactory::getUser();
$idMiddleware		= UserData::getUserMiddlewareId($usuario->id);
$clabeTmp			= str_split($clabe,17);
$codigoVerificador	= intval($clabeTmp[1]);
$clabesepa			= str_split($clabeTmp[0]);
$claveBancoClabe	= $clabesepa[0].$clabesepa[1].$clabesepa[2];
$datosAccount		= UserData::getBankAccount($idMiddleware->idMiddleware);
$ponderaciones 		= array(3,7,1,3,7,1,3,7,1,3,7,1,3,7,1,3,7);
$paso3 				= 0;
$clavesbancos		= array();

foreach ($bancos as $key => $value) {
	$clavesbancos[] = $value->clave;
	if($value->claveClabe == $claveBanco){
		$nombrebanco = $value->banco;
		$claveEnvio = $value->clave;
	} 
}

foreach ($clabesepa as $key => $value) {
	$paso1[] = intval($value)*$ponderaciones[$key];
	
	$paso2[] = $paso1[$key]%10;
	
	$paso3 = $paso3+$paso2[$key];
}

$paso4 			= $paso3%10;
$paso5 			= 10-$paso4;
$paso6 			= $paso5%10;
$verificacion	= $paso6==$codigoVerificador;
$verificabanco	= $claveBanco == $claveBancoClabe;

if($verificacion and $verificabanco){
	$action	= MIDDLE.PUERTO.'/trama-middleware/rest/account/createAccount';
}else{
	$action	 = JURI::base().'index.php?option=com_jumi&view=application&fileid=36&bankCode='.$claveBanco.'&clabe='.$clabe;
	$message = JText::_('CUENTACLABE_INCORRECTA');
	$app->redirect($action, $message, 'message');
}
?>
<form action="<?php echo $action; ?>" method="post">
	<div class="confirmacion">
			<h1><?php echo JText::_('CUENTA_BANCARIA_TITULO_CONFIRMACION');  ?></h1>
			<div><?php echo JText::_('CUENTA_BANCARIA_CONFIRMACION'); ?></div>
					
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="hidden" name="userId" value="<?php echo $idMiddleware->idMiddleware; ?>" />
			<input type="hidden" name="callback" value="<?php echo $callback; ?>" />
			<input type="hidden" name="clabe" value="<?php echo $clabe; ?>" />
			<input type="hidden" name="bankCode" value="<?php echo $claveEnvio; ?>" />
			
			<div>
				<div class="div_cuentas"><?php echo JText::_('CUENTA_BANCARIA_BANCO'); ?>:</div> <span class="label_valor" id="bank"><?php echo $nombrebanco; ?></span>
			</div>
			<div>
				<div class="div_cuentas"><?php echo JText::_('CUENTA_BANCARIA_CUENTA_CLABE'); ?>:</div> <span class="label_valor" id="clabeNum"><?php echo $clabe; ?></span>
			</div>
			
			<div style="margin: 10px;">
				<input type="button" class="button cancelButton" value="<?php echo JText::_('LBL_CANCELAR');  ?>">
				<input type="submit" class="button" value="<?php echo JText::_('LBL_GUARDAR'); ?>" />
			</div>
		</div>
</form>