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

if(!class_exists('plgCommunityLatestPhoto'))
{
	class plgCommunityLatestPhoto extends CApplications
	{
		var $name		= 'LatestPhoto';
		var $_name		= 'latestphoto';
		var $_user		= null;
	
	    function plgCommunityLatestPhoto(& $subject, $config)
	    {
			$this->_my		= CFactory::getUser();
			$this->db 		= JFactory::getDBO();
			parent::__construct($subject, $config);
	    }
	
		/**
		 * Ajax function to save a new wall entry
		 * 	 
		 * @param message	A message that is submitted by the user
		 * @param uniqueId	The unique id for this group
		 * 
		 **/	 	 	 	 	 		
		function onProfileDisplay()
		{	
			JPlugin::loadLanguage( 'plg_community_latestphoto', JPATH_ADMINISTRATOR );
			$mainframe = JFactory::getApplication();
		
			// Attach CSS
			$document	= JFactory::getDocument();
			$css		= JURI::base() . 'plugins/community/latestphoto/latestphoto/style.css';
			$document->addStyleSheet($css);
			$user     = CFactory::getRequestUser();
			$userid	= $user->id;
			
			$def_limit = $this->params->get('count', 10);
			$limit = JRequest::getVar('limit', $def_limit, 'REQUEST');
			$limitstart = JRequest::getVar('limitstart', 0, 'REQUEST');		
			
			$row = $this->getPhotos($userid, $limitstart, $limit);
			$total = count($row);		
			
			$caching = $this->params->get('cache', 1);		
			if($caching)
			{
				$caching = $mainframe->getCfg('caching');
			}
			
			$cache = JFactory::getCache('plgCommunityLatestPhoto');
			$cache->setCaching($caching);
			$callback = array('plgCommunityLatestPhoto', '_getLatestPhotoHTML');		
			$content = $cache->call($callback, $userid, $limit, $limitstart, $row, $total);
						
			return $content;
		}
		
		static public function _getLatestPhotoHTML($userid, $limit, $limitstart, $row, $total)
		{
			
			//CFactory::load( 'models' , 'photos' );
			$photo = JTable::getInstance( 'Photo' , 'CTable' );
							
			ob_start();				
			if(!empty($row))
			{
				?>
				<div id="application-latestphoto">
					
				<?php
				$i = 0;
				foreach($row as $data)
				{
					$photo->load( $data->id );
					
					$link = plgCommunityLatestPhoto::buildLink($photo->albumid, $data->id);
					$thumbnail	= $photo->getThumbURI();

				?>
				<a href="<?php echo $link; ?>">
					<img class="cAvatar cAvatar-sidebar jomNameTips" width="64" title="<?php echo CTemplate::escape($photo->caption);?>" src="<?php echo $thumbnail; ?>" />
				</a>
				<?php	
				} // end foreach
				?>
				</div>
				<?php
			}
			else
			{
				?>
				<div><?php echo JText::_('PLG_LATESTPHOTO_NO_PHOTO')?></div>
				<?php
			}	
			?>
			<div style='clear:both;'></div>
			<?php
			$contents  = ob_get_contents();
			@ob_end_clean();
			$html = $contents;
			
			return $html;
		}
		
		function getPhotos($userid, $limitstart, $limit)
		{		
			$photoType = PHOTOS_USER_TYPE;
			
			//privacy settings
			//CFactory::load('libraries', 'privacy');
			$permission	= CPrivacy::getAccessLevel($this->_my->id, $userid);
								
			$sql  = "	SELECT
								a.id
						FROM
								".$this->db->nameQuote('#__community_photos')." AS a
						INNER JOIN 
								".$this->db->nameQuote('#__community_photos_albums')." AS b ON a.`albumid` = b.`id` 
						WHERE
								a.".$this->db->nameQuote('creator')." = ".$this->db->quote($userid)." AND
								b.".$this->db->nameQuote('type')." = ".$this->db->quote($photoType)." AND								
								a.".$this->db->nameQuote('published')."=".$this->db->quote(1)." AND
								b.permissions <=" . $this->db->Quote( $permission )."
						ORDER BY
								a.".$this->db->nameQuote('created')." DESC
						LIMIT 
								".$limitstart.",".$limit;
			
			$query = $this->db->setQuery($sql);
			$row  = $this->db->loadObjectList();
			if($this->db->getErrorNum()) {
				JError::raiseError( 500, $this->db->stderr());
			}
			
			return $row;
		}
		
		static public function buildLink($albumid, $photoid)
		{
			$photo	= JTable::getInstance( 'Photo' , 'CTable' );
			$photo->load( $photoid );

			return $photo->getPhotoLink();
		}
	
	}	
}
