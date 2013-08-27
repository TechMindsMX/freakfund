<?php
/********************************************************************
Product		: Flexicontact
Date		: 1 February 2013
Copyright	: Les Arbres Design 2010-2013
Contact		: http://extensions.lesarbresdesign.info
Licence		: GNU General Public License
*********************************************************************/

defined('_JEXEC') or die('Restricted Access');

class FlexicontactViewLog_Detail extends JViewLegacy
{
function display($tpl = null)
{
	JToolBarHelper::title(LAFC_COMPONENT_NAME.': <small><small>'.JText::_('COM_FLEXICONTACT_LOG').'</small></small>', 'flexicontact.png');
	JToolBarHelper::back();
	
	$log_data = &$this->log_data;

	echo '<table class="fc_table">';
	echo "\n".'<tr><td class="prompt"><strong>'.JText::_('COM_FLEXICONTACT_DATE_TIME').'</strong></td><td>'.$log_data->datetime.'</strong></td></tr>';
	echo "\n".'<tr><td class="prompt"><strong>'.JText::_('COM_FLEXICONTACT_NAME').'</strong></td><td>'.$this->log_data->name.'</strong></td></tr>';
	echo "\n".'<tr><td class="prompt"><strong>'.JText::_('COM_FLEXICONTACT_EMAIL').'</strong></td><td>'.$this->log_data->email.'</strong></td></tr>';
	echo "\n".'<tr><td class="prompt"><strong>'.JText::_('COM_FLEXICONTACT_ADMIN_SUBJECT').'</strong></td><td>'.$this->log_data->subject.'</strong></td></tr>';
	
// the main message

	echo "\n".'<tr><td class="prompt" valign="top"><strong>'.JText::_('COM_FLEXICONTACT_MESSAGE').'</strong></strong></td>';
	$message = nl2br($this->log_data->message);
	if (substr($message, 0, 6) == '<br />')
    	$message = substr($message, 6);
	echo "\n".'<td style="white-space: normal;">'.$message.'</strong></td></tr>';
	
	if ($this->log_data->field1)
		echo "\n".'<tr><td class="prompt"><strong>'.$this->config_data->field_prompt1.'</strong></td><td>'.$this->log_data->field1.'</strong></td></tr>';
	if ($this->log_data->field2)
		echo "\n".'<tr><td class="prompt"><strong>'.$this->config_data->field_prompt2.'</strong></td><td>'.$this->log_data->field2.'</strong></td></tr>';
	if ($this->log_data->field3)
		echo "\n".'<tr><td class="prompt"><strong>'.$this->config_data->field_prompt3.'</strong></td><td>'.$this->log_data->field3.'</strong></td></tr>';
	if ($this->log_data->field4)
		echo "\n".'<tr><td class="prompt"><strong>'.$this->config_data->field_prompt4.'</strong></td><td>'.$this->log_data->field4.'</strong></td></tr>';
	if ($this->log_data->field5)
		echo "\n".'<tr><td class="prompt"><strong>'.$this->config_data->field_prompt5.'</strong></td><td>'.$this->log_data->field5.'</strong></td></tr>';

// admin_email was only added to the log at version 6.01 so older logs have it blank - better not to show it

	if ($this->log_data->admin_email != '')
		echo "\n".'<tr><td class="prompt"><strong>'.JText::_('COM_FLEXICONTACT_V_EMAIL_TO').'</strong></td><td>'.$this->log_data->admin_email.'</td></tr>';
		
	echo "\n".'<tr><td class="prompt"><strong>'.JText::_('COM_FLEXICONTACT_IP_ADDRESS').'</strong></td><td>'.$this->log_data->ip.'</strong></td></tr>';
	echo "\n".'<tr><td class="prompt"><strong>'.JText::_('COM_FLEXICONTACT_BROWSER').'</strong></td><td>'.$this->log_data->browser_string.'</strong></td></tr>';
	echo "\n".'<tr><td class="prompt"><strong>'.JText::_('COM_FLEXICONTACT_STATUS').'</strong></td><td>'.$this->_status($this->log_data->status_main).'</strong></td></tr>';
	echo "\n".'<tr><td class="prompt"><strong>'.JText::_('COM_FLEXICONTACT_STATUS_COPY').'</strong></td><td>'.$this->_status($this->log_data->status_copy).'</strong></td></tr>';
	echo '</table>';
}

function _status($status)
{
	if ($status == '0')		// '0' status means no mail was sent
		return '';
	if ($status == '1')		// '1' means email was sent ok
		return '<img src="'.LAFC_ADMIN_ASSETS_URL.'tick.png" border="0" alt="" />';
	return $status;			// anything else was an error
}


}