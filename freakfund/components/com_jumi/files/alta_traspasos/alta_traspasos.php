<?php
defined('_JEXEC') OR defined('_VALID_MOS') OR die("Direct Access Is Not Allowed");
$usuario = JFactory::getUser();
$app 	 = JFactory::getApplication();
$doc 	 = JFactory::getDocument();
if ($usuario->guest == 1) {
	$return = JURI::getInstance()->toString();
	$url = 'index.php?option=com_users&view=login';
	$url .= '&return=' . base64_encode($return);
	$app->redirect($url, JText::_('JGLOBAL_YOU_MUST_LOGIN_FIRST'), 'message');
}

jimport("trama.class");
jimport("trama.jsocial");
jimport("trama.usuario_class");
jimport("trama.error_class");

$doc->addStyleSheet(JURI::base().'components/com_jumi/files/alta_traspasos/css/estilos_alta.css');
$token 			= JTrama::token();
$userId			= UserData::getUserMiddlewareId($usuario->id);
$beneficiarios 	= UserData::getBeneficiarios($userId->idMiddleware);
?>

<script>
	jQuery(document).ready(function(){
		jQuery('#clabe').change(function(){
			console.log(jQuery(this).parent().find('input[type="text"]'));
			jQuery(this).parent().find('input[type="text"]').each(function(){
				console.log('algo');
			});
			jQuery(this).parent().parent().find('#guardar').prop('disabled', false);
			var clabe = this.value;
			
			var request = $.ajax({
				url: "libraries/trama/js/ajax.php",
				data: {
  					"clabe"	: clabe,
  					"token"	: "<?php echo $token; ?>",
  					"fun"	: 6
 				},
 				type: 'post'
			});
			
			request.done(function(result){
				if(result != ''){
					var obj = eval('(' + result + ')');
					if(!obj.error){
						jQuery('#socio').val(obj.name);
						jQuery('#email').val(obj.email);
						jQuery('#destinationId').val(obj.id);
					} else {
						alert('mal');
					}
				}else{
					alert('No existe el numero de cuenta');
					jQuery('#socio').val('');
					jQuery('#email').val('');
					jQuery('#clabe').val('');
				}
			});
			
			request.fail(function (jqXHR, textStatus) {
				console.log(jqXHR, textStatus);
			});
		});
		
		jQuery('#guardar').click(function(){
			jQuery('#showSocio').html(jQuery('#socio').val());
			jQuery('#showmaxmount').html(jQuery('#maxMount').val());
			jQuery('#showemail').html(jQuery('#email').val());
			jQuery('#showClabe').html(jQuery('#clabe').val());
			
			jQuery('#divConfirmacion').show();
		});
		
		jQuery('#Cancelar').click(function(){
			jQuery('#showSocio').html();
			jQuery('#showmaxmount').html();
			jQuery('#showemail').html();
			jQuery('#showClabe').html();
			
			jQuery('#socio').val('');
			jQuery('#maxMount').val('');
			jQuery('#email').val('');
			jQuery('#clabe').val('');
			
			jQuery('#divConfirmacion').hide();
			jQuery('#divFormulario').show();
		});
	});
	
	function deleteCta(campo){
		var action 			= campo;
		var userId 			= jQuery('#userId').val();
		var destinationId	= jQuery(campo).parent().parent().find('#destinationIdEdicion').val();
		
		
		var request = $.ajax({
			url: "<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/tx/deleteLimitAmountToTransfer",
			data: {
				"userId"		: userId,
				"destinationId"	: destinationId,
				"token"			: "<?php echo $token; ?>"
			},
			type: 'post'
		});
		
		request.done(function(result){
			jQuery(campo).parent().parent().remove();
		});
		
		request.fail(function (jqXHR, textStatus) {
			alert("Ocurrio un problema al eliminar");
		});
	}
	
	function safeUpdate(campo){
		var action 			= campo;
		var userId 			= jQuery('#userId').val();
		if(action.value == "Confirmar"){
			var maxAmount 		= jQuery('#maxMount').val();
			var destinationId	= jQuery('#destinationId').val();
		}else{
			var maxAmount 		= jQuery(campo).parent().parent().find('input[type="text"]').val();
			var destinationId	= jQuery(campo).parent().parent().find('#destinationIdEdicion').val();
		}
		
		var request = $.ajax({
			url: "<?php echo MIDDLE.PUERTO; ?>/trama-middleware/rest/tx/maxAmountToTransfer",
			data: {
				"userId"		: userId,
				"amount"		: maxAmount,
				"destinationId"	: destinationId,
				"token"			: "<?php echo $token; ?>"
			},
			type: 'post'
		});
		
		request.done(function(result){
			if(action.value == "Confirmar"){
				var html = '';
				
				html += '<div class="fila">';
				html += '	<input type="hidden" id="destinationIdEdicion" value="' +destinationId+ '" />';
				html += '	<div class="editable" onclick="editar(this)">';
				html += '		<input type="hidden" value="'+maxAmount+'" />';
				html += '		<span>$<span class="number">'+maxAmount+'</span></span>';
				html += '	</div>';
				html += '	<div>';
				html += '	<input type="hidden" value="'+jQuery('#clabe').val()+'" />';
				html += '	<span>'+jQuery('#clabe').val()+'</span>';
				html += '	</div>';
				html += '	<div>'+jQuery('#socio').val()+'</div>';
				html += '	<div>'+jQuery('#email').val()+'</div>';
				html += '	<div style="width: 170px;">';
				html += '		<input type="button" class="button safe" value="Actualizar" onclick="safeUpdate(this)" disabled="disabled" />';
				html += '		<input type="button" class="button" value="Borrar" onclick="deleteCta(this)" />';
				html += '	</div>';
				html += '</div>';
				
				jQuery(html).insertBefore('#autocompletado');
				
				jQuery("span.number").number( true, 2 );
				
				jQuery('#showSocio').html();
				jQuery('#showmaxmount').html();
				jQuery('#showemail').html();
				jQuery('#showClabe').html();
				
				jQuery('#socio').val('');
				jQuery('#maxMount').val('');
				jQuery('#email').val('');
				jQuery('#clabe').val('');
				jQuery('#destinationId').val('');
				
				jQuery('#divConfirmacion').hide();
				jQuery('#divFormulario').show();
			}else if(action.value == "Actualizar") {
				console.log(jQuery(action).parent().parent().find('.safe'));
				jQuery(action).parent().parent().find('.safe').attr('disabled', 'disabled');
				
				jQuery(action).parent().parent().find('span').text('');
				jQuery(action).parent().parent().find('span').html('$<span class="number">' + jQuery(action).parent().parent().find('input[type="text"]').val() + '</span>');
				
				jQuery(action).parent().parent().find('input[type="text"]').prop('type', 'hidden');
				
				jQuery("span.number").number( true, 2 );
				
				jQuery(action).parent().parent().find('span').show();
			}
		});
		
		request.fail(function (jqXHR, textStatus) {
			alert("Ocurrio un problema al crear/actualizar los datos");
		});
	}
	
	function editar(campo){
		jQuery(campo).parent().find('.safe').prop('disabled', false);
		
		jQuery(campo).find('span').hide();
		jQuery(campo).find('input').prop('type', 'text')
	}
