<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managenavigationsmodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }
    
    public function get_navigations( $mainid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('main_id', $mainid)
                            ->where('nav_status !=','discard')
                            ->order_by('nav_order','asc')
                            ->get('navigations')
                            ->result_array();
        return $query;
    }

    public function count_navigations( $mainid=0 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('nav_status !=','discard')
                            ->order_by('nav_order','asc')
                            ->count_all_results('navigations');
        return $query;
    }

    public function get_navigationinfo_byid( $navid=0 ){
        $query = $this->db->where('nav_id', $navid)
                            ->get('navigations')
                            ->row_array();
        return $query;
    }

    public function get_navigationinfo_byorder( $mainid=0, $order=0 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('nav_order', $order)
                            ->where('nav_status !=','discard')
                            ->limit(1)
                            ->get('navigations')
                            ->row_array();
        return $query;
    }

    public function reOrder( $mainid=0 ){
        $lists = $this->get_navigations( $mainid );
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;
                $this->db->set('nav_order', $i);
                $this->db->where('nav_id', $list['nav_id']);
                $this->db->update('navigations');
            }
        }
    }

    public function create(){
        $message = array();

        $total = $this->count_navigations( $this->input->post('main_id') );
        $newOrder = 0;

        $this->db->set('main_id', $this->input->post('main_id'));
        $this->db->set('content_type', $this->input->post('content_type'));
        if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
            $this->db->set('category_id', $this->input->post('category_id'));
            $this->db->set('content_id', $this->input->post('content_id'));
        }
        if( $this->input->post('content_type') == 'external_link' ){
            $this->db->set('nav_external_url', $this->input->post('nav_external_url'));
        }
        if( $this->input->post('content_type') == 'internal_link' ){
            $this->db->set('nav_internal_url', $this->input->post('nav_internal_url'));
        }
        $this->db->set('is_newtab', $this->input->post('is_newtab'));
        $this->db->set('nav_title_th', $this->input->post('nav_title_th'));
        $this->db->set('nav_title_en', $this->input->post('nav_title_en'));
        $this->db->set('nav_order', $newOrder);
        $this->db->set('nav_status', $this->input->post('nav_status'));
        $this->db->set('nav_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('nav_createdip', $this->input->ip_address());
        $this->db->insert('navigations');

        $this->reOrder( $this->input->post('main_id') );

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;

    }

    public function update(){
        $message = array();

        $info = $this->get_navigationinfo_byid( $this->input->post('nav_id') );

        $this->db->set('main_id', $this->input->post('main_id'));
        $this->db->set('content_type', $this->input->post('content_type'));
        if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
            $this->db->set('category_id', $this->input->post('category_id'));
            $this->db->set('content_id', $this->input->post('content_id'));
        }
        if( $this->input->post('content_type') == 'external_link' ){
            $this->db->set('nav_external_url', $this->input->post('nav_external_url'));
        }
        if( $this->input->post('content_type') == 'internal_link' ){
            $this->db->set('nav_internal_url', $this->input->post('nav_internal_url'));
        }
        $this->db->set('is_newtab', $this->input->post('is_newtab'));
        $this->db->set('nav_title_th', $this->input->post('nav_title_th'));
        $this->db->set('nav_title_en', $this->input->post('nav_title_en'));
        $this->db->set('nav_status', $this->input->post('nav_status'));
        $this->db->set('nav_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('nav_updatedip', $this->input->ip_address());
        $this->db->where('nav_id', $info['nav_id']);
        $this->db->update('navigations');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;

    }

    public function setStatus( $setto='approved', $navid=0 ){
        $message = array();
        $info = $this->get_navigationinfo_byid( $navid );

        $this->db->set('nav_status', $setto);
        $this->db->set('nav_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('nav_updatedip', $this->input->ip_address());
        $this->db->where('nav_id', $info['nav_id']);
        $this->db->update('navigations');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
            $this->reOrder( $info['main_id'] );
        }else{
            $message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }

    public function setOrder( $movement='up', $navid=0 ){
        $message = array();
        $info = $this->get_navigationinfo_byid( $navid );
        $total = $this->count_navigations( $info['main_id'] );

        if( $movement == 'up' ){
            $newOrder = intval( $info['nav_order'] - 1 );
            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'messages-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{
                $exists = $this->get_navigationinfo_byorder( $info['main_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['nav_order'] + 1 );
                    $this->db->set('nav_order', $exists_newOrder);
                    $this->db->where('nav_id', $exists['nav_id']);
                    $this->db->update('navigations');
                }

                $this->db->set('nav_order', $newOrder);
                $this->db->where('nav_id', $info['nav_id']);
                $this->db->update('navigations');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );
            }
        }else if( $movement == 'down' ){
            $newOrder = intval( $info['nav_order'] + 1);
            if( $newOrder > $total ){
                $message = array(
                    'status' => 'messages-warning',
                    'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
                );
            }else{
                $exists = $this->get_navigationinfo_byorder( $info['main_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['nav_order'] - 1 );
                    $this->db->set('nav_order', $exists_newOrder);
                    $this->db->where('nav_id', $exists['nav_id']);
                    $this->db->update('navigations');
                }

                $this->db->set('nav_order', $newOrder);
                $this->db->where('nav_id', $info['nav_id']);
                $this->db->update('navigations');

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

    public function get_static_pages(){
        $query = $this->db->where('page_status','approved')
                            ->order_by('page_id','asc')
                            ->get('static_pages')
                            ->result_array();
        return $query;
    }

    public function get_article_categories($mainid=0){
        $query = $this->db->where('main_id', $mainid)
                            ->where('category_status !=','discard')
                            ->order_by('category_order','asc')
                            ->get('categories')
                            ->result_array();
        return $query;
    }

    public function get_insurance_categories(){
        $query = $this->db->select('insurance_category_id as `category_id`, insurance_category_title_th as `category_title_th`, insurance_category_title_en as `category_title_en`')
                            ->where('insurance_category_status !=','discard')
                            ->order_by('insurance_category_order','asc')
                            ->get('insurance_categories')
                            ->result_array();
        return $query;
    }

    public function get_document_categories( $mainid=0 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('category_status !=','discard')
                            ->order_by('category_order','asc')
                            ->get('document_categories')
                            ->result_array();
        return $query;
    }

    public function get_articles( $categoryid=0 ){
        $query = $this->db->select('article_id as `content_id`, article_title_th as `content_title_th`, article_title_en as `content_title_en`')
                            ->where('category_id', $categoryid)
                            ->where('article_status !=','discard')
                            ->order_by('article_createdtime','desc')
                            ->get('articles')
                            ->result_array();
        return $query;
    }

    public function get_insurances( $categoryid=0 ){
        $query = $this->db->select('insurance_id as `content_id`, insurance_title_th as `content_title_th`, insurance_title_en as `content_title_en`')
                            ->where('insurance_category_id', $categoryid)
                            ->where('insurance_status !=','discard')
                            ->order_by('insurance_createdtime','desc')
                            ->get('insurance')
                            ->result_array();
        return $query;
    }

    public function get_documents( $categoryid=0 ){
        $query = $this->db->select('document_id as `content_id`, document_title_th as `content_title_th`, document_title_en as `content_title_en`')
                            ->where('category_id', $categoryid)
                            ->where('document_status !=','discard')
                            ->order_by('document_createdtime','desc')
                            ->get('documents')
                            ->result_array();
        return $query;
    }

}

/* End of file Managenavigationsmodel.php */
