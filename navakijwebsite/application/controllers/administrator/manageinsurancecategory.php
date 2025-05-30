<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageinsurancecategory extends CI_Controller {

    var $_data = array();
	var $seq;
    var $offset;
    
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('admin_library');
		$this->load->model('administrator/manageinsurancecategory/manageinsurancecategorymodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('2aa7829581f0044d116a6d8fad2a91fc');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("Manage Insurance",'icon-list-alt');
    }
    

    public function index($offset=0)
    {
        if(!$this->admin_model->check_permision("r")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
        $this->admin_model->set_detail('Categories');
        
        /* Get Data Table - Start */
		$perpage = 10;
		$this->offset = $offset;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->manageinsurancecategorymodel->get_categories($perpage, $offset));
		$totalrows = $this->manageinsurancecategorymodel->count_categories();
        /* Get Data Table - End */
        
        $this->admin_model->set_top_button('เพิ่มหมวดหมู่','manageinsurancecategory/create','icon-plus','btn-success','w');

        $this->admin_model->set_column('insurance_category_id','ลำดับ','10%','icon-list-ol');
        $this->admin_model->set_column('insurance_category_title_th','ชื่อหมวดหมู่','20%','icon-font');
        $this->admin_model->set_column('insurance_category_order','การจัดลำดับ','15%','icon-sort');
        $this->admin_model->set_column('insurance_category_status','สถานะการแสดงผล','25%','icon-eye-slash');
        $this->admin_model->set_action_button('แก้ไข','manageinsurancecategory/update/[insurance_category_id]','icon-pencil-square','btn-primary','w');
        $this->admin_model->set_action_button('ลบ','manageinsurancecategory/delete/[insurance_category_id]','icon-trash','btn-danger','d');
        $this->admin_model->set_action_button('จัดการประกันภัย','manageinsurance/index/[insurance_category_id]','icon-list-alt','btn-success','r');
        $this->admin_model->set_column_callback('insurance_category_id','show_seq');
        $this->admin_model->set_column_callback('insurance_category_title_th','show_title');
        $this->admin_model->set_column_callback('insurance_category_order','show_order');
        $this->admin_model->set_column_callback('insurance_category_status','show_status');

        $this->admin_model->set_pagination("manageinsurancecategory/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
    }

    public function create(){
        if(!$this->admin_model->check_permision("r")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
        $this->admin_model->set_detail('เพิ่มหมวดหมู่');

        $this->form_validation->set_rules('insurance_category_icon','ไอคอน','trim|required');
        $this->form_validation->set_rules('insurance_category_title_th','ชื่อหมวดหมู่ (ไทย)','trim|required');
        $this->form_validation->set_rules('insurance_category_title_en','ชื่อหมวดหมู่ (En)','trim|required');
        $this->form_validation->set_rules('insurance_category_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','"%s" is required.');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if( $this->form_validation->run() === false ){
            $this->admin_library->add_breadcrumb("รายการหมวดหมู่","manageinsurancecategory/index","icon-list");
            $this->admin_library->add_breadcrumb("เพิ่มหมวดหมู่","manageinsurancecategory/create","icon-plus");
            
            $this->admin_library->view('manageinsurancecategory/create', $this->_data);
			$this->admin_library->output();
        }else{
            $message = $this->manageinsurancecategorymodel->create();

            $this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageinsurancecategory/index');
        }
    }

    public function update( $insurance_categoryid=0 ){
        if(!$this->admin_model->check_permision("r")){
			show_error("Your permission is invalid.");
		}
		
		$this->admin_model->set_menu_key('76313661731d0f47fc5579f741b696be');
        $this->admin_model->set_detail('แก้ไขข้อมูลหมวดหมู่');

        $this->form_validation->set_rules('insurance_category_icon','ไอคอน','trim|required');
        $this->form_validation->set_rules('insurance_category_title_th','ชื่อหมวดหมู่ (ไทย)','trim|required');
        $this->form_validation->set_rules('insurance_category_title_en','ชื่อหมวดหมู่ (En)','trim|required');
        $this->form_validation->set_rules('insurance_category_meta_url','URL สำหรับ SEO','trim|required');
        $this->form_validation->set_rules('insurance_category_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','"%s" is required.');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if( $this->form_validation->run() === false ){
            $this->admin_library->add_breadcrumb("รายการหมวดหมู่","manageinsurancecategory/index","icon-list");
            $this->admin_library->add_breadcrumb("แก้ไขข้อมูล","manageinsurancecategory/update/".$insurance_categoryid,"icon-pencil-square");

            $this->_data['info'] = $this->manageinsurancecategorymodel->get_insurance_categoryinfo_byid( $insurance_categoryid );
            
            $this->admin_library->view('manageinsurancecategory/update', $this->_data);
			$this->admin_library->output();
        }else{
            $message = $this->manageinsurancecategorymodel->update( $insurance_categoryid );

            $this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageinsurancecategory/index');
        }
    }

    public function delete( $insurance_categoryid=0 ){
		$message = $this->manageinsurancecategorymodel->setStatus('discard', $insurance_categoryid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageinsurancecategory/index');
    }

    public function setorder( $movement='up', $insurance_categoryid=0 ){
        $message = $this->manageinsurancecategorymodel->setOrder( $movement, $insurance_categoryid );

        $this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageinsurancecategory/index');
    }
    
    /* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
    }
    
    public function show_title( $text, $row ){
        return $row['insurance_category_title_th'].' / '.$row['insurance_category_title_en'];
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
        $text .= '(<a href="'.admin_url('manageinsurancecategory/setorder/up/'.$row['insurance_category_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
        $text .= ' | ';
        $text .= '<a href="'.admin_url('manageinsurancecategory/setorder/down/'.$row['insurance_category_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
        return $text;
    }
    /* Default function -  End */
    
    public function debug(){
        $icons = $this->manageinsurancecategorymodel->get_icons();
        print_r( $icons );
    }

}

/* End of file manageinsurancecategory.php */
