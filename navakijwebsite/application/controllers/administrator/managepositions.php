<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managepositions extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managepositions/managepositionsmodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('c8bec918fcbcb6b3b1fee2ee23e36105');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการผู้บริหาร",'icon-list-alt');
	}

	public function index($mainid=0, $offset=0){
		if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}
		
		$this->admin_model->set_menu_key('6972a51278bae3b7c1446ebe2d498000');
		$this->admin_model->set_detail('รายการตำแหน่งผู้บริหาร');
		
		$this->admin_model->set_top_button('เพิ่มตำแหน่งผู้บริหาร','managepositions/create/'.$mainid,'icon-plus','btn-success','w');
		if( $mainid > 0 ){
			$this->admin_model->set_top_button('กลับไปยังตำแหน่งหลัก','managepositions/index/0','icon-undo','btn-primary','r');
		}
		
		/* Get Data Table - Start */
		$perpage = 10;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managepositionsmodel->get_positions($mainid, $perpage, $offset));
		$totalrows = $this->managepositionsmodel->count_positions($mainid);
		/* Get Data Table - End */
		
		$this->admin_model->set_column('position_id','ลำดับ','15%','icon-list-ol');
		if( $mainid > 0 ){
			$this->admin_model->set_column('main_id','ตำแหน่งหลัก','15%','icon-quote');
		}
		$this->admin_model->set_column('position_title_th','ชื่อ','15%','icon-quote');
		$this->admin_model->set_column('position_order','การจัดลำดับ','15%','icon-sort');
		$this->admin_model->set_column('position_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_action_button('แก้ไขข้อมูล','managepositions/update/[main_id]/[position_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managepositions/delete/[main_id]/[position_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_action_button('จัดการตำแหน่งผู้บริหารย่อย','managepositions/index/[position_id]','icon-list','btn-default','r');
        $this->admin_model->set_column_callback('position_id','show_seq');
        $this->admin_model->set_column_callback('main_id', 'show_category');
        $this->admin_model->set_column_callback('position_order','show_order');
        $this->admin_model->set_column_callback('position_status', 'show_status');
		$this->admin_model->set_pagination("managepositions/index/".$mainid,$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
	}

    public function create( $mainid=0 ){
        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('6972a51278bae3b7c1446ebe2d498000');
        $this->admin_model->set_detail('เพิ่มตำแหน่งผู้บริหาร');

        $this->form_validation->set_rules('position_title_th', 'ชื่อ (ไทย)', 'trim|required');
        $this->form_validation->set_rules('position_title_en', 'ชื่อ (En)', 'trim|required');
        $this->form_validation->set_rules('position_status', 'สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if($this->form_validation->run()===FALSE){
            $this->admin_library->add_breadcrumb("รายการตำแหน่งผู้บริหาร","managepositions/index/".$mainid,"icon-list-ol");
            $this->admin_library->add_breadcrumb("เพิ่มตำแหน่งผู้บริหาร","managepositions/create/".$mainid,"icon-plus");

            $this->_data['mainId'] = $mainid;

            $this->admin_library->view('managepositions/create', $this->_data);
            $this->admin_library->output();
        }else{
            $message = $this->managepositionsmodel->create();
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managepositions/index/'.$mainid);
        }
    }

    public function update( $mainid=0, $positionid=0 ){
        if(!$this->admin_model->check_permision("r")){
            show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }

        $this->admin_model->set_menu_key('6972a51278bae3b7c1446ebe2d498000');
        $this->admin_model->set_detail('แก้ไขตำแหน่งผู้บริหาร');

        $this->form_validation->set_rules('position_title_th', 'ชื่อ (ไทย)', 'trim|required');
        $this->form_validation->set_rules('position_title_en', 'ชื่อ (En)', 'trim|required');
        $this->form_validation->set_rules('position_status', 'สถานะการแสดงผล','trim|required');
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_error_delimiters('<div class="message error">','</div>');
        
        if($this->form_validation->run()===FALSE){
            $this->admin_library->add_breadcrumb("รายการตำแหน่งผู้บริหาร","managepositions/index/".$mainid,"icon-list-ol");
            $this->admin_library->add_breadcrumb("แก้ไขตำแหน่งผู้บริหาร","managepositions/update/".$mainid.'/'.$positionid,"icon-pencil-square-o");

            $this->_data['mainId'] = $mainid;
            $this->_data['info'] = $this->managepositionsmodel->get_positioninfo_byid( $positionid );

            $this->admin_library->view('managepositions/update', $this->_data);
            $this->admin_library->output();
        }else{
            $message = $this->managepositionsmodel->update($positionid);
			
            $this->session->set_flashdata($message['status'], $message['text']);
            admin_redirect('managepositions/index/'.$mainid);
        }
    }

    public function delete( $mainid=0, $positionid=0 ){
        $message = array();
        $message = $this->managepositionsmodel->setStatus( 'discard', $positionid );

        $this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('managepositions/index/'.$mainid);
    }

    public function setorder( $movement='up', $mainid=0, $positionid=0 ){
        $message = array();
        $message = $this->managepositionsmodel->setOrder( $movement, $positionid );

        $this->session->set_flashdata($message['status'],$message['text']);
        admin_redirect('managepositions/index/'.$mainid);
    }

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }

    public function show_category( $text, $row ){
        $category = $this->managepositionsmodel->get_positioninfo_byid( $text );
        if( isset( $category ) && count( $category ) > 0 ){
            return $category['position_title_th'];
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
        $text .= '(<a href="'.admin_url('managepositions/setorder/up/'.$row['main_id'].'/'.$row['position_id']).'"><i class="icon-chevron-up"></i> เลื่อนขึ้น</a>';
        $text .= ' | ';
        $text .= '<a href="'.admin_url('managepositions/setorder/down/'.$row['main_id'].'/'.$row['position_id']).'"><i class="icon-chevron-down"></i> เลื่อนลง</a>)';
        return $text;
    }
    /* Default function -  End */

}