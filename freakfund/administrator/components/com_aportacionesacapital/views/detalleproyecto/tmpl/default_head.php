<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$datos = $this->items;

?>
<tr>
	<th>
		<h2><?php echo strtoupper($this->items->name); ?></h2>
	</th>
</tr>
<tr>
	<th>
		<div class="datosProy">
			<div>
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_FUNDENDDATE'); ?>:</span></div>
				<div class="textos derecha"><?php echo $datos->fundEndDate; ?></div>
			</div>
			<div>
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_LISTADOPROYECTOS_HEADING_BREAKEVEN'); ?>:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->breakeven; ?></span></div>
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_FALTANTE'); ?>:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->balanceToBE; ?></span></div>
			</div>
			
			<div>
				<div class="textos"><span class="labels"><?php echo JText::_('COM_APORTACIONESCAPITAL_DETALLEPROYECTO_RECAUDADO'); ?>:</span></div>
				<div class="textos derecha">$<span class="number"><?php echo $datos->balance; ?></span></div>
			</div>
			
		</div>
	</th>
</tr>