<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$usuario 		= JFactory::getUser();
$token			= JTrama::token();
$callback		= JURI::base().'index.php?option=com_freakfund&task=projectlist';
$errorCallback	= JURI::base().'index.php?option=com_freakfund&task=errors&error=projectlist';
$datos 			= $this->items;
$datos->idMod	= userData::getUserMiddlewareId($usuario->id)->idMiddleware;

var_dump($datos->idMod);
?>
	<tr>
		<td align="absmiddle">
			<h3><?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_NAMEPROD').': '.$datos->name; ?></h3>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo $datos->FechaApintar; ?>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_STATUSPRO_FINANTIALCASH').': $<span class="number">'.$datos->balance; ?></span>
		</td>
	</tr>
	<tr>
		<td align="absmiddle">
			<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_PERCENTAGE').': <span class="number">'.$datos->percentage; ?></span>%
		</td>
	</tr>
	
	<tr>
		<td align="absmiddle">
			<input type="hidden" value="<?php echo $datos->id; ?>"		name="projectId" />
			<input type="hidden" value="<?php echo $datos->idMod; ?>"	name="userId" />
			<input type="hidden" value="<?php echo $token; ?>"			name="token" />
			<input type="hidden" value="<?php echo $callback; ?>"		name="callback" />
			
			<div id="status5">
				<?php echo $datos->inputs; ?>
				
				<div style="margin-bottom: 10px;">
					<input type="button" id="status10" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_BUTTONDOCPENDIENTE'); ?>" />
					<input type="button" id="status6" value="<?php echo JText::_('COM_FREAKFUND_STATUSPRO_BUTTONPRODUCTION'); ?>" disabled/>
				</div>
			</div>
		</td>
	</tr>
