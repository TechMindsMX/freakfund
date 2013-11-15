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
$token = JTrama::token();

$beneficiarios = array();

$db =& JFactory::getDbo();
 $query = $db->getQuery(true);
 $query->select('idJoomla, idMiddleware');
 $query->from($db->quoteName('#__users_middleware'));
  $db->setQuery( $query );
  $ids = $db->loadObjectList();

foreach ($ids as $key => $benef) {
	if($benef->idJoomla != 378 && $benef->idJoomla != 379 && $benef->idJoomla != 381){
		 $benef->nombre  	= JFactory::getUser($benef->idJoomla)->name;
		 $benef->no_cuenta  = 9876543210 + $key;
		 $benef->maxAmount 	= 10000;
		 $benef->email		= JFactory::getUser($benef->idJoomla)->email;
		 array_push($beneficiarios, $benef);
	}
}
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
				var obj = eval('(' + result + ')');
				
				if(!obj.error){
					jQuery('#socio').val(obj.name);
					jQuery('#email').val(obj.email);
					jQuery('#userId').val(obj.id);
				} else {
					alert('mal');
				}
			});
			
			request.fail(function (jqXHR, textStatus) {
				console.log('Surguieron problemas al almacenar tu calificación');
			});
		});
		
		jQuery('#safe').click(function(){
			var maxAmount 	=jQuery('#maxMount').val();
			var userId 		= jQuery('#userId').val();
			
			var request = $.ajax({
				url: "libraries/trama/js/ajax.php",
				data: {
  					"userId"	: userId,
  					"maxMount"	: maxAmount,
  					"token"		: "<?php echo $token; ?>",
  					"fun"		: 7
 				},
 				type: 'post'
			});
			
			request.done(function(result){
				var obj = eval('(' + result + ')');
				
			});
			
			request.fail(function (jqXHR, textStatus) {
				console.log('Surguieron problemas al almacenar tu calificación');
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
	
		jQuery('div.editable').click(function(){
			jQuery(this).find('span').hide();
			jQuery(this).find('input').prop('type', 'text')
		});
	});
</script>

<div id="divFormulario">
	<form id="formAltaTraspaso" action="" method="post">
		<input type="hidden" name="userId" id="userId" />
		
		<div class="fila encabezado">
			<div><?php echo 'Monto maximo'; //JText::_('FORM_ALTA_ASPASOS_MONTOMAXIMO'); ?></div>
			<div><?php echo 'Numero de cuenta';//JText::_('FORM_ALTA_TRASPASOS_CLABEFF'); ?></div>
			<div><?php echo 'Nombre del Socio';//JText::_('FORM_ALTA_TRASPASOS_NOMSOCIO'); ?></div>
			<div><?php echo 'Email';//JText::_('FORM_ALTA_TRASPASOS_EMAIL'); ?></div>
		</div>
		
		<?php
		foreach ($beneficiarios as $key => $value) {
		?>
			<div class="fila">
				<div class="editable">
					<input type="hidden" value="<?php echo $value->maxAmount; ?>" />
					<span>$<span class="number"><?php echo $value->maxAmount; ?></span></span>
				</div>
				<div class="editable">
					<input type="hidden" value="<?php echo $value->no_cuenta; ?>" />
					<span><?php echo $value->no_cuenta; ?></span>
				</div>
				<div><?php echo $value->nombre; ?></div>
				<div><?php echo $value->email; ?></div>
				<div style="width: 145px;">
					<input type="button" value="Actualizar" />
					<input type="button" value="Borrar" />
				</div>
			</div>
		<?php 
		}
		?>
		<div class="fila">
			<div><input type="text" name="maxMount" id="maxMount" /></div>
			<div><input type="text" name="clabe" id="clabe" /></div>
			<div><input type="text" name="socio" id="socio" readonly="readonly" /></div>
			<div><input type="text" name="email" id="email" readonly="readonly" /></div>
			<div><input type="button" id="guardar" value="Guardar" /></div>
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
		<span><input type="button" id="Cancelar" value="Cancelar" /></span>
		<span><input type="button" id="safe" value="Confirmar" /></span>
	</div>
</div>