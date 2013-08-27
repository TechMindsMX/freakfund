<?php

defined('_JEXEC') or die('Restricted access');

class TramaGremiosModelBlock extends JModel 
{
	
	public function block($ids, $value) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$ids= implode(',', $ids);			

		$fields = 'block = '.$value;
		$conditions = 'id = '.$ids;
		
		$query->update($db->quoteName('#__users'))
				->set($fields)
				->where($conditions);

		$db->setQuery($query);
		 
		try {
		    $result = $db->query(); // Use $db->execute() for Joomla 3.0.
			return true;
		    		} catch (Exception $e) {
		    return flase;
		}
	}
	
}
