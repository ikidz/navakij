<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageadminsenders extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageadminsenders/manageadminsendersmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1e1188604ececddcc32218f8f72a29ad');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการรับสมัครงาน",'icon-list-alt');
	}

	public function emaillists(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('a10f1551223251bf90972a36548c7fc1');
		$this->admin_model->set_detail('รายการอีเมลผู้ดูแลระบบ');
		
		$this->form_validation->set_rules('setting_value','รายละเอียด','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['info'] = $this->manageadminsendersmodel->get_setting_bykey( 'hr_admin_emails'  );

            $this->admin_library->view('manageadminsenders/email', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->manageadminsendersmodel->update( 'hr_admin_emails' );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageadminsenders/emaillists');

        }
	}

}