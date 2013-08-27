<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
?>
<div id="cModule-LatestMembers" class="cMods cMods-LatestMembers<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php
	if( !empty( $row ) )
	{
	?>
	<div class="cMod-Thumbs">
		<?php		
		foreach( $row as $data )
		{
			$user 		= CFactory::getUser($data->id);				
			$userName 	= CStringHelper::escape( $user->getDisplayName() );
			$userLink 	= CRoute::_('index.php?option=com_community&view=profile&userid='.$data->id);
			
			$html = '	<a href="'.$userLink.'">';
			if($tooltips)
			{
				$html .= '	<img width="45" src="'.$user->getThumbAvatar().'" class="jomNameTips" alt="'.$userName.'" title="'.$user->getDisplayName().'" />';
			}
			else
			{
				$html .= '	<img width="45" src="'.$user->getThumbAvatar().'" alt="'. $userName.'" title="'.$userName.'" />';
			}
			$html .= '	</a>';
			echo $html;
		}
		?>
	</div>
	<div class="cMod-ThumbsAll clearfix">
		<a style='float:right;' href='<?php echo CRoute::_("index.php?option=com_community&view=search&task=browse&sort=latest"); ?>'><?php echo JText::_("SHOW_ALL"); ?></a>
	</div>
	<?php
	}
	else
	{
		echo JText::_('NO_MEMBERS_YET');
	}
	?>
</div>