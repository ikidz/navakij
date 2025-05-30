<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Article_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		
    }

    public function get_knowledge_categories(){
        $query = $this->db->where_in('main_id', 26)
                            ->where('category_status','approved')
                            ->order_by('category_order','asc')
                            ->get('categories')
                            ->result_array();
        return $query;
    }
    
    public function get_news_categories(){
        $query = $this->db->where_in('main_id', 23)
                            ->where('category_status','approved')
                            ->order_by('category_order','asc')
                            ->get('categories')
                            ->result_array();
        return $query;
    }

    public function get_category_info($categoryid){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('category_status','approved')
                            ->get('categories')
                            ->row_array();
        return $query;
    }

    public function get_news_list($categoryid, $limit=6, $offset=0){

        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $where = 'category_id = "'.$categoryid.'" AND article_status = "approved" AND article_start_date <= "'.date("Y-m-d").'" AND ( article_end_date >= "'.date("Y-m-d").'" OR article_end_date is null )';
        
        $query = $this->db->where($where)
                            ->order_by('article_postdate','desc')
                            // ->order_by('article_createdtime','asc')
                            ->get('articles')
                            ->result_array();

        return $query;
    }

    public function count_news_list($categoryid){
        $where = 'category_id = "'.$categoryid.'" AND article_status = "approved" AND article_start_date <= "'.date("Y-m-d").'" AND ( article_end_date >= "'.date("Y-m-d").'" OR article_end_date is null )';
        $query = $this->db->where($where)
                            ->count_all_results('articles');
        return $query;

    }

    public function get_article_info($articleid=0){
        $query = $this->db->where('article_id', $articleid)
                            ->where('article_status','approved')
                            ->get('articles')
                            ->row_array();
        return $query;
    }

    public function get_news_search_list($s_data=array(),$limit=6, $offset=0){

        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        if( $s_data['keywords'] != '' ){
			$keyword = htmlspecialchars( $s_data['keywords'] );
			$conditions = '(
				article_title_'.$this->_language.' like "%'.$keyword.'%" AND
                article_status = "approved" AND 
                article_start_date <= "'.date("Y-m-d").'" AND 
                (
                    article_end_date >= "'.date("Y-m-d").'" OR 
                    article_end_date is null
                )
			)';
			$query = $this->db->where( $conditions );
        }else{
            $conditions = '(
                article_status = "approved" AND 
                article_start_date <= "'.date("Y-m-d").'" AND 
                (
                    article_end_date >= "'.date("Y-m-d").'" OR 
                    article_end_date is null
                )
			)';
			$query = $this->db->where( $conditions );
        }
        
        $query = $this->db->order_by('article_postdate','desc')
                            ->get('articles')
                            ->result_array();
        return $query;
    }

    public function count_news_search_list($s_data=array()){

        if( $s_data['keywords'] != '' ){
			$keyword = htmlspecialchars( $s_data['keywords'] );
			$conditions = '(
				article_title_'.$this->_language.' like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
        }

        $query = $this->db->where('article_status','approved')
                            ->count_all_results('articles');
        return $query;

    }
	
    public function get_galleries_byarticleid( $articleid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }
        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }
        $query = $this->db->where('article_id', $articleid)
                            ->where('gallery_status','approved')
                            ->order_by('gallery_createdtime','desc')
                            ->get('galleries')
                            ->result_array();
        return $query;
    }

    public function get_hidden_article_info( $articleid=0 ){
        $query = $this->db->where('article_id', $articleid)
                            ->where('article_status','approved')
                            ->get('hidden_articles')
                            ->row_array();
        return $query;
    }

    public function get_hidden_document_info( $documentid=0 ){
        $query = $this->db->where('document_id', $documentid)
                            ->where('document_status','approved')
                            ->get('hidden_documents')
                            ->row_array();
        return $query;
    }

}