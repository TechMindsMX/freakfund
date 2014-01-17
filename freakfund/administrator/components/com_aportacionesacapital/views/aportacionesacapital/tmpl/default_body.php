<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

foreach ($this->items as $key => $value) {
var_dump($value->fundEndDate, $value->dateDiff->invert, $value->dateDiff->days);
	
?>

<tr>
	<td align="absmiddle">
		<?php if($value->dateDiff->invert == 1 && $value->dateDiff->days <= 300 ) {
			echo '<a href="index.php?option=com_aportacionesacapital&task=detalleproyecto&id='.$value->id.'">'.$value->name.'</a>';
		} else {
			echo $value->name;
		} ?>
	</td>
	<td align="absmiddle">
		<?php echo $value->producerName; ?>
	</td>
	<td align="absmiddle">
		<span><?php echo $value->fundEndDate; ?></span>
	</td>
</tr>

<?php
}
?>