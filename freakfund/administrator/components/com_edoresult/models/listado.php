<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class listadoModellistado extends JModelList{
	public function getlistadoproyectos() {
		$db 	= JFactory::getDbo();
		$query 	= $db->getQuery(true); 
		
		$query->select ('c3rn2_users.name, c3rn2_users_middleware.idJoomla, c3rn2_users_middleware.idMiddleware')
			  ->from ('c3rn2_users')
			  ->join('INNER', 'c3rn2_users_middleware ON c3rn2_users_middleware.idJoomla = c3rn2_users.id')
			  ->where('idJoomla != 378');
		
		$db->setQuery($query);
		$results = $db->loadObjectList();

		$proyectos = JTrama::getProyByStatus('5,10,6,7,8,11');

		foreach ($proyectos as $key => $value) {
			foreach ($results as $llave => $valor) {
				if($value->userId == $valor->idMiddleware){
					$value->idJoomla 		= $valor->idJoomla;
					$value->prodName 		= $valor->name;
					$value->ligaEdoResult 	= 'index.php?option=com_edoresult&task=projectstatement&id='.$value->id; 
				}
			}
		}		
		return $proyectos;
	}
}