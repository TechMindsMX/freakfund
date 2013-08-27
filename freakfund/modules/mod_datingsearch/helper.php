<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die('Restricted access');

require_once( JPATH_ROOT .'/components/com_community/helpers/string.php' );

class modDatingSearchHelper
{
	static public function getGenderValue( $fieldcode )
	{
		$db 	= JFactory::getDBO();
			
	 	$sql 	= "SELECT " . $db->quoteName("options") . " "
		 		. "FROM " . $db->quoteName("#__community_fields") ." "
			 	. "WHERE " . $db->quoteName("fieldcode") . " = " . $db->quote($fieldcode);
				
		$db->setQuery( $sql );
		$results = $db->loadResult();					

		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr() );
	    }
		
		$options = array();
		$options = explode("\n", $results);
		array_walk($options, array( 'JString' , 'trim' ) );
				
		return $options;
	}
	
	static public function getCountryValue( $fieldcode )
	{
		// retrieve field details
		$db 	= JFactory::getDBO();
			
	 	$sql 	= "SELECT * FROM " . $db->quoteName("#__community_fields") ." "
			 	. "WHERE " . $db->quoteName("fieldcode") . " = " . $db->quote($fieldcode);
				
		$db->setQuery( $sql );
		$results = $db->loadObject();					

		if($db->getErrorNum()) {
			JError::raiseError( 500, $db->stderr() );
	    }
	    
		// load countries from xml
		jimport( 'joomla.filesystem.file' );
		$file	= JPATH_ROOT .'/components/com_community/libraries/fields/countries.xml';
		
		$options = array();
		
		if( JFile::exists( $file ) )
		{
			$contents	= JFile::read( $file );
			$parser = new SimpleXMLElement($file,NULL,true);
	
			$countries		= $parser->countries->country;
			foreach($countries as $country )
			{
				$options[]	= $country->name;
			}
		}   

		array_walk($options, array( 'JString' , 'trim' ) );
				
		return $options;
	}
	
	static public function getFieldType($fieldcode)
	{
		$db 	= JFactory::getDBO();
			
	 	$sql 	= "SELECT " . $db->quoteName("type") . ", " . $db->quoteName("fieldcode") . " "
		 		. "FROM " . $db->quoteName("#__community_fields") ." ";
				
		$db->setQuery( $sql );
		$results = $db->loadObjectList();
		
		$type = new stdClass();
		
		foreach($fieldcode as $key=>$field)
		{
			foreach($results as $data)
			{
				if($field == $data->fieldcode)
				{
					$type->$key = $data->type;
				}
			}
		}
		
		return $type;
	}
}