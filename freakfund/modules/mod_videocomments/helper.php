<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');

class modVideoCommentsHelper
{
	static public function getList(&$params)
	{
                $my			= CFactory::getUser();
                //CFactory::load('libraries', 'privacy');
		$data = array();
		$db		= JFactory::getDBO();
		
		$query	= 'SELECT * FROM ' . $db->quoteName('#__community_wall').' AS a '
				. ' INNER JOIN ' . $db->quoteName('#__community_videos').' AS b '
				. ' ON a.' . $db->quoteName('contentid').'=b.' . $db->quoteName('id')
				. ' WHERE a.' . $db->quoteName('type').' =' . $db->Quote('videos')
				. 'AND b.' . $db->quoteName('status').' =' . $db->Quote('ready')
				. 'ORDER BY a.' . $db->quoteName('date').' DESC '
				. 'LIMIT 150';
				
		$db->setQuery( $query );
		
		$comments	= $db->loadObjectList();

                $counter = $params->get( 'count' , 5 );
                    
                foreach($comments as $key=>$comment)
                {
                    if(CPrivacy::isAccessAllowed($my->id, $comment->creator, 'custom', $comment->permissions))
                    {
                        $data[] = $comment;
                    }
                   
                    if(--$counter == 0)
                    {
                        break;
                    }
                  }

		return $data;
	}
}
