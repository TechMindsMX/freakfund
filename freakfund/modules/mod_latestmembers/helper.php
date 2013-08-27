<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

if( !function_exists('getLatestMember') )
{
	function getLatestMember($limit = 15, $updated_avatar_only)
	{
		$db	 = JFactory::getDBO();
		
		if($updated_avatar_only)
		{
			$condition  = 'AND b.' . $db->quoteName( 'avatar' ) . ' != ' . $db->Quote( 'components/com_community/assets/default.jpg' ) . ' ';
			$condition .= 'AND b.' . $db->quoteName( 'avatar' ) . ' != \'\' '; 
		}
		else
		{
			$condition = ' ';
		}
		//apply admin privacy setting filter
		$config		= CFactory::getConfig();
		if( !$config->get( 'privacy_show_admins') )
		{
		    $userModel		= CFactory::getModel( 'User' );
			$tmpAdmins		= $userModel->getSuperAdmins();

			$admins         = array();
			
			$condition  .= ' AND '.$db->quoteName('id').' NOT IN(';
			for( $i = 0; $i < count($tmpAdmins);$i++ )
			{
			    $admin  = $tmpAdmins[ $i ];
			    $condition  .= $db->Quote( $admin->id );
			    $condition  .= $i < count($tmpAdmins) - 1 ? ',' : '';
			}
			$condition  .= ')';
		}		
		
		$query	= 'SELECT * FROM ' . $db->quoteName( '#__users' ) . ' AS a ' 
				. 'INNER JOIN ' . $db->quoteName( '#__community_users' ) . ' AS b ON a.' . $db->quoteName( 'id' ) . ' = b.' . $db->quoteName( 'userid' ) . ' '
				. 'WHERE a.' . $db->quoteName( 'block' ) . ' = ' . $db->Quote( 0 ) . ' '
				. $condition
				. 'ORDER BY a.' . $db->quoteName( 'registerDate' ) . ' '
				. 'DESC LIMIT ' . $limit;
		$db->setQuery( $query );
		
		$result = $db->loadObjectList();
	
		if($db->getErrorNum())
		{
			JError::raiseError( 500, $db->stderr());
		}
		
		return $result;
	}
}

?>
