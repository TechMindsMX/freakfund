<?php
defined('JPATH_PLATFORM') or die ;

class JFactoryExtended extends JFactory 
{
	protected $specialid = '';
	
	public function userGroupNames() {
		$db = JFactory::getDbo();
		$query = 'SELECT id, title' . ' FROM `#__usergroups`';
		$db -> setQuery($query);
		$this -> groupNames = $db -> loadObjectList();

		return $this -> groupNames;
	}

	public function getSpecialViewlevel() {
		$db = JFactory::getDbo();
		$query = 'SELECT id, title' . ' FROM `#__viewlevels`';
		$db -> setQuery($query);
		$viewlevelsNames = $db -> loadObjectList();
		foreach ($viewlevelsNames as $key => $value) {
			if ($value->title == 'Special') {
					$this->specialid = $value->id;
			}
			
		}	
		return $this -> specialid;

	}

}
