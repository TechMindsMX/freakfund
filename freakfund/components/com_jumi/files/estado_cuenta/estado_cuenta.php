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
$fechaInicial 			= $app->input->get('fechaInicial', date('01-m-Y', strtotime($query_date)), 'string'); 	// Primer dia del mes
$fechaFinal 			= $app->input->get('fechaFinal', date('d-m-Y'), 'string' ); 							// Ultimo dia del mes
$token 					= JTrama::token();
$idMiddleware			= UserData::getUserMiddlewareId($usuario->id);
$datosUsuarioMiddleware = UserData::getUserBalance($idMiddleware->idMiddleware);
$datosUsuarioJoomla 	= UserData::datosGr($idMiddleware->idJoomla);
$txList 				= JTrama::getTransactions($idMiddleware->idMiddleware, $fechaInicial, $fechaFinal);
$descripcionTx			= array();
$sumaDepositos			= 0;
$sumaRetiros			= 0;
$retiro					= '';
$deposito				= '';
$periodo				= '';
$saldoFinalPeriodo		= '0';
$arreglodefechas		= array();
$mes_actual 			= explode("-",$fechaInicial);
$validacionSelect 		= $year == $mes_actual[2] ? $month : 13;

if(!isset($datosUsuarioJoomla)){
	$datosUsuarioJoomla->nomCalle = "";
	$datosUsuarioJoomla->noExterior = "";
	$datosUsuarioJoomla->perfil_colonias_idcolonias = "";
	$datosUsuarioJoomla->perfil_delegacion_iddelegacion = "";
	$datosUsuarioJoomla->perfil_estado_idestado = "";
	$datosUsuarioJoomla->perfil_codigoPostal_idcodigoPostal = "";
	$datosUsuarioJoomla->rfcRFC = "";
}

for($i=1; $i<=12; $i++){
	$fechas = new stdClass;
	$year1 = $year==$mes_actual[2]?$year:$mes_actual[2];
	$queryDate 			= $year1.'-'.$i;
	$fechas->fechaini	= date('01-m-Y', strtotime($queryDate)); // Primer dia del mes
	$fechas->fechafin	= date('t-m-Y', strtotime($queryDate)); // Ultimo dia del mes
	
	$arreglodefechas[] = $fechas;
}

$fechasJS = json_encode($arreglodefechas);
//definicion de campos del formulario
$action 	= JURI::BASE()."index.php?option=com_jumi&view=application&fileid=30"; 

$tableHtml 	= "<table class='table table-striped' id='edocta_table'>";
$tableHtml 	.= "	<tr id='cabezera'>";
$tableHtml 	.= "		<th>". JText::_('FECHA') ."<th />";
$tableHtml 	.= "		<th style='width:170px;'>". JText::_('STATEMENT_DESC') ."<th />";
$tableHtml 	.= "		<th class='magic_seal'>". JText::_('STATEMENT_REFERENCE') ."<th />";
$tableHtml 	.= "		<th style='text-align: right;'>". JText::_('STATEMENT_AMOUNT') ."<th />";
$tableHtml 	.= "		<th class='magic_seal' style='text-align: right;'>". JText::_('SALDO_FF') ."<th />";
$tableHtml 	.= "	</tr>";

