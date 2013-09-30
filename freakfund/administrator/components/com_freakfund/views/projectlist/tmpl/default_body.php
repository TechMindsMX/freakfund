<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$document = JFactory::getDocument();
$document->addScript('../libraries/trama/js/jquery.number.min.js'); 

foreach($this->items as $i => $item):
	if ( $item->type != 'REPERTORY' ) {
		$htmlChange = '<a href="index.php?option=com_freakfund&task=statusPro&proyid='.$item->id.'" />Modificar</a>'
?>
        <tr class="row<?php echo $i % 2; ?>" id="status_<?php echo $item->status; ?>">
	        <td>
	    		<?php echo $item->name; ?>
	        </td>
	        <td>
	        	<?php echo $item->fundEndDate; ?>
	        </td>
	        <td>
	        	$<span class="number"><?php echo $item->breakeven; ?></span>
	        </td>
	        <td>
	        	<?php echo $item->percentage; ?>
	        </td>
	        <td>
	        	<?php echo JTrama::getStatusName($item->status); ?>
	        </td>
	        <td style="background-color: <?php echo $item->semaphore; ?>;">
	        	&nbsp;
	        </td>
	        <td>
	        	<?php echo $htmlChange; ?>
	        </td>
        </tr>
<?php 
	}
endforeach; 
?>