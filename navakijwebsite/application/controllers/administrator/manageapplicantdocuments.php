<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageapplicantdocuments extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageapplicantdocuments/manageapplicantdocumentsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1e1188604ececddcc32218f8f72a29ad');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการรับสมัครงาน",'icon-list-alt');
	}

	public function announcing_letter(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		$_menu_name = 'หลักเกณฑ์วิธีการและเงื่อนไขในการขออนุญาตเปิดสาขา ย้ายที่ตั้งสำนักงานใหญ่ หรือสำนักงานสาขา หรือเลิกสาขาของบริษัทประกันวินาศภัย พ.ศ. 2551 ลว. 3 กรกฎาคม 2551';
		$this->admin_model->set_menu_key('c299d0e14791865236c4cf1d2621d27e');
		$this->admin_model->set_detail( $_menu_name );
		
		$this->form_validation->set_rules('setting_value','รายละเอียด','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['info'] = $this->manageapplicantdocumentsmodel->get_setting_bykey( 'announcing_letter' );
            $this->_data['_menu_name'] = $_menu_name;

            $this->admin_library->view('manageapplicantdocuments/texteditor', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->manageapplicantdocumentsmodel->update( 'announcing_letter' );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageapplicantdocuments/announcing_letter');

        }
	}
	
	public function forbidden_person_letter(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
        $_menu_name = 'บุคคลซึ่งมีลักษณะต้องห้ามตามมาตรา 34 แห่งพระราชบัญญัติ ประกันวินาศภัย (ฉบับที่ 2) พ.ศ. 2551 ลว.​ 27 มกราคม 2551';
		$this->admin_model->set_menu_key('1290d3069859d7ec69b6bf9251fc8d84');
		$this->admin_model->set_detail( $_menu_name );
		
		$this->form_validation->set_rules('setting_value','รายละเอียด','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['info'] = $this->manageapplicantdocumentsmodel->get_setting_bykey( 'forbidden_person_letter' );
            $this->_data['_menu_name'] = $_menu_name;

            $this->admin_library->view('manageapplicantdocuments/texteditor', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->manageapplicantdocumentsmodel->update( 'forbidden_person_letter' );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageapplicantdocuments/forbidden_person_letter');

        }
	}
	
	public function pdpa_act(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
        $_menu_name = 'พระราชบัญญัติ คุ้มครองข้อมูลส่วนบุคคล';
		$this->admin_model->set_menu_key('3114275784241da858ba02f7127978f5');
		$this->admin_model->set_detail( $_menu_name );
		
		$this->form_validation->set_rules('setting_value','รายละเอียด','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            
            $this->_data['info'] = $this->manageapplicantdocumentsmodel->get_setting_bykey( 'pdpa_act' );
            $this->_data['_menu_name'] = $_menu_name;

            $this->admin_library->view('manageapplicantdocuments/texteditor', $this->_data);
            $this->admin_library->output();

        }else{
            
            $message = $this->manageapplicantdocumentsmodel->update( 'pdpa_act' );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageapplicantdocuments/pdpa_act');

        }
	}

}