</script>

<div id="divFormulario">
	<h3><?php echo 'Alta de Cuentas para traspasos ';//JText::_('FORM_ALTA_ASPASOS_MONTOMAXIMO'); ?></h3>
	<form id="formAltaTraspaso" action="" method="post">
		<input type="hidden" name="userId" id="userId" value="<?php echo $userId->idMiddleware; ?>"/>
		<input type="hidden" name="userId" id="destinationId" />
		
		<div class="fila encabezado">
			<div><?php echo 'Monto maximo'; //JText::_('FORM_ALTA_ASPASOS_MONTOMAXIMO'); ?></div>
			<div><?php echo 'Numero de cuenta';//JText::_('FORM_ALTA_TRASPASOS_CLABEFF'); ?></div>
			<div><?php echo 'Nombre del Socio';//JText::_('FORM_ALTA_TRASPASOS_NOMSOCIO'); ?></div>
			<div><?php echo 'Email';//JText::_('FORM_ALTA_TRASPASOS_EMAIL'); ?></div>
		</div>
		
		<?php
		foreach ($beneficiarios as $key => $value) {
		?>
			<div class="fila" id="<?php echo $key; ?>">
				<input type="hidden" id="destinationIdEdicion" value="<?php echo $value->destinationId; ?>" />

				<div class="editable" onclick="editar(this)" >
					<input type="hidden" value="<?php echo $value->amount; ?>" />
					<span>$<span class="number"><?php echo $value->amount; ?></span></span>
				</div>
				<div>
					<?php echo $value->account; ?>
				</div>
				<div><?php echo $value->name; ?></div>
				<div><?php echo $value->email; ?></div>
				<div style="width: 170px;">
					<input type="button" class="button safe" value="Actualizar" onclick="safeUpdate(this)" disabled="disabled" />
					<input type="button" class="button" value="Borrar" onclick="deleteCta(this)" />
				</div>
			</div>
		<?php 
		}
		?>

		<div class="fila" id="autocompletado">
			<div><input type="text" name="maxMount" id="maxMount" /></div>
			<div><input type="text" name="clabe" id="clabe" /></div>
			<div><input type="text" name="socio" id="socio" readonly="readonly" /></div>
			<div><input type="text" name="email" id="email" readonly="readonly" /></div>
			<div style="width: 170px;">
				<input type="button" class="button" id="guardar" value="Guardar" disabled="disabled" />
			</div>
		</div>
	</form>
</div>

<div id="divConfirmacion" style="display: none">
	estas Segurooooooo
	<div>
		<span>CLABE:</span>
		<span id="showClabe"></span>
	</div>
	
	<div>
		<span>Nombre del beneficiario:</span>
		<span id="showSocio"></span>
	</div>
	
	<div>
		<span>Monto máximo a traspasar:</span>
		<span id="showmaxmount"></span>
	</div>
	
	<div>
		<span>Correo electrónico del beneficiario:</span>
		<span id="showemail"></span>
	</div>
	
	<div>
		<span><input type="button" class="button" id="Cancelar" value="Cancelar" /></span>
		<span><input type="button" class="button safe" value="Confirmar" onclick="safeUpdate(this)" /></span>
	</div>
</div>