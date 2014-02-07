<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$providers 		= $this->items->providers;
$presupuesto 	= $this->items->budget;

echo '<h2>'.$this->items->name.'</h2>';

foreach ($providers as $key => $value) {
	if($value->advancePaidDate) {
		$deshabilitarAnticipo = 'disabled';
	}else{
		$deshabilitarAnticipo = '';
	}

	if($value->settlementPaidDate || !$value->advancePaidDate) {
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
			<input type="button" value="<?php echo JText::_('COM_FREAKFUND_PROVIDERS_BODY_PAGAR');?>" 
				class="pagar" <?php echo $deshabilitarAnticipo; ?> id="<?php echo 'ant-'.$key ;?>" />
			<input type="hidden" value="0" />
			<input type="hidden" value="<?php echo $value->providerId; ?>" />
			<input type="hidden" value="<?php echo $value->producerName; ?>" />
			<input type="hidden" value="<?php echo $value->projectId; ?>" />
			<input type="hidden" value="<?php echo $value->advanceQuantity; ?>" />
		</td>
		
		<td align="absmiddle">
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