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
			<input type="text" name="montoPago" id="montoPago" />
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_SALDOPROD').': $<span class="number">'.($datos->CRE-$datos->CPR).'</span>'; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_SALDOPROY').': $<span class="number">'.$datos->budget.'</span>'; ?>
		</td>
	</tr>
	
	<tr>
		<td align="absmiddle">
			<input type="button" value="<?php echo JText::_('COM_FREAKFUND_LIQUIDACIONPROD_BODY_SEND'); ?>" />
		</td>
	</tr>