<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$document = JFactory::getDocument();

$document->addScript('modules/mod_busqueda_categoria/js/jquery.chained.js');
$scriptJS = 'jQuery(function() {
	jQuery("#selectSubCat").chained("#selectCat");	
});';

$tipoPP = isset($_GET['typeId']) ? '&typeId='.$_GET['typeId'] : '';

$accion= 'index.php?option=com_jumi&view=application&fileid=8'.$tipoPP;

$document->addScriptDeclaration($scriptJS);

$opcionesSubCat = '';
?>
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
		
