<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
?>
<div id="cModule-PhotoComments" class="cMods cMods-PhotoComments<?php echo $params->get('moduleclass_sfx'); ?>">
<?php
if( $comments )
{
	$i		= 1;
	$total	= count( $comments );
	
	foreach( $comments as $comment )
	{
		$poster	= CFactory::getUser( $comment->post_by );
		
		if( $comment->phototype == PHOTOS_USER_TYPE )
		{
			$link	= CRoute::_('index.php?option=com_community&view=photos&task=photo&albumid=' . $comment->albumid . '&photoid=' . $comment->contentid . '&userid=' . $comment->creator ); // . '#photoid=' . $comment->contentid;
		}
		else
		{
			$link	= CRoute::_('index.php?option=com_community&view=photos&task=photo&albumid=' . $comment->albumid . '&photoid=' . $comment->contentid . '&groupid=' . $comment->groupid ); // . '#photoid=' . $comment->contentid;
		}
?>
	<div class="cMod-Row">
		<a href="<?php echo $link;?>" class="cThumb-Avatar l-float">
			<img src="<?php echo $poster->getThumbAvatar(); ?>" width="45" height="45" alt="" />
		</a>
		<div class="cThumb-Detail">
			<a href="<?php echo $link;?>" class="cThumb-Title"><?php echo $comment->caption;?></a>
			<div class="cThumb-Brief">
            	<?php echo CStringHelper::truncate($comment->comment,150);?>
            </div>
		</div>
	</div>
<?php
		$i++;
	}
}
else
{
?>
	<?php echo JText::_('MOD_PHOTOCOMMENTS_NO_COMMENTS');?>
<?php
}
?>
</div>
