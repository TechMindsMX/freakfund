<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$value = $this->items;

?>
<tr>
	<th>
		<h1><?php echo $value['proyectName']; ?></h1>
		<h3><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_CUENTA').$value['account']; ?></h3>
	</th>
</tr>
