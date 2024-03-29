<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
defined('_JEXEC') or die();
CAssets::attach('assets/easytabs/jquery.easytabs.min.js', 'js');
?>
<script type="text/javascript">
function disableFormField(){

//change the background color to light grey
document.getElementById('to').style.backgroundColor      = "#eee";
document.getElementById('subject').style.backgroundColor = "#eee";
document.getElementById('message-body').style.backgroundColor    = "#eee";

//text field
document.getElementById('to').readonly = true;
document.getElementById('subject').readonly = true;
document.getElementById('message-body').readonly = true;

//button
document.getElementById('submitBtn').disabled = true;
//document.getElementById('cancelBtn').disabled = true;

}//end disableFormField

var yPos;

function addFriendName()
{
	var inputs 		= [];    
	
	joms.jQuery('#selections option:selected').each( function() {
		inputs.push(this.value);				
	});

	var x = inputs.join(', ');
	joms.jQuery('#to').val(x);
}

joms.jQuery(document).ready(function(){
	<?php 
		//@since 2.4
		if(isset($data->toUsersInfo) && count($data->toUsersInfo) > 0 ){
			foreach($data->toUsersInfo as $user){
	?>
		cAddRecipients('<?php echo $user['rid'] ?>','<?php echo $user['avatar'] ?>','<?php echo $user['name'] ?>');
	<?php
			}
		}
	?>
});

</script>

<div class="cInbox-Write">
<form name="jsform-inbox-write" class="community-form-validate composeForm cForm" id="writeMessageForm" action="<?php echo CRoute::getURI(); ?>" method="post" onsubmit="disableFormField();">
<?php
	if( $totalSent >=  $maxSent && $maxSent != 0 )
	{
?>
	<div class="cAlert"><?php echo JText::_('COM_COMMUNITY_PM_LIMIT_REACHED');?></div>
<?php
	}
	else
	{
?>
	<ul class="cFormList cFormHorizontal cResetList">

		<?php echo $beforeFormDisplay;?>

		<!-- name -->
		<li>
			<label for="name" class="form-label">
				*<?php echo ($useRealName == '1') ? JText::_('COM_COMMUNITY_COMPOSE_TO_REALNAME') : JText::_('COM_COMMUNITY_COMPOSE_TO_USERNAME'); ?>
			</label>
			<div class="form-field">
				<div id="inbox-selected-to-wrapper">
					<a id="addRecipient" href="javascript:void(0);" onclick="joms.friends.showForm('', 'friends,inviteUsers','0','1','joms.friends.selectRecipients()');;" class="cButton">
						<?php echo JText::_('COM_COMMUNITY_INBOX_ADD_RECIPIENT');?>
					</a>
					<ul id="inbox-selected-to" class="cInbox-Selection cResetList"></ul>
				</div>
			</div>
		</li>
		<!-- subject -->
		<li class="has-seperator">
			<label for="description" class="form-label">
				*<?php echo JText::_('COM_COMMUNITY_COMPOSE_SUBJECT'); ?>
			</label>
			<div class="form-field">
				<div class="input-wrap">
					<input id="subject" class="input text required" name="subject" type="text" value="<?php echo htmlspecialchars($data->subject); ?>" style="width: 100%" />
				</div>
			</div>
		</li>
		<!-- message -->
		<li>
			<label for="description" class="form-label">
				*<?php echo JText::_('COM_COMMUNITY_COMPOSE_MESSAGE'); ?>
			</label>
			<div class="form-field">
				<div class="input-wrap">
					<textarea id="message-body" name="body" class="textarea required" style="resize: vertical; width: 100%; height: 200px"><?php echo $data->body; ?></textarea>
				</div>
			</div>
		</li>

		<?php echo $afterFormDisplay;?>

		<!-- buttons -->
		<li class="has-seperator">
			<div class="form-field">
				<span class="form-helper"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></span>
			</div>
		</li>
		<li>
			<div class="form-field">
				<input type="hidden" name="action" value="doSubmit"/>					
				<input id="submitBtn" class="cButton cButton-Blue validateSubmit" name="submitBtn" type="submit" value="<?php echo JText::_('COM_COMMUNITY_INBOX_SEND_MESSAGE'); ?>" />
			</div>
		</li>
	</ul>
</form>
<script type="text/javascript">
	cvalidate.init();
	cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("COM_COMMUNITY_ENTRY_MISSING")); ?>');
</script>
<?php
	}
?>
</div>
