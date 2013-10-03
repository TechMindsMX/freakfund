<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$token = JTrama::token();

$document = JFactory::getDocument();
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		jQuery('#docComplete').change(function() {
			if( jQuery(this).prop('checked') ) {
				jQuery('#publishButton').prop('disabled', false);
				jQuery('#baja').prop('disabled', true);
				jQuery('#selectBajas').prop('disabled', true);
			}else{
				jQuery('#publishButton').prop('disabled', true);
				jQuery('#baja').prop('disabled', false);
				jQuery('#selectBajas').prop('disabled', false);
			}
		});

		jQuery('#formstatus input[type="button"]').click(function() {
			switch(this.id){
				case 'publishButton':
					jQuery('#selectBajas').prop('name', '');
					jQuery("#formstatus").submit();
					break;

				case 'baja':
				jQuery('#statusbaja').val(4);
				
				jQuery("#formstatus").submit();
				break;

				case 'finishButton':
					if(confirm('¿Está seguro que desea finalizar el producto, dispersar los beneficios y notificar a los involucrados? ESTA ACCIÓN ES IRREVERSIBLE')) {
						if(confirm('¿Está seguro? ESTA ACCIÓN ES IRREVERSIBLE')) {
							if(confirm('¿Seguro Seguro?')) {
								jQuery('#selectBajas').prop('name', '');
								jQuery("#formstatus").submit();
							} else {
								alert('Bien hecho');
							}
						} else {
							alert('Bien hecho');
						}
					} else {
						alert('Bien hecho');
					}
					break;
				
				default:
					alert('que presionaste????');
					break;
			}
		});
	});
</script>

<form id="formstatus" action="<?php echo MIDDLE.PUERTO.'/trama-middleware/rest/project/changeStatus'; ?>" method="POST" enctype="application/x-www-form-urlencoded">
	
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>
