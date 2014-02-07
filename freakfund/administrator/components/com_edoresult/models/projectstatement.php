<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class projectStatementModelprojectStatement extends JModelList{
	public function getprojectStatement() {
		$valorget = JFactory::getApplication()->input;
		$valorget = $valorget->get('id');
		
		$dataProyecto = JTrama::getStateResult($valorget);
		
		return $dataProyecto;
	}

}