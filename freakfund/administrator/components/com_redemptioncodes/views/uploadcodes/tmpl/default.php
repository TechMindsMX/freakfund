<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

$formulario = '<p>'.JText::_('SIN_REDEMP_CSV').'</p>'.
				'<input type="file" name="redemptionCsv" />';

?>
<form action="<?php echo JRoute::_('index.php?option=com_redemptioncodes'); ?>" method="post" name="adminForm">
    <table class="adminlist">
    	<?php
    	'<h2>'.$this->items->name.'</h2>';
    	
    	if(isset($this->items->redemptionCodes)) {
    		
			echo '<tr><th>'.JText::_('LISTADO_REDEMP_CODES').'</th></tr>';
	    	foreach ($this->items->redemptionCodes as $i => $value) {
	    		?>
				<tr class="row<?php echo $i % 2; ?>">

				<td><?php echo $value; ?></td>
				</tr>
				<?php
			}
		} else {
			echo $formulario;
		}
    	?>
				<div>
					<input type="hidden" name="task" value="" />
					<input type="hidden" name="boxchecked" value="0" />
					<?php echo JHtml::_('form.token'); ?>
				</div>

		</tbody>

	    <tfoot>
			<tr>
	        	<td colspan="4"><?php // echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>

    </table>
</form>