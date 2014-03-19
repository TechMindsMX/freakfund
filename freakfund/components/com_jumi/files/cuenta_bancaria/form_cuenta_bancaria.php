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
$action			= MIDDLE.PUERTO.'/trama-middleware/rest/account/createAccount';
$confirmacion	= $input->get('confirmacion', 0, 'int');
$error			= $input->get('errorCode', null, 'int');
$datosAccount	= UserData::getBankAccount($idMiddleware->idMiddleware);

errorClass::manejoError($error, '36');

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
?>
<script language="JavaScript">
	jQuery(document).ready(function(){
		jQuery("#form_cashout").validationEngine();
		
		<?php
			if(!is_null($datosAccount)){
				echo 'jQuery("#type").val("'.$datosAccount->type.'");';
				echo 'jQuery("#bankCode").val("'.$datosAccount->bankCode.'");';
				if($datosAccount->type != '001'){
					echo 'jQuery("#bankCode").prop("disabled", false);';
				}
				echo 'jQuery("#account").val("'.$datosAccount->account.'");';
			}
		?>
		
		jQuery('#type').change(function(){
			if(this.value == '001'){
				jQuery('#bankCode').val('072');
				jQuery('#bankCode').prop('disabled', 'disabled');
			}else{
				jQuery('#bankCode').prop('disabled', '');
			}
			
		})
		
		jQuery('.guarda').click(function(){
			jQuery('.formulario').hide();
			jQuery('#bankCode').prop('disabled', false);
			jQuery('#typeAccount').html(jQuery('#type option:selected').html());
			jQuery('#bank').html(jQuery('#bankCode option:selected').html());
			jQuery('#clabeNum').html(jQuery('#account').val());
			jQuery('.confirmacion').show();
		});
		
		jQuery('.cancelButton').click(function(){
			jQuery('.formulario').show();
			jQuery('#type').val();
			jQuery('#bankCode').val();
			jQuery('#account').val()
			jQuery('.confirmacion').hide();
		});
		
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
		<div class="formulario">
			<h1><?php echo JText::_('CUENTA_BANCARIA_TITULO');  ?></h1>
			
			<div>
				<label for="typeAccount"><?php echo JText::_('CUENTA_BANCARIA_TIPO_CUENTA'); ?></label>
				<select name="type" id="type" class="validate[required]">
					<?php
					foreach ($tipoCuenta as $key => $value) {
						$selected = $key=='001'?'selected="selected"':'';
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
					?>
				</select>
			</div>
			
			<div>
				<label for="bank"><?php echo JText::_('CUENTA_BANCARIA_BANCO'); ?></label>
				<select name="bankCode" id="bankCode"  class="validate[required]" disabled="disabled">
					<?php
					foreach ($bancos as $key => $value) {
						$selected = $key=='072'?'selected="selected"':'';
						echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
					?>
				</select>
			</div>
			
			<div>
				<label for="account"><?php echo JText::_('CUENTA_BANCARIA_CUENTA_CLABE'); ?></label>
				<input type="text" id="account" name="account" maxlength="16" class="validate[required,custom[onlyNumberSp]]" value="" />
			</div>
			
			<div style="margin: 10px;">
				<input type="button" class="button cancelButton" value="<?php echo JText::_('LBL_CANCELAR');  ?>">
				<input type="button" class="button guarda" value="<?php echo JText::_('LBL_GUARDAR'); ?>" />
			</div>
		</div>

		<div class="confirmacion" style="display: none;">
			<h1><?php echo JText::_('CUENTA_BANCARIA_TITULO_CONFIRMACION');  ?></h1>
			<div><?php echo JText::_('CUENTA_BANCARIA_CONFIRMACION'); ?></div>
					
			<input type="hidden" name="token" value="<?php echo $token; ?>" />
			<input type="hidden" name="userId" value="<?php echo $idMiddleware->idMiddleware; ?>" />
			<input type="hidden" name="callback" value="<?php echo $callback; ?>" />
			
			<div>
				<?php 
					echo '<div class="div_cuentas">'.JText::_('CUENTA_BANCARIA_TIPO_CUENTA').':</div> <span class="label_valor" id="typeAccount"></span>';
				?>
			</div>
			<div>
				<?php 
					echo '<div class="div_cuentas">'.JText::_('CUENTA_BANCARIA_BANCO').':</div> <span class="label_valor" id="bank"></span>';
				?>
			</div>
			<div>
				<?php 
					echo '<div class="div_cuentas">'.JText::_('CUENTA_BANCARIA_CUENTA_CLABE').':</div> <span class="label_valor" id="clabeNum"></span>';
				?>
			</div>
			
			<div style="margin: 10px;">
				<input type="button" class="button cancelButton" value="<?php echo JText::_('LBL_CANCELAR');  ?>">
				<input type="submit" class="button" value="<?php echo JText::_('LBL_GUARDAR'); ?>" />
			</div>
		</div>
	</form>

</div>