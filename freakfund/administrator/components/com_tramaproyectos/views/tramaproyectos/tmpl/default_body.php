<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php 
jimport('trama.class');
$urls = new JTrama;

foreach($this->items as $i => $item):
	if ( $item->type != 'REPERTORY' ) {
		$user_revision = $item->logs;
				
		if (!empty($user_revision)) {
			$revisado_por = JFactory::getUser($user_revision[0]->userId)->name;
			$fecha = date('d/M/Y',$user_revision[0]->timestamp/1000);
			
		} else {
			$revisado_por = '';
			$fecha = '';
		}
		
		
		$item->producerName = JFactory::getUser($item->userId)->name;
		
		if($item->status != 0){
			$html = '<a href="index.php?option=com_tramaproyectos&view=detalleproyecto&id='.$item->id.'">'.$item->name.'</a>';
		} else {
			$html = $item->name;
		}
 ?>
        <tr class="row<?php echo $i % 2; ?>" id="status_<?php echo $item->status; ?>">
                <td>
                	<?php echo $item->id; ?>
                </td>
                <td>
            		<?php echo $html; ?>
                </td>
                <td>
                	<?php echo $item->producerName; ?>
                </td>
                <td>
                	<?php echo $urls::tipoProyProd($item); ?>
                </td>
                <td>
                	<?php echo $urls::getStatusName($item->status); ?>
                </td>
                <td>
                	<?php echo $revisado_por; ?>
                </td>
                <td>
                	<?php echo $fecha; ?>
                </td>
        </tr>
<?php 
	}
endforeach; 
?>