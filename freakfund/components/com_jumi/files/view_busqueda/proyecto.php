<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );
jimport('trama.class');
jimport('trama.usuario_class');

$usuario 		=& JFactory::getUser();
$base 			=& JUri::base();
$document 		=& JFactory::getDocument();
$pathJumi 		= Juri::base().'components/com_jumi/files';
$busquedaPor 	= array(0 => 'all', 1 => 'PROJECT', 2 => 'PRODUCT', 3 => 'REPERTORY' );
$ligasPP 		= '';
$input 			= JFactory::getApplication()->input;
$tipoPP 		= $input->get('typeId', 0, 'INT');

$params 		= new stdClass;
$params->categoria 		= $input->get('categoria', 'all', 'STR');
$params->subcategoria 	= $input->get('subcategoria', 'all', 'STR');
$params->estatus 		= $input->get('status', '', 'STR');
$params->tags 			= $input->get('tags', null, "STR");

function filtro (){
		$ligasPP = '<div id="ligasprod" class="barra-top clearfix">'.
				   '<div id="filtrar" style="float:left;">'.JText::_('FILTRAR').'</div>'.
				   '<div id="triangle"> </div>'.
				   '<div class="barraProy">'.JText::_('LABEL_PROYECTOS').' <input  type="radio" id="proyecto" name="filtro" CHECKED /></div>'.
				   '<div class="barraProd">'.JText::_('LABEL_PRODUCTOS').' <input type="radio" id="producto" name="filtro" /></div>'.
				   '<div class="clearfix" id="contador"></div>'.
				   '</div>';
		
		return $ligasPP;
}

function prodProy ($tipo, $params) {
	if( !empty($_POST) ) {
		if (!is_null($params->tags)) {
			$tagLimpia = array_shift(tagLimpia($params->tags));
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/getByKeyword/'.$tagLimpia;
		} elseif ( ($tipo == 'all' ) && ($params->categoria == "all") && ($params->subcategoria == "all") ) { //Todo de Proyectos y Productos no importan las categorias ni subcategorias
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/all';
		} elseif ( ($params->categoria == '') && ($params->subcategoria == "all") && ($params->estatus != "")) {
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/status/'.$params->estatus;
		} elseif ( ($params->categoria != "all") && ($params->subcategoria == "all") ) {//Productos o proyectos por categoria
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/category/'.$params->categoria.'/'.$params->estatus;
		} elseif ( ($params->categoria != "all") && ($params->subcategoria != "all") ) {//Productos o proyectos por Subcategoria
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/subcategory/'.$tipo.'/'.$params->subcategoria.'/'.$params->estatus;
		}
	} else {
		if ($params->categoria == 'all') {
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/status/'.$params->estatus;
		} else {
			$url = MIDDLE.PUERTO.'/trama-middleware/rest/project/category/'.$params->categoria.'/'.$params->estatus;
		}
	}

	$json0 = @file_get_contents($url);
	if ( !json_decode($json0) ) {
		$app =& JFactory::getApplication();
		$app->redirect(JURI::base(), JText::_('BUSQUEDA_SIN_RESULTADOS'), 'notice');
	}
	
	return $json0;
}

$json = json_decode(prodProy($busquedaPor[$tipoPP], $params));
$statusName = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/status/list'));

foreach ($json as $key => $value) {
	$value->nomCat 		= JTrama::getSubCatName($value->subcategory);
	$value->nomCatPadre = JTrama::getCatName($value->subcategory);
	$value->producer 	= JTrama::getProducerProfile(UserData::getUserJoomlaId($value->userId));
	$value->statusName 	= JTrama::getStatusName($value->status);
	
	$string = strip_tags($value->description);
	$value->description = (strlen($string) > 113 ? substr($string,0,110).'...' : $string);

	$value = JTrama::getDatos($value->id);
	
	JTrama::dateDiff($value->fundEndDate, $value);

	$value->jtextdays = JText::sprintf('LAPSED_DAYS', $value->dateDiff->days);
	
	if( isset($value->premiereEndDateCode) ) {
		$fecha = date('d-m-Y',($value->premiereEndDateCode/1000));
		$value->premiereEndDateArray = explode('-', $fecha);
		$value->premiereEndDateArray[1] = JFactory::getDate()->monthToString($value->premiereEndDateArray[1], true);
	}else{ 
		$value->premiereEndDateArray = array(0=>'01',1=>'Ene',2=>'2015');
	}
}

