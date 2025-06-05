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

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
    }
    
    function index(){

      $s_data = array();
      $s_data['keywords'] = $this->input->get('keywords');
			$s_data['category_id'] = $this->input->get('category_id');
      $s_data['province_id'] = $this->input->get('province_id');
      $s_data['district_id'] = $this->input->get('district_id');
      $s_data['brand'] = $this->input->get('brand');
      $s_data['lat'] = $this->input->get('lat');
      $s_data['lng'] = $this->input->get('lng');
      
      $limit_branches = 10;
      
      $this->_data['category'] = $this->claim_model->get_category_branch_list();
      $this->_data['province'] = $this->claim_model->get_provinces();
      $this->_data['brand'] = $this->claim_model->get_brands();
      $this->_data['documents_subcatgories'] = $this->claim_model->get_subcat_bymainid( 15 );
      $this->_data['limit_branches'] = $limit_branches;
      $this->_data['s_datas'] = $s_data;

      if( $this->input->get() ){
          $this->_data["branch_list"] = $this->claim_model->get_branch_list($s_data, 0, $limit_branches);
          $this->_data['total_brances'] = $this->claim_model->count_branch_list($s_data);
      }else{
          $this->_data['branch_list'] = array();
          $this->_data['total_brances'] = 0;
      }

			$this->load->view('included/header',$this->_data);
			$this->load->view('included/navigation');
			$this->load->view('claim/index');
			$this->load->view('included/footer');
    }

    public function pdflist( $categoryid=0 ){

        if( $categoryid > 0 ){
        
            $this->_data['category'] = $this->claim_model->get_category_branch_info( $categoryid );
            $this->_data['branches'] = $this->claim_model->get_pdf_branches( $categoryid );

            $this->load->view('claim/pdflist', $this->_data);
        
        }else{
            $this->_data['categories'] = $this->claim_model->get_category_branch_list();

            $this->load->view('included/header', $this->_data);
            $this->load->view('included/navigation');
            $this->load->view('claim/pdfcate');
            $this->load->view('included/footer');
        }
        
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