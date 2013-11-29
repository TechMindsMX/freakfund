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
$userdata		= UserData::getUserBalance($userId->idMiddleware);
?>

<script>
	jQuery(document).ready(function(){
		jQuery('#clabe').change(function(){
			var clabe = this.value;
			var salir = false;
			
			jQuery('.fila').each(function(){
			    if( parseInt(jQuery(this).find('.numCuenta').html()) == parseInt(clabe) ){
			    	alert('La cuenta ya esta dada de alta');
			    	salir = true;
			    }
			    
			});
			
			if( salir ){
				jQuery('#socio').val('');
				jQuery('#email').val('');
				jQuery('#clabe').val('');
				jQuery('#guardar').attr('disabled', 'disabled');
				return false;
			}
			
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
					jQuery('#guardar').attr('disabled', 'disabled');
				}
			});
			
			request.fail(function (jqXHR, textStatus) {
				console.log(jqXHR, textStatus);
			});
		});
		
		jQuery('.altavalidation').focusout(function(){
			var contador = 0;
			
			jQuery(this).parent().parent().find('.altavalidation').each(function(){
					
				if(this.value != ''){
					contador++;
				}
				
				if( contador == 2 ) {
					jQuery(this).parent().parent().find('#guardar').prop('disabled', false);
				} else {
					jQuery(this).parent().parent().find('#guardar').attr('disabled', 'disabled');
				}
			});
		});
		
		jQuery('#guardar').click(function(){
			var nombre 	= jQuery('#socio').val();
			var monto	= jQuery('#maxMount').val();
			var email 	= jQuery('#email').val();
			var numCta 	= jQuery('#clabe').val();
			var action 	= 'guardar';
			var message = '<?php echo JText::_('ALTA_TRASPASOS_MSG_GUARDAR'); ?>';
			var div		= jQuery(this).parent().parent();
			
			pintadivConfirmacion(nombre, monto, email, numCta, action, message, div);
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
			jQuery('#autocompletado').find('#guardar').attr('disabled', 'disabled');
			jQuery('#divConfirmacion').hide();
			jQuery('#divFormulario').show();
		});
	});
	
	
	function confirmaciondelete(campo){
		var montoMaximo 		= jQuery(campo).parent().parent().find('.editable').find('input').val();
		var numCuenta 			= parseInt(jQuery(campo).parent().parent().find('.numCuenta').html());
		var nombreBeneficiario	= jQuery(campo).parent().parent().find('.nomBeneficiario').html();
		var mailBeneficiario	= jQuery(campo).parent().parent().find('.mailBeneficiario').html();
		var action				= 'borrar';
		var message				= '<?php echo JText::_('ALTA_TRASPASOS_MSG_BORRAR'); ?>';
		var div 				= jQuery(campo).parent().parent();
		
		pintadivConfirmacion(nombreBeneficiario, montoMaximo, mailBeneficiario, numCuenta, action, message, div);
	}
	
	function confirmacionUpdate(campo){
		
		var montoMaximo 		= jQuery(campo).parent().parent().find('.editable').find('input').val();
		var numCuenta 			= parseInt(jQuery(campo).parent().parent().find('.numCuenta').html());
		var nombreBeneficiario	= jQuery(campo).parent().parent().find('.nomBeneficiario').html();
		var mailBeneficiario	= jQuery(campo).parent().parent().find('.mailBeneficiario').html();
		var action				= 'update';
		var message				= '<?php echo JText::_('ALTA_TRASPASOS_MSG_UPDATE'); ?>';
		var div 				= jQuery(campo).parent().parent();

		pintadivConfirmacion(nombreBeneficiario, montoMaximo, mailBeneficiario, numCuenta, action, message, div);
	}
	
	function pintadivConfirmacion(nombre, monto, email, numCta, action, message, div){
		console.log(nombre, monto, email, numCta, action, message, div);
		
		jQuery('#showSocio').html(nombre);
		jQuery('#showmaxmount').html('$<span class="number">' + monto + '</span>' );
		jQuery('#showemail').html(email);
		jQuery('#showClabe').html(numCta);
		
		jQuery("span.number").number( true, 2 );

		switch(action){
			case 'guardar':
				$('#divConfirmacion').find('h3').html(message);
				$('#divConfirmacion').find('.safe').attr('onclick','safeUpdate(this, "'+jQuery(div).prop('id')+'")');
				break;
			case 'borrar':
				$('#divConfirmacion').find('h3').html(message);
				$('#divConfirmacion').find('.safe').attr('onclick','deleteCta(this, '+jQuery(div).prop('id')+')');
				break
			case 'update':
				$('#divConfirmacion').find('h3').html(message);
				$('#divConfirmacion').find('.safe').attr('onclick','safeUpdate(this, "'+jQuery(div).prop('id')+'")');
				break;
		}
		
		jQuery('#divConfirmacion').show();
	}
	
	function deleteCta(campo, div){
		var userId 			= jQuery('#userId').val();
		var destinationId	= jQuery('#'+div).parent().parent().find('#destinationIdEdicion').val();
		
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
			jQuery('#'+div).remove();
			jQuery('#divConfirmacion').hide();
		});
		
		request.fail(function (jqXHR, textStatus) {
			alert("Ocurrio un problema al eliminar");
		});
	}
	
	function safeUpdate(campo, div){
		var action				= jQuery('#'+div);
		var userId 				= jQuery('#userId').val();
		
		if(action.prop('id') == "autocompletado"){
			 var maxAmount 		= jQuery('#maxMount').val();
			 var destinationId	= jQuery('#destinationId').val();
		}else if( jQuery.isNumeric(action.prop('id')) ){
			var maxAmount 		= action.find('.editable').find('input[type="text"]').val();
			var destinationId	= action.find('#destinationIdEdicion').val();
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
			var obj = eval('(' + result + ')');
			
			if(typeof obj.error == 'undefined'){
			
				if(action.prop('id') == "autocompletado"){
					var html = '';
					
					html += '<div class="fila" id="'+obj.response+'">';
					html += '	<input type="hidden" id="destinationIdEdicion" value="' +destinationId+ '" />';
					html += '	<div class="editable" onclick="editar(this)">';
					html += '		<input type="hidden" value="'+maxAmount+'" />';
					html += '		<span>$<span class="number">'+maxAmount+'</span></span>';
					html += '	</div>';
					html += '	<div class="numCuenta">'+jQuery('#clabe').val()+'</div>';
					html += '	<div class="nomBeneficiario">'+jQuery('#socio').val()+'</div>';
					html += '	<div class="mailBeneficiario">'+jQuery('#email').val()+'</div>';
					html += '	<div style="width: 170px;">';
					html += '		<input type="button" class="button safe" value="Actualizar" onclick="confirmacionUpdate(this)" disabled="disabled" />';
					html += '		<input type="button" class="button" value="Borrar" onclick="confirmaciondelete(this)" />';
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
					
				}else if( jQuery.isNumeric(action.prop('id')) ) {
					action.find('.safe').attr('disabled', 'disabled');
					
					action.find('span').text('');
					action.find('span').html('$<span class="number">' + action.find('input[type="text"]').val() + '</span>');
					
					action.find('input[type="text"]').prop('type', 'hidden');
					
					jQuery("span.number").number( true, 2 );
					
					jQuery('#divConfirmacion').hide();
					action.find('span').show();
				}
			}else{
				alert('No puedes dar de alta tu propio numero de cuenta');
			}
		});
		
		request.fail(function (jqXHR, textStatus) {
			alert("Ocurrio un problema al crear/actualizar los datos");
		});
	}
	
	function editar(campo){
		jQuery('#formAltaTraspaso').find('.fila').each(function(){
			if( jQuery.isNumeric(this.id) ){
				jQuery(this).find('.safe').attr('disabled', 'disabled');
				jQuery(this).find('span').show();
				jQuery(this).find('input[type="text"]').hide();
			}
		});

		jQuery(campo).parent().find('.safe').prop('disabled', false);
		jQuery(campo).find('span').hide();
		jQuery(campo).find('input').prop('type', 'text');
		jQuery(campo).find('input[type="text"]').show();
	}
