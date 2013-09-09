<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$providers = $this -> items -> providers;
$presupuesto = $this->items -> budget;

foreach ($providers as $key => $value) {
	JTrama::formatDatosProy($value);
?>
	<tr>
		<td align="absmiddle">
			<?php echo $value->advanceDate; ?>
		</td>
		
		<td align="absmiddle">
			$<span class="number"><?php echo $value->advanceQuantity; ?></span>
		</td>
		
		<td align="absmiddle">
			<input type="button" value="<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_BODY_PAGAR');?>" class="pagar" />
			<input type="hidden" value="0" name="pagoAnticipo" />
			<input type="hidden" value="<?php echo $value->providerId; ?>" name="providerId" />
			<input type="hidden" value="<?php echo $value->projectId; ?>" name="projectId" />
		</td>
		
		<td align="absmiddle">
			<?php echo $value->settlementDate; ?>
		</td>
		
		<td align="absmiddle">
			$<span class="number"><?php echo $value->settlementQuantity; ?></span>
		</td>
		
		<td align="absmiddle">
			<input type="button" value="<?php echo JText::_('COM_TRAMAPROYECTOS_TRAMAPROYECTOS_BODY_PAGAR');?>" class="pagar" />
			<input type="hidden" value="1" name="pagoAnticipo" />
			<input type="hidden" value="<?php echo $value->providerId; ?>" name="providerId" />
			<input type="hidden" value="<?php echo $value->projectId; ?>" name="projectId" />
		</td>
		
		<td align="absmiddle">
			<?php echo JFactory::getUser($value->providerId)->name; ?>
		</td>
		
		<td>
			$<span class="number"><?php echo $value->advanceQuantity+$value->settlementQuantity; ?></span>
		</td>
		
		<td align="absmiddle">
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