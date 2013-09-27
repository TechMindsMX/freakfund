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
			}else{
				jQuery('#publishButton').prop('disabled', true);
			}
		});

		jQuery('#formstatus input[type="button"]').click(function() {
			switch(this.id){
				case 'publishButton':
					alert('Publicar');
					break;

				case 'incompletedoc':
					alert('Documentacion ');
					break;

				case 'finishButton':
					if(confirm('¿Está seguro que desea finalizar el producto, dispersar los beneficios y notificar a los involucrados? ESTA ACCIÓN ES IRREVERSIBLE')) {
						if(confirm('¿Está seguro? ESTA ACCIÓN ES IRREVERSIBLE')) {
							if(confirm('¿Seguro Seguro?')) {
								if(confirm('¿Por tu mama?')) {
									alert('Estatus cambiado');
								} else {
									alert('Bien hecho');
								}
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
				
				case 'productnosend':
					alert('Producto no entregado');
					break;

				default:
					alert('que presionaste');
					break;
			}
		});
	});
</script>
<form id="formstatus" action="<?php echo JRoute::_('index.php?option=com_freakfund'); ?>" method="post" name="adminForm">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>
