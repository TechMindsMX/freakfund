<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
require_once '../components/com_jumi/files/classIncludes/libreriasPP.php';

?>
<form action="<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/project/saveProducerPayment" method="post" name="adminForm">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>
<!-- <div style="font-family: Arial; font-size: 12px;"><?php var_dump($this->items); ?></div> -->