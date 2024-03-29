<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 */
defined('_JEXEC') or die();
?>

<h3 class="app-box-header">
	<?php if($config->get('groupfrontpagelist')) { echo JText::_('COM_COMMUNITY_GROUPS_LATEST'); } else { echo JText::_('COM_COMMUNITY_FEATURED_GROUPS'); } ?>
</h3>

<div class="app-box-content">
	<?php 
	if ( !empty( $groups ) ) 
	{
	?>
	<ul class="cThumbsList cResetList clearfix">
	<?php
		foreach ( $groups as $group )
		{ 
	?>
		<li>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups&task=viewgroup&groupid='.$group->id); ?>">
				<img src="<?php echo $group->getThumbAvatar(); ?>" alt="<?php echo $this->escape($group->name); ?>" class="cAvatar cGroupAvatar jomNameTips" title="<?php echo htmlspecialchars( JText::_( $this->escape($group->name) )); ?>" />
			</a>
		</li>
	<?php 
		}
	?>
	</ul>
	<?php
	} else {
	?>
	<div class="cEmpty"><?php echo JText::_('COM_COMMUNITY_GROUPS_NOITEM'); ?></div>
	<?php } ?>
</div>

<div class="app-box-footer">
	<a href="<?php echo CRoute::_('index.php?option=com_community&view=groups'); ?>"><?php echo JText::_('COM_COMMUNITY_GROUPS_VIEW_ALL'); ?></a>
</div>