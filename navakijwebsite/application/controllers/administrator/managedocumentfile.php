<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managedocumentfile extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managedocumentfile/managedocumentfilemodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('dc76a414f8c0968fe1eb984363cef907');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการไฟล์",'icon-list-alt');
	}

	public function index($documentid=0, $offset=0){
        if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }
        
        //$category = $this->managedocumentfilemodel->get_categoryinfo_byid( $categoryid );
        $document = $this->managedocumentfilemodel->get_documentinfo_byid( $documentid );
        //$this->_data['category'] = $category;
        $this->_data['document'] = $document;

        $this->admin_model->set_menu_key('dc76a414f8c0968fe1eb984363cef907');
		if( isset( $category ) && count( $category ) > 0 ){
			$this->admin_model->set_detail('รายการไฟล์ของ "'.$document['document_title_th'].'"');
		}else{
			$this->admin_model->set_detail('รายการไฟล์ทั้งหมด');
        }

        /* Set Custom Tools - Start */
		$this->admin_model->set_custom_tools('managedocumentfile/create', $this->_data);
        /* Set Custom Tools - End */
        
        /* Get Data Table - Start */
		$perpage = 10;
		$this->offset = $offset;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managedocumentfilemodel->get_document_file($document['document_id'], $perpage, $offset));
		$totalrows = $this->managedocumentfilemodel->count_document_file($document['document_id']);
        /* Get Data Table - End */

        // $this->admin_model->set_checkall_dropdown('<i class="icon-unlock"></i> เปิดการแสดงผล','managedocumentfile/setstatus/approved/'.$document['document_id'], 'w','btn-success');
        // $this->admin_model->set_checkall_dropdown('<i class="icon-lock"></i> ปิดการแสดงผล','managedocumentfile/setstatus/pending/'.$document['document_id'], 'w','btn-inverse');
        // $this->admin_model->set_checkall_dropdown('<i class="icon-trash"></i> ลบรูปภาพ','managedocumentfile/setstatus/discard/'.$document['document_id'], 'w','btn-danger');
        // $this->admin_model->set_checkall(true, 'document_file_id');
        
        $this->admin_model->set_column('document_file_id','ลำดับ','10%','icon-list-ol');
        $this->admin_model->set_column('document_file_th','ไฟล์','15%','icon-picture-o');
        $this->admin_model->set_column('document_file_title_th','หัวข้อ','35%','icon-font');
        $this->admin_model->set_column('document_file_status','สถานะการแสดงผล','15%','icon-eye-slash');
        $this->admin_model->set_action_button('แก้ไข','managedocumentfile/update/[document_id]/[document_file_id]','icon-pencil-square-o','btn-primary','w');
		$this->admin_model->set_action_button('ลบข้อมูล','managedocumentfile/delete/[document_id]/[document_file_id]','icon-trash','btn-danger','d');
		$this->admin_model->set_column_callback('document_file_id','show_seq');
		$this->admin_model->set_column_callback('document_file_th','show_file');
		$this->admin_model->set_column_callback('document_file_status','show_status');
		
		$this->admin_model->set_pagination("managedocumentfile/index/".$documentid,$totalrows,$perpage,5);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
    }
    
    public function uploadFiles($documentid=0){
        $message = $this->managedocumentfilemodel->create($documentid );

        $this->session->set_flashdata($message['status'], $message['text']);
        admin_redirect('managedocumentfile/index/'.$documentid);
    }

    public function update($documentid,$document_file_id=0){
		
		if(!$this->admin_model->check_permision("w")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
		}echo $document_file_id;
		$this->admin_model->set_menu_key('dc76a414f8c0968fe1eb984363cef907');
        $this->admin_model->set_detail('แก้ไขไฟล์');
        $this->_data['info'] = $this->managedocumentfilemodel->get_document_fileinfo_byid($document_file_id);
       
		$this->form_validation->set_rules('document_file_title_th','หัวข้อไฟล์ (ไทย)','trim|required');
		$this->form_validation->set_rules('document_file_title_en','หัวข้อไฟล์ (En)','trim|required');
		$this->form_validation->set_rules('document_file_desc_th','หมายเหตุ (ไทย)','trim');
		$this->form_validation->set_rules('document_file_desc_en','หมายเหตุ (En)','trim');
		$this->form_validation->set_rules('document_file_status','สถานะการแสดงผล','trim|required');
		$this->form_validation->set_message('required','กรุณาระบุ "%s"');
		$this->form_validation->set_error_delimiters('<div class="message error">','</div>');
		
		if($this->form_validation->run()===FALSE){
			
			//$this->_data['info'] = $this->managedocumentfilemodel->get_document_fileinfo_byid($document_file_id);
			
			$this->admin_library->add_breadcrumb("รายการไฟล์","managedocumentfile/index","icon-list");
			$this->admin_library->add_breadcrumb("แก้ไขไฟล์","managedocumentfile/update/".$document_file_id,"icon-plus");
			
			$this->admin_library->view('managedocumentfile/update', $this->_data);
			$this->admin_library->output();
			
		}else{
			
			$message = $this->managedocumentfilemodel->update($document_file_id);
			
			$this->session->set_flashdata($message['status'],$message['text']);
			admin_redirect('managedocumentfile/index/'.$this->_data['info']['document_id']);
			
		}
	}

    public function delete( $documentid=0, $fileid=0 ){

        $selectedLists = $this->input->get('select_item');

        $message = $this->managedocumentfilemodel->setStatus( 'discard', $documentid, $fileid );

        $this->session->set_flashdata($message['status'], $message['text']);
        admin_redirect('managedocumentfile/index/'.$documentid);
    }

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }

    public function show_file($text, $row){
        if($text!=''){
            return '<a href="'.base_url('public/core/uploaded/documents/files/'.$row['document_id'].'/'.$row['document_file_th']).'" class="fancybox-button" target="_blank"><i class="icon-download"></i> ดาวน์โหลดไฟล์</a>';
        }else{
            return 'ไม่มีไฟล์';
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