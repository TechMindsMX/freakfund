<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
include_once 'utilidades.php';
$datos = new getDatosObj;
$pathJumi = 'components/com_jumi/files/perfil';
$accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&form=perfil_persona';
$usuario = JFactory::getUser();

$existenDatos = $datos->existingUser($usuario->id);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Registro de Perfil</title>

	<link rel="stylesheet" href="<?php echo $pathJumi ?>/css/validationEngine.jquery.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo $pathJumi ?>/css/form.css" type="text/css"/>
	
	<script src="<?php echo $pathJumi ?>/js/misjs.js" type="text/javascript"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	
	<script>
		jQuery(document).ready(function(){
			jQuery("#formID").validationEngine();
			
			<?php
			if($existenDatos) {
				$generales = $datos->datosGenerales($usuario->id);				
				echo "jQuery('#daGr_Foto_guardada').val('".$generales->Foto."');";
				echo "jQuery('#daGr_nomNombre').val('".$generales->nomNombre."');";
				echo "jQuery('#daGr_nomApellidoPaterno').val('".$generales->nomApellidoPaterno."');";
				echo "jQuery('#daGr_nomApellidoMaterno').val('".$generales->nomApellidoMaterno."');";
				
				echo 'jQuery("li:contains(\'Empresa\')").show();';
				echo 'jQuery("li:contains(\'Contacto\')").hide();';
			}else {
				echo 'jQuery("li:contains(\'Empresa\')").hide();';
				echo 'jQuery("li:contains(\'Contacto\')").hide();';
			}
			?>
		});
    </script>
</head>

<body>
	<div id="contenedor">
		<form action="<?php echo $accion; ?>" id="formID" method="post" name="formID" enctype="multipart/form-data">
			<input type="hidden" name="daGr_Foto_guardada" id="daGr_Foto_guardada" value="" />
			
			<div id="nombre"><h3><?php echo JText::_('DATOS_GR'); ?></h3></div>            
			
			<div class="_50">
				<label for="daGr_nomNombre"><?php echo JText::_('NOMBRE'); ?> *:</label>   
				<input 
					name		= "daGr_nomNombre" 
					class		= "validate[required,custom[onlyLetterSp]]" 
					type		= "text" 
					id			= "daGr_nomNombre" 
					maxlength	= "25" />
			</div>
			
			<div class="_25">
				<label for="daGr_nomApellidoPaterno"><?php echo JText::_('APEPAT'); ?>*:</label>
				<input 
					name 		= "daGr_nomApellidoPaterno" 
					class 		= "validate[required,custom[onlyLetterSp]]" 
					type 		= "text" 
					id 			= "daGr_nomApellidoPaterno" 
					maxlength 	= "25" />
			</div>
			
			<div class="_25">
				<label for="daGr_nomApellidoMaterno"><?php echo JText::_('APEMAT'); ?>:</label>
				<input 
					name		= "daGr_nomApellidoMaterno" 
					class		= "validate[custom[onlyLetterSp]]" 
					type		= "text" 
					id			= "daGr_nomApellidoMaterno" 
					maxlength	= "25" />
			</div>
			
			<div class="_100">
				<label for="daGr_Foto"><?php echo JText::_('FOTO'); ?>:</label>
				<input 
					name		= "daGr_Foto"
					id			= "daGr_Foto"
					type		= "file"
					onchange	= 'loadImage(this)' />
			</div>
			
            <div>
            	<input name="Enviar" class="button" type="submit" value="<?php echo JText::_('ENVIAR'); ?>" />
            </div>  
        </form>
    </div>
</body>
</html>