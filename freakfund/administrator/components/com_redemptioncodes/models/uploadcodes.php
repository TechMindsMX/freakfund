<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');

class RedemptioncodesModelSavecsv extends JModelList {

	public function savefile() {
		// 5 Autorizado = Financiamiento
		// 6 Producción
		$doc = JFactory::getApplication();
		$input = $doc->input;
		
		$proId = $input->get('proyid', 'STR');
		
		$proy = JTrama::getDatos($proId);
		
		$proy->redemptioncodes = JTrama::getRedemptionCodes($proy);
		
		$resultado = $proy;

		return $resultado;
	}
}
