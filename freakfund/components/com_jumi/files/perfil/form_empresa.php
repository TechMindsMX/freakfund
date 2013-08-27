<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "doFict Access Is Not Allowed" );
	include_once 'utilidades.php';
	
	$pathJumi		 	= 'components/com_jumi/files/perfil';
	$datosgenerales 	= new getDatosObj;
	$usuario 			= JFactory::getUser();
	$generales 			= $datosgenerales->datosGenerales($usuario->id, 1);
	$direccionGeneral	= $datosgenerales->domicilio($generales->id, 1);
	$domcilioFiscal 	= $datosgenerales->domicilio($generales->id, 2);
	$datosFiscales 		= $datosgenerales->datosFiscales($generales->id);
	
	if (isset($domcilioFiscal)) {
		$existe = 1;
	} else {
		$existe = 0;
	}
	
	$accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&exi='.$existe.'&form=empresa';
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
			datosxCP();
			
		// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine();

			jQuery('#copiarDatos').click(function(){
					jQuery('#doFi_nomCalle').val('<?php echo $direccionGeneral->nomCalle;?>');
					jQuery('#doFi_noExterior').val('<?php echo $direccionGeneral->noExterior;?>');
					jQuery('#doFi_noInterior').val('<?php echo $direccionGeneral->noInterior;?>');					
					jQuery('option', jQuery('#doFi_nomColonias')).remove();
					jQuery('#doFi_nomColonias').append(new Option('<?php echo $direccionGeneral->perfil_colonias_idcolonias;?>','<?php echo $direccionGeneral->perfil_colonias_idcolonias;?>'));					
					jQuery('#doFi_nomDelegacion').val('<?php echo $direccionGeneral->perfil_delegacion_iddelegacion;?>');
					jQuery('#doFi_iniCodigoPostal').val('<?php echo $direccionGeneral->perfil_codigoPostal_idcodigoPostal;?>');
					jQuery('option', jQuery('#doFi_nomEstado')).remove();
					jQuery('#doFi_nomEstado').append(new Option('<?php echo $direccionGeneral->perfil_estado_idestado;?>','<?php echo $direccionGeneral->perfil_estado_idestado;?>'));					
					jQuery('#doFi_nomPais').val('<?php echo $direccionGeneral->perfil_pais_idpais;?>');
				});

			<?php 		
			if ($existe) {
				echo "jQuery('#daFi_nomNombreComercial').val('".$datosFiscales->nomNombreComercial."');";
				echo "jQuery('#daFi_nomRazonSocial').val('".$datosFiscales->nomRazonSocial."');";
				echo "jQuery('#daFi_rfcRFC').val('".$datosFiscales->rfcRFC."');";
				
				echo "jQuery('#doFi_nomCalle').val('".$domcilioFiscal->nomCalle."');";
				echo "jQuery('#doFi_noExterior').val('".$domcilioFiscal->noExterior."');";
				echo "jQuery('#doFi_noInterior').val('".$domcilioFiscal->noInterior."');";
				echo "jQuery('#doFi_nomColonias').append(new Option('".$domcilioFiscal->perfil_colonias_idcolonias."', '".$domcilioFiscal->perfil_colonias_idcolonias."'));";
				echo "jQuery('#doFi_nomEstado').append(new Option('".$domcilioFiscal->perfil_estado_idestado."', '".$domcilioFiscal->perfil_estado_idestado."'));";
				echo "jQuery('#doFi_nomDelegacion').val('".$domcilioFiscal->perfil_delegacion_iddelegacion."');";
				echo "jQuery('#doFi_iniCodigoPostal').val('".$domcilioFiscal->perfil_codigoPostal_idcodigoPostal."');";
				echo "jQuery('#doFi_nomPais').val('".$domcilioFiscal->perfil_pais_idpais."');";
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
	                <input name="daFi_nomRazonSocial" type="text" id="daFi_nomRazonSocial" maxlength="50" />
	            </div>
            	<div class="_25">
	                <label for="daFi_rfcRFC">RFC(May&uacute;sculas)*:</label>
	                <input name="daFi_rfcRFC" class="validate[required,custom[rfc]]" type="text" id="daFi_rfcRFC" maxlength="14" />
	            </div>
	            <div class="_75">
	                <label for="daFi_nomNombreComercial"><?php echo JText::_('NOMBRE_COMERCIAL'); ?>:</label>
	                <input name="daFi_nomNombreComercial" type="text" id="daFi_nomNombreComercial" maxlength="50" />
	            </div>
            </div>             
            
            <div id="nombre"><h3><?php echo JText::_('DOM_FISCAL'); ?></h3></div>            
            
            <div class="_50">
            	<label for="datosPrev"><?php echo JText::_('COPIAR_INFO'); ?></label>
            </div>
            
            <div class="_50" style="text-align: right;">
            	<input name="Copiar" class="button" id="copiarDatos" type="button" value="<?php echo JText::_('COPIAR'); ?>" />
            </div>
            
            <div class="_50">
               	<label for="doFi_nomCalle"><?php echo JText::_('CALLE'); ?> *:</label>
                <input name="doFi_nomCalle" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_nomCalle" maxlength="70" />
            </div>
            
            <div class="_25">
               	<label for="doFi_noExterior"><?php echo JText::_('NUM_EXT'); ?>*:</label>
               	<input name="doFi_noExterior" class="validate[required,custom[onlyLetterNumber]]" type="text" id="doFi_noExterior" size="10" maxlength="5" />
            </div>
            
            <div class="_25">
               	<label for="doFi_noInterior"><?php echo JText::_('NUM_INT'); ?>:</label>
               	<input name="doFi_noInterior" class="validate[custom[onlyLetterNumber]]" type="text" id="doFi_noInterior" size="10" maxlength="5" />
            </div>
            
            <div class="_25">
               	<label for="doFi_iniCodigoPostal"><?php echo JText::_('CP'); ?> *:</label>
               	<input name="doFi_perfil_codigoPostal_idcodigoPostal" class="validate[required,custom[onlyNumberSp]]"  type="text" id="doFi_iniCodigoPostal" size="10" maxlength="5" />
            </div>
            
            <div class="_75">
               	<label for="doFi_nomColonias"><?php echo JText::_('COLONIA'); ?> *:</label>
               	<!--input name="doFi_perfil_colonias_idcolonias" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomColonias" maxlength="50" /-->
               	<select name="doFi_perfil_colonias_idcolonias" class="validate[required]" id="doFi_nomColonias"></select>
            </div>
            
            <div class="_50">
            	<label for="doFi_nomDelegacion"><?php echo JText::_('DELEGACION'); ?> *:</label>
            	<input name="doFi_perfil_delegacion_iddelegacion" class="validate[required,custom[onlyLetterSp]]" type="text" id="doFi_nomDelegacion" maxlength="50" />
            </div> 
            
            <div class="_25">
               	<label for="doFi_nomEstado"><?php echo JText::_('ESTADO'); ?> *:</label>
               	<select name="doFi_perfil_estado_idestado" id="doFi_nomEstado" class="validate[required]" ></select>
            </div>
            
            <div class="_25">
               	<label for="doFi_nomPais"><?php echo JText::_('PAIS'); ?> *:</label>
               	<select name="doFi_perfil_pais_idpais" id="doFi_nomPais" class="validate[required]">
               		<option value="1" selected="selected">M&eacute;xico</option>
				</select>
			</div>
			
			<div>
				<input name="Enviar" class="button" type="submit" onclick="return validar();" value="<?php echo JText::_('ENVIAR'); ?>" />
			</div>
		
		</form>
	</div>
</body>
</html>