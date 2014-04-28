<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$projectName = $this->items->name;
?>
<tr>
	<th>
		<h3><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME').strtoupper($projectName); ?></h3>
	</th>
</tr>