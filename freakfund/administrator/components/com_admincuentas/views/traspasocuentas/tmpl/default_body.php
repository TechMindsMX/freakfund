<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$value = $this->items;
?>
	<tr>
		<td align="absmiddle">
			<input type="hidden" id="callback" name="callback" />
			<input type="hidden" id="balanceOrigen" value="<?php echo $value['balance']; ?>" />
			
			<div id="formulario">
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_CUENTAORIGEN') ?>: </span><?php echo $value['cuentaOrigen']; ?>
				</div>
				
				<div class="datos" id="balanceOrigen">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_LISTADOCUENTAS_HEADING_BALANCE') ?>: </span>
					$<span class="number"><?php echo $value['balance']; ?></span>
				</div>
				
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_CUENTA_DESTINO') ?>: </span>
					<input type="text" class="numCuenta" name="cuentaDestino" id="cuentaDestino" maxlength="11" />
				</div>
				
				<div class="datosCuenta">
					<div class="datos">
						<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_PROYECTO') ?>: </span>
						<span class="proyecto"></span>
					</div>
				</div>
				
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_MONTO') ?>: </span>
					<input type="text" class="numCuenta" name="amount" id="montoTraspaso" maxlength="14" />
				</div>
				
				<div class="datos">
					<input type="button" class="button" id="confirmButton" value="<?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_BUTTON_SEND') ?>" />
				</div>
			</div>
			
			<div id="confirmacion">
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_CUENTAORIGEN') ?>: </span><?php echo $value['cuentaOrigen']; ?>
				</div>
				
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_LISTADOCUENTAS_HEADING_BALANCE') ?>: </span>
					$<span class="number">><?php echo $value['balance']; ?></span>
				</div>
				
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_CUENTA_DESTINO') ?>: </span>
					<span id="destino"></span>
				</div>
				
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_PROYECTO') ?>: </span>
					<span class="proyecto"></span>
				</div>
				
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_MONTO') ?>: </span>
					<span class="montoTraspaso"></span>
				</div>
				
				<div class="datos">
					<input type="button" class="button" id="cancelConfirm" value="<?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_BUTTON_CANCEL_CONFIRM') ?>" />
					<input type="button" class="button" id="submit" value="<?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_BUTTON_CONFIRM') ?>" />
				</div>
			</div>
		
			<div id="resumen">
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_TRAS_PROY') ?>: </span>
					<?php echo $value['name']; ?>
				</div>
				
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_CUENTAORIGEN') ?>: </span>
					<?php echo $value['cuentaOrigen']; ?>
				</div>
				
				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_CUENTA_DESTINO') ?>: </span>
					<?php echo $value['accountDest']; ?>
				</div>

				<div class="datos">
					<span class="labels"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_MONTO') ?>: </span>
					$<span class="number"><?php echo $value['amount']; ?></span>
				</div>
				
				<div class="datos">
					<a href="index.php?option=com_admincuentas" class="button"><?php echo JText::_('COM_ADMINCUENTAS_TRASPASO_GOBACK'); ?></a>
				</div>
			</div>
		</td>
	</tr>