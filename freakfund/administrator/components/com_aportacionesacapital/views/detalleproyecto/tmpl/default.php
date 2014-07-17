<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$token 		= JTrama::token();
$document 	= JFactory::getDocument();
$document	-> addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document	-> addScript('../templates/rt_hexeris/js/jquery.number.min.js');
?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		jQuery('span.number').number(true,2);

		jQuery('#detalle input:button.button').click(function(){
			console.log(this);
			var trUsed			= jQuery(this).parents('tr')[0];
			var monto 			= jQuery(trUsed).find('input:text').val();
			var providerId		= jQuery(trUsed).find('input:hidden').val();
			var providerName 	= jQuery(trUsed).find('span.producerName').text();
			
			jQuery('.monto').html('$<span class="number">'+monto+'</span>');
			jQuery('.providerName').html(' '+providerName);
			jQuery('#provId').val(providerId);
			jQuery('#mount').val(monto);
			
			jQuery('span.number').number(true,2);
			jQuery('#detalle').hide();
			jQuery('#resumen').show();
			
		});
		
		jQuery('#send').click(function(){
			jQuery('#formstatus').submit();
		});
		
		jQuery('#cancel').click(function(){
			jQuery('#resumen').hide();
			jQuery('#detalle').show();
		})
	});
</script>

<form id="formstatus" action="<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/tx/returnOfCapitalInjection" method="POST" enctype="application/x-www-form-urlencoded">
	
        <table id="tablaGral" class="adminlist">
            <thead><?php echo $this->loadTemplate('head');?></thead>
            <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
            <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>
