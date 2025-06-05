<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managecategory extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1d8bd8e6fde38fdd6e03c1103afdd9e2');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการบทความ",'icon-list-alt');

		$this->load->model('administrator/managecategory/managecategorymodel');
		$this->load->model('administrator/menu_model');
	}

	public function index($mainid=0, $offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('c968d3f91811914d4f308ee878f82a7a');
		
		if( $mainid > 0 ){
			$maincategory = $this->managecategorymodel->get_categoryinfo_byid( $mainid );
			$this->admin_model->set_detail('รายการหมวดหมู่ย่อยของ '.$maincategory['category_title_th'] );
		}else{
			$this->admin_model->set_detail('รายการหมวดหมู่');
		}
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managecategorymodel->get_categories($mainid, $perpage, $offset));
		$totalrows = $this->managecategorymodel->count_categories($mainid);
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มหมวดหมู่','managecategory/create/'.$mainid,'icon-plus','btn-success','w');
		if( $mainid > 0 ){
			$this->admin_model->set_top_button('กลับไปยังหมวดหมู่หลัก','managecategory/index','icon-undo','btn-primary','r');
		}
		
		$this->admin_model->set_column('category_id','ลำดับ','10%','icon-list-ol');
		if( $mainid > 0 ){
			$this->admin_model->set_column('main_id','หมวดหมู่หลัก','15%','icon-arrow-up');
		}
		$this->admin_model->set_column('category_title_th','ชื่อ','15%','icon-font');
		$this->admin_model->set_column('category_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('category_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไข','managecategory/update/[main_id]/[category_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managecategory/delete/[main_id]/[category_id]','icon-trash','btn-danger','d');
		if( $mainid > 0 ){
			$this->admin_model->set_action_button('จัดการบทความ','managearticle/index/[category_id]','icon-files-o','btn-inverse','r');
		}else{
			$this->admin_model->set_action_button('จัดการหมวดหมู่ย่อย','managecategory/index/[category_id]','icon-arrow-down','btn-default','r');
		}
		$this->admin_model->set_column_callback('category_id','show_seq');
		$this->admin_model->set_column_callback('main_id','show_maincategory');
		$this->admin_model->set_column_callback('category_title_th','show_title');
		$this->admin_model->set_column_callback('category_order','show_order');
		$this->admin_model->set_column_callback('category_status','show_status');
		$this->admin_model->set_pagination("managecategory/index/".$mainid,$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create( $mainid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
        $this->admin_model->set_menu_key('c968d3f91811914d4f308ee878f82a7a');
        $maincategory = $this->managecategorymodel->get_categoryinfo_byid( $mainid );
		if( $mainid > 0 ){
			$this->admin_model->set_detail('เพิ่มรายการหมวดหมู่ของ '.$maincategory['category_title_th'] );
		}else{
			$this->admin_model->set_detail('เพิ่มรายการหมวดหมู่');
		}
		$this->form_validation->set_rules('is_use_icon', 'ใช้ไอคอน','trim');
		if( $this->input->post('is_use_icon') && $this->input->post('is_use_icon') == 1 ){
			$this->form_validation->set_rules('category_icon','ไอคอน','trim|required');
		}
		$this->form_validation->set_rules('category_title_th','ชื่อหมวดหมู่ (ไทย)','trim|required');
        $this->form_validation->set_rules('category_title_en','ชื่อหมวดหมู่ (En)','trim|required');
		$this->form_validation->set_rules('category_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			if( $mainid > 0 ){
				$maincategory = $this->managecategorymodel->get_categoryinfo_byid( $mainid );
				$title = 'เพิ่มรายการหมวดหมู่ของ '.$maincategory['category_title_th'];
			}else{
				$title = 'เพิ่มรายการหมวดหมู่';
			}
			$this->admin_library->add_breadcrumb( $title,"managecategory/index/".$mainid,"icon-list-ol");
            $this->admin_library->add_breadcrumb("เพิ่มรายการหมวดหมู่","managecategory/create/".$mainid,"icon-plus");
            
            $this->_data['maincategory'] = $maincategory;
			
			$this->admin_library->view('managecategory/create', $this->_data);
			$this->admin_library->output();
			
		}else{
			$message = $this->managecategorymodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managecategory/index/'.$mainid);
		}
	}
	
	public function update( $mainid=0, $categoryid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
        $this->admin_model->set_menu_key('c968d3f91811914d4f308ee878f82a7a');
        $maincategory = $this->managecategorymodel->get_categoryinfo_byid( $mainid );
		if( $mainid > 0 ){
			$this->admin_model->set_detail('เพิ่มรายการหมวดหมู่ของ '.$maincategory['category_title_th'] );
		}else{
			$this->admin_model->set_detail('เพิ่มรายการหมวดหมู่');
		}
		
		$this->form_validation->set_rules('is_use_icon', 'ใช้ไอคอน','trim');
		if( $this->input->post('is_use_icon') && $this->input->post('is_use_icon') == 1 ){
			$this->form_validation->set_rules('category_icon','ไอคอน','trim|required');
		}
		$this->form_validation->set_rules('category_title_th','ชื่อหมวดหมู่ (ไทย)','trim|required');
        $this->form_validation->set_rules('category_title_en','ชื่อหมวดหมู่ (En)','trim|required');
        $this->form_validation->set_rules('category_meta_url','Meta URL','trim');
		$this->form_validation->set_rules('category_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_message('is_unique','"%s" ซ้ำกันในฐานข้อมูล');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			if( $mainid > 0 ){
				$maincategory = $this->managecategorymodel->get_categoryinfo_byid( $mainid );
				$title = 'แก้ไขรายการหมวดหมู่ของ '.$maincategory['category_title_th'];
			}else{
				$title = 'แก้ไขรายการหมวดหมู่';
			}
			$this->admin_library->add_breadcrumb( $title,"managecategory/index/".$mainid,"icon-list-ol");
            $this->admin_library->add_breadcrumb("เพิ่มรายการหมวดหมู่","managecategory/create/".$mainid,"icon-plus");
            
            $this->_data['maincategory'] = $maincategory;
            $this->_data['info'] = $this->managecategorymodel->get_categoryinfo_byid( $categoryid );
			
			$this->admin_library->view('managecategory/update', $this->_data);
			$this->admin_library->output();
			
		}else{

			$message = $this->managecategorymodel->update();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managecategory/index/'.$mainid);
		}
	}
	
	public function delete( $mainid=0, $categoryid=0 ){
		$message = $this->managecategorymodel->setStatus('discard', $categoryid);
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managecategory/index/'.$mainid);
	}
	
	public function setorder( $movement='up', $mainid=0, $categoryid=0 ){
        $message = $this->managecategorymodel->setOrder( $movement, $categoryid);
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managecategory/index/'.$mainid);
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_maincategory( $text, $row ){
		if( $text > 0 ){
			$maincategory = $this->managecategorymodel->get_categoryinfo_byid( $text );
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
		$text .= '(<a href="'.admin_url('managecategory/setorder/up/'.$row['main_id'].'/'.$row['category_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('managecategory/setorder/down/'.$row['main_id'].'/'.$row['category_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}
	/* Default function -  End */

}