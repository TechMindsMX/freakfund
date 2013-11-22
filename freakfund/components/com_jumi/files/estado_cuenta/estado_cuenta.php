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
require_once 'libraries/trama/libreriasPP.php';

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token 					= JTrama::token();
$idMiddleware			= UserData::getUserMiddlewareId($usuario->id);
$datosUsuarioMiddleware = UserData::getUserBalance($idMiddleware->idMiddleware);
$datosUsuarioJoomla 	= UserData::datosGr($idMiddleware->idJoomla);



//definicion de campos del formulario
$action = '#';

include_once ("objetote.php");

$tableHtml = "<table class='table table-striped' id='edocta_table'>";
$tableHtml .= "<tr id='cabezera'>";
$tableHtml .= "<th>Fecha<th />";
$tableHtml .= "<th>Descripción<th />";
$tableHtml .= "<th>Referencia<th />";
$tableHtml .= "<th>Retiro/Cargo<th />";
$tableHtml .= "<th>Depósito/Abono<th />";
$tableHtml .= "<th>Saldo<th />";
$tableHtml .= "</tr>";

$selectTipo = '<select name="tipo" id="filtroTipo">';
$selectTipo .=	"<option value='nada' selected>Sin Filtro</option>";

foreach ($arregloobjetos as $obj) {
	$algo1 = ($obj->withdraw != '')? '$<span style="color:red;" class="number">'.$obj->withdraw.'</span>' : ' ';
	$algo2 = ($obj->deposit != '')? '$<span class="number">'.$obj->deposit.'</span>' : ' ';
	
	$tableHtml .= '<tr id="'.$obj->tipo.'">';
	$tableHtml .= '<td>'.$obj->date. '<td />';
	$tableHtml .= '<td>'.$obj->reference.'<td />';
	$tableHtml .= '<td>'.$obj->description.'<td />';
	$tableHtml .= '<td>'.$algo1.'<td />';
	$tableHtml .= '<td>'.$algo2.'<td />';
	$tableHtml .= '<td>$<span class="number">'.$obj->currentBalance.'</span><td />';
	$tableHtml .= '</tr>';
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

	           	jQuery('#edocta_table tr').hide();
		       	jQuery('#edocta_table tr#'+variable).show();	
		    	jQuery('#edocta_table tr#cabezera').show();		    
			}	
		});
	});
</script>
<h1><?php echo JText::_('ESTADO_CUENTA');  ?></h1>
<div>
<div style="width:100%; float:left;">
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
	</div>
	<div style="float:left; width:40%;" >
		<table  id="datos_usuario">
			<tr>
			
				<td colspan="3" ><strong><?php echo JFactory::getUser($idMiddleware->idJoomla)->name;?></strong></td>
			</tr>
			<tr>
				<td ><?php echo $datosUsuarioJoomla->nomCalle?></td>
				<td >No. <?php echo $datosUsuarioJoomla->noExterior?></td>
				<td >Int. <?php echo isset($datosUsuarioJoomla->noInterior)? $datosUsuarioJoomla->noInterior : '';?></td>
				
			</tr>
			<tr>
				<td>Col.<?php echo $datosUsuarioJoomla->perfil_colonias_idcolonias?></td>
				<td>Del.<?php echo $datosUsuarioJoomla->perfil_delegacion_iddelegacion?></td>
			</tr>
			<tr>
				
				<td><?php echo $datosUsuarioJoomla->perfil_estado_idestado?></td>
				<td><?php echo JText::_('CP');?>: <?php echo $datosUsuarioJoomla->perfil_codigoPostal_idcodigoPostal?></td>
				
			</tr>
			<tr>
				<td>RFC: <?php echo $datosUsuarioJoomla->rfcRFC?></td>
			</tr>
			<tr>
				<td colspan="3">Número de cuenta: <strong>34639278457868943</strong></td>
			</tr>
		</table>
	</div>
	<div style="float:right; width:40%;">
		<table class='table '>
			<th colspan="2" style="text-align: center;"><?php echo JText::_('RESUMEN_CUENTAS');?></th>
			<tr>
				<td><?php echo JText::_('SALDO_INICIAL_PERIODO');?></td>
				<td>$<span class="number"><?php echo $datosUsuarioMiddleware->balance;?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SUMATORIA_DEPOSITOS');?></td>
				<td>$<span class="number"><?php echo $sumaFinanciamientos;?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SUMATORIA_RETIROS');?></td>
				<td>$<span style="color:red;" class="number"><?php echo $sumaInversiones;?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SALDO_FINAL_PERIODO');?></td>
				<td>$<span class="number"><?php echo $valorCartera;?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('PERIODO_FECHA_INI_FIN');?></td>
				<td>06/2013  al  07/2013</td>
			</tr>
		</table>
	</div>
	<div style="clear:both"></div>
		<div>
	</form>
		<?php echo $selectTipo; ?>
	</div>	
		<div style="margin-top:20px;">
		<?php echo $tableHtml; ?>
		</div>
		<div class="espaciado">
		<input type="button" class="button" value="<?php echo JText::_('REGRESAR');  ?>" onClick="javascript:window.history.back();">
		</div>
</div>