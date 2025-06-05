<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Manageiconsmodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }
    
    public function get_icons( $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('icon_status !=','discard')
                            ->order_by('icon_order','asc')
                            ->get('icons')
                            ->result_array();
        return $query;
    }

    public function count_icons(){
        $query = $this->db->where('icon_status !=','discard')
                            ->order_by('icon_order','asc')
                            ->count_all_results('icons');
        return $query;
    }

    public function get_iconinfo_byid( $iconid=0 ){
        $query = $this->db->where('icon_id', $iconid)
                            ->get('icons')
                            ->row_array();
        return $query;
    }

    public function get_iconinfo_byorder( $order=0 ){
        $query = $this->db->where('icon_order', $order)
                            ->where('icon_status !=','discard')
                            ->limit(1)
                            ->get('icons')
                            ->row_array();
        return $query;
    }

    public function reOrder(){
        $lists = $this->get_icons();
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;

                $this->db->set('icon_order', $i);
                $this->db->where('icon_id', $list['icon_id']);
                $this->db->update('icons');
            }
        }
    }

    public function create(){
        $message = array();

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/icons';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 1024;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'icon_image', $_FILES['icon_image']);
        /* Upload - End */

        $total = $this->count_icons();
        $newOrder = 0;

        $this->db->set('icon_image', $file);
        $this->db->set('icon_title_th', $this->input->post('icon_title_th'));
        $this->db->set('icon_title_en', $this->input->post('icon_title_en'));
        $this->db->set('icon_order', $newOrder);
        $this->db->set('icon_status', $this->input->post('icon_status'));
        $this->db->set('icon_createdtime',date("Y-m-d H:i:s"));
        $this->db->set('icon_createdip', $this->input->ip_address());
        $this->db->insert('icons');

        $this->reOrder();

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update(){
        $message = array();
        $info = $this->get_iconinfo_byid( $this->input->post('icon_id') );

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/icons';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 1024;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->edit_upload($config, 'icon_image', $_FILES['icon_image'], $info['icon_image']);
        /* Upload - End */

        $this->db->set('icon_image', $file);
        $this->db->set('icon_title_th', $this->input->post('icon_title_th'));
        $this->db->set('icon_title_en', $this->input->post('icon_title_en'));
        $this->db->set('icon_status', $this->input->post('icon_status'));
        $this->db->set('icon_updatedtime',date("Y-m-d H:i:s"));
        $this->db->set('icon_updatedip', $this->input->ip_address());
        $this->db->where('icon_id', $info['icon_id']);
        $this->db->update('icons');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto='approved', $iconid=0 ){
        
        $message = array();
        $info = $this->get_iconinfo_byid( $iconid );

        $this->db->set('icon_status', $setto);
        $this->db->set('icon_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('icon_updatedip', $this->input->ip_address());
        $this->db->where('icon_id', $info['icon_id']);
        $this->db->update('icons');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';

            $this->reOrder();
        }else{
            $message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
        }
        
        $message['status'] = 'message-success';
        return $message;

    }

    public function setOrder( $movement='up', $iconid=0 ){
        $message = array();
        $info = $this->get_iconinfo_byid( $iconid );
        $total = $this->count_icons();

        if( $movement == 'up' ){
            $newOrder = intval($info['icon_order'] - 1);
            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{
                $exists = $this->get_iconinfo_byorder( $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['icon_order'] + 1 );
                    $this->db->set('icon_order', $exists_newOrder);
                    $this->db->where('icon_id', $exists['icon_id']);
                    $this->db->update('icons');
                }

                $this->db->set('icon_order', $newOrder);
                $this->db->where('icon_id', $info['icon_id']);
                $this->db->update('icons');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกการจัดลำดับข้อมูลสำเร็จ'
                );
            }
        }else if( $movement == 'down' ){
            $newOrder = intval($info['icon_order'] + 1);
            if( $newOrder > $total ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
                );
            }else{
                $exists = $this->get_iconinfo_byorder( $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['icon_order'] + 1 );
                    $this->db->set('icon_order', $exists_newOrder);
                    $this->db->where('icon_id', $exists['icon_id']);
                    $this->db->update('icons');
                }

                $this->db->set('icon_order', $newOrder);
                $this->db->where('icon_id', $info['icon_id']);
                $this->db->update('icons');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกการจัดลำดับข้อมูลสำเร็จ'
                );
            }
        }else{
            $message = array(
                'status' => 'message-error',
                'text' => 'ไม่สามาถจัดลำดับได้'
            );
        }

        return $message;
    }

}

/* End of file Manageiconsmodel.php */
