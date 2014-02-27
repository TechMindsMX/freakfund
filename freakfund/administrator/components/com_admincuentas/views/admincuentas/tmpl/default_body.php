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
			<input type="hidden" name="numCuenta" value="<?php echo $value->account; ?>" />
			<input type="hidden" name="balance" value="<?php echo $value->balance; ?>" />
			<input type="submit" class="button" value="<?php echo JText::_('COM_ADMINCUENTAS_LISTADOCUENTAS_TRASPASO'); ?>" />
		</td>
	</tr>
<?php
}
?>