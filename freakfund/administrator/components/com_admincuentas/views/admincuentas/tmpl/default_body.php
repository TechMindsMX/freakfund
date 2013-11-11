<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

foreach ($this->items as $key => $value) {
?>
	<tr>
		<td align="absmiddle">
			<?php echo $value->numCuenta; ?>
		</td>
		<td align="left">
			<?php echo $value->name; ?>
		</td>
		<td align="right">
			$<span class="number"><?php echo $value->balance; ?></span>
		</td>
		<td align="middle">
			<a class="button" href="index.php?option=com_admincuentas&task=traspasocuentas&id=<?php echo $value->idMiddleware; ?>"><?php echo JText::_('COM_ADMINCUENTAS_LISTADOCUENTAS_TRASPASO'); ?></a>
		</td>
	</tr>
<?php
}
?>