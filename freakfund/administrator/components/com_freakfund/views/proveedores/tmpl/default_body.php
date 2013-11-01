<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$providers 		= $this->items->providers;
$presupuesto 	= $this->items->budget;

foreach ($providers as $key => $value) {
	if($value->advancePaidDate) {
		$deshabilitarAnticipo = 'disabled';
	}else{
		$deshabilitarAnticipo = '';
	}
	
	if($value->settlementPaidDate) {
		$deshabilitaFiniquito = 'disabled';
	}else{
		$deshabilitaFiniquito = '';
	}
?>
	<tr>
		<td align="absmiddle">
			<?php echo $value->producerName; ?>
		</td>
		
		<td>
			$<span class="number"><?php echo $value->advanceQuantity+$value->settlementQuantity; ?></span>
		</td>
		
		<td align="absmiddle">
			<?php echo $value->advanceDate; ?>
		</td>
		
		<td align="absmiddle">
			$<span class="number"><?php echo $value->advanceQuantity; ?></span>
		</td>
		
		<td align="absmiddle">
			<input type="button" value="<?php echo JText::_('COM_FREAKFUND_PROVIDERS_BODY_PAGAR');?>" class="pagar" <?php echo $deshabilitarAnticipo; ?> />
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
			<input type="button" value="<?php echo JText::_('COM_FREAKFUND_PROVIDERS_BODY_PAGAR');?>" class="pagar" <?php echo $deshabilitaFiniquito ?>/>
			<input type="hidden" value="1" name="pagoAnticipo" />
			<input type="hidden" value="<?php echo $value->providerId; ?>" name="providerId" />
			<input type="hidden" value="<?php echo $value->projectId; ?>" name="projectId" />
		</td>
	</tr>
<?php
}
?>
<tr>
	<td align="right"><?php echo JText::_('COM_FREAKFUND_PROVIDERS_BODY_PRESUPUESTO');?> </td>
	<td>$<span class="number"><?php echo $presupuesto; ?></span></td>
	<td colspan="6"></td>
</tr>