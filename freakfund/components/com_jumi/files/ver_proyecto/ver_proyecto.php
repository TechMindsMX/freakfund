<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	
	jimport('trama.class');
	jimport('trama.usuario_class');
	jimport('trama.jsocial');
	jimport('trama.jfactoryext');
	JHTML::_('behavior.tooltip');
	
	$usuario =& JFactory::getUser();
	$usuario->idMiddleware = ( $usuario->id != 0 ) ? UserData::getUserMiddlewareId($usuario->id)->idMiddleware : null;

	$app = JFactory::getApplication();
	$jinput = $app->input;

	// chequeamos si el usuario es Special
	$isSpecial = '';
	$grupos = new JFactoryExtended;
	foreach ($usuario->getAuthorisedViewLevels() as $key => $value) {
		$isSpecial = ($value == $grupos->getSpecialViewlevel()) ? 1 : 0;
	}
	
	$pathJumi = Juri::base().'components/com_jumi/files/ver_proyecto/';
	$proyecto = $jinput->get('proyid', '', 'INT');
	
	$document->addStyleSheet($pathJumi.'css/themes/bar/bar.css');
	
	$document->addStyleSheet($pathJumi.'css/nivo-slider.css');
	$document->addStyleSheet($pathJumi.'css/style.css');

	$token = JTrama::token();
?> 

<script type="text/javascript" src="components/com_jumi/files/ver_proyecto/js/jquery.nivo.slider.js"></script>
<script type="text/javascript" src="libraries/trama/js/raty/jquery.raty.js"></script>
<script type="text/javascript" src="libraries/trama/js/jquery.number.min.js"></script>

<?php
$json = JTrama::getDatos($proyecto);
$json->etiquetaTipo = tipoProyProd($json);
$json->acceso = JTramaSocial::checkUserGroup($proyecto, $usuario->id);

if($json->name) {
	$mydoc =& JFactory::getDocument();
	$mydoc->setTitle($json->name);
}

function tipoProyProd($data) {
	$tipo = $data->type;
	switch ($tipo) {
		case 'PRODUCT':
			$tipoEtiqueta = JText::_('PRODUCT');
			$data->editUrl = '12';
			break;
		case 'REPERTORY':
			$tipoEtiqueta = JText::_('REPERTORIO');
			$data->editUrl = '14';
			break;
		default:
			$tipoEtiqueta = JText::_('PROJECT');
			$data->editUrl = '9';
			break;
	}
	return $tipoEtiqueta;
}

function videos($obj, $param) {
	$html = '';
	
	$array = $obj->projectVideos;
	foreach ($array as $key => $value ) {
		if (strstr($value->url, 'youtube')) {
			$arrayLimpio[] = array('youtube' => end(explode("=", $value->url)));
		}
		if (strstr($value->url, 'youtu.be')) {
			$urlcorta = end(explode(".be/", $value->url));
			$urlcorta = explode("?", $urlcorta);
			$arrayLimpio[] = array('youtube' => $urlcorta[0]);
		}
		elseif (strstr($value->url, 'vimeo')) {
			$arrayLimpio[] = array('vimeo' => end(explode("://vimeo.com/", $value->url)));
		}
	}

	switch ($param) {
	case 1:
		$video1 = $arrayLimpio[0];
		if (key($video1) == 'youtube') {
			$html .= '<iframe class="video-player" width="100%" '.
					'src="//www.youtube.com/embed/'.$video1['youtube'].
					'?rel=0" frameborder="0" allowfullscreen></iframe>';
		}
		elseif (key($video1) == 'vimeo') {
			$html .= '<iframe class="video-player" width="100%" '.
				'src="http://player.vimeo.com/video/'.$video1['vimeo'].'?autoplay=0" '.
				'frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
		}
	break;
	default:
		foreach ( $arrayLimpio as $llave => $valor ) {
			foreach ($valor as $key => $value) {
				if ($key == 'youtube') {
					$html .= '<div class="item-video"><input class="liga" type="button"'.
						'value="//www.youtube.com/embed/'.$value.'?rel=0&autoplay=1"'.
						'style="background: url(\'http://img.youtube.com/vi/'.$value.'/0.jpg\')'.
						' no-repeat; background-size: 100%;" /></div>';
				}
				elseif ($key == 'vimeo') {
					$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$value.php"));
					$thumbVimeo = $hash[0]['thumbnail_medium']; 
					
					$html .= '<div class="item-video"><input class="liga" type="button"'.
						'value="//player.vimeo.com/video/'.$value.'?autoplay=1"'.
						'style="background: url('.$thumbVimeo.')'.
						' no-repeat; background-size: 100%;" /></div>';
				}
			}
		}
	break;
	}

	return $html;
}

