<?php
/**
 * @package	JomSocial
 * @copyright (C) 2008 by Slashes & Dots Sdn Bhd - All rights reserved!
 * @license		GNU/GPL, see LICENSE.php
 */
 
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

/** detect and display facebook language **/
if (!defined('FACEBOOK_LANG_AVAILABLE')) {
define('FACEBOOK_LANG_AVAILABLE', 1);
}

$lang = JFactory::getLanguage();
$currentLang =  $lang->get('tag');

$fbLang =   explode(',', trim(FACEBOOK_LANGUAGE) );
$currentLang = str_replace('-','_',$currentLang);
$fbLangScript = '<script src="http://connect.facebook.net/en_GB/all.js" type="text/javascript"></script>';

if(in_array($currentLang,$fbLang)==FACEBOOK_LANG_AVAILABLE){
    $fbLangScript = '<script src="http://connect.facebook.net/'.$currentLang.'/all.js" type="text/javascript"></script>';
}

$fbLangScript = CUrlHelper::httpsURI($fbLangScript);
?>

<div id="fb-root"></div><b><?php echo JText::_('COM_COMMUNITY_OR');?></b>&nbsp;

<?php echo $fbLangScript; ?>
<script type="text/javascript">
function jomFbButtonInit(){
	FB.init({
		appId: '<?php echo $config->get('fbconnectkey');?>', 
		status: true, 
		cookie: true, 
		oauth: true,
		xfbml: true
		});
	}
	
	 FB.Event.subscribe('auth.login', function(response) {
          //window.location.reload();
        });
	
	/*
	FB.Event.subscribe('auth.logout', function(response) {
	  window.location.reload();
	});
	*/


if( typeof window.FB != 'undefined' ) {
	jomFbButtonInit();
} else {
	window.fbAsyncInit = jomFbButtonInit;
}
<?php 
	$fbScope = array('offline_access','email');
	$config	= CFactory::getConfig();
	if($config->get('fbconnectupdatestatus')){
		$fbScope[] = 'user_status';
		$fbScope[] = 'status_update';
		$fbScope[] = 'read_stream';
	}
	if($config->get('fbconnectpoststatus')){
		$fbScope[] = 'publish_stream';
	}
	if($config->get('fbsignupimport') || $config->get('fbloginimportprofile')){
		$fbScope[] = 'user_birthday';
	}
	
?>
</script>
<fb:login-button  onlogin="joms.connect.update();" scope="<?php echo implode($fbScope, ',')?>"><?php echo JText::_('COM_COMMUNITY_SIGN_IN_WITH_FACEBOOK');?></fb:login-button>

