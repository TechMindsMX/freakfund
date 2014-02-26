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
$input 			= JFactory::getApplication()->input;
$usuario		= JFactory::getUser();
$idMiddleware	= UserData::getUserMiddlewareId($usuario->id);
$datosUsuario	= UserData::getUserBalance($idMiddleware->idMiddleware);
$callback		= JURI::base().'index.php?option=com_jumi&view=application&fileid=24&from=36';
$confirmacion	= $input->get('confirmacion', 0, 'int');
$typeAccount	= $input->get('typeAccount', '', 'string');
$bank			= $input->get('bank', '', 'string');
$account		= $input->get('account', 0, 'string');
$error			= $input->get('errorCode', null, 'int');
$accountNumber	= $input->get('numCuenta', '', 'string');

errorClass::manejoError($error, '36');

if($confirmacion==0){
	$action	= JURI::base().'index.php?option=com_jumi&view=application&fileid=36';
	$textBotton = JText::_('LBL_GUARDAR');
}else{
	$action	= JURI::base().'index.php?option=com_jumi&view=application&fileid=24';
	$textBotton = JText::_('LABEL_CONFIRMAR');
	
	$tipoCuenta = array("001"=>JText::_('CUENTA_BANCARIA_CUENTA_BANORTE'),
						"040"=>JText::_('CUENTA_BANCARIA_CLABE'));

	
	$bancos = array("002"=>JText::_('BANAMEX'),
					"012"=>JText::_('BBVA_BANCOMER'), 
					"014"=>JText::_('BANCO_SANTANDER'), 
					"019"=>JText::_('BANJERCITO'), 
					"021"=>JText::_('HSBC'),
					"030"=>JText::_('BANCO_BAJIO'),
					"032"=>JText::_('IXE_BANCO'),
					"036"=>JText::_('BANCO_INBURSA'),
					"037"=>JText::_('BANCO_INTERACCIONES'),
					"042"=>JText::_('BANCA_MIFEL'),
					"044"=>JText::_('SCOTIABANK_INVERLAT'),
					"058"=>JText::_('BANCO_REGIONAL DE MONTERREY'),
					"059"=>JText::_('BANCO_INVEX'),
					"060"=>JText::_('BANSI'),
					"062"=>JText::_('BANCA_AFIRME'),
					"072"=>JText::_('BANORTE'), 
					"103"=>JText::_('AMERICAN_EXPRESS_BANK'),
					"106"=>JText::_('BANK_AMERICA_MEXICO'),
					"127"=>JText::_('BANCO_AZTECA'));
}

?>
<script language="JavaScript">
	jQuery(document).ready(function(){
		jQuery("#form_cashout").validationEngine();
		
		jQuery('.guarda').val('<?php echo $textBotton; ?>');
		
		jQuery('#typeAccount').change(function(){
			var tipoCuenta = jQuery(this).val();
			
			if(tipoCuenta == '120'){
				jQuery('#account').prop('maxlength', 15);
			}
			
			if(tipoCuenta == '001' || tipoCuenta == '100'){
				jQuery('#account').prop('maxlength', 20);
				jQuery('#bank').val('072');
			}else{
				jQuery('#bank').val('');
			}
		});
	});
	
	function btnCancel(){
		if( confirm('<?php echo JText::_('CONFIRMAR_CANCELAR'); ?>') )
			javascript:window.history.back();
	}
</script>

<div>

	<form id="form_cashout" action="<?php echo $action; ?>" method="POST">
