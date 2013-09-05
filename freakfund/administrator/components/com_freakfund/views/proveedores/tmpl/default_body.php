<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$urls = new JTrama;

foreach($this->items as $i => $item):
	if ( $item->type != 'REPERTORY' ) {
		$user_revision = $item->logs;
				
		if (!empty($user_revision)) {
			$fecha = date('d/M/Y',$user_revision[0]->timestamp/1000);
		} else {
			$fecha = '';
		}
		
		$item->producerName = JFactory::getUser($item->userId)->name;
		
		$html = '<a href="index.php?option=com_tramaproyectos&view=detalleproyecto&id='.$item->id.'">'.$item->name.'</a>';
 ?>
        <tr class="row<?php echo $i % 2; ?>" id="status_<?php echo $item->status; ?>">
	        <td>
	    		<?php echo $html; ?>
	        </td>
	        <td>
	        	<?php echo $item->producerName; ?>
	        </td>
        </tr>
<?php 
	}
endforeach; 
?>