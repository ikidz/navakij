<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managegallerymodel extends CI_Model {

    var $_data;
    public function __construct()
    {
        parent::__construct();
    }

    public function get_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('categories')
                            ->row_array();
        return $query;
    }

    public function get_articleinfo_byid( $articleid=0 ){
        $query = $this->db->where('article_id', $articleid)
                            ->get('articles')
                            ->row_array();
        return $query;
    }

    public function get_galleries( $articleid=0, $limit, $offset=0){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('article_id', $articleid)
                            ->where('gallery_status !=','discard')
                            ->order_by('gallery_createdtime','desc')
                            ->get('galleries')
                            ->result_array();
        return $query;
    }

    public function count_galleries( $articleid=0 ){
        $query = $this->db->where('article_id', $articleid)
                            ->where('gallery_status !=','discard')
                            ->order_by('gallery_createdtime','desc')
                            ->count_all_results('galleries');
        return $query;
    }

    public function get_galleryinfo_byid( $galleryid=0 ){
        $query = $this->db->where('gallery_id', $galleryid)
                            ->get('galleries')
                            ->row_array();
        return $query;
    }

    public function create( $articleid=0 ){

        $data = [];

        $count = count($_FILES['gallery-photo-add']['name']);
        $totalUploaded = 0;

        for($i=0;$i<$count;$i++){

            if(!empty($_FILES['gallery-photo-add']['name'][$i])){

                $_FILES['gallery_image']['name'] = $_FILES['gallery-photo-add']['name'][$i];
                $_FILES['gallery_image']['type'] = $_FILES['gallery-photo-add']['type'][$i];
                $_FILES['gallery_image']['tmp_name'] = $_FILES['gallery-photo-add']['tmp_name'][$i];
                $_FILES['gallery_image']['error'] = $_FILES['gallery-photo-add']['error'][$i];
                $_FILES['gallery_image']['size'] = $_FILES['gallery-photo-add']['size'][$i];

                /* Upload - Start */
                $mainPath = realpath('').'/public/core/uploaded/article/galleries';
                if(is_dir($mainPath)===false){
                    mkdir($mainPath, 0777);
                    chmod($mainPath, 0777);
                }

                $uploadpath = $mainPath.'/'.$articleid;
                if(is_dir($uploadpath)===false){
                    mkdir($uploadpath, 0777);
                    chmod($uploadpath, 0777);
                }
                            
                $config['upload_path'] = $uploadpath;
                $config['allowed_types'] = 'jpg|png|gif|jpeg';
                $config['max_size'] = 2048;
                $config['encrypt_name'] = true;
                            
                $file = $this->uploadmodel->do_upload($config, 'gallery_image', $_FILES['gallery_image']);
                /* Upload - End */

                $this->db->set('article_id', $articleid);
                $this->db->set('gallery_image', $file);
                $this->db->set('gallery_status','approved');
                $this->db->set('gallery_createdtime', date("Y-m-d H:i:s"));
                $this->db->set('gallery_createdip', $this->input->ip_address());
                $this->db->insert('galleries');

                if( $file != '' ){
                    $totalUploaded++;
                }

            }

        }

        if( $totalUploaded == $count ){
            $message['status'] = 'message-success';
            $message['text'] = 'อัพโหลดรูปภาพสำเร็จ จำนวน '.$totalUploaded.' รูปภาพ';
        }else if( $totalUploaded < $count && $totalUploaded > 0 ){
            $message['status'] = 'message-warning';
            $message['text'] = 'อัพโหลดรูปภาพสำเร็จ จำนวน '.$totalUploaded.' รูปภาพ จากทั้งหมด '.$count.' รูป';
        }else{
            $message['status'] = 'message-error';
            $message['text'] = 'กรุณาเลือกรูปภาพที่ต้องการอัพโหลด';
        }

        return $message;

    }

    public function setStatus( $setto='approved', $articleid=0, $galleryid=0 ){
        $message = array();

        $info = $this->get_galleryinfo_byid( $galleryid );

        $this->db->set('gallery_status', $setto);
        $this->db->set('gallery_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('gallery_updatedip', $this->input->ip_address());
        $this->db->where('gallery_id', $info['gallery_id']);
        $this->db->update('galleries');
        
        if( $setto == 'discard' ){
            
            if( is_file( realpath('public/core/uploaded/article/galleries/'.$articleid.'/'.$info['gallery_image']) ) === true ){
                unlink( realpath('public/core/uploaded/article/galleries/'.$articleid.'/'.$info['gallery_image']) );
            }

        }

        $message['status'] = 'message-success';
        if( $setto == 'discard' ){
            $message['text'] = 'ลบรูปภาพสำเร็จ';
        }else{
            $message['text'] = 'บันทึกข้อมูลสถานะการแสดงผลสำเร็จ';
        }

        return $message;
    }

    public function setBulkStatus( $setto='approved', $articleid=0, $lists = array() ){
        $message = array();

        $totalSelected = count( $lists );
        $error = 0;
        $success = 0;

        if( isset( $lists ) && $totalSelected > 0 ){
            foreach( $lists as $list ){

                $response = array();
                $response = $this->setStatus( $setto, $articleid, $list );
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
    

}

/* End of file Managegallerymodel.php */
