<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');
$datos = $this->items;
//var_dump($datos);exit;
?>
	<tr>
		<td align="justify">
			<div>
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_ADVANCEQUANTITY'); ?>:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->advanceQuantity; ?></span></div>
			</div>
			
			<div>
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SETTLEMENTQUENTITY'); ?>:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->settlementQuantity; ?></span></div>
			</div>
			
			<div>
				<input type="hidden" name="advanceQuantity" value="<?php echo $datos->advanceQuantity; ?>" />
				<input type="hidden" name="settlementQuantity" value="<?php echo $datos->settlementQuantity; ?>" />
				
				<input type="submit" value="<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SEND') ?>"
			</div>
		</td>
	</tr>
<?php
?>