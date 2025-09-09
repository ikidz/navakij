<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managedocumentfilemodel extends CI_Model {

    var $_data;
    public function __construct()
    {
        parent::__construct();
    }

    public function get_documentinfo_byid( $documentid=0 ){
        $query = $this->db->where('document_id', $documentid)
                            ->get('documents')
                            ->row_array();
        return $query;
    }

    public function get_document_file( $documentid=0, $limit, $offset=0){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('document_id', $documentid)
                            ->where('document_file_status !=','discard')
                            ->order_by('document_file_order','asc')
                            ->order_by('document_file_createdtime','desc')
                            ->get('document_files')
                            ->result_array();
        return $query;
    }

    public function count_document_file( $documentid=0 ){
        $query = $this->db->where('document_id', $documentid)
                            ->where('document_file_status !=','discard')
                            ->order_by('document_file_createdtime','desc')
                            ->count_all_results('document_files');
        return $query;
    }

    public function get_document_fileinfo_byid( $document_fileid=0 ){
        $query = $this->db->where('document_file_id', $document_fileid)
                            ->get('document_files')
                            ->row_array();
        return $query;
    }

    public function create( $documentid=0 ){
        
        /* Upload - Start */
        $mainPath = realpath('').'/public/core/uploaded/documents/files';
        if(is_dir($mainPath)===false){
            mkdir($mainPath, 0777);
            chmod($mainPath, 0777);
        }

        $uploadpath = $mainPath.'/'.$documentid;
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }

        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'pdf|doc|docx|xlsx|xls|zip';
        $config['max_size'] = 102400;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'document_file_th', $_FILES['document_file_th']);

        /* Upload - End */

        /* Upload - Start */
        $mainPath = realpath('').'/public/core/uploaded/documents/files';
        if(is_dir($mainPath)===false){
            mkdir($mainPath, 0777);
            chmod($mainPath, 0777);
        }

        $uploadpath = $mainPath.'/'.$documentid;
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'pdf|doc|docx|xlsx|xls|zip';
        $config['max_size'] = 102400;
        $config['encrypt_name'] = true;
                    
        $file_en = $this->uploadmodel->do_upload($config, 'document_file_en', $_FILES['document_file_en']);
        
        /* Upload - End */

        $total = $this->count_documents( $documentid );
        $newOrder = 0;

        $this->db->set('document_id', $documentid);
        $this->db->set('document_file_th', $file);
        $this->db->set('document_file_en', $file_en);
        $this->db->set('document_file_title_th', $this->input->post('document_file_title_th'));
        $this->db->set('document_file_title_en', $this->input->post('document_file_title_en'));
        $this->db->set('document_file_desc_th', $this->input->post('document_file_desc_th'));
        $this->db->set('document_file_desc_en', $this->input->post('document_file_desc_en'));
        $this->db->set('document_file_order', $newOrder);
        $this->db->set('document_file_status','approved');
        $this->db->set('document_file_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('document_file_createdip', $this->input->ip_address());
        $this->db->insert('document_files');

        $message['status'] = 'message-success';
        $message['text'] = 'อัพโหลดไฟล์สำเร็จ';
        

        return $message;

    }

    public function update($document_file_id=0){
		$info = $this->get_document_fileinfo_byid($document_file_id);
        
         /* Upload - Start */
         $mainPath = realpath('').'/public/core/uploaded/documents/files';
         if(is_dir($mainPath)===false){
             mkdir($mainPath, 0777);
             chmod($mainPath, 0777);
         }

         $uploadpath = $mainPath.'/'.$info['document_id'];
         if(is_dir($uploadpath)===false){
             mkdir($uploadpath, 0777);
             chmod($uploadpath, 0777);
         }
         
         $config['upload_path'] = $uploadpath;
         $config['allowed_types'] = 'pdf|doc|docx|xlsx|xls|zip';
         $config['max_size'] = 102400;
         $config['encrypt_name'] = true;
                     
         $file = $this->uploadmodel->edit_upload($config, 'document_file_th', $_FILES['document_file_th'], $info['document_file_th']);
         
         /* Upload - End */

        /* Upload - Start */
        $mainPath = realpath('').'/public/core/uploaded/documents/files';
        if(is_dir($mainPath)===false){
            mkdir($mainPath, 0777);
            chmod($mainPath, 0777);
        }

        $uploadpath = $mainPath.'/'.$info['document_id'];
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'pdf|doc|docx|xlsx|xls|zip';
        $config['max_size'] = 102400;
        $config['encrypt_name'] = true;
                    
        $file_en = $this->uploadmodel->edit_upload($config, 'document_file_en', $_FILES['document_file_en'], $info['document_file_en']);
        /* Upload - End */

		
		
        $this->db->set('document_id', $info['document_id']);
        $this->db->set('document_file_th', $file);
        $this->db->set('document_file_en', $file_en);
        $this->db->set('document_file_title_th', $this->input->post('document_file_title_th'));
        $this->db->set('document_file_title_en', $this->input->post('document_file_title_en'));
        $this->db->set('document_file_desc_th', $this->input->post('document_file_desc_th'));
        $this->db->set('document_file_desc_en', $this->input->post('document_file_desc_en'));
        $this->db->set('document_file_status', $this->input->post('document_file_status'));
		$this->db->set('document_file_updatedtime', date("Y-m-d H:i:s"));
		$this->db->set('document_file_updatedip', $this->input->ip_address());
		$this->db->where('document_file_id', $info['document_file_id']);
		$this->db->update('document_files');
		
		$message = array();
		$message['status'] = 'message-success';
		$message['text'] = 'บันทึกข้อมูลสำเร็จ';
		
		if(!$file){
			$this->session->set_flashdata('message-warning','ยังไม่ได้อัพโหลดไฟล์');
		}
		
		return $message;
	}

    public function setStatus( $setto='approved', $documentid=0, $document_fileid=0 ){
        $message = array();

        $info = $this->get_document_fileinfo_byid( $document_fileid );

        $this->db->set('document_file_status', $setto);
        $this->db->set('document_file_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('document_file_updatedip', $this->input->ip_address());
        $this->db->where('document_file_id', $info['document_file_id']);
        $this->db->update('document_files');
        
        if( $setto == 'discard' ){
            
            if( is_file( realpath('public/core/uploaded/document/files/'.$documentid.'/'.$info['document_file_th']) ) === true ){
                unlink( realpath('public/core/uploaded/document/files/'.$documentid.'/'.$info['document_file_th']) );
            }
            if( is_file( realpath('public/core/uploaded/document/files/'.$documentid.'/'.$info['document_file_en']) ) === true ){
                unlink( realpath('public/core/uploaded/document/files/'.$documentid.'/'.$info['document_file_en']) );
            }

            $this->reOrder( $info['document_id'] );

        }

        $message['status'] = 'message-success';
        if( $setto == 'discard' ){
            $message['text'] = 'ลบรูปภาพสำเร็จ';
        }else{
            $message['text'] = 'บันทึกข้อมูลสถานะการแสดงผลสำเร็จ';
        }

        return $message;
    }

    public function setBulkStatus( $setto='approved', $documentid=0, $lists = array() ){
        $message = array();

        $totalSelected = count( $lists );
        $error = 0;
        $success = 0;

        if( isset( $lists ) && $totalSelected > 0 ){
            foreach( $lists as $list ){

                $response = array();
                $response = $this->setStatus( $setto, $documentid, $list );
                if( $response['status'] == 'message-success' ){
                    $success++;
                }else{
                    $error++;
                }

            }

            if( $success > 0 && $error <= 0 ){
                $status = 'message-success';
                $text = 'ทั้งสิ้น '.$success.' รายการ';
            }else if( $success <= 0 && $error > 0 ){
                $status = 'message-error';
                $text = 'ไม่สามารถทำรายการได้';
            }else{
                $status = 'message-warning';
                $text = 'ดำเนินการแล้ว '.$success.' รายการ เกิดข้อผิดพลาดขึ้นจำนวน '.$error.' รายการ';
            }

            $message = array(
                'status' => $status,
                'text' => $text
            );
            
        }else{
            $message['status'] = 'message-error';
            $message['text'] = 'กรุณาเลือกรูปภาพที่ต้องการจะดำเนินการ';
        }

        return $message;
    }

    public function get_documentfileinfo_byorder( $documentid=0, $newOrder ){
        $query = $this->db->where('document_id', $documentid)
                            ->where('document_file_order', $newOrder)
                            ->where('document_file_status !=', 'discard')
                            ->limit(1)
                            ->get('document_files')
                            ->row_array();
        return $query;
    }

    public function reOrder( $documentid=0 ){
        $lists = $this->get_document_file( $documentid );
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;
                $this->db->set('document_file_order', $i);
                $this->db->where('document_file_id', $list['document_file_id']);
                $this->db->update('document_files');
            }
        }
    }
    
    public function setOrder( $movement='up', $document_file_id=0 ){
        $message = array();
        $info = $this->get_document_fileinfo_byid( $document_file_id );
        $total = $this->count_document_file( $info['document_id'] );

        if( $movement == 'up' ){
            $newOrder = intval( $info['document_file_order'] - 1 );
            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{
                $exists = $this->get_documentfileinfo_byorder( $info['document_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['document_file_order'] + 1 );
                    $this->db->set('document_file_order', $exists_newOrder);
                    $this->db->where('document_file_id', $exists['document_file_id']);
                    $this->db->update('document_files');
                }

                $this->db->set('document_file_order', $newOrder);
                $this->db->where('document_file_id', $info['document_file_id']);
                $this->db->update('document_files');
                
                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );
            }
        }else if( $movement == 'down' ){
            $newOrder = intval( $info['document_file_order'] + 1 );
            if( $newOrder > $total ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
                );
            }else{
                $exists = $this->get_documentfileinfo_byorder( $info['document_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['document_file_order'] - 1 );
                    $this->db->set('document_file_order', $exists_newOrder);
                    $this->db->where('document_file_id', $exists['document_file_id']);
                    $this->db->update('document_files');
                }

                $this->db->set('document_file_order', $newOrder);
                $this->db->where('document_file_id', $info['document_file_id']);
                $this->db->update('document_files');
                
                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );
            }
        }else{
            $message = array(
                'status' => 'message-error',
                'text' => 'ไม่สามารถบันทึกข้อมูลการจัดลำดับได้'
            );
        }

        return $message;
    }
}

/* End of file Managedocument_filemodel.php */
