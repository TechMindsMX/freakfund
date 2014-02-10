<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');

$url = JRoute::_('index.php?option=com_freakfund&task=proveedores&view=confirm&id=1');

// load tooltip behavior
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document->addScript('../templates/rt_hexeris/js/jquery.number.min.js');

?>
<script language="JavaScript">
	
	jQuery(document).ready(function (){
		 jQuery('span.number').number( true, 2, '.',',' );
		 
		 jQuery('.pagar').click(function(){
				var data = {
					"type"			: jQuery(this).next().val(),
					"providerId"	: jQuery(this).next().next().val(),
					"providerName"	: jQuery(this).next().next().next().val(),
					"projectId" 	: jQuery(this).next().next().next().next().val(),
					"monto" 		: jQuery(this).next().next().next().next().next().val(),
					"proName"		: "<?php echo $this->items->name; ?>"
				};
				jQuery('#envio').val(JSON.stringify(data));

		 	jQuery('form').submit();
		 });
	});
</script>
<form action="<?php echo JRoute::_('index.php?option=com_freakfund&task=proveedores&view=confirm&id=1'); ?>" method="post" name="adminForm">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>