
<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

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

		$this->load->model('service/servicemodel');

		$this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
    }
    
    public function index($metaURL=''){

		if( $metaURL != '' ){

			$this->_data['category'] = array();
			$this->_data['articles'] = array();
			$this->_data['documents_subcatgories'] = array();
			$category = $this->servicemodel->get_categoryinfo( $metaURL );
			$document_category = $this->servicemodel->get_document_categoryinfo( $metaURL );
			$this->_data['category'] = $category;
			if( isset( $category ) && count( $category ) > 0 ){
				$this->_data['articles'] = $this->servicemodel->get_articles_bycategoryid( $category['category_id'] );
			}

			if( isset( $document_category ) && count( $document_category ) > 0 ){
				$this->_data['documents_subcatgories'] = $this->servicemodel->get_documents_categories( $document_category['category_id'] );
			}

			$this->load->view('included/header', $this->_data);
			$this->load->view('included/navigation');
			$this->load->view('service/index');
			$this->load->view('included/footer');
		}else{

			$this->_data['categories'] = $this->servicemodel->get_categories();

			$this->load->view('included/header', $this->_data);
			$this->load->view('included/navigation');
			$this->load->view('service/landing');
			$this->load->view('included/footer');
		}

	}

	public function documents( $categoryid=0 ){

		$category = $this->servicemodel->get_document_categoryinfo_byid( $categoryid );
		$this->_data['category'] = $category;
		$this->_data['maincategory'] = $this->servicemodel->get_document_categoryinfo_byid( $category['main_id'] );
		$this->_data['documents'] = $this->servicemodel->get_documents_bycategoryid( $categoryid );

		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('service/documents');
		$this->load->view('included/footer');

	}
	
	public function info( $articleid=0 ){

		$info = $this->servicemodel->get_articleinfo_byid( $articleid );
		$this->_data['category'] = $this->servicemodel->get_categoryinfo_byid( $info['category_id'] );
		$this->_data['info'] = $info;

		$this->_data['meta_title'] = ($this->_data['info']['article_meta_title'] != '' ? $this->_data['info']['article_meta_title'] : $this->_data['info']['article_title_'.$this->_language] );
        $this->_data['meta_keyword'] = $this->_data['info']['article_meta_keyword'];
        $this->_data['meta_description'] = $this->_data['info']['article_meta_description'];
        if( $this->_data['info']['article_facebook_image'] !='' && is_file( realpath('public/core/uploaded/article/facebook/'.$this->_data['info']['article_facebook_image']) ) === true ){
            list( $width, $height ) = getimagesize( realpath('public/core/uploaded/article/facebook/'.$this->_data['info']['article_facebook_image']) );
            $this->_data['meta_image'] = base_url( 'public/core/uploaded/article/facebook/'.$this->_data['info']['article_facebook_image'] );
            $this->_data['meta_image_width'] = $width;
            $this->_data['meta_image_height'] = $height;
        }

		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('service/info');
		$this->load->view('included/footer');
	}
    
    public function payment(){
		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('service/payment');
		$this->load->view('included/footer');
	}

	public function claim(){
		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('service/claim');
		$this->load->view('included/footer');
	}
	

}

/* End of file Service.php */