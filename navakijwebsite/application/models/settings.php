<?php
class Settings extends CI_Model{
	var $_setting = array();
	public function __construct()
	{
		parent::__construct();
		$setting = $this->db->get("system_setting")->result_array();	
		foreach($setting as $row){
			$this->_setting[$row['setting_key']]=$row['setting_value'];	
		}
	}
	public function item($key)
	{
		if(isset($this->_setting[$key])){
			return $this->_setting[$key];
		}else{
			return NULL;
		}
	}
	public function set($key,$value)
	{
		$this->db->set("setting_value",$value);
		if(isset($this->_setting[$key])){
			$this->db->where("setting_key",$key);	
			$this->db->update("system_setting");
		}else{
			$this->db->set("setting_key",$key);	
			$this->db->insert("system_setting");
		}
	}
}