function imagenes($data) {
	$html = '';
	
	$array = $data->projectPhotos;
	foreach ( $array as $key => $value ) {
		$imagen = "/".$value->url;
		$html .= '<img width="100" height="100" src="'.PHOTO.$imagen.'" alt="" />';	
	}

	return $html;
}

function audios($data) {
	$hostname = parse_url(JURI::base(), PHP_URL_HOST);
	$localDomain = ( $hostname == 'localhost' || is_numeric(strpos($hostname, '192')) );

	$html = '';
	$array = $data->projectSoundclouds;
	
	if (!empty($array) && $localDomain === false ) {
	
		require_once 'Services/Soundcloud.php';
			
		// create a client object with your app credentials
		$client = new Services_Soundcloud(SOUNDCLOUD_CLIENT_ID, SOUNDCLOUD_CLIENT_SECRET);
		$client->setCurlOptions(array(CURLOPT_FOLLOWLOCATION => 1));
		
		foreach ($array as $key => $value) {
			if (!empty($value->url)) {
			// get a tracks oembed data
		//	$track_url = str_replace('https', 'http', $value->url);
			$track_url = $value->url;
			$embed_info = json_decode($client->get('resolve', array('url' => $track_url)));
			// render the html for the player widget
			
			$html .= '<iframe width="100%" height="100" scrolling="no" frameborder="no" src="'.
			'https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Ftracks%2F'.$embed_info->id.'"></iframe>';
			}
		}
	} else {
		$html = ($localDomain === false) ? JText::_('NO_HAY_AUDIOS') : JText::_('SOLO_EN_DOMINIO');
	}
	return $html;
}

function avatar($data) {
	$avatar = $data->avatar;
	$html = '<img class="avatar" src="'.AVATAR.'/'.$avatar.'" />';
	
	return $html;
}

function finanzas ($data) {
	$html = '';
	
	$html = '<ul id="finanzas_general">'.
			'<li><span>'.JText::_('BUDGET').'</span> <span class="number">'.$data->budget.'</span></li>'.
			'<li><span>'.JText::_('BREAKEVEN').'</span> <span class="number">'.$data->breakeven.'</span></li>'.
			'<li><span>'.JText::_('REVE_POTENTIAL').'</span> <span class="number">'.$data->revenuePotential.'</span></li>'.
			'</ul>';
	return $html;
}

function descripcion ($data) {
	$html = '';
	
	$html = '<p id="descripcion" class="texto">'.
			$data->description.
			'</p>';
	
	return $html;
}

function rating($data) {
		
	if($data->rating == 'NaN') {
		$rating = 0;
	} else {
		$rating = $data->rating;
	}
	
	$html = '<div id="rating" style="float: left; margin-top: 8px; margin-left: 26px; width: 100px;"></div>'.
			'<div id="texto"style="float: left; font-size: 50px; position: relative; text-align: center; width: 30%; margin-left: 15px; top: 15px;">'.
			number_format($rating, 1).
			'</div>';
	
	return $html;
}

function encabezado($data) {
	$fechacreacion = $data->timeCreated/1000;
	$statusName = JTrama::getStatusName($data->status);
	$html = '<div class="encabezado">'.
		'<h1>'.$data->name.'</h2>'.
		'<h2 class="mayusc">'.JTrama::getSubCatName($data->subcategory).'</h3>'.
		'<p id="productor">'.JTrama::getProducerProfile(UserData::getUserJoomlaId($data->userId)).'</p>'.
		'<p class="fechacreacion"> Creado '.date('d-M-Y', $fechacreacion).'</p>'.
		'<h3 class="tipo_proy_prod mayusc">'.$data->etiquetaTipo.' - '.JHTML::tooltip($statusName->tooltipText,$statusName->tooltipTitle,'',$statusName->fullName).'</h3>'.
		'</div>';
	
	return $html;
}

