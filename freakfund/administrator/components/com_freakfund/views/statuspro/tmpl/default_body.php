<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$usuario 	= JFactory::getUser();
$token		= JTrama::token();
$callback	= JURI::base().'index.php?option=com_freakfund&task=projectlist';
$datos 		= $this->items;
$selectBaja = $datos->motivosBaja;

$select = '<select name="reason" id="selectBajas">';
foreach ($selectBaja as $key => $value) {
	$select .=  '<option value="'.$value->id.'">'.JText::_('COM_FREAKFUND_STATUSPRO_BAJA_'.$value->id).'</option>';
}
$select .= '</select><br /><br />';
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
			<input type="hidden" value="<?php echo $datos->id; ?>"  name="projectId" />
			<input type="hidden" value="<?php echo $usuario->id; ?>"  name="userId" />
			<input type="hidden" value="<?php echo $token; ?>"  name="token" />
			<input type="hidden" value="<?php echo $callback; ?>"  name="callback" />
			
			<?php 
			if($datos->statusVenta == 1) {
			?>
				<input type="hidden" value="6"  name="status" id="statusbaja" />
				Documentacion completa: <input type="checkbox" value="1" id="docComplete" class="docComplete" />
				<br /><br />
				
				<input type="button" id="publishButton" disabled="true" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_PUBLISHBUTTON'); ?>" />
				<br /><br />
			<?php
			} else {
			?>
				<input type="hidden" value="8"  name="status" id="statusbaja" />
				<input type="button" id="finishButton" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_FINISH'); ?>" />
			<?php
			}
			?>
				<?php echo $select; ?>
				<input type="button" id="baja" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_DARDEBAJA'); ?>" />
		</td>
	</tr>
