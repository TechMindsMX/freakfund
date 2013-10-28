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

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token 			= JTrama::token();
$input 			= JFactory::getApplication()->input;
$usuario		= JFactory::getUser();
$idMiddleware   = UserData::getUserMiddlewareId($usuario->id);
$proyid			= $input->get("proyid",0,"int");
$pro			= JTrama::getDatos($proyid);
$datosUsuario	= UserData::getUserBalance($idMiddleware->idMiddleware);
$saldo 			= $datosUsuario->balance == null ? 0: $datosUsuario->balance;
$uri 			=& JFactory::getURI();
$callback 		= $uri->toString();

$action 		= MIDDLE.PUERTO.'/trama-middleware/rest/project/consumeUnits';

$response		= $input->get("response",1,"int"); // RESPUESTA EXITO
$error			= $input->get("error",0,"int");

if ($error === 0 && $response === 0) {
?>

<script>
jQuery(document).ready(function(){
	
	jQuery(':input').change(function(){
		var limite = parseInt(jQuery(this).prev().prev().prev().children().text());
//		console.log(jQuery(this).val(), limite, jQuery(this).val()>limite);

		if ( jQuery(this).val()>limite){
			jQuery(this).val(0);
			jQuery(this).next().children().text(0);
			alert('Cantidad superior a inventario');
			
			var total = 0 ;				
			jQuery("#form_compra").find("span#resultados").each(function() {
				total += parseFloat(jQuery(this).text()) || 0;
			
			jQuery("#resultadoglobal").text(total);
			});
		}else{
		  var val_uni = parseFloat(jQuery(this).prev().prev().prev().prev().children().text());
			var resultado = val_uni * jQuery(this).val();

			jQuery(this).next().children().text(resultado);
			
			var total = 0 ;
			jQuery("#form_compra").find("span#resultados").each(function() {
				total += parseFloat(jQuery(this).text()) || 0;
			
			jQuery("#resultadoglobal").text(total);
			});
			if ( jQuery(this).val() > 0 ) {
				var nombre = jQuery(this).attr('id');
				jQuery(this).attr('name', nombre);
			} else {
				jQuery(this).attr('name', '');
			}
		}
	});	
});
</script>

<h1><?php echo JText::_('INVENTARIO_COMPRA');  ?></h1>
<h2><?php echo $pro->name; ?></h2>
<div>
	<form id="form_compra" action="<?php echo $action; ?>" method="POST">
		<input type="hidden" name="userId" id="userId" value="<?php echo $idMiddleware->idMiddleware; ?>" />
		<input type="hidden" name="projectId" id="projectId" value="<?php echo $pro->id; ?>" />
	
		<?php
		foreach ($pro->projectUnitSales as $key => $value){

			$html = '<div class="wrapper">
					<div>'.JText::_('SECCION').':'. $value ->section .'</div>
					<div>'.JText::_('PRECIO_UNIDAD').': <span class="valor_unidad">'. $value ->unitSale.'</span></div>
					<div>'.JText::_('INVENTARIOPP').': <span>'. $value ->unit .'</span></div>
					<input type="hidden" value="'.$value ->id.'"/>
					<label>'.JText::_('CANTIDAD_COMPRAR').':</label>
					<input class="input_compra" type="text" id="'.$value->id.'" name="" />
					<div>'.JText::_('TOTAL_SECCION').':'.'<span id="resultados"></span></div>
					</div>';
			echo $html;
		}

		echo '<h3>'. $usuario->name .'</h3>';
		echo '<div>'.JText::_('SALDO_FF').':'. $saldo .'</div>';
		echo '<div>'.JText::_('TOTAL_PAGAR').':<span id="resultadoglobal"></span></div>';
		?>
		<input type="hidden" name="callback" value="<?php echo $callback; ?>" />
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
		<div style="margin: 10px;">
		<input type="submit" id="guardar" class="button" value="Invertir" />
		<input type="button" class="button" value="Cancelar" onclick="history.go(-1);" />
		</div>
	</form>
	
</div>

<?php
} else {
	$totalCompra = 0;
	
	$html = '<h2>'.$usuario->name.'</h2>
			<div>'.JText::_('SALDO_FF').':'. $saldo .'</div>
			<h3>'.$pro->name.'</h3>
			<p>'.JText::_('COMPRA_SUCCESS').'</p>
			<h3>'.JText::_('COMPRA_SUCCESS_DETAILS').'</h3>
			<div class="detalles_tx">
				<span class="label">'.JText::_('COMPRA_TX_ID').'</span>'.rand(3, 100).'
				<table class="table table-stripped">
					<tr>
						<th>'.JText::_('SECCION').'</th>
						<th>'.JText::_('PRECIO_UNIDAD').'</th>
						<th>'.JText::_('CANTIDAD_COMPRADAS').'</th>
						<th>'.JText::_('COMPRA_SUBTOTAL').'</th>
					</tr>';
	foreach ($pro->projectUnitSales as $key => $value) {
	$cant = 3;
	$subtotal = $value->unitSale*$cant;
	$totalCompra = $totalCompra + $subtotal;
	
	$html .=	'<tr>
					<td>'.$value->section.'</td>
					<td>'.$value->unitSale.'</td>
					<td>'.$cant.'</td>
					<td>'.$subtotal.'</td>
				</tr>';
	}
	
	$html .=	'<tr>
					<td colspan="3" style="text-align: right;">'.JText::_('TOTAL').'</td>
					<td><b>'.$totalCompra.'</b></td>
				</tr>
				</table>
					<pre>SIMULADO FALTA CREAR SERVICIO</pre>
				</div>
				';
	echo $html;
}
