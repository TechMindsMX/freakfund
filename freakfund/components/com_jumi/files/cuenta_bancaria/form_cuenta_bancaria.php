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

$token 			= JTrama::token();

$input 			= $app->input;
$idMiddleware	= UserData::getUserMiddlewareId($usuario->id);
$datosUsuario	= UserData::getUserBalance($idMiddleware->idMiddleware);
$callback		= JURI::base().'index.php?option=com_jumi&view=application&fileid=24&from=36';
$action			= JURI::base().'index.php?option=com_jumi&view=application&fileid=38';
$confirmacion	= $input->get('confirmacion', 0, 'int');
$error			= $input->get('errorCode', null, 'int');
$clabe			= $input->get('clabe', null, 'string');
$bankcode		= $input->get('bankCode', substr($clabe, 0,3), 'string');
$datosAccount	= UserData::getBankAccount($idMiddleware->idMiddleware);
$bancos		 	= JTrama::catalogoBancos();
$selected 		= '';
$options		= '<option value="000">Seleccione su opción</option>';
$selectBanco	= substr($clabe, 0,3);

foreach ($bancos as $key => $value) {
	$arrayJsBancos[]	= $value->claveClabe;

	if($bankcode == $value->claveClabe){
		$selected = 'selected="selected"';
	}else{
		$selected = '';
	}
	$options 			.= '<option value="'.$value->claveClabe.'" '.$selected.'>'.$value->banco.'</option>';
}

errorClass::manejoError($error, '36');
?>
<script language="JavaScript">
	jQuery(document).ready(function(){
		var arrayBancos = new Array();
		<?php
		foreach ($arrayJsBancos as $key => $value) {
			echo 'arrayBancos['.$key.'] = "'.$value.'";';
		}
		?> 
		jQuery("#form_cabankCodeshout").validationEngine();
		
		
		
		jQuery('#account').val('<?php echo $clabe; ?>');
		
		jQuery('.cancelButton').click(function(){
			jQuery('.formulario').show();
			jQuery('#type').val();
			jQuery('#bankCode').val();
			jQuery('#account').val()
			jQuery('.confirmacion').hide();
		});
	});

	function btnCancel(){
		if( confirm('<?php echo JText::_('CONFIRMAR_CANCELAR'); ?>') )
			javascript:window.history.back();
	}
</script>

<div>

	<form id="form_cashout" action="<?php echo $action; ?>" method="POST">
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
		<input type="hidden" name="userId" value="<?php echo $idMiddleware->idMiddleware; ?>" />
		<input type="hidden" name="callback" value="<?php echo $callback; ?>" />
		
		<div class="formulario">
			<h1><?php echo JText::_('CUENTA_BANCARIA_TITULO');  ?></h1>

			<div>
				<label for="bank"><?php echo JText::_('CUENTA_BANCARIA_BANCO'); ?></label>
				<select name="bankCode" id="bankCode"  class="validate[required]">
					<?php echo $options; ?>
				</select>
			</div>
			
			<div>
				<label for="account"><?php echo JText::_('CUENTA_BANCARIA_CUENTA_CLABE'); ?></label>
				<input type="text" id="account" name="clabe" maxlength="18" class="validate[required,custom[onlyNumberSp]]" value="<?php echo $clabe; ?> " />
			</div>
			
			<div style="margin: 10px;">
				<input type="button" class="button" onclick="btnCancel()" value="<?php echo JText::_('LBL_CANCELAR');  ?>">
				<input type="submit" class="button guarda" value="<?php echo JText::_('LBL_GUARDAR'); ?>" />
			</div>
		</div>
	</form>

</div>