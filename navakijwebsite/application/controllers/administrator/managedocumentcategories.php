<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managedocumentcategories extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managedocumentcategories/managedocumentcategoriesmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('2a6ec6243d5d491c9e32946fb1f2cf4b');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการเอกสารบริษัท",'icon-list-alt');
	}

	public function index($mainid=0, $offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('dc76a414f8c0968fe1eb984363cef907');
		
		if( $mainid > 0 ){
			$maincategory = $this->managedocumentcategoriesmodel->get_categoryinfo_byid( $mainid );
			$this->admin_model->set_detail('รายการหมวดหมู่เอกสารของ '.$maincategory['category_title_th'] );
		}else{
			$this->admin_model->set_detail('รายการหมวดหมู่เอกสาร');
		}
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managedocumentcategoriesmodel->get_categories($mainid, $perpage, $offset));
		$totalrows = $this->managedocumentcategoriesmodel->count_categories($mainid);
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มหมวดหมู่','managedocumentcategories/create/'.$mainid,'icon-plus','btn-success','w');
		if( $mainid > 0 ){
			$this->admin_model->set_top_button('กลับไปยังหมวดหมู่หลัก','managedocumentcategories/index','icon-undo','btn-primary','r');
		}
		
		$this->admin_model->set_column('category_id','ลำดับ','10%','icon-list-ol');
		if( $mainid > 0 ){
			$this->admin_model->set_column('main_id','หมวดหมู่หลัก','15%','icon-arrow-up');
		}
		$this->admin_model->set_column('category_title_th','ชื่อ','15%','icon-font');
		$this->admin_model->set_column('category_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('category_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไข','managedocumentcategories/update/[main_id]/[category_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managedocumentcategories/delete/[main_id]/[category_id]','icon-trash','btn-danger','d');
		if( $mainid > 0 ){
			$this->admin_model->set_action_button('จัดการเอกสาร','managedocuments/index/[category_id]','icon-files-o','btn-inverse','r');
		}else{
			$this->admin_model->set_action_button('จัดการหมวดหมู่ย่อย','managedocumentcategories/index/[category_id]','icon-arrow-down','btn-default','r');
		}
		$this->admin_model->set_column_callback('category_id','show_seq');
		$this->admin_model->set_column_callback('main_id','show_maincategory');
		$this->admin_model->set_column_callback('category_title_th','show_title');
		$this->admin_model->set_column_callback('category_order','show_order');
		$this->admin_model->set_column_callback('category_status','show_status');
		$this->admin_model->set_pagination("managedocumentcategories/index/".$mainid,$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create( $mainid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
        $this->admin_model->set_menu_key('dc76a414f8c0968fe1eb984363cef907');
        $maincategory = $this->managedocumentcategoriesmodel->get_categoryinfo_byid( $mainid );
		if( $mainid > 0 ){
			$this->admin_model->set_detail('เพิ่มรายการหมวดหมู่ของ '.$maincategory['category_title_th'] );
		}else{
			$this->admin_model->set_detail('เพิ่มรายการหมวดหมู่');
		}
		
		$this->form_validation->set_rules('category_title_th','ชื่อหมวดหมู่ (ไทย)','trim|required');
		$this->form_validation->set_rules('category_title_en','ชื่อหมวดหมู่ (En)','trim|required');
		$this->form_validation->set_rules('category_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			if( $mainid > 0 ){
				$maincategory = $this->managedocumentcategoriesmodel->get_categoryinfo_byid( $mainid );
				$title = 'เพิ่มรายการหมวดหมู่ของ '.$maincategory['category_title_th'];
			}else{
				$title = 'เพิ่มรายการหมวดหมู่';
			}
			$this->admin_library->add_breadcrumb( $title,"managedocumentcategories/index/".$mainid,"icon-list-ol");
            $this->admin_library->add_breadcrumb("เพิ่มรายการหมวดหมู่","managedocumentcategories/create/".$mainid,"icon-plus");
            
            $this->_data['maincategory'] = $maincategory;
			
			$this->admin_library->view('managedocumentcategories/create', $this->_data);
			$this->admin_library->output();
			
		}else{
			$message = $this->managedocumentcategoriesmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managedocumentcategories/index/'.$mainid);
		}
	}
	
	public function update( $mainid=0, $categoryid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
        $this->admin_model->set_menu_key('dc76a414f8c0968fe1eb984363cef907');
        $maincategory = $this->managedocumentcategoriesmodel->get_categoryinfo_byid( $mainid );
		if( $mainid > 0 ){
			$this->admin_model->set_detail('เพิ่มรายการหมวดหมู่ของ '.$maincategory['category_title_th'] );
		}else{
			$this->admin_model->set_detail('เพิ่มรายการหมวดหมู่');
		}
		
		$this->form_validation->set_rules('category_title_th','ชื่อหมวดหมู่ (ไทย)','trim|required');
		$this->form_validation->set_rules('category_title_en','ชื่อหมวดหมู่ (En)','trim|required');
		$this->form_validation->set_rules('category_meta_url','Meta URL','trim');
		$this->form_validation->set_rules('category_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			if( $mainid > 0 ){
				$maincategory = $this->managedocumentcategoriesmodel->get_categoryinfo_byid( $mainid );
				$title = 'แก้ไขรายการหมวดหมู่ของ '.$maincategory['category_title_th'];
			}else{
				$title = 'แก้ไขรายการหมวดหมู่';
			}
			$this->admin_library->add_breadcrumb( $title,"managedocumentcategories/index/".$mainid,"icon-list-ol");
            $this->admin_library->add_breadcrumb("เพิ่มรายการหมวดหมู่","managedocumentcategories/create/".$mainid,"icon-plus");
            
            $this->_data['maincategory'] = $maincategory;
            $this->_data['info'] = $this->managedocumentcategoriesmodel->get_categoryinfo_byid( $categoryid );
			
			$this->admin_library->view('managedocumentcategories/update', $this->_data);
			$this->admin_library->output();
			
		}else{
			$message = $this->managedocumentcategoriesmodel->update();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managedocumentcategories/index/'.$mainid);
		}
	}
	
	public function delete( $mainid=0, $categoryid=0 ){
		$message = $this->managedocumentcategoriesmodel->setStatus('discard', $categoryid);
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managedocumentcategories/index/'.$mainid);
	}
	
	public function setorder( $movement='up', $mainid=0, $categoryid=0 ){
        $message = $this->managedocumentcategoriesmodel->setOrder( $movement, $categoryid);
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managedocumentcategories/index/'.$mainid);
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_maincategory( $text, $row ){
		if( $text > 0 ){
			$maincategory = $this->managedocumentcategoriesmodel->get_categoryinfo_byid( $text );
			return $maincategory['category_title_th'];
		}
    }
    
    public function show_title( $text, $row ){
        return $text.' / '.$row['category_title_en'];
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
		$text .= '(<a href="'.admin_url('managedocumentcategories/setorder/up/'.$row['main_id'].'/'.$row['category_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('managedocumentcategories/setorder/down/'.$row['main_id'].'/'.$row['category_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}
	/* Default function -  End */

}