<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.modellist');

class proveedoresModelproveedores extends JModelList
{		
		public function getproveedores(){
			$temporal = JFactory::getApplication()->input;
			$temporal = $temporal->get('id');
			
			$datos = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/get/'.$temporal));
			
			return $datos;
		}
}