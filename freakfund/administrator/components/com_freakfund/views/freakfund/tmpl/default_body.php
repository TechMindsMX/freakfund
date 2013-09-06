<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$urls = new JTrama;

foreach($this->items as $i => $item):
	if ( $item->type != 'REPERTORY' ) {
		$item->producerName = JFactory::getUser($item->userId)->name;
		
		if ( empty($item->providers) ) {
			$html = 'Sin Proveedores';
		} else {
			$html = '<a href="index.php?option=com_freakfund&task=proveedores&id='.$item->id.'">Mostrar Proveedores</a>';
		}
 ?>
        <tr class="row<?php echo $i % 2; ?>" id="status_<?php echo $item->status; ?>">
	        <td>
	    		<?php echo $item->name; ?>
	        </td>
	        <td>
	        	<?php echo $item->producerName; ?>
	        </td>
	        <td>
	        	<?php echo $html; ?>
	        </td>
        </tr>
<?php 
	}
endforeach; 
?>