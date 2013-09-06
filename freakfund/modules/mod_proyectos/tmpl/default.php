<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$document = JFactory::getDocument();

$document->addScript('libraries/trama/js/jquery.number.min.js');
$document->addStyleSheet('modules/mod_proyectos/css/mod_proyectos.css');

// <script type="text/javascript" src="libraries/trama/js/jquery.number.min.js"></script>

	foreach ($datos as $key => $value) {
		$nombre = $value->name;
		$thumbnail = AVATAR.'/'.$value->projectAvatar->name;
		$url = 'index.php?option=com_jumi&view=appliction&fileid=11&proyid='.$value->id;
		
		$ita = $value->balance;
		$breakeven = $value->breakeven;
		$fechaCierre = $value->fundEndDate;
		$porcentajeBE = $value->balancePorcentaje;
		
		switch ($params->get('tipodepro')) {
			case 'apoyados':
				$html = '<div class="mod-pro">
							<a href="'.$url.'">
							<img src="'.$thumbnail.'" alt="'.$nombre.'" />
							<h2>'.$nombre.'</a></h2>
							<h4><span class="number derecha" >'.$ita.'</span></h4>
							<div class="clear"></div>
						</div>';
		
				echo $html;
				
				break;
			
			default:
				$html = '<div class="mod-pro">
							<a href="'.$url.'">
							<img src="'.$thumbnail.'" alt="'.$nombre.'" />
							<h2>'.$nombre.'</a></h2>
							<h4 class="porcentaje" >'.$porcentajeBE.'%
							<span class="number derecha" >'.$breakeven.'</span></h4>
							<p>'.JText::_('FECHA_CIERRE').': '.$fechaCierre.'</p>
							<div class="clear"></div>
						</div>';
		
				echo $html;
				
				break;
		}
	}

?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('span.number').number( true, 0, ',','.' )
	});
</script>
