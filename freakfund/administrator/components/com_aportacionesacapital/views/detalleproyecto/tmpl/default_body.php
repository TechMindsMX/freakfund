<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');
$datos = $this->items;
?>
	<tr>
		<td align="absmiddle">
			<?php
				echo '<div>'.JText::_('COM_APORTACIONESCAPITAL_DETALLAEPROYECTO_PROVEEDORES').'</div>';
				
				echo "<div>";
				foreach ($datos->providers as $key => $value) {
					if($value->producerName != 'Super User'){
						echo $value->producerName.'<br />';
					}
				}
				echo "</div>";
			?>
		</td>
	</tr>
<?php
?>