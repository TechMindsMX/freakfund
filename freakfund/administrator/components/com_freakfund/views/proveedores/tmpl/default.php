<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document->addScript('../libraries/trama/js/jquery.number.min.js');
?>
<script language="JavaScript">
	jQuery(document).ready(function (){
		 jQuery('span.number').number( true, 2, '.',',' );
	});
</script>
<form action="<?php echo JRoute::_('index.php?option=com_tramaproyectos'); ?>" method="post" name="adminForm">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>