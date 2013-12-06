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

$year 					= date('Y');
$month 					= date('m');
$query_date 			= $year.'-'.$month;
$fecha_inicial 			= $app->input->get('fechaInicial', date('01-m-Y', strtotime($query_date)), 'string'); // Primer dia del mes
$fechaFinal 			= $app->input->get('fechaFinal', date('t-m-Y', strtotime($query_date)), 'string' ); // Ultimo dia del mes
$token 					= JTrama::token();
$idMiddleware			= UserData::getUserMiddlewareId($usuario->id);
$datosUsuarioMiddleware = UserData::getUserBalance($idMiddleware->idMiddleware);
$datosUsuarioJoomla 	= UserData::datosGr($idMiddleware->idJoomla);
$projectList 			= JTrama::getTransactions($idMiddleware->idMiddleware, $fecha_inicial, $fechaFinal);
$descripcionTx			= array();
$sumaDepositos			= 0;
$sumaRetiros			= 0;
$retiro					= '';
$deposito				= '';
$periodo				= '';
$saldoFinalPeriodo		= '0';
$arreglodefechas		= array();

for($i=1; $i<=12; $i++){ //for](inicio; hasta; incremento)
	$fechas = new stdClass;
	$queryDate 			= $year.'-'.$i;
	$fechas->fechaini	= date('01-m-Y', strtotime($queryDate)); // Primer dia del mes
	$fechas->fechafin	= date('t-m-Y', strtotime($queryDate)); // Ultimo dia del mes
	
	$arreglodefechas[] = $fechas;
}
$fechasJS = json_encode($arreglodefechas);
//definicion de campos del formulario
$action 	= JURI::BASE()."index.php?option=com_jumi&view=application&fileid=30"; 
$tableHtml 	= "<table class='table table-striped' id='edocta_table'>";
$tableHtml 	.= "<tr id='cabezera'>";
$tableHtml 	.= "<th>Fecha<th />";
$tableHtml 	.= "<th>Descripción<th />";
$tableHtml 	.= "<th>Referencia<th />";
$tableHtml 	.= "<th>Retiro/Cargo<th />";
$tableHtml 	.= "<th>Depósito/Abono<th />";
$tableHtml 	.= "<th>Saldo<th />";
$tableHtml 	.= "</tr>";

$selectTipo = '<select name="tipo" id="filtroTipo">';
$selectTipo .=	"<option value='nada' selected>Sin Filtro</option>";

$descripcionTx['CREDIT'] 	= 'Deposito';
$descripcionTx['TRANSFER']	= 'Transferencia';
$descripcionTx['FUNDING']	= 'Financiamiento';

if(!is_null($projectList) && !empty($projectList)){
	if($projectList[0]->type == 'DEBIT'){
		$saldoInicialPeriodo = $projectList[0]->balance - $projectList[0]->amount;
	}elseif($projectList[0]->type == 'DEBIT'){
		$saldoInicialPeriodo = $projectList[0]->balance + $projectList[0]->amount;
	}
	
	foreach ($projectList as $obj) {
		//operaciones resumen de cuenta
		if($obj->type == 'DEBIT'){
			$sumaRetiros = $obj->amount + $sumaRetiros;
			$retiro =  '$<span style="color:red;" class="number">'.$obj->amount.'</span>';
			$deposito = '';
		}elseif(($obj->type == 'CREDIT')){
			$sumaDepositos = $obj->amount + $sumaDepositos;
			$deposito = '$<span class="number">'.$obj->amount.'</span>';
			$retiro = '';
		}
		
		//fin operaciones
		$obj->fechaFormat =  date('d-m-Y',($obj->timestamp/1000));
		
		$tableHtml .= '<tr id="'.$obj->description.'">';
		$tableHtml .= '<td>'.$obj->fechaFormat. '<td />';
		$tableHtml .= '<td>'.$descripcionTx[$obj->description].'<td />';
		$tableHtml .= '<td>'.$obj->reference.''.$obj->timestamp.'<td />';
		$tableHtml .= '<td>'.$retiro.'<td />';
		$tableHtml .= '<td>'.$deposito.'<td />';
		$tableHtml .= '<td>$<span class="number">'.$obj->balance.'</span><td />';
		$tableHtml .= '</tr>';
	}
	
	$periodo = $fecha_inicial.' al '.$fechaFinal;
	$saldoFinalPeriodo = end($projectList)->balance;
}
foreach ($descripcionTx as $key => $value) {
	$selectTipo .=	"<option value='" .$key . "'>" .$value . "</option>";
}

