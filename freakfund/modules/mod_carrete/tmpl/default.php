<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$document = JFactory::getDocument();

$document->addStyleSheet('modules/mod_carrete/css/mod_carrete.css');

$pathJumi = 'components/com_jumi/files/carrusel';

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
	    jQuery('#mycarousel2').jcarousel({
	        auto: 10,
	        wrap: 'last',
	        initCallback: mycarousel_initCallback,
	        scroll: 4
	    });
	});

</script>

<div id="wrap">
	<ul id="mycarousel2" class="jcarousel-skin-tango">
  	<?php 
  		foreach ($datos as $key => $value) {
			echo '<li>
    				<div class="contenedor" style="background:url(\''.AVATAR.'/'.$value->projectAvatar->name.'\'); background-size: 100%;">
    					<div class="info-proyecto" >
    						<div><h3>'.$value->name.'</h3></div>
    						<span>'.JText::_('CATEGORIA').' '.$value->categoryName.'</span> - 
   							<span>'.$value->subcategoryName.'</span><br />
							<span>'.JText::_('LABEL_ROI').' '.$value->ROI.'%</span><br />
							<span>'.JText::_('LABEL_ROF').' '.$value->ROF.'%</span><br />
   							<span>
   								<a class="button" href="index.php?option=com_jumi&view=appliction&fileid=11&proyid='.$value->id.'">
	    							'.JText::_('INVERTIR_PROYECTO').'</a>
    						</span>
    					</div>
    				</div>
    			</li>';
		}
  	?>
  </ul>
</div>


