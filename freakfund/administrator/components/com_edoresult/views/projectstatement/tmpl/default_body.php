<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$value = $this->items;
var_dump($value);
?>
	<tr>
		<td>
			<table>
				<tr>
					<td>Proyecto:</td>
					<td><?php echo $value['projectName']; ?></td>
				</tr>
				<tr>
					<td>Productor:</td>
					<td><?php echo $value['producerName']; ?></td>
				</tr>
				<tr>
					<td>Presupuesto:</td>
					<td>$<span class="number"><?php echo $value['presupuesto']; ?></span></td>
				</tr>
				<tr>
					<td>Balance:</td>
					<td>$<span class="number"><?php echo $value['balance']; ?></span></td>
				</tr>
				<tr>
					<td>Punto de equiibrio:</td>
					<td>$<span class="number"><?php echo $value['breakeven']; ?></span></td>
				</tr>
			</table>
			
			<table border="1">
				<tr>
					<td>Ingresos</td>
					<td>por financiamiento</td>
					<td></td>
					<td>$<span class="number"><?php echo $value['totalFun']; ?></span></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>por inversion</td>
					<td></td>
					<td>$<span class="number"><?php echo $value['totalInv']; ?></span></td>
				</tr>
				<tr>
					<td>Total</td>
					<td></td>
					<td></td>
					<td>$<span class="number"><?php echo $value['totalIng']; ?></span></td>
				</tr>
				<tr>
					<td></td>
				</tr>
				<tr>
					<td>Egresos</td>
					<td>Productor</td>
					<td></td>
					<td style="color: red;">-$<span class="number"><?php echo $value['totalPay']; ?></span></td>
				</tr>
				<tr>
					<td>Total</td>
					<td></td>
					<td></td>
					<td style="color: red;">-$<span class="number"><?php echo $value['totalEgr']; ?></span></td>
				</tr>
			</table>
		</td>
	</tr>