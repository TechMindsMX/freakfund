<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class listadoModellistado extends JModelList{
	public function getlistadoproyectos() {
		$proyectos 	= JTrama::getProyByStatus('5,10,6,7,8,11');
		$proyectos 	= UserData::getusersData($proyectos, 'edoResult');

		return $proyectos;
	}
}