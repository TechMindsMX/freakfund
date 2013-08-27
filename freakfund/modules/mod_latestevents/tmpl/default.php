<?php
/**
 * @package		Upcoming Events Module
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die('Restricted access');
?>
<div id="cModule-LatestEvents" class="cMods cMods-LatestEvents<?php echo $params->get('moduleclass_sfx'); ?>">
<?php
if( !empty( $events ) )
{
?>
	<?php
	foreach( $events as $event )
	{
		$handler    = CEventHelper::getHandler( $event );
                $tipslength = $params->get( 'tipslength');
                
                if ($event->description != '') {
                    $tooltips = $event->description;
                } else if ($event->summary != '') {
                    $tooltips = $event->summary;
                } else {
                    $tooltips = $event->title;
                }
                
                $tooltips = strip_tags($tooltips);
                $tooltips = CStringHelper::escape($tooltips);
                $tooltips = CStringHelper::truncate($tooltips, $tipslength, '...');
	?>
		<div class="cMod-Row clearfix jomNameTips tipFullWidth" title="<?php echo $tooltips;?>">
			<b class="cThumb-Calendar l-float">
				<b><?php echo CEventHelper::formatStartDate($event, JText::_('M') ); ?></b>
				<b><?php echo CEventHelper::formatStartDate($event, JText::_('d') ); ?></b>
			</b>

			<div class="cThumb-Detail">
				<a href="<?php echo $handler->getFormattedLink( 'index.php?option=com_community&view=events&task=viewevent&eventid=' . $event->id );?>" class="cThumb-Title">
					<?php echo $event->title;?>
				</a>
				<div class="cThumb-Brief">
					<?php echo $event->location;?>
				</div>
				<div class="cThumb-Attendee">
					<a href="<?php echo $handler->getFormattedLink('index.php?option=com_community&view=events&task=viewguest&eventid=' . $event->id . '&type='.COMMUNITY_EVENT_STATUS_ATTEND);?>"><?php echo JText::sprintf((cIsPlural($event->confirmedcount)) ? 'COM_COMMUNITY_EVENTS_ATTANDEE_COUNT_MANY':'COM_COMMUNITY_EVENTS_ATTANDEE_COUNT', $event->confirmedcount);?></a>
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
?>
	<div class="cMod-Empty"><?php echo JText::_( 'COM_COMMUNITY_EVENTS_NO_EVENTS_ERROR' );?></div>
<?php
}
?>
</div>