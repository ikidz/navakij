<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sustainable extends CI_Controller {

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

        $this->load->model('sustainable_model');

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
        
    }

    public function index(){
        $this->load->view('included/header');
        $this->load->view('included/navigation');
        $this->load->view('sustainable/index');
        $this->load->view('included/footer');
    }

    public function documents( $categoryid=0 ){
        
		$category = $this->sustainable_model->get_document_categoryinfo_byid( $categoryid );
		$this->_data['category'] = $category;
		$this->_data['maincategory'] = $this->sustainable_model->get_document_categoryinfo_byid( $category['main_id'] );
        $this->_data['documents'] = $this->sustainable_model->get_documents_bycategoryid( $categoryid );
        // print_r( $this->_data ['documents']);
        // exit();

		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('sustainable/documents');
		$this->load->view('included/footer');

    }
    public function change_link(){

        redirect(site_url('news-update/csr-news'));
    }

}

/* End of file Sustainable.php */