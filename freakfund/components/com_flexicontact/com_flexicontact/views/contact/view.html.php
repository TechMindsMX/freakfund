<?php
/********************************************************************
Product		: Flexicontact
Date		: 7 May 2013
Copyright	: Les Arbres Design 2009-2013
Contact		: http://www.lesarbresdesign.info
Licence		: GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted Access');

class FlexicontactViewContact extends JViewLegacy
{

//---------------------------------------------------------------------------------------------------------
// display the contact form
//
function display($tpl = null)
{
	$app = JFactory::getApplication('site');
	$menu_params =  $app->getParams();

	if (isset($menu_params->pageclass_sfx))
		echo "\n".'<div class="flexicontact'.$menu_params->pageclass_sfx.'">';
	else
		echo "\n".'<div class="flexicontact">';

// get the page title
	
	$page_heading = '';
	if ($menu_params->get('show_page_title', '0'))
		$page_heading = $menu_params->get('page_title', '');				// Page Display Options, Joomla 1.5
	
	if ($menu_params->get('show_page_heading', '0'))						// Page Display Options, Joomla > 1.5
		$page_heading = $menu_params->get('page_heading', '');

// if there is a page heading in Page Display Options, draw it in H1

	if ($page_heading != '')
		echo "\n<h1>".$page_heading.'</h1>';
		
// if there is a page title in Basic Options, draw it in H2

	if ($menu_params->get('page_hdr', '') != '')							// Basic Options
		echo "\n<h2>".$menu_params->get('page_hdr', '').'</h2>';

// draw top text, if any

	if (!empty($this->config_data->page_text))		// top text
		{
		JPluginHelper::importPlugin('content');
		$page_text = JHtml::_('content.prepare', $this->config_data->page_text);
		echo "\n".'<div>'.$page_text.'</div>';
		}

	if (!empty($errors))								// if validation failed
		{
		echo '<span class="fc_error">'.JText::_('COM_FLEXICONTACT_MESSAGE_NOT_SENT').'</span>';
		if (isset($errors['top']))
			echo '<br /><span class="fc_error">'.$errors['top'].'</span>';
		}
	
// start the form

	$uri = JFactory::getURI();
	$myuri = $uri->toString();
	echo "\n".'<form name="fc_form" action="'.JRoute::_($myuri).'" method="post" class="fc_form">';
	echo JHTML::_('form.token');
	echo '<input type="hidden" name="option" value="'.LAFC_COMPONENT.'" />';
	echo '<input type="hidden" name="task" value="send" />';
	echo '<table class="fc_table">';

// from name
	if(empty($this->post_data->from_email)){
	echo '<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_FROM_NAME').'</td>
			<td class="fc_field">
			<input type="text" class="fc_input" name="from_name" size="30" value="'.$this->escape($this->post_data->from_name).'" /> '.
				self::get_error('from_name').'</td></tr>';}else{echo '<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_FROM_NAME').'</td>
			<td class="fc_field">
			<input type="text" class="fc_input" name="from_name" size="30" value="'.$this->escape($this->post_data->from_name).'" readonly /> '.
				self::get_error('from_name').'</td></tr>';}

	
// from email address
	if(empty($this->post_data->from_email)){
	echo '<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_FROM_ADDRESS').'</td>
		  	<td class="fc_field">
			<input type="text" class="fc_input" name="from_email" size="30" value="'.$this->escape($this->post_data->from_email).'" /> '.
				self::get_error('from_email').'</td></tr>';}else{echo '<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_FROM_ADDRESS').'</td>
		  	<td class="fc_field">
			<input type="text" class="fc_input" name="from_email" size="30" value="'.$this->escape($this->post_data->from_email).'" readonly /> '.
				self::get_error('from_email').'</td></tr>';}
				
// subject

	if ($this->config_data->show_subject)
		echo '<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_SUBJECT').'</td>
			<td class="fc_field">
			<input type="text" class="fc_input" name="subject" size="30" value="'.$this->escape($this->post_data->subject).'" /> '.
				self::get_error('subject').'</td></tr>';

// the five optional fields

	if ($this->config_data->field_opt1 != 'disabled')
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt1.'</td>
			<td class="fc_field">
			<input type="text" class="fc_input" maxlength="10" name="field1" size="30" value="'.$this->escape($this->post_data->field1).'" /> '.
			self::get_error('field1').'</td></tr>';
				
	if ($this->config_data->field_opt2 != 'disabled')
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt2.'</td>
			<td class="fc_field">
			<input type="text" class="fc_input" name="field2" size="30" value="'.$this->escape($this->post_data->field2).'" /> '.
			self::get_error('field2').'</td></tr>';
				
	if ($this->config_data->field_opt3 != 'disabled')
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt3.'</td>
			<td class="fc_field">
			<input type="text" class="fc_input" name="field3" size="30" value="'.$this->escape($this->post_data->field3).'" /> '.
			self::get_error('field3').'</td></tr>';
			  
	if ($this->config_data->field_opt4 != 'disabled')
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt4.'</td>
			<td class="fc_field">
			<input type="text" class="fc_input" name="field4" size="30" value="'.$this->escape($this->post_data->field4).'" /> '.
			self::get_error('field4').'</td></tr>';
			
	if ($this->config_data->field_opt5 != "disabled")
		echo "\n".'<tr><td class="fc_prompt">'.$this->config_data->field_prompt5.'</td>
			<td class="fc_field">
			<input type="text" class="fc_input" name="field5" size="30" value="'.$this->escape($this->post_data->field5).'" /> '.
			self::get_error('field5').'</td></tr>';

// the main text area

	if ($this->config_data->area_opt != 'disabled')
		echo "\n".'<tr><td class="fc_prompt" style="vertical-align:top">'.$this->config_data->area_prompt.'</td>
			<td class="fc_field">
			<textarea class="fc_input" name="area_data" rows="'.$this->config_data->area_height.'" cols="'.$this->config_data->area_width.'">'.$this->escape($this->post_data->area_data).'</textarea>
			<br />'.self::get_error('area_data').'</td></tr>';

// the "send me a copy" checkbox

	if ($this->config_data->show_copy == LAFC_COPYME_CHECKBOX)
		{
		if ($this->post_data->copy_me)
			$checked = 'checked = "checked"';
		else
			$checked = '';
		$checkbox = '<input type="checkbox" class="fc_input" name="copy_me" value="1" '.$checked.'/>';
		echo '<tr><td colspan="2" class="fc_field">'.$checkbox.' ';
		echo JText::_('COM_FLEXICONTACT_COPY_ME').'</td></tr>';
		}
	
// the agreement required checkbox

	$send_button_state = '';
	if ($this->config_data->agreement_prompt != '')
		{
		if ($this->post_data->agreement_check)
			$checked = 'checked = "checked"';
		else
			{
			$send_button_state = 'disabled="disabled"';
			$checked = '';
			}
		$onclick = ' onclick="if(this.checked==true){form.send_button.disabled=false;}else{form.send_button.disabled=true;}"';
		$checkbox = '<input type="checkbox" class="fc_input" name="agreement_check" value="1" '.$checked.$onclick.'/>';
		if (($this->config_data->agreement_name != '') and ($this->config_data->agreement_link != ''))
			{
			$popup = 'onclick="window.open('."'".$this->config_data->agreement_link."', 'fcagreement', 'width=640,height=480,scrollbars=1,location=0,menubar=0,resizable=1'); return false;".'"';
			$link_text = $this->config_data->agreement_prompt.' '.JHTML::link($this->config_data->agreement_link, $this->config_data->agreement_name, 'target="_blank" '.$popup);
			}
		else
			$link_text = $this->config_data->agreement_prompt;
		echo '<tr><td colspan="2" class="fc_field">'.$checkbox.' '.$link_text.'</td></tr>';
		}

// the magic word

	if ($this->config_data->magic_word != '')
		{
		echo "\n".'<tr><td class="fc_prompt">'.JText::_('COM_FLEXICONTACT_MAGIC_WORD').'</td>
			<td class="fc_field">
			<input type="text" class="fc_input" name="magic_word" size="30" value="'.$this->post_data->magic_word.'" /> '.
			self::get_error('magic_word').'</td></tr>';
		}

// the image captcha

	if ($this->config_data->num_images > 0)
		{
		echo "\n".'<tr><td colspan="2" class="fc_images">';
		require_once(LAFC_HELPER_PATH.'/flexi_captcha.php');
		echo Flexi_captcha::show_image_captcha($this->config_data, self::get_error('imageTest'));
		echo '</td></tr>';
		}

// the send button

	echo "\n".'<tr><td colspan="2" class="fc_button">';
	echo '<input type="submit" class="button fc_button" name="send_button" '.$send_button_state.' value="'.JText::_('COM_FLEXICONTACT_SEND_BUTTON').'" />';
	echo '</td></tr>';
	echo '</table>';

// bottom text

	if (!empty($this->config_data->bottom_text))
		{
		JPluginHelper::importPlugin('content');
		$bottom_text = JHtml::_('content.prepare', $this->config_data->bottom_text);
		echo "\n".'<div>'.$bottom_text.'</div>';
		}
		
	echo "\n</form>";
	echo "\n</div>";				// class="flexicontact"
}

//---------------------------------------------------------------------------------------------------------
// Get and format an error message
//
function get_error($field_name)
{
	if (isset($this->errors[$field_name]))
		return '<span class="fc_error">'.$this->errors[$field_name].'</span>';
	else
		return '';
}



	
}
?>
