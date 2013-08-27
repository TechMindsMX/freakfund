<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/libraries/core.php' );

class modGroupPosthelper
{
	static public function getStream( &$params )
	{
		//since @2.6
		$db		= JFactory::getDBO();
		$query = '';
		//if user is logged in, depends on the settings, either to display updates from participated group or all public groups
		if($params->get('afterlogin_setting') && JFactory::getUser()->id){
			//first lets get the user participated group
			//CFactory::load( 'models' , 'groups' );		
			$groupsModel	= CFactory::getModel('groups');
			
			$groupIds = $groupsModel -> getGroupIds(JFactory::getUser()->id);
			$groupIds = implode(',',$groupIds);
			
			if(empty($groupIds)) return array();
			
			$query	= 'SELECT a.*, b.' . $db->quoteName('name').' AS groupname, b.' . $db->quoteName('thumb').' AS thumbnail
					   FROM ' . $db->quoteName( '#__community_activities' ) . ' AS a '
					. 'INNER JOIN '.  $db->quoteName( '#__community_groups' ) . ' AS b '
					. ' ON b.' . $db->quoteName('id').'=a.' . $db->quoteName('groupid')
					. ' WHERE a.' . $db->quoteName( 'app' ) . '=' . $db->Quote( 'groups.wall' )
					. ' AND a.' . $db->quoteName('groupid').' IN ('. $groupIds .')'
					. ' ORDER BY a.' . $db->quoteName('created').' DESC '
					. ' LIMIT ' . $params->get( 'count' );
					
		}else{

			$query	= 'SELECT a.*, b.' . $db->quoteName('name').' AS groupname, b.' . $db->quoteName('thumb').' AS thumbnail
					   FROM ' . $db->quoteName( '#__community_activities' ) . ' AS a '
					. 'INNER JOIN '.  $db->quoteName( '#__community_groups' ) . ' AS b '
					. ' ON b.' . $db->quoteName('id').'=a.' . $db->quoteName('groupid').' AND b.' . $db->quoteName('approvals').'=' . $db->Quote( 0 )
					. ' WHERE a.' . $db->quoteName( 'app' ) . '=' . $db->Quote( 'groups.wall' )
					. ' ORDER BY a.' . $db->quoteName('created').' DESC '
					. ' LIMIT ' . $params->get( 'count' );
		}
		
		$db->setQuery( $query );
		$rows	= $db->loadObjectList();
		
		// if exist, group the results based on groups
		$results = array();
		if(count($rows)){
			foreach($rows as $row){
				$results[$row->groupid][] = $row;
			}
		}
		
		//reverse the results so that latest will be shown on top
		array_reverse($results);
		
		return $results;
	}
}
