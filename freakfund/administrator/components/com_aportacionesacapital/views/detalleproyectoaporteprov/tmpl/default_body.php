<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');
$datos = $this->items;
?>
<tr>
	<td align="justify">
			
		<h3><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_PROVEEDORES'); ?></h3>
			
		<table class="adminlist">
			<tr>
				<th><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_PROVEEDOR'); ?></th>
				<th><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_ADVANCEQUANTITY'); ?></th>
				<th><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_SETTLEMENTQUENTITY'); ?></th>
				<th><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROVEEDOR_NOTAS'); ?></th>
			</tr>
			<?php 
			foreach ($datos->providers as $key => $value) {
				if ($value->flags < 2 ) {
					if ($value->isProducer){
						$htmlProviderName = '<a href="index.php?option=com_aportacionesacapital&task=aporteproveedor&id='.$datos->id.'&providerId='.$value->providerId.'&producer=1">
						'.$value->producerName.'
						</a>
						<p>'.JText::_('COM_APORTACIONESCAPITAL_PRODUCTOR').'</p>';
					} else {
						$htmlProviderName = '<a href="index.php?option=com_aportacionesacapital&task=aporteproveedor&id='.$datos->id.'&providerId='.$value->providerId.'&producer=0">
						'.$value->producerName.'
						</a>';
					}
				} else {
					$htmlProviderName = $value->producerName;
				}
				
				echo '<tr class="row'.($key % 2).'">
				<td>
					'.$htmlProviderName.'						
				</td>
				<td>
					<p><span class="number">'.$value->advanceQuantity.'</span></p>
					<p>'.$value->advanceDate.'</p>
				</td>
				<td>
					<p><span class="number">'.$value->settlementQuantity.'</span></p>
					<p>'.$value->settlementDate.'</p>
				</td>
				<td>
					<p>'.$value->flagsTxt.'</p>
				</td>
				</tr>';
			}
		?>
		</table>
	</td>
</tr>
<?php
?>