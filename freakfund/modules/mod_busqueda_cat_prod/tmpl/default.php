<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$document = JFactory::getDocument();

$document->addScript('templates/rt_hexeris/js/jquery-1.9.1.js');
$document->addScript('modules/mod_busqueda_cat_prod/js/jquery.chained.js');
$document->addStyleSheet('modules/mod_busqueda_cat_prod/css/busq_cat.css');
$scriptJS = 'jQuery(function() {
	jQuery("#selectSubCat").chained("#selectCat");	
});';
$document->addScriptDeclaration($scriptJS);

$input = JFactory::getApplication()->input;
$tipoPP = $input->get('typeId',null,'int');

$accion= 'index.php?option=com_jumi&view=application&fileid=8&typeId='.$tipoPP.'&status='.$status;

$opcionesSubCat = '';

?>
<div class="busq_cat">
<form action="<?php echo $accion; ?>" method="post"> 
	<select id="selectCat" name="categoria">
		<option value="">Seleccione una categoría</option>
	<?php		
	foreach ( $categoria as $key => $value ) {
		echo '<option value="'.$value->id.'">'.$value->name.'</option>';
		$opcionesPadre[] = $value->id;
	}
	?>
	</select>
	
	<select id="selectSubCat" name="subcategoria">
			<option value="all">Todas</option>
	<?php
	foreach ( $opcionesPadre as $valor ) {
		$opcionesSubCat .= '<option class="'.$valor.'" value="all">Todas las subcategorias</opcion>';
	}
	foreach ( $subCategorias as $key => $value ) {
		$opcionesSubCat .= '<option class="'.$value->father.'" value="'.$value->id.'">'.$value->name.'</option>';
	}
	
	echo $opcionesSubCat;
	?>
	</select>
	
	<input type="submit" value="Buscar" >
</form>
</div>