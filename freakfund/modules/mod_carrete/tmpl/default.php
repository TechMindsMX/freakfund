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
	<ul id="mycarousel<?php echo $module->id; ?>" class="jcarousel-skin-tango">
  	<?php
  	switch ($params->get('tipodepro')) {
		case 'cerrar':
	 		foreach ($datos as $key => $value) {
				echo '<li>
	    				<div class="contenedor">
	    					<div style="background:url(\''.AVATAR.'/'.$value->projectAvatar->name.'\'); background-size: 100%;">
	    						<img src="'.AVATAR.'/'.$value->projectAvatar->name.'" class="imagenes" />
	    					</div>
	    					<div class="info-proyecto" >
								<div><h3>'.$value->name.'</h3></div>
								<span>'.JText::_('CATEGORIA').' '.$value->categoryName.'</span> - 
								<span>'.$value->subcategoryName.'</span><br />
								<span>'.$value->status.'</span><br />
								<span>'.JText::_('LABEL_RECAUDADO').' '.$value->balance.'</span><br />
								<span>'.JText::sprintf('LAPSED_DAYS', $value->dateDiff->days).'</span><br />
								<div class="boton-wrap">
									<a class="button btn-invertir" href="'.$url.$value->id.'">
										'.JText::_('INVERTIR_PROYECTO').'</a>
	    						</div>
	    					</div>
	    				</div>
	    			</li>';
			}
			break;
		  
		case 'apoyados':
	 		foreach ($datos as $key => $value) {
				echo '<li>
	    				<div class="contenedor">
	    					<div style="background:url(\''.AVATAR.'/'.$value->projectAvatar->name.'\'); background-size: 100%;">
	    						<img src="'.AVATAR.'/'.$value->projectAvatar->name.'" class="imagenes" />
	    					</div>
	    					<div class="info-proyecto" >
								<div><h3>'.$value->name.'</h3></div>
								<span>'.JText::_('CATEGORIA').' '.$value->categoryName.'</span> - 
								<span>'.$value->subcategoryName.'</span><br />
								<span>'.$value->status.'</span><br />
								<span>'.JText::_('LABEL_ROI').' '.$value->ROI.'%</span><br />
								<span>'.JText::_('LABEL_ROF').' '.$value->ROF.'%</span><br />
								<div class="boton-wrap">
									<a class="button btn-invertir" href="'.$url.$value->id.'">
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
	    					<div style="background:url(\''.AVATAR.'/'.$value->projectAvatar->name.'\'); background-size: 100%;">
	    						<img src="'.AVATAR.'/'.$value->projectAvatar->name.'" class="imagenes" />
	    					</div>
	    					<div class="info-proyecto" >
								<div><h3>'.$value->name.'</h3></div>
								<span>'.JText::_('CATEGORIA').' '.$value->categoryName.'</span> - 
								<span>'.$value->subcategoryName.'</span><br />
								<span>'.$value->status.'</span><br />
								<span>'.JText::_('LABEL_ROI').' '.$value->ROI.'%</span><br />
								<span>'.JText::_('LABEL_ROF').' '.$value->ROF.'%</span><br />
								<div class="boton-wrap">
									<a class="button btn-invertir" href="'.$url.$value->id.'">
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


