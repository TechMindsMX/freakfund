<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');
$datos = $this->items;
//var_dump($datos);exit;
?>
<tr>
	<td align="justify">
		<div id="hiddens">
			<input type="hidden" name="token" value="<?php echo $datos->token; ?>" />
			<input type="hidden" name="projectId" value="<?php echo $datos->projectId; ?>" />
			<input type="hidden" name="providerId" value="<?php echo $datos->providerId; ?>" />
			<input type="hidden" name="type" value="<?php echo $datos->type; ?>" />
			
		</div>
		Esta seguro de enviar esta operacion es IRREVERSIBLE!!!!!!!!!!!!
		<br /><br /><br />
		
		Nombre proveedor: <?php echo $datos->producerName; ?>
		<br /><br />
		
		Nombre del proyecto:<?php echo $datos->ProductName; ?>
		<br /><br /> 
		
		Monto de la aportacion : $<span class="number"><?php echo $datos->monto; ?></span>
		<br /><br /><br />
		
		<input type="submit" value="<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SEND'); ?>" />
	</td>
</tr>
<?php
?>