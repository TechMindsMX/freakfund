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

//si proyid no esta vacio traigo los datos del Producto del servicio del middleware
$token = JTrama::token();

$input = JFactory::getApplication()->input;
$usuario= JFactory::getUser();
$proyid= $input->get("proyid",0,"int");
$pro=JTrama::getDatos($proyid);
$datosUsuario=JTrama::getUserBalance($usuario->id);

//definicion de campos del formulario
$action = MIDDLE.PUERTO.'/trama-middleware/rest/';
//$action = 'components/com_jumi/files/costos_variables/post.php';
?>

<script>
	jQuery(document).ready(function(){
		
		jQuery(':input').change(function(){
			var limite = parseInt(jQuery(this).prev().prev().prev().val());
			if ( jQuery(this).val()>limite){
				jQuery(this).val(0);
				jQuery(this).next().children().text(0);
				
				var total = 0 ;				
				jQuery("#form_compra").find("span#resultados").each(function() {
					total += parseFloat(jQuery(this).text()) || 0;
				
				jQuery("#resultadoglobal").text(total);
				});
			}else{
			
				var resultado = jQuery(this).prev().prev().val() * jQuery(this).val();
				jQuery(this).next().children().text(resultado);
				
				var total = 0 ;
				jQuery("#form_compra").find("span#resultados").each(function() {
					total += parseFloat(jQuery(this).text()) || 0;
				
				jQuery("#resultadoglobal").text(total);
				});
				
			}
			});	
		
	});
</script>
<h1><?php echo JText::_('INVENTARIO_COMPRA');  ?></h1>
<div>
	<form id="form_compra" action="<?php echo $action; ?>" method="POST">
	
		<?php 	
		if ($datosUsuario->balance == null ){
			$saldo= "0";
		}else{
			$saldo= $datosUsuario->balance;
		}
		
		$campo = '<label>'.JText::_('CANTIDAD_COMPRAR').':</label><input class="input_compra" type="text" id="cantidad"	name="compra" /> ';
		
		foreach ($pro->projectUnitSales as $key => $value){
	
			echo '<div>'.JText::_('SECCION').':'. $value ->section .'</div>';			
			echo '<div>'.JText::_('PRECIO_UNIDAD').':'. $value ->unitSale.'</div>';
			echo '<div>'.JText::_('INVENTARIOPP').':'. $value ->unit .'</div>';
			echo '<input type="hidden" value="'.$value ->unit.'"/>';
			echo '<input type="hidden" value="'.$value ->unitSale.'"/>';
			echo $campo;
			echo '<div>'.JText::_('TOTAL_SECCION').':'.'<span id="resultados"></span></div><br /><br />';
			
		}
		
		echo '<div>'.JText::_('SALDO_FF').':'. $saldo .'</div>';
		echo '<div>'.JText::_('TOTAL_PAGAR').':<span id="resultadoglobal"></span></div>';
		?>
		<div style="margin: 10px;">
		<input type="button" class="button" value="Invertir" />
		</div>
		<div><input type="button" class="button" value="Cancelar" onclick="history.go(-1);" /> </div>
	</form>
	
</div>