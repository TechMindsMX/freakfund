<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

jimport('trama.class');
 
// load tooltip behavior
JHtml::_('behavior.tooltip');
$token 		= JTrama::token();
$document 	= JFactory::getDocument();
$document	-> addScript('../templates/rt_hexeris/js/jquery-1.9.1.js');
$datos 		= $this->items;
$selectBaja = $datos->motivosBaja;

$select = '<select name="reason" id="selectBajas">';
foreach ($selectBaja as $key => $value) {
	$select .=  '<option value="'.$value->id.'">'.JText::_('COM_FREAKFUND_STATUSPRO_BAJA_'.$value->id).'</option>';
}
$select .= '</select>';

switch($datos->status){
	case '5':
		$datos->jquery = "jQuery('#docComplete').change(function() {".
						 "		if( jQuery(this).prop('checked') ) {".
						 "			jQuery('#statusbaja').val(6);".
						 "		}else{".
						 "			jQuery('#statusbaja').val(10);".
						 "		}".
						 "});";
						 
		$datos->inputs = '<input type="hidden" name="status" value="10" id="statusbaja" />
						  <input type="hidden" name="reason" value="0" id="motivoBaja" />
							<div style="margin-bottom: 10px;">
								¿La documentacion esta completa?: <input type="checkbox" value="1" id="docComplete" class="docComplete" />
							</div>';
		$datos->finalizacion = '';
		
		$datos->bajaMotivos = '';
		
		break;
	case '6':
		$datos->jquery = "jQuery('#docComplete').change(function() {".
						 "		if( jQuery(this).prop('checked') ) {".
						 "			jQuery('#statusbaja').val(7);".
						 "			jQuery('#motivoBaja').val();".
						 "			jQuery('#motivoBaja').prop('name', '');".
						 "		}else{".
						 "			jQuery('#statusbaja').val(4);".
						 "			jQuery('#motivoBaja').val(1);".
						 "			jQuery('#motivoBaja').prop('name', 'reason');".
						 "		}".
						 "});";
						 
		$datos->inputs = '<input type="hidden" name="status" value="4" id="statusbaja" />
						  <input type="hidden" name="reason" value="1" id="motivoBaja" />
							<div style="margin-bottom: 10px;">
								¿Se entrego el proyecto?: <input type="checkbox" value="1" id="docComplete" class="docComplete" />
							</div>';
		$datos->finalizacion = '';
		
		$datos->bajaMotivos = '';
		break;
	case '7':
		$datos->jquery = "jQuery('#publishButton').prop('id', 'finishButton');".
						 "jQuery('#finishButton').val('".JText::_("COM_FREAKFUND_STATUSPRO_FINISH")."');".
						 "jQuery('#docComplete').change(function() {".
						 "		if( jQuery(this).prop('checked') ) {".
						 "			jQuery('#statusbaja').val(11);".
						 "			jQuery('#motivoBaja').val();".
						 "			jQuery('#motivoBaja').prop('name', '');".
						 "		}else{".
						 "			jQuery('#statusbaja').val(4);".
						 "			jQuery('#motivoBaja').val(1);".
						 "			jQuery('#motivoBaja').prop('name', 'reason');".
						 "		}".
						 "});";
						 
		$datos->inputs = '<input type="hidden" name="status" value="4" id="statusbaja" />
						  <input type="hidden" name="reason" value="1" id="motivoBaja" />
							<div style="margin-bottom: 10px;">
								¿Finalizar proyecto?: <input type="checkbox" value="1" id="docComplete" class="docComplete" />
							</div>';
		$datos->finalizacion = '';
		
		$datos->bajaMotivos = '';
		
		break;
	case '8':
		$datos->jquery = "jQuery('#publishButton').prop('id', 'finishButton');".
						 "jQuery('#finishButton').val('".JText::_("COM_FREAKFUND_STATUSPRO_FINISH")."');".
						 "jQuery('#finishButton').prop('disabled', true);".
						 "jQuery('#docComplete').change(function() {".
						 "		if( jQuery(this).prop('checked') ) {".
						 "			jQuery('#statusbaja').val(11);".
						 "			jQuery('#motivoBaja').val();".
						 "			jQuery('#motivoBaja').prop('name', '');".
						 "			jQuery('#finishButton').prop('disabled', false);".
						 "		}else{".
						 "			jQuery('#statusbaja').val(4);".
						 "			jQuery('#motivoBaja').val(1);".
						 "			jQuery('#motivoBaja').prop('name', 'reason');".
						 "			jQuery('#finishButton').prop('disabled', true);".
						 "		}".
						 "});";
						 
		$datos->inputs = '<input type="hidden" name="status" value="4" id="statusbaja" />
						  <input type="hidden" name="reason" value="1" id="motivoBaja" />
							<div style="margin-bottom: 10px;">
								¿Finalizar proyecto?: <input type="checkbox" value="1" id="docComplete" class="docComplete" />
							</div>';
		$datos->finalizacion = '';
		
		$datos->bajaMotivos = '';
		
		break;	
	case '11':
		$datos->jquery = "jQuery('#publishButton').prop('id', 'finishButton');".
						 "jQuery('#finishButton').val('".JText::_("COM_FREAKFUND_STATUSPRO_FINISH")."');".
						 "jQuery('#docComplete').change(function() {".
						 "		if( jQuery(this).prop('checked') ) {".
						 "			jQuery('#statusbaja').val(11);".
						 "			jQuery('#motivoBaja').val();".
						 "			jQuery('#motivoBaja').prop('name', '');".
						 "		}else{".
						 "			jQuery('#statusbaja').val(4);".
						 "			jQuery('#motivoBaja').val(1);".
						 "			jQuery('#motivoBaja').prop('name', 'reason');".
						 "		}".
						 "});";
						 
		$datos->inputs = '<input type="hidden" name="status" value="4" id="statusbaja" />
						  <input type="hidden" name="reason" value="1" id="motivoBaja" />
							<div style="margin-bottom: 10px;">
								¿Finalizar proyecto?: <input type="checkbox" value="1" id="docComplete" class="docComplete" />
							</div>';
		$datos->finalizacion = '';
		
		$datos->bajaMotivos = '';
		break;
	case '10':
		$datos->jquery = "jQuery('#docComplete').change(function() {".
						 "		if( jQuery(this).prop('checked') ) {".
						 "			jQuery('#statusbaja').val(6);".
						 "			jQuery('#motivoBaja').val();".
						 "			jQuery('#motivoBaja').prop('name', '');".
						 "		}else{".
						 "			jQuery('#statusbaja').val(4);".
						 "			jQuery('#motivoBaja').val(0);".
						 "			jQuery('#motivoBaja').prop('name', 'reason');".
						 "		}".
						 "});";
						 
		$datos->inputs = '<input type="hidden" name="status" value="4" id="statusbaja" />
						  <input type="hidden" name="reason" value="0" id="motivoBaja" />
							<div style="margin-bottom: 10px;">
								¿La documentacion esta completa?: <input type="checkbox" value="1" id="docComplete" class="docComplete" />
							</div>';
		$datos->finalizacion = '';
		
		$datos->bajaMotivos = '';
		break;
	default:
		break;
}

$jquery 	= $datos->jquery;
?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		<?php
			echo $jquery;
		?>

		jQuery('#formstatus input[type="button"]').click(function() {
			switch(this.id){
				case 'publishButton':
					jQuery('#selectBajas').prop('name', '');
					//jQuery("#formstatus").submit();
					break;

				case 'baja':
					jQuery('#statusbaja').val(4);
					//jQuery("#formstatus").submit();
					break;

				case 'finishButton':
					if(confirm('¿Está seguro que desea finalizar el producto, dispersar los beneficios y notificar a los involucrados? ESTA ACCIÓN ES IRREVERSIBLE')) {
						jQuery('#selectBajas').prop('name', '');
						//jQuery("#formstatus").submit();
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
