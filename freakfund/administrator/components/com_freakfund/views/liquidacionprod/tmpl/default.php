<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$user = JFactory::getUser();
$isAdmin = $user->get('isRoot');
if (!$isAdmin) {
	$url = 'index.php?option=com_freakfund';
	JFactory::getApplication()->redirect($url, JText::_('CONTENIDO_PRIVADO'), 'error');
}

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document->addScript('../libraries/trama/js/jquery.validationEngine.js');
$document->addScript('../libraries/trama/js/jquery.validationEngine-es.js');
//require_once '../libraries/trama/libreriasPP.php';

?>
<script>
	jQuery(document).ready(function(){
		jQuery("#formID").validationEngine();
		
		jQuery('#payment').change(function(){
			var valor = jQuery(this).val();
			if(isNaN(valor)){
				jQuery('#buttonSubmit').prop('disabled', 'disabled');
			}else{
				jQuery('#buttonSubmit').prop('disabled', '');
			}
		});
	});
</script>
<style>
	.formErrorContent{
		background: none repeat scroll 0 0 #EE0101;
	    border: 2px solid #DDDDDD;
	    border-radius: 6px;
	    box-shadow: 0 0 6px #000000;
	    color: #FFFFFF;
	    font-size: 14px;
	    min-width: 120px;
	    padding: 4px 10px;
	    position: relative;
	    width: 100%;
	    z-index: 991;
	}
	.formErrorArrow {
	    margin: -2px 0 0 13px;
	    position: relative;
	    width: 15px;
	}
	.formErrorArrow {
	    z-index: 996;
	}
	.formErrorArrow {
	    margin: -2px 0 0 13px;
	    position: relative;
	    width: 15px;
	}
	.formErrorArrow {
	    z-index: 996;
	}
</style>
<form action="<?php echo MIDDLE.PUERTO.TIMONE; ?>project/saveProducerPayment" method="post" name="adminForm" id="formID">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>
