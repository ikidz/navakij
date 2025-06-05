<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
File Name 	: menu_manager.php
Controller	: Menu_manager
Create By 	: Jarak Kritkiattisak
Create Date 	: 7/5/2557 BE
Project 	: iAon Project
Version 		: 1.0
*/
class Menu_manager extends CI_Controller {
	var $_data=array();
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/admin_model');
		$this->load->model('administrator/menu_model');
		$this->admin_library->forceLogin();
		$this->admin_model->set_menu_key('e5d42c8b4fde26dd387ea108252d8e4c');
	}
	public function index()
	{
		if(!$this->admin_model->check_permision("r")){
			$this->session->set_flashdata("message-warning","สิทธิการเข้าถึงของคุณไม่ถูกต้อง คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลส่วนนี้.");
			admin_redirect("dashboard");
		}
		$this->admin_model->initd($this);
		$this->admin_model->set_title("Menu Manager","icon-bars");
		
		$this->admin_model->set_top_button("เพิ่มเมนูใหม่","menu_manager/addmenu",'icon-plus','btn-success','w');
		$this->admin_model->set_top_button("สำรองข้อมูล","menu_manager/backup",'icon-download','btn-primary','s');
		
		$this->admin_model->set_datatable($this->menu_model->dataTable());
		$this->admin_model->set_column("menu_label","ชื่อเมนู",0,"icon-code");
		$this->admin_model->set_column("menu_link","เชื่อมโยงไปยัง",0,"icon-external-link",'hidden-phone');
		$this->admin_model->set_column("menu_sequent","ลำดับ",0,"icon-sort-amount-asc",'hidden-phone');
		$this->admin_model->set_column("menu_key","Key",0,"icon-key",'hidden-phone');
		$this->admin_model->set_column_callback("menu_label","add_icon");
		$this->admin_model->set_column_callback("menu_link","make_url");
		$this->admin_model->set_column_callback("menu_sequent","make_sequent");
		$this->admin_model->set_action_button("แก้ไข","menu_manager/edit_menu/[menu_id]",'icon-edit','btn-info','w');
		$this->admin_model->set_action_button("เมนูย่อย","menu_manager/submenu/[menu_id]",'icon-gears','btn-info','w');
		$this->admin_model->set_action_button("ลบ","menu_manager/delete_menu/[menu_id]",'icon-trash','btn-danger','d');
		$this->admin_model->make_list();
		$this->admin_library->output();
	}
	public function submenu($menu_id)
	{
		if(!$this->admin_model->check_permision("r")){
			$this->session->set_flashdata("message-warning","สิทธิการเข้าถึงของคุณไม่ถูกต้อง คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลส่วนนี้.");
			admin_redirect("dashboard");
		}
		$this->admin_model->initd($this);
		$this->admin_model->set_title("Menu Manager","icon-bars");
		$this->admin_library->add_breadcrumb("จัดการเมนู","menu_manager/index","icon-bars");
		$this->admin_library->add_breadcrumb("จัดการเมนูย่อย","menu_manager/submenu/".$menu_id,"icon-bars");
		
		$this->admin_model->set_top_button("เพิ่มเมนูย่อยใหม่","menu_manager/addsubmenu/".$menu_id,'icon-plus','btn-success','w');
		$this->admin_model->set_top_button("สำรองข้อมูล","menu_manager/backup",'icon-download','btn-primary','s');
		
		$this->admin_model->set_datatable($this->menu_model->subMenudataTable($menu_id));
		$this->admin_model->set_column("menu_label","ชื่อเมนู",0,"icon-code");
		$this->admin_model->set_column("menu_link","เชื่อมโยงไปยัง",0,"icon-external-link",'hidden-phone');
		$this->admin_model->set_column("menu_sequent","ลำดับ",0,"icon-sort-amount-asc",'hidden-phone');
		$this->admin_model->set_column("menu_key","Key",0,"icon-key",'hidden-phone');
		$this->admin_model->set_column_callback("menu_label","add_icon");
		$this->admin_model->set_column_callback("menu_link","make_url");
		$this->admin_model->set_column_callback("menu_sequent","make_sequent");
		$this->admin_model->set_action_button("แก้ไข","menu_manager/edit_submenu/[menu_id]/[submenu_id]",'icon-edit','btn-info','w');
		$this->admin_model->set_action_button("ลบ","menu_manager/delete_submenu/[menu_id]/[submenu_id]",'icon-trash','btn-danger','d');
		$this->admin_model->make_list();
		$this->admin_library->output();
	}
	public function add_icon($text,$row)
	{
		return '<i class="'.$row['menu_icon'].'"></i> '.$text;
	}
	public function make_url($text,$row)
	{
		return "<a href=\"".admin_url($text)."\">".$text."</a>";		
	}
	public function make_sequent($text,$row)	
	{
		if($text==0){
			return "บนสุดเสมอ";
		}
		$text = $this->menu_model->show_sequent($text);
		return $text;		
	}
	public function addmenu()
	{
		if(!$this->admin_model->check_permision("w")){
			$this->session->set_flashdata("message-warning","สิทธิการเข้าถึงของคุณไม่ถูกต้อง คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลส่วนนี้.");
			admin_redirect("dashboard");
		}
		$this->form_validation->set_rules("menu_label","ชื่อเมนู","trim|required|max_length[30]");
		if($this->form_validation->run()===false){
			$this->load->library('administrator/controllerlist');
			$this->admin_library->add_breadcrumb("เพิ่มเมนูใหม่","menu_manager/addmenu","icon-plus");
			$this->admin_library->view("menu_manager/addmenu");
			$this->admin_library->output();
		}else{
			$this->menu_model->add_menu();
			$this->session->set_flashdata("message-success","บันทึกเรียบร้อยแล้ว");
			admin_redirect("menu_manager/index");
		}
			
	}
	public function addsubmenu($menu_id)
	{
		if(!$this->admin_model->check_permision("w")){
			$this->session->set_flashdata("message-warning","สิทธิการเข้าถึงของคุณไม่ถูกต้อง คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลส่วนนี้.");
			admin_redirect("dashboard");
		}
		$this->form_validation->set_rules("menu_label","ชื่อเมนู","trim|required|max_length[30]");
		if($this->form_validation->run()===false){
			$this->_data['menu_id']=$menu_id;
			$this->load->library('administrator/controllerlist');
			$this->admin_library->add_breadcrumb("เพิ่มเมนูใหม่","menu_manager/addmenu","icon-plus");
			$this->admin_library->view("menu_manager/addsubmenu");
			$this->admin_library->output();
		}else{
			$this->menu_model->add_submenu();
			$this->session->set_flashdata("message-success","บันทึกเรียบร้อยแล้ว");
			admin_redirect("menu_manager/submenu/".$menu_id);
		}
			
	}
	public function edit_menu($menu_id)
	{
		if(!$this->admin_model->check_permision("w")){
			$this->session->set_flashdata("message-warning","สิทธิการเข้าถึงของคุณไม่ถูกต้อง คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลส่วนนี้.");
			admin_redirect("dashboard");
		}
		$this->form_validation->set_rules("menu_label","ชื่อเมนู","trim|required|max_length[30]");
		if($this->form_validation->run()===false){
			$this->_data['row']=$this->menu_model->getmenu($menu_id);
			$this->load->library('administrator/controllerlist');
			$this->admin_library->add_breadcrumb("เพิ่มเมนูใหม่","menu_manager/addmenu","icon-plus");
			$this->admin_library->view("menu_manager/editmenu");
			$this->admin_library->output();
		}else{
			$this->menu_model->edit_menu();
			$this->session->set_flashdata("message-success","บันทึกเรียบร้อยแล้ว");
			admin_redirect("menu_manager/index");
		}
			
	}
	public function edit_submenu($menu_id,$submenu_id)
	{
		if(!$this->admin_model->check_permision("w")){
			$this->session->set_flashdata("message-warning","สิทธิการเข้าถึงของคุณไม่ถูกต้อง คุณไม่ได้รับสิทธิ์ให้เข้าถึงข้อมูลส่วนนี้.");
			admin_redirect("dashboard");
		}
		$this->form_validation->set_rules("menu_label","ชื่อเมนู","trim|required|max_length[30]");
		if($this->form_validation->run()===false){
			$this->_data['row']=$this->menu_model->getsubmenu($submenu_id);
			$this->load->library('administrator/controllerlist');
			$this->admin_library->add_breadcrumb("แก้ไขเมนูใหม่","menu_manager/addmenu","icon-plus");
			$this->admin_library->view("menu_manager/editsubmenu");
			$this->admin_library->output();
		}else{
			$this->menu_model->edit_submenu();
			$this->session->set_flashdata("message-success","บันทึกเรียบร้อยแล้ว");
			admin_redirect("menu_manager/submenu/".$menu_id);
		}
			
	}
	public function delete_menu($menu_id)
	{
		$this->db->where("menu_id",$menu_id);
		$this->db->limit(1);
		$this->db->delete("system_menu");
		$this->session->set_flashdata("message-success","ลบเรียบร้อยแล้ว");
		admin_redirect("menu_manager/index");
	}
	public function delete_submenu($menu_id,$submenu_id)
	{
		$this->db->where("submenu_id",$submenu_id);
		$this->db->limit(1);
		$this->db->delete("system_submenu");
		$this->session->set_flashdata("message-success","ลบเรียบร้อยแล้ว");
		admin_redirect("menu_manager/submenu/".$menu_id);
	}
	public function backup()
	{
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$backup_file = 'menu_'.date("Y-m-d_H-i-s").'.gz';
		$prefs = array(
                'tables'      => array('system_menu','system_submenu'),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'gzip',             // gzip, zip, txt
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
		$backup =& $this->dbutil->backup($prefs); 
		
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		force_download($backup_file, $backup);
	}
	
}