<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends CI_Controller {

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
		$this->load->model('aboutus/aboutusmodel');

        $this->mainmodel->iplog( $this->input->ip_address(), $this->_language, current_url(), uri_string() );
    }
    
    public function index(){
        redirect('about-us/company-history');
		// $this->load->view('included/header', $this->_data);
		// $this->load->view('included/navigation');
		// $this->load->view('aboutus/boardofdirectors');
		// $this->load->view('included/footer');
	}
	
	public function info($articleid=0){

		$this->_data['maincategory'] = array();
		$this->_data['category'] = array();
		$this->_data['info'] = array();
		$info = $this->aboutusmodel->get_articleinfo_byid( $articleid );
		if( isset( $info ) && count( $info ) > 0 ){
			$this->_data['info'] = $info;
			$category = $this->aboutusmodel->get_categoryinfo_byid( $info['category_id'] );
			if( isset( $category ) && count( $category ) > 0 ){
				$this->_data['category'] = $category;
				$this->_data['maincategory'] = $this->aboutusmodel->get_categoryinfo_byid( $category['category_id'] );
			}
		}

		$this->_data['meta_title'] = ($this->_data['info']['article_meta_title'] != '' ? $this->_data['info']['article_meta_title'] : $this->_data['info']['article_title_'.$this->_language] );
        $this->_data['meta_keyword'] = $this->_data['info']['article_meta_keyword'];
        $this->_data['meta_description'] = $this->_data['info']['article_meta_description'];
        if( $this->_data['info']['article_facebook_image'] !='' && is_file( realpath('public/core/uploaded/article/facebook/'.$this->_data['info']['article_facebook_image']) ) === true ){
            list( $width, $height ) = getimagesize( realpath('public/core/uploaded/article/facebook/'.$this->_data['info']['article_facebook_image']) );
            $this->_data['meta_image'] = base_url( 'public/core/uploaded/article/facebook/'.$this->_data['info']['article_facebook_image'] );
            $this->_data['meta_image_width'] = $width;
            $this->_data['meta_image_height'] = $height;
        }
        // print_r( $this->_data );
        // exit();

		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('aboutus/info');
		$this->load->view('included/footer');
	}

	public function documents( $categoryid=0 ,$offset=0){

        $perpage = 10;
        if($offset>1){
            $offset = ($offset*$perpage)-$perpage;
        }else{
            $offset = 0;
        }

        $category = $this->aboutusmodel->get_document_categoryinfo_byid( $categoryid );
        $maincategory = $this->aboutusmodel->get_document_categoryinfo_byid( $category['main_id'] );
        $config['base_url'] = site_url($maincategory['category_meta_url'].'/'.$category['category_meta_url']);
        $config['total_rows'] = $this->aboutusmodel->count_document_list($categoryid);
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
		$this->_data['maincategory'] = $this->aboutusmodel->get_document_categoryinfo_byid( $category['main_id'] );
        $this->_data['documents'] = $this->aboutusmodel->get_documents_bycategoryid( $categoryid , $perpage, $offset);
        
        $this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('aboutus/documents');
		$this->load->view('included/footer');
    }
    
    public function organizational(){
		$this->load->view('included/header');
		$this->load->view('included/navigation');
		$this->load->view('aboutus/organizational');
		$this->load->view('included/footer');
	}

	public function boardofdirectors(){

        $this->_data['position'] = $this->aboutusmodel->get_positioninfo_byid( 1 );
        $this->_data['boardmembers'] = $this->aboutusmodel->get_boardmembers( 1 );

		$this->load->view('included/header', $this->_data);
		$this->load->view('included/navigation');
		$this->load->view('aboutus/boardofdirectors');
		$this->load->view('included/footer');
	}

    public function directors( $positionid=0 ){

        $this->_data['position'] = $this->aboutusmodel->get_positioninfo_byid( $positionid );
        $this->_data['subpositions'] = $this->aboutusmodel->get_positions_bymainid( $positionid );
        
        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('aboutus/directors');
        $this->load->view('included/footer');

    }

    public function getProfile( $id=0 ){
        if( !$id || $id == 0 ){
            $response = [
                'status' => 500,
                'message' => 'ID is invalid'
            ];

            $this->json->set('response', $response);
            $this->json->send();
            return;
        }

        $this->_data['info'] = $this->aboutusmodel->get_memberinfo_byid( $id );
        $view = $this->load->view('aboutus/member_profile', $this->_data, TRUE);

        $response = [
            'status' => 200,
            'payLoads' => [
                'member_name' => $this->_data['info']['member_name_'.$this->_language],
                'views' => $view
            ]
        ];
        $this->json->set('response', $response);
        $this->json->send();
        return ;
    }

    public function awards(){

        $this->_data['awards'] = $this->aboutusmodel->get_awards();

        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('aboutus/awards');
        $this->load->view('included/footer');
    }
	
    public function sellagents(){

				$sData = array();
				if( $this->input->get('keywords') ){
					$sData['keywords'] = $this->input->get('keywords'); 
				}else{
					$sData['keywords'] = '';
				}

        $this->_data['sellagents'] = $this->aboutusmodel->get_sellagents($sData);

        $this->load->view('included/header', $this->_data);
        $this->load->view('included/navigation');
        $this->load->view('aboutus/sellagents');
        $this->load->view('included/footer');

    }

}

/* End of file Aboutus.php */