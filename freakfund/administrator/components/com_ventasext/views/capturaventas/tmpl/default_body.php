<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.class');
$document = JFactory::getDocument();
$data = $this->items;
$callback = 'index.php?option=com_ventasext&task=capturaventas&id='.$data->id.'&resumen=1'
?>
<tr>
	<td>
		<div class="captura">
			<table class="table table-striped">
				<tr>
					<th><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_SECCION'); ?></th>
					<th style="text-align: right;"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_PRECIO_UNIDAD'); ?></th>
					<th style="text-align: right;"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_UNIDAD_DISPONIBLES'); ?></th>
					<th style="text-align: right;"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_CANTIDAD_A_COMPRAR'); ?></th>
					<th style="text-align: right;"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_COMPRA_SUBTOTAL'); ?></th>
				</tr>
				
				<?php
				foreach ($data->projectUnitSales as $key => $value) {
					$disabled = '';
					if($value->unit == 0){
						$disabled = 'disabled="disabled"';	
					}
				?>
					<input type="hidden" id="totales<?php echo $value->id; ?>" value="<?php echo $value->unit; ?>" />
					<tr class="wrapper">
						<td>
							<?php echo $value->section; ?>
							
						</td>
						<td>
							$<span class="number"><?php echo $value->unitSale; ?></span>
							<input type="hidden" id="precio" value="<?php echo $value->unitSale; ?>" />
						</td>
						<td>
							<div id="uniDisponibles<?php echo $value->id; ?>"><?php echo $value->unit; ?></div>
						</td>
						<td><input type="text" name="<?php echo $value->id; ?>" id="cantidad" <?php echo $disabled; ?> /></td>
						<td align="right">
							$<span class="number sub">0</span>
							<input type="hidden" class="subinput" />
						</td>
						
					</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="4" align="right"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_COMPRA_TOTAL') ?></td>
					<td align="right">$<span class="number total">0</span></td>
				</tr>
			</table>
			
			<div><input type="button" class="button" id="ingresarventa" value="Ingresar Venta" /></div>
		</div>
		
		<div class="detalle" style="display: none;">
			<input type="hidden" name="proyId" value="<?php echo $data->id; ?>" />
			<input type="hidden" name="callback" value="<?php echo $callback; ?>" />
			<div>
				Esta seguro de realizar la siguiente venta externa
			</div>
			<table class="table table-striped">
				<tr>
					<th><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_SECCION'); ?></th>
					<th style="text-align: right;"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_PRECIO_UNIDAD'); ?></th>
					<th style="text-align: right;"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_UNIDAD_DISPONIBLES'); ?></th>
					<th style="text-align: right;"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_CANTIDAD_A_COMPRAR'); ?></th>
					<th style="text-align: right;"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_COMPRA_SUBTOTAL'); ?></th>
				</tr>
				
				<?php
				foreach ($data->projectUnitSales as $key => $value) {
					$disabled = '';
					if($value->unit == 0){
						$disabled = 'disabled="disabled"';	
					}
				?>
					<tr class="wrapper">
						<td><?php echo $value->section; ?></td>
						
						<td>$<span class="number"><?php echo $value->unitSale; ?></span></td>
						
						<td><?php echo $value->unit; ?></td>
						
						<td><div class="<?php echo $value->id; ?>"></div></td>
						
						<td align="right">$<span class="number subdetalle">0</span></td>
					</tr>
				<?php
				}
				?>
				<tr>
					<td colspan="4" align="right"><?php echo JText::_('COM_VENTASEXT_CAPTURAVENTAS_PROJECTNAME_COMPRA_TOTAL') ?></td>
					<td align="right">$<span class="number totaldetalle">0</span></td>
				</tr>
			</table>
			
			<div>
				<input type="button" class="button" id="canceldetalle" value="Cancel" />
				<input type="submit" value="Enviar"> 
			</div>
		</div>
	</td>
</tr>