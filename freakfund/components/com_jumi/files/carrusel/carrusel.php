<?php
defined('_JEXEC') OR die( "Direct Access Is Not Allowed" );
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
	    jQuery('#mycarousel').jcarousel({
	        auto: 5,
	        wrap: 'last',
	        initCallback: mycarousel_initCallback
	    });
	});

</script>

<div id="wrap">
  <ul id="mycarousel" class="jcarousel-skin-tango">
    <li><img src="http://static.flickr.com/66/199481236_dc98b5abb3_s.jpg" width="125" height="125" alt="" /></li>
    <li><img src="http://static.flickr.com/75/199481072_b4a0d09597_s.jpg" width="125" height="125" alt="" /></li>
    <li><img src="http://static.flickr.com/57/199481087_33ae73a8de_s.jpg" width="125" height="125" alt="" /></li>
    <li><img src="http://static.flickr.com/77/199481108_4359e6b971_s.jpg" width="125" height="125" alt="" /></li>
    <li><img src="http://static.flickr.com/58/199481143_3c148d9dd3_s.jpg" width="125" height="125" alt="" /></li>
    <li><img src="http://static.flickr.com/72/199481203_ad4cdcf109_s.jpg" width="125" height="125" alt="" /></li>
    <li><img src="http://static.flickr.com/58/199481218_264ce20da0_s.jpg" width="125" height="125" alt="" /></li>
    <li><img src="http://static.flickr.com/69/199481255_fdfe885f87_s.jpg" width="125" height="125" alt="" /></li>
    <li><img src="http://static.flickr.com/60/199480111_87d4cb3e38_s.jpg" width="125" height="125" alt="" /></li>
    <li><img src="http://static.flickr.com/70/229228324_08223b70fa_s.jpg" width="125" height="125" alt="" /></li>
  </ul>
</div>
