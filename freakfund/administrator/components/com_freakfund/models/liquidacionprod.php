<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class liquidacionprodModelliquidacionprod extends JModelList
{
    public function getDatosProductor() {
    	$temporal = JFactory::getApplication()->input;
		$temporal = $temporal->get('id');
		
		$query = JTrama::getDatos($temporal);

		$query->token = JTrama::token();
		$query->callback = JURI::base().'index.php?option=com_freakfund';
		$query->errorCallback = JURI::base().'index.php?option=com_freakfund&task=errors';
		
		$query->productorName = self::getProductorName($query->userId);

		return $query;
		
    }
	public function getProductorName( $idMiddleware )
	{
		return JFactory::getUser(UserData::getUserJoomlaId($idMiddleware))->name;
	}

}