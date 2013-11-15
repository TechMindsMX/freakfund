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
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_CREACION'); ?>:</span></div>
				<div class="textos derecha"><?php echo date('d-m-Y', ($datos->timeCreated/1000)); ?></div>
			</div>
			<div>
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_LISTADOPROYECTOS_HEADING_BREAKEVEN'); ?>:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->breakeven; ?></span></div>
			</div>
			
			<div>
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_RECAUDADO'); ?>:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->balance; ?></span></div>
			</div>
			
			<div>
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_FALTANTE'); ?>:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->breakeven-$datos->balance; ?></span></div>
			</div>
			
			
			
			<?php
				echo '<h3>'.JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_PROVEEDORES').'</h3>';
				
				echo "<ul>";
				foreach ($datos->providers as $key => $value) {
					if( $value->producerName != 'Super User' && ($value->providerId != $datos->userId) ){
						echo '<li>';
						echo '<a href="index.php?option=com_aportacionesacapital&task=aporteproveedor&id='.$datos->id.'&providerId='.$value->providerId.'&producer=false">'.$value->producerName.'</a>';
						echo '</li>';
					}
				}
				echo "</ul>";
			?>
			<div>
				<span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_LISTADOPROYECTOS_HEADING_PRODUCTOR');?>:</span> 
				<a href="index.php?option=com_aportacionesacapital&task=aporteproveedor&id=<?php echo $datos->id; ?>&providerId=<?php echo $datos->userId; ?>&producer=true">
					<?php echo $datos->producerName; ?>
				</a> 
			</div>
		</td>
	</tr>
<?php
?>