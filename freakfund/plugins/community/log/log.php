<?php
/**
 * @category	Plugins
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php');

if(!class_exists('plgCommunityLog'))
{
	class plgCommunityLog extends CApplications
	{
		var $name		= 'Log';
		var $_name		= 'log';
	
	    function plgCommunityLog(& $subject, $config)
	    {
			parent::__construct($subject, $config);
			
			$db				= JFactory::getDBO();
			$query ="
			CREATE TABLE IF NOT EXISTS #__community_access_log (
				`user_hash` VARCHAR( 50 ) NOT NULL ,
				`controller` VARCHAR( 50 ) NOT NULL ,
				`task` VARCHAR( 50 ) NULL ,
				`datetime` TIMESTAMP NOT NULL ,
				`domain` VARCHAR( 50 ) NOT NULL
			) ENGINE = MYISAM ;";
			$db->setQuery( $query );
			$db->query();
	    }
		
		function onSystemStart() {
			$domain = $_SERVER['HTTP_HOST'];
			$task = JRequest::getVar('task', '');
			$controller = JRequest::getVar('view', '');
			$user_hash = md5(JFactory::getUser()->username);
			
			$db				= JFactory::getDBO();
			
			$data				= new stdClass();
			$data->domain		= $_SERVER['HTTP_HOST'];
			$data->task		= JRequest::getVar('task', '');
			$data->controller		= JRequest::getVar('view', '');
			$data->user_hash	= md5(JFactory::getUser()->username);

			$db->insertObject( '#__community_access_log' , $data );
		}
		
		public static function export(){
			$db = JFactory::getDBO();
			$query = 'SELECT * FROM ' . $db->nameQuote('#__community_access_log');
			$db->setQuery($query);
			$res = $temp_res = $db->loadRowList();
			$results = json_encode($res);
			
			//only upload if there is a data
			$response = '';
			if(isset($temp_res[0][0]) && $temp_res[0][0] != ''){
				$url = 'http://logs.jomsocial.com/retrievelog.php';  // url to send the log to
				
				$curl=curl_init($url);
				curl_setopt($curl, CURLOPT_HEADER, 0);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($curl, CURLOPT_POST,1);
				curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,FALSE);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
				curl_setopt($curl,CURLOPT_POSTFIELDS,'info='.$results);
				
				$response = curl_exec($curl);
				curl_close($curl);
			}else{
				return false;
			}
			
			if($response == 'ok'){
				//empty the table
				$query = "TRUNCATE TABLE ".$db->nameQuote('#__community_access_log');
				$db->setQuery($query);
				$db->query();
				return true;
			}else{
				return false;
			}
		}
	}	
}

