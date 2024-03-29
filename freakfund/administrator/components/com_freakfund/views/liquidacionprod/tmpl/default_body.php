<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$datos = $this->items;
?>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_HEADING_NAME').': '.$datos->productorName; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<label for="montoPago"><?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_MONTOPAGO'); ?></label>
			<input type="hidden" name="token" id="token" value="<?php echo $datos->token; ?>" />
			<input type="hidden" name="projectId" id="projectId" value="<?php echo $datos->id; ?>" />
			<input type="hidden" name="producerId" id="producerId" value="<?php echo $datos->userId; ?>" />
			<input type="hidden" name="callback" id="callback" value="<?php echo $datos->callback; ?>" />
			<input type="hidden" name="errorCallback" id="errorCallback" value="<?php echo $datos->errorCallback; ?>" />
			<input type="text" name="payment" id="payment" class="validate[required, custom[number]]"  />
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_PROY_BALANCE').': $'.number_format($datos->balance,2); ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_PROY_BUDGET').': $'.number_format($datos->budget,2); ?>
		</td>
	</tr>
	
	<tr>
		<td align="absmiddle">
			<input type="submit" id="buttonSubmit" value="<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_SEND'); ?>" />
		</td>
	</tr>