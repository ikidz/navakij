<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Staticpage extends CI_Controller {

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

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );

    }

    public function risk_management(){
        
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/risk_management');
        $this->load->view('included/footer');

    }

    public function funding_amount(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/funding_amount');
        $this->load->view('included/footer');
    }

    public function public_documents(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/public_documents');
        $this->load->view('included/footer');
    }

    public function objectives(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/objectives');
        $this->load->view('included/footer');
    }

    public function product_details(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/product_details');
        $this->load->view('included/footer');
    }

    public function alm(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/alm');
        $this->load->view('included/footer');
    }

    public function expected_risk(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/expected_risk');
        $this->load->view('included/footer');
    }

    public function estimation(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/estimation');
        $this->load->view('included/footer');
    }

    public function investment(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/investment');
        $this->load->view('included/footer');
    }

    public function analysis(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('staticpage/analysis');
        $this->load->view('included/footer');
    }

}

/* End of file Static_page.php */