<?php
if($confirmacion == 0){
?>
		<h1><?php echo JText::_('CUENTA_BANCARIA_TITULO');  ?></h1>
		
		<input type="hidden" name="confirmacion" value="1" />
		
		<div>
			<label for="typeAccount"><?php echo JText::_('CUENTA_BANCARIA_TIPO_CUENTA'); ?></label>
			<select name="typeAccount"  class="validate[required]" id="typeAccount">
				<option value="001" selected="selected"><?php echo JText::_('CUENTA_BANCARIA_CUENTA_BANORTE'); ?></option>
				<option value="040"><?php echo JText::_('CUENTA_BANCARIA_CLABE'); ?></option>
			</select>
		</div>
		
		<div>
			<label for="bank"><?php echo JText::_('CUENTA_BANCARIA_BANCO'); ?></label>
			<select name="bank" id="bank"  class="validate[required]">
				<option value="072" selected="selected"><?php echo JText::_('BANORTE') ?></option>
				<option value="002"><?php echo JText::_('BANAMEX') ?></option>
				<option value="012"><?php echo JText::_('BBVA_BANCOMER') ?></option> 
				<option value="014"><?php echo JText::_('BANCO_SANTANDER') ?></option> 
				<option value="019"><?php echo JText::_('BANJERCITO') ?></option> 
				<option value="021"><?php echo JText::_('HSBC') ?></option>
				<option value="030"><?php echo JText::_('BANCO_BAJIO') ?></option>
				<option value="032"><?php echo JText::_('IXE_BANCO') ?></option>
				<option value="036"><?php echo JText::_('BANCO_INBURSA') ?></option>
				<option value="037"><?php echo JText::_('BANCO_INTERACCIONES') ?></option>
				<option value="042"><?php echo JText::_('BANCA_MIFEL') ?></option>
				<option value="044"><?php echo JText::_('SCOTIABANK_INVERLAT') ?></option>
				<option value="058"><?php echo JText::_('BANCO_REGIONAL DE MONTERREY') ?></option>
				<option value="059"><?php echo JText::_('BANCO_INVEX') ?></option>
				<option value="060"><?php echo JText::_('BANSI') ?></option>
				<option value="062"><?php echo JText::_('BANCA_AFIRME') ?></option>
				<option value="103"><?php echo JText::_('AMERICAN_EXPRESS_BANK') ?></option>
				<option value="106"><?php echo JText::_('BANK_AMERICA_MEXICO') ?></option>
				<option value="127"><?php echo JText::_('BANCO_AZTECA') ?></option>
			</select>
		</div>
		
		<div>
			<label for="account"><?php echo JText::_('CUENTA_BANCARIA_CUENTA_CLABE'); ?></label>
			<input type="text" id="account" name="account" maxlength="16" class="validate[required,custom[onlyNumberSp]]" value="<?php echo $accountNumber; ?>" />
		</div>
<?php
}else{
?>
		<h1><?php echo JText::_('CUENTA_BANCARIA_TITULO_CONFIRMACION');  ?></h1>
		<div><?php echo JText::_('CUENTA_BANCARIA_CONFIRMACION'); ?></div>
				
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
		<input type="hidden" name="userId" value="<?php echo $idMiddleware->idMiddleware; ?>" />
		<input type="hidden" name="userId" value="<?php echo $typeAccount; ?>" />
		<input type="hidden" name="userId" value="<?php echo $bank; ?>" />
		<input type="hidden" name="userId" value="<?php echo $account; ?>" />
		
		<div>
			<?php 
				echo '<div class="div_cuentas">'.JText::_('CUENTA_BANCARIA_TIPO_CUENTA').':</div>'.
					 '<div class="label_valor div_cuentas"><strong>'.$tipoCuenta[$typeAccount].'</strong></div>'; 
			?>
		</div>
		<div>
			<?php 
				echo '<div class="div_cuentas">'.JText::_('CUENTA_BANCARIA_BANCO').':</div>'.
					 '<div class="label_valor div_cuentas" style="margin-left:9%"><strong>'.$bancos[$bank].'</strong></div>'; 
			?>
		</div>
		<div>
			<?php 
				echo '<div class="div_cuentas">'.JText::_('CUENTA_BANCARIA_CUENTA_CLABE').':</div>'.
					 '<div class="label_valor div_cuentas"><strong>'.$account.'</strong></div>'; 
			?>
		</div>
<?php
}
?>
		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR');  ?>" onClick="btnCancel">
			<input type="submit" class="button guarda" value="<?php echo JText::_('LBL_GUARDAR'); ?>" />
		</div>
	</form>

</div>