<?php
defined('_JEXEC') or die( 'Restricted access' );

$path = 'images/fotoPerfil/';
$pathJumi = Juri::base().'components/com_jumi/files';

$tabla = "perfilx_respuestas";

$var = $_POST;

function busquedaPerfil($tabla, $valor ,$campo){
	
	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);
	
	$query
		->select('users_id')
		->from($tabla)
		->where('FIND_IN_SET("'.$valor.'", '.$campo.')');
	
	$db->setQuery( $query );
	
	$resultado = $db->loadObjectList();
	
	return $resultado;
}

function agrupacionIds($tabla, $valor, $campo){
	
	$noKeyWorks = count($valor);
	
	for($i = 0; $i < $noKeyWorks; $i++){

		$resultado = busquedaPerfil($tabla, $valor[$i], $campo);
				
		$noIds = count($resultado);
		
		for ($j = 0; $j < $noIds; $j++) {

			$arrayIds[] = $resultado[$j]->users_id;

		}
		
		if (isset($arrayIds)) {
			
			$arrayresults = array_count_values($arrayIds);
		
		} else {
			
			$allDone =& JFactory::getApplication();
			$allDone->redirect($_SERVER['HTTP_REFERER'], 'No se encontro ningun resultado' );
		
		}
				
	}	
	
	return $arrayresults;
}

foreach ($var as $key => $value) {
	if ((is_numeric($value)) && ($key != 'usuario') && ($key !='controlador')) {
		$valor[] = $value;
	}
	if ($key == 'usuario') {
		$idjoom = $value;
	}
	elseif ($key == 'campo') {
		$campo = $value;
	}
	elseif ($key == 'controlador') {
		$control = $value;
	}
}

if(empty($valor)) {
	$allDone =& JFactory::getApplication();
	$allDone->redirect($_SERVER['HTTP_REFERER'], 'No se selecciono ninguna busqueda' );
}

$agrupacionIds = agrupacionIds($tabla, $valor, $campo);

$arrayIds = array_keys($agrupacionIds);

arsort($agrupacionIds);

$Ids = implode(",",$arrayIds);

$db =& JFactory::getDBO();
$query = $db->getQuery(true);

$query
	->select('nomNombre, nomApellidoPaterno, nomApellidoMaterno, Foto, users_id, nomJobTitle, nomCompania')
	->from('perfil_persona')
	->where('users_id IN ('.$Ids.') && perfil_tipoContacto_idtipoContacto = 1');

$db->setQuery( $query );

$resultado = $db->loadObjectList();

foreach ($agrupacionIds as $key => $val) {
	
	for ($i = 0; $i < count($resultado); $i++){
		
		if ($resultado[$i]->users_id == $key){

			$arregloOrdenado[] = $resultado[$i]; 
		
		}
	
	}

}

$jsonResult = json_encode($arregloOrdenado);

?>

<?php 
	$document->addStyleSheet($pathJumi.'/view_busqueda/css/pagination.css');
	echo '<script src="libraries/trama/js/jquery.pagination.js"></script>';
?>

<script type="text/javascript">
var members = <?php echo $jsonResult; ?>;

$(document).ready(function(){
	initPagination();

});

function pageselectCallback (page_index, jq) {
	var items_per_page = 9;
	var max_elem = Math.min((page_index+1) * items_per_page, members.length);
	var newcontent = '';
	var columnas = 3;
	var ancho = Math.floor(100/columnas);
	var countCol = 0;

	for ( var i = page_index * items_per_page; i < max_elem; i++ ) {

		var link = 'index.php?option=com_jumi&view=appliction&fileid=17&userid=' + members[i].users_id;		
		var nomJobTitle = members[i].nomJobTitle != null ? members[i].nomJobTitle : " "; 
		var nomCompania = members[i].nomCompania != null ? members[i].nomCompania : " "; 
		
		countCol++;
		if (countCol == columnas) {
			countCol = countCol - columnas;
			last='-last';
		}
		else {
			last='';
		}
		newcontent += '<div id="'+members[i]+'">'
		newcontent += '<div class="proyecto col' + last + ' ancho">';
		newcontent += '<div class="inner">';
		newcontent += '<div class="titulo">';
		newcontent += '<div class="tituloText inner">';
		newcontent += '<div class="fotoPerfil">';
		newcontent += '<a href="' + link + '">';
		newcontent += '<div class="imgPerfil"><img style="width:175px;" src="' + members[i].Foto + '" alt="Foto" /></div>';
		newcontent += '<div class="datosPerfil">';
		newcontent += '<h4>' + members[i].nomNombre + ' ' + members[i].nomApellidoPaterno +'</h4>';
		newcontent += '<h4>' + nomJobTitle + '</h4>';
		newcontent += '<h4>' + nomCompania + '</h4>';
		newcontent += '</div>';
		newcontent += '<div style="clear:both;"></div>';
		newcontent += '</a></div>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '</div>';
	}
               
	jQuery('#Searchresult').html(newcontent);
            
	return false;
}
            
function initPagination() {			 
	var num_entries = members.length;
	var pags = (members.length/num_entries) + 1;

	jQuery("#Pagination").pagination(num_entries, {
		num_display_entries: pags,
		callback: pageselectCallback
	});
}
</script>

	<dl id="Searchresult"></dl>
	<div id="Pagination" class="pagination"></div>