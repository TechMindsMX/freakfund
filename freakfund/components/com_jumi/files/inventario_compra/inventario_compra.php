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
jimport("trama.usuario_class");
jimport("trama.error_class");
require_once 'libraries/trama/libreriasPP.php';
//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token 			= JTrama::token();
$input 			= JFactory::getApplication()->input;
$usuario		= JFactory::getUser();
$idMiddleware   = UserData::getUserMiddlewareId($usuario->id);
$usuario->data	= UserData::getUserBalance($idMiddleware->idMiddleware);
$proyid			= $input->get("proyid",0,"int");
$pro			= JTrama::getDatos($proyid);

if(!JTrama::checkValidStatus($pro)) {
	$returnUrl = $_SERVER['HTTP_REFERER'];
	$app->redirect($returnUrl, JText::sprintf('JGLOBAL_NO_ACEPTA_COMPRAS', $pro->name), 'error');
}

$datosUsuario	= UserData::getUserBalance($idMiddleware->idMiddleware);
$saldo 			= $datosUsuario->balance == null ? 0: $datosUsuario->balance;
$uri 			=& JFactory::getURI();
$callback 		= $uri->toString().'&appId=27';
$response		= $input->get("response",0,"int"); // RESPUESTA EXITO
$error			= $input->get("error",0,"int");
$from			= $input->get("appId",0,"int");
$confirm		= $input->get("confirm", 0, "int");

if($confirm == 0){
	$action		= JURI::base().'index.php?option=com_jumi&view=appliction&fileid=27&proyid='.$proyid.'&confirm=1';
}else{
	$action		= MIDDLE.PUERTO.'/trama-middleware/rest/project/consumeUnits';
}

