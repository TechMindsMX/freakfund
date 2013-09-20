<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

if (!empty($datos)) {

$document = JFactory::getDocument();

$document->addScript('libraries/trama/js/jquery.number.min.js');
$document->addStyleSheet('modules/mod_proyectos/css/mod_proyectos.css');

$scripjs = '	jQuery(document).ready(function() {
		jQuery("span.number").number( true, 0, ",","." )
	});';
$document->addScriptDeclaration($scripjs);

	foreach ($datos as $key => $value) {
		$nombre = $value->name;
		$thumbnail = AVATAR.'/'.$value->projectAvatar->name;
		$url = 'index.php?option=com_jumi&view=appliction&fileid=11&proyid='.$value->id;
		
		$ita = isset($value->balance) ? $value->balance : null;
		$breakeven = isset($value->breakeven) ? $value->breakeven : null;
		$fechaCierre = isset($value->fundEndDate)? $value->fundEndDate : null;
		$porcentajeBE = isset($value->balancePorcentaje) ? $value->balancePorcentaje : null;
		$tri = isset($value->tri) ? $value->tri : null;
		
		switch ($params->get('tipodepro')) {
			case 'cerrar':
				$html = '<div class="mod-pro">
							<a href="'.$url.'">
							<div class="thumb-img">
								<img src="'.$thumbnail.'" alt="'.$nombre.'" />
							</div>
							<div class="descrip">
								<h2>'.$nombre.'</a></h2>
								<h4 class="porcentaje" >'.$porcentajeBE.'%
								<span class="number derecha" >'.$breakeven.'</span></h4>
								<p>'.JText::_('FECHA_CIERRE').': '.$fechaCierre.'</p>
							</div>
							<div class="clear"></div>
						</div>';
		
				echo $html;
				
				break;

			case 'apoyados':
				$html = '<div class="mod-pro">
							<a href="'.$url.'">
							<div class="thumb-img">
								<img src="'.$thumbnail.'" alt="'.$nombre.'" />
							</div>
							<div class="descrip">
								<h2>'.$nombre.'</a></h2>
								<h4><span class="number derecha" >'.$ita.'</span></h4>
							</div>
							<div class="clear"></div>
						</div>';
		
				echo $html;
				
				break;
			
			case 'rentables':
				$html = '<div class="mod-pro">
							<a href="'.$url.'">
							<div class="thumb-img">
								<img src="'.$thumbnail.'" alt="'.$nombre.'" />
							</div>
							<div class="descrip">
								<h2>'.$nombre.'</a></h2>
								<h4 class="statusbar"><div class="animacionbg" style="width: '.(100-$tri).'%;"></div></h4>
								<span>'.$tri.' %</span>
							</div>
							<div class="clear"></div>
						</div>';
		
				echo $html;
				
				break;		}
	}

}
?>

