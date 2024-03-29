<?php
/**
 * @package		JomSocial
 * @subpackage 	Template 
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 * 
 * @param	applications	An array of applications object
 * @param	pagination		JPagination object 
 */
defined('_JEXEC') or die();
?>
<?php
if( $fields )
{
	$required	= false;
?>
	<form action="<?php echo CRoute::getURI(); ?>" method="post" id="jomsForm" name="jomsForm" class="community-form-validate">
<?php
	foreach( $fields as $group )
	{
		$fieldName	= $group->name == 'ungrouped' ? '' : $group->name;
?>
		<div class="ctitle">
			<h2><?php echo JText::_( $fieldName ); ?></h2>
		</div>
		
		<ul class="cFormList cFormHorizontal cResetList">
<?php
		foreach($group->fields as $field )
		{
			if( !$required && $field->required == 1 )
				$required	= true;

			$html = CProfileLibrary::getFieldHTML($field);
?>
				<li>
					<label id="lblfield<?php echo $field->id;?>" for="field<?php echo $field->id;?>" class="form-label"><?php if($field->required == 1) echo '*'; ?><?php echo JText::_($field->name); ?></label>
					<div class="form-field">
						<?php echo $html; ?>
						<div class="form-privacy">
							<?php echo CPrivacy::getHTML( 'privacy' . $field->id ); ?>
						</div>
					</div>
				</li>	
<?php
		}
?>
		
<?php
	}
?>    
<?php
	if( $required )
	{
?>		
		<li></li>
		<li class="has-seperator">
			<div class="form-field">
				<span class="form-helper"><?php echo JText::_( 'COM_COMMUNITY_REGISTER_REQUIRED_FILEDS' ); ?></span>
			</div>
		</li>
<?php
	}
?>				
		<li>
			<div class="form-field">
				<div id="cwin-wait" style="display:none;"></div>
				<input class="cButton cButton-Blue validateSubmit" type="submit" id="btnSubmit" value="<?php echo JText::_('COM_COMMUNITY_REGISTER'); ?>" name="submit">
			</div>					
		</li>
	</ul>
	<input type="hidden" name="profileType" value="<?php echo $profileType;?>" />
	<input type="hidden" name="task" value="registerUpdateProfile" />	
	<input type="hidden" id="authenticate" name="authenticate" value="0" />	
	<input type="hidden" id="authkey" name="authkey" value="" />
	</form>
	<script type="text/javascript">
		cvalidate.init();
		cvalidate.setSystemText('REM','<?php echo addslashes(JText::_("COM_COMMUNITY_ENTRY_MISSING")); ?>');
		
		joms.jQuery( '#jomsForm' ).submit( function() {
			joms.jQuery('#btnSubmit').hide();
			joms.jQuery('#cwin-wait').show();
			
			if(joms.jQuery('#authenticate').val() != '1')
			{
				joms.registrations.authenticateAssign();
				return false;			
			}						
		});
		
		joms.jQuery( document ).ready( function(){
			joms.privacy.init();
		});
	</script>	
<?php
}
else
{
?>
	<div class="cAlert"><?php echo JText::_('COM_COMMUNITY_NO_CUSTOM_PROFILE_CREATED_YET');?></div>
<?php
}
?>