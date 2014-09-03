<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$token 		= JTrama::token();
$document 	= JFactory::getDocument();
$document	-> addStyleSheet('../libraries/trama/css/validationEngine.jquery.css');
$document	-> addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document	-> addScript('../templates/rt_hexeris/js/jquery.number.min.js');
$document	-> addScript('../libraries/trama/js/jquery.validationEngine-es.js');
$document	-> addScript('../libraries/trama/js/jquery.validationEngine.js');

$datos 		= $this->items;
$input = JFactory::getApplication()->input;

$confirmacion 	= $input->get('confirmacion');
$monto			= $input->get('monto');
?>
<style>
	.resumen{
		display: none;
	}
	.captura{
		display: none;
	}
	.confirmacion{
		display: none;
	}
	.confimacionDivs{
		margin-top: 15px;
	}
	.textoConfirmacion{
		font-size: 13px;
		font-weight: bolder;
	}
	.textoResumen{
		font-size: 14px;
		padding: 15px;
		font-weight: bolder;
	}
</style>
<script language="JavaScript">
	jQuery(document).ready(function() {
		jQuery("#formstatus").validationEngine();
		jQuery('span.number').number(true,2);
		
<?php
	if($confirmacion){
?>
	jQuery('#montoResumen').text('<?php echo $monto; ?>');
	jQuery('span.number').number(true,2);
	jQuery('.resumen').show()
<?php
	}else{
?>
	jQuery('.captura').show();
<?php
	}
?>
		
		jQuery('#botonenviar').click(function (){
			if( jQuery("#formstatus").validationEngine('validate') ){
				jQuery('.captura').hide();
				jQuery('#monto').text(jQuery('#montoCaptura').val());
				jQuery('span.number').number(true,2);
				jQuery('.confirmacion').show();
			}
		});
		
		jQuery('#cancelar').click(function (){
				jQuery('.captura').show();
				jQuery('#monto').text('');
				jQuery('.confirmacion').hide();
		});
		
		jQuery('#enviarBoton').click(function(){
			var callback = '<?php echo JURI::BASE().'index.php?option=com_admincuentas&task=errors'; ?>&monto='+jQuery('#montoCaptura').val();
			
			jQuery('#callback').val(callback);
			
			jQuery('#formstatus').submit();
		});
	});
</script>

<form id="formstatus" action="<?php echo MIDDLE.PUERTO.TIMONE; ?>stp/transferFundsBridgeToTrama" method="POST" enctype="application/x-www-form-urlencoded">
	
        <table id="tablaGral" class="adminlist">
        	<thead><tr><th></th></tr></thead>
        	
			<tfoot><tr><td></td></tr></tfoot>
			
			<tbody>
				<tr>
					<td>
						<div class="captura" style="margin-top: 15px;">
								<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<input type="hidden" name="callback" id="callback" >
								
								<label for="mount">Monto a traspasar</label>
								<input type="text" name="amount" id="montoCaptura" class="validate[required,custom[number]]">
								
								<input type="button" value="Enviar" class="button" id="botonenviar" />
						</div>
						
						<div class="confirmacion">
							<div class="textoConfirmacion"><?php echo JText::_('TRASPASO_CONFIRMACION'); ?> $<span class="number" id="monto"></span></div>
							<div class="confimacionDivs">
								<input type="button" id="enviarBoton" class="button" value="<?php echo JText::_('TRASPASO_ENVIAR');  ?>" />
								<input type="button" value="Cancelar" class="button" id="cancelar" />
							</div>
						</div>
						
						<div class="resumen">
							<div class="textoResumen"><?php echo JText::_('TRASPASO_RESUMEN'); ?> $<span class="number" id="montoResumen"></span></div>
							<a href="index.php?option=com_admincuentas" class="button"><?php echo JText::_('TRASPASO_GOBACK'); ?> </a>
						</div>
						
					</td>
				</tr>
			</tbody>
			
        </table>
</form>
