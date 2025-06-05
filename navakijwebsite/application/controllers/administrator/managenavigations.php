<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managenavigations extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managenavigations/managenavigationsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('3657c88b6cec0acb0086688fa1462cc0');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการเมนูเว็บไซต์",'icon-list-alt');
	}

	public function index($mainid=0, $offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('941ebe9d4e51818dd4c8ee4a478417a0');
		$mainNav = $this->managenavigationsmodel->get_navigationinfo_byid( $mainid );
		if( isset( $mainNav ) && count( $mainNav ) > 0 ){
			$this->admin_model->set_detail('รายการเมนูย่อยของ '.$mainNav['nav_title_th']);
		}else{
			$this->admin_model->set_detail('รายการเมนู');
		}
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managenavigationsmodel->get_navigations($mainid, $perpage, $offset));
		$totalrows = $this->managenavigationsmodel->count_navigations($mainid);
		
		$this->admin_model->set_top_button('เพิ่มเมนูเว็บไซต์','managenavigations/create/'.$mainid,'icon-plus','btn-success','w');
		if( isset( $mainNav ) && count( $mainNav ) > 0 ){
			$this->admin_model->set_top_button('กลับไปยังเมนูหลักเว็บไซต์','managenavigations/index','icon-undo','btn-primary','r');
		}
		/* Get Data Table - End */
		
		$this->admin_model->set_column('nav_id','ลำดับ','15%','icon-list-ol');
		if( isset( $mainNav ) && count( $mainNav ) > 0 ){
			$this->admin_model->set_column('main_id','เมนูหลัก','15%','icon-tags');
		}
		$this->admin_model->set_column('nav_title_th','ชื่อ','15%','icon-font');
		$this->admin_model->set_column('nav_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('nav_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไข','managenavigations/update/[main_id]/[nav_id]','icon-pencil-square','btn-primary','w');
        $this->admin_model->set_action_button('ลบข้อมูล','managenavigations/delete/[main_id]/[nav_id]','icon-trash','btn-danger','d');
        $this->admin_model->set_action_button('จัดการเมนูย่อย','managenavigations/index/[nav_id]','icon-hand-o-down','btn-default','r');
		$this->admin_model->set_column_callback('nav_id','show_seq');
		$this->admin_model->set_column_callback('main_id','show_mainNav');
		$this->admin_model->set_column_callback('nav_title_th','show_title');
		$this->admin_model->set_column_callback('nav_order','show_order');
		$this->admin_model->set_column_callback('nav_status','show_status');
		
		$this->admin_model->set_pagination("managenavigations/index/".$mainid,$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
		
	}
	
	public function create( $mainid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('941ebe9d4e51818dd4c8ee4a478417a0');
		$this->admin_model->set_detail('เพิ่มรายการเมนูเว็บไซต์');
		
        $this->form_validation->set_rules('main_id','เมนูหลัก','trim');
        $this->form_validation->set_rules('content_type','ประเภทของเมนู','trim|required');
        if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
            $this->form_validation->set_rules('category_id','หมวดหมู่ของเนื้อหา','trim|required');
        }else{
            $this->form_validation->set_rules('category_id','หมวดหมู่ของเนื้อหา','trim');
        }
        $this->form_validation->set_rules('content_id','เนื้อหา','trim');
		$this->form_validation->set_rules('nav_title_th','ชื่อเมนู (ไทย)','trim|required');
        $this->form_validation->set_rules('nav_title_en','ชื่อเมนู (En)','trim|required');
        if( $this->input->post('content_type') == 'external_link' ){
            $this->form_validation->set_rules('nav_external_url', 'URL','trim|required');
        }else{
            $this->form_validation->set_rules('nav_external_url', 'URL','trim');
        }
        if( $this->input->post('content_type') == 'internal_link' ){
            $this->form_validation->set_rules('nav_internal_url','URL','trim|required');
        }else{
            $this->form_validation->set_rules('nav_internal_url','URL','trim');
        }
        $this->form_validation->set_rules('is_newtab','เปิดแท็บใหม่','trim');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการเมนูเว็บไซต์","managenavigations/index/".$mainid,"icon-list-ol");
            $this->admin_library->add_breadcrumb("เพิ่มรายการเมนูเว็บไซต์","managenavigations/create/".$mainid,"icon-plus");

            $this->_data['mainid'] = $mainid;
            $this->_data['static_pages'] = $this->managenavigationsmodel->get_static_pages();
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

            $this->admin_library->view('managenavigations/create', $this->_data);
            $this->admin_library->output();
		}else{
			$message = $this->managenavigationsmodel->create();
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managenavigations/index/'.$mainid);
		}
    }
    
    public function update( $mainid=0, $navid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('941ebe9d4e51818dd4c8ee4a478417a0');
		$this->admin_model->set_detail('แก้ไขรายการเมนูเว็บไซต์');
		
        $this->form_validation->set_rules('main_id','เมนูหลัก','trim');
        $this->form_validation->set_rules('content_type','ประเภทของเมนู','trim|required');
        if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
            $this->form_validation->set_rules('category_id','หมวดหมู่ของเนื้อหา','trim|required');
        }else{
            $this->form_validation->set_rules('category_id','หมวดหมู่ของเนื้อหา','trim');
        }
        $this->form_validation->set_rules('content_id','เนื้อหา','trim');
		$this->form_validation->set_rules('nav_title_th','ชื่อเมนู (ไทย)','trim|required');
        $this->form_validation->set_rules('nav_title_en','ชื่อเมนู (En)','trim|required');
        if( $this->input->post('content_type') == 'external_link' ){
            $this->form_validation->set_rules('nav_external_url', 'URL','trim|required');
        }else{
            $this->form_validation->set_rules('nav_external_url', 'URL','trim');
        }
        if( $this->input->post('content_type') == 'internal_link' ){
            $this->form_validation->set_rules('nav_internal_url','URL','trim|required');
        }else{
            $this->form_validation->set_rules('nav_internal_url','URL','trim');
        }
        $this->form_validation->set_rules('is_newtab','เปิดแท็บใหม่','trim');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการเมนูเว็บไซต์","managenavigations/index/".$mainid,"icon-list-ol");
            $this->admin_library->add_breadcrumb("เพิ่มรายการเมนูเว็บไซต์","managenavigations/create/".$mainid,"icon-plus");

            $info = $this->managenavigationsmodel->get_navigationinfo_byid( $navid );

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
            $this->_data['static_pages'] = $this->managenavigationsmodel->get_static_pages();
            $this->_data['contentType'] = ( $this->input->post('content_type') ? $this->input->post('content_type') : $info['content_type'] );

            $this->admin_library->view('managenavigations/update', $this->_data);
            $this->admin_library->output();
		}else{
			$message = $this->managenavigationsmodel->update();
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managenavigations/index/'.$mainid);
		}
    }
    
    public function delete( $mainid=0, $navid=0 ){
        $message = $this->managenavigationsmodel->setStatus( 'discard', $navid );

        $this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('managenavigations/index/'.$mainid);
    }

    public function setorder( $movement='up', $mainid=0, $navid=0 ){
        $message = $this->managenavigationsmodel->setOrder( $movement, $navid );

        $this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('managenavigations/index/'.$mainid);
    }

    public function get_categories( $type = 'articles', $controllerUse = false ){
        $this->_data['categories'] = array();
        if( $type == 'articles' ){
            $this->_data['settings'] = array(
                'category_type' => 'articles',
                'has_sub' => 1
            );
            $this->_data['categories'] = $this->managenavigationsmodel->get_article_categories();
        }else if( $type == 'insurance' ){
            $this->_data['settings'] = array(
                'category_type' => 'insurance',
                'has_sub' => 0
            );
            $this->_data['categories'] = $this->managenavigationsmodel->get_insurance_categories();
        }else if( $type == 'documents' ){
            $this->_data['settings'] = array(
                'category_type' => 'documents',
                'has_sub' => 1
            );
            $this->_data['categories'] = $this->managenavigationsmodel->get_document_categories();
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
            $this->load->view('administrator/views/managenavigations/api/categories', $this->_data);
        }
    }

    public function get_contents( $type = 'articles', $categoryid=0, $controllerUse = false ){
        $this->_data['contents'] = array();
        if( $type == 'articles' ){
            $this->_data['contents'] = $this->managenavigationsmodel->get_articles( $categoryid );
        }else if( $type == 'insurance' ){
            $this->_data['contents'] = $this->managenavigationsmodel->get_insurances( $categoryid );
        }else if( $type == 'documents' ){
            $this->_data['contents'] = $this->managenavigationsmodel->get_documents( $categoryid );
        }

        if( $controllerUse === true ){
            return $this->_data['contents'];
        }else{
            $this->load->view('administrator/views/managenavigations/api/contents', $this->_data);
        }
    }

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }

    public function show_mainNav( $text, $row ){
        $navigation = $this->managenavigationsmodel->get_navigationinfo_byid( $text );
        return $navigation['nav_title_th'];
    }

    public function show_title( $text, $row ){
        return $text.' / '.$row['nav_title_en'];
    }

    public function show_status($text, $row){
        switch($text){
            case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
            case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
            default : return 'ไม่มีสถานะ';
        }
    }

    public function show_order($text, $row){
        $text = $text.' ';
        $text .= '(<a href="'.admin_url('managenavigations/setorder/up/'.$row['main_id'].'/'.$row['nav_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
        $text .= ' | ';
        $text .= '<a href="'.admin_url('managenavigations/setorder/down/'.$row['main_id'].'/'.$row['nav_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
        return $text;
    }
    /* Default function -  End */

}