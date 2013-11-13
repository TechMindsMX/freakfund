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
				<div class="textos"><span class="labels">Fecha de creación:</span></div>
				<div class="textos derecha"><?php echo date('d-m-Y', ($datos->timeCreated/1000)); ?></div>
			</div>
			<div>
				<div class="textos"><span class="labels">Punto de equilibrio:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->breakeven; ?></span></div>
			</div>
			
			<div>
				<div class="textos"><span class="labels">Recaudado:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->balance; ?></span></div>
			</div>
			
			<div>
				<div class="textos"><span class="labels">Por recaudar:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->breakeven-$datos->balance; ?></span></div>
			</div>
			
			
			
			<?php
				echo '<h3>'.JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_PROVEEDORES').'</h3>';
				
				echo "<ul>";
				foreach ($datos->providers as $key => $value) {
					if( $value->producerName != 'Super User' && ($value->providerId != $datos->userId) ){
						echo '<li>'.$value->producerName.'</li>';
					}
				}
				echo "</ul>";
			?>
			<div>
				<?php echo '<span class="labels">'.JText::_('COM_APORTACIONESCAPITAL_LISTADOPROYECTOS_HEADING_PRODUCTOR').':</span> '.$datos->producerName; ?> 
			</div>
		</td>
	</tr>
<?php
?>