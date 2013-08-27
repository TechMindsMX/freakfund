<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<!-- <form action="<?php echo JRoute::_('index.php?option=com_tramaproyectos'); ?>" method="post" name="adminForm"> -->
	<form action="<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/project/changeStatus" method="post" >
        <table class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
        </table>
</form>