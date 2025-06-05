<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managehiddendocumentsmodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }
    
    public function get_documents( $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('document_status !=','discard')
                            ->order_by('document_order','asc')
                            ->get('hidden_documents')
                            ->result_array();
        return $query;
    }

    public function count_documents(){
        $query = $this->db->where('document_status !=','discard')
                            ->order_by('document_order','asc')
                            ->count_all_results('hidden_documents');
        return $query;
    }

    public function get_documentinfo_byid( $documentid=0 ){
        $query = $this->db->where('document_id', $documentid)
                            ->get('hidden_documents')
                            ->row_array();
        return $query;
    }

    public function create(){
        $message = array();

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/hidden_documents';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'pdf|doc|docx|xlsx|xls|zip';
        $config['max_size'] = 102400;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'document_file', $_FILES['document_file']);
        /* Upload - End */

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/hidden_documents';
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

        /* Generate META URL - Start */
        $metaURL = 'stfile/'.$this->input->post('document_title_en');
		$validatedURL = validate_meta_url( $metaURL, 'hidden_documents', 'document_' );
        /* Generate META URL - End */

        $this->db->set('document_file', $file);
        $this->db->set('document_file_en', $file_en);
        $this->db->set('document_title_th', $this->input->post('document_title_th'));
        $this->db->set('document_title_en', $this->input->post('document_title_en'));
        $this->db->set('document_publish_date', date("Y-m-d", strtotime( $this->input->post('document_publish_date') ) ));
        $this->db->set('document_meta_title', $this->input->post('document_meta_title'));
        $this->db->set('document_meta_description', $this->input->post('document_meta_description'));
        $this->db->set('document_meta_keywords', $this->input->post('document_meta_keywords'));
        $this->db->set('document_meta_url', $validatedURL);
        $this->db->set('document_status', $this->input->post('document_status'));
        $this->db->set('document_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('document_createdip', $this->input->ip_address());
        $this->db->insert('hidden_documents');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update(){
        $message = array();
        $info = $this->get_documentinfo_byid( $this->input->post('document_id') );

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/hidden_documents';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'pdf|doc|docx|xlsx|xls|zip';
        $config['max_size'] = 102400;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->edit_upload($config, 'document_file', $_FILES['document_file'], $info['document_file']);
        /* Upload - End */

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/hidden_documents';
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

        /* Generate META URL - Start */
        $metaURL = $this->input->post('document_meta_url');
		$validatedURL = validate_meta_url( $metaURL, 'hidden_documents', 'document_', $info['document_id'] );
        /* Generate META URL - End */

        $this->db->set('document_file', $file);
        $this->db->set('document_file_en', $file_en);
        $this->db->set('document_title_th', $this->input->post('document_title_th'));
        $this->db->set('document_title_en', $this->input->post('document_title_en'));
        $this->db->set('document_publish_date', date("Y-m-d", strtotime( $this->input->post('document_publish_date') ) ));
        $this->db->set('document_meta_title', $this->input->post('document_meta_title'));
        $this->db->set('document_meta_description', $this->input->post('document_meta_description'));
        $this->db->set('document_meta_keywords', $this->input->post('document_meta_keywords'));
        $this->db->set('document_meta_url', $validatedURL);
        $this->db->set('document_status', $this->input->post('document_status'));
        $this->db->set('document_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('document_updatedip', $this->input->ip_address());
        $this->db->where('document_id', $info['document_id']);
        $this->db->update('hidden_documents');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto='discard', $documentid=0 ){
        $message = array();
        $info = $this->get_documentinfo_byid( $documentid );

        $this->db->set('document_status', $setto);
        $this->db->set('document_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('document_updatedip', $this->input->ip_address());
        $this->db->where('document_id', $info['document_id']);
        $this->db->update('hidden_documents');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกข้อมูลสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }

}

/* End of file Managedocumentsmodel.php */
