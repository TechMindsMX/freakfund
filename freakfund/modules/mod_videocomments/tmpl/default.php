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
	$char_limit	= intval($params->get('character_limit'));
	
	foreach( $comments as $comment )
	{
		//$comment->comment = CStringHelper::truncate($comment->comment, $char_limit);
		if( ($char_limit > 0) && (JString::strlen($comment->comment) > $char_limit) )
		{
			$comment->comment = JString::substr($comment->comment, 0, $char_limit) . '...';
		}
		
		$poster	= CFactory::getUser( $comment->post_by );
		
		if( $comment->creator_type == VIDEO_USER_TYPE )
		{
			$link	= CRoute::_('index.php?option=com_community&view=videos&task=video&videoid=' . $comment->contentid . '&userid=' . $comment->creator );
		}
		else
		{
			$link	= CRoute::_('index.php?option=com_community&view=videos&task=video&videoid=' . $comment->contentid . '&groupid=' . $comment->groupid );
		}
		
?>
	<div class="cMod-Row">
		<a href="<?php echo CRoute::_('index.php?option=com_community&view=profile&userid='.$comment->post_by);?>" class="cThumb-Avatar l-float">
			<img src="<?php echo $poster->getThumbAvatar(); ?>" width="45" height="45" />
		</a>
		<div class="cThumb-Detail">
			<a href="<?php echo $link;?>" class="cThumb-Title"><?php echo $comment->title;?></a>
			<div class="cThumb-Brief"><?php echo CStringHelper::escape($comment->comment); ?></div>
		</div>
	</div>
<?php
		$i++;
	}
}
else
{
?>
	<?php echo JText::_('MOD_VIDEOCOMMENTS_NO_COMMENTS');?>
<?php
}
?>
</div>