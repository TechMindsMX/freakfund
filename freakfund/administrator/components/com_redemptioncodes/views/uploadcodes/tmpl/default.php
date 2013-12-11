<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');

$accion = MIDDLE.PUERTO.'/trama-middleware/rest/ticketmaster/uploadTicketmasterLayout';
$html = $this->items->redemptioncode?'<tr><th><p><img src="'.JURI::base().'templates/bluestork/images/admin/tick.png" />'.JText::_('REDEMPTIONCODE_UPLOAD_CODE_READY').'</p></th></tr>':'';
?>

<form action="<?php echo $accion; ?>" method="post" name="adminForm" enctype="multipart/form-data">
    <table class="adminlist">
    	<?php
    	echo '<h2>'.$this->items->name.'</h2>';
    	
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
			<?php echo $html; ?>
			<tr><th><?php echo JText::_('SIN_REDEMP_CSV'); ?></th></tr>
			<tr><td>
				<input type="file" name="layout" id="csv" />
				<input type="hidden" name="projectId" value="<?php echo $this->items->id; ?>" />
				<input type="hidden" name="token" value="<?php echo $this->items->token; ?>" />
				<input type="hidden" name="callback" value="<?php echo $this->items->callback; ?>" />
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

