<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$document = JFactory::getDocument();
$document	-> addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document	-> addScript('../templates/rt_hexeris/js/jquery.number.min.js');

$action = MIDDLE.PUERTO.'/trama-middleware/rest/project/boxOfficeSales';
echo $action;
//$action = '/post.php';
?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		jQuery('span.number').number(true,2);
		
		jQuery(':input').keyup(function(){
			var cantidad	= jQuery(this).val();
			var precio 		= parseFloat(jQuery(this).parent().parent().find('#precio').val());
			var subtotal 	= cantidad * precio;
			var total		= 0;
			var disponibles	= parseFloat(jQuery('#totales'+this.name).val());			
			
			if( !isNaN(cantidad*1) ){
				if(disponibles >= cantidad){
					jQuery(this).parent().parent().find('.sub').html(subtotal);
					jQuery(this).parent().parent().find('.subinput').val(subtotal);
				
					jQuery.each($('.subinput'),function(key,value){
					    if( !isNaN(parseInt(jQuery(value).val())) ){
					    	total += parseInt(jQuery(value).val());
					    }
					});
					
					jQuery('.total').text(total);
				
					if( (total > 0) ){
						jQuery('#ingresarventa').attr('disabled', false);
					}else{
						jQuery('#ingresarventa').attr('disabled', true);
					}
					
					//Detalle de operación
					var cantidadDetalle = jQuery('form').find('.'+this.name);
					var subtotalDetalle	= jQuery(cantidadDetalle).parent().next().children();
					
					jQuery('.totaldetalle').text(total);  
					cantidadDetalle.html(cantidad);
					subtotalDetalle.html(subtotal);
	
					jQuery('#uniDisponibles'+this.name).text(disponibles - cantidad);
					jQuery('#disponiblesDetalle'+this.name).text(disponibles - cantidad);
				}else{
					alert('No puede Ingresar un número mayor a: '+disponibles);
					jQuery(this).val('0');
					
					jQuery(this).parent().parent().find('.sub').html(0);
					jQuery(this).parent().parent().find('.subinput').val(0);
					
					jQuery.each($('.subinput'),function(key,value){
					    if( !isNaN(parseInt(jQuery(value).val())) ){
					    	total += parseInt(jQuery(value).val());
					    }
					});
					
					jQuery('.total').text(total);
					
					//Detalle de operación
					var cantidadDetalle = jQuery('form').find('.'+this.name);
					var subtotalDetalle	= jQuery(cantidadDetalle).parent().next().children();
					
					jQuery('.totaldetalle').text(0);  
					cantidadDetalle.html(0);
					subtotalDetalle.html(0);
	
					jQuery('#uniDisponibles'+this.name).text(disponibles);
					jQuery('#disponiblesDetalle'+this.name).text(disponibles);
				}
			}
			
			jQuery('span.number').number(true,2);
		});
		
		jQuery('#ingresarventa').click(function(){
			jQuery('.captura').hide();
			jQuery('.detalle').show();
		});
		
		jQuery('#canceldetalle').click(function(){
			jQuery('.captura').show();
			jQuery('.detalle').hide();
		});
	});
</script>
<form action="<?php echo $action; ?>" method="post" name="adminForm" id="idform">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>