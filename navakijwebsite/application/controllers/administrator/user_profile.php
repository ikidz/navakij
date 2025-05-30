<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_profile extends CI_Controller {
	var $_data = array();
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/admin_model');	
		$this->admin_library->forceLogin();
	}
	public function index()
	{
		$this->admin_library->setTitle('ข้อมูลส่วนตัว','icon-building');
		$this->admin_library->setDetail("จัดการข้อมูลส่วนตัวของคุณ");
		$user_id = $this->admin_library->user_id();
		$this->db->where("user_id",$user_id);
		$this->db->where("user_status <>","delete");
		$this->db->limit(1);
		$this->_data['row']=$this->db->get("system_users")->row_array();
		if(!$this->_data['row']){
			$this->session->set_flashdata("message-warning","ไม่พบรายการที่คุณต้องการแก้ไฃ");
			admin_redirect("");
		}
		$this->admin_library->view("user_profile/viewprofile",$this->_data);
		$this->admin_library->output();
	}
	
	public function edit()
	{
		$user_id = $this->admin_library->user_id();
		$this->db->where("user_id",$user_id);
		$this->db->where("user_status <>","delete");
		$this->db->limit(1);
		$this->_data['row']=$this->db->get("system_users")->row_array();
		if(!$this->_data['row']){
			$this->session->set_flashdata("message-warning","ไม่พบรายการที่คุณต้องการแก้ไฃ");
			admin_redirect("user_profile/index");
		}
			
		$post_password = $this->input->post("password");
		$this->form_validation->set_rules("username","ชื่อผู้ใช้งาน","trim|required|min_length[4]|max_length[30]");
		if($post_password <> ""){
			$this->form_validation->set_rules("password","รหัสผ่าน","trim|required|min_length[4]|max_length[30]|matches[repassword]");
		}
		$this->form_validation->set_rules("user_fullname","ชื่อ-สกุล","trim|required");
		$this->form_validation->set_rules("user_email","อีเมลล์","trim|required|valid_email");
		$this->form_validation->set_rules("user_mobileno","โทรศัพท์มือถือ","trim|required|numeric");
		
		$this->form_validation->set_message("required","กรุณาระบุ%sด้วยค่ะ");
		$this->form_validation->set_message("min_length","กรุณาระบุ%sไม่น้อยกว่า %d ตัวอักษร");
		$this->form_validation->set_message("max_length","กรุณาระบุ%sไม่เกิน %d ตัวอักษร");
		$this->form_validation->set_message("matches","กรุณาระบุ%sให้ตรงกันด้วยค่ะ");
		$this->form_validation->set_message("valid_email","กรุณาระบุ%sให้ถูกต้องด้วยค่ะ");
		$this->form_validation->set_message("numeric","กรุณาระบุ%sให้ถูกต้องด้วยค่ะ สามารถระบุได้เพียงตัวเลข 0-9 เท่านั้น");
		
		if($this->form_validation->run()===false){
		
			
			$this->admin_library->view("user_profile/editform",$this->_data);
			$this->admin_library->output();
			
		}else{
			if($this->upload_avatar()===false){
				$this->admin_library->view("user_profile/editform",$this->_data);
				$this->admin_library->output();
				return false;
			}
			
			$this->db->set("username",$this->input->post("username"));
			if($post_password <> ""){
				$this->db->set("password",md5($this->input->post("password")));
			}
			$this->db->set("user_fullname",$this->input->post("user_fullname"));
			$this->db->set("user_email",$this->input->post("user_email"));
			$this->db->set("user_mobileno",$this->input->post("user_mobileno"));
			$this->db->set("user_updateby",$this->admin_library->user_id());
			$this->db->set("user_updateip",$this->input->ip_address());
			$this->db->set("user_updatedate",date("Y-m-d H:i:s"));
			$this->db->where("user_id",$user_id);
			$this->db->limit(1);
			$this->db->update("system_users");
			$this->send_update_email($user_id,$this->input->post("password"));
			$this->session->set_flashdata("message-success","บันทึกการแก้ไขผู้ใช้งานเรียบร้อยแล้ว");
			$this->session->set_flashdata("message-info","โปรดทราบว่าการปรับปรุงข้อมูลผู้ใช้งานนั้น จะมีผลในทันทีโดยไม่จำเป็นต้องออกจากระบบ");
			admin_redirect("user_profile/index");
		}
	}
	function upload_avatar()
	{
		$this->load->library("upload");
		if(@$_FILES['avatar_file']['tmp_name'] !== ""){
		
			$config=array();
			$config['upload_path'] = './public/uploads/user_admin/';
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size']	= '1024';
			$config['max_width']  = '1024';
			$config['max_height']  = '1024';
			$config['encrypt_name']  = true;
			$this->upload->initialize($config);
			if ($this->upload->do_upload("avatar_file")===true){
				$data = $this->upload->data();
				$this->db->set("user_avatar",$data['file_name']);
				return true;
			}else{
				$this->_data['upload_error']=$this->upload->display_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>');
				return false;
			}
		}else{
			return true;
		}
	}
	function send_update_email($user_id,$password='')
	{
		$this->db->where("user_id",$user_id);
		$this->db->where("user_status <>","delete");
		$this->db->limit(1);
		$email_data=$this->db->get("system_users")->row_array();
		$email_data['password']=$password;
		$email_data['company']=$this->admin_library->getCompanyName();
		$email_body = $this->load->view("administrator/views/user_profile/email_update",$email_data,true);
		$this->load->library("email");
		$email = $this->config->item("email");
		$this->email->initialize($email['settings']);
		$this->email->from($email['sender_email'], $email['sender_name']);
		$this->email->to($email_data['user_email']);
		$this->email->subject('แจ้งเตือนข้อมูลการเข้าใช้งานระบบจัดการ ' . $email_data['company'] . 'ได้รับการปรับปรุง');
		$this->email->set_mailtype("html");
		$this->email->message($email_body);		
		$this->email->send();
	}
}