if(!is_null($txList) && !empty($txList)){
	if($txList[0]->type == 'CREDIT'){
		$saldoInicialPeriodo = $txList[0]->balance - $txList[0]->amount;
	}elseif($txList[0]->type == 'DEBIT'){
		$saldoInicialPeriodo = $txList[0]->balance + $txList[0]->amount;
	}
	
	foreach ($txList as $obj) {
		 if (!in_array($obj->description, $descripcionTx)) {
		 	array_push($descripcionTx, $obj->description);
		 }
		
		//operaciones resumen de cuenta
		if($obj->type == 'DEBIT'){
			$sumaRetiros = $obj->amount + $sumaRetiros;
			$retiro =  '<span style="color:red;">$-'.number_format($obj->amount,2).'</span>';
			$deposito = '';
		}elseif(($obj->type == 'CREDIT')){
			$sumaDepositos = $obj->amount + $sumaDepositos;
			$deposito = '$<span>'.number_format($obj->amount,2).'</span>';
			$retiro = '';
		}
		//fin operaciones
		
		$obj->fechaFormat =  date('d-m-Y',($obj->timestamp/1000));
		
		if(!is_null($obj->bulkId)){
			$detailTransaction 	= JTrama::getDetailTransactions($obj->bulkId);
			$agregarmas 		= '<span class="showdetail"><img src="'.JURI::base().'/images/agregar.png" width="20" style="margin-top:-5px;" /></span>';
			$agregarmas			.= '<span class="hidedetail" style="display:none"><img src="'.JURI::base().'/images/quitar.png" width="20" style="margin-top:-5px;" /></span>';
			$detalleDescripcion	= '';
			$detalleReferencia	= '';
			$detalleRetiro		= '';
			
			if(count($detailTransaction) > 1){
				foreach ($detailTransaction as $key => $value) {
					$detalleDescripcion .= '<div style="display:none; margin-top: 5px;">'.JText::_('STATEMENT_'.$value->description).'</div>';
					$detalleReferencia	.= '<div style="display:none; margin-top: 5px;">'.$value->reference.'</div>';
					$detalleRetiro		.= '<div style="display:none; margin-top: 5px;">$-<span>'.number_format($value->amount,2).'</span></div>';
				}
			}else{
				$detalleDescripcion	= '';
				$detalleReferencia	= '';
				$detalleRetiro		= '';
				$agregarmas			= '';
			}
		}else{
			$detalleDescripcion	= '';
			$detalleReferencia	= '';
			$detalleRetiro		= '';
			$agregarmas			= '';
		}

		if( $obj->description == 'TRANSFER'){
			switch ($obj->type) {
				case 'CREDIT':
					$retiroAbono = JText::_('STATEMENT_TYPE_CREDIT');
					break;
				case 'DEBIT':
					$retiroAbono = JText::_('STATEMENT_TYPE_DEBIT');
					break;
				
				default:
					$retiroAbono = '';
					break;
			}
		}else{
			$retiroAbono = '';
		}
		$projectName = substr($obj->projectName, 0, 20);
		
		
				
		$tableHtml .= '<tr id="'.$obj->description.'">';
		$tableHtml .= '	<td class="mas-grandota">'.$obj->fechaFormat.$agregarmas.'<td />';
		$tableHtml .= '	<td>'.JText::_('STATEMENT_'.$obj->description).$retiroAbono.$detalleDescripcion;
		$tableHtml .= '	<h4 class="projectName">'.$projectName.'</h4><td />';
		$tableHtml .= '	<td class="magic_seal">'.$obj->reference.$detalleReferencia.'<td />';
		$tableHtml .= '	<td class="derecha">'.$retiro.$detalleRetiro.$deposito.'<td />';
		$tableHtml .= '	<td class="magic_seal derecha">$'.number_format($obj->balance, 2).'<td />';
		$tableHtml .= '</tr>';
	}
	
	$saldoFinalPeriodo = end($txList)->balance;
	
} else {
	$tableHtml .= '<tr><td>'.JText::_('BUSQUEDA_SIN_RESULTADOS').'</td></tr>';
}
$tableHtml .= "</table>";

$selectTipo = '<select name="tipo" id="filtroTipo">';
$selectTipo .=	"<option value='nada' selected>".JText::_('MOVEMENT_FILTER')."</option>";
foreach ($descripcionTx as $key => $value) {
	$selectTipo .=	"<option value='" .$value . "'>" . JText::_('STATEMENT_'.$value) . "</option>";
}
$selectTipo .='</select>';

$periodo = $fechaInicial.' al '.$fechaFinal;

$document->addScript('libraries/trama/js/jquery-ui.min.js', 'text/javascript', true, false);
$document->addScript("libraries/trama/js/jquery.ui.datepicker-es.js", 'text/javascript', true, false);
$document->addStyleSheet('libraries/trama/css/jquery-ui.css');

$fInicial	= explode('-', $fechaInicial);
$fFinal		= explode('-', $fechaFinal);
$fInicial	= $fInicial[2].','.(intval($fInicial[1])-1).','.$fInicial[0];
$fFinal		= $fFinal[2].','.(intval($fFinal[1])-1).','.$fFinal[0];;
?>