function informacionTmpl($data, $params) {
	 $mapa= '<div id="map-wrapper" style="margin-top: 30px;"><div id="map-canvas" style="height: 100%; width:100%; margin-top:25px;"></div></div>			
  	 <p style="max-width:300px;">'.$data->showground.'</p>';
	 $botonContactar= JText::_('SOLICITA_PARTICIPAR');
 	require_once 'solicitud_participar.php';
 	
	switch ($params) {
		case 'finanzas':
			$izquierda = avatar($data).
				'<div class="gantry-width-spacer flotado">'.
		  		participar($data,$botonContactar).
				'</div>'.
				'<div class="gantry-width-spacer flotado">'.
				irGrupo($data).
				'</div>';
			$derecha = finanzas($data).
						tablaFinanzas($data).
						fechas($data);
			break;
		
		default:
			$izquierda = avatar($data).
				'<div class="granty-width-spacer flotando">'.
				rating($data).
				
				'</div>'.
				'<div class="granty-width-spacer flotado">'.
				$mapa.
				'</div>';
			$derecha = $data->description.
				'<br /><h3>'.JText::_("LBL_ELENCO").'</h3><p>'.$data->cast.'</p>';
			
			break;
	}

	$html = '<div id="izquierdaDesc" class="ancho-col gantry-width-block">'.
			'<div>'.
			$izquierda.
			'</div>'.
			'</div>'.
			'<div id="derechaDesc" class="ancho-col gantry-width-block">'.
			'<div>'.
			encabezado($data).
			'</div>'.
			'<div id="contenido-detalle">'.
			$derecha.
			'</div>'.
			
			'</div>';
	
	return $html;
}

function fechas($data) {
	$html = '<ul id="fechas">';
	if ($data->type == 'PROJECT') {
			$html .= '<li><span>'.JText::_($data->type.'_FUND_START').'</span>'.$data->fundStartDate.'</li>'.
					'<li><span>'.JText::_($data->type.'_FUND_END').'</span>'.$data->fundEndDate.'</li>'.
					'<li><span>'.JText::_($data->type.'_PRODUCTION_START').'</span>'.$data->productionStartDate.'</li>';
	}
	$html .= '<li><span>'.JText::_($data->type.'_PREMIERE_START').'</span>'.$data->premiereStartDate.'</li>'.
			'<li><span>'.JText::_($data->type.'_PREMIERE_END').'</span>'.$data->premiereEndDate.'</li>'.
			'</ul>';

	return $html;
}

function userName($data) {
	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);
	
	$query
		->select('nomNombre,nomApellidoPaterno')
		->from('perfil_persona')
		->where('users_id = '.$data.' && perfil_tipoContacto_idtipoContacto = 1');
	
	$db->setQuery( $query );
	
	$resultado = $db->loadObject();
	if (!is_null($resultado)) {
		$result = $resultado->nomNombre.' '.$resultado->nomApellidoPaterno;
	}
		$result = JFactory::getUser($data)->name;
	
	return $result;
}

