<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
jimport('trama.usuario_class');

$urls = new JTrama;
if( !empty($this->items) ) {
	foreach($this->items as $i => $item):
		if ( $item->type != 'REPERTORY' ) {
			$item->producerName = JFactory::getUser(UserData::getUserJoomlaId($item->userId))->name;
			if ( empty($item->providers) ) {
				$htmlProveedores = JText::_('COM_FREAKFUND_FREAKFUND_BODY_NOPROVIDERS');
			} else {
				$htmlProveedores = '<a href="index.php?option=com_freakfund&task=proveedores&id='.$item->id.'">'.JText::_('COM_FREAKFUND_FREAKFUND_BODY_SHOWPROVIDERS').'</a>';
			}
			
			$htmlProductor = '<a href="index.php?option=com_freakfund&task=liquidacionprod&id='.$item->id.'" >'.$item->producerName.'</a>';
	?>
	        <tr class="row<?php echo $i % 2; ?>" id="status_<?php echo $item->status; ?>">
		        <td>
		    		<?php echo $item->name; ?>
		        </td>
		        <td>
		        	<?php echo $htmlProductor; ?>
		        </td>
		        <td>
		        	<?php echo $htmlProveedores; ?>
		        </td>
	        </tr>
	<?php 
		}
	endforeach;
} else {
?>
		<tr>
			<td colspan="3" align="center"><?php echo JText::_('COM_FREAKFUND_FREAKFUND_BODY_NOPROJECTS') ?></td>
		</tr>
<?php 
} 
?>