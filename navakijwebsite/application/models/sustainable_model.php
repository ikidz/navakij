<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Sustainable_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_document_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('document_categories')
                            ->row_array();
        return $query;
    }

    public function get_documents_bycategoryid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('document_status','approved')
                            ->order_by('document_order','asc')
                            ->get('documents')
                            ->result_array();
        return $query;
    }

    

}

/* End of file Servicemodel.php */
