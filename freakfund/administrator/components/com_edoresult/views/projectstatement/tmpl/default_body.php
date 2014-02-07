<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$value = $this->items;
?>
	<tr>
		<td width="37.5%"></td>
		<td width="25%">
			<table class="contenedores">
				<tr>
					<td colspan="2" align="absmiddle"><h3><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_T1'); ?></h3></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PROYECTO'); ?></td>
					<td class="cantidades"><strong><?php echo $value['proyectName']; ?></strong></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PRODUCTOR'); ?></td>
					<td class="cantidades"><strong><?php echo $value['producerName']; ?></strong></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PRESUPUESTO'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['presupuesto']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_BREAKEVEN'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['breakeven']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_BALANCE'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['balance']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_TRI'); ?></td>
					<td class="cantidades"><span class="number"><?php echo $value['porcentaTRI']; ?></span>%</td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_TRF'); ?></td>
					<td class="cantidades"><span class="number"><?php echo $value['porcentaTRF']; ?></span>%</td>
				</tr>
			</table>
		</td>
		<td width="37.5%"></td>
	</tr>
	<tr>
		<td align="absmiddle"><h3><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_INGRESOS'); ?></h3></td>
		<td align="absmiddle"><h3><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_EGRESOS'); ?></h3></td>
		<td align="absmiddle"><h3><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_RESULTADOS'); ?></h3></td>
	</tr>
	<tr valign="top">
		<td>
			<table class="contenedores">
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORFINANCIAMIENTO'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totFundin']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORINVERSION'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totInvers']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORVENTAS'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totVentas']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORPATROCINIOS'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totPatroc']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORAPOYO_DONATIVOS'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['toApoDona']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_OTROS'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totalOtro']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_APORTACIONES_CAPITAL'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['toAporCap']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_TOTAL'); ?></td>
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
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PROVEEDORES'); ?></td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toProveed']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_CAPITAL'); ?></td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toCapital']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_REEMBOLSO'); ?></td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toReemCap']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_EPRODUCTOR'); ?></td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toProduct']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_COSTOS_FIJOS'); ?></td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toCostFij']; ?></span></td>
				</tr>
				
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_COSTOS_VARIABLES'); ?></td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['toCostVar']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_TOTAL'); ?>Total</td>
					<td></td>
					<td class="tdCantidadesegresos">-$<span class="number"><?php echo $value['totalEgresos']; ?></span></td>
				</tr>
			</table>
		</td>
		<td>	
			<table class="contenedores">
				<!--Resultados-->
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_INGRESOS_EGRESOS'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultadoIE']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_RETORNOS'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['retornos']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_DEFINANCIAMIENTO'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultFinan']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_DEINVERSION'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultInver']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_REDENCIONES'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultReden']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_COMICIONES'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultComic']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_OTROS'); ?></td>
					<td></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultOtros']; ?></span></td>
				</tr>
			</table>
		</td>
	</tr>