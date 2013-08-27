<?php
defined('_JEXEC') or die( 'Restricted access' );

$tabla = "perfilx_respuestas";

$var = $_POST;
	foreach ($var as $key => $value) {
		if ((is_numeric($value)) && ($key != 'usuario') && ($key !='controlador')) {
			$valor[] = $value;
		}
		if ($key == 'usuario') {
			$idjoom = $value;
		}
		elseif ($key == 'campo') {
			$campo = $value;
		}
		elseif ($key == 'controlador') {
			$control = $value;
		}
	}

$valor = implode(',', $valor);

function insertar($tabla, $campo, $valor, $idjoom){

	$db = JFactory::getDbo();

	$query = $db->getQuery(true);

	$columns = array($campo, 'users_id');
	$values = array($db->quote($valor), $db->quote($idjoom));
	
	$query
		->insert($db->quoteName($tabla))
		->columns($db->quoteName($columns))
		->values(implode(',', $values));
	
	$db->setQuery($query);
	$db->query();
	
	redirecciona(JText::_('DATOS_GUARDADOS'));
}

function actualizar($tabla, $campo, $valor, $idjoom){

	$db = JFactory::getDbo();

	$query = $db->getQuery(true);

	$fields = (
		'`'.$campo.'` = \'' .$valor.'\'');
	
	$conditions = (
		'`users_id` = ' .$idjoom);
	
	$query->update($db->quoteName($tabla))->set($fields)->where($conditions);
	
	$db->setQuery($query);
	$db->query();
	
	redirecciona(JText::_('DATOS_ACTUALIZADOS'));
}

function dataRecord($tabla, $campo, $valor, $idjoom, $control){
	
		if(empty($control)){
			insertar($tabla, $campo, $valor, $idjoom);
		}else{
			actualizar($tabla, $campo, $valor, $idjoom);
		}
}

function redirecciona($msg) {
	$app = JFactory::getApplication();
	$link = Juri::base();
	$app->redirect($link, $msg, $msgType='message');
}

dataRecord($tabla, $campo, $valor, $idjoom, $control);




?>