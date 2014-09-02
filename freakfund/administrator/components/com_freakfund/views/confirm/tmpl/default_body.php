<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$document = JFactory::getDocument();
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');

jimport('trama.class');
$token = JTrama::token();

$datos = $this->items;

$url = MIDDLE.PUERTO.TIMONE.'project/saveProviderPayment';

if (!isset($datos['envio'])) {
	$app = JFactory::getApplication();
	$app->redirect(JRoute::_('index.php?option=com_freakfund'), JText::_('COM_FREAKFUND_ERRORS_MSG'), 'error');
}
$envio = json_decode($datos['envio']);

switch ($envio->type) {
	case 0:
		$envio->typeName = JText::_('COM_FREAKFUND_PROVIDERS_HEADING_DATEANTICIPO');
		break;
	
	case 1:
		$envio->typeName = JText::_('COM_FREAKFUND_PROVIDERS_HEADING_DATEFINIQUITO');
		break;
}
?>
<script>
jQuery(document).ready(function() {
	 jQuery('.pagar2').click(function () {
	 	var elem = this;
	 	var request = $.ajax({
			url	:"<?php echo $url; ?>",
			data: {
				"providerId"	: "<?php echo $envio->providerId; ?>",
				"type"			: "<?php echo $envio->type; ?>",
				"projectId" 	: "<?php echo $envio->projectId; ?>",
				"token"			: "<?php echo $token; ?>___MALO"
			},
			type: 'post'
		});
		
		request.done(function(result){
			var obj = eval('(' + result + ')');
			
			if (!obj.error){
				var mensaje = '<dl id="system-message"><dt class="message"></dt>';
				mensaje += '<dd class="message"><ul><li><?php echo JText::_('CONFIRMAR_PAGO_PROVEEDOR_EXITO'); ?></ul></dd></dl>';
				
				jQuery(elem).attr('disabled', 'disabled');
				jQuery('#toolbar-box').append(mensaje).delay(5000).fadeOut(1000, function(){
					window.location.replace("<?php echo 'index.php?option=com_freakfund&task=proveedores&id='.$envio->projectId; ?>");
				});
			} else {
				var mensaje = '<dl id="system-message"><dt class="error"></dt>';
				mensaje += '<dd class="error"><ul><li><?php echo JText::_('COM_FREAKFUND_ERROR_OPERACION'); ?></ul></dd></dl>';

				jQuery(elem).attr('disabled', 'disabled');
				jQuery('#toolbar-box').append(mensaje).delay(5000).fadeOut(1000, function(){
					window.location.replace("<?php echo 'index.php?option=com_freakfund&task=proveedores&id='.$envio->projectId; ?>");
				});
			}
		});
	 });
 });
</script>		 
	<tr>
		<td align="absmiddle">
			<h1><?php echo JText::_('CONFIRMAR_PAGO_PROVEEDOR'); ?></h1>
			<h3><?php echo $envio->proName; ?></h3>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('CONFIRMAR_PAGO_PROVEEDOR_TXT'); ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<label><?php echo JText::_('COM_FREAKFUND_PROVIDERS_HEADING_NAMEPROVIDER');?></label> : <?php echo $envio->providerName; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<label><?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_MONTOPAGO');?></label> : $ <?php echo number_format($envio->monto,2); ?>
		</td>
	</tr>
	
	<tr>
		<td align="absmiddle">
			<?php echo $envio->typeName; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<input type="button" class="pagar2" value="<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_SEND'); ?>" />
			<a class="button" href="<?php echo JRoute::_('index.php?option=com_freakfund'); ?>" ><?php echo JText::_('JCANCEL'); ?></a>
		</td>
	</tr>