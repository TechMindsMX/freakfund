<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

$path = MIDDLE.AVATAR."/";

$usuario =& JFactory::getUser();
$base =& JUri::base();
$document =& JFactory::getDocument();

$pathJumi = Juri::base().'components/com_jumi/files';
$busquedaPor = array(0 => 'all', 1 => 'PROJECT', 2 => 'PRODUCT', 3 => 'REPERTORY' );
$ligasPP = '';

$tipoPP = isset($_GET['typeId']) ? $_GET['typeId'] : 0;
$categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
$subcategoria = isset($_POST['subcategoria']) ? $_POST['subcategoria'] : 'all';

if ( !$tipoPP ) {
	$ligasPP = '<div id="ligasprod" class="barra-top clearfix">'.
			   '<div id="filtrar" style="float:left;">Filtrar por: </div>'.
			   '<div id="triangle"> </div>'.
			   '<div class="barraProy">Proyectos <input  type="checkbox" id="proyecto" /></div>'.
			   '<div class="barraProd">Productos <input type="checkbox" id="producto" /></div>'.
			   '<div class="barraRep">Repertorios <input type="checkbox" id="repertorio" /></div>'.
			   '<div class="botonLimpio"><input type="button" value="Limpiar Filtro" /></div>'.
			   '<div class="clearfix" id="contador"></div>'.
			   '</div>';
}

function prodProy ($tipo) {
	if( !empty($_POST) ) {
		if (isset($_POST['tags'])) {
			$tagLimpia = array_shift(tagLimpia($_POST['tags']));
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/getByTag/'.$tagLimpia;
		}
		elseif ( ($tipo == 'all' ) && ($_POST['categoria'] == "") && ($_POST['subcategoria'] == "all") ) { //Todo de Proyectos y Productos no importan las categorias ni subcategorias
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/all';
		} elseif ( ($tipo == 'all' ) && ($_POST['categoria'] != "") && ($_POST['subcategoria'] == "all") ) {//Productos y Proyectos por categoria
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/category/all/'.$_POST['categoria'];
		} elseif ( ($tipo == 'all' ) && ($_POST['categoria'] != "") && ($_POST['subcategoria'] != "all") ) {//Productos y proyectos por subcategoria
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/subcategory/all/'.$_POST['subcategoria'];
		} elseif ( ($tipo != 'all' ) && ($_POST['categoria'] != "") && ($_POST['subcategoria'] == "all") ) {//Productos o proyectos por categoria
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/category/'.$tipo.'/'.$_POST['categoria'];
		} elseif ( ($tipo != 'all' ) && ($_POST['categoria'] != "") && ($_POST['subcategoria'] != "all") ) {//Productos o proyectos por Subcategoria
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/subcategory/'.$tipo.'/'.$_POST['subcategoria'];
		} elseif ( ($tipo != 'all' ) && ($_POST['categoria'] == "") && ($_POST['subcategoria'] == "all") ) {//nose
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/'.$tipo;
		}	
	} else {
		$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/'.$tipo;
	}

	$json0 = @file_get_contents($url);

	if ( $json0 === false ) {
		$app =& JFactory::getApplication();
		$app->redirect(JURI::base(), JText::_('BUSQUEDA_SIN_RESULTADOS'), 'notice');
	}
	
	return $json0;
}

$json = json_decode(prodProy($busquedaPor[$tipoPP]));
$statusName = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/status/list'));

jimport('trama.class');
foreach ($json as $key => $value) {
	$value->nomCat = JTrama::getSubCatName($value->subcategory);
	$value->nomCatPadre = JTrama::getCatName($value->subcategory);
	$value->producer = JTrama::getProducerProfile($value->userId);
	$value->statusName = JTrama::getStatusName($value->status);
}


foreach ($json as $key => $value) {
	if($value->status != 4){
	$jsonJS[] = $value;
			switch ($value->type) {
				case 'PROJECT':
					$proyectos[] = $value; //Solo Proyectos
					$prodProy[] = $value; //Proyectos y Productos
					$repertProy[] = $value; //PRoyectos y Repertorios				
					break; 
				case 'PRODUCT':
					$productos[] = $value; //Solo Productos
					$prodProy[] = $value; //Proyectos y Productos
					$repertorioProduc[] = $value; //Productos y Repertorios				
					break;
				case 'REPERTORY':
					$repertorio[] = $value; //Solo Repertorios
					$repertorioProduc[] = $value; //Repertorios y Productos
					$repertProy[] = $value; //Repertorios y Proyectos							
					break;	
			}		
		}		
};

if (!empty($jsonJS)) {
	$jsonJS = json_encode($jsonJS);
}
if (!empty($productos)) {
	$productos = json_encode($productos);
}
if (!empty($proyectos)) {
	$proyectos = json_encode($proyectos);
}
if(!empty($repertorio)) {
	$repertorio = json_encode($repertorio);
}
if(!empty($prodProy)) {
	$prodProy = json_encode($prodProy);
}
if(!empty($repertorioProduc)) {
	$repertorioProduc = json_encode($repertorioProduc);
}
if(!empty($repertProy)) {
	$repertProy = json_encode($repertProy);
}

$document->addStyleSheet($pathJumi.'/view_busqueda/css/pagination.css');
echo '<script src="'.$pathJumi.'/view_busqueda/js/jquery.pagination.js"></script>';


function tagLimpia ($data) {
  $limitePalabras = 1;
  $pattern = '/[^a-zA-Z_áéíóúñ\s]/i';
  $data = preg_replace($pattern, '', $data);
  $datolimpio = explode(' ', $data, $limitePalabras);
  
  return $datolimpio;
}
?>

