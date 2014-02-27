
(function($){
    $.fn.validationEngineLanguage = function(){
    };
    $.validationEngineLanguage = {
        newLang: function(){
            $.validationEngineLanguage.allRules = {
            	"numcuenta":{
            		"regex": /^[u|p]{1}|[0-9]{10}$/,
            		"alertText": 'numero de cuenta no valido',
            	},
                "required": { // Add your regex rules here, you can take telephone as an example
                    "regex": "none",
                    "alertText": "* Este campo es obligatorio",
                    "alertTextCheckboxMultiple": "* Por favor seleccione una opción",
                    "alertTextCheckboxe": "* Este checkbox es obligatorio"
                },
                "requiredInFunction": { 
                    "func": function(field, rules, i, options){
                        return (field.val() == "test") ? true : false;
                    },
                    "alertText": "* Field must equal test"
                },
                "funciondate": {
                	"func": function(field, rules, i, options){
                		var valorCampo = '';
                		var fechaCampo = new Date();
                		var hoy = new Date();
                		var respuesta = true;
                		
                		if(validaFechaDDMMAAAA(field.val())){
                			valorCampo = field.val().split('-');
							fechaCampo.setFullYear(valorCampo[2],valorCampo[1]-1,valorCampo[0])                		
                		}
                		return ( hoy <= fechaCampo ) ? true : false;
                	},
                	"alertText": "* La fecha no puede ser menor a "+new Date().getDate()+'-'+(new Date().getMonth()+1)+'-'+new Date().getFullYear()
                },
                "valitiny": {
                	"func":function (field) {
                		var respuesta = false;
                		var tiny = $('#description_ifr').contents().find('.mceContentBody p').text();
                		
                		if (tiny != '') {
                			respuesta = true;
                		} else {
                			respuesta = false;
                		}
                		
                		return respuesta;
                	},
                	"alertText": "el campo es requerido"
                },
                "fininicio": {
                	"func": function ( field ) {
                		if(validaFechaDDMMAAAA(field.val())){
						    var fecha = field.val();
						    var fechaminima = jQuery('#productionStartDate').val();
						    var arrayfecha = fecha.split('-');
						    var arrayfechamin = fechaminima.split('-');
						    var date1 = new Date();
						    var date2 = new Date();
						    var date3 = new Date();
						    
						    date1.setFullYear(arrayfecha[2],parseInt(arrayfecha[1])-1,parseInt(arrayfecha[0]));
						    date2.setFullYear(arrayfechamin[2],parseInt(arrayfechamin[1])-1,parseInt(arrayfechamin[0])+120);
						    date3.setFullYear(arrayfechamin[2],parseInt(arrayfechamin[1])-1,parseInt(arrayfechamin[0]));
						}
						
						return (date1 > date2) && (date1 > date3) ? true : false;
                	},
                	"alertText": "* La Fecha no puede ser menor de 120 dias del inicio de producción ni ser menor a la fecha de lanzamiento"
                },
                "cierre": {
                	"func": function ( field ) {
                		if(validaFechaDDMMAAAA(field.val())){
						    var fecha = field.val();
						    var fechaminima = jQuery('#premiereStartDate').val();
						    var arrayfecha = fecha.split('-');
						    var arrayfechamin = fechaminima.split('-');
						    var date1 = new Date();
						    var date2 = new Date();
						    
						    date1.setFullYear(arrayfecha[2],parseInt(arrayfecha[1])-1,parseInt(arrayfecha[0]));
						    date2.setFullYear(arrayfechamin[2],parseInt(arrayfechamin[1])-1,parseInt(arrayfechamin[0]));
						}
						
						return (date1 > date2) ? true : false;
                	},
                	"alertText": "* La Fecha no puede ser menor a la fecha de lanzamiento"
                },
                "minSize": {
                    "regex": "none",
                    "alertText": "* Mínimo de ",
                    "alertText2": " caracteres autorizados"
                },
				"groupRequired": {
                    "regex": "none",
                    "alertText": "* Debe de rellenar al menos uno de los siguientes campos"
                },
                "maxSize": {
                    "regex": "none",
                    "alertText": "* Máximo de ",
                    "alertText2": " caracteres autorizados"
                },
		        "min": {
                    "regex": "none",
                    "alertText": "* El valor mínimo es "
                },
                "max": {
                    "regex": "none",
                    "alertText": "* El valor máximo es "
                },
		        "past": {
                    "regex": "none",
                    "alertText": "* Fecha anterior a "
                },
                "future": {
                    "regex": "none",
                    "alertText": "* Fecha posterior a "
                },	
                "maxCheckbox": {
                    "regex": "none",
                    "alertText": "* Se ha excedido el número de opciones permitidas"
                },
                "minCheckbox": {
                    "regex": "none",
                    "alertText": "* Por favor seleccione ",
                    "alertText2": " opciones"
                },
                "equals": {
                    "regex": "none",
                    "alertText": "* Los campos no coinciden"
                },
                "creditCard": {
                    "regex": "none",
                    "alertText": "* La tarjeta de crédito no es válida"
                },
                "phone": {
                    // credit: jquery.h5validate.js / orefalo
                    "regex": /^[0-9]{10}$/,
                    "alertText": "* Número de teléfono inválido"
                },
                "email": {
                    // Shamelessly lifted from Scott Gonzalez via the Bassistance Validation plugin http://projects.scottsplayground.com/email_address_validation/
                    "regex": /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,
                    "alertText": "* Correo inválido"
                },
                "integer": {
                    "regex": /^[\-\+]?\d+$/,
                    "alertText": "* No es un valor entero válido"
                },
                "number": {
                    // Number, including positive, negative, and floating decimal. credit: orefalo
                    "regex": /^\d{1,9}(\.\d{0,2})?$/,
                    "alertText": "* No es un valor decimal válido"
                },
                "date": {
                    "func": function (field){
                		return validaFechaDDMMAAAA(field.val());
                	},
                    "alertText": "* Fecha inválida, por favor utilize el formato DD-MM-AAAA"
                },
                "ipv4": {
                	"func": /^((([01]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))[.]){3}(([0-1]?[0-9]{1,2})|(2[0-4][0-9])|(25[0-5]))$/,
                    "alertText": "* Direccion IP inválida"
                },
                "url": {
                    "regex": /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i,
                    "alertText": "* URL Inválida"
                },
                "onlyNumberSp": {
                    "regex": /^[0-9\ ]+$/,
                    "alertText": "* Sólo números"
                },

                "onlyNumberRenta": {
                    "regex": /^(?:100(?:\.0)?|[1-9][0-9]?(?:\.[0-9][0-9]?)?|1?\.[0-9][0-9]?)$/,
                    "alertText": "* Sólo números,la tasa debe ser entre 1 y 100% y hasta 2 decimales"
                },
                "onlyNumberISEP": {
                    "regex": /^(?:12(?:\.0)?|[4-9](?:\.[0-9][0-9]?)?|1[01](?:\.[0-9][0-9]?)?|4?\.[0-9][0-9]?)$/,
                    "alertText": "* Sólo números,la tasa debe ser entre 4 y 12% y hasta 2 decimales"
                },
                "onlyNumberTiket": {
                    "regex": /^(?:10(?:\.0)?|[1-9](?:\.[0-9][0-9]?)?|1?\.[0-9][0-9]?)$/,
                    "alertText": "* Sólo números,la tasa debe ser entre 1 y 10% y hasta 2 decimales"
                },
                "onlyNumberSOGEM": {
                    "regex": /^(?:20(?:\.0)?|[1-9](?:\.[0-9][0-9]?)?|1[0-9](?:\.[0-9][0-9]?)?|1?\.[0-9][0-9]?)$/,
                    "alertText": "* Sólo números,la tasa debe ser entre 1 y 20% y hasta 2 decimales"
                },
			    "onlyLetterSp": {
                    "regex": /^[a-zA-Z ñ Ñ á Á éÉ íÍ óÓ úÚ \ . \']+$/,
                    "alertText": "* Sólo letras"
                },
				"rfc": {
                    "regex": /^[A-Z]{3,4}([0-9]{2})(1[0-2]|0[1-9])([0-3][0-9])([A-Z0-9]{3,4})$/,
                    "alertText": "* RFC inválida "
                },
				
                "yt": {
                    "func": function (field){
                    	var regyt = /https?:\/\/(?:youtu\.be\/|(?:[a-z]{2,3}\.)?youtube\.com\/watch(?:\?|#\!)v=)([\w-]{11}).*/gi;
                    	var regvi = /http?:\/\/(?:www\.)?(vimeo|youtube)\.com\/(?:watch\?v=)?(.*?)(?:\z|$|&)/;
                    	var campo = field.val();
                    	
                    	if ( (campo.match(regyt)) || (campo.match(regvi)) ) {
                    		regreso = true;
	                    } else {
	                    	regreso = false;
	                    }
	                    	return regreso;
                    },                
                	"alertText":"* Enlace inválido (Solo enlaces de Youtube o Vimeo)"
                },
				"sc": {
                    "regex": /^https?:\/\/(?:www\.)?soundcloud\.com\/[A-Za-z0-9]+(?:[-_][A-Za-z0-9]+)*(?!\/sets(?:\/|$))(?:\/[A-Za-z0-9]+(?:[-_][A-Za-z0-9]+)*){1,2}\/?$/,
                    "alertText": "* Enlace Soundcloud inválido "
                },
                "onlyLetterNumber": {
                    "regex": /^[0-9a-zA-Z ñ Ñ á Á éÉ íÍ óÓ úÚ . ]+$/,
                    "alertText": "* No se permiten caracteres especiales"
                },
				// --- CUSTOM RULES -- Those are specific to the demos, they can be removed or changed to your likings
                "ajaxUserCall": {
                    "url": "ajaxValidateFieldUser",
					// you may want to pass extra data on the ajax call
                    "extraData": "name=eric",
                    "alertTextLoad": "* Cargando, espere por favor",
                    "alertText": "* Este nombre de usuario ya se encuentra usado"
                },
                "ajaxNameCall": {
					// remote json service location
                    "url": "ajaxValidateFieldName",
					// error
                    "alertText": "* Este nombre ya se encuentra usado",
					// if you provide an "alertTextOk", it will show as a green prompt when the field validates
                    "alertTextOk": "* Este nombre está disponible",
					// speaks by itself
                    "alertTextLoad": "* Cargando, espere por favor"
                },
                "validate2fields": {
                    "alertText": "* Por favor entrar HELLO"
                }
            };
            
        }
    };
    $.validationEngineLanguage.newLang();
})(jQuery);

function validaFechaDDMMAAAA(fecha){
	var dtCh= "-";
	var minYear=1900;
	var maxYear=2100;
	function isInteger(s){
		var i;
		for (i = 0; i < s.length; i++){
			var c = s.charAt(i);
			if (((c < "0") || (c > "9"))) return false;
		}
		return true;
	}
	function stripCharsInBag(s, bag){
		var i;
		var returnString = "";
		for (i = 0; i < s.length; i++){
			var c = s.charAt(i);
			if (bag.indexOf(c) == -1) returnString += c;
		}
		return returnString;
	}
	function daysInFebruary (year){
		return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
	}
	function DaysArray(n) {
		for (var i = 1; i <= n; i++) {
			this[i] = 31
			if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
			if (i==2) {this[i] = 29}
		}
		return this
	}
	function isDate(dtStr){
		var daysInMonth = DaysArray(12)
		var pos1=dtStr.indexOf(dtCh)
		var pos2=dtStr.indexOf(dtCh,pos1+1)
		var strDay=dtStr.substring(0,pos1)
		var strMonth=dtStr.substring(pos1+1,pos2)
		var strYear=dtStr.substring(pos2+1)
		strYr=strYear
		if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
		if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
		for (var i = 1; i <= 3; i++) {
			if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
		}
		month=parseInt(strMonth)
		day=parseInt(strDay)
		year=parseInt(strYr)
		if (pos1==-1 || pos2==-1){
			return false
		}
		if (strMonth.length<1 || month<1 || month>12){
			return false
		}
		if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
			return false
		}
		if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
			return false
		}
		if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
			return false
		}
		return true
	}
	if(isDate(fecha)){
		return true;
	}else{
		return false;
	}
}
