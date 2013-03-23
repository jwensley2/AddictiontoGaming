<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;

$db['default']['hostname'] = 'internal-db.s139665.gridserver.com';
$db['default']['username'] = 'db139665_atg';
$db['default']['password'] = 'IfoY8oKgCd';
$db['default']['database'] = 'db139665_atg_site';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
$db['default']['pconnect'] = TRUE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;

$db['phpbb']['hostname'] = "internal-db.s139665.gridserver.com";
$db['phpbb']['username'] = "db139665_phpbb";
$db['phpbb']['password'] = "sGIlzgKuFC";
$db['phpbb']['database'] = "db139665_atg_phpbb3";
$db['phpbb']['dbdriver'] = "mysql";
$db['phpbb']['dbprefix'] = "";
$db['phpbb']['pconnect'] = TRUE;
$db['phpbb']['db_debug'] = TRUE;
$db['phpbb']['cache_on'] = FALSE;
$db['phpbb']['cachedir'] = "";
$db['phpbb']['char_set'] = "utf8";
$db['phpbb']['dbcollat'] = "utf8_general_ci";
$db['phpbb']['swap_pre'] = '';
$db['phpbb']['autoinit'] = TRUE;
$db['phpbb']['stricton'] = FALSE;

$db['sourcemod']['hostname'] = "internal-db.s139665.gridserver.com";
$db['sourcemod']['username'] = "db139665_atg";
$db['sourcemod']['password'] = "IfoY8oKgCd";
$db['sourcemod']['database'] = "db139665_atg_sourcemod";
$db['sourcemod']['dbdriver'] = "mysql";
$db['sourcemod']['dbprefix'] = "";
$db['sourcemod']['pconnect'] = TRUE;
$db['sourcemod']['db_debug'] = TRUE;
$db['sourcemod']['cache_on'] = FALSE;
$db['sourcemod']['cachedir'] = "";
$db['sourcemod']['char_set'] = "utf8";
$db['sourcemod']['dbcollat'] = "utf8_general_ci";
$db['sourcemod']['swap_pre'] = '';
$db['sourcemod']['autoinit'] = TRUE;
$db['sourcemod']['stricton'] = FALSE;

/*
$db['hlstats']['hostname'] = "localhost";
$db['hlstats']['username'] = "db139665_atg";
$db['hlstats']['password'] = "IfoY8oKgCd";
$db['hlstats']['database'] = "atg_hlxce";
$db['hlstats']['dbdriver'] = "mysql";
$db['hlstats']['dbprefix'] = "";
$db['hlstats']['pconnect'] = TRUE;
$db['hlstats']['db_debug'] = TRUE;
$db['hlstats']['cache_on'] = FALSE;
$db['hlstats']['cachedir'] = "";
$db['hlstats']['char_set'] = "utf8";
$db['hlstats']['dbcollat'] = "utf8_general_ci";
$db['hlstats']['swap_pre'] = '';
$db['hlstats']['autoinit'] = TRUE;
$db['hlstats']['stricton'] = FALSE;
*/


/* End of file database.php */
/* Location: ./application/config/database.php */