<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		
	}

    public function create(){
        
        $this->db->set('subscribe_email', $this->input->post('email'));
        $this->db->set('subscribe_createdtime', date("Y-m-d H:i:s"));
        $this->db->insert('subscribe');

        $id = $this->db->insert_id();

        return $id;
    }

    public function get_gallery_byarticleid( $articleid=0, $limit=0, $offset=0 ){
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

    public function get_branch_list($s_data=array(), $limit=0, $offset=0){
      if($s_data['category_id'] != 0 && $s_data['category_id'] != ''){
          $query = $this->db->where('branches.category_id', $s_data['category_id']);
      }
      if( $s_data['keywords'] != '' ){
				$keyword = htmlspecialchars( $s_data['keywords'] );
				$conditions = '(
					branches.branch_title_th like "%'.$keyword.'%" or
					branches.branch_title_en like "%'.$keyword.'%"
				)';
				$query = $this->db->where( $conditions );
      }
      if($s_data['province_id']!=''){
				$query = $this->db->where('branches.province_id', $s_data['province_id']);
      }
      if($s_data['district_id']!=''){
				$query = $this->db->where('branches.district_id', $s_data['district_id']);
			}

			if( in_array( $s_data['category_id'], array(1,2,3) ) === true && $s_data['brand'] != '' ){
				$query = $this->db->like('branches.brands', $s_data['brand']);
      }

      // if( in_array( $s_data['category_id'], array(1,2,3) ) === true ){
      //     $query = $this->db->group_by("branch_brand.branch_id");
      // }
        // if($s_data['lat']!='' && $s_data['lng']!=''){
        //     $latitude = $s_data['lat'];
        //     $longitude = $s_data['lng'];
        //     $query = $this->db->select("*, (((acos(sin((".$latitude."*pi()/180)) * sin((`branch_lat`*pi()/180)) + cos((".$latitude."*pi()/180)) * cos((`branch_lat`*pi()/180)) * cos(((".$longitude."- `branch_lng`) * pi()/180)))) * 180/pi()) * 60 * 1.1515 * 1.609344) as distance",false,false);

        //     $query = $this->db->having('distance <=', MAPS_DISTANCE_SEARCH,false);
        // }

      if( $limit > 0 ){
          $query = $this->db->limit( $limit );
      }

      if( $offset > 0 ){
          $query = $this->db->offset( $offset );
      }

      $query = $this->db->where('branches.branch_status', 'approved')
      										->order_by("branches.branch_order","ASC")
      										->get('branches')->result_array();
      
      return $query;

    }

    public function get_category_branch_info($category_id){
        $query = $this->db->where('category_id',$category_id)
                            ->get('branch_categories')
                            ->row_array();
        return $query;
    }
	
    public function get_brand_title($branch_id){
        $query = $this->db->join('brands', 'branch_brand.brand_id = brands.brand_id', 'left')
                            ->where('branch_brand.branch_id',$branch_id)
                            ->get('branch_brand')
                            ->result_array();
        return $query;

    }

}