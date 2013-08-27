<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
?>
<?php
$showAvatar = $params->get('show_avatar', '1');
$showTotal	= $params->get('show_total', '1');
?>
<div id="cModule-ActiveGroups" class="cMods cMods-ActiveGroups<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php
	$showAvatar = $params->get('show_avatar', '1');
	$showTotal	= $params->get('show_total', '1');

if ( !empty($groups) ) {

	foreach ( $groups as $group ) {
?>
	<div class="cMod-Row">
		<a class="cThumb-Avatar l-float" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&groupid='.$group->id.'&task=viewgroup'); ?>">
			<img src="<?php echo $group->avatar; ?>" alt="<?php echo CStringHelper::escape( $group->name ); ?>" width="45" />
		</a>
		
		<div class="cThumb-Detail">
			<a class="cThumb-Title" href="<?php echo CRoute::_('index.php?option=com_community&view=groups&groupid='.$group->id.'&task=viewgroup'); ?>">
				<?php echo $group->name; ?>
			</a><br />
			<?php if ( $showTotal == 1 ) : ?>
			<div class="cThumb-Brief small">
				<a href="<?php echo CRoute::_( "index.php?option=com_community&view=groups&task=viewmembers&groupid=" . $group->id ); ?>">
					<?php echo JText::sprintf( (cIsPlural($group->totalMembers)) ? 'MOD_ACTIVEGROUPS_MEMBER_MANY':'MOD_ACTIVEGROUPS_MEMBER', $group->totalMembers); ?>
				</a>
			</div>
			<?php endif; ?>
		</div>
	</div>
<?php
	}
}
else 
{
		echo JText::_("MOD_ACTIVEGROUPS_NO_ACTIVE_GROUPS");
}
?>
</div>