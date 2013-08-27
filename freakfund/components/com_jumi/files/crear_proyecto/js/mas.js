var counter = 0;

function moreFields() {
	counter++;
	var newFields = document.getElementById('readroot').cloneNode(true);
	newFields.id = '';
	newFields.style.display = 'block';
	var newField = newFields.childNodes;
	for (var i=0;i<newField.length;i++) {
		var theName = newField[i].name
		if (theName)
			newField[i].name = theName + counter;
	}
	var insertHere = document.getElementById('writeroot');
	insertHere.parentNode.insertBefore(newFields,insertHere);
}

jQuery(document).ready(function(){

jQuery("#form2 select").click(function() {
	
	var seleccion = jQuery(this).find('option:selected');
	temp = seleccion.text();
	bandera = jQuery(this).attr("id");
	
	if (bandera == 'selectCategoria') {
		
		var subSeleccion = jQuery('#subcategoria').find('option:selected');
		tmpSub = subSeleccion.text();
		
	} else if (bandera == 'subcategoria') {
		
		var subSeleccion = jQuery('#selectCategoria').find('option:selected');
		tmpSub = subSeleccion.text();
		
	}
	
});

jQuery("#form2 select").change(function(){

	var categoriaSeleccionada = jQuery(this).find('option:selected');
	var selectedCategoria = categoriaSeleccionada.text();
	var valortextarea = $('#tagsArea').val();

	if (valortextarea == "") {

	    $('#tagsArea').val(selectedCategoria);

	} else {

	    var arreglo = valortextarea.split(',');
	    var cuantos = arreglo.length;
	    	    
	    arrayCat = findReplace(cuantos, selectedCategoria, arreglo, temp, tmpSub);
	    valor_final = arrayCat.join(',');
	    $('#tagsArea').val(valor_final);

	}

});

function findReplace(cuantos, valor, arreglo, tmpCategoriaSeleccionada, tmpSubCategoriaSeleccionada) {

	for (var i = 0; i < cuantos; i++) {

	    if (arreglo[i] == valor || arreglo[i] == tmpCategoriaSeleccionada || arreglo[i] == tmpSubCategoriaSeleccionada) {
	    
	        arreglo[i] = valor;
	        
	        break;

	    } else if (i == cuantos-1){

	        arreglo[cuantos] = valor;

	    }

	}

	return arreglo;

}

emptyKeys();

});

function emptyKeys() {

	var valorKeysArea = $('#tagsArea').val();

	if (valorKeysArea == "") {

		var catSeleccionada = jQuery('#selectCategoria').find('option:selected');
		temp = catSeleccionada.text();
		var subCatSeleccionada = jQuery('#subcategoria').find('option:selected');
		tmpSub = subCatSeleccionada.text();

		$('#tagsArea').val(tmpSub+','+temp);

	}
	
}
//validacion banner
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
		if(img.width > 1920 || img.height > 1200 || img.width < 800 || img.height < 600 || peso  > 4096000){
			
			
		alert ("Solo se aceptan imagenes de resolucion entre 800 x 600, 1920 x 1080 y con un peso no mayor a 4 mb, su imagen no sera subida. ");
		$fileupload = $('#'+input1.id);  
		$fileupload.replaceWith($fileupload.clone(true)); 
		$('#'+input1.id).val(""); 
        // This next bit removes the image, which is obviously optional -- perhaps you want
        // to do something with it!
        img.parentNode.removeChild(img);
        img = undefined;}
        
    }


}
//validacion avatar
function loadImage2(input1) {
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
		if(img.width > 600 || img.height > 600 || img.width < 360 || img.height < 360 || peso  > 4096000){
			
			
		alert ("Solo se aceptan imagenes de resolución entre 1920x1200 y 800x600, y con un peso no mayor a 4 mb, su imagen no sera subida. ");
		$fileupload = $('#'+input1.id);  
		$fileupload.replaceWith($fileupload.clone(true)); 
		$('#'+input1.id).val(""); 
        // This next bit removes the image, which is obviously optional -- perhaps you want
        // to do something with it!
        img.parentNode.removeChild(img);
        img = undefined;}
        
    }
}