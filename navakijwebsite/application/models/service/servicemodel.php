<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Servicemodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_categories( $mainid=1 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('category_status','approved')
                            ->order_by('category_order','asc')
                            ->get('categories')
                            ->result_array();
        return $query;
    }
    
    public function get_categoryinfo( $category='' ){
        $query = $this->db->where('category_meta_url', $category)
                            ->where('category_status','approved')
                            ->order_by('category_createdtime','desc')
                            ->limit(1)
                            ->get('categories')
                            ->row_array();
        return $query;
    }

    public function get_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('categories')
                            ->row_array();
        return $query;
    }

    public function get_documents_categories( $mainid=1 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('category_status','approved')
                            ->order_by('category_order','asc')
                            ->get('document_categories')
                            ->result_array();
        return $query;
    }

    public function get_document_categoryinfo( $category='' ){
        $query = $this->db->where('category_meta_url', $category)
                            ->where('category_status','approved')
                            ->order_by('category_createdtime','desc')
                            ->limit(1)
                            ->get('document_categories')
                            ->row_array();
        return $query;
    }

    public function get_document_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('document_categories')
                            ->row_array();
        return $query;
    }

    public function get_articles_bycategoryid( $categoryid=0 ){
        $periodCondition = 'article_start_date <= "'.date("Y-m-d").'" AND ( article_end_date >= "'.date("Y-m-d").'" OR article_end_date is null )';
        $query = $this->db->where('category_id', $categoryid)
                            ->where('article_status','approved')
                            ->where( $periodCondition )
                            ->order_by('article_createdtime','desc')
                            ->get('articles')
                            ->result_array();
        return $query;
    }

    public function get_articleinfo_byid( $articleid=0 ){
        $query = $this->db->where('article_id', $articleid)
                            ->get('articles')
                            ->row_array();
        return $query;
    }

    public function get_documents_bycategoryid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('document_status','approved')
                            ->order_by('document_createdtime','desc')
                            ->get('documents')
                            ->result_array();
        return $query;
    }

    public function get_documentinfo_byid( $documentid=0 ){
        $query = $this->db->where('document_id', $documentid)
                            ->get('documents')
                            ->row_array();
        return $query;
    }

    public function get_files_bydocumentid( $documentid=0 ){
        $query = $this->db->where('document_id', $documentid)
                            ->where('document_file_status','approved')
                            ->order_by('document_file_createdtime','desc')
                            ->get('document_files')
                            ->result_array();
        return $query;
    }

}

/* End of file Servicemodel.php */
