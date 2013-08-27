<?php
/********************************************************************
Product		: Flexicontact
Date		: 7 May 2013
Copyright	: Les Arbres Design 2009-2013
Contact		: http://extensions.lesarbresdesign.info
Licence		: GNU General Public License
*********************************************************************/
defined('_JEXEC') or die('Restricted Access');

// if we get called by an <installfile> xml element, we will enter here, not via the InstallerScript class

$installer = new com_flexicontactInstallerScript;
return $installer->fc_install($this);
	
// if we get called by a <scriptfile> xml element, the installer will call the various functions of the InstallerScript class

class com_flexicontactInstallerScript
{
public function __constructor(JAdapterInstance $adapter) { }
public function preflight($route, JAdapterInstance $adapter) { }
public function install(JAdapterInstance $adapter) { }
public function update(JAdapterInstance $adapter) { }
public function uninstall(JAdapterInstance $adapter)
{ 
	echo "<h2>Flexicontact has been uninstalled</h2>";
}
public function postflight($route, JAdapterInstance $adapter)
{
	$this->fc_install($adapter);
}

//-------------------------------------------------------------------------------
// This is the code from older versions
//
function fc_install($adapter)
{
	$this->helper = new LA_install;				// instantiate our install helper class
	$this->db = JFactory::getDBO();
	$component_version = $this->helper->get_component_version($adapter);
	if ($component_version === false)
		return false;

// delete files from old (and very old) versions

	@unlink(JPATH_SITE.'/administrator/components/com_flexicontact/admin.flexicontact.php');
	@unlink(JPATH_SITE.'/administrator/components/com_flexicontact/flexicontact.xml');
	@unlink(JPATH_ROOT.'/administrator/components/com_flexicontact/toolbar.flexicontact.html.php'); 
	@unlink(JPATH_ROOT.'/administrator/components/com_flexicontact/toolbar.flexicontact.php'); 
	@unlink(JPATH_ROOT.'/administrator/components/com_flexicontact/admin.flexicontact.html.php');
	@unlink(JPATH_ROOT.'/components/com_flexicontact/flexicontact.html.php');
	@unlink(JPATH_ROOT.'/components/com_flexicontact/RL_flexicontact.html.php');

// add new column to the log table, if it exists
// (it doesn't get created unless the user turns logging on)

	if ($this->helper->table_exists('#__flexicontact_log'))
		$this->helper->add_column('#__flexicontact_log', 'admin_email', "VARCHAR(60) NOT NULL DEFAULT '' AFTER `email`");

// we are done

	echo "Flexicontact version $component_version installed.";
	return true;
}

} // end of class definition

//********************************************************************************
//
// The following helper class is common to all our installers.
// Nothing in this class is specific to any particular component.
//
//********************************************************************************

class LA_install
{
//-------------------------------------------------------------------------------
// Constructor
//
function LA_install()
{
	$this->db = JFactory::getDBO();
	$version = new JVersion();
	$this->joomla_version = $version->RELEASE;

// check the PHP version

	$php_version = phpversion();
	if ($php_version{0} < 5)
		echo "<h2>Warning: You are running an old version of PHP ($php_version) This extension requires at least version 5.0.</h2>";

// check the MySql version

	$this->db->setQuery("SELECT version()");
	$mysql_version = $this->db->loadResult();
	if ($mysql_version{0} < 5)
		echo "<h2>Warning: You are running an old version of MySql ($mysql_version) This extension requires at least version 5.0.</h2>";
}

//-------------------------------------------------------------------------------
// Check the Joomla version and get the component version from the component manifest xml file
//
function get_component_version($adapter)
{
	switch ($this->joomla_version)
		{
		case '1.0':
			echo '<h3>'."Cannot run on this version of Joomla ($joomla_version)".'</h3>';
			return false;
		case '1.5':
			$component_version = $adapter->manifest->version[0]->_data;
			break;
		case '1.6':
		case '1.7':
		case '2.5':
		case '3.0':
		case '3.1':
			$component_version = $adapter->get('manifest')->version;
			break;
		default:
			$component_version = $adapter->get('manifest')->version;
			$component_name = $adapter->get('manifest')->name;
			echo "<h3>Warning: This version of $component_name has not been tested on this version of Joomla ($this->joomla_version).</h3>";
			echo "<h3>Some functions may not work properly.</h3>";
			break;
		}
		
	return $component_version;
}

//-------------------------------------------------------------------------------
// Check whether a table exists in the database. Returns TRUE if exists, FALSE if it doesn't
//
function table_exists($table)
{
	$tables = $this->db->getTableList();
	$table = $this->replaceDbPrefix($table);
	if (self::in_arrayi($table,$tables))
		return true;
	else
		return false;
}

//-------------------------------------------------------------------------------
// Check whether a column exists in a table. Returns TRUE if exists, FALSE if it doesn't
//
function column_exists($table, $column)
{
	if ($this->joomla_version < 3.0)
		{
		$result = $this->db->getTableFields($table);
		$fields = &$result[$table];
		}
	else
		{
		$result = $this->db->getTableColumns($table);
		$fields = &$result;
		}
	if ($fields === null)
		return false;
	if (array_key_exists($column,$fields))
		return true;
	else
		return false;
}

//-------------------------------------------------------------------------------
// Add a column if it doesn't exist (the table must exist)
//
function add_column($table, $column, $details)
{
	if ($this->column_exists($table, $column))
		return true;
	$query = 'ALTER TABLE `'.$table.'` ADD `'.$column.'` '.$details;
	$this->db->setQuery($query);
	$this->db->query();
	if ($this->db->getErrorNum())
		{
		echo $this->db->stderr();
		return false;
		}
	return true;
}

//-------------------------------------------------------------------------------
// Change a column if it exists 
//
function change_column($table, $column, $details)
{
	if (!$this->column_exists($table, $column))
		return;
	$query = 'ALTER IGNORE TABLE `'.$table.'` CHANGE `'.$column.'` '.$details;
	$this->db->setQuery($query);
	$this->db->query();
	if ($this->db->getErrorNum())
		{
		echo $this->db->stderr();
		return false;
		}
}

//-------------------------------------------------------------------------------
// Miscellaneous SQL
//
function do_sql($query)
{
   	$this->db->setQuery($query);
   	$this->db->query();
   	if ($this->db->getErrorNum())
      	{
      	echo $this->db->stderr();
      	return false;
      	}
      return true;
}

//-------------------------------------------------------------------------------
// Miscellaneous SQL, ignoring errors
//
function do_sql_ignore($query)
{
	try
		{
		$this->db->setQuery($query);
		$this->db->query();
		}
 	catch (Exception $e)
		{
		}
 }

//-------------------------------------------------------------------------------
// Joomla 1.7 took away replacePrefix() for some unknown reason
//
function replaceDbPrefix($sql)
{
	$app = JFactory::getApplication();
	$dbprefix = $app->getCfg('dbprefix');
	return str_replace('#__',$dbprefix,$sql);
}

//-------------------------------------------------------------------------------
// Case insensitive in_array()
//
static function in_arrayi($needle, $haystack)
{
    return in_array(strtolower($needle), array_map('strtolower', $haystack));
}

//-------------------------------------------------------------------------------
// Used for debugging
//
static function trace($data)
{
	@file_put_contents(JPATH_ROOT.'/trace.txt', $data."\n",FILE_APPEND);
}


} // end of class definition



?>
