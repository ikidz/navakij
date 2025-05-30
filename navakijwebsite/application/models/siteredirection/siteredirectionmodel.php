<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Siteredirectionmodel extends CI_Model {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function get_mapinfo_byid( $mapid=0 ){
        $query = $this->db->where('map_id', $mapid)
                            ->get('mapping_urls')
                            ->row_array();
        return $query;
    }
}

/* End of file Siteredirectionmodel.php */
