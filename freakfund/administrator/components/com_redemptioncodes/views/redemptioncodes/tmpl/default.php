<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_redemptioncodes'); ?>" method="post" name="adminForm">
    <table class="adminlist">
        <thead>
			<tr>
		        <th>
		        	<?php echo JText::_('COM_REDEMPTIONCODES_REDEMPTIONCODES_HEADING_ID'); ?>
		        </th>
		                         
		        <th>
		            <?php echo JText::_('COM_REDEMPTIONCODES_REDEMPTIONCODES_HEADING_NAME'); ?>
		        </th>
		        <th>
		        	<?php echo JText::_('COM_REDEMPTIONCODES_REDEMPTIONCODES_HEADING_STATUS'); ?>
		        </th>
		        <th>
		        	<?php echo JText::_('COM_REDEMPTIONCODES_REDEMPTIONCODES_HEADING_CODES'); ?>
		        </th>
		        <th>
		        	<?php echo JText::_('COM_REDEMPTIONCODES_REDEMPTIONCODES_HEADING_EXISTS'); ?>
		        </th>
			</tr>
		</thead>
        <tbody>
			<?php 
			
			$front = str_replace('administrator/', '', JURI::base());
			$linkPro = $front.'index.php?option=com_jumi&view=application&fileid=11&proyid=';
			
			$linkCodes = 'index.php?option=com_redemptioncodes&view=uploadcodes&proyid=';
			
			foreach($this->items as $i => $item):
				$img = $item->redemptioncodes? JURI::base().'templates/bluestork/images/admin/tick.png':JURI::base().'templates/bluestork/images/admin/publish_x.png';
			 	
			?>
				<tr class="row<?php echo $i % 2; ?>">
					<td>
						<?php echo $item->id; ?>
					</td>
					<td>
						<?php echo $item->name; ?>
						<span style="margin-left: 50px;">
							<a target="_blank" href="<?php echo $linkPro. $item->id; ?>"><?php echo JText::_('VER_PROY'); ?></a>
						</span>
					</td>
					<td>
						<?php echo JHTML::tooltip($item->statusName->tooltipText,$item->statusName->tooltipTitle,'',$item->statusName->fullName); ?>
					</td>
					<td>
						<a href="<?php echo $linkCodes. $item->id; ?>"><?php echo JText::_('ADD_REDEMP_CODES'); ?></a>
					</td>
					<td align="middle">
						<img src="<?php echo $img; ?>" />
					</td>
				</tr>
			<?php 
			endforeach; 
			?>
				<div>
					<input type="hidden" name="task" value="" />
					<input type="hidden" name="boxchecked" value="0" />
					<?php echo JHtml::_('form.token'); ?>
				</div>

		</tbody>

	    <tfoot>
			<tr>
	        	<td colspan="5"><?php // echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>

    </table>
</form>