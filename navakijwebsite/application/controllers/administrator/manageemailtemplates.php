<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class ManageemailTemplates extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageemailtemplates/manageemailtemplatesmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1e1188604ececddcc32218f8f72a29ad');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการรับสมัครงาน",'icon-list-alt');
	}

	public function template($type='applicant'){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		if( $type == 'applicant' ){
            $menu_key = '47d87779a5ae0689b90d4f6afe13d230';
			$page_title = 'เทมเพลตสำหรับผู้สมัคร';
		}else{
            $menu_key = '3a081eef4aa9a99b7c25cf22068b477f';
			$page_title = 'เทมเพลตสำหรับผู้ดูแลระบบ';
		}
        $this->admin_model->set_menu_key($menu_key);
		$this->admin_model->set_detail( $page_title );
		
		$this->form_validation->set_rules('email_subject','หัวข้ออีเมล','trim|required');
		$this->form_validation->set_rules('email_body','ข้อความ','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb($page_title,"manageemailtemplates/template/".$type,"icon-info");

            $this->_data['page_title'] = $page_title;
            $this->_data['type'] = $type;
            $this->_data['info'] = $this->manageemailtemplatesmodel->get_settinginfo( $type );
			
			$this->admin_library->view('manageemailtemplates/template', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->manageemailtemplatesmodel->update($type);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageemailtemplates/template/'.$type);
		}
	}

	public function profile_template( $type='profile' ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		if( $type == 'profile' ){
            $menu_key = 'e5548cae38990a205ebcc49e8997026c';
			$page_title = 'เทมเพลตสำหรับผู้ฝากประวัติ';
		}else{
            $menu_key = '6c0760987505095d29f6c899f9586321';
			$page_title = 'เทมเพลตสำหรับผู้ดูแลระบบ';
		}
        $this->admin_model->set_menu_key($menu_key);
		$this->admin_model->set_detail( $page_title );
		
		$this->form_validation->set_rules('email_subject','หัวข้ออีเมล','trim|required');
		$this->form_validation->set_rules('email_body','ข้อความ','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb($page_title,"manageemailtemplates/profile_template/".$type,"icon-info");

            $this->_data['page_title'] = $page_title;
            $this->_data['type'] = $type;
            $this->_data['info'] = $this->manageemailtemplatesmodel->get_profile_settinginfo( $type );
			
			$this->admin_library->view('manageemailtemplates/profile_template', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->manageemailtemplatesmodel->profile_update($type);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageemailtemplates/profile_template/'.$type);
		}
	}

}