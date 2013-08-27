<?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
jimport ( 'joomla.application.component.view' );

class CommunityViewDeveloper extends CommunityView
{
	public function display($tpl = null)
	{
		$tmpl	=   new CTemplate();		
		echo $tmpl->fetch( 'developer.core' );
	}
}
