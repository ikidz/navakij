<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managedocumentcategoriesmodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }
    
    public function get_categories( $mainid=0, $limit=0, $offset=0 ){

        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('main_id', $mainid)
                            ->where('category_status !=','discard')
                            ->order_by('category_order','asc')
                            ->get('document_categories')
                            ->result_array();
        return $query;
    }

    public function count_categories( $mainid=0 ){

        $query = $this->db->where('main_id', $mainid)
                            ->where('category_status !=','discard')
                            ->order_by('category_order','asc')
                            ->count_all_results('document_categories');
        return $query;
    }

    public function get_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('document_categories')
                            ->row_array();
        return $query;
    }

    public function get_categoryinfo_byorder( $mainid=0, $order=0 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('category_order', $order)
                            ->where('category_status !=','discard')
                            ->limit(1)
                            ->get('document_categories')
                            ->row_array();
        return $query;
    }

    public function reOrder( $mainid=0 ){
        $lists = $this->get_categories( $mainid );
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;
                $this->db->set('category_order', $i);
                $this->db->where('category_id', $list['category_id']);
                $this->db->update('document_categories');
            }
        }
    }

    public function create(){
        $message = array();

        $total = $this->count_categories( $this->input->post('main_id') );
        $newOrder = 0;

        /* Generate META URL - Start */
        $metaURL = $this->input->post('category_title_en');
		$validatedURL = validate_meta_url( $metaURL, 'document_categories', 'category_' );
        /* Generate META URL - End */

        $this->db->set('main_id', $this->input->post('main_id'));
        $this->db->set('category_title_th', $this->input->post('category_title_th'));
        $this->db->set('category_title_en', $this->input->post('category_title_en'));
        $this->db->set('category_order', $newOrder);
        $this->db->set('category_meta_url', $validatedURL);
        $this->db->set('category_status', $this->input->post('category_status'));
        $this->db->set('category_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('category_createdip', $this->input->ip_address());
        $this->db->insert('document_categories');

        $this->reOrder( $this->input->post('main_id') );

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update(){
        $message = array();
        $info = $this->get_categoryinfo_byid( $this->input->post('category_id') );

        /* Generate META URL - Start */
        $metaURL = $this->input->post('category_meta_url');
		$validatedURL = validate_meta_url( $metaURL, 'document_categories', 'category_', $info['category_id'] );
        /* Generate META URL - End */

        $this->db->set('main_id', $this->input->post('main_id'));
        $this->db->set('category_title_th', $this->input->post('category_title_th'));
        $this->db->set('category_title_en', $this->input->post('category_title_en'));
        $this->db->set('category_meta_url', $validatedURL);
        $this->db->set('category_status', $this->input->post('category_status'));
        $this->db->set('category_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('category_updatedip', $this->input->ip_address());
        $this->db->where('category_id', $this->input->post('category_id'));
        $this->db->update('document_categories');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto = 'discard', $categoryid=0 ){
        $message = array();
        $info = $this->get_categoryinfo_byid( $categoryid );

        $this->db->set('category_status', $setto);
        $this->db->set('category_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('category_updatedip', $this->input->ip_address());
        $this->db->where('category_id', $info['category_id']);
        $this->db->update('document_categories');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
            $this->reOrder( $info['main_id'] );
        }else{
            $message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }

    public function setOrder( $movement='up', $categoryid=0 ){
        $message = array();
        $info = $this->get_categoryinfo_byid( $categoryid );
        $total = $this->count_categories( $info['main_id'] );

        if( $movement == 'up' ){
            $newOrder = intval( $info['category_order'] - 1 );
            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{

                $exists = $this->get_categoryinfo_byorder( $info['main_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['category_order'] + 1 );
                    $this->db->set('category_order', $exists_newOrder);
                    $this->db->where('category_id', $exists['category_id']);
                    $this->db->update('document_categories');
                }

                $this->db->set('category_order', $newOrder);
                $this->db->where('category_id', $info['category_id']);
                $this->db->update('document_categories');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );

            }
        }else if( $movement == 'down' ){
            $newOrder = intval( $info['category_order'] + 1 );
            if( $newOrder > $total ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
                );
            }else{

                $exists = $this->get_categoryinfo_byorder( $info['main_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['category_order'] - 1 );
                    $this->db->set('category_order', $exists_newOrder);
                    $this->db->where('category_id', $exists['category_id']);
                    $this->db->update('document_categories');
                }

                $this->db->set('category_order', $newOrder);
                $this->db->where('category_id', $info['category_id']);
                $this->db->update('document_categories');

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

/* End of file Managedocumentcategoriesmodel.php */
