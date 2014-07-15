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
require_once 'libraries/trama/libreriasPP.php';
include_once 'utilidades.php';
$datos = new getDatosObj;
$pathJumi = 'components/com_jumi/files/perfil';
$accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&form=perfil_persona';

$existenDatos = $datos->existingUser($usuario->id);
?>

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

<body>
	<div id="contenedor">
		<form action="<?php echo $accion; ?>" id="formID" method="post" name="formID" enctype="multipart/form-data">
			<input type="hidden" name="daGr_Foto_guardada" id="daGr_Foto_guardada" value="" />
			
			<div id="nombre"><h1><?php echo JText::_('DATOS_GR'); ?></h1></div>            
			
			<div class="_50">
				<label for="daGr_nomNombre"><?php echo JText::_('LBL_NOMBRE'); ?> *:</label>   
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
				<label for="daGr_Foto"><?php echo JText::_('LBL_FOTO'); ?>:</label>
				<input 
					name		= "daGr_Foto"
					id			= "daGr_Foto"
					type		= "file"
					onchange	= 'loadImage(this)' />
			</div>
			<p class="warning"><?php echo JText::_('TAMANO_IMAGEN_PERFIL');?></p>
			
            <div>
            <input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
            	<input name="Enviar" class="button" type="submit" value="<?php echo JText::_('LBL_ENVIAR'); ?>" />
            </div>  
        </form>
    </div>
