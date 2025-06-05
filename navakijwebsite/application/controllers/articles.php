<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Articles extends CI_Controller {

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
        $this->load->model('article_model');
        $this->load->library('pagination');
        $this->load->library('form_validation');

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );

    }

    public function knowledges( $categoryid=0, $offset=0 ){

        if( $categoryid == 0 ){
            $this->_data['categories'] = $this->article_model->get_knowledge_categories();        
            $this->load->view('included/header', $this->_data);
            $this->load->view('included/navigation');
            $this->load->view('articles/landing');
            $this->load->view('included/footer');
        }else{
            $perpage = 6;
            if($offset>1){
                $offset = ($offset*$perpage)-$perpage;
            }else{
                $offset = 0;
            }

            $this->_data['category_info'] = $this->article_model->get_category_info($categoryid);
            $config['base_url'] = site_url('knowledges/'.$this->_data['category_info']['category_meta_url']);
            $config['total_rows'] = $this->article_model->count_news_list($categoryid);
            $config['uri_segment'] = 4;
            $config['per_page'] = 6;
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

            $this->_data['news_list'] = $this->article_model->get_news_list($categoryid, $perpage, $offset);
            $this->load->view('included/header',$this->_data);
            $this->load->view('included/navigation');
            $this->load->view('articles/knowledge_list');
            $this->load->view('included/footer');
        }
    }

    public function knowledge_info( $articleid=0 ){
        $this->_data['article_info'] = $this->article_model->get_article_info($articleid);
        $this->_data['category_info'] = $this->article_model->get_category_info($this->_data['article_info']['category_id']);
        $limitGallery = 9;
        $this->_data['limit_gallery'] = $limitGallery;
        $this->_data['galleries'] = $this->article_model->get_galleries_byarticleid( $articleid, $limitGallery, 0 );

        $this->_data['meta_title'] = ($this->_data['article_info']['article_meta_title'] != '' ? $this->_data['article_info']['article_meta_title'] : $this->_data['article_info']['article_title_'.$this->_language] );
        $this->_data['meta_keyword'] = $this->_data['article_info']['article_meta_keyword'];
        $this->_data['meta_description'] = $this->_data['article_info']['article_meta_description'];
        if( $this->_data['article_info']['article_facebook_image'] !='' && is_file( realpath('public/core/uploaded/article/facebook/'.$this->_data['article_info']['article_facebook_image']) ) === true ){
            list( $width, $height ) = getimagesize( realpath('public/core/uploaded/article/facebook/'.$this->_data['article_info']['article_facebook_image']) );
            $this->_data['meta_image'] = base_url( 'public/core/uploaded/article/facebook/'.$this->_data['article_info']['article_facebook_image'] );
            $this->_data['meta_image_width'] = $width;
            $this->_data['meta_image_height'] = $height;
        }

        $this->load->view('included/header',$this->_data);
        $this->load->view('included/navigation');
        $this->load->view('articles/knowledge_info');
        $this->load->view('included/footer');
    }
    
    public function index($categoryid=0, $offset=0){
        
        if( $categoryid == 0 ){

            $this->_data['news_categories'] = $this->article_model->get_news_categories();
            
            $this->load->view('included/header',$this->_data);
            $this->load->view('included/navigation');
            $this->load->view('articles/index');
            $this->load->view('included/footer');
        }else{

            $perpage = 6;
            if($offset>1){
                $offset = ($offset*$perpage)-$perpage;
            }else{
                $offset = 0;
            }
            
            $this->_data['category_info'] = $this->article_model->get_category_info($categoryid);
            $config['base_url'] = site_url('news-update/'.$this->_data['category_info']['category_meta_url']);
            $config['total_rows'] = $this->article_model->count_news_list($categoryid);
            $config['uri_segment'] = 4;
            $config['per_page'] = 6;
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
            
            $this->_data['news_list'] = $this->article_model->get_news_list($categoryid, $perpage, $offset);
            $this->load->view('included/header',$this->_data);
            $this->load->view('included/navigation');
            $this->load->view('articles/news_list');
            $this->load->view('included/footer');
            
        }
    }

    public function info($articleid=0){

        $this->_data['article_info'] = $this->article_model->get_article_info($articleid);
        $this->_data['category_info'] = $this->article_model->get_category_info($this->_data['article_info']['category_id']);
        $limitGallery = 9;
        $this->_data['limit_gallery'] = $limitGallery;
        $this->_data['galleries'] = $this->article_model->get_galleries_byarticleid( $articleid, $limitGallery, 0 );

        $this->_data['meta_title'] = ($this->_data['article_info']['article_meta_title'] != '' ? $this->_data['article_info']['article_meta_title'] : $this->_data['article_info']['article_title_'.$this->_language] );
        $this->_data['meta_keyword'] = $this->_data['article_info']['article_meta_keyword'];
        $this->_data['meta_description'] = $this->_data['article_info']['article_meta_description'];
        if( $this->_data['article_info']['article_facebook_image'] !='' && is_file( realpath('public/core/uploaded/article/facebook/'.$this->_data['article_info']['article_facebook_image']) ) === true ){
            list( $width, $height ) = getimagesize( realpath('public/core/uploaded/article/facebook/'.$this->_data['article_info']['article_facebook_image']) );
            $this->_data['meta_image'] = base_url( 'public/core/uploaded/article/facebook/'.$this->_data['article_info']['article_facebook_image'] );
            $this->_data['meta_image_width'] = $width;
            $this->_data['meta_image_height'] = $height;
        }

        $this->load->view('included/header',$this->_data);
        $this->load->view('included/navigation');
        $this->load->view('articles/info');
        $this->load->view('included/footer');
    }

    public function search_article($offset=0)
    {
        $this->form_validation->set_rules('keywords', 'หัวข้อ','trim');

        $s_data = array();
        $s_data['keywords'] = $this->input->get('keywords');

        $perpage = 6;
            if($offset>1){
                $offset = ($offset*$perpage)-$perpage;
            }else{
                $offset = 0;
            }
            
            
            //$this->_data['category_info'] = $this->article_model->get_category_info($categoryid);
            $config['base_url'] = site_url('article-search');
            $config['total_rows'] = $this->article_model->count_news_search_list($s_data);
            $config['uri_segment'] = 3;
            $config['per_page'] = 6;
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
            $this->_data['keywords'] = $s_data['keywords'];
            $this->_data['news_list'] = $this->article_model->get_news_search_list($s_data, $perpage, $offset);
            $this->load->view('included/header',$this->_data);
            $this->load->view('included/navigation');
            $this->load->view('articles/news_search_list');
            $this->load->view('included/footer');

    }

    public function stview( $articleid=0 ){
        $this->_data['article_info'] = $this->article_model->get_hidden_article_info($articleid);

        $this->_data['meta_title'] = ($this->_data['article_info']['article_meta_title'] != '' ? $this->_data['article_info']['article_meta_title'] : $this->_data['article_info']['article_title_'.$this->_language] );
        $this->_data['meta_keyword'] = $this->_data['article_info']['article_meta_keyword'];
        $this->_data['meta_description'] = $this->_data['article_info']['article_meta_description'];
        if( $this->_data['article_info']['article_facebook_image'] !='' && is_file( realpath('public/core/uploaded/article/facebook/'.$this->_data['article_info']['article_facebook_image']) ) === true ){
            list( $width, $height ) = getimagesize( realpath('public/core/uploaded/article/facebook/'.$this->_data['article_info']['article_facebook_image']) );
            $this->_data['meta_image'] = base_url( 'public/core/uploaded/article/facebook/'.$this->_data['article_info']['article_facebook_image'] );
            $this->_data['meta_image_width'] = $width;
            $this->_data['meta_image_height'] = $height;
        }

        $this->load->view('included/header',$this->_data);
        $this->load->view('included/navigation');
        $this->load->view('articles/stview');
        $this->load->view('included/footer');
    }

    public function stfile( $documentid=0 ){
        $info = $this->article_model->get_hidden_document_info( $documentid );

        if( isset( $info ) && count( $info ) > 0 ){
            $fieldname = ( $this->_language == 'en' ? 'document_file_en' : 'document_file' );
            if( $info[$fieldname] != '' && is_file( realpath( 'public/core/uploaded/hidden_documents/'.$info[$fieldname] ) ) === true ){
                redirect( base_url('public/core/uploaded/hidden_documents/'.$info[$fieldname]) );
            }else{
                show_404();
            }
        }else{
            show_404();
        }
    }

    public function cookies_policy(){

        $this->_data['info'] = $this->mainmodel->get_web_setting( 'privacy_'.$this->_language );

        $this->load->view('included/header',$this->_data);
        $this->load->view('included/navigation');
        $this->load->view('articles/policy');
        $this->load->view('included/footer');

    }

}

/* End of file Articles.php */