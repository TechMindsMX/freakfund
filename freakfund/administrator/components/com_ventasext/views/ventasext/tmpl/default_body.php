<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$document = JFactory::getDocument();

if( isset($this->items[0]->type) ) {//valida que haya resultados
	foreach($this->items as $i => $item):
		if ( $item->type != 'REPERTORY' ) {
			$statusNoModificables 	= array(4,8);
			$statusName 			= JTrama::getStatusName($item->status, $this->items[0]->statusList);
			$item->htmlChange 		= !in_array($item->status,$statusNoModificables) ? '<a href="index.php?option=com_freakfund&task=statusPro&proyid='.$item->id.'" />Modificar</a>':'';
	?>
	        <tr class="row<?php echo $i % 2; ?>" id="<?php echo $item->status; ?>">
		        <td>
		    		<?php echo $item->id; ?>
		        </td>
		        <td>
		    		<?php echo $item->name; ?>
		        </td>
		        <td>
		        	<?php echo JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName); ?>
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