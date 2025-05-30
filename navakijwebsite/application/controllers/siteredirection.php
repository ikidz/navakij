<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Siteredirection extends CI_Controller {

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

        $this->load->model('siteredirection/siteredirectionmodel');
    }
    

    public function index($mapid=0){

        $info = $this->siteredirectionmodel->get_mapinfo_byid( $mapid );

        if( in_array( $info['content_type'], array('insurance','articles','documents') ) === true ){
            $content = array();
            $category = array();
            if( $info['content_type'] == 'insurance' ){
                $category = $this->mainmodel->get_insurance_categoryinfo_byid( $info['category_id'] );
                $content = $this->mainmodel->get_insuranceinfo_byid( $info['content_id'] );
            }else if( $info['content_type'] == 'articles' ){
                $category = $this->mainmodel->get_article_categoryinfo_byid( $info['category_id'] );
                $maincategory = $this->mainmodel->get_article_categoryinfo_byid( $category['main_id'] );
                $content = $this->mainmodel->get_articleinfo_byid( $info['content_id'] );
            }else if( $info['content_type'] == 'documents' ){
                $category = $this->mainmodel->get_document_categoryinfo_byid( $info['category_id'] );
                $content = $this->mainmodel->get_documentinfo_byid( $info['content_id'] );
            }

            if( isset( $content ) && count( $content ) > 0 ){
                $url = site_url($content['content_meta_url']);
            }else if( isset( $category ) && count( $category ) > 0 ){
                if( isset( $maincategory ) && count( $maincategory ) > 0 ){
                    $url = site_url($maincategory['category_meta_url'].'/'.$category['category_meta_url']);
                }else{
                    $url = site_url($category['category_meta_url']);
                }
            }else{
                $url = 'javascript:void(0);';
            }
        }else if( $info['content_type'] == 'external_link' ){
            $url = $info['map_external_url'];
        }else if( $info['content_type'] == 'internal_link'){
            $url = site_url( $info['map_internal_url'] );
        }else{
            $url = 'javascript:void(0);';
        }

        redirect( $url, false );
    }

}

/* End of file Siteredirection.php */
