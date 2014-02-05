<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$value = $this->items;
?>
	<tr>
		<td align="absmiddle">
			<div class="datos">
				<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_NOMBREUSUARIO') ?>: </span><?php echo $value->name; ?>
			</div>
			
			<div class="datos">
				<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_CUENTAORIGEN') ?>: </span><?php echo $value->cuentaOrigen; ?>
			</div>
			
			<div class="datos">
				<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_CUENTADESTINO') ?>: </span><input type="text" name="originCount" align="center" size="23" value="<?php echo $value->numCuenta; ?>" />
			</div>
			
			<div class="datos">
				<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_SALDO') ?>: </span>$<span class="number"><?php echo $value->balance; ?></span>
			</div>
			
			<div class="datos">
				<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_MONTO') ?>:</span> <input type="text" name="mount" />
			</div>
			
			<div class="datos">
				<input type="submit" value="<?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_BUTTON_SEND') ?>" />
			</div>
		</td>
	</tr>