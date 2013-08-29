/*funciones para copiar informacion de campos*/
function datosxCP() {
	console.log('algo');
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

function loadImage(input1) {
    var input, file, fr, img;

    if (typeof window.FileReader !== 'function') {
        write("The file API isn't supported on this browser yet.");
        return;
    }

    input = document.getElementById(input1.id);
    if (!input) {
        write("Um, couldn't find the imgfile element.");
    }
    else if (!input.files) {
        write("This browser doesn't seem to support the `files` property of file inputs.");
    }
    else if (!input.files[0]) {
        write("Please select a file before clicking 'Load'");
    }
    else {
        file = input.files[0];
        fr = new FileReader();
        fr.onload = createImage;
        fr.readAsDataURL(file);
    }
	
	var fileInput = jQuery('#'+input1.id)[0];
    peso = fileInput.files[0].size;
	
    function createImage() {
        img = document.createElement('img');
        img.onload = imageLoaded;
        img.style.display = 'none'; // If you don't want it showing
        img.src = fr.result;
        document.body.appendChild(img);
    }

    function imageLoaded() {
		if(img.width > 1920 || img.height > 1200 || img.width < 400 || img.height < 300 || peso  > 4194304){
			
			
		alert ("Solo se aceptan imagenes de resolucion entre 400 x 300, 1920 x 1080 y con un peso no mayor a 2 mb, su imagen no sera subida. ");
		$fileupload = $('#'+input1.id);  
		$fileupload.replaceWith($fileupload.clone(true)); 
		$('#'+input1.id).val(""); 
        // This next bit removes the image, which is obviously optional -- perhaps you want
        // to do something with it!
        img.parentNode.removeChild(img);
        img = undefined;}
        
    }


}