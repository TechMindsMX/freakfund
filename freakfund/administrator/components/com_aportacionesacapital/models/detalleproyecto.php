<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class detalleProyectoModeldetalleProyecto extends JModelList
{
	public function getdetalleProy() {
		$idProy = JFactory::getApplication()->input;
		$idProy = $idProy->get('id');
		
		$detalleProyecto = JTrama::getDatos($idProy);
		
		self::producerIdJoomlaANDName($detalleProyecto);
		
		foreach ($detalleProyecto->providers as $key => $value) {
			self::producerIdJoomlaANDName($value, $value->providerId);
		}
		
		return $detalleProyecto;
	}

	public function producerIdJoomlaANDName($obj,$id=null){
		if($id == null){
			$id = $obj->userId;
		}
		
		$obj->idJoomla = UserData::getUserJoomlaId($id);
		$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
}