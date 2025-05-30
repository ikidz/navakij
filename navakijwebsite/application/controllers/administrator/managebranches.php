<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managebranches extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managebranches/managebranchesmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('95249f054e1caa96054bf35140e42d90');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการเครือข่ายสินไหมฯ",'icon-list-alt');
	}

	public function index( $categoryid=0, $offset=0 ){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		if( $categoryid <= 0 ){
			
			$message = array(
				'status' => 'message-warning',
				'text' => 'กรุณาเลือกประเภทเครือข่าย'
			);
			
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('managebranchcategories/index');
			
		}
		
		$category = $this->managebranchesmodel->get_categoryinfo_byid( $categoryid );
		
		$this->admin_model->set_menu_key('396b0cd364ca3e8cb1c9b55d6ab37913');
		$this->admin_model->set_detail('รายการเครือข่ายของ '.$category['category_title_th']);
		
		$this->admin_model->set_top_button('เพิ่มเครือข่าย','managebranches/create/'.$category['category_id'],'icon-plus','btn-success','w');
		$this->admin_model->set_top_button('กลับไปยังรายการประเภท','managebranchcategories/index','icon-undo','btn-primary','w');
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managebranchesmodel->get_branches($categoryid, $perpage, $offset));
		$totalrows = $this->managebranchesmodel->count_branches($categoryid);
		/* Get Data Table - End */
		
		$this->admin_model->set_column('branch_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('branch_image','รูปภาพ','15%','icon-picture-o');
		$this->admin_model->set_column('branch_title_th','ชื่อ','15%','icon-font');
		$this->admin_model->set_column('is_partner','บริษัทในเครือ','10%','icon-star');
		$this->admin_model->set_column('is_on_website','แสดงผลบนเว็บไซต์','10%','icon-laptop');
		$this->admin_model->set_column('is_on_pdf','แสดงผลบน PDF','10%','icon-file-pdf-o');
		$this->admin_model->set_column('branch_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managebranches/update/[category_id]/[branch_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managebranches/delete/[category_id]/[branch_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('branch_id','show_seq');
		$this->admin_model->set_column_callback('branch_image','show_thumbnail');
		$this->admin_model->set_column_callback('brnach_title_th','show_title');
		$this->admin_model->set_column_callback('is_partner','show_partner');
		$this->admin_model->set_column_callback('is_on_website','show_web_status');
		$this->admin_model->set_column_callback('is_on_pdf','show_pdf_status');
		$this->admin_model->set_column_callback('branch_status','show_status');
		$this->admin_model->set_pagination("managebranches/index/".$category['category_id'],$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create( $categoryid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('396b0cd364ca3e8cb1c9b55d6ab37913');
		$this->admin_model->set_detail('เพิ่มรายการเครือข่าย');
		
		$category = $this->managebranchesmodel->get_categoryinfo_byid( $categoryid );
		
		$this->form_validation->set_rules('branch_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('branch_title_en','ชื่อ (En)','trim');
		$this->form_validation->set_rules('branch_tel','เบอร์โทรศัพท์','trim|required');
		$this->form_validation->set_rules('branch_fax','เบอร์โทรสาร','trim');
		$this->form_validation->set_rules('branch_email','อีเมลติดต่อ','trim|valid_email');
		$this->form_validation->set_rules('branch_website','เว็บไซต์','trim');
        $this->form_validation->set_rules('branch_address','ที่อยู่','trim|required');
        $this->form_validation->set_rules('province_id', 'จังหวัด','trim|required');
        $this->form_validation->set_rules('district_id', 'อำเภอ/เขต','trim|required');
        $this->form_validation->set_rules('subdistrict_id', 'ตำบล/แขวง','trim|required');
        $this->form_validation->set_rules('is_partner','อยู่ในเครือ','trim');
		$this->form_validation->set_rules('branch_lat','Latitude','trim');
		if( $this->input->post('branch_lat') != '' ){
			$this->form_validation->set_rules('branch_lng','Longitude','trim|required');
		}else{
			$this->form_validation->set_rules('branch_lng','Longitude','trim');
		}
		$this->form_validation->set_rules('branch_gmap_url','Google Map URL','trim');
		$this->form_validation->set_rules('branch_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_message('valid_email','"%s" มีรูปแบบไม่ถูกต้อง');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการเครือข่าย","managebranches/index/".$category['category_id'],"icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มเครือข่าย","managebranches/create/".$category['category_id'],"icon-plus");
			
            $this->_data['category'] = $category;
            $this->_data['provinces'] = $this->managebranchesmodel->get_provinces();
			
			$this->admin_library->view('managebranches/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managebranchesmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managebranches/index/'.$category['category_id']);
		}
	}
	
	public function update( $categoryid=0, $branchid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('396b0cd364ca3e8cb1c9b55d6ab37913');
		$this->admin_model->set_detail('แก้ไขรายการเครือข่าย');
		
		$category = $this->managebranchesmodel->get_categoryinfo_byid( $categoryid );
		$info = $this->managebranchesmodel->get_branchinfo_byid( $branchid );
		
		$this->form_validation->set_rules('branch_title_th','ชื่อ (ไทย)','trim|required');
		$this->form_validation->set_rules('branch_title_en','ชื่อ (En)','trim');
		$this->form_validation->set_rules('branch_tel','เบอร์โทรศัพท์','trim|required');
		$this->form_validation->set_rules('branch_fax','เบอร์โทรสาร','trim');
		$this->form_validation->set_rules('branch_email','อีเมลติดต่อ','trim|valid_email');
		$this->form_validation->set_rules('branch_website','เว็บไซต์','trim');
        $this->form_validation->set_rules('branch_address','ที่อยู่','trim|required');
        $this->form_validation->set_rules('province_id', 'จังหวัด','trim|required');
        $this->form_validation->set_rules('district_id', 'อำเภอ/เขต','trim|required');
        $this->form_validation->set_rules('subdistrict_id', 'ตำบล/แขวง','trim|required');
        $this->form_validation->set_rules('is_partner','อยู่ในเครือ','trim');
		$this->form_validation->set_rules('branch_lat','Latitude','trim');
		if( $this->input->post('branch_lat') != '' ){
			$this->form_validation->set_rules('branch_lng','Longitude','trim|required');
		}else{
			$this->form_validation->set_rules('branch_lng','Longitude','trim');
		}
		$this->form_validation->set_rules('branch_gmap_url','Google Map URL','trim');
		$this->form_validation->set_rules('branch_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_message('valid_email','"%s" มีรูปแบบไม่ถูกต้อง');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการเครือข่าย","managebranches/index/".$category['category_id'],"icon-list-ol");
            $this->admin_library->add_breadcrumb("แก้ไขเครือข่าย","managebranches/update/".$category['category_id'].'/'.$info['branch_id'],"icon-pencil-square-o");
            
            $this->_data['category'] = $category;
            $this->_data['info'] = $info;
            $this->_data['provinces'] = $this->managebranchesmodel->get_provinces();
            $this->_data['districts'] = ( $info['province_id'] > 0 ? $this->managebranchesmodel->get_districts( $info['province_id'] ) : array() );
            $this->_data['subdistricts'] = ( $info['district_id'] > 0 ? $this->managebranchesmodel->get_subdistricts( $info['district_id'] ) : array() );
			
			$this->admin_library->view('managebranches/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managebranchesmodel->update();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managebranches/index/'.$category['category_id']);
		}
    }
    
    public function delete( $categoryid=0, $branchid=0 ){
        $message = $this->managebranchesmodel->setStatus('discard', $branchid);
        $this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('managebranches/index/'.$categoryid);
    }

	public function uploadbulk($offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('396b0cd364ca3e8cb1c9b55d6ab37913');
		$this->admin_model->set_detail('รายการอัพโหลด');

		

		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managebranchesmodel->get_branch_bulks($perpage, $offset));
		$totalrows = $this->managebranchesmodel->count_branch_bulks();
		/* Get Data Table - End */

	}

	public function setDisplayStatus( $type='web', $setto=0, $categoryid=0, $branchid=0 ){
		$message = $this->managebranchesmodel->setDisplayStatus( $type, $setto, $branchid );
		$this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('managebranches/index/'.$categoryid);
	}

    /* APIs - Start */
    public function get_districts(){
        $provinceid = $this->input->post('province_id');
        $this->_data['districts'] = $this->managebranchesmodel->get_districts( $provinceid );
        $this->load->view('administrator/views/managebranches/api/districts', $this->_data);
    }

    public function get_subdistricts(){
        $districtid = $this->input->post('district_id');
        $this->_data['subdistricts'] = $this->managebranchesmodel->get_subdistricts( $districtid );
        $this->load->view('administrator/views/managebranches/api/subdistricts', $this->_data);
    }
    /* APIs - End */

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }

    public function show_thumbnail($text, $row){
        if($text!=''){
            return '<a href="'.base_url('public/core/uploaded/branches/'.$text).'" class="fancybox-button"><img src="'.base_url('public/core/uploaded/branches/'.$text).'" alt="" style="width:150px;" /></a>';
        }else{
            return 'ไม่มีรูปภาพแสดง';
        }
    }

    public function show_title( $text, $row ){
        return $text.' / '.$row['branch_title_en'];
    }

    public function show_partner( $text, $row ){
        if( $text == 1 ){
            return '<i class="icon-star"></i>';
        }
    }

	public function show_web_status( $text, $row ){
		$type = 'web';
		if( $text == 1 ){
			return '
				<p style="text-align:center;"><span class="label label-success"><i class="icon-check"></i></span></p>
				<p style="text-align:center;">[ <a href="'.admin_url('managebranches/setDisplayStatus/'.$type.'/0/'.$row['category_id'].'/'.$row['branch_id']).'">ปิดแสดงผล</a> ]</p>
			';
		}else{
			return '
				<p style="text-align:center;"><span class="label label-inverse"><i class="icon-times"></i></span></p>
				<p style="text-align:center;">[ <a href="'.admin_url('managebranches/setDisplayStatus/'.$type.'/1/'.$row['category_id'].'/'.$row['branch_id']).'">เปิดแสดงผล</a> ]</p>
			';
		}
	}

	public function show_pdf_status( $text, $row ){
		$type = 'pdf';
		if( $text == 1 ){
			return '
				<p style="text-align:center;"><span class="label label-success"><i class="icon-check"></i></span></p>
				<p style="text-align:center;">[ <a href="'.admin_url('managebranches/setDisplayStatus/'.$type.'/0/'.$row['category_id'].'/'.$row['branch_id']).'">ปิดแสดงผล</a> ]</p>
			';
		}else{
			return '
				<p style="text-align:center;"><span class="label label-inverse"><i class="icon-times"></i></span></p>
				<p style="text-align:center;">[ <a href="'.admin_url('managebranches/setDisplayStatus/'.$type.'/1/'.$row['category_id'].'/'.$row['branch_id']).'">เปิดแสดงผล</a> ]</p>
			';
		}
	}

    public function show_status($text, $row){
        switch($text){
            case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
            case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
            default : return 'ไม่มีสถานะ';
        }
    }
    /* Default function -  End */

}