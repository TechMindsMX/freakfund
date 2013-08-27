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
			console.log(obj);
			console.log(select_edos);
			
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