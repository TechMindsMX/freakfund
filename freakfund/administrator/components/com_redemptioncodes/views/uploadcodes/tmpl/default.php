<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// var_dump($this);
// load tooltip behavior
JHtml::_('behavior.tooltip');


$accion = JRoute::_('index.php?option=com_redemptioncodes');
$accion = 'components/com_redemptioncodes/controllers/upload.php';

?>

<form action="<?php echo $accion; ?>" method="post" name="adminForm" enctype="multipart/form-data">
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
			?>
			<tr><th><?php echo JText::_('SIN_REDEMP_CSV'); ?></th></tr>
			<tr><td>
				<input type="file" name="csv" id="csv" />
				<input type="hidden" name="projectid" value="<?php echo $this->items->id; ?>" />
				<input type="hidden" name="token" value="<?php echo $this->items->token; ?>" />
				<input type="hidden" name="callback" value="<?php echo $this->items->callback; ?>" />
				<input type="hidden" name="errorCallback" value="<?php echo $this->items->errorCallback; ?>" />
				<input type="submit" class="button" value="Subir" />
			</td></tr>
		<?php
		}
    	?>
		</tbody>

	    <tfoot>
			<tr>
	        	<td colspan="4"><?php // echo $this->pagination->getListFooter(); ?></td>
			</tr>
		</tfoot>

    </table>
</form>

