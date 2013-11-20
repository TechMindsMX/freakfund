<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class aportacionesacapitalModelaportacionesacapital extends JModelList
{
	public function getlistadoProyectos() {
		$proyectos = JTrama::getProyByStatus('5');
		
		foreach ($proyectos as $key => $value) {
			$value->toBreakeven = $value->breakeven - $value->balance;
			$value->toBreakevenPercentage = round(( $value->balance / $value->breakeven ) * 100, 2 );

			self::producerIdJoomlaANDName($value);
		}
		
		return $proyectos;
	}

	public function producerIdJoomlaANDName($obj,$id=null){
		if($id == null){
			$id = $obj->userId;
		}
		
		$obj->idJoomla = UserData::getUserJoomlaId($id);
		$obj->producerName = JFactory::getUser($obj->idJoomla)->name;
	}
}