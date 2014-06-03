<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class listadoModellistado extends JModelList{
	public function getlistadoproyectos() {
		$proyectos = JTrama::allProjects();
		$status = array(5,10,6,7,8,11);
		
		foreach ($proyectos as $key => $value) {
			if(in_array($value->status, $status)){
				$proyectosfiltrados[] = $value;
			}
		}
		
		$proyectosfiltrados = UserData::getusersData($proyectosfiltrados, 'edoResult');
		
		return $proyectosfiltrados;
	}
}