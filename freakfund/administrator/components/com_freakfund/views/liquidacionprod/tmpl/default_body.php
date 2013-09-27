<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$datos = $this->items;
?>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_HEADING_NAME').': '.JFactory::getUser($datos->userId)->name; ?>
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
			<input type="text" name="payment" id="payment" class="validate[required]"  />
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_SALDOPROD').': $<span class="number">'.($datos->CPR-$datos->cre).'</span>'; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_SALDOPROY').': $<span class="number">'.$datos->budget.'</span>'; ?>
		</td>
	</tr>
	
	<tr>
		<td align="absmiddle">
			<input type="submit" value="<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_SEND'); ?>" />
		</td>
	</tr>