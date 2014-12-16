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
<!--inicia seccion de ventas-->
				<tr>
					<td colspan="2" style="font-weight: bold;">
						<div><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORFINANCIAMIENTO'); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<div><?php echo JText::_('ALTA_PRO_MONTO'); ?>:</div>
						<div><?php echo JText::_('PORCENTAJE_COSTOS'); ?>:</div>
					</td>
					<td class="cantidades">
						<div>$<span class="number"><?php echo $value['totFundin']; ?></span></div>
						<div><span class="number"><?php echo $value['porFundin']; ?></span>%</div>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="font-weight: bold;"><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORINVERSION'); ?></td>
				</tr>
				<tr>
					<td>
						<div><?php echo JText::_('ALTA_PRO_MONTO'); ?>:</div>
						<div><?php echo JText::_('PORCENTAJE_COSTOS'); ?>:</div>
					</td>
					<td class="cantidades">
						<div>$<span class="number"><?php echo $value['totInvers']; ?></span></div>
						<div><span class="number"><?php echo $value['porInvers']; ?></span>%</div>
					</td>
				</tr><tr>
					<td colspan="2" style="font-weight: bold;"><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORVENTAS'); ?></td>
				</tr>
				<tr>
					<td>
						<div><?php echo JText::_('ALTA_PRO_MONTO'); ?>:</div>
						<div><?php echo JText::_('PORCENTAJE_COSTOS'); ?>:</div>
					</td>
					<td class="cantidades">
						<div>$<span class="number"><?php echo $value['totVentas']; ?></span></div>
						<div><span class="number"><?php echo $value['porVentas']; ?></span>%</div>
					</td>
				</tr>
				<tr style="font-size: 16px; font-weight: bold;">
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_TOTALPORVENTAS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totalPorVentas']; ?></span></td>
				</tr>
<!--Fin de la seccion de ventas-->
				<?php 
				if($value['totPatroc'] != 0){ 
				?>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORPATROCINIOS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totPatroc']; ?></span></td>
				</tr>
				<?php
				}
				if($value['toApoDona'] != 0){
				?>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORAPOYO_DONATIVOS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['toApoDona']; ?></span></td>
				</tr>
				<?php
				}
				if($value['totalOtro'] != 0){
				?>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_OTROS'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totalOtro']; ?></span></td>
				</tr>
				<?php
				}
				if($value['toAporCap'] != 0){
				?>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_APORTACIONES_CAPITAL'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['toAporCap']; ?></span></td>
				</tr>
				<?php
				}
                if($value['totTransTrama'] != 0){
                    ?>
                    <tr>
                        <td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PORTRANSFERENCIATRAMA'); ?></td>
                        <td class="cantidades">$<span class="number"><?php echo $value['totTransTrama']; ?></span></td>
                    </tr>
                <?php
                }
				?>
				<tr class="total">
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_TOTAL'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['totalIngresos']; ?></span></td>
				</tr>
			</table>

				<!--Seccion de Egresos-->
			<div class="titulo-tabla espacio-bajo"><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_EGRESOS'); ?></div>
			<table class="table table-striped">
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_PROVEEDORES'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toProveed']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_CAPITAL'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toCapital']; ?></span></td>
				</tr>
				<?php
				if($value['toAporCap'] != 0){
				?>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_REEMBOLSO'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toReemCap']; ?></span></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_EPRODUCTOR'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toProduct']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_FEE_TRAMA'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toFeeTrama']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_RETORNOS'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toRetornos']; ?></span></td>
				</tr>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_COSTOS_VARIABLES').JText::_('COM_ESTADO_RESULTADOS_DETALLE_LVL_PROYECTADOS'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['toCostVar']; ?></span></td>
				</tr>
				<tr class="total">
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_TOTAL'); ?></td>
					<td class="cantidades egresos">-$<span class="number"><?php echo $value['totalEgresos']; ?></span></td>
				</tr>
			</table>

<!--Resultados-->
			<div class="titulo-tabla espacio-bajo"><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_RESULTADOS'); ?></div>
			<table class="table table-striped">
				
				<tr class="total">
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_INGRESOS_EGRESOS'); ?></td>
					<td class="cantidades">$<?php echo number_format($value['resultadoIE'], 2); ?></td>
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
				<?php
				if($value['resultReden'] != 0){
				?>
				<tr>
					<td><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_REDENCIONES'); ?></td>
					<td class="cantidades">$<span class="number"><?php echo $value['resultReden']; ?></span></td>
				</tr>
				<?php 
				}
				?>
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
					<td colspan="2" style="font-weight: bold;">
						<div><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_BREAKEVEN'); ?></div>
					</td>
				</tr>
				<tr>
					<td>
						<div><?php echo JText::_('ALTA_PRO_MONTO'); ?>:</div>
						<div><?php echo JText::_('PORCENTAJE_COSTOS'); ?>:</div>
					</td>
					<td class="cantidades">
						<div>$<span class="number"><?php echo $value['breakeven']; ?></span></div>
						<div><span class="number"><?php echo $value['porBreakeven']; ?></span>%</div>
					</td>
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
			
			<div class="titulo-tabla espacio-bajo"><?php echo JText::_('COM_ESTADO_RESULTADOS_DETALLE_T2'); ?></div>
			<table class="table table-striped">
			<?php
			foreach( $value['sections'] as $key=>$valor ){
			?>
				<tr>
					<td colspan="2" style="font-weight: bold;"><?php echo '<span class="titulito">'.$valor->name.'</span>'; ?></td>
				</tr>
				<tr>
					<td>
						<div><?php echo JText::_('COM_ESTADO_RESULTADOS_UNIDADES'); ?></div>
						<div><?php echo JText::_('COM_ESTADO_RESULTADOS_UNIDADES_DISPONIBLES'); ?></div>
						<div><?php echo JText::_('COM_ESTADO_RESULTADOS_UNIDADES_VENDIDAS'); ?></div>
						<div><?php echo JText::_('COM_ESTADO_RESULTADOS_UNIDADES_PRECIO'); ?></div>
					</td>
					<td class="cantidades">
						<div><?php echo $valor->total; ?></div>
						<div><?php echo $valor->units; ?></div>
						<div><?php echo $valor->unitSales; ?></div>
						<div>$<span class="number"><?php echo $valor->price; ?></span></div>
					</td>
				</tr>
			<?php
			}
			?>
			</table>
</div>
</td></tr>