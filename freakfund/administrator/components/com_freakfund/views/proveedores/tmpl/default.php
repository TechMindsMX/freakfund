<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$document = JFactory::getDocument();
$document->addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$document->addScript('../libraries/trama/js/jquery.number.min.js');
$token = JTrama::token();
?>
<script language="JavaScript">
	jQuery(document).ready(function (){
		 jQuery('span.number').number( true, 2, '.',',' );
		 
		 jQuery('.pagar').click(function () {
		 	var request = $.ajax({
				url:"<?php echo MIDDLE.PUERTO ?>/trama-middleware/rest/project/saveProviderPayment",
				data: {
					"providerId": jQuery(this).next().next().val(),
					"type": jQuery(this).next().val(),
					"projectId" : jQuery(this).next().next().next().val(),
					"token": "<?php echo $token; ?>"
				},
				type: 'post'
			});
			
			request.done(function(result){
				// var obj = eval('(' + result + ')');
				
				console.log(result);
			});
		 });
	});
</script>
<form action="<?php echo JRoute::_('index.php?option=com_tramaproyectos'); ?>" method="post" name="adminForm">
        <table id="tablaGral" class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
        </table>
</form>