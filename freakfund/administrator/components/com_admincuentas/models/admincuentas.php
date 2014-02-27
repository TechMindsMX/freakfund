<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
jimport('trama.class');
jimport('trama.usuario_class');

class admincuentasModeladmincuentas extends JModelList
{
	public function getlistadoCuentas() {
		$cuentasAdmin = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/bank/listAdministrativeAccounts'));

		return $cuentasAdmin;
	}
}