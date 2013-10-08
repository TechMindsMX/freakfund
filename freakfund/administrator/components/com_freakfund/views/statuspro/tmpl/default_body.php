<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$usuario 	= JFactory::getUser();
$token		= JTrama::token();
$callback	= JURI::base().'index.php?option=com_freakfund&task=projectlist';
$datos 		= $this->items;
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
			<input type="hidden" value="<?php echo $datos->id; ?>"   name="projectId" />
			<input type="hidden" value="<?php echo $usuario->id; ?>" name="userId" />
			<input type="hidden" value="<?php echo $token; ?>"  	 name="token" />
			<input type="hidden" value="<?php echo $callback; ?>"  	 name="callback" />
			
			<div id="status5">
				<?php echo $datos->inputs; ?>
				
				<div style="margin-bottom: 10px;">
					<input type="button" id="status10" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_BUTTONDOCPENDIENTE'); ?> 10" />
					<input type="button" id="status6" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_BUTTONPRODUCTION'); ?> 6" disabled/>
					
				</div>
			</div>
		</td>
	</tr>
