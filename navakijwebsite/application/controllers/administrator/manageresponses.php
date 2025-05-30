<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageresponses extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageresponses/manageresponsesmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('e7a5758a3611bdd6e94dc9fe4bb53743');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการหน้า Call out",'icon-list-alt');
	}

	public function index($offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('b6de1967fa938007cef7548f80fb128c');
		$this->admin_model->set_detail('รายการ Call out');
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->manageresponsesmodel->get_responses($perpage, $offset));
		$totalrows = $this->manageresponsesmodel->count_responses();
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มรายการ Call out','manageresponses/create','icon-plus','btn-success','w');
		
		$this->admin_model->set_column('response_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('response_image','รูปภาพ','15%','icon-picture-o');
		$this->admin_model->set_column('response_title_th','หัวข้อ','15%','icon-font');
        $this->admin_model->set_column('response_createdtime', 'URL','15%','icon-link');
		$this->admin_model->set_column('response_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','manageresponses/update/[response_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','manageresponses/delete/[response_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('response_id','show_seq');
		$this->admin_model->set_column_callback('response_image','show_thumbnail');
        $this->admin_model->set_column_callback('response_createdtime','show_url');
		$this->admin_model->set_column_callback('response_status','show_status');
		$this->admin_model->set_pagination("manageresponses/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
		
	}
	
	public function create(){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('b6de1967fa938007cef7548f80fb128c');
		$this->admin_model->set_detail('เพิ่มรายการ Call out');
		
		$this->form_validation->set_rules('response_title_th','หัวข้อ (ไทย)','trim|required');
		$this->form_validation->set_rules('response_title_en','หัวข้อ (En)','trim');
		$this->form_validation->set_rules('response_caption_th','ข้อความ (ไทย)','trim');
		$this->form_validation->set_rules('response_caption_en','ข้อความ (En)','trim');
        $this->form_validation->set_rules('response_remark_th', 'หมายเหตุ (ไทย)','trim');
        $this->form_validation->set_rules('response_remark_en', 'หมายเหตุ (En)','trim');
        $this->form_validation->set_rules('response_button_1_url','URL ปุ่มที่ 1','trim');
        if( $this->input->post('response_button_1_url') != '' ){
            $this->form_validation->set_rules('response_button_1_label_th','ข้อความของปุ่ม 1','trim|required');
            $this->form_validation->set_rules('response_button_1_label_en','ข้อความของปุ่ม 1','trim|required');
        }else{
            $this->form_validation->set_rules('response_button_1_label_th','ข้อความของปุ่ม 1','trim');
            $this->form_validation->set_rules('response_button_1_label_en','ข้อความของปุ่ม 1','trim');
        }
        $this->form_validation->set_rules('response_button_2_url','URL ปุ่มที่ 2','trim');
        if( $this->input->post('response_button_2_url') != '' ){
            $this->form_validation->set_rules('response_button_2_label_th','ข้อความของปุ่ม 2','trim|required');
            $this->form_validation->set_rules('response_button_2_label_en','ข้อความของปุ่ม 2','trim|required');
        }else{
            $this->form_validation->set_rules('response_button_2_label_th','ข้อความของปุ่ม 2','trim');
            $this->form_validation->set_rules('response_button_2_label_en','ข้อความของปุ่ม 2','trim');
        }
		$this->form_validation->set_rules('response_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการ Call out","manageresponses/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการ Call out","manageresponses/create","icon-plus");
			
			$this->admin_library->view('manageresponses/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->manageresponsesmodel->create();
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageresponses/index');
		}
	}
	
	public function update( $responseid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('b6de1967fa938007cef7548f80fb128c');
		$this->admin_model->set_detail('แก้ไขรายการ Call out');
		
		$this->form_validation->set_rules('response_title_th','หัวข้อ (ไทย)','trim|required');
		$this->form_validation->set_rules('response_title_en','หัวข้อ (En)','trim');
		$this->form_validation->set_rules('response_caption_th','ข้อความ (ไทย)','trim');
		$this->form_validation->set_rules('response_caption_en','ข้อความ (En)','trim');
        $this->form_validation->set_rules('response_remark_th', 'หมายเหตุ (ไทย)','trim');
        $this->form_validation->set_rules('response_remark_en', 'หมายเหตุ (En)','trim');
        $this->form_validation->set_rules('response_button_1_url','URL ปุ่มที่ 1','trim');
        if( $this->input->post('response_button_1_url') != '' ){
            $this->form_validation->set_rules('response_button_1_label_th','ข้อความของปุ่ม 1','trim|required');
            $this->form_validation->set_rules('response_button_1_label_en','ข้อความของปุ่ม 1','trim|required');
        }else{
            $this->form_validation->set_rules('response_button_1_label_th','ข้อความของปุ่ม 1','trim');
            $this->form_validation->set_rules('response_button_1_label_en','ข้อความของปุ่ม 1','trim');
        }
        $this->form_validation->set_rules('response_button_2_url','URL ปุ่มที่ 2','trim');
        if( $this->input->post('response_button_2_url') != '' ){
            $this->form_validation->set_rules('response_button_2_label_th','ข้อความของปุ่ม 2','trim|required');
            $this->form_validation->set_rules('response_button_2_label_en','ข้อความของปุ่ม 2','trim|required');
        }else{
            $this->form_validation->set_rules('response_button_2_label_th','ข้อความของปุ่ม 2','trim');
            $this->form_validation->set_rules('response_button_2_label_en','ข้อความของปุ่ม 2','trim');
        }
		$this->form_validation->set_rules('response_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการ Call out","manageresponses/index","icon-list-ol");
			$this->admin_library->add_breadcrumb("แก้ไขรายการ Call out","manageresponses/create","icon-plus");
			
			$this->_data['info'] = $this->manageresponsesmodel->get_responseinfo_byid( $responseid );
			
			$this->admin_library->view('manageresponses/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->manageresponsesmodel->update( $responseid );
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('manageresponses/index');
		}
	}
	
	public function delete( $setto='approved', $responseid=0 ){
		
		$message = array();
		$message = $this->manageresponsesmodel->setStatus( $setto, $responseid );
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('manageresponses/index');
		
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_thumbnail($text, $row){
		if($text!=''){
			return '<a href="'.base_url('public/core/uploaded/responses/'.$row['response_image']).'" class="fancybox-button"><img src="'.base_url('public/core/uploaded/responses/'.$row['response_image']).'" alt="" style="width:80px;" /></a>';
		}else{
			return 'ไม่มีรูปภาพแสดง';
		}
	}

    public function show_url( $text, $row ){
		$response = 'TH : <a href="'.site_url('th/response/'.$row['response_id'],false).'" target="_blank">'.site_url('th/response/'.$row['response_id'],false).'</a><br />';
		$response .= 'EN : <a href="'.site_url('en/response/'.$row['response_id'],false).'" target="_blank">'.site_url('en/response/'.$row['response_id'],false).'</a>';
        return $response;
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