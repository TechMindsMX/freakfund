<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$token 		= JTrama::token();
$document 	= JFactory::getDocument();
$document	-> addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document	-> addScript('../templates/rt_hexeris/js/jquery.number.min.js');
$datos 		= $this->items;

if( $datos['resumen'] === 'true' && !is_null($datos['error']) ){
	$app	= JFactory::getApplication();
	$app->enqueueMessage(JText::_('COM_ADMINCUENTAS_TRASPASO_ERROR'.$datos['error']), 'error');
	$datos['resumen'] = 'false';
}elseif( $datos['resumen'] === 'true' && is_null($datos['error']) ){
	$app	= JFactory::getApplication();
	$app->enqueueMessage(JText::_('COM_ADMINCUENTAS_TRASPASO_DONE'), 'message');
}
?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		var resumen = <?php echo $datos['resumen']; ?>;

		if(resumen){
			jQuery('#formulario').hide();
			jQuery('#confirmacion').hide();
			jQuery('#resumen').show();
		}else{
			jQuery('#formulario').show();
			jQuery('#confirmacion').hide();
			jQuery('#resumen').hide();
		}
		
		jQuery('span.number').number(true,2);
		jQuery('#cuentaDestino').change(function(){
			var clabe 		= jQuery(this).val();
			var clabe		= clabe.toUpperCase();
			var validacion	= clabe.substring(0,1)=='U' || clabe.substring(0,1)=='P' ? true : false;
			
			jQuery('#cuentaDestino').val(clabe);
			
			if(validacion){
				var request = $.ajax({
					url: "../libraries/trama/js/ajax.php",
					data: {
	  					"numCuenta"	: clabe,
	  					"fun"		: 7
	 				},
	 				type: 'post'
				});
				
				request.done(function(result){
					if(result != ''){
						jQuery('.proyecto').text(result)
						jQuery('.datosCuenta').fadeIn()
					}else{
						alert('<?php echo JText::_("COM_ADMINCUENTAS_TRASPASO_NUMBER_NOEXIST"); ?>');
					}
				});
			}else{
				alert('<?php echo JText::_("COM_ADMINCUENTAS_TRASPASO_INVALID_NUMBER"); ?>')
			}
		});
		
		jQuery('#confirmButton').click(function(){
			var nombre 			= jQuery('.proyecto')[0];
			var cuentaDestino 	= jQuery('#cuentaDestino').val();
			var montoTraspaso 	= jQuery('#montoTraspaso').val();
			var nombre			= jQuery(nombre).text();
			var balanceOrigen 	= jQuery('#balanceOrigen').val();
			var callback 		= '<?php echo $datos['callback']; ?>&cuentaDestino='+cuentaDestino+'&amount='+montoTraspaso+'&name='+nombre+'&balance='+balanceOrigen;
			
			jQuery('#system-message-container').remove();
			jQuery('#formulario').hide();
			jQuery('#callback').val(callback);
			jQuery('#destino').text(cuentaDestino);
			jQuery('.montoTraspaso').html('$<span class="number">'+montoTraspaso+'</span>');
			jQuery('span.number').number(true,2);
			jQuery('#confirmacion').show();
		});
	
		jQuery('#cancelConfirm').click(function(){
			jQuery('#confirmacion').hide();
			jQuery('#callback').val('');
			jQuery('#destino').text();
			jQuery('.montoTraspaso').html();
			jQuery('#formulario').show();
		});
	});
</script>

<form id="formstatus" action="" method="POST" enctype="application/x-www-form-urlencoded">
	<table id="tablaGral" class="adminlist">
	    <thead><?php echo $this->loadTemplate('head');?></thead>
	    <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
	    <tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
</form>
