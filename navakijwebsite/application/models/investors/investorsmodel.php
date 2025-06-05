<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Investorsmodel extends CI_Model {

    
    public function __construct(){
        parent::__construct();
    }
    
    public function get_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('categories')
                            ->row_array();
        return $query;
    }

    public function get_articles_bycategoryid( $categoryid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }
        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }
        $periodCondition = 'article_start_date <= "'.date("Y-m-d").'" AND ( article_end_date >= "'.date("Y-m-d").'" OR article_end_date is null )';
        $query = $this->db->where('category_id', $categoryid)
                            ->where('article_status','approved')
                            ->where( $periodCondition )
                            ->order_by('article_createdtime','desc')
                            ->get('articles')
                            ->result_array();
        return $query;
    }
    public function count_articles_list($categoryid=0){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('article_status','approved')
                            ->count_all_results('articles');
        return $query;

    }


    public function count_articles_bycategoryid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('article_status','approved')
                            ->order_by('article_createdtime','desc')
                            ->count_all_results('articles');
        return $query;
    }

    public function get_articleinfo_byid( $articleid=0 ){
        $query = $this->db->where('article_id', $articleid)
                            ->get('articles')
                            ->row_array();
        return $query;
    }

    public function get_document_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('document_categories')
                            ->row_array();
        return $query;
    }

    public function get_documents_bycategoryid( $categoryid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }
        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }
        $query = $this->db->where('category_id', $categoryid)
                            ->where('document_status','approved')
                            ->order_by('document_order','asc')
                            ->get('documents')
                            ->result_array();
        return $query;
    }

    public function count_document_list($categoryid=0){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('document_status','approved')
                            ->count_all_results('documents');
        return $query;

    }

    public function get_document_file_bydocumentid($documentid){
        $query = $this->db->where('document_id', $documentid)
                            ->where('document_file_status','approved')
                            ->order_by('document_file_createdtime','desc')
                            ->get('document_files')
                            ->result_array();
        return $query;
    }

}

/* End of file Investorsmodel.php */