function proInfo($data) {
// |  5 | Autorizado    |  Financiamiento
// |  6 | Produccion    |  Produccion
// |  7 | Presentacion  |  Presentacion
	$style = '';

	switch ($data->status) { 
		case '5':
			$data->dateDiff = JTrama::dateDiff($data->fundEndDate);
			$data->balancePorcentaje = (($data->balance * 100) / $data->breakeven);
			$data->statusbarPorcentaje = $data->balancePorcentaje;

			$statusInfo1 = '<span class="bloque"><div class="margen"><div>'.JText::_('LABEL_RECAUDADO').'</div>
							<h1 class="naranja">$ <span class="number">'.$data->balance.'</span></h1></div></span>';
			$statusInfo2 = '<span class="bloque"><div class="margen"><div>'.JText::_('PUNTO_EQUILIBRIO').'</div>
							<h1 class="naranja">$ <span class="number">'.$data->breakeven.'</span></h1></div></span>';
			$statusInfo3 = '<span class="bloque"><div class="margen"><div>'.JText::_('DIAS_RESTANTES').'</div>
							<h1 class="naranja"><span>'.$data->dateDiff->days.'</span></h1></div></span>';
			$statusInfo4 = '<span class="bloque"><div class="margen"><div>'.botonFinanciar($data).'</div>
							</div></span>';
							
			break;
		case '6' OR '7' OR '10':
			$data->balancePorcentaje = (($data->balance / $data->revenuePotential)*100);
			$data->statusbarPorcentaje = ((($data->balance - $data->breakeven) * 100) / ($data->revenuePotential - $data->breakeven));
			$data->finanPorcentaje = (($data->breakeven / $data->revenuePotential)*100);
			$data->finanPorcentaje2 = $data->finanPorcentaje + 0.1;
			
			$data->trfFormateado = ($data->trfFormateado != null || $data->trfFormateado != 0) ? $data->trfFormateado.' %' : '0%';
			$data->triFormateado = ($data->triFormateado != null || $data->triFormateado != 0) ? $data->triFormateado.' %' : '0%';

			$statusInfo1 = '<span class="bloque" style="border: 0;"></span>';
			$statusInfo2 = '<span class="bloque"><div class="margen"><div>'.JText::_('ROI_FIN').'</div>
							<h1 class="naranja"><span>'.$data->trfFormateado.'</span></h1></div></span>';
			$statusInfo3 = '<span class="bloque"><div class="margen"><div>'.JText::_('ROI_INV').'</div>
							<h1 class="naranja"><span>'.$data->triFormateado.'</span></h1></div></span>';
			$statusInfo4 = '<span class="bloque"><div class="margen"><div>'.botonFinanciar($data).'</div>
							</div></span>';

			break;
	}
	$tmpl = '<div id="proInfo">
			<span class="bloque">
			<h1>'.$data->name.'</h1>
			<h3 class="mayusc">'.JTrama::getSubCatName($data->subcategory).'</h3>
			<p id="productor">'.JTrama::getProducerProfile(UserData::getUserJoomlaId($data->userId)).'</p>
			</span>
			'.$statusInfo1.$statusInfo2.$statusInfo3.$statusInfo4.'
			</div>';
			
			return $tmpl;
}

function statusbar($data) {
	$data->animacion = 	'<script>
						setTimeout(function () {
							jQuery("#statusbar").animate({
								width: [ "'.(($data->balancePorcentaje)).'%", "swing" ]
							}, 2000, function() {
								var status = '.$data->status.'; 
								if (status != 5){
									jQuery("#statusbar").append("<div class=\"recaudado\">$ '.number_format($data->balance,0).'</div>");
								}
								if (status == 5){
									jQuery("#statusbar").append("<div class=\"recaudado\">'.number_format($data->statusbarPorcentaje,2).' %</div>");
								}
							});
						}, 3000);
					</script>';
	
	switch ($data->status) { 
		case '5':
			$tmpl = '<div id="animacionbg">
						<div id="statusbar"></div>
					</div>';
			break;
		case '6' OR '7' OR '10':
			$tmpl = '<div style="position:relative; height: 2em;">
						<span class="statusbarFecha" style="left: 0%;">'.$data->fundStartDate.'</span>
						<span class="statusbarFecha" style="left: '.($data->finanPorcentaje-3).'%;">'.$data->fundEndDate.'</span>
						<span class="statusbarFecha" style="right: 0%;">'.$data->premiereEndDate.'</span>
					</div>
				<div id="animacionbg">
					<span style="left: '.(($data->finanPorcentaje/2)-3).'%;">'.JText::_("STATEMENT_FUNDING").'</span>
					<span style="left: '.((((100-$data->finanPorcentaje)/2)+$data->finanPorcentaje)-3).'%;">'.JText::_("STATEMENT_INVESTMENT").'</span>
					<div id="statusbar" style="background: linear-gradient(to right, 
											#73cee4 0%,
											#73cee4 '.(($data->breakeven / $data->balance)*100).'%,
											#9CF '.((($data->breakeven / $data->balance)*100)).'%, 
											#9CF 100%);">
					</div>
					<span id="markBE" style="left:'.$data->finanPorcentaje.'%;"></span>
				</div>'
					;
			break;
	}

	return $tmpl;
}

