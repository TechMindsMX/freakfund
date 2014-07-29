<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$document = JFactory::getDocument();
$document	-> addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document	-> addScript('../templates/rt_hexeris/js/jquery.number.min.js');

$vName = ( isset($this->items[0]->vName))?$this->items[0]->vName :'aportecapital';

JSubMenuHelper::addEntry(
	JText::_('COM_FREAKFUND_FREAKFUND_PAGODEAPORTACIONES'),
	'index.php?option=com_aportacionesacapital',
	$vName == 'pagodeaportaciones');

JSubMenuHelper::addEntry(
	JText::_('COM_FREAKFUND_FREAKFUND_SUBMENU_APORTEDEPROVEEDORES'),
	'index.php?option=com_aportacionesacapital&task=listadoaporte',
	$vName == 'aportecapital');
?>
<script language="JavaScript">
	jQuery(document).ready(function() {

	jQuery('span.number').number(true,2);

		jQuery('#statusFilter').change(function(){
			var valor = this.value;
			if(valor == 'all') {
				jQuery('#tablaGral tr').show();
			}else{
				jQuery.each(jQuery('#tablaGral tr'),function(){
					if(this.id == valor  || this.id == ''){
						jQuery(this).show()
					}else{
						jQuery(this).hide()
					}
				});
			}
		});
	});
</script>
<form action="<?php echo JRoute::_('index.php?option=com_tramaproyectos'); ?>" method="post" name="adminForm" id="idform">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>