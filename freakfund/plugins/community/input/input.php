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

if(!class_exists('plgCommunityInput'))
{
	class plgCommunityInput extends CApplications
	{
		var $name		= 'Walls';
		var $_name		= 'input';
	
	    function plgCommunityInput(& $subject, $config)
	    {	
			parent::__construct($subject, $config);
	    }
	    
	    function _filterText(&$text) {
			$text = $this->_nl2br2($text);
	
			$text = preg_replace("/(<br\s*\/?>\s*){3,}/", "<br /><br />", $text);
	
			return $text;
		}
		
		/**
		 * ->title
		 * ->comment 	 
		 */	 	
		function onWallDisplay( &$row )
		{
			CError::assert( $row->comment, '', '!empty', __FILE__ , __LINE__ );
			$row->comment = $this->_filterText($row->comment);
		}
		
		/**
		 * ->message
		 */
		function onMessageDisplay( &$row )
		{
			CError::assert( $row->body, '', '!empty', __FILE__ , __LINE__ );
			$row->body = $this->_filterText($row->body);
		} 
		
		function onDiscussionDisplay( &$row )
		{
			CError::assert( $row->message, '', '!empty', __FILE__ , __LINE__ );
			$config	= CFactory::getConfig();
			
			// If editor is disabled, we only want to replace newlines with BR otherwise it doesn't make any sense to replace so many br
			if( $config->get('editor') == '0' )
			{
				$row->message = $this->_filterText($row->message);
			}
		} 
		
		function onWallSave(&$row)
		{
		}
		
		function _nl2br2($string)
		{
			$string = CString::str_ireplace(array("\r\n", "\r", "\n"), "<br />", $string);
			return $string;
		}
	
	}	
}

