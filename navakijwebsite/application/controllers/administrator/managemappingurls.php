<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managemappingurls extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managemappingurls/managemappingurlsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('eae8ed1811aa26169c27dfea701ff90c');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการ Mapping",'icon-list-alt');
	}

	public function index($offset=0){
        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }
            
        $this->admin_model->set_menu_key('48ce8d486ef5db33b068237da32370c8');
        $this->admin_model->set_detail('รายการ Mapping URL');

        $this->admin_model->set_top_button('เพิ่มรายการ Mapping','managemappingurls/create','icon-plus','btn-success','w');

        /* Get Data Table - Start */
        $perpage = 10;
        if($offset>1){
            $offset = ($offset*$perpage)-$perpage;
            $this->seq = $offset;
        }else{
            $offset = 0;
        }
        $this->admin_model->set_dataTable($this->managemappingurlsmodel->get_maps($perpage, $offset));
        $totalrows = $this->managemappingurlsmodel->count_maps();
        /* Get Data Table - End */

        $this->admin_model->set_column('map_id','ลำดับ','10%','icon-list-ol');
        $this->admin_model->set_column('map_origin','URL ต้นทาง','15%','icon-sign-in');
        $this->admin_model->set_column('map_destination','URL ปลายทาง','15%','icon-sign-out');
        $this->admin_model->set_column('map_status','สถานะการแสดงผล','15%','icon-eye-slash');
        $this->admin_model->set_action_button('แก้ไขข้อมูล','managemappingurls/update/[map_id]','icon-pencil-square-o','btn-primary','w');
        $this->admin_model->set_action_button('ลบข้อมูล','managemappingurls/delete/[map_id]','icon-trash','btn-danger','d');
        $this->admin_model->set_column_callback('map_id','show_seq');
        $this->admin_model->set_column_callback('map_destination','show_path');
        $this->admin_model->set_column_callback('map_status','show_status');
        $this->admin_model->set_pagination("managemappingurls/index",$totalrows,$perpage,4);
        $this->admin_model->make_list();
                
        $this->admin_library->output();
    }

    public function create(){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('48ce8d486ef5db33b068237da32370c8');
        $this->admin_model->set_detail('เพิ่มรายการ Mapping');

        $this->form_validation->set_rules('map_origin', 'URL ต้นทาง','trim|required');
        $this->form_validation->set_rules('content_type','ประเภทของเมนู','trim|required');
        if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
            $this->form_validation->set_rules('category_id','หมวดหมู่ของเนื้อหา','trim|required');
        }else{
            $this->form_validation->set_rules('category_id','หมวดหมู่ของเนื้อหา','trim');
        }
        $this->form_validation->set_rules('content_id','เนื้อหา','trim');
        if( $this->input->post('content_type') == 'external_link' ){
            $this->form_validation->set_rules('map_external_url', 'URL','trim|required');
        }else{
            $this->form_validation->set_rules('map_external_url', 'URL','trim');
        }
        if( $this->input->post('content_type') == 'internal_link' ){
            $this->form_validation->set_rules('map_internal_url','URL','trim|required');
        }else{
            $this->form_validation->set_rules('map_internal_url','URL','trim');
        }
        $this->form_validation->set_rules('is_newtab','เปิดแท็บใหม่','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if($this->form_validation->run()===FALSE){
            $this->admin_library->add_breadcrumb("รายการ Mapping URL","managemappingurls/index","icon-list-ol");
            $this->admin_library->add_breadcrumb("เพิ่มรายการ Mapping URL","managemappingurls/create","icon-plus");

            $this->_data['static_pages'] = $this->managemappingurlsmodel->get_static_pages();
            $this->_data['categories'] = array();
            $this->_data['settings'] = array();

            if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
                $response = $this->get_categories( $this->input->post('content_type'), true );
                $this->_data['settings'] = $response['settings'];
                $this->_data['categories'] = $response['categories'];
                if( $this->input->post('category_id') ){
                    $this->_data['contents'] = $this->get_contents( $this->input->post('content_type'), $this->input->post('category_id'), true );
                }
            }

            $this->admin_library->view('managemappingurls/create', $this->_data);
            $this->admin_library->output();
        }else{
            $message = $this->managemappingurlsmodel->create();
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managemappingurls/index');
        }
    }

    public function update($mapid=0){
        if(!$this->admin_model->check_permision("w")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('48ce8d486ef5db33b068237da32370c8');
        $this->admin_model->set_detail('แก้ไขรายการ Mapping');

        $this->form_validation->set_rules('map_origin', 'URL ต้นทาง','trim|required');
        $this->form_validation->set_rules('content_type','ประเภทของเมนู','trim|required');
        if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
            $this->form_validation->set_rules('category_id','หมวดหมู่ของเนื้อหา','trim|required');
        }else{
            $this->form_validation->set_rules('category_id','หมวดหมู่ของเนื้อหา','trim');
        }
        $this->form_validation->set_rules('content_id','เนื้อหา','trim');
        if( $this->input->post('content_type') == 'external_link' ){
            $this->form_validation->set_rules('map_external_url', 'URL','trim|required');
        }else{
            $this->form_validation->set_rules('map_external_url', 'URL','trim');
        }
        if( $this->input->post('content_type') == 'internal_link' ){
            $this->form_validation->set_rules('map_internal_url','URL','trim|required');
        }else{
            $this->form_validation->set_rules('map_internal_url','URL','trim');
        }
        $this->form_validation->set_rules('is_newtab','เปิดแท็บใหม่','trim');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if($this->form_validation->run()===FALSE){
            $this->admin_library->add_breadcrumb("รายการ Mapping URL","managemappingurls/index","icon-list-ol");
            $this->admin_library->add_breadcrumb("แก้ไขรายการ Mapping URL","managemappingurls/update/".$mapid,"icon-plus");

            $info = $this->managemappingurlsmodel->get_mapinfo_byid( $mapid );

            if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
                $response = $this->get_categories( $this->input->post('content_type'), true );
                $this->_data['settings'] = $response['settings'];
                $this->_data['categories'] = $response['categories'];
                if( $this->input->post('category_id') ){
                    $this->_data['contents'] = $this->get_contents( $this->input->post('content_type'), $this->input->post('category_id'), true );
                }
            }else{
                $response = $this->get_categories( $info['content_type'], true );
                $this->_data['settings'] = $response['settings'];
                $this->_data['categories'] = $response['categories'];
                if( $info['category_id'] != 0 ){
                    $this->_data['contents'] = $this->get_contents( $info['content_type'], $info['category_id'], true );
                }
            }
            $this->_data['info'] = $info;
            $this->_data['static_pages'] = $this->managemappingurlsmodel->get_static_pages();
            $this->_data['contentType'] = ( $this->input->post('content_type') ? $this->input->post('content_type') : $info['content_type'] );

            if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
                $response = $this->get_categories( $this->input->post('content_type'), true );
                $this->_data['settings'] = $response['settings'];
                $this->_data['categories'] = $response['categories'];
                if( $this->input->post('category_id') ){
                    $this->_data['contents'] = $this->get_contents( $this->input->post('content_type'), $this->input->post('category_id'), true );
                }
            }

            $this->admin_library->view('managemappingurls/update', $this->_data);
            $this->admin_library->output();
        }else{
            $message = $this->managemappingurlsmodel->update( $mapid );
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managemappingurls/index');
        }
    }

    public function delete( $mapid=0 ){
        $message = array();
        $message = $this->managemappingurlsmodel->setStatus( 'discard', $mapid );

        $this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('managemappingurls/index');
    }

    public function get_categories( $type = 'articles', $controllerUse = false ){
        $this->_data['categories'] = array();
        if( $type == 'articles' ){
            $this->_data['settings'] = array(
                'category_type' => 'articles',
                'has_sub' => 1
            );
            $this->_data['categories'] = $this->managemappingurlsmodel->get_article_categories();
        }else if( $type == 'insurance' ){
            $this->_data['settings'] = array(
                'category_type' => 'insurance',
                'has_sub' => 0
            );
            $this->_data['categories'] = $this->managemappingurlsmodel->get_insurance_categories();
        }else if( $type == 'documents' ){
            $this->_data['settings'] = array(
                'category_type' => 'documents',
                'has_sub' => 1
            );
            $this->_data['categories'] = $this->managemappingurlsmodel->get_document_categories();
        }else{
            $this->_data['settings'] = array(
                'category_type' => '',
                'has_sub' => 0
            );
        }
        
        if( $controllerUse === true ){
            return array(
                'settings' => $this->_data['settings'],
                'categories' => $this->_data['categories']
            );
        }else{
            $this->load->view('administrator/views/managemappingurls/api/categories', $this->_data);
        }
    }

    public function get_contents( $type = 'articles', $categoryid=0, $controllerUse = false ){
        $this->_data['contents'] = array();
        if( $type == 'articles' ){
            $this->_data['contents'] = $this->managemappingurlsmodel->get_articles( $categoryid );
        }else if( $type == 'insurance' ){
            $this->_data['contents'] = $this->managemappingurlsmodel->get_insurances( $categoryid );
        }else if( $type == 'documents' ){
            $this->_data['contents'] = $this->managemappingurlsmodel->get_documents( $categoryid );
        }

        if( $controllerUse === true ){
            return $this->_data['contents'];
        }else{
            $this->load->view('administrator/views/managemappingurls/api/contents', $this->_data);
        }
    }

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }

    public function show_status($text, $row){
        switch($text){
            case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
            case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
            default : return 'ไม่มีสถานะ';
        }
    }

    public function show_path( $text, $row ){
        
        if( in_array( $row['content_type'], array('insurance','articles','documents') ) === true ){
            $content = array();
            $category = array();
            if( $row['content_type'] == 'insurance' ){
                $category = $this->mainmodel->get_insurance_categoryinfo_byid( $row['category_id'] );
                $content = $this->mainmodel->get_insuranceinfo_byid( $row['content_id'] );
            }else if( $row['content_type'] == 'articles' ){
                $category = $this->mainmodel->get_article_categoryinfo_byid( $row['category_id'] );
                $maincategory = $this->mainmodel->get_article_categoryinfo_byid( $category['main_id'] );
                $content = $this->mainmodel->get_articleinfo_byid( $row['content_id'] );
            }else if( $row['content_type'] == 'documents' ){
                $category = $this->mainmodel->get_document_categoryinfo_byid( $row['category_id'] );
                $content = $this->mainmodel->get_documentinfo_byid( $row['content_id'] );
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
        }else if( $row['content_type'] == 'external_link' ){
            $url = $row['map_external_url'];
        }else if( $row['content_type'] == 'internal_link'){
            $url = site_url( $row['map_internal_url'] );
        }else{
            $url = 'javascript:void(0);';
        }
        
        return '<a href="'.$url.'" target="_blank">'.$url.'</a>';
        
    }
    /* Default function -  End */

}