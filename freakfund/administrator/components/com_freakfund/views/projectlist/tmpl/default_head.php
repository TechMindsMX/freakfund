<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');

$datosSelect = $this->items[0]->statusList;
?>
<tr>
	<th>
        <?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_IDPORD'); ?>
    </th>
    <th>
        <?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_NAMEPROD'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_CLOSEDATE');?>
    </th>
    <th>
    	<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_BALANCE');?>
    </th>
    <th>
    	<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_BREAKEVEN'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_PERCENTAGE'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_STATUS'); ?>
    	<div>
    		<select id="statusFilter">
    			<option value="all">Seleccione una opción</option>
    			<?php
				foreach ($datosSelect as $key => $value) {
					if ( ($value->id >= 4) && ($value->id != 9) ) {
						echo '<option value="'.$value->id.'">'.$value->name.'</option>';
					}
				}
    			?>
    		</select>
    	</div>
    </th>
    <th>
    	<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_SEMAPHORE'); ?>
    </th>
    <th>
    	<?php echo JText::_('COM_FREAKFUND_PROJECTLIST_HEADING_CHANGESTATUS'); ?>
    </th>
</tr>