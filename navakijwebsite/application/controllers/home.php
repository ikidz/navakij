<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	var $_data;
	var $_language;
	function __construct(){
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

		$this->load->model('home/homemodel');
		$this->load->model('service/servicemodel');

		$this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
	}
	
	function index(){

		$this->_data['aboutus'] = $this->mainmodel->get_web_setting('aboutus');
		$this->_data['product_categories'] = $this->homemodel->get_product_categories();
		$this->_data['categories'] = $this->servicemodel->get_categories();
		// $this->_data['latest_1'] = $this->homemodel->get_latest_article_bycategoryid( 7 );
		// $this->_data['latest_2'] = $this->homemodel->get_latest_article_bycategoryid( 8 );
		// $this->_data['latest_3'] = $this->homemodel->get_latest_article_bycategoryid( 9 );
		$this->_data['latest_news'] = $this->homemodel->get_latest_news();

		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('included/banner');
		$this->load->view('home/index');
		$this->load->view('included/footer');
	}

	function template(){
		$this->load->view('included/header');
		$this->load->view('included/navigation');
		$this->load->view('home/mock_page');
		$this->load->view('included/footer');
	}
}

?>