<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managebranchoffices extends CI_Controller {
    var $_data = array();
	var $seq;

    public function __construct()
    {
        parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managebranchoffices/managebranchofficesmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('93817ced9e4bb97645e382ff1a307e4d');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการสำนักงานสาขา",'icon-list-alt');
    }

    public function index( $offset=0){
        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('a1a0f47fd62e66bf8c8ce37fe0e67985');
        $this->admin_model->set_detail('รายการภูมิภาค');

        /* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managebranchofficesmodel->get_regions($perpage, $offset));
		$totalrows = $this->managebranchofficesmodel->count_regions();
		/* Get Data Table - End */

        $this->admin_model->set_column('region_id','ลำดับ','10%','icon-list-ol');
        $this->admin_model->set_column('region_th','ชื่อ','15%','icon-font');
        $this->admin_model->set_column('region_order', 'จำนวนสาขา','15%','icon-star');
        $this->admin_model->set_action_button('ดูรายการสาขา','managebranchoffices/branches/[region_id]','icon-eye-o','btn-success','r');
        $this->admin_model->set_column_callback('region_id','show_seq');
        $this->admin_model->set_column_callback('region_order','show_totlalbranches');
        $this->admin_model->set_pagination("managebranchoffices/index",$totalrows,$perpage,4);
        $this->admin_model->make_list();

        $this->admin_library->output();

    }

    public function branches($regionid=0, $offset=0)
    {
        if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		if( $regionid <= 0 ){
			
			$message = array(
				'status' => 'message-warning',
				'text' => 'กรุณาเลือกภูมิภาคที่ต้องการจัดการสาขา',
			);
			
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('managebranchoffices/index');
			
		}
		
		$region = $this->managebranchofficesmodel->get_regioninfo_byid( $regionid );
		
		$this->admin_model->set_menu_key('a1a0f47fd62e66bf8c8ce37fe0e67985');
		$this->admin_model->set_detail('รายการสาขาของภูมิภาค '.$region['region_th']);
		
		$this->admin_model->set_top_button('เพิ่มสาขาใหม่','managebranchoffices/create/'.$region['region_id'],'icon-plus','btn-success','w');
		$this->admin_model->set_top_button('กลับไปยังรายการภูมิภาค','managebranchoffices/index','icon-undo','btn-primary','w');
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managebranchofficesmodel->get_branches($regionid, $perpage, $offset));
		$totalrows = $this->managebranchofficesmodel->count_branches($regionid);
		/* Get Data Table - End */
		
		$this->admin_model->set_column('id','ลำดับ','10%','icon-list-ol');
        $this->admin_model->set_column('name_th','ชื่อสาขา','20%','icon-font');
        $this->admin_model->set_column('tel','เบอร์โทร','15%','icon-phone');
        $this->admin_model->set_column('map_img','แผนที่ (รูปภาพ)','10%','icon-picture-o');
        $this->admin_model->set_column('map_google','แผนที่ (Google Map)','10%','icon-map-marker');
        $this->admin_model->set_column('order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managebranchoffices/update/[region_id]/[id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managebranchoffices/delete/[region_id]/[id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('id','show_seq');
		$this->admin_model->set_column_callback('name_th','show_title');
		$this->admin_model->set_column_callback('map_img','show_map_img');
		$this->admin_model->set_column_callback('map_google','show_map_google');
        $this->admin_model->set_column_callback('order','show_order');
		$this->admin_model->set_column_callback('status','show_status');
		$this->admin_model->set_pagination("managebranchoffices/index/".$region['region_id'],$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
    }

    public function create($regionid=0){
        if(!$this->admin_model->check_permision("r")){
			show_error("Your permission is invalid.");
		}

		$region = $this->managebranchofficesmodel->get_regioninfo_byid( $regionid );

		$this->admin_model->set_menu_key('a1a0f47fd62e66bf8c8ce37fe0e67985');
        $this->admin_model->set_detail('เพิ่มสาขาของภูมิภาค '.$region['region_th']);

        $this->form_validation->set_rules('name_th','ชื่อสาขา (ไทย)','trim|required');
        $this->form_validation->set_rules('name_en','ชื่อสาขา (En)','trim|required');
        $this->form_validation->set_rules('tel','เบอร์โทรศัพท์','trim|required');
        $this->form_validation->set_rules('map_google','แผนที่ (Google Map)','trim');
        $this->form_validation->set_rules('status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','"%s" is required.');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if( $this->form_validation->run() === false ){
            $this->admin_library->add_breadcrumb('รายการสาขาของภูมิภาค '.$region['region_th'],"managebranchoffices/index","icon-list");
            $this->admin_library->add_breadcrumb('เพิ่มสาขาของภูมิภาค '.$region['region_th'],"managebranchoffices/create","icon-plus");

            $this->_data['region'] = $region;
            
            $this->admin_library->view('managebranchoffices/create', $this->_data);
			$this->admin_library->output();
        }else{
            $message = $this->managebranchofficesmodel->create($regionid);

            $this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managebranchoffices/branches/'.$regionid);
        }
    }

    public function update( $regionid=0, $id=0 ){
        if(!$this->admin_model->check_permision("r")){
			show_error("Your permission is invalid.");
		}

		$region = $this->managebranchofficesmodel->get_regioninfo_byid( $regionid );

		$this->admin_model->set_menu_key('a1a0f47fd62e66bf8c8ce37fe0e67985');
        $this->admin_model->set_detail('แก้ไขสาขาของภูมิภาค '.$region['region_th']);

        $info = $this->managebranchofficesmodel->get_branchinfo_byid( $id );

        $this->form_validation->set_rules('name_th','ชื่อสาขา (ไทย)','trim|required');
        $this->form_validation->set_rules('name_en','ชื่อสาขา (En)','trim|required');
        $this->form_validation->set_rules('tel','เบอร์โทรศัพท์','trim|required');
        $this->form_validation->set_rules('map_google','แผนที่ (Google Map)','trim');
        $this->form_validation->set_rules('status','สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','"%s" is required.');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if( $this->form_validation->run() === false ){
            $this->admin_library->add_breadcrumb('รายการสาขาของภูมิภาค '.$region['region_th'],"managebranchoffices/index","icon-list");
            $this->admin_library->add_breadcrumb('แก้ไขสาขาของภูมิภาค '.$region['region_th'],"managebranchoffices/update/".$regionid.'/'.$info['id'],"icon-pencil-square");

            $this->_data['region'] = $region;
            $this->_data['info'] = $info;
            
            $this->admin_library->view('managebranchoffices/update', $this->_data);
			$this->admin_library->output();
        }else{
            $message = $this->managebranchofficesmodel->update($info['id']);

            $this->session->set_flashdata($message['status'], $message['text']);
			admin_redirect('managebranchoffices/branches/'.$regionid);
        }
    }

    public function delete( $regionid=0, $id=0 ){
		$message = $this->managebranchofficesmodel->setStatus('discard', $id);
		
		$this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managebranchoffices/branches/'.$regionid);
    }

    public function setorder( $movement='up', $regionid=0, $id=0 ){
        $message = $this->managebranchofficesmodel->setOrder( $movement, $id );

        $this->session->set_flashdata($message['status'],$message['text']);
		admin_redirect('managebranchoffices/branches/'.$regionid);
    }

    /* Default function - Start */
	public function show_seq($text, $row){
		$this->seq++;
		return $this->seq;
    }
    
    public function show_title( $text, $row ){
        return $row['name_th'].' / '.$row['name_en'];
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
        $text .= '(<a href="'.admin_url('managebranchoffices/setorder/up/'.$row['region_id'].'/'.$row['id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
        $text .= ' | ';
        $text .= '<a href="'.admin_url('managebranchoffices/setorder/down/'.$row['region_id'].'/'.$row['id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
        return $text;
    }

    public function show_map_img( $text, $row ){
        if( !empty($text) ){
            return '<a href="'.base_url('public/core/uploaded/branchoffices/'.$text).'" target="_blank">คลิก</a>';
        }else{
            return 'ไม่มีรูปภาพ';
        }
    }

    public function show_map_google( $text, $row ){
        if( !empty($text) ){
            return '<a href="'.$text.'" target="_blank">คลิก</a>';
        }else{
            return 'ไม่มีแผนที่';
        }
    }

    public function show_totlalbranches( $text, $row ){
        $total = $this->managebranchofficesmodel->count_branches($row['region_id']);
        $badge = 'badge-disabled';
        if($total > 0){
            $badge = 'badge-info';
        }
        return '<span class="badge '.$badge.'">'.$total.'</span>';
    }
	/* Default function -  End */
}

/* End of file managebranchoffices.php */
/* Location: ./application/controllers/administrator/managebranchoffices.php */