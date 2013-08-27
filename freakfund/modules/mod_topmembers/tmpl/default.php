<?php
/**
 * @category	Modules
 * @package		JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
?>
<div id="cModule-TopMembers" class="cMods cMods-TopMembers<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<?php
	$showAvatar = $params->get('show_avatar', 1);
	$showKarma 	= $params->get('enablekarma', 1);
	
	if ( !empty($users) ) {
	?>
		<?php
		foreach ( $users as $user ) {
		?>
		<div class="cMod-Row" id="user-<?php echo $user->id; ?>" style="clear:both">

			<?php if ( $showAvatar == 1 ) : ?>
				<a href="<?php echo $user->link; ?>" title="<?php echo JText::sprintf('MOD_TOPMEMBERS_GO_TO_PROFILE', CStringHelper::escape( $user->name ) ); ?>" class="cThumb-Avatar l-float">
					<img src="<?php echo $user->avatar; ?>" alt="<?php echo CStringHelper::escape( $user->name ); ?>" width="45" height="45" />
				</a>
			<?php endif; ?>

			<div class="cThumb-Detail">
				<a href="<?php echo $user->link; ?>" class="cThumb-Title"><?php echo $user->name; ?></a>
				<div class="cThumb-Brief">
				<?php if ( $showKarma == 1 ) : ?>
						<img alt="<?php echo $user->userpoints; ?>" src="<?php echo $user->karma; ?>" />
				<?php elseif ( $showKarma == 2 ) : ?>
						<small><?php echo JText::_('MOD_TOPMEMBERS_POINTS') , ': ', $user->userpoints; ?></small>
				<?php endif; ?>
				</div>
			</div>	

		</div>
		<?php
		}
		?>
	<?php
	}
	else 
	{
		echo JText::_("MOD_TOPMEMBERS_NO_MEMBERS");
	}
	?>
	<br style="clear:both"/>
</div>