<script type="text/javascript">
	jQuery(function() {
		var fechaIni = new Date(<?php echo $fInicial;?>);
		
		jQuery.datepicker.setDefaults( jQuery.datepicker.regional[ "es" ] );
		
	 	jQuery( "#fechaInicial" ).datepicker({
	    	dateFormat: "dd-mm-yy",
	 		minDate: "-1y",
	 		maxDate: 0,
	 		defaultDate: fechaIni,
	 		setDate: fechaIni,
			onSelect: function(selectedDate) {
				var fecha 	= jQuery(this).datepicker("getDate");
				var fecha1	= new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() +1 )
				jQuery( "#fechaFinal" ).datepicker("option", "minDate", fecha1 );
				jQuery( "#fechaFinal").prop('disabled', false);
				jQuery(this).validationEngine('validate');
			}
		});
		
	 	jQuery( "#fechaFinal" ).datepicker({
	    	dateFormat: "dd-mm-yy",
	 		minDate: "-1y",
	 		maxDate: 0,
	 		altField: "#fechaFinal",
			onSelect: function(selectedDate) {
				var fecha 	= jQuery(this).datepicker("getDate");
				var fecha1	= new Date(fecha.getFullYear(), fecha.getMonth(), fecha.getDate() -1 )
				jQuery( "#fechaInicial" ).datepicker("option", "maxDate", fecha1 );
				jQuery( "#fechaInicial").prop('disabled', false);
				jQuery(this).validationEngine('validate');
			}
		});
		
		jQuery( "#fechaInicial" ).datepicker('setDate', fechaIni);
		jQuery( "#fechaFinal" ).datepicker('setDate', new Date(<?php echo $fFinal; ?>));

    	jQuery( "#fechaInicial, #fechaFinal" ).prop('readonly', 'readonly');
	});

var objFechas = <?php echo $fechasJS; ?>;

