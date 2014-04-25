<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');

$datosSelect 	= $this->items[0]->statusList;
$statusvalidos 	= array(6,7);
?>
<tr>
	<th>
        <?php echo JText::_('COM_VENTASEXT_PROJECTLIST_HEADING_IDPORD'); ?>
    </th>
    <th>
        <?php echo JText::_('COM_VENTASEXT_PROJECTLIST_HEADING_NAMEPROD'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_VENTASEXT_PROJECTLIST_HEADING_STATUS'); ?>
    	<div>
    		<select id="statusFilter">
    			<option value="all"><?php echo JText::_('COM_VENTASEXT_SELECT_OPTION'); ?></option>
    			<?php
				foreach ($datosSelect as $key => $value) {
					if ( ($value->id == 6) || ($value->id == 7) ) {
						echo '<option value="'.$value->id.'">'.$value->name.'</option>';
					}
				}
    			?>
    		</select>
    	</div>
    </th>
</tr>