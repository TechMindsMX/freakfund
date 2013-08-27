/*funciones para copiar informacion de campos*/
function copiarFiscal() {
    document.getElementById('doFi_nomCalle').value = document.getElementById('dire_nomCalle').value;
    document.getElementById('doFi_noExterior').value = document.getElementById('dire_noExterior').value;
    document.getElementById('doFi_noInterior').value = document.getElementById('dire_noInterior').value;
    document.getElementById('doFi_iniCodigoPostal').value = document.getElementById('dire_iniCodigoPostal').value;
    document.getElementById('doFi_nomEstado').value = document.getElementById('dire_nomEstado').value;
	document.getElementById('doFi_nomPais').value = document.getElementById('dire_nomPais').value;
	document.getElementById('doFi_nomColonias').value = document.getElementById('dire_nomColonias').value;
	document.getElementById('doFi_nomDelegacion').value = document.getElementById('dire_nomDelegacion').value;
}

function copiarRepresentante() {
    document.getElementById('repr_nomNombre').value = document.getElementById('daGr_nomNombre').value;
    document.getElementById('repr_nomApellidoPaterno').value = document.getElementById('daGr_nomApellidoPaterno').value;
    document.getElementById('repr_nomApellidoMaterno').value = document.getElementById('daGr_nomApellidoMaterno').value;
    document.getElementById('maRe_coeEmail').value = document.getElementById('maGr_coeEmail').value;
    document.getElementById('teRe_nomTipoTelefono').value = document.getElementById('teGr_nomTipoTelefono').value;	
    document.getElementById('teRe_telTelefono').value = document.getElementById('teGr_telTelefono').value;	
    document.getElementById('teRe_extension').value = document.getElementById('teGr_extension').value;
}

function copiarDomRep() {
    document.getElementById('doRe_nomCalle').value = document.getElementById('dire_nomCalle').value;
    document.getElementById('doRe_noExterior').value = document.getElementById('dire_noExterior').value;
    document.getElementById('doRe_noInterior').value = document.getElementById('dire_noInterior').value;
    document.getElementById('doRe_iniCodigoPostal').value = document.getElementById('dire_iniCodigoPostal').value;
    document.getElementById('doRe_nomEstado').value = document.getElementById('dire_nomEstado').value;
	document.getElementById('doRe_nomPais').value = document.getElementById('dire_nomPais').value;
	document.getElementById('doRe_nomColonias').value = document.getElementById('dire_nomColonias').value;
	document.getElementById('doRe_nomDelegacion').value = document.getElementById('dire_nomDelegacion').value;
}

function copiarContacto() {
    document.getElementById('daCo_nomNombre').value = document.getElementById('daGr_nomNombre').value;
    document.getElementById('daCo_nomApellidoPaterno').value = document.getElementById('daGr_nomApellidoPaterno').value;
    document.getElementById('daCo_nomApellidoMaterno').value = document.getElementById('daGr_nomApellidoMaterno').value;
    document.getElementById('maCo_coeEmail').value = document.getElementById('maGr_coeEmail').value;
    document.getElementById('teCo_nomTipoTelefono').value = document.getElementById('teGr_nomTipoTelefono').value;	
    document.getElementById('teCo_telTelefono').value = document.getElementById('teGr_telTelefono').value;	
    document.getElementById('teCo_extension').value = document.getElementById('teGr_extension').value;
}

function copiarDomCon() {
    document.getElementById('doCo_nomCalle').value = document.getElementById('dire_nomCalle').value;
    document.getElementById('doCo_noExterior').value = document.getElementById('dire_noExterior').value;
    document.getElementById('doCo_noInterior').value = document.getElementById('dire_noInterior').value;
    document.getElementById('doCo_iniCodigoPostal').value = document.getElementById('dire_iniCodigoPostal').value;
    document.getElementById('doCo_nomEstado').value = document.getElementById('dire_nomEstado').value;	
	document.getElementById('doCo_nomPais').value = document.getElementById('dire_nomPais').value;
	document.getElementById('doCo_nomColonias').value = document.getElementById('dire_nomColonias').value;
	document.getElementById('doCo_nomDelegacion').value = document.getElementById('dire_nomDelegacion').value;
}

function datosxCP() {
	jQuery('input[name$="perfil_codigoPostal_idcodigoPostal"]').change(function () {
					
		var request = $.ajax({
			url:"components/com_jumi/files/busqueda/ajax.php",
			data: {
				"cp": this.value,
				"fun": '2'
			},
			type: 'post'
		});
	
		request.done(function(result){
			var obj = eval('('+result+')');
			var colonias = obj.dAsenta;
			var select_colonias = jQuery('select[name$="perfil_colonias_idcolonias"]');
			var select_edos = jQuery('select[name$="perfil_estado_idestado"]');
			
			jQuery('option', select_colonias).remove();
			jQuery('option', select_edos).remove();
								
			jQuery.each(colonias, function (key, value){
				select_colonias.append(new Option(value, value));
			});
			
			jQuery('input[name$="perfil_delegacion_iddelegacion"]').val(obj.dMnpio);
			
			
			select_edos.append(new Option(obj.dEstado, obj.dEstado));
		});
	
		request.fail(function (jqXHR, textStatus) {
			console.log(jqXHR);
		});
		
	});
}