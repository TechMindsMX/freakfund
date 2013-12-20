<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$document = JFactory::getDocument();
$document->addScript('../libraries/trama/js/jquery.number.min.js'); 

if( isset($this->items[0]->type) ) {
	foreach($this->items as $i => $item):
		if ( $item->type != 'REPERTORY' ) {
			$statusNoModificables = array(4,5,8);
			$statusName = JTrama::getStatusName($item->status);
			$item->htmlChange = !in_array($item->status,$statusNoModificables) ? '<a href="index.php?option=com_freakfund&task=statusPro&proyid='.$item->id.'" />Modificar</a>':'';
	?>
	        <tr class="row<?php echo $i % 2; ?>" id="<?php echo $item->status; ?>">
		        <td>
		    		<?php echo $item->id; ?>
		        </td>
		        <td>
		    		<?php echo $item->name; ?>
		        </td>
		        <td>
		        	<?php echo $item->FechaApintar; ?>
		        </td>
		        <td>
		        	$<span class="number"><?php echo $item->balance; ?></span>
		        </td>
		        <td>
		        	$<span class="number"><?php echo $item->breakeven; ?></span>
		        </td>
		        <td>
		        	<?php echo $item->percentage; ?>
		        </td>
		        <td>
		        	<?php echo JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName); ?>
		        </td>
		        <td align="absmiddle" style="background-color: <?php echo $item->semaphore; ?>; font-weight:bolder; color:BLACK;">
		        	<?php echo $item->status; ?>
		        </td>
		        <td>
		        	<?php echo $item->htmlChange; ?>
		        </td>
	        </tr>
	<?php 
		}
	endforeach;
}else{
?>
		<tr>
			<td align="middle" colspan="8"><?php echo JText::_('COM_FREAKFUND_FREAKFUND_BODY_NOPROJECTS') ?></td>
		</tr>
<?php
}
?>