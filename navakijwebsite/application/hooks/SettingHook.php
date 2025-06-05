<?php 

class SettingHook{
	function db_setting()
	{
		 $CI =& get_instance(); 
		 
		 $results = $CI->db->get('system_settings')->result();
		 
		 foreach ($results as $setting) {
		 
		 $CI->config->set_item($setting->setting_id, $setting->setting_value);
		 
		 }
	 }
}
