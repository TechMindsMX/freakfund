<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$token = JTrama::token();
?>
<script language="JavaScript">
	function confirmar () {
		if(confirm('¿Está seguro que desea finalizar el producto, dispersar los beneficios y notificar a los involucrados? ESTA ACCIÓN ES IRREVERSIBLE')) {
			if(confirm('¿Está seguro? ESTA ACCIÓN ES IRREVERSIBLE')) {
				if(confirm('¿Seguro Seguro?')) {
					if(confirm('¿Por tu mama?')) {
						alert('Ya te chingaste');
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
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_freakfund'); ?>" method="post" name="adminForm">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>
