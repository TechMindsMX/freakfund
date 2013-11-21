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
		
		jQuery('.safe').click(function(){
			var maxAmount 		= jQuery('#maxMount').val();
			var userId 			= jQuery('#userId').val();
			var destinationId	= jQuery('#destinationId').val();
			
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
				if(this.value == Confirmar){
					var html = '';
					
					html += '<div class="fila">';
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
					html += '		<input type="button" class="button" value="Actualizar" />';
					html += '		<input type="button" class="button" value="Borrar" />';
					html += '	</div>';
					html += '</div>';
					
					jQuery(html).insertBefore('#autocompletado');
					
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
				}else{
					jQuery(this).parent().parent().find('input[type="text"]').prop('type', 'hidden');
					jQuery(this).parent().parent().find('span').text('');
					jQuery(this).parent().parent().find('span').html('$<span class="number">' + jQuery(this).parent().parent().find('input[type="hidden"]').val() + '</span>');
					jQuery("span.number").number( true, 2 );
					jQuery(this).parent().parent().find('span').show();
				}
			});
			
			request.fail(function (jqXHR, textStatus) {
				console.log(jqXHR, textStatus);
			});
		});

		// jQuery('div.editable').click(function(){
			// jQuery(this).find('span').hide();
			// jQuery(this).find('input').prop('type', 'text')
		// });
			
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
	
	function editar(campo){
		jQuery(campo).find('span').hide();
		jQuery(campo).find('input').prop('type', 'text')
	}
</script>

<div id="divFormulario">
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
				<div class="editable" onclick="editar(this)">
					<input type="hidden" value="<?php echo $value->amount; ?>" />
					<span>$<span class="number"><?php echo $value->amount; ?></span></span>
				</div>
				<div>
					<?php echo $value->account; ?>
				</div>
				<div><?php echo $value->name; ?></div>
				<div><?php echo $value->email; ?></div>
				<div style="width: 170px;">
					<input type="button" class="button safe" value="Actualizar" />
					<input type="button" class="button" value="Borrar" />
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
			<div style="width: 170px;"><input type="button" class="button" id="guardar" value="Guardar" /></div>
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
		<span><input type="button" class="button safe" value="Confirmar" /></span>
	</div>
</div>