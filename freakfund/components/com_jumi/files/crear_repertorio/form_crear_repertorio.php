<link href="/maps/documentation/javascript/examples/default.css" rel="stylesheet">
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
<?php 

defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
$usuario = JFactory::getUser();
$app = JFactory::getApplication();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url    = 'index.php?option=com_users&view=login';
	$url   .= '&return='.base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}
jimport('trama.class');
require_once 'components/com_jumi/files/crear_proyecto/classIncludes/libreriasPP.php';

$categoria = JTrama::getAllCatsPadre();
$subCategorias = JTrama::getAllSubCats();

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token = JTrama::token();
$objDatosRepertorio = JTrama::getDatos( (!empty($_GET['proyid']))?$_GET['proyid']:null);

//definicion de campos del formulario
$action = MIDDLE.PUERTO.'/trama-middleware/rest/project/create';
$hiddenphotosIds = '<input type="hidden" name="projectPhotosIds" id="projectPhotosIds" value= ""/>';
$validacion = 'validate[required]';
$countunitSales = 1;
$countImgs = 10;
$limiteVideos = 5;
$limiteSound = 5;
$hiddenIdRepertorio = '';
$agregarCampos = '';
$categoriaSelected = '';
$subcategoriaSelected = '';
$banner = '';
$avatar = '';
$opcionesSubCat = '';
$ligasVideos = '';
$ligasAudios = '';
//termina la definicion de campos del formularios

if ( isset ($objDatosRepertorio) ) {
	
	if($objDatosRepertorio->userId == $usuario->id) {
		$hiddenIdRepertorio = '<input type="hidden" value="'.$objDatosRepertorio->id.'" name="id" />';
		$hiddenphotosIds = '<input type="hidden"  name="projectPhotosIds" id="projectPhotosIds" />';
		
		$avatar = '<img src="'.MIDDLE.AVATAR.'/'.$objDatosRepertorio->projectAvatar->name.'" width="100" />';
		$banner = '<img src="'.MIDDLE.BANNER.'/'.$objDatosRepertorio->projectBanner->name.'" width="100" />';
		
		$ligasVideos = $objDatosRepertorio->projectVideos;
		$ligasAudios = $objDatosRepertorio->projectSoundclouds;
		
		$validacion = '';
		$validacionImgs = '';
		
		$countImgs = $countImgs - count($objDatosRepertorio->projectPhotos);
		
		$subcategoriaSelected = $objDatosRepertorio->subcategory;
		
		foreach ($subCategorias as $key => $value) {
			if( $value->id == $objDatosRepertorio->subcategory ) {
				$categoriaSelected = $value->father;
			}
		}
	} else {
		$mensaje = 'No es propietario del Repertorio';
		
		$allDone =& JFactory::getApplication();
		$allDone->redirect('index.php', $mensaje );
	}
}
?>

<script>
	jQuery(document).ready(function(){
		jQuery('#description').addClass('validate[required,custom[tiny]]');
		jQuery("#tinymce").addClass( "validate[required]");
		jQuery("#form2").validationEngine();

		jQuery("#enviar").click(function (){
			var form = jQuery("#form2")[0];
			var total = form.length;
			
			var section = new Array();
			var unitSale = new Array();
			var capacity = new Array();
			var sec = 0;
			var unit = 0;
			var cap = 0;
			
			for (i=0; i < total; i++) {
			    seccion = form[i].name.substring(0,7);
			    capayuni = form[i].name.substring(0,8);
			    if(seccion == 'section') {
			        section[sec] = form[i].value;
			        sec++;
			    }else if(capayuni == 'unitSale'){
			        unitSale[unit] = form[i].value;
			        unit++
			    }else if(capayuni == 'capacity'){
			        capacity[cap] = form[i].value;
			        cap++;
			    }
			}
			
			jQuery("#seccion").removeClass("validate[required,custom[onlyLetterNumber]]");
			jQuery("#unidad").removeClass("validate[required,custom[onlyNumberSp]]");
			jQuery("#inventario").removeClass("validate[required,custom[onlyNumberSp]]");
			
			console.log(section.join(","));
			console.log(unitSale.join(","));
			console.log(capacity.join(","));
			
			jQuery("#seccion").val(section.join(","));
			jQuery("#unidad").val(unitSale.join(","));
			jQuery("#inventario").val(capacity.join(","));

			emptyKeys();

			jQuery('#token').val('<?php echo $token;?>');
			
			jQuery("#form2").submit();
		});
	});

	
</script>
<h3><?php echo JText::_('CREAR').JText::_('REPERTORIO');  ?></h3>

