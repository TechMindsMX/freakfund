<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$urls = new JTrama;
$providers = $this -> items -> providers;
$presupuesto = $this->items -> budget;

foreach ($providers as $key => $value) {
?>
	<tr>
		<td>
			<?php echo $value->advanceDate; ?>
		</td>
		
		<td>
			$<span class="number"><?php echo $value->advanceQuantity; ?></span>
		</td>
		
		<td align="absmiddle">
			<input type="button" value="<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_BODY_PAGAR');?>" onClick="alert('pagado');" />
		</td>
		
		<td>
			<?php echo $value->settlementDate; ?>
		</td>
		
		<td>
			$<span class="number"><?php echo $value->settlementQuantity; ?></span>
		</td>
		
		<td>
			<input type="button" value="<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_BODY_PAGAR');?>" onClick="alert('pagado');" />
		</td>
		
		<td>
			<?php echo JFactory::getUser($value->providerId)->name; ?>
		</td>
		
		<td>
			$<span class="number"><?php echo $value->advanceQuantity+$value->settlementQuantity; ?></span>
		</td>
		
		<td align="center">
			<input type="checkbox" value="1">
		</td>
	</tr>
<?php
}
?>
<tr>
	<td colspan="7" align="right">Persupuesto </td>
	<td>$<span class="number"><?php echo $presupuesto; ?></span></td>
	<td></td>
</tr>