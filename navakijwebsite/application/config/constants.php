<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');
define("ADMIN_PATH",							"administrator/"); 
define('UPLOAD_PATH', 							realpath( 'public/core/uploaded' ) );

define('RECAPTCHA_KEY','6LegBy0UAAAAAPfxCdCGTG8HKBzEIdrIb7LQIGhE');
define('MAPS_KEY','AIzaSyBaQ_E9cSPk2vvduX0bG_3MgbwIFjyytPQ');
define('MAPS_DISTANCE_SEARCH',10);

/* PDPA Cookie - Start */
define('COOKIE_NAME', 'PDPACookie');
/* PDPA Cookie - End */

/* Language - Start */
define('DEFAULT_LANGUAGE','th');
/* Language - End */

/* IP Geolocation - Start */
define('IPGEO_API_KEY', '4c37a5493ed64ab6ab60f161e9723442');
define('IPGEO_COOKIE_NAME', 'IPCookie');
/* IP Geolocation - End */

/* End of file constants.php */
/* Location: ./application/config/constants.php */