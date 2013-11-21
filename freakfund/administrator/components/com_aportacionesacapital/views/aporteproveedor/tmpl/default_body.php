<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');
$datos = $this->items;
?>
	<tr>
		<td align="justify">
			<div class="subtitulo"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SUBTITLE'); ?></div>
			<div>
				<div class="textos">
					<input type="checkbox" name="anticipo" value="1" <?php if ($datos->advancePaidDate OR $datos->advanceFundingDate) echo 'disabled';?> />
					<span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_ADVANCEQUANTITY'); ?>:</span>
				</div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->advanceQuantity; ?></span></div>
			</div>
			
			<div>
				<div class="textos">
					<input type="checkbox" name="liquidacion" value="2" <?php if ($datos->settlementPaidDate OR $datos->settlementFundingDate) echo 'disabled';?> />
					<span class="labels">
						<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SETTLEMENTQUENTITY'); ?>:
					</span>
				</div>
				<div class="textos derecha">
					$<span class="number">
						<?php echo $datos->settlementQuantity; ?>
					</span>
					
				</div>
			</div>
			
			<?php
			$fullAporte = ($datos->advancePaidDate AND $datos->advancePaidDate AND $datos->settlementPaidDate AND $datos->settlementFundingDate)? true: false;
			if($datos->producer AND $fullAporte){ 
			?>
				<div style="margin-top: 20px;">
					<span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_MONTOCUENTA'); ?>: </span>
					<input type="text" name="aportacionliquida" id="aportacionliquida" />
				</div>
				
				<div>
					<span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SALDOPENDIENTE') ?></span> 
					$<span class="number"><?php echo $datos->balance; ?></span></div>
			<?php 
			}
			?>
			<div class="pie">
				<?php $productor = $datos->producer ? 1 : 0; ?>
				<input type="hidden" name="projectId" value="<?php echo $datos->projectId; ?>" />
				<input type="hidden" name="providerId" value="<?php echo $datos->providerId; ?>" />
				<input type="hidden" name="producer" value="<?php echo $productor; ?>" />
				
				<input type="submit" value="<?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SEND') ?>"
			</div>
		</td>
	</tr>
<?php
?>