foreach ($json as $key => $value) {
	if($value->status != 4){
		$jsonJS[] = $value;
		switch ($value->status) {
			case '5':
				$proyectos[] = $value; //Solo Proyectos
				break; 
			case in_array($value->status, array(6,7)):
				$productos[] = $value; //Solo Productos
				break;
		}		
	}		
};

if (!empty($jsonJS)) {
	$jsonJS = json_encode($proyectos);
}
if (!empty($productos)) {
	$productos = json_encode($productos);
}
if (!empty($proyectos)) {
	$proyectos = json_encode($proyectos);
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
	jQuery('#contador').html("<span><?php echo JText::_('RESULTADOS'); ?>:</span>"+members.length);
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
					jQuery("#contador").html("<span>'.JText::_('RESULTADOS').':</span> "+members.length);
					initPagination();';
				}else {
					echo 'alert("'.JText::_('NO_RESULTADOS').'");'.
						 'jQuery("#ligasprod in/home/lutek/workspaceput").prop("checked",false);';
				} ?>
			}else if (producto && !proyecto && !repertorio) {
				<?php 
				if (isset($productos)) {
					echo 'members = '.$productos.';
					jQuery("#contador").html("<span>'.JText::_('RESULTADOS').': </span>"+members.length);
					initPagination();';
			 	}else {
					echo 'alert("'.JText::_('NO_RESULTADOS').'");'.
						 'jQuery("#ligasprod input").prop("checked",false);';
				} 
			 	?>
			}else if(!producto && !proyecto && repertorio) {
				<?php
				if (isset($repertorio)) {
					echo 'members = '.$repertorio.';
					jQuery("#contador").html("<span>'.JText::_('RESULTADOS').':</span> "+members.length);
					initPagination();';
			 	}else {
					echo 'alert("'.JText::_('NO_RESULTADOS').'");'.
						 'jQuery("#ligasprod input").prop("checked",false);';;
				}
				?>
			}else if(producto && proyecto && !repertorio) {
				<?php
				if (isset($prodProy)) {
					echo 'members = '.$prodProy.';
					jQuery("#contador").html("<span>'.JText::_('RESULTADOS').':</span> "+members.length);
					initPagination();';
			 	}else {
					echo 'alert("'.JText::_('NO_RESULTADOS').'");'.
						 'jQuery("#ligasprod input").prop("checked",false);';
				}
				?>
			}else if(producto && !proyecto && repertorio) {
				<?php
				if (isset($repertorioProduc)) {
					echo 'members = '.$repertorioProduc.';
					jQuery("#contador").html("<span>'.JText::_('RESULTADOS').':</span> "+members.length);
					initPagination();';
			 	}else {
					echo 'alert("'.JText::_('NO_RESULTADOS').'");'.
						 'jQuery("#ligasprod input").prop("checked",false);';
				}?>	
			}else if(!producto && proyecto && repertorio) {
				<?php if (isset($repertProy)) {
					echo 'members = '.$repertProy.';
					jQuery("#contador").html("<span>'.JText::_('RESULTADOS').':</span> "+members.length);
					initPagination();';
			 	}
			 	else {
					echo 'alert("'.JText::_('NO_RESULTADOS').'");'.
						 'jQuery("#ligasprod input").prop("checked",false);';
				}?>
			 	
			}else if( (repertorio && proyecto && producto) || (!repertorio && !proyecto && !producto) ){
				members = <?php echo $jsonJS; ?>;
				jQuery("#contador").html("<span><?php echo JText::_('RESULTADOS'); ?>:</span> "+members.length);
				initPagination();
			}
		}else{
			jQuery('#ligasprod input').prop('checked',false);
			members = <?php echo $jsonJS; ?>;
			jQuery("#contador").html("<span><?php echo JText::_('RESULTADOS'); ?>:</span> "+members.length);
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

		/*VARIABLES PARA PROBAR QUITARLAS CUANDO ESTE EL SERVICIO NO SE TE OLVIDE PENDEJO*/
		members[i].recaudado = 20000;
		members[i].fundEnd = '12-12-2013';
		members[i].roiFinanciadores = 40;
		members[i].roiInversionistas = 30;
		members[i].premierEnd = '12-01-2014';
		/**************************************************************************************/
		
		var link = 'index.php?option=com_jumi&view=appliction&fileid=11&proyid=' + members[i].id;
		/*Cambiar los atributos del objeto segun el JSON*/
		var breakeven = members[i].breakeven != null ? members[i].breakeven : " ";
		var recaudado = members[i].recaudado != null ? members[i].recaudado : " ";
		var porcentajeRecaudado = members[i].recaudado != null ? ((members[i].recaudado/members[i].breakeven)*100).toFixed(2) : 0;
		var cierreFinanciamiento = members[i].fundEnd != null ? members[i].fundEnd : " "; 
		var roiFinanciadores = members[i].roiFinanciadores != null ? members[i].roiFinanciadores : " ";
		var roiInversionistas = members[i].roiInversionistas != null ? members[i].roiInversionistas : " ";
		var cierrePresentacion = members[i].premierEnd != null ? members[i].premierEnd : " ";
		/************************************************************************************/
		countCol++;
		if (countCol == columnas) {
			countCol = countCol - columnas;
			last='-last';
		}
		else {
			last='';
		}
		var descripcion = members[i].name;
		var largo = 33;
		var trimmed = descripcion.substring(0, largo);
		
		newcontent += '<div id="'+members[i].type+'">'
		newcontent += '<div class="proyectos col' + last + ' ancho">';
		newcontent += '<div class="inner">';
		newcontent += '<div class="titulo">';
		newcontent += '<div class="tituloText inner">';
		newcontent += '<span class="tituloProy"><a href="' + link + '">' + trimmed + '</a></span>';
		newcontent += '<span class="catSubCat upper">' + members[i].nomCatPadre + ' - ' + members[i].nomCat +'</span>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '<div class="avatar" style="background-image:url(\'<?php echo AVATAR; ?>\/'+members[i].projectAvatar.name+'\');">';
		newcontent += '	<a href="' + link + '">';
		newcontent += '		<span class="mask"></span>';
		newcontent += '	</a>';
		newcontent += '</div>';
		
		if(members[i].status == 5){
			newcontent += '<div class="fondo_barra">';
			newcontent += '<span class="txt_barra"><?php echo JText::_('LABEL_RECAUDADO'); ?>: '+ porcentajeRecaudado +'%</span>';
			newcontent += '<span class="barra" style="width: '+ porcentajeRecaudado +'%; text-align:center;"></span>';
			newcontent += '</div>';
			newcontent += '<div class="cuentas upper"><?php echo JText::_('LABEL_RECAUDADO'); ?>: $<span class="number">'+ recaudado +'</span></div>';
			newcontent += '<div class="cuentas"><?php echo JText::_('PUNTO_EQUILIBRIO_ABR'); ?>: $<span class="number">'+ breakeven +'</span></div>';
			newcontent += '<div class="cuentas">'+ members[i].jtextdays +'</div>';
		}
		
		if( members[i].status == 6 || members[i].status == 7 || members[i].status == 0){
			newcontent += '<div class="productStyle">';
			newcontent += '<div class="box1 two-cols first"><div class="inside">';
			newcontent += '<div class="big">'+ roiFinanciadores +'% </div> <div class="small"><?php echo JText::_('LABEL_ROF'); ?></div></div>';
			newcontent += '</div>';
			newcontent += '<div class="box1 two-cols second"><div class="inside">';
			newcontent += '<div class="big">'+ roiInversionistas +'%</div><div class="small"><?php echo JText::_('LABEL_ROI'); ?></div></div>';
			newcontent += '</div>';
			newcontent += '</div>';
		}
		
		newcontent += '<div class="descripcion">';
		newcontent += '<div class="inner">';		
		newcontent += '<div class="descText">' + members[i].description + '</div>';
		newcontent += '<span class="productor">' + members[i].producer+'</span>';
		newcontent += '<div class="boton-wrap">';
		newcontent += '<a class="button btn-invertir" href="' + link + '">' + "<?php echo JText::_('INVERTIR_PROYECTO'); ?>"+'</a>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '</div>';
		newcontent += '</div>';
	}
               
	jQuery('#Searchresult').html(newcontent);
    jQuery("span.number").number( true, 2 );
            
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
	<?php
	if (isset($params->tags)){
	 	echo filtro();
	 }
	 ?>
	<dl id="Searchresult"></dl>
	<div id="Pagination" class="pagination"></div>
</body>
</html>