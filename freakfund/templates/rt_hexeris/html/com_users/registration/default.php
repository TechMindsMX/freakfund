<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>

<script type="text/javascript">
jQuery(document).ready(function() {
	var ancho = jQuery(window).width()*.8;
	var alto = jQuery(window).height()*.8;
	jQuery('div.aceptarTerminos > iframe').width(ancho);
	jQuery('div.aceptarTerminos > iframe').height(alto);
	
	jQuery('#aceptado').click(function() {
		var chequeado = jQuery('#aceptado').prop('checked');
		if (chequeado == true ) {
			jQuery('.validate').prop('disabled', false);
		}
		else {
			jQuery('.validate').attr('disabled', 'disabled' );
		}
	});
});
</script>

<div class="registration<?php echo $this->pageclass_sfx?>">
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>

	<form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
	<?php $fields = $this->form->getFieldset($fieldset->name);?>
	<?php if (count($fields)):?>
		<fieldset>
		<?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
		?>
			<legend><?php echo JText::_($fieldset->label);?></legend>
		<?php endif;?>
			<dl>
		<?php foreach($fields as $field):// Iterate through the fields in the set and display them.?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
				<dt>
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type!='Spacer'): ?>
						<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
					<?php endif; ?>
				</dt>
				<dd><?php echo ($field->type!='Spacer') ? $field->input : "&#160;"; ?></dd>
			<?php endif;?>
		<?php endforeach;?>
			</dl>
		</fieldset>
	<?php endif;?>
<?php endforeach;?>
		<div>
		<div id="terminos">
			<input id="aceptado" type="checkbox" value="" name="aceptarTerminos" />
			<span><label for="aceptarTerminos"><?php echo JText::_('I_ACCEPT');?>
			<a href="#" data-rokbox="" data-rokbox-element="div.aceptarTerminos"><?php echo JText::_('TERMS');?></a></label>
			</span>
		</div>
			<input type="submit" class="button validate" disabled="disabled" value="<?php echo JText::_('JREGISTER');?>" />
			<?php echo JText::_('COM_USERS_OR');?>
			<a href="<?php echo JRoute::_('');?>" title="<?php echo JText::_('JCANCEL');?>"><?php echo JText::_('JCANCEL');?></a>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
			<?php echo JHtml::_('form.token');?>
		</div>
	</form>
</div>
	<div class="esconder">
		<div class="aceptarTerminos">
			<iframe src="<?php JURI::base(); ?>index.php?option=com_content&view=article&id=14&tmpl=component"></iframe>
		</div> 
	</div>