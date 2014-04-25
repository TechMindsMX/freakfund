<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class capturaventasModelcapturaventas extends JModelList{
	public function getDatos () {
		$app = JFactory::getApplication();
		$input = $app->input;
		$id = $input->get('id');
		
		$datos = JTrama::getDatos($id);
		
		return $datos;
	}
}