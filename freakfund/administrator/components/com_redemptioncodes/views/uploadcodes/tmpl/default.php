<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');

$formulario = '<p>'.JText::_('SIN_REDEMP_CSV').'</p>'.
				'<input type="file" name="csv" value="" />'.
				'<input type="hidden" name="projectid" value="'.$this->items->id.'" />'.
				'<input type="submit" class="button" value="Subir" />';

$accion = JRoute::_('index.php?option=com_redemptioncodes');
$accion = 'components/com_redemptioncodes/controllers/upload.php';

?>
<form action="" method="post" name="adminForm" enctype="multipart/form-data">
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

