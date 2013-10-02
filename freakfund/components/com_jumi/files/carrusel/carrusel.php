<?php
defined('_JEXEC') OR die( "Direct Access Is Not Allowed" );
jimport('trama.class');
$pathJumi = 'components/com_jumi/files/carrusel';

/*Cambiar el servicio en la libreria jtrama*/
$allProjects = JTrama::allProjects();

/*Quitar cuando el servicio este listo*/
$allProjects[0]->recaudado = 50000;
$allProjects[1]->recaudado = 50000;
$allProjects[2]->recaudado = 50000;
$allProjects[3]->recaudado = 50000;
$allProjects[4]->recaudado = 50000;
$allProjects[5]->recaudado = 50000;
$allProjects[6]->recaudado = 50000;
$allProjects[7]->recaudado = 50000;
$allProjects[8]->recaudado = 50000;
$allProjects[9]->recaudado = 50000;
$allProjects[10]->recaudado = 50000;
$allProjects[11]->recaudado = 50000;
/*******************************************/

function diferenciaEntreFechas($fecha_principal, $fecha_secundaria, $obtener = 'DIAS', $redondear = true){
   $f0 = strtotime($fecha_principal);
   $f1 = strtotime($fecha_secundaria);
   $resultado = ($f0 - $f1);
   switch ($obtener) {
       default: break;
       case "MINUTOS"   :   $resultado = $resultado / 60;   break;
       case "HORAS"     :   $resultado = $resultado / 60 / 60;   break;
       case "DIAS"      :   $resultado = $resultado / 60 / 60 / 24;   break;
       case "SEMANAS"   :   $resultado = $resultado / 60 / 60 / 24 / 7;   break;
   }
   if($redondear) $resultado = round($resultado);
   return $resultado;
}


?>

<link href="<?php echo $pathJumi;?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $pathJumi;?>/lib/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $pathJumi;?>/skins/tango/skin.css" />

<script type="text/javascript">

	function mycarousel_initCallback(carousel)
	{
	    // Disable autoscrolling if the user clicks the prev or next button.
	    carousel.buttonNext.bind('click', function() {
	        carousel.startAuto(0);
	    });
	
	    carousel.buttonPrev.bind('click', function() {
	        carousel.startAuto(0);
	    });
	
	    // Pause autoscrolling if the user moves with the cursor over the clip.
	    carousel.clip.hover(function() {
	        carousel.stopAuto();
	    }, function() {
	        carousel.startAuto();
	    });
	};
	
	jQuery(document).ready(function() {
	    jQuery('#mycarousel').jcarousel({
	        auto: 5,
	        wrap: 'last',
	        initCallback: mycarousel_initCallback,
	        scroll: 4
	    });
	});

</script>

<div id="wrap">
	<ul id="mycarousel" class="jcarousel-skin-tango">
  	<?php 
  		$noProyectos = count($allProjects);
  		for ($i = 0; $i < $noProyectos && $i < 12; $i++) {
			echo '<li>
    				<div class="contenedor" style="background: url(\''.AVATAR.'/'.$allProjects[$i]->projectAvatar->name.'\'); background-size: 100%;">
    					<div class="info-proyecto" >
    						<span>'.$allProjects[$i]->name.'</span><br/>
    						<span>'.JText::_('PORCENTAJE_RECAUDADO').' '.$allProjects[$i]->recaudado.'</span><br/>
   							<span>'.JText::_('PUNTO_EQUILIBRIO').' '.$allProjects[$i]->breakeven.'</span><br/>
							<span>'.JText::_('DIAS_RESTANTES').' '.diferenciaEntreFechas($allProjects[$i]->fundEndDate, date("d-m-Y")).'</span><br/>
   							<span>
   								<a class="button" href="index.php?option=com_jumi&view=appliction&fileid=11&proyid='.$allProjects[$i]->id.'">
	    							'.JText::_('INVERTIR_PROYECTO').'</a>
    						</span>
    					</div>
    				</div>
    			</li>';
		}
  	?>
  </ul>
</div>
