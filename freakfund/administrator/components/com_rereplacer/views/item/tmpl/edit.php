<?php
/**
 * Item View Template: Edit
 *
 * @package         ReReplacer
 * @version         5.7.1
 *
 * @author          Peter van Westen <peter@nonumber.nl>
 * @link            http://www.nonumber.nl
 * @copyright       Copyright © 2013 NoNumber All Rights Reserved
 * @license         http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

defined('_JEXEC') or die;

JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

$user = JFactory::getUser();
$db = JFactory::getDBO();
$query = $db->getQuery(true)
	->select('c.misc')
	->from('#__' . $this->config->contact_table . ' as c')
	->where('c.user_id = ' . (int) $user->id);
$db->setQuery($query);
$contact = $db->loadObject();

$view_state = $this->item->view_state;
if ($view_state == -1) {
	$view_state = $this->config->view_state;
}

JHtml::script('nnframework/script.min.js', false, true);
JFactory::getDocument()->addStyleDeclaration('.nn_multiselect { width:300px; }');

?>

<form action="<?php echo JRoute::_('index.php?option=com_rereplacer&id=' . ( int ) $this->item->id); ?>" method="post"
	name="adminForm" id="item-form">
	<input type="hidden" name="task" value="" />
	<?php echo JHtml::_('form.token'); ?>

	<?php ob_start(); ?>
	<div style="display:none;">
		<?php echo str_replace('value="' . $view_state . '"', 'value="' . $view_state . '" checked="checked"', str_replace('checked="checked"', '', $this->render($this->item->form, 'view_state'))); ?>
	</div>

	<div class="view_state_<?php echo $view_state; ?>" id="view_state_div">
		<div class="button1 button_view_state simple">
			<div>
				<a onclick="NNFrameworkChangeView( 0 );" class="hasTip"
					title="<?php echo JText::_('NN_SIMPLE') . '::' . JText::_('RR_SIMPLE_DESC'); ?>"><?php echo JText::_('NN_SIMPLE'); ?></a>
			</div>
		</div>
		<div class="button1 button_view_state normal">
			<div>
				<a onclick="NNFrameworkChangeView( 1 );" class="hasTip"
					title="<?php echo JText::_('NN_NORMAL') . '::' . JText::_('RR_NORMAL_DESC'); ?>"><?php echo JText::_('NN_NORMAL'); ?></a>
			</div>
		</div>
		<div class="button1 button_view_state advanced">
			<div>
				<a onclick="NNFrameworkChangeView( 2 );" class="hasTip"
					title="<?php echo JText::_('NN_ADVANCED') . '::' . JText::_('RR_ADVANCED_DESC'); ?>"><?php echo JText::_('NN_ADVANCED'); ?></a>
			</div>
		</div>
		<div class="clr"></div>
	</div>
	<?php
	$view_state_buttons = ob_get_contents();
	ob_end_clean();
	?>

	<div class="width-100">
		<?php echo str_replace('VIEW_STATE_PLACEHOLDER', $view_state_buttons, $this->render($this->item->form, 'main_texts')); ?>
	</div>

	<table width="100%">
		<tr>
			<td valign="top">
				<div class="width-100">
					<?php echo $this->render($this->item->form, 'details', JText::_('JDETAILS')); ?>

					<?php echo $this->render($this->item->form, 'search', JText::_('RR_SEARCH_REPLACE')); ?>

					<fieldset class="adminform">
						<legend><?php echo JText::_('RR_DYNAMIC_TAGS'); ?></legend>
						<?php
						$_tick = '<img src="../media/nnframework/images/tick.png" border="0" alt="' . JText::_('JYES') . '" title="' . JText::_('JYES') . '" />';
						$_cross = '<img src="../media/nnframework/images/publish_x.png" border="0" alt="' . JText::_('JNO') . '" title="' . JText::_('JNO') . '" />';
						?>
						<p><?php echo JText::_('RR_DYNAMIC_TAGS_DESC'); ?></p>

						<table class="adminlist" style="width:auto;">
							<thead>
								<tr>
									<th><label><?php echo JText::_('RR_SYNTAX'); ?></label></th>
									<th style="text-align:left">
										<span><?php echo JText::_('JGLOBAL_DESCRIPTION'); ?></span></th>
									<th style="text-align:left">
										<span><?php echo JText::_('RR_INPUT_EXAMPLE'); ?></span></th>
									<th style="text-align:left">
										<span><?php echo JText::_('RR_OUTPUT_EXAMPLE'); ?></span></th>
									<th>
										<span class="hasTip" title="<?php echo JText::_('NN_NORMAL'); ?>::<?php echo JText::_('RR_USE_IN_NORMAL'); ?>"><?php echo JText::_('NN_NORMAL'); ?></span>
									</th>
									<th>
										<span class="hasTip" title="<?php echo JText::_('RR_REGEX'); ?>::<?php echo JText::_('RR_USE_IN_REGEX'); ?>"><?php echo JText::_('RR_REGEX'); ?></span>
									</th>
									<th>
										<span class="hasTip" title="<?php echo JText::_('RR_SEARCH'); ?>::<?php echo JText::_('RR_USE_IN_SEARCH'); ?>"><?php echo JText::_('RR_SEARCH'); ?></span>
									</th>
									<th>
										<span class="hasTip" title="<?php echo JText::_('RR_REPLACE'); ?>::<?php echo JText::_('RR_USE_IN_REPLACE'); ?>"><?php echo JText::_('RR_REPLACE'); ?></span>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td style="font-family:monospace">[[comma]]</td>
									<td><?php echo JText::_('RR_USE_INSTEAD_OF_A_COMMA'); ?></td>
									<td style="font-family:monospace">[[comma]]</td>
									<td style="font-family:monospace">,</td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[space]]</td>
									<td><?php echo JText::_('RR_USE_FOR_LEADING_OR_TRAILING_SPACES'); ?></td>
									<td style="font-family:monospace">[[space]]</td>
									<td></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[user:id]]</td>
									<td><?php echo JText::_('RR_DYNAMIC_TAG_USER_ID'); ?></td>
									<td style="font-family:monospace">[[user:id]]</td>
									<td><?php echo $user->id; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[user:username]]</td>
									<td><?php echo JText::_('RR_DYNAMIC_TAG_USER_USERNAME'); ?></td>
									<td style="font-family:monospace">[[user:username]]</td>
									<td><?php echo $user->username; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[user:name]]</td>
									<td><?php echo JText::_('RR_DYNAMIC_TAG_USER_NAME'); ?></td>
									<td style="font-family:monospace">[[user:name]]</td>
									<td><?php echo $user->name; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[user:...]]</td>
									<td><?php echo JText::_('RR_DYNAMIC_TAG_USER_OTHER'); ?></td>
									<td style="font-family:monospace">[[user:misc]]</td>
									<td><?php echo isset($contact->misc) ? $contact->misc : ''; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[date:...]]</td>
									<td><?php echo JText::sprintf('RR_DYNAMIC_TAG_DATE', '<a rel="{handler: \'iframe\', size:{x:window.getSize().x-100, y: window.getSize().y-100}}" href="http://www.php.net/manual/function.strftime.php" class="modal">', '</a>'); ?></td>
									<td nowrap="nowrap" style="font-family:monospace">[[date:%A, %d %B %Y]]</td>
									<td><?php
										$date = JFactory::getDate('now', 'UTC');
										echo $date->toFormat('%A, %d %B %Y');
										?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[random:...-...]]</td>
									<td><?php echo JText::_('RR_DYNAMIC_TAG_RANDOM'); ?></td>
									<td style="font-family:monospace">[[random:0-100]]</td>
									<td><?php echo rand(0, 100); ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[counter]]</td>
									<td><?php echo JText::_('RR_DYNAMIC_TAG_COUNTER'); ?></td>
									<td style="font-family:monospace">[[counter]]</td>
									<td>1</td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
								<tr>
									<td style="font-family:monospace">[[escape]]..[[/escape]]</td>
									<td><?php echo JText::_('RR_DYNAMIC_TAG_ESCAPE'); ?></td>
									<td style="font-family:monospace">[[escape]]\1[[/escape]]</td>
									<td>\"It\'s a string!\"</td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
									<td align="center"><?php echo $_cross; ?></td>
									<td align="center"><?php echo $_tick; ?></td>
								</tr>
							</tbody>
						</table>

						<p><?php echo JText::sprintf('RR_HELP_ON_REGULAR_EXPRESSIONS', '<a rel="{handler: \'iframe\', size: {x: 800, y: window.getSize().y-100}}" href="index.php?nn_qp=1&folder=media.rereplacer.images&file=image.inc.php" class="modal">', '</a>'); ?></p>

					</fieldset>
				</div>

				<div class="clr"></div>
			</td>
			<td valign="top" width="1%">
				<div class="width-100">
					<div id="<?php echo rand(1000000, 9999999); ?>___view_state.1___view_state.2"
						class="nntoggler nntoggler_horizontal">
						<div id="<?php echo rand(1000000, 9999999); ?>___view_state.1___view_state.2"
							class="nntoggler nntoggler_nofx">
							<div style="width:550px;">
								<?php
								echo JHtml::_('sliders.start', 'rereplacer-sliders');
								echo JHtml::_('sliders.panel', JText::_('RR_SEARCH_OPTIONS'), 'search-page');
								echo $this->render($this->item->form, 'options');

								echo JHtml::_('sliders.panel', JText::_('RR_SEARCH_AREAS'), 'areas-page');
								echo $this->render($this->item->form, 'areas');

								$html = JHtml::_('sliders.panel', JText::_('NN_PUBLISHING_ASSIGNMENTS'), 'assignments-page');
								echo str_replace('<div class="panel">', '<div id="' . rand(1000000, 9999999) . '___view_state.2" class="panel nntoggler">', $html);
								echo $this->render($this->item->form, 'assignments');

								echo JHtml::_('sliders.end');
								?>
							</div>
						</div>
					</div>
				</div>

				<div class="clr"></div>
			</td>
		</tr>
	</table>

	<div class="clr"></div>
</form>

<script language="javascript" type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'item.cancel') {
			Joomla.submitform(task);
			return;
		}

		// do field validation
		passCheck = checkFields();
		if (passCheck) {
			Joomla.submitform(task);
		}
	}

	function checkFields()
	{
		var f = document.adminForm;
		msg = '';
		// do field validation
		if (f['jform[name]'].value == '') {
			msg = '<?php echo JText::_('RR_THE_ITEM_MUST_HAVE_A_NAME', true); ?>';
		} else {
				if (f['jform[search]'].value == '') {
					msg = '<?php echo JText::_('RR_THE_ITEM_MUST_HAVE_SOMETHING_TO_SEARCH_FOR', true); ?>';
				}
		}
		if (msg != '') {
			alert(msg);
			return 0;
		} else {
			return checkFields_2();
		}
	}
	function checkFields_2()
	{
		var f = document.adminForm;
		msg = '';
		// do field validation
		if (
				f['jform[search]'].value.trim() != '' && f['jform[search]'].value.trim().length < 3
			) {
			msg = '<?php echo sprintf(JText::_('RR_THE_SEARCH_STRING_SHOULD_BE_LONGER', true), 2); ?>';
		}
		if (msg != '') {
			alert(msg);
			return 0;
		} else {
			return 1;
		}
	}
	checkFields_2();
</script>
