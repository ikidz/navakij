<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageintropagemodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function get_intropages( $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('intro_status !=','discard')
                            ->order_by('intro_createdtime','desc')
                            ->get('intro')
                            ->result_array();
        return $query;
    }

    public function count_intropages(){
        $query = $this->db->where('intro_status !=','discard')
                            ->order_by('intro_createdtime','desc')
                            ->count_all_results('intro');
        return $query;
    }

    public function get_introinfo_byid( $introid=0 ){
        $query = $this->db->where('intro_id', $introid)
                            ->get('intro')
                            ->row_array();
        return $query;
    }

    public function create(){
        $message = array();

        $this->db->set('intro_type', $this->input->post('intro_type'));

        /* Add Type - Start */
        if( $this->input->post('intro_type') == 'image' ){
            /* Upload - Start */
            $uploadpath = realpath('').'/public/core/uploaded/intro';
            if(is_dir($uploadpath)===false){
                mkdir($uploadpath, 0777);
                chmod($uploadpath, 0777);
            }
                        
            $config['upload_path'] = $uploadpath;
            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = true;
                        
            $file = $this->uploadmodel->do_upload($config, 'intro_value', $_FILES['intro_value']);
            $uploadedError = false;
            if( $file == '' || is_file( realpath('public/core/uploaded/intro/'.$file) ) === false ){
                $uploadedError = true;
            }
            /* Upload - End */

            $this->db->set('intro_value', $file);

        }else{
            $this->db->set('intro_value', $this->input->post('intro_value'));
        }
        /* Add Type - End */

        $this->db->set('intro_url', $this->input->post('intro_url'));
        $this->db->set('intro_title', $this->input->post('intro_title'));
        $this->db->set('intro_start_date', date('Y-m-d', strtotime( $this->input->post('intro_start_date') )));
        $this->db->set('intro_end_date', ( $this->input->post('intro_end_date') != '' ? date('Y-m-d', strtotime( $this->input->post('intro_end_date') )) : null ));
        $this->db->set('intro_status', $this->input->post('intro_status'));
        $this->db->set('intro_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('intro_createdip', $this->input->ip_address());
        $this->db->insert('intro');

        if( $uploadedError === true ){
            $this->session->set_flashdata('message-warning', 'ไม่สามารถอัพโหลดรูปภาพได้');
        }

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
        
    }
    
    public function update($introid=0){
        $message = array();
        $info = $this->get_introinfo_byid( $introid );

        $this->db->set('intro_type', $this->input->post('intro_type'));

        /* Add Type - Start */
        if( $this->input->post('intro_type') == 'image' ){
            /* Upload - Start */
            $uploadpath = realpath('').'/public/core/uploaded/intro';
            if(is_dir($uploadpath)===false){
                mkdir($uploadpath, 0777);
                chmod($uploadpath, 0777);
            }
                        
            $config['upload_path'] = $uploadpath;
            $config['allowed_types'] = 'jpg|png|gif|jpeg';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = true;
                        
            $file = $this->uploadmodel->edit_upload($config, 'intro_value', $_FILES['intro_value'], $info['intro_value']);
            /* Upload - End */

            $this->db->set('intro_value', $file);

        }else{
            $this->db->set('intro_value', $this->input->post('intro_value'));
        }
        /* Add Type - End */

        $this->db->set('intro_url', $this->input->post('intro_url'));
        $this->db->set('intro_title', $this->input->post('intro_title'));
        $this->db->set('intro_start_date', date('Y-m-d', strtotime( $this->input->post('intro_start_date') )));
        $this->db->set('intro_end_date', ( $this->input->post('intro_end_date') != '' ? date('Y-m-d', strtotime( $this->input->post('intro_end_date') )) : null ));
        $this->db->set('intro_status', $this->input->post('intro_status'));
        $this->db->set('intro_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('intro_updatedip', $this->input->ip_address());
        $this->db->where('intro_id', $info['intro_id']);
        $this->db->update('intro');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
        
    }

    public function setStatus( $setto='approved', $introid=0 ){

        $message = array();
        $info = $this->get_introinfo_byid( $introid );

        $this->db->set('intro_status', $setto);
        $this->db->set('intro_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('intro_updatedip', $this->input->ip_address());
        $this->db->where('intro_id', $info['intro_id']);
        $this->db->update('intro');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;

    }

}

/* End of file Manageintropagemodel.php */
