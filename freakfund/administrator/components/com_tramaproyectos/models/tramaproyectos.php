<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * TramaProyectos Model
 */
class TramaProyectosModelTramaProyectos extends JModelList
{
        /**
         * load the list data.
         *
         * @return      string  An SQL query
         */
        public function getDatos()
        {
        	$query = json_decode(file_get_contents(MIDDLE.PUERTO.'/trama-middleware/rest/project/all'));
			
			return $query;
        }
}
