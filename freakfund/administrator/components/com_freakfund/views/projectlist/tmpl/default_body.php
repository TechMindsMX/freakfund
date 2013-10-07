<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$document = JFactory::getDocument();
$document->addScript('../libraries/trama/js/jquery.number.min.js'); 

foreach($this->items as $i => $item):
	if ( $item->type != 'REPERTORY' ) {
		$htmlChange = $item->status != 4? '<a href="index.php?option=com_freakfund&task=statusPro&proyid='.$item->id.'" />Modificar</a>':'';
?>
        <tr class="row<?php echo $i % 2; ?>" id="status_<?php echo $item->status; ?>">
	        <td>
	    		<?php echo $item->id; ?>
	        </td>
	        <td>
	    		<?php echo $item->name; ?>
	        </td>
	        <td>
	        	<?php echo $item->premiereEndDate; ?>
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
	        <td align="absmiddle" style="background-color: <?php echo $item->semaphore; ?>; font-weight:bolder; color:BLACK;">
	        	<?php echo $item->status; ?>
	        </td>
	        <td>
	        	<?php echo $htmlChange; ?>
	        </td>
        </tr>
<?php 
	}
endforeach; 
?>