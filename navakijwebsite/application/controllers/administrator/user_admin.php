<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_admin extends CI_Controller {
	var $_data=array();
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/admin_model');	
		$this->admin_library->forceLogin();
		$this->admin_model->set_menu_key('0914413975b88c951f08f2dc073a5079');
	}
	public function index()
	{
		
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_library->setTitle('Users Admin','icon-user');
		$this->admin_library->setDetail("ผู้ใช้งานระบบ");
		
		
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("ผู้ใช้งานระบบ",'icon-group');
		
		$this->admin_model->set_top_button("เพิ่มผู้ใช้งานใหม่","user_admin/addnew",'icon-plus','btn-success','w');
		$this->admin_model->set_top_button("สำรองข้อมูล","user_admin/backup",'icon-download','btn-primary','s');
		
		//List View
		//ให้ใช้ Check All ได้
		//$this->admin_model->set_checkall(true);
		//$this->admin_model->set_checkall_dropdown("เปิดใช้งานรายการที่เลือก",'user_group/checkall_active','w');
		//$this->admin_model->set_checkall_dropdown("ระงับรายการที่เลือก",'user_group/checkall_suspend','w');
		//$this->admin_model->set_checkall_dropdown("ลบรายการที่เลือก",'user_admin/checkall_delete','d');
		$this->db->select("system_users.*,system_group.group_name");
		$this->db->join("system_group","system_group.group_id=system_users.user_group");
		$this->db->where("system_users.user_status <>","delete");
		$this->db->order_by("system_users.username","ASC");
		$this->admin_model->set_datatable($this->db->get("system_users"));
		
		$this->admin_model->set_column("username","ชื่อผู้ใช้",0,'icon-unlock');
		$this->admin_model->set_column("user_fullname","ชื่อ-สกุล",0,'icon-quote-left','hidden-phone');
 		$this->admin_model->set_column("user_email","อีเมลล์",0,'icon-envelope','hidden-phone');
 		$this->admin_model->set_column("group_name","กลุ่มผู้ใช้",0,'icon-group','hidden-phone');
 		$this->admin_model->set_column("user_status","สถานะ",0,'icon-check','hidden-phone');
 		$this->admin_model->set_column_callback("user_status","user_status_callback");
		//$this->admin_model->set_action_button("ข้อมูลกลุ่ม","user_group/view/[group_id]",'icon-building','btn-success','r');
		$this->admin_model->set_action_button("แก้ไขผู้ใช้งาน","user_admin/edit/[user_id]",'icon-edit','btn-info','w');
		$this->admin_model->set_action_button("ลบผู้ใช้งาน","user_admin/delete/[user_id]",'icon-trash','btn-danger','d');
		
		//$this->admin_model->set_pagination("user_group/index",100,10,4);
		$this->admin_model->make_list();
		
		
		$this->admin_library->output();
	}
	
	public function addnew()
	{
		$this->admin_model->initd($this);
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->form_validation->set_rules("username","ชื่อผู้ใช้งาน","trim|required|min_length[4]|max_length[30]|unique[system_users.username]");
		$this->form_validation->set_rules("password","รหัสผ่าน","trim|required|min_length[4]|max_length[30]|matches[repassword]");
		$this->form_validation->set_rules("user_fullname","ชื่อ-สกุล","trim|required");
		$this->form_validation->set_rules("user_email","อีเมลล์","trim|required|valid_email");
		$this->form_validation->set_rules("user_mobileno","โทรศัพท์มือถือ","trim|required|numeric");
		$this->form_validation->set_rules("user_group","กลุ่มผู้ใช้งาน","trim|required");
		$this->form_validation->set_rules("user_status","สถานะผู้ใช้","trim|required");
		
		$this->form_validation->set_message("required","กรุณาระบุ%sด้วยค่ะ");
		$this->form_validation->set_message("min_length","กรุณาระบุ%sไม่น้อยกว่า %d ตัวอักษร");
		$this->form_validation->set_message("max_length","กรุณาระบุ%sไม่เกิน %d ตัวอักษร");
		$this->form_validation->set_message("matches","กรุณาระบุ%sให้ตรงกันด้วยค่ะ");
		$this->form_validation->set_message("valid_email","กรุณาระบุ%sให้ถูกต้องด้วยค่ะ");
		$this->form_validation->set_message("numeric","กรุณาระบุ%sให้ถูกต้องด้วยค่ะ สามารถระบุได้เพียงตัวเลข 0-9 เท่านั้น");
		
		if($this->form_validation->run()===false){
			$this->admin_library->view("user_admin/addform",$this->_data);
			$this->admin_library->output();
			
		}else{
			$this->db->set("username",$this->input->post("username"));
			$this->db->set("password",md5($this->input->post("password")));
			$this->db->set("user_fullname",$this->input->post("user_fullname"));
			$this->db->set("user_email",$this->input->post("user_email"));
			$this->db->set("user_mobileno",$this->input->post("user_mobileno"));
			$this->db->set("user_group",$this->input->post("user_group"));
			$this->db->set("user_status",$this->input->post("user_status"));
			$this->db->set("user_joinby",$this->admin_library->user_id());
			$this->db->set("user_joinip",$this->input->ip_address());
			$this->db->set("user_joindate",date("Y-m-d H:i:s"));
			$this->db->set("user_updateby",$this->admin_library->user_id());
			$this->db->set("user_updateip",$this->input->ip_address());
			$this->db->set("user_updatedate",date("Y-m-d H:i:s"));
			$this->db->insert("system_users");
			$user_id = $this->db->insert_id();
			$this->send_newuser_email($user_id,$this->input->post("password"));
			$this->session->set_flashdata("message-success","บันทึกผู้ใช้งานเรียบร้อยแล้ว");
			$this->session->set_flashdata("message-info","ผู้ใช้งานจะได้รับอีเมลล์ 1 ฉบับที่ระบุข้อมูลการเข้าใช้งาน โดยผู้ใช้งานจะสามารถใช้งานได้ในทันที");
			admin_redirect("user_admin/index");
		}
		
	}
	
	public function edit($user_id)
	{
		$this->admin_model->initd($this);
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		$post_password = $this->input->post("password");
		$this->form_validation->set_rules("username","ชื่อผู้ใช้งาน","trim|required|min_length[4]|max_length[30]");
		if($post_password <> ""){
			$this->form_validation->set_rules("password","รหัสผ่าน","trim|required|min_length[4]|max_length[30]|matches[repassword]");
		}
		$this->form_validation->set_rules("user_fullname","ชื่อ-สกุล","trim|required");
		$this->form_validation->set_rules("user_email","อีเมลล์","trim|required|valid_email");
		$this->form_validation->set_rules("user_mobileno","โทรศัพท์มือถือ","trim|required|numeric");
		$this->form_validation->set_rules("user_group","กลุ่มผู้ใช้งาน","trim|required");
		$this->form_validation->set_rules("user_status","สถานะผู้ใช้","trim|required");
		
		$this->form_validation->set_message("required","กรุณาระบุ%sด้วยค่ะ");
		$this->form_validation->set_message("min_length","กรุณาระบุ%sไม่น้อยกว่า %d ตัวอักษร");
		$this->form_validation->set_message("max_length","กรุณาระบุ%sไม่เกิน %d ตัวอักษร");
		$this->form_validation->set_message("matches","กรุณาระบุ%sให้ตรงกันด้วยค่ะ");
		$this->form_validation->set_message("valid_email","กรุณาระบุ%sให้ถูกต้องด้วยค่ะ");
		$this->form_validation->set_message("numeric","กรุณาระบุ%sให้ถูกต้องด้วยค่ะ สามารถระบุได้เพียงตัวเลข 0-9 เท่านั้น");
		
		if($this->form_validation->run()===false){
		
			$this->db->where("user_id",$user_id);
			$this->db->where("user_status <>","delete");
			$this->db->limit(1);
			$this->_data['row']=$this->db->get("system_users")->row_array();
			if(!$this->_data['row']){
				$this->session->set_flashdata("message-warning","ไม่พบรายการที่คุณต้องการแก้ไฃ");
				admin_redirect("user_admin/index");
			}
			$this->admin_library->view("user_admin/editform",$this->_data);
			$this->admin_library->output();
			
		}else{
			$this->db->set("username",$this->input->post("username"));
			if($post_password <> ""){
				$this->db->set("password",md5($this->input->post("password")));
			}
			$this->db->set("user_fullname",$this->input->post("user_fullname"));
			$this->db->set("user_email",$this->input->post("user_email"));
			$this->db->set("user_mobileno",$this->input->post("user_mobileno"));
			$this->db->set("user_group",$this->input->post("user_group"));
			$this->db->set("user_status",$this->input->post("user_status"));
			$this->db->set("user_updateby",$this->admin_library->user_id());
			$this->db->set("user_updateip",$this->input->ip_address());
			$this->db->set("user_updatedate",date("Y-m-d H:i:s"));
			$this->db->where("user_id",$user_id);
			$this->db->limit(1);
			$this->db->update("system_users");
			if($this->input->post("user_status")=="active"){
				$this->send_update_email($user_id,$this->input->post("password"));
			}else{
				$this->send_suspend_email($user_id);
			}
			
			$this->session->set_flashdata("message-success","บันทึกการแก้ไขผู้ใช้งานเรียบร้อยแล้ว");
			$this->session->set_flashdata("message-info","โปรดทราบว่าการปรับปรุงข้อมูลผู้ใช้งานนั้น จะมีผลในทันทีโดยไม่จำเป็นต้องออกจากระบบ");
			admin_redirect("user_admin/index");
		}
		
	}
	
	public function delete($user_id)
	{
		if(!$this->admin_model->check_permision("d")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		if($this->admin_library->user_id() == $user_id){
			$this->session->set_flashdata("message-warning","ไม่สามารถลบตัวคุณเองได้");
			admin_redirect("user_admin/index");
		}
		$this->send_delete_email($user_id);
		$this->admin_library->delete_account($user_id);
		$this->session->set_flashdata("message-success","ลบผุ้ใช้งานที่เลือกเรียบร้อยแล้ว");
		$this->session->set_flashdata("message-info","โปรดทราบว่าการลบผู้ใช้งานนั้น จะมีผลในทันดีโดยไม่จำเป็นต้องออกจากระบบ");
		admin_redirect("user_admin/index");
	}
	public function user_status_callback($text)
	{
		$text = ($text=="active")?'<i class="icon-unlock color_gold"></i> เปิดใช้งาน':'<i class="icon-lock color_lavared"></i> ระงับสิทธิ์';
		return $text;
	}
	public function backup()
	{
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$backup_file = 'useradmin_'.date("YmdHis").'.gz';
		$prefs = array(
                'tables'      => array('system_users'),  // Array of tables to backup.
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
	private function send_newuser_email($user_id,$password)
	{
		$this->db->where("user_id",$user_id);
		$this->db->where("user_status <>","delete");
		$this->db->limit(1);
		$email_data=$this->db->get("system_users")->row_array();
		$email_data['password']=$password;
		$email_data['company']=$this->admin_library->getCompanyName();
		$email_body = $this->load->view("administrator/views/user_admin/email_create",$email_data,true);
		
		$this->load->library("email");
		$email = $this->config->item("email");
		$this->email->initialize($email['settings']);
		$this->email->from($email['sender_email'], $email['sender_name']);
		$this->email->to($email_data['user_email']);
		$this->email->subject('ข้อมูลการเข้าสู่ระบบจัดการ ' . $email_data['company']);
		$this->email->set_mailtype("html");
		$this->email->message($email_body);		
		$this->email->send();
	}
	function send_update_email($user_id,$password='')
	{
		$this->db->where("user_id",$user_id);
		$this->db->where("user_status <>","delete");
		$this->db->limit(1);
		$email_data=$this->db->get("system_users")->row_array();
		$email_data['password']=$password;
		$email_data['company']=$this->admin_library->getCompanyName();
		$email_body = $this->load->view("administrator/views/user_admin/email_update",$email_data,true);
		$this->load->library("email");
		$email = $this->config->item("email");
		$this->email->initialize($email['settings']);
		$this->email->from($email['sender_email'], $email['sender_name']);
		$this->email->to($email_data['user_email']);
		$this->email->subject('แจ้งเตือนข้อมูลการเข้าใช้งานระบบจัดการ ' . $email_data['company'] . ' ได้รับการปรับปรุง');
		$this->email->set_mailtype("html");
		$this->email->message($email_body);		
		$this->email->send();
	}
	function send_suspend_email($user_id)
	{
		$this->db->where("user_id",$user_id);
		$this->db->where("user_status <>","delete");
		$this->db->limit(1);
		$email_data=$this->db->get("system_users")->row_array();
		$email_data['company']=$this->admin_library->getCompanyName();
		$email_body = $this->load->view("administrator/views/user_admin/email_suspend",$email_data,true);
		$this->load->library("email");
		$email = $this->config->item("email");
		$this->email->initialize($email['settings']);
		$this->email->from($email['sender_email'], $email['sender_name']);
		$this->email->to($email_data['user_email']);
		$this->email->subject('แจ้งเตือนข้อมูลการเข้าใช้งานระบบจัดการ ' . $email_data['company'] . ' ถูกระงับสิทธิ์');
		$this->email->set_mailtype("html");
		$this->email->message($email_body);		
		$this->email->send();
	}
	function send_delete_email($user_id)
	{
		$this->db->where("user_id",$user_id);
		$this->db->where("user_status <>","delete");
		$this->db->limit(1);
		$email_data=$this->db->get("system_users")->row_array();
		$email_data['company']=$this->admin_library->getCompanyName();
		$email_body = $this->load->view("administrator/views/user_admin/email_delete",$email_data,true);
		$this->load->library("email");
		$email = $this->config->item("email");
		$this->email->initialize($email['settings']);
		$this->email->from($email['sender_email'], $email['sender_name']);
		$this->email->to($email_data['user_email']);
		$this->email->subject('แจ้งเตือนข้อมูลการเข้าใช้งานระบบจัดการ ' . $email_data['company'] . ' ของคุณถูกยกเลิก');
		$this->email->set_mailtype("html");
		$this->email->message($email_body);		
		$this->email->send();
	}
}