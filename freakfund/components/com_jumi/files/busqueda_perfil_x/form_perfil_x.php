<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$usuario = JFactory::getUser();

$base = JUri::base();
$document = JFactory::getDocument();
$pathJumi = Juri::base().'components/com_jumi/files';
$accion= 'index.php?option=com_jumi&view=application&fileid=21';
$tablaGrabacion = 'perfilx_respuestas';

function generacampos ($idPadre, $tabla, $columnaId, $columnaIdPadre, $descripcion) {
		
	$db = JFactory::getDbo();
	$query = $db->getQuery(true); 
	
	$query->select ('*')
	->from ($tabla)
	->where($columnaIdPadre.' = '.$idPadre )
	->order ($descripcion.' ASC');
	
	$db->setQuery($query);
	$results = $db->loadObjectList();
	
	if (!empty($results)) { 
		echo "<ul>";
	}
	
	foreach ($results as $columna) {
		$inputPadre = '<li><input type="checkbox" name="'.$columna->$columnaId.'" value="'.$columna->$columnaId.'" id="'.$columna->$columnaId.'" />';
		$inputPadre .= '<span>'.$columna->$descripcion.'</span>';
			
		echo $inputPadre;
				
		generacampos($columna->$columnaId,$tabla, $columnaId, $columnaIdPadre, $descripcion);
	}
	
	if (!empty($results)) {
		echo "</ul>";
	}
}

$document->addStyleSheet('http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css');
$document->addStyleSheet($pathJumi.'/perfil_x/minified/jquery.tree.min.css');

echo '<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>';
echo '<script src="'.$pathJumi.'/perfil_x/minified/jquery.tree.min.js"></script>';
?>
<script type="text/javascript">
function habilita(campo) {
	console.log(campo.name);
	if (campo.checked) {
		
	} else {
		jQuery('#tree input').prop('disabled', false);
		jQuery('#tree input').prop('checked', false);
	}
}
</script>
	
<form action="<?php echo $accion; ?>" id="perfilX" method="post" name="perfilX">

<div id="tree">
	
<?php
generacampos($idPadreParam, $tablaParam, $columnaIdParam, $columnaIdPadreParam, $descripcionParam);
?>
</div>
	<div class="centrado">
		<input type="hidden" name="campo" value="<?php echo $campoTabla ?>" />
		<input type="hidden" name="usuario" value="<?php echo $usuario->id; ?>" />
		<input class="button" type="button" id="uncheckAll" value="<?php echo JText::_('ES_INSTITUCION'); ?>" />
		<input class="button" type="submit" value="<?php echo JText::_('LBL_BUSCAR'); ?>" />
	</div>
	</form>
	
<div style="clear: both;"></div>
<!-- initialize checkboxTree plugin -->
		<script type="text/javascript">
			jQuery.noConflict();

			jQuery(document).ready(function() {
				jQuery('#tree').tree({
					/* specify here your options */
					dnd: false
				});
			});
		</script>

		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#tree').children().find('ul').hide();
				jQuery('#tree').children().find('li.expanded').removeClass('expanded').addClass('collapsed');
				jQuery('#tree').children().find('span.ui-draggable').removeClass('ui-draggable');

				jQuery('#uncheckAll').click(function() {
					  jQuery('#tree').children().find('input[type="checkbox"]').prop("checked", false);
				});
				
			});
		</script>
