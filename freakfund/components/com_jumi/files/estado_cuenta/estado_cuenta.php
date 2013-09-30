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

jimport('trama.class');
require_once 'components/com_jumi/files/classIncludes/libreriasPP.php';

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token = JTrama::token();

$datosUsuario=JTrama::getUserBalance($usuario->id);

//definicion de campos del formulario
$action = '#';
//$action = 'components/com_jumi/files/costos_variables/post.php';

include_once ("objetote.php");

$tableHtml = "<table class='table-striped' id='edocta_table' border='1'>";
$tableHtml .= "<tr id='cabezera'>";
$tableHtml .= "<th>Fecha<th />";
$tableHtml .= "<th>Movimiento<th />";
$tableHtml .= "<th>Tipo<th />";
$tableHtml .= "<th>Detalle<th />";
$tableHtml .= "<th>Referencia<th />";
$tableHtml .= "<th>Insitucion<th />";
$tableHtml .= "<th>Tasa<th />";
$tableHtml .= "<th>Cantidad<th />";
$tableHtml .= "<th>Unitario<th />";
$tableHtml .= "<th>Subtotal<th />";
$tableHtml .= "<th>Saldo<th />";
$tableHtml .= "<th>Notas<th />";
$tableHtml .= "</tr>";

$selectTipo = '<select name="tipo" id="filtroTipo">';
$selectTipo .=	"<option value='nada' selected>Sin Filtro</option>";

foreach ($arregloobjetos as $obj) {
	$tableHtml .= "<tr id='".$obj->tipo ."'>";
	$tableHtml .= "<td>" .$obj->fecha . "<td />";
	$tableHtml .= "<td>" .$obj->movimiento . "<td />";
	$tableHtml .= "<td>" .$obj->tipo . "<td />";
	$tableHtml .= "<td>" .$obj->detalle . "<td />";
	$tableHtml .= "<td>" .$obj->referencia . "<td />";
	$tableHtml .= "<td>" .$obj->institucion . "<td />";
	$tableHtml .= "<td>" .$obj->tasa . "<td />";
	$tableHtml .= "<td>" .$obj->cantidad . "<td />";
	$tableHtml .= "<td>" .$obj->unitario . "<td />";
	$tableHtml .= "<td>" .$obj->subtotal . "<td />";
	$tableHtml .= "<td>" .$obj->saldo . "<td />";
	$tableHtml .= "<td>" .$obj->notas . "<td />";
	$tableHtml .= "</tr>";

	
}

foreach ($arregloCatalogo as $obj) {
	$selectTipo .=	"<option value='" .$obj->name . "'>" .$obj->name . "</option>";
}

$tableHtml .= "</table>";
$selectTipo .='</select>';
?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form_cuenta").validationEngine();
		
		jQuery('#filtroTipo').change(function(){
			var limite = jQuery('#edocta_table tr').length;

			if(this.value == 'nada'){
			    jQuery('#edocta_table tr').show();
			}else{
			    var variable=this.value;			    
console.log(variable);
	           	jQuery('#edocta_table tr').hide();
		       	jQuery('#edocta_table tr#'+variable).show();	
		    	jQuery('#edocta_table tr#cabezera').show();		    
			}	
		});
	});
</script>
<h1><?php echo JText::_('ESTADO_CUENTA');  ?></h1>
<div>
	<form id="form_cuenta" action="<?php echo $action; ?>" method="POST">
	
	
		<select name="fechas" >
			  <option value="Enero">Enero</option>
			  <option value="Febrero">Febrero</option>
			  <option value="Marzo">Marzo</option>
			  <option value="Abril">Abril</option>
			  <option value="Mayo">Mayo</option>
			  <option value="Mayo">Junio</option>
			  <option value="Mayo">Julio</option>
			  <option value="Mayo">Agosto</option>
			  <option value="Mayo">Septiembre</option>
			  <option value="Mayo">Octubre</option>
			  <option value="Mayo">Noviembre</option>
			  <option value="Mayo">Diciembre</option>	 
		</select>
					
		<?php echo JText::_('RANGO_FECHA_INICIO');  ?> <input placeholder="DD-MM-AAAA" class="validate[custom[date]]" type="text" name="fechaini">
  		<?php echo JText::_('RANGO_FECHA_FIN');  ?> <input placeholder="DD-MM-AAAA" class="validate[custom[date]]" type="text" name="fechafin">
		
		<input type="button" class="button" value="Consultar" />
		
	</form>
		<?php echo $selectTipo; ?>
		<div>
		
			<table class='table-striped' border="1">
				<tr>
					<td><?php echo JText::_('SOCIO');?></td>
					<td><?php echo $usuario->name;?></td>
				</tr>
				<tr>
					<td><?php echo JText::_('SALDO');?></td>
					<td><?php echo $datosUsuario->balance;?></td>
				</tr>
				<tr>
					<td>Financiamientos</td>
					<td>1,700</td>
				</tr>
				<tr>
					<td>Inversiones</td>
					<td>150</td>
				</tr>
				<tr>
					<td>Valor de cartera</td>
					<td>1850</td>
				</tr>
				<tr>
					<td>Retornos acumulados</td>
					<td>374</td>
				</tr>
				<tr>
					<td>Utilidad acumulada</td>
					<td>161</td>
				</tr>
			</table>
		</div>
		
		<div style="margin-top:20px;">
		<?php echo $tableHtml; ?>
		</div>
		<div class="espaciado">
		<input type="button" class="button" value="<?php echo JText::_('REGRESAR');  ?>" onClick="javascript:window.history.back();">
		</div>
</div>