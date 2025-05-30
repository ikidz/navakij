<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Economicsgovernance extends CI_Controller {

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

		$this->load->model('economicsgovernance/economicsgovernancemodel', 'egm');

		$this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
    }

    public function landing(){
        $this->_data['info'] = $this->egm->get_main_category_info();
        $this->_data['categories'] = $this->egm->get_categories();

        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('economicsgovernance/landing');
        $this->load->view('included/footer');
    }

    public function documents( $categoryid=0 ){
        $this->_data['maincategory'] = $this->egm->get_main_category_info();
        $this->_data['category'] = $this->egm->get_categoryinfo_byid( $categoryid );
        $this->_data['documents'] = $this->egm->get_documents_bycategoryid( $categoryid );

        $this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('economicsgovernance/documents');
		$this->load->view('included/footer');
    }

}