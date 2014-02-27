<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

foreach ($this->items as $key => $value) {
?>
	<tr>
		<td align="absmiddle">
			<?php echo $value->account; ?>
		</td>
		<td align="left">
			<?php echo JText::_('COM_ADMINCUENTAS_LISTADOCUENTAS_'.$value->type); ?>
		</td>
		<td align="right">
			$<span class="number"><?php echo $value->balance; ?></span>
		</td>
		<td align="middle">
			<?php echo $value->url; ?>
		</td>
	</tr>
<?php
}
?>