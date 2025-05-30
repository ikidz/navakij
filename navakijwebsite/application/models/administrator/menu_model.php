<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class menu_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function dataTable()
	{
		$this->db->where("menu_sequent <",900);
		$this->db->order_by("menu_sequent","ASC");
		$this->db->limit(1000);
		
		$menu = $this->db->get("system_menu")->result_array();
		return $menu;
	}
	public function getmenu($menu_id)
	{
		$this->db->where("menu_id",$menu_id);
		$menu = $this->db->get("system_menu")->row_array();
		return $menu;	
	}
	public function getsubmenu($submenu_id)
	{
		$this->db->where("submenu_id",$submenu_id);
		$menu = $this->db->get("system_submenu")->row_array();
		return $menu;	
	}
	public function subMenudataTable($menu_id)
	{
		$this->db->where("menu_id",$menu_id);
		$this->db->order_by("menu_sequent","ASC");
		$this->db->limit(1000);
		
		$menu = $this->db->get("system_submenu")->result_array();
		return $menu;	
	}
	public function show_sequent($sequent_id)
	{
		$this->db->select("menu_label");
		$this->db->where("menu_sequent <",$sequent_id);
		$this->db->limit(1);
		$this->db->order_by("menu_sequent","DESC");
		$seq = $this->db->get("system_menu")->row_array();
		if($seq){
			return "หลัง \"".$seq['menu_label']."\"";
		}else{
			return "ไม่ทราบแน่ชัด";
		}
	}
	public function get_menu_last_sequent()
	{
		$this->db->where("menu_sequent <",900);
		$this->db->limit(1);
		$this->db->order_by("menu_sequent","DESC");
		$seq = $this->db->get("system_menu")->row_array();
		$last = intval($seq['menu_sequent']);
		$last++;
		return $last;
	}
	public function get_submenu_last_sequent($menu_id)
	{
		$this->db->where("menu_sequent <",900);
		$this->db->where("menu_id",$menu_id);
		$this->db->limit(1);
		$this->db->order_by("menu_sequent","DESC");
		$seq = $this->db->get("system_submenu")->row_array();
		$last = intval($seq['menu_sequent']);
		$last++;
		return $last;
	}
	public function set_menu_sequent($menu_id,$sequent)
	{
		/*
$this->db->where("menu_id <>",$menu_id);
		$this->db->where("menu_sequent",$sequent);
		$has = $this->db->get("system_menu")->row_array();
		if($has){
			$this->db->where("menu_sequent >=",$sequent);
			$this->db->where("menu_sequent <",900);
			$menu = $this->db->get("system_menu")->result_array();
			$sequent_start = $sequent;
			foreach($menu as $row){
				$sequent_start++;
				$this->db->set("menu_sequent",$sequent_start);
			}
		}
*/
	}
	public function add_menu()
	{
		$menu_label=trim(strip_tags($this->input->post("menu_label")));
		$menu_icon=trim(strip_tags($this->input->post("menu_icon")));
		$menu_link=trim(strip_tags($this->input->post("menu_link")));
		$menu_link=str_replace(ADMIN_PATH, "", $menu_link);
		$menu_sequent=intval(trim(strip_tags($this->input->post("menu_sequent"))));
		$menu_key=md5(time() . microtime());
		$menu_sequent_initd = $this->get_menu_last_sequent();
		$this->db->set("menu_label",$menu_label);
		$this->db->set("menu_icon",$menu_icon);
		$this->db->set("menu_link",$menu_link);
		$this->db->set("menu_sequent",$menu_sequent_initd);
		$this->db->set("menu_key",$menu_key);
		$menu_id = $this->db->insert("system_menu");
		//$this->set_menu_sequent($menu_id,$menu_sequent);
	}
	public function add_submenu()
	{
		$menu_id=intval(trim(strip_tags($this->input->post("menu_id"))));
		$menu_label=trim(strip_tags($this->input->post("menu_label")));
		$menu_icon=trim(strip_tags($this->input->post("menu_icon")));
		$menu_link=trim(strip_tags($this->input->post("menu_link")));
		$menu_link=str_replace(ADMIN_PATH, "", $menu_link);
		$menu_sequent=intval(trim(strip_tags($this->input->post("menu_sequent"))));
		$menu_key=md5(time() . microtime());
		$menu_sequent_initd = $this->get_submenu_last_sequent($submenu_id);
		$this->db->set("menu_id",$menu_id);
		$this->db->set("menu_label",$menu_label);
		$this->db->set("menu_icon",$menu_icon);
		$this->db->set("menu_link",$menu_link);
		$this->db->set("menu_sequent",$menu_sequent_initd);
		$this->db->set("menu_key",$menu_key);
		$this->db->insert("system_submenu");
		//$this->set_menu_sequent($menu_id,$menu_sequent);
	}
	public function edit_menu()
	{
		
		$menu_id=intval(trim(strip_tags($this->input->post("menu_id"))));
		$menu_label=trim(strip_tags($this->input->post("menu_label")));
		$menu_icon=trim(strip_tags($this->input->post("menu_icon")));
		$menu_link=trim(strip_tags($this->input->post("menu_link")));
		$menu_link=str_replace(ADMIN_PATH, "", $menu_link);
		$menu_sequent=intval(trim(strip_tags($this->input->post("menu_sequent"))));
		$menu_key=md5(time() . microtime());
		if($menu_sequent < 0){
			$menu_sequent = $this->get_menu_last_sequent();
		}
		$this->db->set("menu_label",$menu_label);
		$this->db->set("menu_icon",$menu_icon);
		$this->db->set("menu_link",$menu_link);
		//$this->db->set("menu_sequent",$menu_sequent);
		//$this->db->set("menu_key",$menu_key);
		$this->db->where("menu_id",$menu_id);
		$this->db->limit(1);
		return $this->db->update("system_menu");
	}
	public function edit_submenu()
	{
		$submenu_id=intval(trim(strip_tags($this->input->post("submenu_id"))));
		$menu_id=intval(trim(strip_tags($this->input->post("menu_id"))));
		$menu_label=trim(strip_tags($this->input->post("menu_label")));
		$menu_icon=trim(strip_tags($this->input->post("menu_icon")));
		$menu_link=trim(strip_tags($this->input->post("menu_link")));
		$menu_link=str_replace(ADMIN_PATH, "", $menu_link);
		$menu_sequent=intval(trim(strip_tags($this->input->post("menu_sequent"))));
		$menu_key=md5(time() . microtime());
		if($menu_sequent < 0){
			$menu_sequent = $this->get_submenu_last_sequent($submenu_id);
		}
		$this->db->set("menu_label",$menu_label);
		$this->db->set("menu_icon",$menu_icon);
		$this->db->set("menu_link",$menu_link);
		//$this->db->set("menu_sequent",$menu_sequent);
		//$this->db->set("menu_key",$menu_key);
		//$this->db->where("menu_id",$menu_id);
		$this->db->where("submenu_id",$submenu_id);
		$this->db->limit(1);
		return $this->db->update("system_submenu");
		//exit($this->db->last_query());
	}
	function get_icons()
	{
		$pattern = '/\.(icon-(?:\w+(?:-)?)+):before\s*{\s*content:\s*"(.+)";\s+}/';
			$subject = file_get_contents(realpath('') . '/public/panel/assets/font-awesome-4.1.0/css/font-awesome.css');
			
			preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
			
			$icons = array();
			
			foreach($matches as $match){
			    $icons[$match[1]] = $match[2];
			}
			
			//$icons = var_export($icons, TRUE);
			//$icons = stripslashes($icons);
			return $icons;
	}
}