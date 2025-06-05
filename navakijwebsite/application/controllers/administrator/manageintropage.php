<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Manageintropage extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/manageintropage/manageintropagemodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('b2cd5403d4566368e2fa59602dbad456');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("การจัดการ Popup Special Day",'icon-list-alt');
	}

	public function index($offset=0){
        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('0474d0b6d051c3f09481bb07c62c5590');
        $this->admin_model->set_detail('รายการ Popup');

        /* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->manageintropagemodel->get_intropages($perpage, $offset));
		$totalrows = $this->manageintropagemodel->count_intropages();
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่ม Popup ใหม่','manageintropage/create','icon-plus','btn-success','w');
		
		$this->admin_model->set_column('intro_id','ลำดับ','10%','icon-list');
		$this->admin_model->set_column('intro_type','ประเภท','15%','icon-star');
		$this->admin_model->set_column('intro_value','มีเดีย','15%','icon-star');
		$this->admin_model->set_column('intro_title','ชื่อ Popup','20%','icon-font');
		$this->admin_model->set_column('intro_start_date','ช่วงการแสดงผล','15%','icon-calendar');
		$this->admin_model->set_column('intro_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_column_callback('intro_id','show_seq');
		$this->admin_model->set_column_callback('intro_type','show_type');
		$this->admin_model->set_column_callback('intro_value','show_image');
		$this->admin_model->set_column_callback('intro_start_date','show_period');
		$this->admin_model->set_column_callback('intro_status','show_status');
		$this->admin_model->set_action_button('แก้ไข','manageintropage/update/[intro_id]','icon-pencil-square-o','btn-success','w');
		$this->admin_model->set_action_button('ลบข้อมูล','manageintropage/setstatus/discard/[intro_id]','icon-trash','btn-danger','d');
		
		$this->admin_model->set_pagination("manageintropage/index",$totalrows,$perpage,4);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
    }
    
    public function create(){
        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('0474d0b6d051c3f09481bb07c62c5590');
        $this->admin_model->set_detail('รายการ Popup');

        $this->form_validation->set_rules('intro_type','ประเภทของมีเดีย','trim|required');
        if( $this->input->post('intro_type') == 'youtube' ){
            $this->form_validation->set_rules('intro_value','มีเดีย','trim|required');
        }
        $this->form_validation->set_rules('intro_url','ลิงก์ไปยัง','trim');
        $this->form_validation->set_rules('intro_title','ชื่อ Popup','trim|required');
        $this->form_validation->set_rules('intro_start_date','วันที่เริ่มต้น','trim|required');
        $this->form_validation->set_rules('intro_end_date','วันที่สิ้นสุด','trim');
        $this->form_validation->set_rules('intro_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            $this->admin_library->add_breadcrumb("รายการ Popup","manageintropage/index","icon-list");
            $this->admin_library->add_breadcrumb("เพิ่ม Popup ใหม่","manageintropage/create","icon-plus");
            
            $this->admin_library->view('manageintropage/create', $this->_data);
			$this->admin_library->output();
        }else{
            $message = $this->manageintropagemodel->create();
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageintropage/index');
        }
    }

    public function update($introid=0){
        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('0474d0b6d051c3f09481bb07c62c5590');
        $this->admin_model->set_detail('รายการ Popup');

        $this->form_validation->set_rules('intro_type','ประเภทของมีเดีย','trim|required');
        if( $this->input->post('intro_type') == 'youtube' ){
            $this->form_validation->set_rules('intro_value','มีเดีย','trim|required');
        }
        $this->form_validation->set_rules('intro_url','ลิงก์ไปยัง','trim');
        $this->form_validation->set_rules('intro_title','ชื่อ Popup','trim|required');
        $this->form_validation->set_rules('intro_start_date','วันที่เริ่มต้น','trim|required');
        $this->form_validation->set_rules('intro_end_date','วันที่สิ้นสุด','trim');
        $this->form_validation->set_rules('intro_status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');

        if($this->form_validation->run()===FALSE){
            $this->admin_library->add_breadcrumb("รายการ Popup","manageintropage/index","icon-list");
            $this->admin_library->add_breadcrumb("แก้ไขข้อมูล Popup","manageintropage/update/".$introid,"icon-plus");

            $this->_data['info'] = $this->manageintropagemodel->get_introinfo_byid( $introid );
            
            $this->admin_library->view('manageintropage/update', $this->_data);
			$this->admin_library->output();
        }else{
            $message = $this->manageintropagemodel->update($introid);
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('manageintropage/index');
        }
    }

    public function setstatus( $setto='approved', $introid=0 ){

        $message = $this->manageintropagemodel->setStatus($setto, $introid);
			
        $this->session->set_flashdata($message['status'], $message['text']);
        admin_redirect('manageintropage/index');

    }

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }

    public function show_type( $text, $row ){
        switch( $text ){
            case 'youtube' : return 'YouTube'; break;
            case 'image' :
            default : return 'รูปภาพ';
        }
    }

    public function show_image($text, $row){
        if($text!=''){
            if( $row['intro_type'] == 'image' ){
                return '<a href="'.base_url('public/core/uploaded/intro/'.$row['intro_value']).'" class="fancybox-button"><img src="'.base_url('public/core/uploaded/intro/'.$row['intro_value']).'" alt="" style="width:150px;" /></a>';
            }else{
                return '<a href="https://www.youtube.com/embed/'.$row['intro_value'].'?autoplay=1" class="fancybox-button-iframe"><img src="http://img.youtube.com/vi/'.$row['intro_value'].'/sddefault.jpg" style="width:150px;" /></a>';
            }
        }else{
            return 'ไม่มีรูปภาพแสดง';
        }
    }

    public function show_status($text, $row){
        switch($text){
            case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
            case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
            default : return 'ไม่มีสถานะ';
        }
    }

    public function show_period( $text, $row ){
        $start = ( !$row['intro_start_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['intro_start_date'] ) );
		$end = ( !$row['intro_end_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['intro_end_date'] ) );

		$status = ( $row['intro_start_date'] > date("Y-m-d") ? '<span class="label label-warning">ยังไม่ถึงเวลาแสดงผล</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		if( $row['intro_end_date'] != null || $row['intro_end_date'] != '' ){
			$status = ( $row['intro_end_date'] < date("Y-m-d") ? '<span class="label label-inverse">หมดอายุ</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		}
		
		$response = ( !$row['intro_start_date'] ? 'ไม่กำหนด' : $start.' - '.$end ).'<br />'.$status;
		return $response;
    }
    /* Default function -  End */

}