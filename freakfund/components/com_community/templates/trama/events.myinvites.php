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
<div class="cLayout cEvents-Invitations">

	<?php echo $sortings; ?>

	<div class="cMain">
	
		<?php
			if( $events )
			{
			?>
			<div class="cAlert">
				<?php echo JText::sprintf( CStringHelper::isPlural( $count ) ? 'COM_COMMUNITY_EVENTS_INVITATION_COUNT_MANY' : 'COM_COMMUNITY_EVENTS_INVITATION_COUNT_SINGLE' , $count ); ?>
			</div>

			<ul class="cIndexList forEvents cResetList">
			<?php
				for( $i = 0; $i < count( $events ); $i++ )
				{
					$event	=& $events[$i];
			?>
			<li id="events-invite-<?php echo $event->id;?>">
				<div class="cIndex-Box clearfix">
					
					<a class="cIndex-Avatar cFloat-L" href="<?php echo CRoute::_( 'index.php?option=com_community&view=events&task=viewevent&eventid=' . $event->id );?>" class="cAvatar" />
						<img src="<?php echo $event->getThumbAvatar();?>" alt="<?php echo $this->escape($event->title); ?>"/>
						<?php if(CEventHelper::isPast($event) ) { ?>
							<b class="cStatus-Past"><?php echo JText::_('COM_COMMUNITY_EVENTS_PAST'); ?></b>
						<?php } else if(CEventHelper::isToday($event)) { ?>
							<b class="cStatus-OnGoing"><?php echo JText::_('COM_COMMUNITY_EVENTS_ONGOING'); ?></b>
						<?php } ?>
					</a>
					<div class="cIndex-Content">
						<h3 class="cIndex-Name cResetH">
							<a href="<?php echo CRoute::_( 'index.php?option=com_community&view=events&task=viewevent&eventid=' . $event->id );?>"><?php echo $this->escape($event->title); ?></a>
						</h3>
						<div class="cIndex-Status">
							<div class="cIndex-Date"><b><?php echo CEventHelper::formatStartDate($event, $config->get('eventdateformat') ); ?></b></div>
							<i class="cIndex-Location"><?php echo $this->escape($event->location); ?></i>
							<div class="cIndex-Time small"><?php echo JText::sprintf('COM_COMMUNITY_EVENTS_DURATION', JHTML::_('date', $event->startdate, JText::_('DATE_FORMAT_LC2')), JHTML::_('date', $event->enddate, JText::_('DATE_FORMAT_LC2'))); ?></div>
						</div>
						<div class="cIndex-actions">
							<div class="action">
								<i class="com-icon-groups"></i>
								<a href="<?php echo CRoute::_('index.php?option=com_community&view=events&task=viewguest&eventid=' . $event->id . '&type='.COMMUNITY_EVENT_STATUS_ATTEND);?>">
									<?php echo JText::sprintf((cIsPlural($event->confirmedcount)) ? 'COM_COMMUNITY_EVENTS_MANY_GUEST_COUNT':'COM_COMMUNITY_EVENTS_GUEST_COUNT', $event->confirmedcount);?>
								</a>
							</div>
						</div>
					</div>
					<div class="community-events-pending-actions">		
						<a class="jsIcon1 icon-add-friend cButton cButton-Green" href="javascript:void(0);" onclick="joms.events.joinNow('<?php echo $event->id; ?>');"><?php echo JText::_('COM_COMMUNITY_EVENTS_ACCEPT'); ?></a>
						<a class="icon-remove cButton cButton-Blue" href="javascript:void(0);" onclick="joms.events.rejectNow('<?php echo $event->id; ?>');"><?php echo JText::_('COM_COMMUNITY_EVENTS_REJECT'); ?></a>
					</div>
				</div>
			</li>
			<?php
				}
				?>
			</ul>
		<?php
			}
			else
			{
		?>
			<div class="cEmpty cAlert"><?php echo JText::_('COM_COMMUNITY_EVENTS_NO_INVITATIONS'); ?></div>
		<?php 
			} 
		?>

		<?php 
		if ( $pagination->getPagesLinks() ) 
		{ 
		?>
		<div class="cPagination">
			<?php echo $pagination->getPagesLinks(); ?>
		</div>
		<?php 
		} 
		?>
	</div>
</div>