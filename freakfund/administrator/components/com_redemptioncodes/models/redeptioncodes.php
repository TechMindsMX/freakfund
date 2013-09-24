<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');

class RedemptioncodesModelRedemptioncodes extends JModelList {

	public function getDatos() {
		$db = JFactory::getDBO();
		$query = $db -> getQuery(true);

		$query 
			-> select("b.users_id, c.*, ju.*, a.nomNombreCategoria") 
			-> from("perfilx_catalogoperfil a, perfilx_respuestas b")
			-> join('LEFT', 'perfil_persona AS c ON ( b.users_id = c.users_id AND c.perfil_tipoContacto_idtipoContacto =1 )' )
			-> join('LEFT', '#__users AS ju ON (b.users_id = ju.id)')
			-> where("a.nomNombreCategoria = 'Gremios' AND FIND_IN_SET(a.idcatalogoPerfil, b.respuestaPerfil) OR a.nomNombreCategoria = 'Instituciones' AND FIND_IN_SET(a.idcatalogoPerfil, b.respuestaPerfil)");

		$db -> setQuery($query);

		$resultado = $db -> loadObjectList();

		return $resultado;
	}

}
