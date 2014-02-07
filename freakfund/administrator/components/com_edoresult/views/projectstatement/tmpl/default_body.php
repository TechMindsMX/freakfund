<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$value = $this->items;
?>
	<tr>
		<td colspan="3">
			<table width="15%">
				<tr>
					<td colspan="2" align="absmiddle">Datos generales e Indicadores</td>
				</tr>
				<tr>
					<td>Proyecto:</td>
					<td><?php echo $value['proyectName']; ?></td>
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
					<td>Punto de equilibrio</td>
					<td>$<span class="number"><?php echo $value['breakeven']; ?></span></td>
				</tr>
				<tr>
					<td>TRI</td>
					<td><span class="number"><?php echo $value['porcentaTRI']; ?></span>%</td>
				</tr>
				<tr>
					<td>TRF</td>
					<td><span class="number"><?php echo $value['porcentaTRF']; ?></span>%</td>
				</tr>
			</table>
		</td>
		
	</tr>
	<tr>
		<td align="absmiddle">Ingresos</td>
		<td align="absmiddle">Egresos</td>
		<td align="absmiddle">Resultados</td>
	</tr>
	<tr valign="top">
		<td>
			<table class="contenedores">
				<tr>
					<td>por financiamiento</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totFundin']; ?></span></td>
				</tr>
				<tr>
					<td>por inversion</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totInvers']; ?></span></td>
				</tr>
				<tr>
					<td>por ventas</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totVentas']; ?></span></td>
				</tr>
				<tr>
					<td>por patrocinios</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totPatroc']; ?></span></td>
				</tr>
				<tr>
					<td>por apoyos y donativos</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['toApoDona']; ?></span></td>
				</tr>
				<tr>
					<td>Otros</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totalOtro']; ?></span></td>
				</tr>
				<tr>
					<td>Aportaciones de capital</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['toAporCap']; ?></span></td>
				</tr>
				<tr>
					<td>Total</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totalIngresos']; ?></span></td>
				</tr>
				<tr>
					<td></td>
				</tr>
			</table>
		</td>
		<td>	
			<table class="contenedores">
				<!--Seccion de Egresos-->
				<tr>
					<td>Proveedores</td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toProveed']; ?></span></td>
				</tr>
				<tr>
					<td>CAPITAL</td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toCapital']; ?></span></td>
				</tr>
				<tr>
					<td>reembolsos de capital</td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toReemCap']; ?></span></td>
				</tr>
				<tr>
					<td>Productor</td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toProduct']; ?></span></td>
				</tr>
				<tr>
					<td>Costos Fijos</td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toCostFij']; ?></span></td>
				</tr>
				
				<tr>
					<td>Costos Variables</td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toCostVar']; ?></span></td>
				</tr>
				<tr>
					<td>Total</td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['totalEgr']; ?></span></td>
				</tr>
			</table>
		</td>
		<td>	
			<table class="contenedores">
				<!--Resultados-->
				<tr>
					<td>Ingresos-Egresos</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultadoIE']; ?></span></td>
				</tr>
				<tr>
					<td>Retornos</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['retornos']; ?></span></td>
				</tr>
				<tr>
					<td>de feinanciamientos</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultFinan']; ?></span></td>
				</tr>
				<tr>
					<td>de inversion</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultInver']; ?></span></td>
				</tr>
				<tr>
					<td>redenciones</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultReden']; ?></span></td>
				</tr>
				<tr>
					<td>Comiciones</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultComic']; ?></span></td>
				</tr>
				<tr>
					<td>Otros</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultOtros']; ?></span></td>
				</tr>
				<tr>
					<td>Total</td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['toResultado']; ?></span></td>
				</tr>
			</table>
		</td>
	</tr>