$detalleInversion =  JTrama::getInvestmentDetail($response);
errorClass::manejoError($error, $from, $proyid);
?>
<script>
jQuery(document).ready(function(){
	
		var $scrollingDiv = $("#scrollingDiv");
 
		jQuery(window).scroll(function(){			
			$scrollingDiv
				.stop()
				.animate({"marginTop": ($(window).scrollTop() + 30) + "px"}, "slow" );			
		});
});
</script>
<?php
if($confirm == 0){
	if ($error === 0 && $response === 0) {
?>
	
	<script>
	
	jQuery(document).ready(function(){
		function formatoNumero() {
			jQuery("span.number").number( true, 2 );
		}
		
		jQuery("#form_compra").validationEngine();
		
		jQuery('#guardar').prop('disabled', true);
		
		function formatoNumero() {
			jQuery("span.number").number( true, 2 );
		}
		
		function sumaarrecha(){
			 var precio = 0;
			 var cant 	= 0;
			 var total 	= 0 ;
			 jQuery("#form_compra").find("tr.wrapper").each(function() {
				 precio = parseFloat(jQuery(this).find('#precio').val()) || 0;
				 cant = parseFloat(jQuery(this).find('input.input_compra').val()) || 0;
				 total += precio * cant;
				 jQuery("#resultadoglobal").text(total);
			});			
				 
			if ( total > 0 && <?php echo $saldo ?> > total ) {
				jQuery('#guardar').prop('disabled', false);
			} else {
				jQuery('#guardar').prop('disabled', true);
			}
		}
		jQuery(':input').change(function(){		
			var limite = parseInt(jQuery(this).prev().prev().val());

			if ( jQuery(this).val()>limite){
				jQuery(this).val(0);
				jQuery(this).next().children().text(0);
				alert('Cantidad superior a inventario');
	
				sumaarrecha();
				
				formatoNumero();
			}else{
				var val_uni = parseFloat(jQuery(this).parent().find('#precio').val());
				var resultado = val_uni * jQuery(this).val();
	
				jQuery(this).parent().next().children().children().text(resultado);
				
				
				sumaarrecha();			
				
				if ( jQuery(this).val() > 0 ) {
					var nombre = jQuery(this).attr('id');
					jQuery(this).attr('name', nombre);
				} else {
					jQuery(this).attr('name', '');
				}
				
				formatoNumero();
			}
			
		});
		function habilitarCompra() {
			var total = sumaarrecha();
				
			if ( total > 0 && <?php echo $saldo ?> > total ) {
				jQuery('#guardar').prop('disabled', false);
			} else {
				jQuery('#guardar').prop('disabled', true);
			}
		}
		
		jQuery('#guardar').click(function() {
				jQuery("#form_compra").validationEngine();
				jQuery("#form_compra").submit();
			
		});
	});
	</script>
	
	<h1><?php echo JText::_('INVENTARIO_COMPRA');  ?></h1>
	<?php
	echo '<h3>'. $usuario->name .'</h3>
		      <div>'.JText::_('SALDO_FF').':$ <span class="number">'. $saldo .'</span>
		      </div>';
	?>
	<h2><?php echo $pro->name; ?></h2>
	<div>
		<form id="form_compra" action="<?php echo $action; ?>" method="POST">
		<table class="table table-striped">
			<tr>
				<th><?php echo JText::_('LBL_SECCION'); ?></th>
				<th style="text-align: right;"><?php echo JText::_('PRECIO_UNIDAD'); ?></th>
				<th style="text-align: right;"><?php echo JText::_('CANTIDAD_A_COMPRAR'); ?></th>
				<th style="text-align: right;"><?php echo JText::_('COMPRA_SUBTOTAL'); ?></th>
			</tr>
			<?php
			
			$html = '<input type="hidden" name="userId" id="userId" value="'. $idMiddleware->idMiddleware .'" />
					<input type="hidden" name="projectId" id="projectId" value="'. $pro->id .'" />';
		
			foreach ($pro->projectUnitSales as $key => $value){
		
				$html .= '
						<tr class="wrapper">
						<td>'. $value ->section .'</td>
						<td style="text-align: right;"> $<span class="number valor_unidad">'. $value ->unitSale.'</span></td>
						<td style="text-align: right;"><input id="" type="hidden" value="'.$value ->unit.'"/>
						<input id="precio" type="hidden" value="'.$value ->unitSale.'"/>
						<input class="input_compra validate[custom[onlyNumberSp]]" type="number" id="'.$value->id.'" name="" /></td>
						<td style="text-align: right; width: 315px;"><div>'.JText::_('TOTAL_SECCION').':$ '.'<span class="number" id="resultados"></span></div></td>
						</tr>';
			}
			$html .= '<tr><td style="text-align: right;" colspan="3"><div><strong>'.JText::_('TOTAL_PAGAR').'</strong></td><td style="text-align: right;">$<strong><span class="number" id="resultadoglobal"></span><strong></div></td></tr></table>';
			$html .= '<input type="hidden" name="callback" value="'. $callback .'" />
					<input type="hidden" name="token" value="'. $token .'" />
					<div style="margin: 10px;">
						<input type="button" class="button" value="'.JText::_('LBL_CANCELAR').'" onclick="history.go(-1);" />
						<input type="button" id="guardar" class="button" value="'.JText::_('INVERTIR_PROYECTO').'"  />
						
					</div>';
	
				echo $html;
				
				
			?>
			
		</form>
		
	</div>
	
	<?php
	} else {
		$totalCompra = 0;
		
		$html = '<h1>'.JText::_('COMPRA_SUCCESS_DETAILS').'</h1>
				<h3>'.$usuario->name.'</h3>
				<div>'.JText::_('SALDO_FF').': $<span class="number">'. $saldo .'</span></div>
				<p>'.JText::_('COMPRA_SUCCESS').'</p>
				<div class="detalles_tx">
					<h2>'.$pro->name.'</h2>
					<span>'.JText::_('COMPRA_TX_ID').' : </span>'.$response.'
					<table class="table table-striped">
						<tr>
							<th>'.JText::_('LBL_SECCION').'</th>
							<th style="text-align: right;">'.JText::_('PRECIO_UNIDAD').'</th>
							<th style="text-align: right;">'.JText::_('CANTIDAD_COMPRADAS').'</th>
							<th style="text-align: right;">'.JText::_('COMPRA_SUBTOTAL').'</th>
						</tr>';
		foreach ($detalleInversion as $key => $value) {
	
			$cant = $value->quantity;
			$subtotal = $value->unitSale*$cant;
			$totalCompra = $totalCompra + $subtotal;
			
			$html .=	'<tr>
							<td>'.$value->section.'</td>
							<td style="text-align:right">$<span class="number">'.$value->unitSale.'</span></td>
							<td style="text-align:right">'.$cant.'</td>
							<td style="text-align:right">$<span class="number">'.$subtotal.'</span></td>
						</tr>';
		}
		
		$html .=	'<tr>
						<td colspan="3" style="text-align: right;"><strong>'.JText::_('TOTAL').'</strong></td>
						<td style="text-align:right"><b>$<span class="number">'.$totalCompra.'</span></b></td>
					</tr>
					</table>
					<a class="button" href="index.php?option=com_jumi&view=application&fileid=24&Itemid=218">'.JText::_('ESCRIT').'</a>
					
					</div>
					';
		echo $html;
	}
}else{
	$recaudado = 0;
		
	$params = $input->getArray($_POST);
?>
	<form id="form_compra" action="<?php echo $action; ?>" method="POST">
		<input type="hidden" name="userId" value="<?php echo $params['userId']; ?>"/>
		<input type="hidden" name="projectId" value="<?php echo $params['projectId']; ?>"/>
		<input type="hidden" name="callback" value="<?php echo $params['callback']; ?>"/>
		<input type="hidden" name="token" value="<?php echo $token; ?>"/>
		
		<h1><?php echo JText::_('INVENTARIO_COMPRA_SCREENCONFIRM_TITTLE'); ?></h1>
		<h3><?php echo $usuario->name; ?></h3>
		<div><?php echo JText::_('SALDO_FF')?> : $<span class="number"><?php echo $saldo ?></span></div>
		<h2><?php echo $pro->name ?> </h2>
		
		<table class="table table-striped">
			<tr>
				<th><?php echo JText::_('LBL_SECCION'); ?></th>
				<th style="text-align: right;"><?php echo JText::_('PRECIO_UNIDAD'); ?></th>
				<th style="text-align: right;"><?php echo JText::_('CANTIDAD_A_COMPRAR'); ?></th>
				<th style="text-align: right;"><?php echo JText::_('COMPRA_SUBTOTAL'); ?></th>
			</tr>
			<?php
				$total = 0;
				foreach ($pro->projectUnitSales as $key => $value) {

					foreach ($params as $indice => $valor) {

						
						
						if($indice == $value->id){

							$total = ($value->unitSale*$valor) + $total;
			?>
						<tr>
							<td><?php echo $value->section; ?></td>
							<td style="text-align: right;">
								$<span class="number"><?php echo $value->unitSale; ?></span>
							</td>
							<td style="text-align: center;">
								<?php echo $valor; ?>
							</td>
							<td style="text-align: right;">$<span class="number">
								<?php echo $value->unitSale*$valor; ?></span>
								<input type="hidden" value="<?php echo $valor; ?>" name="<?php echo $value->id; ?>" />
							</td>
						</tr>
			<?php					
						}	
					}
				} 
			?>	
		<tr>
			<td colspan="3" style="text-align: right;"><strong><?php echo JText::_('TOTAL_PAGAR'); ?></strong></td>
			<td style="text-align: right;">$<strong><span class="number"><?php echo $total; ?></span></strong></td>
		</tr>
		</table>
		<?php
		 $recaudado = $pro->balance + $total;

		 if($recaudado > $pro->breakeven){
		 	$app->enqueueMessage('Algunas unidades serán consideradas financiamiento y las restantes como inversión', 'notice');
		 }
		 
		 if($total < $usuario->data->balance){
		 	$botonGuardar = '<input type="submit" id="guardar" class="button" value="'.JText::_('INVERTIR_PROYECTO').'"  />';
		 }else{
		 	$botonGuardar = '<a class="button" href="index.php?option=com_jumi&view=application&fileid=32">'.JText::_('FREAKFUND_JUMI_ABONOSOCIO_ABONAR').
		 	                ' '.str_replace(':', '', JText::_('FREAKFUND_JUMI_ABONOSOCIO_BALANCE')).'</a>';
		 }
		 
		?>
		<div style="margin: 10px;">
			<input type="button" class="button" value="<?php echo JText::_('LBL_CANCELAR'); ?>" onclick="history.go(-1);" />
			<?php echo $botonGuardar; ?>
		</div>
	</form>
<?php
}
