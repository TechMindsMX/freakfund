<?php
/**
 * @package		Joomla.Site
 * @subpackage	Application
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Joomla! Application define.
 */

//Global definitions.
//Joomla framework path definitions.
$parts = explode(DIRECTORY_SEPARATOR, JPATH_BASE);

//Defines.
define('JPATH_ROOT',			implode(DIRECTORY_SEPARATOR, $parts));

define('JPATH_SITE',			JPATH_ROOT);
define('JPATH_CONFIGURATION',	JPATH_ROOT);
define('JPATH_ADMINISTRATOR',	JPATH_ROOT . '/administrator');
define('JPATH_LIBRARIES',		JPATH_ROOT . '/libraries');
define('JPATH_PLUGINS',			JPATH_ROOT . '/plugins'  );
define('JPATH_INSTALLATION',	JPATH_ROOT . '/installation');
define('JPATH_THEMES',			JPATH_BASE . '/templates');
define('JPATH_CACHE',			JPATH_BASE . '/cache');
define('JPATH_MANIFESTS',		JPATH_ADMINISTRATOR . '/manifests');

$middle = "api-stage.timone.mx";
$puertoTimOne =  "";
$controllerTimOne =  "/timone/services/";

define("MIDDLE", 'http://'.$middle);
define("PUERTO", $puertoTimOne);
define("TIMONE", $controllerTimOne);

define("AVATAR", "/development/media/trama_files/avatar");
define("BANNER", "/development/media/trama_files/banner");
define("PHOTO", "/development/media/trama_files/photo");
define("BCASE", "businesscase");
define("SOUNDCLOUD_CLIENT_ID","52bdfab59cb4719ea8d5ea626efae0da");
define("SOUNDCLOUD_CLIENT_SECRET","7688bd528138b2de5daf52edffc091c5");
