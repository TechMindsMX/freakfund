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

if(!class_exists('plgCommunityMyVideos'))
{
	class plgCommunityMyVideos extends CApplications
	{
		var $name		= 'MyVideos';
		var $_name		= 'myVideos';
		var $_user		= null;
	
	    function plgCommunityMyVideos(& $subject, $config)
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
			JPlugin::loadLanguage( 'plg_community_myvideos', JPATH_ADMINISTRATOR );
			$mainframe = JFactory::getApplication();
		
			// Attach CSS
			$document	= JFactory::getDocument();
			// $css		= JURI::base() . 'plugins/community/myvideos/style.css';
			// $document->addStyleSheet($css);
			$user     = CFactory::getRequestUser();
			$userid	= $user->id;
			$this->loadUserParams();
			
			$def_limit = $this->params->get('count', 10);
			$limit = JRequest::getVar('limit', $def_limit, 'REQUEST');
			$limitstart = JRequest::getVar('limitstart', 0, 'REQUEST');		
			
			$row = $this->getVideos($userid, $limitstart, $limit);
			$total = count($row);		
			
			$caching = $this->params->get('cache', 1);		
			if($caching)
			{
				$caching = $mainframe->getCfg('caching');
			}
			
			$cache = JFactory::getCache('plgCommunityMyVideos');
			$cache->setCaching($caching);
			$callback = array('plgCommunityMyVideos', '_getLatestVideosHTML');		
			$content = $cache->call($callback, $userid, $this->userparams->get('count', 5 ), $limitstart, $row, $total);
						
			return $content;
		}
		
		static public function _getLatestVideosHTML($userid, $limit, $limitstart, $row, $total)
		{
			//
			//CFactory::load( 'models' , 'videos' );
			$video = JTable::getInstance( 'Video' , 'CTable' );
							
			ob_start();				
			if(!empty($row))
			{
				?>
				<ul class="cThumbsList cResetList clearfix">
				<?php
				$i = 1;
				foreach($row as $data)
				{
					if($i > $limit){
						break;
					}
					$i++;
					$video->load( $data->id );
					$link = plgCommunityMyVideos::buildLink($data->id);
					$thumbnail	= $video->getThumbnail();
				?>					
					<li>
						<a href="<?php echo $link; ?>" class="cVideo-Thumb">
							<img class="cAvatar Video cMediaAvatar jomNameTips" title="<?php echo CTemplate::escape($video->getTitle());?>" src="<?php echo $thumbnail; ?>"/>
							<b><?php echo $video->getDurationInHMS()?></b>
						</a>
					</li>
				<?php
				}
				?>
				</ul>
				<div class="app-box-footer">
					<a href="<?php echo CRoute::_('index.php?option=com_community&view=videos&task=myvideos&userid='.$userid); ?>">
						<span><?php echo JText::_('PLG_MYVIDEOS_VIEWALL_VIDEOS');?></span>
						<span>(<?php echo $total;?>)</span>
					</a>
				</div>
				<?php
			}
			else
			{
				?>
				<div><?php echo JText::_('PLG_MYVIDEOS_NO_VIDEOS')?></div>
				<?php
			}	
			?>
			<?php
			$contents  = ob_get_contents();
			@ob_end_clean();
			$html = $contents;
			
			return $html;
		}
		
		public function getVideos($userid, $limitstart, $limit)
		{		
			$photoType = PHOTOS_USER_TYPE;
			
			//privacy settings
			//CFactory::load('libraries', 'privacy');
			$permission	= CPrivacy::getAccessLevel($this->_my->id, $userid);
			
			//get videos from the user
			//CFactory::load('models', 'videos');
			$model	= CFactory::getModel( 'Videos' );
			$videos = $model->getUserTotalVideos($userid);
			
			return $videos;
		}
		
		static public function buildLink($videoId)
		{
			$video	= JTable::getInstance( 'Video' , 'CTable' );
			$video->load( $videoId );

			return $video->getURL();
		}
	
	}	
}
