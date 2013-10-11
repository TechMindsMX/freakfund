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
	case '5': //Autorizado, cambia a estatus 6 (produccion si se tiene la documentacion completa), y estatus 10 Documentacion pendiente
		$datos->jquery = "jQuery('#formstatus input[type=radio]').change(function() {".
						 "		if( jQuery(this).val() == 1 ) {".
						 "			jQuery('#statusbaja').val(6);".
						 "			jQuery('#status6').prop('disabled', false);".
						 "			jQuery('#status10').prop('disabled', true);".
						 "		}else{".
						 "			jQuery('#statusbaja').val(10);".
						 "			jQuery('#status10').prop('disabled', false);".
						 "			jQuery('#status6').prop('disabled', true);".
						 "		}".
						 "});";
						 
		$datos->inputs = '<input type="hidden" name="status" value="10" id="statusbaja" />
							<div style="margin-bottom: 10px;">
								'.JText::_('COM_FREAKFUND_STATUSPRO_DOCPENDIENTE').' : 
								Si <input type="radio" class="docComplete" name="docComplete" id="docCompletetrue" value="0" checked />
								No <input type="radio" class="docComplete" name="docComplete" id="docCompletefalse" value="1" />
							</div>';
		$datos->finalizacion = '';
		
		$datos->bajaMotivos = '';
		
		break;
	case '6'://Producción, cambia a estatus 7 (presentacion si se confirma la entrega del producto), y estatus 4 si no se entrega el producto (enviando el motivo de baja)
		$datos->jquery = "jQuery('#status6').val('".JText::_('COM_FREAKFUND_STATUSPRO_BUTTON_BAJA_PRODUCTO_0')."');\n".
						 "jQuery('#status10').val('".JText::_('COM_FREAKFUND_STATUSPRO_BUTTON_EN_PRESENTACION')."');\n".
						 "jQuery('#status6').prop('id', 'status4');\n".
						 "jQuery('#status10').prop('id', 'status7');\n".
						 "jQuery('#status7').prop('disabled', true);\n".
						 "jQuery('#status4').prop('disabled', false);\n".
						 
						 "jQuery('#formstatus input[type=radio]').change(function() {\n".
						 "		if( jQuery(this).val() == 1 ) {\n".
						 "			jQuery('#statusbaja').val(7);\n".
						 "			jQuery('#motivoBaja').val();\n".
						 "			jQuery('#motivoBaja').prop('name', '');\n".
						 "			jQuery('#status7').prop('disabled', false);\n".
						 "			jQuery('#status4').prop('disabled', true);\n".
						 "		}else{\n".
						 "			jQuery('#statusbaja').val(4);\n".
						 "			jQuery('#motivoBaja').val(0);\n".
						 "			jQuery('#motivoBaja').prop('name', 'reason');\n".
						 "			jQuery('#status7').prop('disabled', true);\n".
						 "			jQuery('#status4').prop('disabled', false);\n".
						 "		}\n".
						 "});\n";
						 
		$datos->inputs = '<input type="hidden" name="status" value="4" id="statusbaja" />
						  <input type="hidden" name="reason" value="0" id="motivoBaja" />
							<div style="margin-bottom: 10px;">
								¿Se entrego el proyecto?: 
								Si <input type="radio" value="1" name="docComplete" id="docCompletetrue" class="docComplete" />
								No <input type="radio" value="0" name="docComplete" id="docCompletefalse" class="docComplete" checked />
							</div>';
		break;
	case '7'://Presentacion, Se envia solamente al estatus 11(Cerrando)
		$datos->jquery = "jQuery('#status10').val('".JText::_('COM_FREAKFUND_STATUSPRO_BUTTON_CERRANDO')."');\n".
						 "jQuery('#status10').prop('id', 'closer');\n".
						 "jQuery('#status6').prop('disabled', false);\n".
						 "jQuery('#status6').remove();\n";
						 
		$datos->inputs = '<input type="hidden" name="status" value="11" id="statusbaja" />';
		break;
	case '10'://Documentacion pendiente, cambia a estatus 6(produccion si la documentacion esta completa), y estatus 4 si no entrego la documentacion (enviar el motivo de la baja)
		$datos->jquery = "jQuery('#status6').val('".JText::_('COM_FREAKFUND_STATUSPRO_BUTTON_BAJA_PRODUCTO_1')."');\n".
						 "jQuery('#status10').val('".JText::_('COM_FREAKFUND_STATUSPRO_BUTTON_EN_PRESENTACION')."');\n".
						 "jQuery('#status6').prop('id', 'status4');\n".
						 "jQuery('#status10').prop('id', 'status6');\n".
						 "jQuery('#status6').prop('disabled', true);\n".
						 "jQuery('#status4').prop('disabled', false);\n".
						 
						 "jQuery('#formstatus input[type=radio]').change(function() {\n".
						 "		if( jQuery(this).val() == 0 ) {\n".
						 "			jQuery('#statusbaja').val(6);\n".
						 "			jQuery('#motivoBaja').val();\n".
						 "			jQuery('#motivoBaja').prop('name', '');\n".
						 "			jQuery('#status6').prop('disabled', false);\n".
						 "			jQuery('#status4').prop('disabled', true);\n".
						 "		}else{\n".
						 "			jQuery('#statusbaja').val(4);\n".
						 "			jQuery('#motivoBaja').val(1);\n".
						 "			jQuery('#motivoBaja').prop('name', 'reason');\n".
						 "			jQuery('#status6').prop('disabled', true);\n".
						 "			jQuery('#status4').prop('disabled', false);\n".
						 "		}\n".
						 "});\n";
						 
		$datos->inputs = '<input type="hidden" name="status" value="4" id="statusbaja" />
						  <input type="hidden" name="reason" value="1" id="motivoBaja" />
							<div style="margin-bottom: 10px;">
								'.JText::_('COM_FREAKFUND_STATUSPRO_DOCPENDIENTE').': 
								Si <input type="radio" value="1" name="docComplete" id="docCompletetrue" class="docComplete" checked />
								No <input type="radio" value="0" name="docComplete" id="docCompletefalse" class="docComplete" />
							</div>';
		break;
	case '11'://Cerrando, Cambia unicamente al estatus 8 (finalizado), y un boton para regresar al listado
		$datos->jquery = "jQuery('#status10').val('".JText::_('COM_FREAKFUND_STATUSPRO_FINISH')."');\n".
						 "jQuery('#status10').prop('id', 'finishButton');\n".
						 "jQuery('#status6').prop('disabled', false);\n".
						 "jQuery('#status6').remove();\n";
						 
		$datos->inputs = '<input type="hidden" name="status" value="8" id="statusbaja" />';
		$datos->finalizacion = '';
		
		$datos->bajaMotivos = '';
		break;
	default:
		$errors = JFactory::getApplication();
	    $errors->redirect('index.php?option=com_freakfund&task=projectlist', 
	    				   $msg = JText::_('COM_FREAKFUND_STATUSPRO_ERRORS_MSG').JTrama::getStatusName($datos->status),
	    				   $msgType='error');
		break;
}
?>
<script language="JavaScript">
	jQuery(document).ready(function() {
		<?php
			echo $datos->jquery;
		?>

		jQuery('#formstatus input[type="button"]').click(function() {
			switch(this.id){
				case 'status6':
					jQuery('#selectBajas').prop('name', '');
					jQuery('#docCompletetrue').prop('name', '');
					jQuery('#docCompletefalse').prop('name', '');
					jQuery("#formstatus").submit();
					break;
				case 'status10':
					jQuery('#docCompletetrue').prop('name', '');
					jQuery('#docCompletefalse').prop('name', '');
					jQuery("#formstatus").submit();
					break;
				case 'status7':
					jQuery('#selectBajas').prop('name', '');
					jQuery('#docCompletetrue').prop('name', '');
					jQuery('#docCompletefalse').prop('name', '');
					jQuery("#formstatus").submit();
					break;
				case 'status4':
					jQuery('#docCompletetrue').prop('name', '');
					jQuery('#docCompletefalse').prop('name', '');
					jQuery("#formstatus").submit();
					break;
				case 'closer':
					jQuery("#formstatus").submit();
					break;
				case 'goback':
					history.back();
					break;
				case 'finishButton':
					if(confirm('¿Está seguro que desea finalizar el producto, dispersar los beneficios y notificar a los involucrados? ESTA ACCIÓN ES IRREVERSIBLE')) {
						jQuery("#formstatus").submit();
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