function botonFinanciar($data) {
	$url = 'index.php?option=com_jumi&view=appliction&fileid=27&proyid='.$data->id;
	$disable = '';
	switch ($data->status) { 
		case 5:
			$string = 'LABEL_FINANCIAR';
			break;
		case '6' OR '7' OR '10':
			$string = 'INVERTIR_PROYECTO';
			break;
		default:
			$string = 'INVERTIR_PROYECTO';
			$disable = 'class="disabled"';
			$url = '';
			break;
	}
	$tmpl = '<div '.$disable.' ><a class="button btn-invertir" href="'.$url.'">'.JText::_($string).'</a></div>';
	
	return $tmpl;
	
}

?>
	<script type="text/javascript">
	function scrollwrapper(){
		jQuery(window).scrollTop(jQuery('div#wrapper').offset().top);
	}

	jQuery(document).ready(function(){
		
		scrollwrapper();
		jQuery(".ver_proyecto").hide();
		jQuery("#banner").show();

		jQuery(".menu-item").hover(
			function(){
				jQuery(this).addClass("over");
			},
			function(){
				jQuery(this).removeClass("over");
			}
		);
		jQuery(".menu-item").click(function(){
			jQuery(".menu-item").removeClass("active");
			var clase = jQuery(this).attr("id");
			jQuery(".ver_proyecto").hide('slow');
			jQuery("#"+clase).show("slow", function() {
				scrollwrapper();
				initialize();
			});
			jQuery(this).addClass("active");
		});

		jQuery(".cerrar").click(function(){
			jQuery(".menu-item").removeClass("active");
			jQuery(".ver_proyecto").hide();
			jQuery("#banner").show("slow", function() {
				scrollwrapper();
			});
		});	

		jQuery(".liga").click(function(){
			var liga = jQuery(this).val();
			jQuery(".video-player").attr("src",liga);
		});
		
	});
	</script>
<div class="clearfix">
	<div id="wrapper">
		<div id="content">
			<div id="banner" class="ver_proyecto">
				<div class="content-banner">
					<img src="<?php echo BANNER.'/'.$json->banner; ?>" />
				</div>
			</div>
			<div id="video" class="ver_proyecto">
				<div id="content_player">
				<?php
				if( ($isSpecial == 1) || ($json->acceso != null) || ($json->videoPublic == 1) || ($json->userId == $usuario->id) ){
				?>
					<div id="video-player">
						<div id="menu-player">
							<?php echo videos($json, 0); ?>
						</div>
						<div id="reproductor">
							<?php echo videos($json, 1); ?>
						</div>
					</div>
				<?php
				}elseif( ($json->acceso == null) || ($json->videoPublic == 0) ) {
					echo JText::_('CONTENIDO_PRIVADO');
				}
				?>
				</div>
			<a class="cerrar">X</a>
			</div>
			<div id="gallery" class="ver_proyecto">
			<div>
				<?php
				if( ($isSpecial == 1) || ($json->acceso != null) || ($json->imagePublic == 1) || ($json->userId == $usuario->id) ){
				?>
				<div class="slider-wrapper theme-bar">
            		<div id="slider" class="nivoSlider">
            			<?php echo imagenes($json); ?>
            		</div>
        		</div>
        		<?php
				}elseif( ($json->acceso == null) || ($json->imagePublic == 0) ) {
					echo JText::_('CONTENIDO_PRIVADO');
				}
				?>
        	</div>
				<a class="cerrar">X</a>
			</div>
			<div id="audios" class="ver_proyecto">
				<?php
				if( ($isSpecial == 1) || ($json->acceso != null) || ($json->audioPublic == 1) || ($json->userId == $usuario->id) ){
					echo audios($json);
				}elseif( ($json->acceso == null) || ($json->audioPublic == 0) ) {
					echo JText::_('CONTENIDO_PRIVADO');
				}
				?>
				<a class="cerrar">X</a>
			</div>
			
			<div id="info" class="ver_proyecto">
				<?php
				if( ($isSpecial == 1) || ($json->acceso != null) || ($json->infoPublic == 1) || ($json->userId == $usuario->id) ){
					echo '<h1 class="mayusc">'.JText::_('LABEL_INFO').'</h1>';
				?>
				
				<div class="detalleDescripcion">
					<?php 
						echo informacionTmpl($json, null);
					}elseif( ($json->acceso == null) || ($json->infoPublic == 0) ) {
						echo JText::_('CONTENIDO_PRIVADO');
					} ?>
					
			    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
			
			    <script>
					var geocoder;
					var map;
					function initialize() {
						var useragent = navigator.userAgent;
						var mapdiv = document.getElementById("map-canvas");
						
						if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
							mapdiv.style.width = '100%';
							mapdiv.style.height = '100%';
							variables = {zoom: 14, center: latlng, disableDefaultUI: true, draggable: false, disableDoubleClickZoom: false, zoomControl: true, mapTypeId: google.maps.MapTypeId.ROADMAP};
							console.log(mapdiv.style.width);
						} else {
						    mapdiv.style.width = '372px';
						    mapdiv.style.height = '300px';
						    variables = {zoom: 14, center: latlng, disableDefaultUI: false, mapTypeId: google.maps.MapTypeId.ROADMAP};
						}
						
						geocoder = new google.maps.Geocoder();
						var latlng = new google.maps.LatLng(19.432684,-99.133359);
						var mapOptions = variables;
						map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
						codeAddress();
					}
					
					function codeAddress() {
					  var address = '<?php echo $json->showground; ?>';
					  geocoder.geocode( { 'address': address}, function(results, status) {
					    if (status == google.maps.GeocoderStatus.OK) {
					      map.setCenter(results[0].geometry.location);
					      var marker = new google.maps.Marker({
					          map: map,
					          position: results[0].geometry.location
					     });
					    } else {
					    	map.setCenter(latlng);
					    	jQuery('#map-canvas').append('<p><?php echo JText::_('NO_ADDRESS'); ?></p>');
					    }
					  });
					}
			
			    </script>
 	
				</div>
				<a class="cerrar">X</a>
			</div>
		</div>
			<div class="clearfix"></div>
		</div>
		<div id="menu">
			<div>
				<div class="menu-item video" id="video"></div>
				<div class="menu-item gallery" id="gallery"></div>
				<div class="menu-item audios" id="audios"></div>
				<div class="menu-item info" id="info"></div>
			</div>
		</div>
		<div class="clearfix"></div>
		<?php echo proInfo($json); ?>
		<?php echo statusbar($json); ?>
	</div>
