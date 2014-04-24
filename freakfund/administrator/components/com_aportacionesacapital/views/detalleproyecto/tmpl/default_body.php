<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');
$datos = $this->items;
?>
<tr>
	<td align="justify">
		<div id="detalle">
			<h3><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_TRASPASO'); ?></h3>
			
			<table>
				<?php
				foreach ($datos->providers as $key => $value) {
				?>
				<tr>
					<td><?php echo $value->producerName; ?></td>
					<td>
						<?php echo JText::_('COM_APORTACIONESCAPITAL_APORTACION'); ?>: 
						<input type="text" id="monto" class="montoTrasf<?php echo $key; ?>" > 
					</td>
					<td>
						<input type="button" class="button" id="enviar" value="<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SEND'); ?>" />
						<input type="hidden" value="<?php echo $value->providerId; ?>">
					</td>
				</tr>
				<?php				
				} 
				?>
			</table>
		</div>
		
		<div id="resumen" style="display: none;">
			<input type="hidden" name="proyId" value="<?php echo $datos->id; ?>" />
			<input type="hidden" name="provId" id="provId" />
			<input type="hidden" name="amount" id="amount" />
			
			<div>
				<h3><?php echo strtoupper(JText::_('COM_APORTACIONESCAPITAL_CONFIRM_TITLE')); ?></h3>
			</div>
			<div>
				<?php echo JText::_('COM_APORTACIONESCAPITAL_ESTASEGURO'); ?><span class="providerName"></span>
				<div class="monto" style="font-weight: bold; margin-top: 10px; margin-bottom: 10px;"></div>
			</div>
			
			<div>
				<input type="button" id="send" class="button" value="<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SEND'); ?>" />
			</div>
		</div>
	</td>
</tr>
<?php
?>