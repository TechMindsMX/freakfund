<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

foreach ($this->items as $key => $value) {
?>
	<tr>
		<td align="absmiddle">
			<a href="<?php echo $value->ligaEdoResult; ?>"><?php echo $value->name; ?></a>
		</td>
		<td align="left">
			<?php echo $value->prodName; ?>
		</td>
		<td align="right">
			$<span class="number"><?php echo $value->balance; ?></span>
		</td>
	</tr>
<?php
}
?>