</div>
	
<?php if (!is_null($usuario->idMiddleware)) {
?>
	<script type="text/javascript">
	 var count = 0;
	 
	 if(isNaN(<?php echo $json->rating; ?>)){
	 	var rating = 0;
	 } else {
	 	var rating = parseFloat(<?php echo $json->rating; ?>);
	 }
	 
		$(document).ready(function() {
			var ruta = "libraries/trama/js/raty/img/"
			$('#rating').raty({
				click: function(score, evt) {
					var request = $.ajax({
						url:"<?php echo MIDDLE.PUERTO;?>/trama-middleware/rest/project/rate",
						data: {
							"score": score,
							"projectId": "<?php echo $proyecto ?>",
							"token": "<?php echo $token; ?>",
							"userId": <?php echo $usuario->idMiddleware; ?>
						},
						type: 'post'
					});
					
					request.done(function(result){
						var obj = eval('(' + result + ')');
												
						if (obj.resultType == 'SUCCESS') {
							jQuery('#rating').raty({
								readOnly: true,
								path 	: ruta,
								score 	: score,
								target		: '#texto',
								targetText	: obj.rate
							});
						} else if(obj.resultType == 'FAIL') {
							jQuery('#rating').raty({
								readOnly: true,
								path 	: ruta,
								score 	: obj.rate,
								target		: '#texto',
								targetText	: obj.rate
							});
						}
					});
					
					request.fail(function (jqXHR, textStatus) {
						alert('<?php echo JText::_("RATING_ERROR"); ?>');
					});
				},
				score		: rating,
				path		: ruta,
			});
			
		});
	</script>
<?php }
?>
	<script>	
	    $(window).load(function() {
        	$('#slider').nivoSlider({
        		prevText: '<?php echo JText::_("LBL_PREV"); ?>',
    			nextText: '<?php echo JText::_("LBL_NEXT"); ?>'
        	});
		});
    </script>


<?php
if (isset($json->animacion)) {
	echo $json->animacion;
}
 ?>
