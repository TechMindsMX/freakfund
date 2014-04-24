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
		
		jQuery('.button').click(function(){
			var monto 		 = jQuery(this).parent().prev().children().val();
			var providerId	 = jQuery(this).next().val();
			var providerName = jQuery(this).parent().prev().prev().text();
			
			jQuery('.monto').html('$<span class="number">'+monto+'</span>');
			jQuery('.providerName').html(' '+providerName);
			jQuery('#provId').val(providerId);
			jQuery('#amount').val(monto);
			
			jQuery('span.number').number(true,2);
			jQuery('#detalle').hide();
			jQuery('#resumen').show();
			
		});
		
		jQuery('#send').click(function(){
			jQuery('#formstatus').submit();
		});
	});
</script>

<form id="formstatus" action="/post.php" method="POST" enctype="application/x-www-form-urlencoded">
	
        <table id="tablaGral" class="adminlist">
            <thead><?php echo $this->loadTemplate('head');?></thead>
            <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
            <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>
