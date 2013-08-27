<?php
/**
 * @category	Module
 * @package		JomSocial
 * @subpackage	OnlineUsers
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
?>
<div id="cModule-OnlineUsers" class="cMods cMods-OnlineUsers<?php echo $params->get('moduleclass_sfx'); ?>">
	<div class="cMod-Thumbs">
		
	<?php
	foreach ( $users as $user )
	{	
		if( !$params->get('hideAdmin') || ( $params->get('hideAdmin') && $user->usertype != 'Super Administrator' && $user->usertype != 'Administrator') )
		{
	?>
			<a href="<?php echo $user->link; ?>" title="<?php echo JText::sprintf( 'MOD_ONLINEUSERS_GO_TO_PROFILE', $user->name ); ?>">
				<img width="45" src="<?php echo $user->avatar; ?>" alt="<?php echo JText::sprintf( 'MOD_ONLINEUSERS_GO_TO_PROFILE', $user->name ); ?>" />
			</a>
	<?php
		}
	}
	?>
	</div>
	
	<div>
		<?php echo JText::sprintf( ( cIsPlural( $total->users ) ) ? 'MOD_ONLINEUSERS_USER_MANY' : 'MOD_ONLINEUSERS_USER', $total->users); ?>
		
		<?php if ( $params->get( 'show_guest', 1 ) ) { ?>
			<?php echo JText::_('MOD_ONLINEUSERS_AND'), ' ', JText::sprintf( ( cIsPlural( $total->guests ) ) ? 'MOD_ONLINEUSERS_GUEST_MANY' : 'MOD_ONLINEUSERS_GUEST', $total->guests ); ?>
		<?php } ?>
		
		<?php echo JText::_("MOD_ONLINEUSERS_ONLINE"); ?> 
		<div>
			<a href="<?php echo CRoute::_('index.php?option=com_community&view=search&task=browse&sort=online'); ?>"><?php echo JText::_("MOD_ONLINEUSERS_SHOW_ALL"); ?></a>
		</div>
	</div>
</div>