<?php
defined('_JEXEC') or die ;

jimport('joomla.application.component.controlleradmin');

class RedemptioncodesControllerRedemptioncodes extends JControllerAdmin {

	public function __construct($config = array()) {
		parent::__construct($config);

		$this -> registerTask('block', 'changeBlock');
		$this -> registerTask('unblock', 'changeBlock');
	}


}
