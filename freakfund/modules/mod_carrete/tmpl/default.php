<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$document = JFactory::getDocument();

$modPath = 'modules/mod_carrete';
$document->addStyleSheet($modPath.'/css/mod_carrete.css');

$url = 'index.php?option=com_jumi&view=appliction&fileid=11&proyid=';

?>

<link href="<?php echo $modPath;?>/css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $modPath;?>/lib/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $modPath;?>/skins/tango/skin.css" />

<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->

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
	    jQuery('#mycarousel<?php echo $module->id; ?>').jcarousel({
	        auto: 100,
	        wrap: 'last',
	        initCallback: mycarousel_initCallback,
	        scroll: 4
	    });
	});

</script>

<div id="wrap">
	<div class="vertodoscarrusel module-title">
  <h2 class="title">Ver todos &gt; </h2>
 
</div>
	<ul id="mycarousel<?php echo $module->id; ?>" class="jcarousel-skin-tango">
  	<?php
  	switch ($params->get('tipodepro')) {
		case 'cerrar':
	 		foreach ($datos as $key => $value) {
				echo '<li>
	    				<div class="contenedor productos">
	    					<div class="avatar" style="background:url(\''.AVATAR.'/'.@$value->projectAvatar->name.'\'); background-size: 100%;">
	    					</div>
	    					<div class="info-proyecto" >
								<div class="titulo">
								<a href="'.$url.@$value->id.'">
								<h2>'.@$value->name.'</h2>
								</a>
								</div>
								<div class="cat">
								<span>'.@$value->categoryName.'</span> - 
								<span>'.@$value->subcategoryName.'</span>
								</div>
								<div class="datos">
								<div class="two-cols first">
								<div class="big">'.@$value->ROI.'%</div>
								<div class="small">'.JText::_('LABEL_ROI').'</div>
								</div>
								<div class="two-cols second">
								<div class="big">'.@$value->ROF.'%</div>
								<div class="small">'.JText::_('LABEL_ROF').'</div>
								</div>
								<div class="clearfix"></div>
								</div>
								<div class="boton-wrap">
									<a class="button btn-invertir" href="'.$url.@$value->id.'">
										'.JText::_('INVERTIR_PROYECTO').'</a>
	    						</div>
	    					</div>
	    				</div>
	    			</li>';
			}
			  
			break;
		case 'apoyados':
	 		foreach ($datos as $key => $value) {
	 			$value->porcentajeRecaudado = 30;
				echo '<li>
	    				<div class="contenedor proyectos">
	    					<div class="avatar" style="background:url(\''.AVATAR.'/'.@$value->projectAvatar->name.'\'); background-size: 100%;">
		    					<span class="mask"></span>
	    					</div>
	    					<div class="info-proyecto" >
								<div class="titulo">
								<a href="'.$url.@$value->id.'">
								<h2>'.@$value->name.'</h2>
								</a>
								</div>
								<div class="cat">
								<span>'.@$value->categoryName.'</span> - 
								<span>'.@$value->subcategoryName.'</span>
								</div>
								<div class="barra" style="width: '.@$value->porcentajeRecaudado.'% "></div>
								<div class="cat texto-normal recaudado">'.JText::_('LABEL_RECAUDADO').
								'<span class="number">'.@$value->balance.'</span>
								</div>
								<div class="cat texto-normal dias-restantes">'.JText::sprintf('LAPSED_DAYS', $value->dateDiff->days).'</div>
								<div class="boton-wrap">
									<a class="button btn-invertir" href="'.$url.@$value->id.'">
										'.JText::_('INVERTIR_PROYECTO').'</a>
	    						</div>
	    					</div>
	    				</div>
	    			</li>';
			}
			break;
		  
		case 'ultimosROI':
	 		foreach ($datos as $key => $value) {
				echo '<li>
	    				<div class="contenedor">
	    					<div style="background:url(\''.AVATAR.'/'.@$value->projectAvatar->name.'\'); background-size: 100%;">
	    						<img src="'.AVATAR.'/'.@$value->projectAvatar->name.'" class="imagenes" />
	    					</div>
	    					<div class="info-proyecto" >
								<div><h3>'.@$value->name.'</h3></div>
								<span>'.JText::_('CATEGORIA').' '.@$value->categoryName.'</span> - 
								<span>'.@$value->subcategoryName.'</span><br />
								<span>'.@$value->status.'</span><br />
								<span>'.JText::_('LABEL_ROI').' '.@$value->ROI.'%</span><br />
								<span>'.JText::_('LABEL_ROF').' '.@$value->ROF.'%</span><br />
								<div class="boton-wrap">
									<a class="button btn-invertir" href="'.$url.@$value->id.'">
										'.JText::_('INVERTIR_PROYECTO').'</a>
	    						</div>
	    					</div>
	    				</div>
	    			</li>';
			}

			break;
	  } 
   	?>
  </ul>
</div>


