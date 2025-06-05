<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Homemodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_product_categories(){
        $query = $this->db->where('insurance_category_status','approved')
                            ->order_by('insurance_category_order','asc')
                            ->get('insurance_categories')
                            ->result_array();
        return $query;
    }

    public function get_latest_article_bycategoryid( $categoryid=0 ){
        $periodCondition = 'article_start_date <= "'.date("Y-m-d").'" AND ( article_end_date >= "'.date("Y-m-d").'" OR article_end_date is null )';
        $query = $this->db->where('category_id', $categoryid)
                            ->where('article_status','approved')
                            //->order_by('article_postdate','desc')
                            ->where( $periodCondition )
                            ->order_by('article_createdtime','desc')
                            ->limit(1)
                            ->get('articles')
                            ->row_array();
        return $query;
    }

    public function get_latest_news(){
        $periodCondition = 'article_start_date <= "'.date("Y-m-d").'" AND ( article_end_date >= "'.date("Y-m-d").'" OR article_end_date is null )';
        $query = $this->db->where_in('category_id', array(7,8,9))
                            ->where('article_status','approved')
                            ->where( $periodCondition )
                            ->order_by('article_postdate','desc')
                            // ->order_by('article_createdtime','asc')
                            ->limit(3)
                            // ->group_by('category_id')
                            ->get('articles')
                            ->result_array();
        return $query;
    }

}

/* End of file Homemodel.php */
