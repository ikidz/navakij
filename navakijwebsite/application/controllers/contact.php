<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {

    var $_data;
	var $_language;
    public function __construct(){
        parent::__construct();

        /* Settle META for SEO - Start */
		$meta_title = $this->mainmodel->get_web_setting('seo_meta_title');
		$meta_description = $this->mainmodel->get_web_setting('seo_meta_description');
		$meta_keywords = $this->mainmodel->get_web_setting('seo_meta_keyword');
        $this->_data['meta_title'] = $meta_title['setting_value'];
        $this->_data['meta_keyword'] = $meta_description['setting_value'];
        $this->_data['meta_description'] = $meta_keywords['setting_value'];
        $this->_data['meta_image'] = base_url('public/core/img/facebook_share.jpg');
        $this->_data['meta_image_width'] = 1200;
        $this->_data['meta_image_height'] = 630;
		/* Settle META for SEO -  End */
		
		$this->languagemodel->uritosession( $this->uri->uri_string() );
		$this->_language = $this->languagemodel->get_language();
        $this->load->library('form_validation');
        $this->load->model('contact_model');

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );

    }
    
    function index(){

        $this->form_validation->set_rules('contact_fname', 'ชื่อ-นามสกุล','trim|required');
        $this->form_validation->set_rules('contact_tel', 'เบอร์โทรศัพท์','trim|required');
        $this->form_validation->set_rules('contact_email','อีเมล','trim|required|valid_email');
        $this->form_validation->set_rules('contact_message','ข้อความ','trim|required');
        $this->form_validation->set_rules('g-recaptcha-response','Captcha','trim|required|callback_validateReCaptcha');
        
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){

            $this->_data['branches'] = $this->contact_model->get_branches();
            
            $this->load->view('included/header',$this->_data);
            $this->load->view('included/navigation');
            $this->load->view('contact/index');
            $this->load->view('included/footer');
		}else{

            $response = $this->contact_model->create();
            
            $this->sendEmail( $response['contact_id'] );
            
            $this->session->set_flashdata($response['status'], $response['text']);
            
            redirect('contact-us');
		}

		
    }

    public function sendEmail( $contact_id = 0 ){

        $info = $this->contact_model->get_contactinfo_byid( $contact_id );

        /* Email Setup - Start */
        $this->load->library('email');
        /* Email Setup - End */

        $adminEmails = $this->mainmodel->get_web_setting('admin_email');
        $this->_data['company_title'] = $this->mainmodel->get_web_setting('company_title_th');

        $this->email->from('system_navakij@navakij.co.th','no-reply');
				$this->email->cc('customerservice@navakij.co.th,praewpailin_n@navakij.co.th');
        $this->email->to( $adminEmails['setting_value'] );
        $this->email->subject( 'มีการติดต่อจาก '.$info['contact_name'] );
        $this->_data['info'] = $info;
        $mailbody = $this->load->view('contact/email', $this->_data, TRUE);
        $this->email->message( $mailbody );
        $this->email->send();

    }
    
    public function validateReCaptcha( $str ){
        $state = false;
        $recaptcha = $this->input->post('g-recaptcha-response');
        $response = $this->recaptcha->verifyResponse($recaptcha);
        if (isset($response['success']) and $response['success'] === true) {
            $state = true;
        }

        return $state;
    }

    // public function info(){
    //     $this->load->view('included/header');
    //     $this->load->view('included/navigation');
    //     $this->load->view('articles/info');
    //     $this->load->view('included/footer');
    // }

}

/* End of file Contact.php */