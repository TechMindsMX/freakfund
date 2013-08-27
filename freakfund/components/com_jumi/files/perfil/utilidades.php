<?php
class getDatosObj {
	function existingUser($idUsuario){
		
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		
		$query
			->select('users_id')
			->from('perfil_persona')
			->where('users_id = '.$idUsuario);
		
		$db->setQuery( $query );
		
		$resultado = $db->loadObjectList();
		
		if (isset($resultado[0])) {
			$existe = 1;
		} else {
			$existe = 0;
		}
		
		return $existe;
		
	}
	
	function datosGenerales($idUsuario, $tipoContacto){
	
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
	
		$query
			->select('*')
			->from('perfil_persona')
			->where('users_id = '.$idUsuario.' && perfil_tipoContacto_idtipoContacto = ' .$tipoContacto);
			
		$db->setQuery( $query );
	
		$resultado = $db->loadObject();
		return $resultado;
	
	}
	
	function domicilio($idPersona, $tipoDireccion){
	
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
	
		$query
		->select('*')
		->from('perfil_direccion')
		->where('perfil_persona_idpersona = '.$idPersona.' && perfil_tipoDireccion_idtipoDireccion = ' .$tipoDireccion);
	
		$db->setQuery( $query );
	
		$resultado = $db->loadObject();
		
		return $resultado;
	
	}
	
	function email($idPersona){
	
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
	
		$query
		->select('*')
		->from('perfil_email')
		->where('perfil_persona_idpersona = '.$idPersona);
	
		$db->setQuery( $query );
	
		$resultado = $db->loadObjectList();
	
		return $resultado;
	
	}
	
	function telefono($idPersona){
	
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
	
		$query
		->select('*')
		->from('perfil_telefono')
		->where('perfil_persona_idpersona = '.$idPersona);
	
		$db->setQuery( $query );
	
		$resultado = $db->loadObjectList();
	
		return $resultado;
	
	}
	
	function datosFiscales($idPersona){
	
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
	
		$query
		->select('*')
		->from('perfil_datosfiscales')
		->where('perfil_persona_idpersona = '.$idPersona);
	
		$db->setQuery( $query );
	
		$resultado = $db->loadObject();
	
		return $resultado;
	
	}
	
	function proyectosPasados($idPersona){
	
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
	
		$query
		->select('*')
		->from('perfil_historialproyectos')
		->where('perfil_persona_idpersona = '.$idPersona);
	
		$db->setQuery( $query );
	
		$resultado = $db->loadObjectList();
	
		return $resultado;
	
	}
	
	function insertFields($tabladb, $col, $val){
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
			->insert($db->quoteName($tabladb))
			->columns($db->quoteName($col))
			->values(implode(',', $val));
		//echo $query.'<br />';
		$db->setQuery( $query );
		$db->query();
	}
	
	function updateFields($tabladb, $fields, $conditions){
		$db =& JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
			->update($db->quoteName($tabladb))
			->set($fields)
			->where($conditions);
		//echo $query.'<br />';
		$db->setQuery( $query );
		$db->query();
	}
	
	function deleteFields($tabladb, $conditions){
	
		$db = JFactory::getDBO();
		
		$query = $db->getQuery(true);
		
		$query
			->delete($db->quoteName($tabladb))
			->where($conditions);
		//echo $query.'<br />';
		$db->setQuery($query);
		$db->query();
	}	
}
?>
