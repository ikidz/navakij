<?php
class Managemappingurlsmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_maps( $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('map_status !=','discard')
                            ->order_by('map_createdtime','desc')
                            ->get('mapping_urls')
                            ->result_array();
        return $query;
    }

    public function count_maps(){
        $query = $this->db->where('map_status !=','discard')
                            ->order_by('map_createdtime','desc')
                            ->count_all_results('mapping_urls');
        return $query;
    }

    public function get_mapinfo_byid( $mapid=0 ){
        $query = $this->db->where('map_id', $mapid)
                            ->get('mapping_urls')
                            ->row_array();
        return $query;
    }

    public function create(){
        $message = array();

        print_r( $this->input->post() );

        $this->db->set('map_origin', $this->input->post('map_origin'));
        $this->db->set('content_type', $this->input->post('content_type'));
        if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
            $this->db->set('category_id', $this->input->post('category_id'));
            $this->db->set('content_id', $this->input->post('content_id'));
        }
        if( $this->input->post('content_type') == 'external_link' ){
            $this->db->set('map_external_url', $this->input->post('map_external_url'));
        }
        if( $this->input->post('content_type') == 'internal_link' ){
            $this->db->set('map_internal_url', $this->input->post('map_internal_url'));
        }
        $this->db->set('is_newtab', $this->input->post('is_newtab'));
        $this->db->set('map_status', $this->input->post('map_status'));
        $this->db->set('map_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('map_createdip', $this->input->ip_address());
        $this->db->insert('mapping_urls');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update( $mapid=0 ){
        $message = array();
        $info = $this->get_mapinfo_byid( $mapid );

        $this->db->set('map_origin', $this->input->post('map_origin'));
        $this->db->set('content_type', $this->input->post('content_type'));
        if( in_array( $this->input->post('content_type'), array('insurance','articles','documents') ) === true ){
            $this->db->set('category_id', $this->input->post('category_id'));
            $this->db->set('content_id', $this->input->post('content_id'));
        }
        if( $this->input->post('content_type') == 'external_link' ){
            $this->db->set('map_external_url', $this->input->post('map_external_url'));
        }
        if( $this->input->post('content_type') == 'internal_link' ){
            $this->db->set('map_internal_url', $this->input->post('map_internal_url'));
        }
        $this->db->set('is_newtab', $this->input->post('is_newtab'));
        $this->db->set('map_status', $this->input->post('map_status'));
        $this->db->set('map_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('map_updatedip', $this->input->ip_address());
        $this->db->where('map_id', $info['map_id']);
        $this->db->update('mapping_urls');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto='approved', $mapid=0 ){
        $message = array();
        $info = $this->get_mapinfo_byid( $mapid );

        $this->db->set('map_status', $setto);
        $this->db->set('map_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('map_updatedip', $this->input->ip_address());
        $this->db->where('map_id', $info['map_id']);
        $this->db->update('navigations');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

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
?>