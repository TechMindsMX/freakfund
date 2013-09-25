<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$document = JFactory::getDocument();
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$vName = $this->items[0]->vName;

JSubMenuHelper::addEntry(
	JText::_('COM_FREAKFUND_FREAKFUND_SUBMENU_PAYMENTS'),
	'index.php?option=com_freakfund',
	$vName == 'Payments');

JSubMenuHelper::addEntry(
	JText::_('COM_FREAKFUND_FREAKFUND_SUBMENU_STATUSCHANGES'),
	'index.php?option=com_freakfund&task=statusPro',
	$vName == 'listproduct');
?>
<form action="<?php echo JRoute::_('index.php?option=com_tramaproyectos'); ?>" method="post" name="adminForm">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>