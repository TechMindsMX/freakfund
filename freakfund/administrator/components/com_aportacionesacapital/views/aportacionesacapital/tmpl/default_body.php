<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

foreach ($this->items as $key => $value) {
?>
	<tr>
		<td align="absmiddle">
			<a href="index.php?option=com_aportacionesacapital&task=detalleproyecto&id=<?php echo $value->id; ?>"><?php echo $value->name; ?></a>
		</td>
		<td align="absmiddle">
			<?php echo $value->producerName; ?>
		</td>
		<td align="absmiddle">
			$<span class="number"><?php echo $value->breakeven; ?></span>
		</td>
	</tr>
<?php
}
?>