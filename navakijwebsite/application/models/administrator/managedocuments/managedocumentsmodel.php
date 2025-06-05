<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managedocumentsmodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }
    
    public function get_documents( $categoryid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('category_id', $categoryid)
                            ->where('document_status !=','discard')
                            ->order_by('document_order','asc')
                            ->get('documents')
                            ->result_array();
        return $query;
    }

    public function count_documents( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('document_status !=','discard')
                            ->order_by('document_order','asc')
                            ->count_all_results('documents');
        return $query;
    }

    public function get_documentinfo_byid( $documentid=0 ){
        $query = $this->db->where('document_id', $documentid)
                            ->get('documents')
                            ->row_array();
        return $query;
    }

    public function get_documentinfo_byorder( $categoryid=0, $order=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('document_order', $order)
                            ->where('document_status !=','discard')
                            ->limit(1)
                            ->get('documents')
                            ->row_array();
        return $query;
    }

    public function get_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('document_categories')
                            ->row_array();
        return $query;
    }

    public function reOrder( $categoryid=0 ){
        $lists = $this->get_documents( $categoryid );
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;
                $this->db->set('document_order', $i);
                $this->db->where('document_id', $list['document_id']);
                $this->db->update('documents');
            }
        }
    }

    public function create(){
        $message = array();
        $category = $this->get_categoryinfo_byid( $this->input->post('category_id') );

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/documents';
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
        $uploadpath = realpath('').'/public/core/uploaded/documents';
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

        /* Upload - Start */
        $thumbPath = $uploadpath.'/thumbnail';
        if(is_dir($thumbPath)===false){
            mkdir($thumbPath, 0777);
            chmod($thumbPath, 0777);
        }
                    
        $config['upload_path'] = $thumbPath;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $thumb = $this->uploadmodel->do_upload($config, 'document_thumbnail', $_FILES['document_thumbnail']);
        /* Upload - End */

        $total = $this->count_documents( $category['category_id'] );
        $newOrder = 0;

        /* Generate META URL - Start */
        $metaURL = $category['category_meta_url'].'/'.$this->input->post('document_title_en');
				$validatedURL = validate_meta_url( $metaURL, 'documents', 'document_' );
        /* Generate META URL - End */

        $this->db->set('category_id', $category['category_id']);
        $this->db->set('document_thumbnail', $thumb);
        $this->db->set('document_type', $this->input->post('document_type'));
        $this->db->set('document_file', $file);
        $this->db->set('document_file_en', $file_en);
        $this->db->set('document_title_th', $this->input->post('document_title_th'));
        $this->db->set('document_title_en', $this->input->post('document_title_en'));
				$this->db->set('document_url_th', $this->input->post('document_url_th'));
				$this->db->set('document_url_en', $this->input->post('document_url_en'));
        $this->db->set('document_desc_th', $this->input->post('document_desc_th'));
        $this->db->set('document_desc_en', $this->input->post('document_desc_en'));
        $this->db->set('document_publish_date', date("Y-m-d", strtotime( $this->input->post('document_publish_date') ) ));
        $this->db->set('document_meta_title', $this->input->post('document_meta_title'));
        $this->db->set('document_meta_description', $this->input->post('document_meta_description'));
        $this->db->set('document_meta_keywords', $this->input->post('document_meta_keywords'));
        $this->db->set('document_meta_url', $validatedURL);
        $this->db->set('document_order', $newOrder);
        $this->db->set('document_status', $this->input->post('document_status'));
        $this->db->set('document_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('document_createdip', $this->input->ip_address());
        $this->db->insert('documents');

        $this->reOrder( $category['category_id'] );

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update(){
        $message = array();
        $category = $this->get_categoryinfo_byid( $this->input->post('category_id') );
        $info = $this->get_documentinfo_byid( $this->input->post('document_id') );

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/documents';
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
        $uploadpath = realpath('').'/public/core/uploaded/documents';
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

        /* Upload - Start */
        $thumbPath = $uploadpath.'/thumbnail';
        if(is_dir($thumbPath)===false){
            mkdir($thumbPath, 0777);
            chmod($thumbPath, 0777);
        }
                    
        $config['upload_path'] = $thumbPath;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $thumb = $this->uploadmodel->edit_upload($config, 'document_thumbnail', $_FILES['document_thumbnail'], $info['document_thumbnail']);
        /* Upload - End */

        /* Generate META URL - Start */
        $metaURL = $this->input->post('document_meta_url');
		$validatedURL = validate_meta_url( $metaURL, 'documents', 'document_', $info['document_id'] );
        /* Generate META URL - End */

        $this->db->set('category_id', $category['category_id']);
        $this->db->set('document_thumbnail', $thumb);
        $this->db->set('document_type', $this->input->post('document_type'));
        $this->db->set('document_file', $file);
        $this->db->set('document_file_en', $file_en);
        $this->db->set('document_title_th', $this->input->post('document_title_th'));
        $this->db->set('document_title_en', $this->input->post('document_title_en'));
				$this->db->set('document_url_th', $this->input->post('document_url_th'));
				$this->db->set('document_url_en', $this->input->post('document_url_en'));
        $this->db->set('document_desc_th', $this->input->post('document_desc_th'));
        $this->db->set('document_desc_en', $this->input->post('document_desc_en'));
        $this->db->set('document_publish_date', date("Y-m-d", strtotime( $this->input->post('document_publish_date') ) ));
        $this->db->set('document_meta_title', $this->input->post('document_meta_title'));
        $this->db->set('document_meta_description', $this->input->post('document_meta_description'));
        $this->db->set('document_meta_keywords', $this->input->post('document_meta_keywords'));
        $this->db->set('document_meta_url', $validatedURL);
        $this->db->set('document_status', $this->input->post('document_status'));
        $this->db->set('document_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('document_updatedip', $this->input->ip_address());
        $this->db->where('document_id', $info['document_id']);
        $this->db->update('documents');

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
        $this->db->update('documents');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
            $this->reOrder( $info['category_id'] );
        }else{
            $message['text'] = 'บันทึกข้อมูลสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }

    public function setOrder( $movement='up', $documentid=0 ){
        $message = array();
        $info = $this->get_documentinfo_byid( $documentid );
        $total = $this->count_documents( $info['category_id'] );

        if( $movement == 'up' ){
            $newOrder = intval( $info['document_order'] - 1 );
            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{
                $exists = $this->get_documentinfo_byorder( $info['category_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['document_order'] + 1 );
                    $this->db->set('document_order', $exists_newOrder);
                    $this->db->where('document_id', $exists['document_id']);
                    $this->db->update('documents');
                }

                $this->db->set('document_order', $newOrder);
                $this->db->where('document_id', $info['document_id']);
                $this->db->update('documents');
                
                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );
            }
        }else if( $movement == 'down' ){
            $newOrder = intval( $info['document_order'] + 1 );
            if( $newOrder > $total ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
                );
            }else{
                $exists = $this->get_documentinfo_byorder( $info['category_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['document_order'] - 1 );
                    $this->db->set('document_order', $exists_newOrder);
                    $this->db->where('document_id', $exists['document_id']);
                    $this->db->update('documents');
                }

                $this->db->set('document_order', $newOrder);
                $this->db->where('document_id', $info['document_id']);
                $this->db->update('documents');
                
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

/* End of file Managedocumentsmodel.php */
