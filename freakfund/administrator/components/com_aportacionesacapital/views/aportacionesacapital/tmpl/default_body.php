<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

foreach ($this->items as $key => $value) {

?>

<tr>
	<td align="absmiddle">
		<?php if($value->dateDiff->invert == 0 && $value->dateDiff->days <= 300 ) {
			echo '<a href="index.php?option=com_aportacionesacapital&task=detalleproyecto&id='.$value->id.'">'.$value->name.'</a>';
		} else {
			echo $value->name;
		} ?>
	</td>
	<td align="absmiddle">
		<?php echo $value->producerName; ?>
	</td>
	<td align="absmiddle">
		$<span class="number"><?php echo $value->breakeven; ?></span>
	</td>
	<td align="absmiddle">
		$<span class="number"><?php echo $value->toBreakeven; ?></span>
	</td>
	<td align="absmiddle">
		<span><?php echo $value->toBreakevenPercentage; ?> %</span>
	</td>
	<td align="absmiddle">
		<span><?php echo $value->fundEndDate; ?></span>
	</td>
</tr>

<?php
}
?>