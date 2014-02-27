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
		
		foreach ($cuentasAdmin as $key => $value) {
			switch ($value->type) {
				case 'TRAMA':
					$value->url ='<a href="index.php?option=com_admincuentas&task=traspasocuentas&idAccount='.$value->id.'" class="button">'.
						  			JText::_('COM_ADMINCUENTAS_LISTADOCUENTAS_TRASPASO').
						 		 '</a>';		
					break;
				case 'BRIDGE':
					$value->url ='<a href="#" class="button">'.
						  			JText::_('COM_ADMINCUENTAS_LISTADOCUENTAS_TRANSFERENCIA').
						 		 '</a>';		
					break;
				
				default:
					
					break;
			}
			
		}
		return $cuentasAdmin;
	}
}