<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_group extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/admin_model');	
		$this->admin_library->forceLogin();
	}
	public function index()
	{
		$this->admin_model->set_menu_key('5e975624c5a4e4cb9fddde6da3bda19f');
		$this->_data['success_message'] = $this->session->flashdata('success_message');
		$this->admin_library->setTitle('Users Group','icon-group');
		$this->admin_library->setDetail("จัดการกลุ่มผู้ใช้งาน");
		
		
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("กลุ่มผู้ใช้งาน",'icon-group');
		
		$this->admin_model->set_top_button("เพิ่มกลุ่มผู้ใช้งานใหม่","user_group/addnew",'icon-plus','btn-success','w');
		$this->admin_model->set_top_button("สำรองข้อมูล","user_group/backup",'icon-download','btn-primary','s');
		
		//List View
		//ให้ใช้ Check All ได้
		//$this->admin_model->set_checkall(true);
		//$this->admin_model->set_checkall_dropdown("เปิดใช้งานรายการที่เลือก",'user_group/checkall_active','w');
		//$this->admin_model->set_checkall_dropdown("ระงับรายการที่เลือก",'user_group/checkall_suspend','w');
		//$this->admin_model->set_checkall_dropdown("ลบรายการที่เลือก",'user_group/checkall_delete','d');
		
		$this->admin_model->set_datatable($this->admin_library->getAllGroup());
		
		$this->admin_model->set_column("group_name","ชื่อกลุ่ม",0,'icon-group');
		$this->admin_model->set_column("group_superadmin","ใช้สิทธิ์สูงสุด",0,'icon-list-ol','hidden-phone');
 		$this->admin_model->set_column_callback("group_superadmin","group_superadmin_callback");
 		
		//$this->admin_model->set_action_button("ข้อมูลกลุ่ม","user_group/view/[group_id]",'icon-building','btn-success','r');
		$this->admin_model->set_action_button("แก้ไขกลุ่ม","user_group/edit/[group_id]",'icon-edit','btn-info','w');
		$this->admin_model->set_action_button("ลบกลุ่ม","user_group/delete/[group_id]",'icon-trash','btn-danger','d');
		
		//$this->admin_model->set_pagination("user_group/index",100,10,4);
		$this->admin_model->make_list();
		
		
		$this->admin_library->output();
	}
	public function addnew()
	{
		$group_id = 0;
		$this->admin_model->initd($this);
		$this->admin_model->set_menu_key('5e975624c5a4e4cb9fddde6da3bda19f');
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		$this->form_validation->set_rules("group_name","ชื่อกลุ่มผู้ใช้งาน","trim|required");
		$this->form_validation->set_rules("company_id","บริษัทสังกัด","trim|required");
		$this->form_validation->set_message("required","กรุณาระบุ%sให้ถูกต้องด้วยค่ะ");
		if($this->form_validation->run() === false){
			$this->admin_library->view("user_group/addgroup");
			$this->admin_library->output();
		}else{
			$super = ($this->input->post("group_superadmin")=="yes")?"yes":"no";
			$group_id = $this->admin_library->addGroup($this->input->post("group_name"),$super,$this->input->post("company_id"));
			$menu_array = $this->input->post("menu");
			$result_menu_array = array();
			foreach($this->admin_library->getAllMenu() as $menu_row){
				$result_menu_array[$menu_row['id']][0] = ($menu_array[$menu_row['id']][0]=="yes")?true:false;
				foreach($menu_row['submenu_entry'] as $submenu_row){
					$result_menu_array[$menu_row['id']][$submenu_row['id']] = ($menu_array[$menu_row['id']][$submenu_row['id']]=="yes")?true:false;
				}
			}
			
			$perm_array = $this->input->post("perm");
			$result_perm_array = array();
			foreach($this->admin_library->getAllMenu() as $menu_row){
				$result_perm_array[$menu_row['key']]['read'] = (@$perm_array[$menu_row['key']]['r']=="yes")?'true':'false';
				$result_perm_array[$menu_row['key']]['write'] = (@$perm_array[$menu_row['key']]['w']=="yes")?'true':'false';
				$result_perm_array[$menu_row['key']]['delete'] = (@$perm_array[$menu_row['key']]['d']=="yes")?'true':'false';
				$this->admin_model->update_permision($group_id,$menu_row['key'],$result_perm_array[$menu_row['key']]);
				foreach($menu_row['submenu_entry'] as $submenu_row){
					$result_perm_array[$submenu_row['key']]['read'] = (@$perm_array[$submenu_row['key']]['r']=="yes")?'true':'false';
					$result_perm_array[$submenu_row['key']]['write'] = (@$perm_array[$submenu_row['key']]['w']=="yes")?'true':'false';
					$result_perm_array[$submenu_row['key']]['delete'] = (@$perm_array[$submenu_row['key']]['d']=="yes")?'true':'false';
					$this->admin_model->update_permision($group_id,$submenu_row['key'],$result_perm_array[$submenu_row['key']]);
				}
			}
			$this->session->set_flashdata("message-success","เพิ่มกลุ่มผุ้ใช้งานเรียบร้อยแล้ว");
			$this->session->set_flashdata("message-info","โปรดทราบว่าการปรับปรุงกลุ่มผู้ใช้งานนั้น จะส่งผลกับผู้ใช้งานที่อยู่ภายใต้กลุ่มนี้ทั้งหมด การตั้งค่าสิทธิ์การเข้าถึงทั้งหมดจะมีผลโดยทันที โดยผู้ใช้งานภายใต้กลุ่มไม่ต้องเข้าสู่ระบบใหม่");
			admin_redirect("user_group/index");
		}
		
	}
	
	public function edit($group_id)
	{
		$this->admin_model->initd($this);
		$this->admin_model->set_menu_key('5e975624c5a4e4cb9fddde6da3bda19f');
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		$this->form_validation->set_rules("group_name","ชื่อกลุ่มผู้ใช้งาน","trim|required");
		$this->form_validation->set_rules("company_id","บริษัทสังกัด","trim|required");
		$this->form_validation->set_message("required","กรุณาระบุ%sให้ถูกต้องด้วยค่ะ");
		if($this->form_validation->run() === false){
			$this->_data['row'] = $this->admin_library->getGroupDetail($group_id);
			$this->admin_library->view("user_group/editgroup",$this->_data);
			$this->admin_library->output();
		}else{
			$super = ($this->input->post("group_superadmin")=="yes")?"yes":"no";
			$this->admin_library->updateGroup($group_id,$this->input->post("group_name"),$super,$this->input->post("company_id"));
			$menu_array = $this->input->post("menu");
			$result_menu_array = array();
			foreach($this->admin_library->getAllMenu() as $menu_row){
				$result_menu_array[$menu_row['id']][0] = ($menu_array[$menu_row['id']][0]=="yes")?true:false;
				foreach($menu_row['submenu_entry'] as $submenu_row){
					$result_menu_array[$menu_row['id']][$submenu_row['id']] = ($menu_array[$menu_row['id']][$submenu_row['id']]=="yes")?true:false;
				}
			}
			
			$perm_array = $this->input->post("perm");
			$result_perm_array = array();
			foreach($this->admin_library->getAllMenu() as $menu_row){
				$result_perm_array[$menu_row['key']]['read'] = (@$perm_array[$menu_row['key']]['r']=="yes")?'true':'false';
				$result_perm_array[$menu_row['key']]['write'] = (@$perm_array[$menu_row['key']]['w']=="yes")?'true':'false';
				$result_perm_array[$menu_row['key']]['delete'] = (@$perm_array[$menu_row['key']]['d']=="yes")?'true':'false';
				$this->admin_model->update_permision($group_id,$menu_row['key'],$result_perm_array[$menu_row['key']]);
				foreach($menu_row['submenu_entry'] as $submenu_row){
					$result_perm_array[$submenu_row['key']]['read'] = (@$perm_array[$submenu_row['key']]['r']=="yes")?'true':'false';
					$result_perm_array[$submenu_row['key']]['write'] = (@$perm_array[$submenu_row['key']]['w']=="yes")?'true':'false';
					$result_perm_array[$submenu_row['key']]['delete'] = (@$perm_array[$submenu_row['key']]['d']=="yes")?'true':'false';
					$this->admin_model->update_permision($group_id,$submenu_row['key'],$result_perm_array[$submenu_row['key']]);
				}
			}
			$this->session->set_flashdata("message-success","ปรับปรุงกลุ่มผุ้ใช้งานเรียบร้อยแล้ว");
			$this->session->set_flashdata("message-info","โปรดทราบว่าการปรับปรุงกลุ่มผู้ใช้งานนั้น จะส่งผลกับผู้ใช้งานที่อยู่ภายใต้กลุ่มนี้ทั้งหมด การตั้งค่าสิทธิ์การเข้าถึงทั้งหมดจะมีผลโดยทันที โดยผู้ใช้งานภายใต้กลุ่มไม่ต้องเข้าสู่ระบบใหม่");
			admin_redirect("user_group/index");
		}
		
	}
	
	
	public function delete($group_id)
	{
		$this->admin_library->deleteGroup($group_id);
		$this->session->set_flashdata("message-success","ลบกลุ่มผุ้ใช้งานที่เลือกเรียบร้อยแล้ว");
		$this->session->set_flashdata("message-info","โปรดทราบว่าการลบกลุ่มผู้ใช้งานนั้น จะส่งผลกับผู้ใช้งานที่อยู่ภายใต้กลุ่มนี้ทั้งหมด รวมทั้งการตั้งค่าสิทธิ์การเข้าถึงทั้งหมดจะถูกยกเลิกตามไปด้วย");
		admin_redirect("user_group/index");
	}
	public function group_superadmin_callback($text)
	{
		$text = ($text=="yes")?"สิทธิ์สูงสุด":"ตั้งค่าด้วยตนเอง";
		return $text;
	}
	public function backup()
	{
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$backup_file = 'usergroup_'.date("YmdHis").'.gz';
		$prefs = array(
                'tables'      => array('system_group', 'system_usergroup_permision'),  // Array of tables to backup.
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