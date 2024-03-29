<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$providers 		= $this->items->providers;
$presupuesto 	= $this->items->budget;

$statusListPago	= array(6,7,11);
$statusNoPagos	= !in_array($this->items->status->id, $statusListPago);

echo '<h2>'.$this->items->name.'</h2>';

if ($statusNoPagos) {
	echo '<p style="color: red;">'.$this->items->status->name.'</p>';
} else {
	echo '<p style="color: green;">'.$this->items->status->name.'</p>';
}

foreach ($providers as $key => $value) {
	if($value->advancePaidDate || $statusNoPagos) {
		$deshabilitarAnticipo = 'disabled';
	}else{
		$deshabilitarAnticipo = '';
	}

	if($value->settlementPaidDate || !$value->advancePaidDate || $statusNoPagos) {
		$deshabilitaFiniquito = 'disabled';
	}else{
		$deshabilitaFiniquito = '';
	}
	
	$advBgColor = $value->advanceDif->invert == 0 ? 'red' : '';
	if ($value->advanceDif->invert == 1 && $value->advanceDif->days <= 15) {
		$advBgColor ='green';
	}
	$setBgColor = $value->settlemDif->invert == 0 ? 'red' : '';
	if ($value->settlemDif->invert == 1 && $value->settlemDif->days <= 15){
		$setBgColor = 'green';
	}

?>
	<tr>
		<td align="absmiddle">
			<?php echo $value->producerName; ?>
		</td>
		
		<td>
			$<span class="number"><?php echo $value->advanceQuantity+$value->settlementQuantity; ?></span>
		</td>
		
		<td align="absmiddle" style="color: <?php echo $advBgColor; ?>;">
			<?php echo $value->advanceDate; ?>
		</td>
		
		<td align="absmiddle">
			$<span class="number"><?php echo $value->advanceQuantity; ?></span>
		</td>
		
		<td align="absmiddle">
			<input type="button" value="<?php echo JText::_('COM_FREAKFUND_PROVIDERS_BODY_PAGAR');?>" 
				class="pagar" <?php echo $deshabilitarAnticipo; ?> id="<?php echo 'ant-'.$key ;?>" />
			<input type="hidden" value="0" />
			<input type="hidden" value="<?php echo $value->providerId; ?>" />
			<input type="hidden" value="<?php echo $value->producerName; ?>" />
			<input type="hidden" value="<?php echo $value->projectId; ?>" />
			<input type="hidden" value="<?php echo $value->advanceQuantity; ?>" />
		</td>
		
		<td align="absmiddle" style="color: <?php echo $setBgColor; ?>;">
			<?php echo $value->settlementDate; ?>
		</td>
		
		<td align="absmiddle">
			$<span class="number"><?php echo $value->settlementQuantity; ?></span>
		</td>
		
		<td align="absmiddle">
			<input type="button" value="<?php echo JText::_('COM_FREAKFUND_PROVIDERS_BODY_PAGAR');?>" 
				class="pagar" <?php echo $deshabilitaFiniquito; ?> id="<?php echo 'liq-'.$key ;?>" />
			<input type="hidden" value="1" />
			<input type="hidden" value="<?php echo $value->providerId; ?>" />
			<input type="hidden" value="<?php echo $value->producerName; ?>" />
			<input type="hidden" value="<?php echo $value->projectId; ?>" />
			<input type="hidden" value="<?php echo $value->settlementQuantity; ?>" />
		</td>
	</tr>
<?php
}
?>
<tr>
	<td align="right"><?php echo JText::_('COM_FREAKFUND_PROVIDERS_BODY_PRESUPUESTO');?> </td>
	<td>$<span class="number"><?php echo $presupuesto; ?></span></td>
	<td colspan="6"></td>
	
	<input type="hidden" name="envio" id="envio" value="" />
</tr>