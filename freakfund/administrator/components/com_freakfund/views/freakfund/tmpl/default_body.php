<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
jimport('trama.usuario_class');
JHtml::_('behavior.tooltip');
$urls = new JTrama;

$statusIds = explode(',', $this->_models['freakfund']->statusIds);
foreach ($statusIds as $key => $value) {
	$statusIds[$key] = JTrama::getStatusName($value);
	$statusNames[] = JHTML::tooltip($statusIds[$key]->tooltipText,$statusIds[$key]->tooltipTitle,'',$statusIds[$key]->fullName)."(".$statusIds[$key]->id.")";
}
$statusNames = implode(', ', $statusNames);

echo '<p>Se muestran los proyectos en estatus = '.$statusNames.'</p>';

if( !empty($this->items) ) {
	foreach($this->items as $i => $item):
		if ( $item->type != 'REPERTORY' ) {
	?>
	        <tr class="row<?php echo $i % 2; ?>" id="status_<?php echo $item->status; ?>">
		        <td>
		    		<?php echo $item->name; ?>
		        </td>
		        <td>
		        	<?php echo $item->htmlProductor; ?>
		        </td>
		        <td>
		        	<?php echo $item->htmlProveedores; ?>
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