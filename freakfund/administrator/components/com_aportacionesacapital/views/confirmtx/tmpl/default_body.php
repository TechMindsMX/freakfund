<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');
$datos = $this->items;

?>

<tr>
	<td align="justify">
		<div id="hiddens">
			<input type="hidden" name="token" value="<?php echo $datos->token; ?>" />
			<input type="hidden" name="projectId" value="<?php echo $datos->projectId; ?>" />
			<input type="hidden" name="providerId" value="<?php echo $datos->providerId; ?>" />
			<input type="hidden" name="type" value="<?php echo $datos->type; ?>" />
			<input type="hidden" name="callback" value="<?php echo $datos->callback; ?>" />
			
		</div>
		<?php echo JText::_('COM_APORTACIONESCAPITAL_IRREVERSIBLE'); ?>
		<br /><br /><br />
		
		<?php echo JText::_('COM_APORTACIONESCAPITAL_LISTADOPROYECTOS_HEADING_PRODUCTOR'); ?> : <?php echo $datos->producerName; ?>
		<br /><br />
		
		<?php echo JText::_('COM_APORTACIONESCAPITAL_LISTADOPROYECTOS_HEADING_NOMBREPROY'); ?> : <?php echo $datos->ProductName; ?>
		<br /><br /> 
		
		<?php echo JText::_('COM_APORTACIONESCAPITAL_APORTACION');?> : $<span class="number"><?php echo $datos->monto; ?></span>
		<br /><br /><br />
		
		<input type="submit" value="<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SEND'); ?>" />
	</td>
</tr>