jQuery(document).ready(function(){
	
	jQuery("#form_cuenta").validationEngine();
	
	jQuery('#selectFechas').val('<?php echo $mes_actual[1]-1; ?>');//pone al select de los meses el mes corriente
	
	//Filtra el contenido segun el select
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
	
	//Muestra el detalle de la fila 
	jQuery('.showdetail').click(function(){
		jQuery(this).hide();
		jQuery(this).parent().next().next().children('div').show();
		jQuery(this).parent().next().next().next().next().children('div').show();
		jQuery(this).parent().next().next().next().next().next().next().children('div').show();
		jQuery(this).next().show();
	});
	
	//Oculta el detalle de la fila
	jQuery('.hidedetail').click(function(){
		jQuery(this).hide();
		jQuery(this).parent().next().next().children('div').hide();
		jQuery(this).parent().next().next().next().next().children('div').hide();
		jQuery(this).parent().next().next().next().next().next().next().children('div').hide();
		jQuery(this).prev().show()
	});

});
</script>
<h1><?php echo JText::_('ESTADO_CUENTA');  ?></h1>
<div id="detalles_busq">
	<div style="float:left; width:40%;" >
		<table  id="datos_usuario">
			<tr>
				<td colspan="3" ><h3><?php echo JFactory::getUser($idMiddleware->idJoomla)->name;?></h3></td>
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
				<td><?php echo JText::_('LBL_CP');?>: <?php echo $datosUsuarioJoomla->perfil_codigoPostal_idcodigoPostal?></td>
				
			</tr>
			<tr>
				<td>RFC: <?php echo $datosUsuarioJoomla->rfcRFC?></td>
			</tr>
			<tr>
				<td colspan="3"><?php echo JText::_('FORM_ALTA_TRASPASOS_CLABEFF'); ?>   <strong><?php echo $datosUsuarioMiddleware->account?></strong></td>
			</tr>
		</table>
	</div>
	
	<div id="resumen_cuentas">
		<table class='table '>
			<th colspan="2" style="text-align: center;"><?php echo JText::_('RESUMEN_CUENTAS');?></th>
			<tr>
				<td><?php echo JText::_('SALDO_INICIAL_PERIODO');?></td>
				<td class="derecha">$<?php echo number_format(@$saldoInicialPeriodo,2); ?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SUMATORIA_DEPOSITOS');?></td>
				<td class="derecha">$<?php echo number_format(@$sumaDepositos, 2); ?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SUMATORIA_RETIROS');?></td>
				<td class="derecha">$<span style="color:red;"><?php echo number_format(@$sumaRetiros,2); ?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('SALDO_FINAL_PERIODO');?></td>
				<td class="derecha">$<?php echo number_format(@$saldoFinalPeriodo,2); ?></span></td>
			</tr>
			<tr>
				<td><?php echo JText::_('PERIODO_FECHA_INI_FIN');?></td>
				<td class="derecha"><?php echo @$periodo ?></td>
			</tr>
		</table>
	</div>
	
	<div  style="width:100%; float:left;">
	<h1><?php echo JText::_('RANGE_SEARCH'); ?></h1>
		<form id="form_cuenta" action="<?php echo $action; ?>" method="post">
			<select id="selectFechas" name="" >
				<option value="0" <?php echo ($validacionSelect-1) 	<	0	?'disabled="disabled"':''; ?>><?php echo JText::_('JANUARY'); ?></option>
				<option value="1" <?php echo ($validacionSelect-1) 	<	1	?'disabled="disabled"':''; ?>><?php echo JText::_('FEBRUARY'); ?></option>
				<option value="2" <?php echo ($validacionSelect-1) 	<	2	?'disabled="disabled"':''; ?>><?php echo JText::_('MARCH'); ?></option>
				<option value="3" <?php echo ($validacionSelect-1) 	<	3	?'disabled="disabled"':''; ?>><?php echo JText::_('APRIL'); ?></option>
				<option value="4" <?php echo ($validacionSelect-1) 	<	4	?'disabled="disabled"':''; ?>><?php echo JText::_('MAY'); ?></option>
				<option value="5" <?php echo ($validacionSelect-1) 	<	5	?'disabled="disabled"':''; ?>><?php echo JText::_('JUNE'); ?></option>
				<option value="6" <?php echo ($validacionSelect-1) 	<	6	?'disabled="disabled"':''; ?>><?php echo JText::_('JULY'); ?></option>
				<option value="7" <?php echo ($validacionSelect-1) 	<	7	?'disabled="disabled"':''; ?>><?php echo JText::_('AUGUST'); ?></option>
				<option value="8" <?php echo ($validacionSelect-1) 	<	8	?'disabled="disabled"':''; ?>><?php echo JText::_('SEPTEMBER'); ?></option>
				<option value="9" <?php echo ($validacionSelect-1) 	<	9	?'disabled="disabled"':''; ?>><?php echo JText::_('OCTOBER'); ?></option>
				<option value="10" <?php echo ($validacionSelect-1) <	10	?'disabled="disabled"':''; ?>><?php echo JText::_('NOVEMBER'); ?></option>
				<option value="11" <?php echo ($validacionSelect-1)	<	11	?'disabled="disabled"':''; ?>><?php echo JText::_('DECEMBER'); ?></option>
			</select>
			<div>			
				<?php echo JText::_('RANGO_FECHA_INICIO');  ?>
			</div>
			<div>
				<input placeholder="DD-MM-AAAA" class="validate[custom[date]] ui-datepicker" type="text" name="fechaInicial" id="fechaInicial">
	  		</div>
	  		<div>
	  			<?php echo JText::_('RANGO_FECHA_FIN');  ?> 
	  		</div>
	  		<div>
	  			<input placeholder="DD-MM-AAAA" class="validate[custom[date]] ui-datepicker" type="text" name="fechaFinal" id="fechaFinal">
			</div>
				<input type="submit" class="button" value="<?php echo JText::_('CONSULT_BUTTON'); ?>" />
		</form>
	</div>
	
	<div style="clear:both"></div>
	<h1><?php echo JText::_('TRANSACTION_DETAIL'); ?></h1>
		<div>
		<?php echo $selectTipo; ?>
	</div>	
	
		<div style="margin-top:20px;">
		<?php echo $tableHtml; ?>
		</div>
		<div class="espaciado">
		<input type="button" class="button" value="<?php echo JText::_('IR_A_CARTERA');  ?>" onClick="window.location.href='index.php?option=com_jumi&view=application&fileid=24&Itemid=218'">
		</div>
</div>