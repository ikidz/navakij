<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class products extends CI_Controller {

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
        $this->load->model('product_model');

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
    }
    

    public function index($category=0){

        if( $category == 0 ){
            $this->_data['product_categories'] = $this->product_model->get_product_categories();

            $this->load->view('included/header', $this->_data);
            $this->load->view('included/navigation');
            $this->load->view('product/landing');
            $this->load->view('included/footer');

        }else{

            $this->_data['product_categories'] = $this->product_model->get_product_categories();
            $this->_data['product_highlight'] = $this->product_model->get_product_highlight( $category );
            $this->_data["product_list"] = $this->product_model->get_product_list($category);
            $this->_data['category_id'] = $category;
            $this->_data['category_info'] = $this->product_model->get_categoryinfo_byid( $category );
            $this->_data['vehicle_group'] = $this->product_model->get_vehicle_group();

            $this->load->view('included/header',$this->_data);
            $this->load->view('included/navigation');
            $this->load->view('product/index');
            $this->load->view('included/footer');

        }

    }

    public function line_landing(){
        $this->_data['product_categories'] = $this->product_model->get_product_categories();

        $this->load->view('included/header', $this->_data);
        // $this->load->view('included/navigation');
        $this->load->view('product/line_landing');
        $this->load->view('included/footer_nonav');
    }

    public function search_product($category=1){

        $s_data = array();
		
        $s_data['filter_keywords'] = $this->input->post('filter_keywords');
		$s_data['vehicle_group_id'] = $this->input->post('vehicle_group_id');
        $s_data['sum_insured'] = $this->input->post('sum_insured');
        $s_data['year'] = $this->input->post('year');
        $s_data['category_id'] = $category;
		
		$this->_data['product_categories'] = $this->product_model->get_product_categories();
        $this->_data["product_list"] = $this->product_model->get_product_search_list($s_data);
        $this->_data['vehicle_group'] = $this->product_model->get_vehicle_group();
        $this->_data['category_id'] = $category;
        
        $this->load->view('included/header',$this->_data);
        $this->load->view('included/navigation');
        $this->load->view('product/search_index');
        $this->load->view('included/footer');
    }

    public function info($insurance=0){

        $this->_data["product_info"] = $this->product_model->get_product_info($insurance);
        $this->_data["category_info"] = $this->product_model->get_category_info($this->_data["product_info"]['insurance_category_id']);
        $this->_data['icon'] = $this->product_model->get_icon_insurance($insurance);
        //$this->_data['vehicle_list'] = $this->product_model->get_vehicle_insurance_by_insurance_id($insurance);
        $this->_data['suggestion_list'] = $this->product_model->get_suggestion_insurance($this->_data["product_info"]['insurance_category_id'],$insurance);
        $this->_data['provinces'] = $this->product_model->get_provinces();

        $this->_data['meta_title'] = $this->_data['product_info']['insurance_meta_title'];
        $this->_data['meta_keyword'] = $this->_data['product_info']['insurance_meta_keyword'];
        $this->_data['meta_description'] = $this->_data['product_info']['insurance_meta_description'];
        if( $this->_data['product_info']['insurance_facebook_image'] !='' && is_file( realpath('public/core/uploaded/insurance/facebook/'.$this->_data['product_info']['insurance_facebook_image']) ) === true ){
            list( $width, $height ) = getimagesize( realpath('public/core/uploaded/insurance/facebook/'.$this->_data['product_info']['insurance_facebook_image']) );
            $this->_data['meta_image'] = base_url( 'public/core/uploaded/insurance/facebook/'.$this->_data['product_info']['insurance_facebook_image'] );
            $this->_data['meta_image_width'] = $width;
            $this->_data['meta_image_height'] = $height;
        }
        

        $this->form_validation->set_rules('agreement','กดยอมรับนโยบายความเป็นส่วนตัวแล้ว','trim|required');
        // $this->form_validation->set_rules('contact_gender',' เพศ','trim|required');
        $this->form_validation->set_rules('contact_fname', 'ชื่อจริง','trim|required');
        $this->form_validation->set_rules('contact_lname', 'นามสกุล','trim|required');
        $this->form_validation->set_rules('contact_tel', 'เบอร์โทรศัพท์','trim|required');
        // $this->form_validation->set_rules('contact_email','อีเมล','trim|required');
        $this->form_validation->set_rules('province_id','จังหวัด','trim|required');
        $this->form_validation->set_rules('agreement','การยินยอมตามนโยบายความเป็นส่วนตัว','trim|required');
        $this->form_validation->set_rules('g-recaptcha-response','Captcha','trim|required|callback_validateReCaptcha');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if($this->form_validation->run()===FALSE){
            $this->load->view('included/header',$this->_data);
            $this->load->view('included/navigation');
            $this->load->view('product/info');
            $this->load->view('included/footer');
        }else{

            $message = $this->product_model->create();

            $this->sendEmail( $message['payLoads']['contact_id'], $message['payLoads']['insurance_id'] );
						
            $this->session->set_flashdata($message['status'], $message['text']);
            redirect( 'products/'.$this->_data['product_info']['insurance_meta_url'] );
            
        }
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

    public function sendEmail( $contact_id = 0, $insurance_id = 0 ){

        $info = $this->product_model->get_contactinfo_byid( $contact_id );
        $product = $this->product_model->get_product_info( $insurance_id );

        /* Email Setup - Start */
        $this->load->library('email');
        /* Email Setup - End */

        $adminEmails = $this->mainmodel->get_web_setting('admin_email');
        $this->_data['company_title'] = $this->mainmodel->get_web_setting('company_title_th');

        $this->email->from('system_navakij@navakij.co.th','no-reply');
        $this->email->to( $adminEmails['setting_value'] );
        $this->email->subject( 'ผลิตภัณฑ์ได้รับความสนใจจากคุณ '.$info['insurance_contact_name'].' '.$info['insurance_contact_lastname'] );
        $this->_data['info'] = $info;
        $this->_data['product'] = $product;
        $mailbody = $this->load->view('product/email', $this->_data, TRUE);
        $this->email->message( $mailbody );
        $this->email->send();

        $this->email->from('system_navakij@navakij.co.th','no-reply');
        $this->email->to( $info['insurance_contact_email'] );
        $this->email->subject( 'ขอบคุณที่ให้ความสนใจในผลิตภัณฑ์ของเรา' );
        $this->_data['info'] = $info;
        $this->_data['product'] = $product;
        $mailbody = $this->load->view('product/email_customer', $this->_data, TRUE);
        $this->email->message( $mailbody );
        $this->email->send();

    }

}

/* End of file Products.php */
