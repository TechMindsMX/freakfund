<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');

class RedemptioncodesModelRedemptioncodes extends JModelList {

	public function getDatos() {
		// 5 Autorizado = Financiamiento
		// 6 Producción
		$statuses = '5,6'; 
		$proy = JTrama::getProyByStatus($statuses);
		foreach ($proy as $key => $value) {
			$value->statusName = JTrama::getStatusName($value->status);
		}

		$resultado = $proy;

		return $resultado;
	}

}
