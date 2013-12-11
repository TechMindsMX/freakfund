<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
	
	jimport('trama.class');
	jimport('trama.usuario_class');
	jimport('trama.jsocial');
	jimport('trama.jfactoryext');
	
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

function buttons($data, $user) {
	$html = '';
	$share = '<span style="cursor: pointer;" class="shareButton">'.JText::_('SHARE_PROJECT').'</span>';
	if ( $user->id == strval($data->userId) ) {
		$link = 'index.php?option=com_jumi&view=appliction&fileid='.$data->editUrl;
		$proyid = '&proyid='.$data->id;
		if( ($data->status == 0) || ($data->status == 2)) {
			$html = '<div id="buttons">'.
					'<div class="arrecho" ><span class="editButton"><a href="'.$link.$proyid.'">'.JText::_('LBL_EDIT').'</a></span></div>'.
					'<div class="arrecho" >'.$share.'</div>'.
					'<div class="arrecho" >'.JTramaSocial::inviteToGroup($data->id).'</div></div>';
		}else{
			$html = '<div id="buttons">'.
					'<div class="arrecho" >'.JTramaSocial::inviteToGroup($data->id).'</div>'.
					'<div class="arrecho" >'.$share.'</div>'.
					'</div>';
		}
	} elseif ( $user->guest == 0 ) {
		$html = '<div id="buttons"><div class="arrecho">'.$share.'</div></div>';
	}
	return $html;
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
		$imagen = "/".$value->name;
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
	$avatar = $data->projectAvatar->name;
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

function tablaFinanzas($data) {
	$html = '<table class="table table-striped">'.
			'<tr><th>'.
			JText::_('LBL_SECCION').'</th><th>'.
			JText::_('PRECIO').'</th><th>'.
			JText::_('CANTIDAD').'</th></tr>';
	$opentag = '<td>';
	$closetag = '</td>';
	foreach ($data->projectUnitSales as $key => $value) {
		$html .= '<tr>';
		$html .= $opentag.$value->section.$closetag;
		$html .= $opentag.'<span class="number">'.$value->unitSale.'</span>'.$closetag;
		$html .= $opentag.'<span class="number">'.$value->unit.'</span>'.$closetag;
		$html .= '</tr>';
	}
	$html .= '</table>';
	
	return $html;
}

function descripcion ($data) {
	$html = '';
	
	$html = '<p id="descripcion" class="texto">'.
			$data->description.
			'</p>';
	
	return $html;
}

function irGrupo($data) {
	$html = '<a class="button" >'.JText::_('IR_GRUPO').'</a>';
	
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
	$html = '<div class="encabezado">'.
		'<h1>'.$data->name.'</h2>'.
		'<h2 class="mayusc">'.JTrama::getSubCatName($data->subcategory).'</h3>'.
		'<p id="productor">'.JTrama::getProducerProfile(UserData::getUserJoomlaId($data->userId)).'</p>'.
		'<p class="fechacreacion"> Creado '.date('d-M-Y', $fechacreacion).'</p>'.
		'<h3 class="tipo_proy_prod mayusc">'.$data->etiquetaTipo.' - '.JTrama::getStatusName($data->status).'</h3>'.
		'</div>';
	
	return $html;
}

function informacionTmpl($data, $params) {
	 $mapa= '<div id="map-wrapper" style="height: 300px; width: 120%; margin-top: 30px;"><div id="map-canvas" style="height: 100%; width:100%; margin-top:25px;"></div></div>			
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
				'<div class="gantry-width-spacer flotado">'.
		  		participar($data,$botonContactar).
				'</div>'.
				
				'<div class="gantry-width-spacer flotado">'.
				irGrupo($data).
				'</div>'.
				
				'<div class="granty-width-spacer flotando">'.
				rating($data).
				
				'</div>'.
				'<div class="granty-width-spacer flotado">'.
				$mapa.
				'</div>';
			$derecha = $data->description.
				'<br /><h3>Elenco</h3><p>'.$data->cast.'</p>';
			
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

function statusbar($data) {
// |  5 | Autorizado    |  Financiamiento
// |  6 | Produccion    |  Produccion
// |  7 | Presentacion  |  Presentacion
	$labelTopLeft = '';
	$labelBottomLeft = '';
	$labelTopRight = '';
	$labelBottomRight = '';
	$labelInside = '';
	$style = '';

	switch ($data->status) { 
		case '5':
$ahora = '1374284000000'; // (time() * 1000);
// $data->balance = 5000000000;
			$labelTopLeft = $data->fundStartDate;
			$labelTopRight = $data->fundEndDate;
			$labelBottomLeft = JText::_('RECUADADO').' = <span class="number">'.$data->balance.'</span>';
			$labelBottomRight = JText::_('PUNTO_EQUILIBRIO').' = <span class="number">'.$data->breakeven.'</span>';
			$labelInside = null;
			$data->difToday = $data->fundEndDateCode - $ahora ;
			$data->balancePorcentaje = (($data->balance * 100) / $data->breakeven);
			$data->statusbarPorcentaje = $data->balancePorcentaje;
			break;
		case '6':
$ahora =  '1394284000000'; // (time() * 1000);
			$labelTopLeft = $data->fundStartDate;
			$labelTopRight = $data->fundEndDate;
			$labelBottomLeft = JText::_('');
			$labelBottomRight = JText::_('');
			$labelInside = null;
			$difMax = $data->premiereStartDateCode - $data->productionStartDateCode;
			$difToday = $data->premiereStartDateCode - $ahora;
			$data->statusbarPorcentaje = (( $difToday * 100) / $difMax ); 
			break;
		case '7':
$ahora =  '1407918800000'; // (time() * 1000);
			$labelTopLeft = $data->fundStartDate;
			$labelTopRight = $data->fundEndDate;
			$labelBottomLeft = JText::_('');
			$labelBottomRight = JText::_('');
			$labelInside = null;
			$difMax = $data->premiereEndDateCode - $data->premiereStartDateCode;
			$difToday = $data->premiereEndDateCode - $ahora;
			$data->statusbarPorcentaje = (( $difToday * 100) / $difMax ); 
			break;
		default:
			$style = ' style="display: none" ';
	}
	if (!$style) {
	$data->animacion = 	'<script>
						setTimeout(function () {
							jQuery("#animacionbg").animate({
								width: [ "'.(100-($data->statusbarPorcentaje)).'%", "swing" ]
							}, 2000);
						}, 1000);
					</script>';
	}
	
	$tmpl = '<div id="statusbar"'.$style.'><div id="animacionbg"></div>'.
			'<span>'.$labelTopLeft.'</span><span>'.$labelBottomLeft.'</span><span>'.$labelTopRight.
			'</span><span>'.$labelBottomRight.'</span><span>'.$labelInside.'</span>'.
			'</div>';

	return $tmpl;
}

function grafico($data) {
	if ($data->status == '5' && $data->type == 'PROJECT') {
		$diasRestan = floor($data->difToday / 86400000);
		
		$tmpl = '<div><span class="number"><h3>'.JText::_('RECAUDADO').' = '.$data->balance.'</h3></span</div>'.
				'<div><h3>'.JText::_('RECAUDADO_PORCEN').' = '.round($data->balancePorcentaje, 2).'%</h3></div>'.
				'<div><h3>'.JText::_('DIAS_RESTAN').' = '.$diasRestan.'</h3></div>';
	
		return $tmpl;
	}
	if ($data->status == '5' && $data->type == 'PRODUCT') {
		$diasRestan = floor($data->difToday / 86400000);
	
		$tmpl = '<div><h3>'.JText::_('TRI').' = '.$data->tri.'</h3></div>'.
				'<div><h3>'.JText::_('TRF').' = '.$data->tri.'</h3></div>';
	
		return $tmpl;
	}
}

function botonFinanciar($data) {
	switch ($data->status) { 
		case '5':
			$string = 'LABEL_FINANCIAR';
			break;
		default:
			$string = 'INVERTIR_PROYECTO';
			break;
	}
	$url = 'index.php?option=com_jumi&view=appliction&fileid=27&proyid='.$data->id;
	$tmpl = '<div><a class="button" href="'.$url.'">'.JText::_($string).'</a></div>';
	
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
		jQuery("#rt-mainbody").css( "margin-top","<?php if( $usuario->guest == 0 ) {echo('55px');}  ?>" );
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
	<div id="wrapper">
		<div id="content">
			<?php echo buttons($json, $usuario); ?>
		</div>
				<?php echo statusbar($json); ?>
			<div id="grafico">
				<?php echo grafico($json); ?>
			</div>
			<?php echo botonFinanciar($json); ?>
			<div id="banner" class="ver_proyecto">
				<div class="info-banner">
					<div class="rt-inner">
						<?php echo encabezado($json); ?>
					</div>
				</div>
				<div class="content-banner">
					<img src="<?php echo BANNER.'/'.$json->projectBanner->name; ?>" />
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
			<a class="cerrar">cerrar</a>
			</div>
			<div id="gallery" class="ver_proyecto">
			<div id="wrapper">
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
				<a class="cerrar">cerrar</a>
			</div>
			<div id="audios" class="ver_proyecto">
				<?php
				if( ($isSpecial == 1) || ($json->acceso != null) || ($json->audioPublic == 1) || ($json->userId == $usuario->id) ){
					echo audios($json);
				}elseif( ($json->acceso == null) || ($json->audioPublic == 0) ) {
					echo JText::_('CONTENIDO_PRIVADO');
				}
				?>
				<a class="cerrar">cerrar</a>
			</div>
			<div id="finanzas" class="ver_proyecto">
				<?php
				if( ($isSpecial == 1) || ($json->acceso != null) || ($json->numberPublic == 1) || ($json->userId == $usuario->id) ){
					echo '<h1 class="mayusc">'.JText::_('LABEL_FINANZAS').'</h1>';
					echo informacionTmpl($json, "finanzas"); 
				}elseif( ($json->acceso == null) || ($json->numberPublic == 0) ) {
					echo JText::_('CONTENIDO_PRIVADO');
				}
				?>
				<a class="cerrar">cerrar</a>
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
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(19.432684,-99.133359);
  var mapOptions = {
    zoom: 14,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
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
    	jQuery('#map-canvas').append('<p>No hay dirección</p>');
    }
  });
}

    </script>
 	
				</div>
				<a class="cerrar">cerrar</a>
			</div>
		</div>
		<div id="menu">
			<div>
				<div class="menu-item video" id="video"></div>
				<div class="menu-item gallery" id="gallery"></div>
				<div class="menu-item audios" id="audios"></div>
				<div class="menu-item finanzas" id="finanzas"></div>
				<div class="menu-item info" id="info"></div>			
			</div>
			<div style="clear: both;"></div>
		</div>
	</div>
	
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
						console.log('Surguieron problemas al almacenar tu calificación');
					});
				},
				score		: rating,
				path		: ruta,
				//target		: '#texto',
				//targetText	: 'Puntuar'
			});
			
			$('.shareButton').click(function() {
				var respuesta = $.ajax({
	     			url:"libraries/trama/js/ajax.php",
	 				data: {
	  					"userId": <?php echo $usuario->id; ?>,
	  					"projectId": <?php echo $json->id; ?>,
	  					"linkProyecto": "<?php echo JURI::base().'index.php?option=com_jumi&view=appliction&fileid=11&proyid='.$json->id; ?>",
	  					"nomUser": "<?php echo userName($usuario->id); ?>",
	  		  			"nomProyecto": "<?php echo $json->name;?>",		
	  					"fun": 3
	 				},
	 				type: 'post'
				});

				respuesta.done(function(result){
					var objShare = eval('('+result+')');

					if (!objShare.shared) {
						$('.shareButton').parent().append('<span>Proyecto Compartido</span>');
						$('.shareButton').remove();
					} else {
						alert(objShare.name+' ya habias compartido esto antes');
					}
				});
			});
			
			
			jQuery('span.number').number( true, 0, ',','.' )

		});
		
	    $(window).load(function() {
        	$('#slider').nivoSlider();
		});
    </script>


<?php
if (isset($json->animacion)) {
	echo $json->animacion;
}
//var_dump($json);
 ?>
