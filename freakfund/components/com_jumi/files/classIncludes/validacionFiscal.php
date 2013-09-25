<?php

defined('_JEXEC') OR defined('_VALID_MOS') OR die( "Direct Access Is Not Allowed" );

function validacionFiscal($usuario){
	
	$userType = tipoUsuario($usuario->id);
	
	if(isset($userType) && $userType->perfil_personalidadJuridica_idpersonalidadJuridica != 1){

		$datosFiscales = datosFiscales($userType->id);
		
		if(!isset($datosFiscales)){
			
			$allDone =& JFactory::getApplication();
			$allDone->redirect('index.php?option=com_jumi&view=application&fileid=13', 'Para poder crear un proyecto tienes que llenar tus datos fiscales' );
		
		}
		
	} else {
		
		$allDone =& JFactory::getApplication();
		$allDone->redirect('index.php?option=com_jumi&view=application&fileid=5', 'Persona Fisica con Actividad Empresarial o Moral' );
	
	}
	
}

function tipoUsuario($usuario){
	
	$usuarioGeneral = 1;
	
	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);
	
	$query
		->select('*')
		->from('perfil_persona')
		->where('users_id = '.$usuario.' && perfil_tipoContacto_idtipoContacto = ' .$usuarioGeneral);
	
	$db->setQuery( $query );
	
	$resultado = $db->loadObject();
	
	return $resultado;
	
}

function datosFiscales($usuario){
	
	$db =& JFactory::getDBO();
	$query = $db->getQuery(true);
	
	$query
		->select('*')
		->from('perfil_datosfiscales')
		->where('perfil_persona_idpersona = '.$usuario);
	
	$db->setQuery( $query );
	
	$resultado = $db->loadObject();
	
	return $resultado;
	
}
?>