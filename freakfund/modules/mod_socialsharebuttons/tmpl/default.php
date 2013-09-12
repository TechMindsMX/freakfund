<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<?php
	echo "<!-- Social Share Buttons | Powered by <a href=\"http://e-max.it/posizionamento-siti-web\" title=\"ottimizzazione siti web\" target=\"_blank\">incrementa il tuo traffico web con e-max.it</a> -->";
	
?>
<div class="social-share-button-mod<?php echo $params->get('moduleclass_sfx');?>">
    <?php
    echo SocialShareButtonsHelper::getFacebookLike($params, $url, $title);
    echo SocialShareButtonsHelper::getFacebookShareMe($params, $url, $title);
    echo SocialShareButtonsHelper::getTwitter($params, $url, $title);
    echo SocialShareButtonsHelper::getReTweetMeMe($params, $url, $title);
    echo SocialShareButtonsHelper::getDigg($params, $url, $title);
    echo SocialShareButtonsHelper::getStumbpleUpon($params, $url, $title);
	echo SocialShareButtonsHelper::getTumblr($params, $url, $title);
	echo SocialShareButtonsHelper::getReddit($params, $url, $title);
	echo SocialShareButtonsHelper::getPinterest($params, $url, $title);
	echo SocialShareButtonsHelper::getBufferApp($params, $url, $title);
    echo SocialShareButtonsHelper::getLinkedIn($params, $url, $title);
    echo SocialShareButtonsHelper::getBuzz($params, $url, $title);
    echo SocialShareButtonsHelper::getGooglePlusOne($params, $url, $title);
    ?>
</div>
<div style="clear:both;"></div>
<?php
	
	if (($params->get( 'credits'))) {
		echo "<div class=\"social_share_buttons_credits\">Powered by <a href=\"http://e-max.it/posizionamento-siti-web/kickstart\" title=\"e-max.it: posizionamento siti web\" target=\"_blank\">primi sui motori con e-max.it</a></div>";
	}
	else {
		echo "<div class=\"social_share_buttons_credits\" style=\"display:none;\">Powered by <a href=\"http://e-max.it/posizionamento-siti-web/kickstart\" title=\"e-max.it: posizionamento siti web\" target=\"_blank\">primi sui motori con e-max.it</a></div>";
	}

	echo "<!-- Social Share Buttons | Powered by <a href=\"http://e-max.it/posizionamento-siti-web/socialize\" title=\"social media marketing\" target=\"_blank\">e-max.it: sem e smm</a> -->";
?>
<div style="clear:both;"></div>