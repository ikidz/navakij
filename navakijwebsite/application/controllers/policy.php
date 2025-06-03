<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Policy extends CI_Controller {

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

		$this->load->library('pagination');
		$this->load->model('policy_model');

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
    }

    public function landing(){

        $this->_data['category'] = $this->policy_model->get_categoryinfo_byid( 34 );
        $this->_data['categories'] = $this->policy_model->get_category_bymainid( 34 );

        $this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('policy/landing');
		$this->load->view('included/footer');

    }

    public function index( $meta_url='', $contentType='', $contentId=0 ){

        $this->_data['category'] = $this->policy_model->get_categoryinfo_byid( 34 );
        $this->_data['contents'] = $this->policy_model->get_sidebar_byurl( $meta_url );
        $this->_data['display'] = $this->policy_model->get_contentinfo_byid( $contentType, $contentId, $this->_data['contents'] );
        // print_r( $this->_data['contents'] );
        // exit();

        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('policy/index');
        $this->load->view('included/footer');

    }

}