<script type="text/javascript">
var members = <?php echo $jsonJS; ?>;

$(document).ready(function(){
	jQuery('#contador').html("<span>RESULTADOS: </span>"+members.length);
	initPagination();
	
	jQuery("#ligasprod input").click(function () {		
		var producto = jQuery('#producto').prop('checked');
		var proyecto = jQuery('#proyecto').prop('checked');
		var repertorio = jQuery('#repertorio').prop('checked');
		
		
		if(this.type != 'button') {
			if(!producto && proyecto && !repertorio) {
				<?php 
				if (isset($proyectos)) {
					echo 'members = '.$proyectos.';
					jQuery("#contador").html("<span>RESULTADOS:</span> "+members.length);
					initPagination();';
				}else {
					echo 'alert("No hay Resultados con este filtro");'.
						 'jQuery("#ligasprod in/home/lutek/workspaceput").prop("checked",false);';
				} ?>
			}else if (producto && !proyecto && !repertorio) {
				<?php 
				if (isset($productos)) {
					echo 'members = '.$productos.';
					jQuery("#contador").html("<span>RESULTADOS: </span>"+members.length);
					initPagination();';
			 	}else {
					echo 'alert("No hay Resultados con este filtro");'.
						 'jQuery("#ligasprod input").prop("checked",false);';
				} 
			 	?>
			}else if(!producto && !proyecto && repertorio) {
				<?php
				if (isset($repertorio)) {
					echo 'members = '.$repertorio.';
					jQuery("#contador").html("<span>RESULTADOS:</span> "+members.length);
					initPagination();';
			 	}else {
					echo 'alert("No hay Resultados con este filtro");'.
						 'jQuery("#ligasprod input").prop("checked",false);';;
				}
				?>
			}else if(producto && proyecto && !repertorio) {
				<?php
				if (isset($prodProy)) {
					echo 'members = '.$prodProy.';
					jQuery("#contador").html("<span>RESULTADOS:</span> "+members.length);
					initPagination();';
			 	}else {
					echo 'alert("No hay Resultados con este filtro");'.
						 'jQuery("#ligasprod input").prop("checked",false);';
				}
				?>
			}else if(producto && !proyecto && repertorio) {
				<?php
				if (isset($repertorioProduc)) {
					echo 'members = '.$repertorioProduc.';
					jQuery("#contador").html("<span>RESULTADOS:</span> "+members.length);
					initPagination();';
			 	}else {
					echo 'alert("No hay Resultados con este filtro");'.
						 'jQuery("#ligasprod input").prop("checked",false);';
				}?>	
			}else if(!producto && proyecto && repertorio) {
				<?php if (isset($repertProy)) {
					echo 'members = '.$repertProy.';
					jQuery("#contador").html("<span>RESULTADOS:</span> "+members.length);
					initPagination();';
			 	}
			 	else {
					echo 'alert("No hay Resultados con este filtro");'.
						 'jQuery("#ligasprod input").prop("checked",false);';
				}?>
			 	
			}else if( (repertorio && proyecto && producto) || (!repertorio && !proyecto && !producto) ){
				members = <?php echo $jsonJS; ?>;
				jQuery("#contador").html("<span>RESULTADOS:</span> "+members.length);
				initPagination();
			}
		}else{
			jQuery('#ligasprod input').prop('checked',false);
			members = <?php echo $jsonJS; ?>;
			jQuery("#contador").html("<span>RESULTADOS:</span> "+members.length);
			initPagination();
		}
	});
});

function pageselectCallback (page_index, jq) {
	var items_per_page = 9;
	var max_elem = Math.min((page_index+1) * items_per_page, members.length);
	var newcontent = '';
	var columnas = 3;
	var ancho = Math.floor(100/columnas);
	var countCol = 0;

	for ( var i = page_index * items_per_page; i < max_elem; i++ ) {

		var link = 'index.php?option=com_jumi&view=appliction&fileid=11&proyid=' + members[i].id;
		
		countCol++;
		if (countCol == columnas) {
			countCol = countCol - columnas;
			last='-last';
		}
		else {
			last='';
		}
		newcontent += '<div id="'+members[i].type+'">'
		newcontent += '<div class="proyecto col' + last + ' ancho">';
		newcontent += '<div class="inner">';
		newcontent += '<div class="titulo">';
		newcontent += '<div class="tituloText inner">';
			var descripcion = members[i].name;
			var largo = 33;
			var trimmed = descripcion.substring(0, largo);
		newcontent += '<span class="tituloProy"><a href="' + link + '">' + trimmed + '</a></span>';
		newcontent += '<span class="catSubCat">' + members[i].nomCatPadre + ' - ' + members[i].nomCat +'</span>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '<div class="avatar">';
		newcontent += '<a href="' + link + '">';
		newcontent += '<img src="<?php echo $path; ?>' + members[i].projectAvatar.name + '" alt="Avatar" /></a></div>';
		newcontent += '<div class="descripcion">';
		newcontent += '<div class="inner">';			
		newcontent += '<div class="descText">' + members[i].description + '</div>';
		newcontent += '<span class="productor">' + members[i].producer+'</span>';
		newcontent += '<p class="readmore">';
		newcontent += '<a href="' + link + '" class="leerText">' + "Ver más";
		newcontent += '</a>';
		newcontent += '</p>';
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


<title>Pagination</title>
</head>
<body>
	<?php echo $ligasPP; ?>
	<dl id="Searchresult"></dl>
	<div id="Pagination" class="pagination"></div>
</body>
</html>