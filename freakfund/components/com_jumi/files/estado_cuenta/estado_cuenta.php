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
jimport('trama.usuario_class');
require_once 'components/com_jumi/files/classIncludes/libreriasPP.php';

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token 			= JTrama::token();
$idMiddleware	= UserData::getUserMiddlewareId($usuario->id);
$datosUsuario 	= UserData::getUserBalance($idMiddleware->idMiddleware);

//definicion de campos del formulario
$action = '#';

include_once ("objetote.php");

$tableHtml = "<table class='table table-striped' id='edocta_table'>";
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
	$tableHtml .= '<tr id="'.$obj->tipo.'">';
	$tableHtml .= '<td>'.$obj->fecha. '<td />';
	$tableHtml .= '<td>'.$obj->movimiento.'<td />';
	$tableHtml .= '<td>'.$obj->tipo.'<td />';
	$tableHtml .= '<td>'.$obj->detalle.'<td />';
	$tableHtml .= '<td>'.$obj->referencia.'<td />';
	$tableHtml .= '<td>'.$obj->institucion.'<td />';
	$tableHtml .= '<td>'.$obj->tasa.'<td />';
	$tableHtml .= '<td>'.$obj->cantidad.'<td />';
	$tableHtml .= '<td>$<span class="number">'.$obj->unitario.'</span><td />';
	$tableHtml .= '<td>$<span class="number">'.$obj->subtotal.'</span><td />';
	$tableHtml .= '<td>$<span class="number">'.$obj->saldo.'</span><td />';
	$tableHtml .= '<td>'.$obj->notas.'<td />';
	$tableHtml .= '</tr>';
}

foreach ($arregloCatalogo as $obj) {
	$selectTipo .=	"<option value='" .$obj->name . "'>" .$obj->name . "</option>";
}

$tableHtml .= "</table>";
$selectTipo .='</select>';

echo '<script src="'.$base.'libraries/trama/js/jquery.number.min.js"> </script>';

?>

<script>
	jQuery(document).ready(function(){
		jQuery("#form_cuenta").validationEngine();
		jQuery("span.number").number(true,2,',','.');
		
		jQuery('#filtroTipo').change(function(){
			var limite = jQuery('#edocta_table tr').length;

			if(this.value == 'nada'){
			    jQuery('#edocta_table tr').show();
			}else{
			    var variable=this.value;			    

	           	jQuery('#edocta_table tr').hide();
		       	jQuery('#edocta_table tr#'+variable).show();	
		    	jQuery('#edocta_table tr#cabezera').show();		    
			}	
		});
	});
</script>
<h1><?php echo JText::_('ESTADO_CUENTA');  ?></h1>
<div>
	<div>
		<table class='table table-striped' id="datos_usuario">
			<tr>
				<td><?php echo JText::_('SOCIO');?></td>
				<td><?php echo JFactory::getUser($idMiddleware->idJoomla)->name;?></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SALDO');?></td>
				<td>$<span class="number"><?php echo $datosUsuario->balance;?></span></td>
			</tr>
			<tr>
				<td>Financiamientos</td>
				<td>$<span class="number"><?php echo $sumaFinanciamientos;?></span></td>
			</tr>
			<tr>
				<td>Inversiones</td>
				<td>$<span class="number"><?php echo $sumaInversiones;?></span></td>
			</tr>
			<tr>
				<td>Valor de cartera</td>
				<td>$<span class="number"><?php echo $valorCartera;?></span></td>
			</tr>
			<tr>
				<td>Retornos acumulados</td>
				<td>$<span class="number"><?php echo $sumaRetornos;?></span></td>
			</tr>
			<tr>
				<td>Utilidad acumulada</td>
				<td>$<span class="number"><?php echo $sumaUtilidad;?></span></td>
			</tr>
		</table>
	</div>

	<form id="form_cuenta" action="<?php echo $action; ?>" method="POST">
	
		<select name="fechas" >
			  <option value="Enero"><?php echo JText::_('JANUARY'); ?></option>
			  <option value="Febrero"><?php echo JText::_('FEBRUARY'); ?></option>
			  <option value="Marzo"><?php echo JText::_('MARCH'); ?></option>
			  <option value="Abril"><?php echo JText::_('APRIL'); ?></option>
			  <option value="Mayo"><?php echo JText::_('MAY'); ?></option>
			  <option value="Junio"><?php echo JText::_('JUNE'); ?></option>
			  <option value="Julio"><?php echo JText::_('JULY'); ?></option>
			  <option value="Agosto"><?php echo JText::_('AUGUST'); ?></option>
			  <option value="Septiembre"><?php echo JText::_('SEPTEMBER'); ?></option>
			  <option value="Octubre"><?php echo JText::_('OCTOBER'); ?></option>
			  <option value="Noviembre"><?php echo JText::_('NVEMBER'); ?></option>
			  <option value="Diciembre"><?php echo JText::_('DECEMBER'); ?></option>
		</select>
					
		<?php echo JText::_('RANGO_FECHA_INICIO');  ?> <input placeholder="DD-MM-AAAA" class="validate[custom[date]]" type="text" name="fechaini">
  		<?php echo JText::_('RANGO_FECHA_FIN');  ?> <input placeholder="DD-MM-AAAA" class="validate[custom[date]]" type="text" name="fechafin">
		
		<input type="button" class="button" value="Consultar" />
		
	</form>
		<?php echo $selectTipo; ?>
		
		<div style="margin-top:20px;">
		<?php echo $tableHtml; ?>
		</div>
		<div class="espaciado">
		<input type="button" class="button" value="<?php echo JText::_('REGRESAR');  ?>" onClick="javascript:window.history.back();">
		</div>
</div>