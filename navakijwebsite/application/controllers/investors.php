<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Investors extends CI_Controller {

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
        $this->load->model('investors/investorsmodel');

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
    }
    
    public function index(){
		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('investors/financial');
		$this->load->view('included/footer');
    }

    public function articles( $categoryid=0 ,$offset=0){

        $perpage = 6;
        if($offset>1){
            $offset = ($offset*$perpage)-$perpage;
        }else{
            $offset = 0;
        }
        
        $category = $this->investorsmodel->get_categoryinfo_byid( $categoryid );
        $config['base_url'] = site_url('investor-relations/'.$category['category_meta_url']);
        $config['total_rows'] = $this->investorsmodel->count_articles_list($categoryid);
        $config['uri_segment'] = 4;
        $config['per_page'] = $perpage;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '<i class="fas fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_link'] = '<i class="fas fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['next_link'] = '<i class="fas fa-angle-right"></i>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['prev_link'] = '<i class="fas fa-angle-left"></i>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);
        
        $this->_data['pagination'] = $this->pagination->create_links();
        
        $this->_data['category_info'] = $category;
        $this->_data['news_list'] = $this->investorsmodel->get_articles_bycategoryid($categoryid, $perpage, $offset);

        $this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('investors/news_list');
		$this->load->view('included/footer');
    }

    public function info( $articleid=0 ){
        $info = $this->investorsmodel->get_articleinfo_byid( $articleid );
		$this->_data['category'] = $this->investorsmodel->get_categoryinfo_byid( $info['category_id'] );
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
		$this->load->view('investors/info');
		$this->load->view('included/footer');
    }

    public function documents( $categoryid=0 ,$offset=0){

        $perpage = 10;
        if($offset>1){
            $offset = ($offset*$perpage)-$perpage;
        }else{
            $offset = 0;
        }

        $category = $this->investorsmodel->get_document_categoryinfo_byid( $categoryid );
        $config['base_url'] = site_url($category['category_meta_url']);
        $config['total_rows'] = $this->investorsmodel->count_document_list($categoryid);
        $config['uri_segment'] = 4;
        $config['per_page'] = $perpage;
        $config['num_links'] = 5;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = FALSE;
        $config['full_tag_open'] = '<ul class="pagination justify-content-end">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = '<i class="fas fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['first_tag_close'] = '</span></li>';
        $config['last_link'] = '<i class="fas fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['last_tag_close'] = '</span></li>';
        $config['next_link'] = '<i class="fas fa-angle-right"></i>';
        $config['next_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['next_tag_close'] = '</span></li>';
        $config['prev_link'] = '<i class="fas fa-angle-left"></i>';
        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['prev_tag_close'] = '</span></li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close'] = '</span></li>';

        $this->pagination->initialize($config);
        
        $this->_data['pagination'] = $this->pagination->create_links();
		$this->_data['category'] = $category;
		$this->_data['maincategory'] = $this->investorsmodel->get_document_categoryinfo_byid( $category['main_id'] );
        $this->_data['documents'] = $this->investorsmodel->get_documents_bycategoryid( $categoryid , $perpage, $offset);
        
        $this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('investors/documents');
		$this->load->view('included/footer');
    }
    
    public function financial(){
		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('investors/financial');
		$this->load->view('included/footer');
	}

    public function stockholder(){
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('investors/stockholder');
        $this->load->view('included/footer');
    }

    public function change_link( $anchor='' ){
        switch( $anchor ){
            case 'marketingnews' :
                redirect('news-update/marketing-news');
            break;
            default :
                redirect('investor-relations/financial-highlights');
        }
    }

}

/* End of file Investors.php */