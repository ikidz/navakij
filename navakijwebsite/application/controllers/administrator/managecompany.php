<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managecompany extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managecompany/managecompanymodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('901b5dbc1f07beb25b9eab9798f3adec');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("การจัดการข้อมูลบริษัท",'icon-list-alt');
	}

	public function index(){
		
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->form_validation->set_rules('company_name','ชื่อบริษัท','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			$this->_data['info'] = $this->managecompanymodel->get_companyinfo();
			
			$this->admin_library->view('managecompany/info', $this->_data);
			$this->admin_library->output();
			
		}else{
			
			$message = $this->managecompanymodel->update();
			
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('managecompany/index');
			
		}
		
	}

}