<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Claim extends CI_Controller {

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

        $this->load->model('claim_model');
        $this->load->library('form_validation');
    }
    
    function index(){

        $this->form_validation->set_rules('keywords', 'ชื่อสถานประกอบการ','trim');
        $this->form_validation->set_rules('category_id', 'นามสกุล','trim');
        $this->form_validation->set_rules('province_id', 'เบอร์โทรศัพท์','trim');
        $this->form_validation->set_rules('district_id','อีเมล','trim');
        $this->form_validation->set_rules('brand_id','','trim');

        $s_data = array();
        $s_data['keywords'] = $this->input->get('keywords');
		$s_data['category_id'] = $this->input->get('category_id');
        $s_data['province_id'] = $this->input->get('province_id');
        $s_data['district_id'] = $this->input->get('district_id');
        $s_data['brand_id'] = $this->input->get('brand_id');
        
        $this->_data["branch_list"] = $this->claim_model->get_branch_list($s_data);
        $this->_data['category'] = $this->claim_model->get_category_branch_list();
        $this->_data['province'] = $this->claim_model->get_provinces();
        $this->_data['brand'] = $this->claim_model->get_brands();
        
		$this->load->view('included/header',$this->_data);
		$this->load->view('included/navigation');
		$this->load->view('claim/index');
		$this->load->view('included/footer');
    }
    
    /* APIs - Start */
    public function get_districts(){
        $provinceid = $this->input->post('province_id');
        $this->_data['districts'] = $this->claim_model->get_districts( $provinceid );
        $this->load->view('claim/api/districts', $this->_data);
    }
    /* APIs - End */

}

/* End of file Claim.php */