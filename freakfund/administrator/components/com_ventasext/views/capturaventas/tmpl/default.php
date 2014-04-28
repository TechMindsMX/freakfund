<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$document = JFactory::getDocument();
$document	-> addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document	-> addScript('../templates/rt_hexeris/js/jquery.number.min.js');

$action = JRoute::_('index.php?option=com_tramaproyectos');
$action = '/post.php';
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

			if( !isNaN(cantidad) ){
				jQuery(this).parent().parent().find('.sub').html(subtotal);
				jQuery(this).parent().parent().find('.subinput').val(subtotal);
				
				jQuery.each($('.subinput'),function(key,value){
				    if( !isNaN(parseInt(jQuery(value).val())) ){
				    	total += parseInt(jQuery(value).val());
				    }
				});
				
				jQuery('.total').text(total);
				
				//Detalle de operación
				var cantidadDetalle = jQuery('form').find('.'+this.name);
				var subtotalDetalle	= jQuery(cantidadDetalle).parent().next().children();
				
				jQuery('.totaldetalle').text(total);  
				cantidadDetalle.html(cantidad);
				subtotalDetalle.html(subtotal);
				console.log(disponibles - cantidad);
				jQuery('#uniDisponibles'+this.name).text(disponibles - cantidad);
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