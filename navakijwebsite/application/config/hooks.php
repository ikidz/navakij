<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

/*
$hook['post_system'][] = array(
					        'class' => 'QueryLogHook',
					        'function' => 'log_queries',
					        'filename' => 'QueryLogHook.php',
					        'filepath' => 'hooks');
$hook['pre_system'] = array('class'    => 'RewriteURLHook',
                            'function' => 'make_rewrite',
                            'filename' => 'RewriteURLHook.php',
                            'filepath' => 'hooks');
*/
$hook['post_controller_constructor'] = array('class'    => 'SettingHook',
                            'function' => 'db_setting',
                            'filename' => 'SettingHook.php',
                            'filepath' => 'hooks');                   
/* End of file hooks.php */
/* Location: ./application/config/hooks.php */