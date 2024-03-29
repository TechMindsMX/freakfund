<?php
/**
 * @package		JomSocial
 * @subpackage 	Template
 * @copyright (C) 2011 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 *
 */
defined('_JEXEC') or die();

/**
 * Require
 * @notification object
 *		- user CUser
 *		- title
 *		- created (optional)
 *		- action (optional)
 */
?>

<div class="cWindowNotification forNotifications">
<?php if(!empty($notifications)) { ?>
	<ul class="cWindowStream forNotifications cResetList">
	<?php
		foreach ($notifications as $row)
		{
	?>
		<li <?php if(!empty($row->rowid)){ echo 'id="'.$row->rowid.'"';} ?>>
			<!-- avatar -->
			<a href="<?php echo CUrlHelper::userLink($row->user->id); ?>" class="cStream-Avatar cFloat-L"><img class="cAvatar" src="<?php echo $row->user->getThumbAvatar(); ?>"></a>
			<!-- end avatar -->

			<!-- content -->
			<div class="cStream-Content<?php if(!is_null($row->action)){ echo ' jsNotificationHasActions'; } ?>">
				<!-- actions -->
				<?php if (!is_null($row->action)) { ?>
				<div class="cStream-Actions cFloat-R">
					<?php echo $row->action; ?>
				</div>
				<?php } ?>
				<!-- end actions -->

				<div class="cStream-Headline">
					<a href="<?php echo CUrlHelper::userLink($row->user->id); ?>" class="cStream-Author"><?php echo $row->user->getDisplayName(); ?></a>
				</div>

				<div class="cStream-Message">
					<?php if (!is_null($row->link)) { ?><a href="<?php echo $row->link; ?>"> <?php } ?>
						<?php echo $row->title; ?>
					<?php if (!is_null($row->link)) { ?></a><?php } ?>


					<?php if (!is_null($row->created)) { ?>
						<br/>
						<small><?php echo $row->created; ?></small>
					<?php } ?>
				</div>
			</div>
			<!-- end content -->
		</li>
	<?php
		}
	?>
	</ul>
</div>

<?php } else { ?>
<div class="cEmpty cAlert">
	<?php echo $empty_notice; ?>
</div>
<?php } ?>

<div class="cWindowNotification-Jumper">
	<a href="<?php echo $link; ?>"><?php echo $link_text; ?></a>
</div>


