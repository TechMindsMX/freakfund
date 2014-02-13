<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
jimport('trama.usuario_class');

$doc = JFactory::getDocument();
$doc->addStyleSheet('../components/com_jumi/files/estado_resultados/edo_resultados.css');
$doc->addStyleDeclaration('table.table-striped {width: 100%;} table.table-striped tr:nth-child(odd) td {background: #f0f0f0;}');

$value = $this->items;
?>
<tr><td>
		<div style="width:50%">
	
			<div class="titulo-tabla espacio-bajo"><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_INGRESOS'); ?></div>
			<table class="table table-striped">
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORFINANCIAMIENTO'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totFundin']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORINVERSION'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totInvers']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORVENTAS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totVentas']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORPATROCINIOS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totPatroc']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORAPOYO_DONATIVOS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['toApoDona']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_OTROS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totalOtro']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_APORTACIONES_CAPITAL'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['toAporCap']; ?></span></td>
				</tr>
				<tr class="total">
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_TOTAL'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totalIngresos']; ?></span></td>
				</tr>
			</table>

			<div class="titulo-tabla espacio-bajo"><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_EGRESOS'); ?></div>
			<table class="table table-striped">
				<!--Seccion de Egresos-->
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PROVEEDORES'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toProveed']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_CAPITAL'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toCapital']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_REEMBOLSO'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toReemCap']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_EPRODUCTOR'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toProduct']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_COSTOS_FIJOS'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toCostFij']; ?></span></td>
				</tr>
				
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_COSTOS_VARIABLES'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toCostVar']; ?></span></td>
				</tr>
				<tr class="total">
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_TOTAL'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['totalEgresos']; ?></span></td>
				</tr>
			</table>

			<div class="titulo-tabla espacio-bajo"><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_RESULTADOS'); ?></div>
			<table class="table table-striped">
				<!--Resultados-->
				<tr class="total">
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_INGRESOS_EGRESOS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultadoIE']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_RETORNOS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['retornos']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_DEFINANCIAMIENTO'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultFinan']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_DEINVERSION'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultInver']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_REDENCIONES'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultReden']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_COMICIONES'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultComic']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_OTROS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultOtros']; ?></span></td>
				</tr>
			</table>
			
			<div class="titulo-tabla espacio-bajo"><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_T1'); ?></div>
			<table class="table table-striped">
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PRESUPUESTO'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['presupuesto']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_BREAKEVEN'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['breakeven']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_INGRESO_POTENCIALES'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['ingresosPotenciales']; ?></span></td>
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
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_FUNDENDDATE'); ?></td>
					<td class="cantidades"><?php echo $value['finFunding']; ?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PRODUCTIONSTARTDATE'); ?></td>
					<td class="cantidades"><?php echo $value['FechaInicioProduc']; ?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PREMIERSTARTDATE'); ?></td>
					<td class="cantidades"><?php echo $value['FechaEstreno']; ?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PRIMIERENDDATE'); ?></td>
					<td class="cantidades"><?php echo $value['fechafin']; ?></td>
				</tr>
			</table>
</div>
</td></tr>