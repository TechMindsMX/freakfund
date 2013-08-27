<?php
	defined('_JEXEC') OR defined('_VALID_MOS') OR die( "doFict Access Is Not Allowed" );
	include_once 'utilidades.php';
?>
<?php
	$usuario =& JFactory::getUser();
	$generales = datosGenerales($usuario->id, 1);
	if(isset($generales)){
		$exisPro = proyectosPasados($generales->id);
		if (!empty($exisPro)) {
			$existe = 'true';
		} else {
			$existe = 'false';
		}
		$proyectosPasados = proyectosPasados($generales->id);
	} else {
		$existe = 'false';
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Registro de Perfil</title>

	<?php
 		$pathJumi = 'components/com_jumi/files/perfil';
 		$accion = JURI::base(true).'/index.php?option=com_jumi&view=application&fileid=7&exi='.$existe.'&form=curri';
 	?>

	<link rel="stylesheet" href="<?php echo $pathJumi ?>/css/validationEngine.jquery.css" type="text/css"/>	
	<link rel="stylesheet" href="<?php echo $pathJumi ?>/css/form.css" type="text/css"/>
	<script src="<?php echo $pathJumi ?>/js/misjs.js" type="text/javascript"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.js" type="text/javascript"></script>    
	<script src="<?php echo $pathJumi ?>/js/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8"></script>
	<script src="<?php echo $pathJumi ?>/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
	<script>
		jQuery(document).ready(function(){
			var eliminaProy= "";
		// binds form submission and fields to the validation engine
			jQuery("#formID").validationEngine();			

			<?php 		
				if ($generales->perfil_personalidadJuridica_idpersonalidadJuridica == 1) {
					echo 'jQuery("li:contains(\'Empresa\')").hide();';
					echo 'jQuery("li:contains(\'Contacto\')").hide();';
				}
			?>
			jQuery('.btnEliminar').click(function(){
				var confirmar = confirm('Esta seguro que deseas eliminar este proyecto');
				if (confirmar){
					eliminaProy += jQuery(this).parent().parent().children().children(':first-child').val() + ',';
					jQuery(this).parent().parent().remove();
					jQuery('#eliminaProy').val(eliminaProy);
				}
				
			});


		});
		/*
		* @param {jqObject} the field where the validation applies
		* @param {Array[String]} validation rules for this field
		* @param {int} rule index
		* @param {Map} form options
		* @return an error string if validation failed
		*/
		
		function checkHELLO(field, rules, i, options){
			if (field.val() != "HELLO") {
			// this allows to use i18 for the error msgs
				return options.allrules.validate2fields.alertText;
			}
		}
    </script>
</head>

<body>
<!--DIVS OCULTOS QUE AGREGAN CAMPOS-->
	<div class="_100" id="readrootProy" style="display: none">                  
            <input name="prPa_idHistorialProyectos" type="hidden" id="prPa_idHistorialProyectos" value="<?php echo 'NULL';?>" />
            <label for="prPa_nomNombreProyecto"><?php echo JText::_('NOMBREPR').JText::_('PROYECTO'); ?></label>
            <input name="prPa_nomNombreProyecto"  type="text" id="prPa_nomNombreProyecto" maxlength="70" />            
            <label for="prPa_urlProyectosPasados"><?php echo JText::_('URL_PROY'); ?></label>
            <input name="prPa_urlProyectosPasados" class="validate[custom[url]]"  type="text" id="prPa_urlProyectosPasados" maxlength="70" />           
            <label for="prPa_dscDescripcionProyecto"><?php echo JText::_('DESCRIPCION').JText::_('PROYECTO'); ?></label> <br />         
            <textarea name="prPa_dscDescripcionProyecto" id="prPa_dscDescripcionProyecto" cols="100" rows="6" maxlength="250"></textarea>  
            <input type="button" value="<?php echo JText::_('QUITAR_PROY'); ?>" onclick="moreFieldsProy(this,false)" />          
	</div>

	<div id="contenedor">
		<form action="<?php echo $accion; ?>" id="formID" method="post" name="formID" enctype="multipart/form-data">
			<input id="eliminaProy" name="eliminaProy" type="hidden" value="" />
			<div id="nombre"><h3><?php echo JText::_('PROY_PAS'); ?></h3></div>            
            <span>
	            <div class="_100">
	            	<?php if ($existe == 'true') { echo '<input name="prPa_idHistorialProyectos" type="hidden" id="prPa_idHistorialProyectos" value="'.$proyectosPasados[0]->idHistorialProyectos.'" />'; }?>
	                <label for="prPa_nomNombreProyecto"><?php echo JText::_('NOMBREPR').JText::_('PROYECTO'); ?></label>
	                <input name="prPa_nomNombreProyecto" type="text" id="prPa_nomNombreProyecto" maxlength="70" 
	                <?php if (!empty($proyectosPasados)) {echo 'value = "'.$proyectosPasados[0]->nomNombreProyecto.'"';}?>/>
	            </div>
	            <div class="_100">
	                <label for="prPa_urlProyectosPasados"><?php echo JText::_('URL_PROY'); ?></label>
	                <input name="prPa_urlProyectosPasados" class="validate[custom[url]]"  type="text" id="prPa_urlProyectosPasados" maxlength="70" 
	                <?php if (!empty($proyectosPasados)) {echo 'value = "'.$proyectosPasados[0]->urlProyectosPasados.'"';}?>/>
	            </div>
	            <div class="_100">
	            	<label for="prPa_dscDescripcionProyecto"><?php echo JText::_('DESCRIPCION').JText::_('PROYECTO'); ?></label> <br />           
	            	<textarea name="prPa_dscDescripcionProyecto"  id="prPa_dscDescripcionProyecto" cols="100" rows="6"><?php 
	            	if (!empty($proyectosPasados)) {echo $proyectosPasados[0]->dscDescripcionProyecto;}
	            	?></textarea>
	            	<input type="button" value="<?php echo JText::_('QUITAR_PROY'); ?>" class="btnEliminar" />
	            </div>
            </span>
            <span id="writerootProy">
            <?php
			if (isset($proyectosPasados)) {
            	$noProyectos = count($proyectosPasados);
            	for ($i = 1; $i < $noProyectos; $i++) {
					echo '<span><div class="_100">
						<input name="prPa_idHistorialProyectos'.($i-1).'" type="hidden" id="prPa_idHistorialProyectos'.($i-1).'" value="'.$proyectosPasados[$i]->idHistorialProyectos.'" />
						<label for="prPa_nomNombreProyecto'.($i-1).'">'.JText::_('NOMBREPR').JText::_('PROYECTO').'</label>
                		<input name="prPa_nomNombreProyecto'.($i-1).'" type="text" id="prPa_nomNombreProyecto'.($i-1).'" maxlength="70" value="'.$proyectosPasados[$i]->nomNombreProyecto.'" />
		            </div>
		            <div class="_100">
		                <label for="prPa_urlProyectosPasados'.($i-1).'">'.JText::_('URL_PROY').'</label>
		                <input name="prPa_urlProyectosPasados'.($i-1).'" class="validate[custom[url]]"  type="text" id="prPa_urlProyectosPasados'.($i-1).'" maxlength="70" value="'.$proyectosPasados[$i]->urlProyectosPasados.'"/>
		            </div>
		            <div class="_100">
		            	<label for="prPa_dscDescripcionProyecto'.($i-1).'">'.JText::_('DESCRIPCION').JText::_('PROYECTO').'</label> <br />           
		            	<textarea name="prPa_dscDescripcionProyecto'.($i-1).'"  id="prPa_dscDescripcionProyecto'.($i-1).'" cols="100" rows="6">'.$proyectosPasados[$i]->dscDescripcionProyecto.'</textarea>
						<input type="button" value="'.JText::_('QUITAR_PROY').'" class="btnEliminar" />
			</div></span>';
				}
			}
            ?>
            </span>
            <input type="button" onclick="moreFieldsProy(this,true)" value="<?php echo JText::_('AGREGAR_PROY'); ?>" /><br /><br />
			<div>
				<input name="Enviar" type="submit" onclick="return validar();" value="<?php echo JText::_('ENVIAR'); ?>" />
			</div>
		</form>
	</div>
</body>
</html>