</script>

<div id="divFormulario">
	<div>
		<div>
		<h2><?php echo JFactory::getUser()->name; ?></h2>
		</div>
		
		<div>
			<span class="labelsconfirmacion">Cuenta Freakfund:</span>
			<span class="datosconfirmacion"><?php echo $userdata->account; ?></span>
		</div>
		
		<div>
			<span class="labelsconfirmacion">Saldo Freakfund:</span>
			<span class="datosconfirmacion">$<span class="number"><?php echo $userdata->balance; ?></span></span>
		</div>
	</div>

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
		//Se crea el listado de los usuario dados de alta
		foreach ($beneficiarios as $key => $value) {
		?>
			<div class="fila" id="<?php echo $value->id; ?>">
				<input type="hidden" id="destinationIdEdicion" value="<?php echo $value->destinationId; ?>" />

				<div class="editable" onclick="editar(this)" >
					<input type="hidden" value="<?php echo $value->amount; ?>" />
					<span>$<span class="number"><?php echo $value->amount; ?></span></span>
				</div>
				<div class="numCuenta">
					<?php echo $value->account; ?>
				</div>
				<div class="nomBeneficiario"><?php echo $value->name; ?></div>
				<div class="mailBeneficiario"><?php echo $value->email; ?></div>
				<div style="width: 170px;">
					<input type="button" class="button safe" value="Actualizar" onclick="confirmacionUpdate(this)" disabled="disabled" />
					<input type="button" class="button" value="Borrar" onclick="confirmaciondelete(this)" />
				</div>
			</div>
		<?php 
		}
		?>
		
		<!--Campos para dar de alta un numero de cuenta-->
		<div class="fila" id="autocompletado">
			<div><input type="text" name="maxMount" id="maxMount" class="altavalidation" placeholder="Monto maximo"/></div>
			<div><input type="text" name="clabe" id="clabe"  class="altavalidation" maxlength="10" /></div>
			<div><input type="text" name="socio" id="socio" readonly="readonly" /></div>
			<div><input type="text" name="email" id="email" readonly="readonly" /></div>
			<div style="width: 170px;">
				<input type="button" class="button" id="guardar" value="Guardar" disabled="disabled" />
			</div>
		</div>
	</form>
</div>

<div id="divConfirmacion">
	<h3>Estas Seguro de enviar la siguiente información!!!</h3>
	
	<div>
		<span class="labelsconfirmacion">CLABE FreakFund:</span>
		<span class="datosconfirmacion" id="showClabe"></span>
	</div>
	
	<div>
		<span class="labelsconfirmacion">Nombre del beneficiario:</span>
		<span class="datosconfirmacion" id="showSocio"></span>
	</div>
	
	<div>
		<span class="labelsconfirmacion">Monto máximo a traspasar:</span>
		<span class="datosconfirmacion" id="showmaxmount"></span>
	</div>
	
	<div>
		<span class="labelsconfirmacion">Email del beneficiario:</span>
		<span class="datosconfirmacion" id="showemail"></span>
	</div>
	
	<div>
		<span><input type="button" class="button" id="Cancelar" value="Cancelar" /></span>
		<span><input type="button" class="button safe" value="Confirmar" onclick="safeUpdate(this)" /></span>
	</div>
</div>

<div>
	<input type="button" class="button" onclick="window.location.href='index.php?option=com_jumi&view=application&fileid=24&Itemid=218'" value="<?php echo JText::_('IR_A_CARTERA'); ?>" />
</div>