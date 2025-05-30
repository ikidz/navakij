<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managejobvacancy extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managejobvacancy/managejobvacancymodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1e1188604ececddcc32218f8f72a29ad');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("รายการตำแหน่งงานว่าง",'icon-list-alt');
	}

	public function index($locationid=0, $offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$location = $this->managejobvacancymodel->get_locationinfo_byid( $locationid );
		if( !isset( $location ) ){
			$message = array(
				'status' => 'message-warning',
				'text' => 'กรุณาระบุสถานที่'
			);
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('managelocations/index');
		}
		
		$this->admin_model->set_menu_key('e145e48c44d87875a4fa857a59d143b6');
		$this->admin_model->set_detail('รายการตำแหน่งงานว่างของ '.$location['location_title_th']);
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managejobvacancymodel->get_jobs($locationid, $perpage, $offset));
		$totalrows = $this->managejobvacancymodel->count_jobs($locationid);
		/* Get Data Table - End */
		
		$this->admin_model->set_top_button('เพิ่มรายการตำแหน่งงาน','managejobvacancy/create/'.$locationid,'icon-plus','btn-success','w');
		$this->admin_model->set_top_button('กลับไปยังรายการสถานที่','managelocations/index','icon-undo','btn-primary','r');
		
		$this->admin_model->set_column('job_id','ลำดับ','5%','icon-list-ol');
		$this->admin_model->set_column('job_title_th','ชื่อตำแหน่ง','15%','icon-font');
		$this->admin_model->set_column('job_amount','จำนวนที่เปิดรับ','10%','icon-user');
		$this->admin_model->set_column('is_appliable','เปิดรับสมัคร','10%','icon-file-text');
		$this->admin_model->set_column('job_order','การจัดลำดับ','15%','icon-sort');
        $this->admin_model->set_column('job_start_date','ช่วงวันที่แสดงผล','15%','icon-calendar-o');
		$this->admin_model->set_column('job_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managejobvacancy/update/[location_id]/[job_id]','icon-pencil-square-o','btn-success','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managejobvacancy/delete/[location_id]/[job_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('job_id','show_seq');
		$this->admin_model->set_column_callback('job_title_th','show_title');
        $this->admin_model->set_column_callback('job_amount', 'show_amount');
		$this->admin_model->set_column_callback('is_appliable','show_icon');
		$this->admin_model->set_column_callback('job_order','show_order');
        $this->admin_model->set_column_callback('job_start_date', 'show_period');
		$this->admin_model->set_column_callback('job_status','show_status');
		$this->admin_model->set_pagination("managejobvacancy/index/".$location['location_id'],$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}
	
	public function create( $locationid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$location = $this->managejobvacancymodel->get_locationinfo_byid( $locationid );
		
		$this->admin_model->set_menu_key('e145e48c44d87875a4fa857a59d143b6');
		$this->admin_model->set_detail('เพิ่มรายการตำแหน่งงานว่าง');
		
		$this->form_validation->set_rules('job_title_th','ชื่อตำแหน่ง (ไทย)','trim|required');
		$this->form_validation->set_rules('job_title_en','ชื่อตำแหน่ง (En)','trim|required');
		$this->form_validation->set_rules('job_remark_label_th','หมายเหตุ (ไทย)','trim');
		$this->form_validation->set_rules('job_remark_label_en','หมายเหตุ (En)','trim');
		$this->form_validation->set_rules('job_responsibility_th','หน้าที่ความรับผิดชอบ (ไทย)','trim');
		$this->form_validation->set_rules('job_responsibility_en','หน้าที่ความรับผิดชอบ (En)','trim');
		$this->form_validation->set_rules('job_qualification_th','คุณสมบัติ (ไทย)','trim');
		$this->form_validation->set_rules('job_qualification_en','คุณสมบัติ (En)','trim');
        $this->form_validation->set_rules('job_start_date','วันที่เริ่มต้น','trim|required');
        $this->form_validation->set_rules('job_end_date','วันที่สิ้นสุด','trim');
		$this->form_validation->set_rules('job_amount','จำนวนที่เปิดรับ','trim');
		$this->form_validation->set_rules('is_appliable','เปิดรับสมัคร','trim');
		$this->form_validation->set_rules('is_profile_leaving','เปิดให้ทิ้งประวัติ','trim');
		$this->form_validation->set_rules('job_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_rules('job_meta_title_th','Meta Title (ไทย)','trim');
		$this->form_validation->set_rules('job_meta_title_en','Meta Title (En)','trim');
		$this->form_validation->set_rules('job_meta_description_th','Meta Descirption (ไทย)','trim');
		$this->form_validation->set_rules('job_meta_description_en','Meta Description (En)','trim');
		$this->form_validation->set_rules('job_meta_keywords_th','Meta Keywords (ไทย)','trim');
		$this->form_validation->set_rules('job_meta_keywords_en','Meta Keywords (En)','trim');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการตำแหน่งงานว่าง","managejobvacancy/index/".$location['location_id'],"icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการตำแหน่งงานว่าง","managejobvacancy/create/".$location['location_id'],"icon-plus");
			
			$this->_data['location'] = $location;
			
			$this->admin_library->view('managejobvacancy/create', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managejobvacancymodel->create( $location['location_id'] );
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managejobvacancy/index/'.$location['location_id']);
		}
	}
	
	public function update( $locationid=0, $jobid=0 ){
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$location = $this->managejobvacancymodel->get_locationinfo_byid( $locationid );
		$info = $this->managejobvacancymodel->get_jobinfo_byid( $jobid );
		
		$this->admin_model->set_menu_key('e145e48c44d87875a4fa857a59d143b6');
		$this->admin_model->set_detail('แก้ไขรายการตำแหน่งงานว่าง');
		
		$this->form_validation->set_rules('job_title_th','ชื่อตำแหน่ง (ไทย)','trim|required');
		$this->form_validation->set_rules('job_title_en','ชื่อตำแหน่ง (En)','trim|required');
		$this->form_validation->set_rules('job_remark_label_th','หมายเหตุ (ไทย)','trim');
		$this->form_validation->set_rules('job_remark_label_en','หมายเหตุ (En)','trim');
		$this->form_validation->set_rules('job_responsibility_th','หน้าที่ความรับผิดชอบ (ไทย)','trim');
		$this->form_validation->set_rules('job_responsibility_en','หน้าที่ความรับผิดชอบ (En)','trim');
		$this->form_validation->set_rules('job_qualification_th','คุณสมบัติ (ไทย)','trim');
		$this->form_validation->set_rules('job_qualification_en','คุณสมบัติ (En)','trim');
        $this->form_validation->set_rules('job_start_date','วันที่เริ่มต้น','trim|required');
        $this->form_validation->set_rules('job_end_date','วันที่สิ้นสุด','trim');
		$this->form_validation->set_rules('job_amount','จำนวนที่เปิดรับ','trim');
		$this->form_validation->set_rules('is_appliable','เปิดรับสมัคร','trim');
		$this->form_validation->set_rules('is_profile_leaving','เปิดให้ทิ้งประวัติ','trim');
		$this->form_validation->set_rules('job_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_rules('job_meta_url','Meta URL','trim');
		$this->form_validation->set_rules('job_meta_title_th','Meta Title (ไทย)','trim');
		$this->form_validation->set_rules('job_meta_title_en','Meta Title (En)','trim');
		$this->form_validation->set_rules('job_meta_description_th','Meta Descirption (ไทย)','trim');
		$this->form_validation->set_rules('job_meta_description_en','Meta Description (En)','trim');
		$this->form_validation->set_rules('job_meta_keywords_th','Meta Keywords (ไทย)','trim');
		$this->form_validation->set_rules('job_meta_keywords_en','Meta Keywords (En)','trim');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			$this->admin_library->add_breadcrumb("รายการตำแหน่งงานว่าง","managejobvacancy/index/".$location['location_id'],"icon-list-ol");
			$this->admin_library->add_breadcrumb("เพิ่มรายการตำแหน่งงานว่าง","managejobvacancy/create/".$location['location_id'],"icon-plus");
			
			$this->_data['location'] = $location;
			$this->_data['info'] = $info;
			
			$this->admin_library->view('managejobvacancy/update', $this->_data);
			$this->admin_library->output();
		}else{
			$message = $this->managejobvacancymodel->update($location['location_id'], $info['job_id']);
						
			$this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managejobvacancy/index/'.$location['location_id']);
		}
	}
	
	public function delete( $locationid=0, $jobid=0 ){
		$message = array();
		$message = $this->managejobvacancymodel->setStatus('discard', $jobid);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managejobvacancy/index/'.$locationid);
	}
	
	public function setorder( $movement='up', $locationid=0, $jobid=0 ){
		$message = array();
		$message = $this->managejobvacancymodel->setOrder( $movement, $jobid );
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managejobvacancy/index/'.$locationid);
	}
	
	/* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
	}
	
	public function show_title( $text, $row ){
		return $text.( $row['job_remark_label_th'] != '' ? ' <span style="color:#da1c5c;">'.$row['job_remark_label_th'].'</span>' : '' );
	}
	
	public function show_icon( $text, $row ){
        $pattern = '';
		if( $text == 1 ){
			$pattern = '<p style="color:#59974a;">ออนไลน์ : <i class="icon-check"></i></p>';
		}else{
			$pattern = '<p style="color:#da1c5c;">ออนไลน์ : <i class="icon-times"></i></p>';
		}
        if( $row['is_profile_leaving'] == 1 ){
			$pattern .= '<p style="color:#59974a;">ฝากประวัติ : <i class="icon-check"></i></p>';
		}else{
			$pattern .= '<p style="color:#da1c5c;">ฝากประวัติ : <i class="icon-times"></i></p>';
		}

        return $pattern;
	}

    public function show_amount( $text, $row ){
        if( $text == 0 ){
            return 'ไม่จำกัด';
        }else{
            return $text.' ตำแหน่ง';
        }
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
		$text .= '(<a href="'.admin_url('managejobvacancy/setorder/up/'.$row['location_id'].'/'.$row['job_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
		$text .= ' | ';
		$text .= '<a href="'.admin_url('managejobvacancy/setorder/down/'.$row['location_id'].'/'.$row['job_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
		return $text;
	}

    public function show_period( $text, $row ){
		$start = ( !$row['job_start_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['job_start_date'] ) );
		$end = ( !$row['job_end_date'] ? 'ไม่กำหนด' : thai_convert_fulldate( $row['job_end_date'] ) );

		$status = ( $row['job_start_date'] > date("Y-m-d") ? '<span class="label label-warning">ยังไม่ถึงเวลาแสดงผล</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		if( $row['job_end_date'] != null || $row['job_end_date'] != '' ){
			$status = ( $row['job_end_date'] < date("Y-m-d") ? '<span class="label label-inverse">หมดอายุ</span>' : '<span class="label label-success">แสดงผลได้</span>' );
		}
		
		
		$response = ( !$row['job_start_date'] ? 'ไม่กำหนด' : $start.' - '.$end ).'<br />'.$status;
		return $response;
	}
	/* Default function -  End */

}