$tableHtml .= "</table>";
$selectTipo .='</select>';

?>

<script>
var objFechas = <?php echo $fechasJS; ?>;

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
	
	jQuery('#selectFechas').change(function(){
		console.log(jQuery(this).val());
		if(jQuery(this).val() != 'a'){
			jQuery('#fechaInicial').val(objFechas[jQuery(this).val()].fechaini);
			jQuery('#fechaFinal').val(objFechas[jQuery(this).val()].fechafin);
		}else{
			jQuery('#fechaInicial').val('');
			jQuery('#fechaFinal').val('');
		}
	});
});
</script>
<h1><?php echo JText::_('ESTADO_CUENTA');  ?></h1>
<div>
<div style="width:100%; float:left;">
	<form id="form_cuenta" action="<?php echo $action; ?>" method="post">
	
		<select id="selectFechas" name="" >
			<option value="a" selected="selected"><?php echo JText::_('SELECCIONEOPCION'); ?></option>
			<option value="0"><?php echo JText::_('JANUARY'); ?></option>
			<option value="1"><?php echo JText::_('FEBRUARY'); ?></option>
			<option value="2"><?php echo JText::_('MARCH'); ?></option>
			<option value="3"><?php echo JText::_('APRIL'); ?></option>
			<option value="4"><?php echo JText::_('MAY'); ?></option>
			<option value="5"><?php echo JText::_('JUNE'); ?></option>
			<option value="6"><?php echo JText::_('JULY'); ?></option>
			<option value="7"><?php echo JText::_('AUGUST'); ?></option>
			<option value="8"><?php echo JText::_('SEPTEMBER'); ?></option>
			<option value="9"><?php echo JText::_('OCTOBER'); ?></option>
			<option value="10"><?php echo JText::_('NOVEMBER'); ?></option>
			<option value="11"><?php echo JText::_('DECEMBER'); ?></option>
		</select>
					
		<?php echo JText::_('RANGO_FECHA_INICIO');  ?>
		<input placeholder="DD-MM-AAAA" class="validate[custom[date]]" type="text" name="fechaInicial" id="fechaInicial">
  		<?php echo JText::_('RANGO_FECHA_FIN');  ?> 
  		<input placeholder="DD-MM-AAAA" class="validate[custom[date]]" type="text" name="fechaFinal" id="fechaFinal">
		
		<input type="submit" class="button" value="Consultar" />
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
				<td colspan="3">Número de cuenta: <strong><?php echo $datosUsuarioMiddleware->account?></strong></td>
			</tr>
		</table>
	</div>
	
	
	<div style="float:right; width:40%;">
		<table class='table '>
			<th colspan="2" style="text-align: center;"><?php echo JText::_('RESUMEN_CUENTAS');?></th>
			<tr>
				<td><?php echo JText::_('SALDO_INICIAL_PERIODO');?></td>
				<td>$<span class="number"><?php echo $saldoInicialPeriodo?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SUMATORIA_DEPOSITOS');?></td>
				<td>$<span class="number"><?php echo $sumaDepositos;?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SUMATORIA_RETIROS');?></td>
				<td>$<span style="color:red;" class="number"><?php echo $sumaRetiros;?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SALDO_FINAL_PERIODO');?></td>
				<td>$<span class="number"><?php echo $saldoFinalPeriodo; ?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('PERIODO_FECHA_INI_FIN');?></td>
				<td><?php echo $periodo ?></td>
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