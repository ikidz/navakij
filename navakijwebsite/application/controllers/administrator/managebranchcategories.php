<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managebranchcategories extends CI_Controller {

    var $_data = array();
	var $seq;
    var $offset;
    
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('admin_library');
		$this->load->model('administrator/managebranchcategories/managebranchcategoriesmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('95249f054e1caa96054bf35140e42d90');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการเครือข่ายสินไหมฯ",'icon-list-alt');
    }
    

    public function index($offset=0)
    {
        if(!$this->admin_model->check_permision("r")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('396b0cd364ca3e8cb1c9b55d6ab37913');
        $this->admin_model->set_detail('รายการประเภทเครือข่าย');
        
        /* Get Data Table - Start */
		$perpage = 10;
		$this->offset = $offset;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managebranchcategoriesmodel->get_categories($perpage, $offset));
		$totalrows = $this->managebranchcategoriesmodel->count_categories();
        /* Get Data Table - End */
        
        $this->admin_model->set_top_button('เพิ่มประเภทเครือข่าย','managebranchcategories/create','icon-plus','btn-success','w');

        $this->admin_model->set_column('category_id','ลำดับ','10%','icon-list-ol');
        $this->admin_model->set_column('category_title_th','ชื่อหมวดหมู่','20%','icon-font');
        $this->admin_model->set_column('category_order','การจัดลำดับ','15%','icon-sort');
        $this->admin_model->set_column('category_status','สถานะการแสดงผล','25%','icon-eye-slash');
        $this->admin_model->set_action_button('แก้ไข','managebranchcategories/update/[category_id]','icon-pencil-square','btn-primary','w');
        $this->admin_model->set_action_button('ลบ','managebranchcategories/delete/[category_id]','icon-trash','btn-danger','d');
        $this->admin_model->set_action_button('จัดการเครือข่าย','managebranches/index/[category_id]','icon-list-alt','btn-success','r');
        $this->admin_model->set_column_callback('category_id','show_seq');
        $this->admin_model->set_column_callback('category_title_th','show_title');
        $this->admin_model->set_column_callback('category_order','show_order');
        $this->admin_model->set_column_callback('category_status','show_status');

        $this->admin_model->set_pagination("managebranchcategories/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
    }

    public function create(){
        if(!$this->admin_model->check_permision("r")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('396b0cd364ca3e8cb1c9b55d6ab37913');
        $this->admin_model->set_detail('เพิ่มประเภทเครือข่าย');

        $this->form_validation->set_rules('category_title_th','ชื่อหมวดหมู่ (ไทย)','trim|required');
        $this->form_validation->set_rules('category_title_en','ชื่อหมวดหมู่ (En)','trim|required');
        $this->form_validation->set_rules('category_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','"%s" is required.');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if( $this->form_validation->run() === false ){
            $this->admin_library->add_breadcrumb("รายการหมวดหมู่","managebranchcategories/index","icon-list");
            $this->admin_library->add_breadcrumb("เพิ่มหมวดหมู่","managebranchcategories/create","icon-plus");
            
            $this->admin_library->view('managebranchcategories/create', $this->_data);
			$this->admin_library->output();
        }else{
            $message = $this->managebranchcategoriesmodel->create();

            $this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managebranchcategories/index');
        }
    }

    public function update( $categoryid=0 ){
        if(!$this->admin_model->check_permision("r")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('396b0cd364ca3e8cb1c9b55d6ab37913');
        $this->admin_model->set_detail('แก้ไขประเภทเครือข่าย');

        $this->form_validation->set_rules('category_title_th','ชื่อหมวดหมู่ (ไทย)','trim|required');
        $this->form_validation->set_rules('category_title_en','ชื่อหมวดหมู่ (En)','trim|required');
        $this->form_validation->set_rules('category_meta_url','URL สำหรับ SEO','trim|required');
        $this->form_validation->set_rules('category_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','"%s" is required.');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if( $this->form_validation->run() === false ){
            $this->admin_library->add_breadcrumb("รายการหมวดหมู่","managebranchcategories/index","icon-list");
            $this->admin_library->add_breadcrumb("แก้ไขข้อมูล","managebranchcategories/update/".$categoryid,"icon-pencil-square");

            $this->_data['info'] = $this->managebranchcategoriesmodel->get_categoryinfo_byid( $categoryid );
            
            $this->admin_library->view('managebranchcategories/update', $this->_data);
			$this->admin_library->output();
        }else{
            $message = $this->managebranchcategoriesmodel->update( $categoryid );

            $this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managebranchcategories/index');
        }
    }

    public function delete( $categoryid=0 ){
		$message = $this->managebranchcategoriesmodel->setStatus('discard', $categoryid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managebranchcategories/index');
    }

    public function setorder( $movement='up', $categoryid=0 ){
        $message = $this->managebranchcategoriesmodel->setOrder( $movement, $categoryid );

        $this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managebranchcategories/index');
    }
    
    /* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
    }
    
    public function show_title( $text, $row ){
        return $row['category_title_th'].' / '.$row['category_title_en'];
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
        $text .= '(<a href="'.admin_url('managebranchcategories/setorder/up/'.$row['category_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
        $text .= ' | ';
        $text .= '<a href="'.admin_url('managebranchcategories/setorder/down/'.$row['category_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
        return $text;
    }
	/* Default function -  End */

}

/* End of file managebranchcategories.php */
