<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$urls = new JTrama;

foreach($this->items as $i => $item):
	if ( $item->type != 'REPERTORY' ) {
		$item->producerName = JFactory::getUser($item->userId)->name;
		
		if ( empty($item->providers) ) {
			$html = JText::_('COM_FREAKFUND_FREAKFUND_BODY_NOPROVIDERS');
		} else {
			$html = '<a href="index.php?option=com_freakfund&task=proveedores&id='.$item->id.'">'.JText::_('COM_FREAKFUND_FREAKFUND_BODY_SHOWPROVIDERS').'</a>';
		}
 ?>
        <tr class="row<?php echo $i % 2; ?>" id="status_<?php echo $item->status; ?>">
	        <td>
	    		<?php echo $item->name; ?>
	        </td>
	        <td>
	        	<a href="index.php?option=com_freakfund&task=liquidacionprod&userId=<?php echo $item->userId; ?>" ><?php echo $item->producerName; ?></a>
	        </td>
	        <td>
	        	<?php echo $html; ?>
	        </td>
        </tr>
<?php 
	}
endforeach; 
?>