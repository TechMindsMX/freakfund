<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$datos = $this->items;
?>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_NAMEPROD').': '.$datos->name; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_CLOSEDATE').': '.$datos->fundEndDate; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_STATUSPRO_FINANTIALCASH').': $'.$datos->finantialCash; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_PERCENTAGE').': '.$datos->percentage; ?>
		</td>
	</tr>
	
	<tr>
		<td align="absmiddle">
			<?php 
			if($datos->statusVenta == 1) {
			?>
				Documentacion completa: <input type="checkbox" value="1" name="docComplete" id="docComplete" class="docComplete" />
				<br /><br />
				<input type="button" id="publishButton" disabled="true" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_PUBLISHBUTTON'); ?>" />
				<br /><br />
				<input type="button" id="incompletedoc" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_INCOMPLETEDOCUMENTATION'); ?>" />
			<?php
			} else {
			?>
				<input type="button" id="productnosend" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_PRODUCTNOSEND'); ?>" />
				<br /><br />
				<input type="button" id="finishButton" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_FINISH'); ?>Finalizado" />
			<?php
			}
			?>
		</td>
	</tr>