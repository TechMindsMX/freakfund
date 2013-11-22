<?php
	$usuario = JFactory::getUser();
	$document = JFactory::getDocument();
	$base = JUri::base();
	$pathJumi = $base.'/libraries/trama/';
	
	$scriptselect = 'jQuery(function() {
		jQuery("#subcategoria").chained("#selectCategoria");	
	});';
	
	$document->addStyleSheet($pathJumi.'css/validationEngine.jquery.css');
	$document->addStyleSheet($pathJumi.'css/form2.css');
if(isset($libreriaGoogle)){
	echo '<script src="'.$pathJumi.'js/maps.js"> </script>';
}
	echo '<script src="'.$pathJumi.'js/misjs.js"> </script>';
	echo '<script src="'.$pathJumi.'js/mas.js"> </script>';
	echo '<script src="'.$pathJumi.'js/jquery.mask.js"> </script>';
	echo '<script src="'.$pathJumi.'js/jquery.validationEngine-es.js"> </script>';
	echo '<script src="'.$pathJumi.'js/jquery.validationEngine.js"> </script>';
	echo '<script src="'.$pathJumi.'js/jquery.chained.js"> </script>';
	$document->addScriptDeclaration($scriptselect);
?>