<form id="form2" action="<?php echo $action; ?>" enctype="multipart/form-data" method="POST">
	<?php 
		echo $hiddenIdRepertorio;
		echo $hiddenphotosIds; 
	?>
	<input
		type="hidden"
		id="status"
		value="0"
		name="status" />
		
	<input 
		type="hidden"
		id="type"
		value="REPERTORY"
		name="type" />
		
	<input
		type="hidden"
		value=""
		name="token"
		id="token" />
		
	<input 
		type="hidden"
		value="<?php echo $usuario->id; ?>"
		name="userId" />
		
	<input 
		type="hidden" 
		name="videoPublic" 
		value="1" 
		id="videoPublic" 
		checked="checked" />
	<input 
		type="hidden" 
		name="audioPublic" 
		value="1" 
		id="audioPublic" 
		checked="checked" />
	<input 
		type="hidden" 
		name="imagePublic" 
		value="1" 
		id="imagePublic" 
		checked="checked" />
	<input 
		type="hidden" 
		name="infoPublic" 
		value="1" 
		id="infoPublic" 
		checked="checked" />
	<input 
		type="hidden" 
		name="numberPublic" 
		value="1" 
		id="numberPublic" 
		checked="checked" />
	
	<label for="nomProy"> <?php echo JText::_('NOMBREPR').JText::_('REPERTORIO');  ?>*: </label> 
	<input 
		type="text"
		id="nomProy"
		class="validate[required,custom[onlyLetterNumber]]"
		maxlength="100"
		value="<?php echo isset($objDatosRepertorio) ? $objDatosRepertorio->name : ''; ?>"
		name="name" /> 
	<br />
	
	<label for="categoria"><?php echo JText::_('CATEGORIA'); ?>: </label>
	<select id="selectCategoria" name="categoria">
		
	<?php		
	foreach ( $categoria as $key => $value ) {
		$selectedCat = ($value->id == $categoriaSelected) ? 'selected' : ''; 
				
		echo '<option value="'.$value->id.'" '.$selectedCat.' >'.$value->name.'</option>';
		$opcionesPadre[] = $value->id;
	}
	?>
	</select>
	<br />
	
	<label for="subcategory"><?php echo JText::_('SUBCATEGORIA'); ?>: </label>
	<select id="subcategoria" name="subcategory">
		<option value="all">Todas</option>
		<?php
		foreach ( $subCategorias as $key => $value ) {
			$selectedSubCat = ($value->id == $subcategoriaSelected) ? 'selected' : '';
			$opcionesSubCat .= '<option class="'.$value->father.'" value="'.$value->id.'" '.$selectedSubCat.' >'.$value->name.'</option>';
		}		
		echo $opcionesSubCat;
		?>
	</select>
	<br />
	<br />
	<div id="file">
	<label for="banner"><?php echo JText::_('BANNER').JText::_('REPERTORIO'); ?>*:</label>
	<input type="file" id="banner" onchange='loadImage(this);' accept="gif|jpg|x-png" class="<?php echo $validacion; ?>" name="banner">
	</div>
	<br />
	<?php echo $banner; ?>
	<br />
	
	<label for="avatar"><?php echo JText::_('AVATAR').JText::_('REPERTORIO'); ?>*:</label> 
	<input type="file" id="avatar" onchange='loadImage2(this);' accept="gif|jpg|x-png" class="<?php echo $validacion; ?>" name="avatar">
	<br />
	<?php echo $avatar; ?>
	<br />
	
	<label for="url"><?php echo JText::_('URL_PROY'); ?>: </label> 
	<input 
		type="text" 
		class="validate[custom[url]]"
		id="url"
		value=""
		name="url"
		maxlength="100" /> 
	<br> 
	<br>
	
	<!-- ligas videos -->
	<?php echo JText::_('VIDEOSP');  ?>
	<br />
	<?php
	for ( $i = 0; $i < $limiteVideos; $i++ ) {
		$urlVideo = isset($ligasVideos[$i]) ? $ligasVideos[$i]->url : '';
		$obligatorio = ($i == 0) ? 'validate[required,custom[yt]]' : 'validate[custom[yt]]';
		$asterisco = ($i == 0) ? '*' : '';
		
		echo $labelVideos = '<label for="linkYt'.($i+1).'">'.JText::_('ENLACE_YT').' '.($i+1).$asterisco.':</label>';
		echo $inputVideos = '<input type="text" id="linkYt'.($i+1).'" class="'.$obligatorio.'" value = "'.$urlVideo.'"	name="videoLink'.($i+1).'" /><br />';
	}
	?>
	<br />
	
	<!-- ligas sonido -->
	<?php echo JText::_('AUDIOSP');  ?>
	<br />
	
	<?php
	for ( $i = 0; $i < $limiteSound; $i++ ) {
		$urlSound = isset($ligasAudios[$i]) ? $ligasAudios[$i]->url : '';
		
		echo $labelSound = '<label for="linkYt'.($i+1).'">'.JText::_('ENLACE_SC').' '.($i+1).':</label>';
		echo $inputSound = '<input type="text" id="linkSc1'.($i+1).'" class="validate[custom[sc]]" value = "'.$urlSound.'"	name="soundCloudLink'.($i+1).'" /><br />';
	}
	?>
	
	<br />
	<label for="fotos" id="labelImagenes"><?php echo JText::_('TRAMA_FOTOS'); ?><span id="maximoImg"><?php echo $countImgs; ?></span>*:</label> 
	<input class="multi <?php echo $validacion; ?>" id="fotos" accept="gif|jpg|x-png" type="file" maxlength="10" name="photo" />
	
	<?php
	if ( isset($objDatosRepertorio) ) {
		echo '<div class="MultiFile-label" id="imagenes" style="display:block; float:left;">';
		
		foreach ($objDatosRepertorio->projectPhotos as $key => $value) {
			echo '<input 
					type = "checkbox"
					id = "photosids"
					name = "photoids_'.$value->id.'"  
					class="projectPhotosIds" 
					value="'.$value->id.'" 
					checked="checked" />
					<img alt="'.$objDatosRepertorio->name.'" src="'.MIDDLE.PHOTO.'/'.$value->name.'" width="100" /><br /><br />';
		}
		
		echo '</div>';
	}
	?> 
	<br />
	<div style="max-width:430px;"><strong>NOTA</strong>: Para una mejor calidad del contenido las im&aacute;genes deben tener un tamaño no menor a 800x600 ni mayor a 1920x1200.</div>  
	<br />
	<label for="descProy"><?php echo JText::_('DESCRIPCION').JText::_('REPERTORIO'); ?>*:</label> <br />
	<div style= "max-width:420px;">
		<?php
			$editor =& JFactory::getEditor('tinymce');
			$contenidoDescription = isset($objDatosRepertorio) ? $objDatosRepertorio->description : '';
			echo $editor->display( 'description', 
						   $contenidoDescription,
						   '100%',
						    '250', 
						    '20', 
						    '20', 
						    false, 
						    null, 
						    null, 
						    null, 
						    array('mode' => 'simple'));
			?>
		</textarea>
		</div>
	
	<br /> 	
	<br />
		<label for="elenco">
		<?php echo JText::_('ELENCO'); ?>:</label> <br />
		<div style= "max-width:420px;">
		<?php
			$editor =& JFactory::getEditor('tinymce');
			$contenidoCast = isset($objDatosRepertorio) ? $objDatosRepertorio->cast : '';
			echo $editor->display( 'cast', 
						   $contenidoCast,
						   '100%',
						    '250', 
						    '20', 
						    '20', 
						    false, 
						    null, 
						    null, 
						    null, 
						    array('theme' => 'simple'));
			?>
		</textarea>
		</div>
		<br />
		<br />		 
		<label for="direccion"><?php echo JText::_('RECINTO'); ?>*: </label> 
		<input 
			type="text" 
			class="validate[required]" 
			id="nameRecinto"
			value="<?php echo isset($objDatosRepertorio) ? $objDatosRepertorio->inclosure : ''; ?>" 
			name="inclosure"
			maxlength="100" /> 
		<br>
	
	<br />
	<div id="panel" style="max-width: 420px">
		<label for="direccion"><?php echo JText::_('DIRECCION_RECINTO'); ?>*: </label> 
      <input name="showground" class="validate[required]" value="<?php echo isset($objDatosRepertorio) ? $objDatosRepertorio->showground : ''; ?>" id="searchTextField" type="text" size="50">
       </div>
    <div id="map-canvas" style="height: 400px; max-width: 420px"></div>
	<br />

	<label for="tags"><?php echo JText::_('KEYWORDS'); ?><br /><span style="font-size: 9px;">(separarlas por comas)</span></label>
	<textarea id="tagsArea" name="tags" cols="60" rows="5"><?php
		if( isset($objDatosRepertorio) && !empty($objDatosRepertorio->tags) ) {
			foreach ($objDatosRepertorio->tags as $key => $value) {
				$array[] = $value->tag;
			}
			$tags = implode($array, ', ');
			echo $tags;
			
		}else {
			echo '';
		}
	?></textarea>
	<br />
	
	
	<input type="submit" class="button" id="enviar" value="<?php echo JText::_('ENVIAR');  ?>">
</form>
