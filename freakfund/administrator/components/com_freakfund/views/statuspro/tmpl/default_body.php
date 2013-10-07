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
				<div id="tituloDiv" style="font-weight: bolder; font-size: 18px; margin-bottom: 20px">Cambio de estatus por documentación</div>
				
				<?php echo $datos->inputs; ?>
				
				<div style="margin-bottom: 10px;">
					<input type="button" id="publishButton" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_PUBLISHBUTTON'); ?>" />
				</div>
			</div>
		</td>
	</tr>
