<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$token 		= JTrama::token();
$document 	= JFactory::getDocument();
$document	-> addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document	-> addScript('../templates/rt_hexeris/js/jquery.number.min.js');
$datos 		= $this->items;
$callback 	= JURI::BASE().'index.php?option=com_admincuentas'
?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		jQuery('span.number').number(true,2);
	});
</script>

<form id="formstatus" action="<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/stp/transferFundsBridgeToTrama" method="POST" enctype="application/x-www-form-urlencoded">
	
        <table id="tablaGral" class="adminlist">
        	<thead><tr><th></th></tr></thead>
        	
			<tfoot><tr><td></td></tr></tfoot>
			
			<tbody>
				<tr>
					<td>
						<div>
							<?php echo JText::_('COM_TRASPASO_PUENTE_CONCENTRADORA'); ?>
						</div>
						
						<div style="margin-top: 30px;">
							<form action="" method="post">
								<input type="hidden" name="token" value="<?php echo $token; ?>" />
								<input type="hidden" name="callback" value="<?php echo $callback; ?>">
								
								<label for="mount">Monto a traspasar</label>
								<input type="text" name="amount">
								
								<input type="submit" value="Enviar" class="button" />
							</form>
						</div>
					</td>
				</tr>
			</tbody>
			
        </table>
</form>
