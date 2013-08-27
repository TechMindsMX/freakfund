<?php
/**
* @version   $Id: social.php 9634 2013-04-24 06:43:01Z arifin $
* @author    RocketTheme http://www.rockettheme.com
* @copyright Copyright (C) 2007 - 2013 RocketTheme, LLC
* @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
*
* Gantry uses the Joomla Framework (http://www.joomla.org), a GNU/GPLv2 content management system
*
*/
defined('JPATH_BASE') or die();

gantry_import('core.gantryfeature');

class GantryFeatureSocial extends GantryFeature {
	var $_feature_name = 'social';

	function init(){
		global $gantry;
	}

	function render($position="") {
		
		ob_start();
		global $gantry;
		
		?>
		<div class="rt-social-buttons">
			<span class="social-button">
				<span class="icon-random"></span>
			</span>
			<span class="rt-social-text"><?php echo $gantry->get('social-text'); ?></span>
			<?php if ($gantry->get('social-facebook') != "") : ?>
			<a class="social-button rt-facebook-btn" href="<?php echo $gantry->get('social-facebook'); ?>">
				<span class="icon-facebook"></span>
			</a>
			<?php endif; ?>
			<?php if ($gantry->get('social-twitter') != "") : ?>
			<a class="social-button rt-twitter-btn" href="<?php echo $gantry->get('social-twitter'); ?>">
				<span class="icon-twitter"></span>
			</a>
			<?php endif; ?>
			<?php if ($gantry->get('social-google') != "") : ?>
			<a class="social-button rt-google-btn" href="<?php echo $gantry->get('social-google'); ?>">
				<span class="icon-google-plus"></span>
			</a>
			<?php endif; ?>
			<?php if ($gantry->get('social-youtube') != "") : ?>
			<a class="social-button rt-google-btn" href="<?php echo $gantry->get('social-youtube');	?>">			
				<span class="icon-play"></span>
			</a>
			<?php endif; ?>
			<?php if ($gantry->get('social-linkedin') != "") : ?>
			<a class="social-button rt-google-btn" href="<?php echo $gantry->get('social-linkedin'); ?>">
				<span class="icon-linkedin"></span>
			</a>
			<?php endif; ?>
			<?php if ($gantry->get('social-rss') != "") : ?>
			<a class="social-button rt-rss-btn" href="<?php echo $gantry->get('social-rss'); ?>">
				<span class="icon-rss"></span>
			</a>
			<?php endif; ?>
			<div class="clear"></div>
		</div>
		<?php
		return ob_get_clean();
	}
}
