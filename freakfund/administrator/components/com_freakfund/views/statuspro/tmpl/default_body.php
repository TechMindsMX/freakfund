<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$usuario 		= JFactory::getUser();
$token			= JTrama::token();
$callback		= JURI::base().'index.php?option=com_freakfund&task=projectlist';
$errorCallback	= JURI::base().'index.php?option=com_freakfund&task=errors&error=projectlist';
$datos 			= $this->items;
?>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_NAMEPROD').': '.$datos->name; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo $datos->FechaApintar; ?>
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
			<input type="hidden" value="<?php echo $datos->id; ?>"     name="projectId" />
			<input type="hidden" value="<?php echo $usuario->id; ?>"   name="userId" />
			<input type="hidden" value="<?php echo $token; ?>"  	   name="token" />
			<input type="hidden" value="<?php echo $callback; ?>"  	   name="callback" />
			<input type="hidden" value="<?php echo $errorCallback; ?>" name="errorCallback" />
			
			<div id="status5">
				<?php echo $datos->inputs; ?>
				
				<div style="margin-bottom: 10px;">
					<input type="button" id="status10" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_BUTTONDOCPENDIENTE'); ?> 10" name="10"/>
					<input type="button" id="status6" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_BUTTONPRODUCTION'); ?> 6" name="6" disabled/>
				</div>
			</div>
		</td>
	</tr>
