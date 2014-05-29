<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

foreach ($this->items as $key => $value) {
?>
	<tr>
		<td align="absmiddle">
			<?php echo $value->ligaEdoResult; ?>
		</td>
		<td align="absmiddle">
			<?php echo $value->prodName; ?>
		</td>
		<td align="right">
			$<span class="number"><?php echo $value->balance; ?></span>
		</td>
	</tr>
<?php
}
?>