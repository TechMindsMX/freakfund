<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$value = $this->items;
?>
	<tr>
		<td align="absmiddle">
			<div class="datos">
				<span class="labels">Nombre del Socio: </span><?php echo $value->name; ?>
			</div>
			
			<div class="datos">
				<span class="labels">Cuenta Origen: </span><?php echo $value->cuentaOrigen; ?>
			</div>
			
			<div class="datos">
				<span class="labels">Cuenta Destino: </span><input type="text" name="originCount" align="center" size="23" value="<?php echo $value->numCuenta; ?>" />
			</div>
			
			<div class="datos">
				<span class="labels">Saldo freakfunds: </span>$<span class="number"><?php echo $value->balance; ?></span>
			</div>
			
			<div class="datos">
				<span class="labels">Monto de la trasferencia:</span> <input type="text" name="mount" />
			</div>
			
			<div class="datos">
				<input type="submit" value="Enviar" />
			</div>
		</td>
	</tr>