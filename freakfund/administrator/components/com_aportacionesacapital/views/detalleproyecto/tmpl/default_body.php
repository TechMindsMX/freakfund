<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');
jimport('trama.class');
$token = JTrama::token();
$datos = $this->items;
$callback = JURI::base().'index.php?option=com_aportacionesacapital&task=errors&id='.$datos->id;
?>
<tr>
	<td align="justify">
		<div id="detalle">
			<h3><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_TRASPASO'); ?></h3>
			
			<table>
				<?php
				foreach ($datos->providers as $key => $value) {
					if( $value->producerName != '' ){
				?>
				<tr>
					<td><span class="producerName"><?php echo $value->producerName; ?></span></td>
					<td>
						<?php echo JText::_('COM_APORTACIONESCAPITAL_APORTACION'); ?>: 
						<input type="text" id="monto" class="montoTrasf<?php echo $key; ?>" >
						<input type="hidden" value="<?php echo $value->providerId; ?>"> 
					</td>
					<td>
						<input type="button" class="button" id="enviar" value="<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SEND'); ?>" />
					</td>
				</tr>
				<?php
					}
				} 
				?>
			</table>
		</div>
		
		<div id="resumen" style="display: none;">
			<input type="hidden" name="projectId" value="<?php echo $datos->id; ?>" />
			<input type="hidden" name="providerId" id="provId" />
			<input type="hidden" name="amount" id="mount" />
			<input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />
			<input type="hidden" name="callback" id="callback" value="<?php echo $callback; ?>" />
			
			<div>
				<h3><?php echo strtoupper(JText::_('COM_APORTACIONESCAPITAL_CONFIRM_TITLE')); ?></h3>
			</div>
			<div>
				<?php echo JText::_('COM_APORTACIONESCAPITAL_ESTASEGURO'); ?><span class="providerName" style="font-weight: bolder;"></span>
				<div class="monto" style="font-weight: bold; margin-top: 10px; margin-bottom: 10px;"></div>
			</div>
			
			<div>
				<input type="button" id="cancel" class="button" value="<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_CANCEL'); ?>" />
				&nbsp;
				<input type="button" id="send" class="button" value="<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SEND'); ?>" />
			</div>
		</div>
	</td>
</tr>
<?php
?>