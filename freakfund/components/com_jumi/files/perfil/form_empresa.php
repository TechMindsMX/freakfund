<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "doFict Access Is Not Allowed" );

	$usuario = JFactory::getUser();
	$app = JFactory::getApplication();
	if ($usuario->guest == 1) {
		$return = JURI::getInstance()->toString();
		$url    = 'index.php?option=com_users&view=login';
		$url   .= '&return='.base64_encode($return);
		$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
	}

	include_once 'utilidades.php';
	require_once 'libraries/trama/libreriasPP.php';
	$pathJumi		= 'components/com_jumi/files/perfil';
	$datos 			= new getDatosObj;
	$accion 		= JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&form=perfil_datosfiscales';
	$datosgenerales	= $datos->datosGenerales($usuario->id);
	$existenDatos	= !is_null($datos->datosFiscales($datosgenerales->id));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Registro de Perfil</title>


	<script>
		jQuery(document).ready(function(){
			datosxCP();
			
		// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine();

			<?php
			if ($existenDatos) {
				$datosFiscales = $datos->datosFiscales($datosgenerales->id);
				$domicioFiscal = $datos->domicilio($datosgenerales->id);
				
				echo "jQuery('#daFi_nomNombreComercial').val('".$datosFiscales->nomNombreComercial."');\n";
				echo "jQuery('#daFi_nomRazonSocial').val('".$datosFiscales->nomRazonSocial."');\n";
				echo "jQuery('#daFi_rfcRFC').val('".$datosFiscales->rfcRFC."');\n";
				
				echo "jQuery('#doFi_nomCalle').val('".$domicioFiscal->nomCalle."');\n";
				echo "jQuery('#doFi_noExterior').val('".$domicioFiscal->noExterior."');\n";
				echo "jQuery('#doFi_noInterior').val('".$domicioFiscal->noInterior."');\n";
				echo "jQuery('#doFi_nomColonias').append(new Option('".$domicioFiscal->perfil_colonias_idcolonias."', '".$domicioFiscal->perfil_colonias_idcolonias."'));\n";
				echo "jQuery('#doFi_nomEstado').append(new Option('".$domicioFiscal->perfil_estado_idestado."', '".$domicioFiscal->perfil_estado_idestado."'));\n";
				echo "jQuery('#doFi_nomDelegacion').val('".$domicioFiscal->perfil_delegacion_iddelegacion."');\n";
				echo "jQuery('#doFi_iniCodigoPostal').val('".$domicioFiscal->perfil_codigoPostal_idcodigoPostal."');\n";
				echo "jQuery('#doFi_nomPais').val('".$domicioFiscal->perfil_pais_idpais."');\n";
				
				echo 'jQuery("li:contains(\'Contacto\')").hide();';
			}else {
				echo 'jQuery("li:contains(\'Generales\')").show();';
				echo 'jQuery("li:contains(\'Contacto\')").hide();';
			}
			?>
		});
    </script>
</head>

<body>
	<div id="contenedor">
		<form action="<?php echo $accion; ?>" id="formID" method="post" name="formID" enctype="multipart/form-data">
            
            <div id="nombre"><h3><?php echo JText::_('DATOS_FISCALES'); ?></h3></div>           
            
            <div id="datosFiscales">
				<div class="_100">
	                <label for="daFi_nomRazonSocial"><?php echo JText::_('RAZON_SOCIAL'); ?>:</label>
	                <input 
	                	name		= "daFi_nomRazonSocial"
	                	type		= "text"
	                	id			= "daFi_nomRazonSocial"
	                	maxlength	= "50" />
	            </div>
            	
            	<div class="_25">
	                <label for="daFi_rfcRFC">RFC(May&uacute;sculas)*:</label>
	                <input 
	                	name		="daFi_rfcRFC" 
	                	class		="validate[required,custom[rfc]]" 
	                	type		="text" 
	                	id			="daFi_rfcRFC" 
	                	maxlength	="14" />
	            </div>
	            
	            <div class="_75">
	                <label for="daFi_nomNombreComercial"><?php echo JText::_('NOMBRE_COMERCIAL'); ?>:</label>
	                <input 
	                	name		="daFi_nomNombreComercial"
	                	type		="text"
	                	id			="daFi_nomNombreComercial"
	                	maxlength	="50" />
	            </div>
            </div>             
            
            <div id="nombre"><h3><?php echo JText::_('DOM_FISCAL'); ?></h3></div>
            
            <div class="_50">
               	<label for="doFi_nomCalle"><?php echo JText::_('LBL_CALLE'); ?> *:</label>
                <input 
                	name		="doFi_nomCalle" 
                	class		="validate[required,custom[onlyLetterNumber]]" 
                	type		="text" 
                	id			="doFi_nomCalle" 
                	maxlength	="70" />
            </div>
            
            <div class="_25">
               	<label for="doFi_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
               	<input 
               		name		="doFi_noExterior" 
               		class		="validate[required,custom[onlyLetterNumber]]" 
               		type		="text" 
               		id			="doFi_noExterior" 
               		size		="10" 
               		maxlength	="5" />
            </div>
            
            <div class="_25">
               	<label for="doFi_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
               	<input 
               		name		="doFi_noInterior" 
               		class		="validate[custom[onlyLetterNumber]]" 
               		type		="text" 
               		id			="doFi_noInterior" 
               		size		="10" 
               		maxlength	="5" />
            </div>
            
            <div class="_25">
               	<label for="doFi_iniCodigoPostal"><?php echo JText::_('LBL_CP'); ?> *:</label>
               	<input 
               		name		="doFi_perfil_codigoPostal_idcodigoPostal" 
               		class		="validate[required,custom[onlyNumberSp]]"  
               		type		="text" 
               		id			="doFi_iniCodigoPostal" 
               		size		="10" 
               		maxlength	="5" />
            </div>
            
            <div class="_75">
               	<label for="doFi_nomColonias"><?php echo JText::_('LBL_COLONIA'); ?> *:</label>
               	<select name="doFi_perfil_colonias_idcolonias" class="validate[required]" id="doFi_nomColonias"></select>
            </div>
            
            <div class="_50">
            	<label for="doFi_nomDelegacion"><?php echo JText::_('LBL_DELEGACION'); ?> *:</label>
            	<input 
            		name="doFi_perfil_delegacion_iddelegacion" 
            		class="validate[required,custom[onlyLetterSp]]"
            		type="text"
            		id="doFi_nomDelegacion"
            		maxlength="50" />
            </div> 
            
            <div class="_25">
               	<label for="doFi_nomEstado"><?php echo JText::_('LBL_ESTADO'); ?> *:</label>
               	<select name="doFi_perfil_estado_idestado" id="doFi_nomEstado" class="validate[required]" ></select>
            </div>
            
            <div class="_25">
               	<label for="doFi_nomPais"><?php echo JText::_('LBL_PAIS'); ?> *:</label>
               	<select name="doFi_perfil_pais_idpais" id="doFi_nomPais" class="validate[required]">
               		<option value="1" selected="selected">M&eacute;xico</option>
				</select>
			</div>
			
			<div>
			<input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR');  ?>" onClick="if(confirm('<?php echo JText::_('CONFIRMAR_CANCELAR');  ?>'))
		javascript:window.history.back();">
				<input name="Enviar" class="button" type="submit" onclick="return validar();" value="<?php echo JText::_('LBL_ENVIAR'); ?>" />
			</div>
		</form>
	</div>
</body>
</html>