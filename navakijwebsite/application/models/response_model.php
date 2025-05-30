<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Response_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }
    
    public function get_responseinfo_byid( $responseid=0 ){
        $query = $this->db->where('response_id', $responseid)
                            ->where('response_status','approved')
                            ->get('responses')
                            ->row_array();
        return $query;
    }

}

/* End of file Response_model.php */
