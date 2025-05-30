<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Claim_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		
	}

		public function get_branch_list($s_data=array(), $offset=0, $limit=0){
    	if($s_data['category_id'] != 0 && $s_data['category_id'] != ''){
          $query = $this->db->where('branches.category_id', $s_data['category_id']);
      }
      if( $s_data['keywords'] != '' ){
				$keyword = htmlspecialchars( $s_data['keywords'] );
				$conditions = '(
					branches.branch_title_'.$this->_language.' like "%'.$keyword.'%"
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

		public function count_branch_list( $s_data=array() ){
			if($s_data['category_id'] != 0 && $s_data['category_id'] != ''){
          $query = $this->db->where('branches.category_id', $s_data['category_id']);
      }
      if( $s_data['keywords'] != '' ){
				$keyword = htmlspecialchars( $s_data['keywords'] );
				$conditions = '(
					branches.branch_title_'.$this->_language.' like "%'.$keyword.'%"
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

      $query = $this->db->where('branches.branch_status', 'approved')
      										->count_all_results('branches');
      
      return $query;
		}

    public function get_pdf_branches( $categoryid=0 ){

        $provinces = $this->db->select('province.province_id, province.name, province.name_alt')
                            ->where('branches.category_id', $categoryid)
                            ->where('branches.branch_status','approved')
                            ->where('branches.is_on_pdf', 1)
                            ->join('province','branches.province_id = province.province_id','inner')
                            ->group_by('province.province_id')
                            ->get('branches')
                            ->result_array();

        $datas = array();
        if( isset( $provinces ) && count( $provinces ) > 0 ){
            foreach( $provinces as $province ){
                
                $queries = $this->db->select('branches.branch_title_th, branches.branch_title_en, branches.branch_address, branches.branch_tel, amphoe.name, amphoe.name_alt')
                                    ->where('branches.branch_status','approved')
                                    ->where('branches.category_id', $categoryid)
                                    ->where('branches.province_id', $province['province_id'])
                                    ->where('branches.is_on_pdf', 1)
                                    ->join('amphoe','branches.district_id = amphoe.amphoe_id', 'left')
                                    ->get('branches')
                                    ->result_array();
                
                $aBranches = array();
                if( isset( $queries ) && count( $queries ) > 0 ){
                    foreach( $queries as $query ){
                        array_push( $aBranches, $query );
                    }
                }
                
                $aProvince = array(
                    'province_id' => $province['province_id'],
                    'province_name' => ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ),
                    'branches' => $aBranches
                );
                array_push( $datas, $aProvince );
            }
        }

        return $datas;
    }
    
    public function get_category_branch_list(){
        $query = $this->db->order_by('category_order','asc')
                            ->get('branch_categories')
                            ->result_array();
        return $query;
    }

    public function get_category_branch_info($category_id){
        $query = $this->db->where('category_id',$category_id)
                            ->get('branch_categories')
                            ->row_array();
        return $query;
    }

    public function get_provinces(){
        $query = $this->db->where('is_actived !=','N');
				if( $this->_language == 'en' ){
					$query = $query->order_by('name_alt','asc');
				}else{
					$query = $query->order_by('name','asc');
				}
				$query = $query->get('province')
                          ->result_array();
        return $query;
    }

    public function get_districts( $provinceid=0 ){
        if( $provinceid > 0 ){
            $query = $this->db->where('province_id', $provinceid);    
        }
        
        $query = $this->db->where('is_actived !=','N');
				if( $this->_language == 'en' ){
					$query = $query->order_by('name_alt','asc');
				}else{
					$query = $query->order_by('name','asc');
				}
				$query = $query->get('amphoe')
                        ->result_array();
        return $query;
    }
    
    public function get_brands(){
        $query = $this->db->where('brand_status','approved')
														->order_by('brand_title','asc')
                            ->get('brands')
                            ->result_array();
        return $query;
    }

    public function get_brand_title($branch_id){
        $query = $this->db->join('brands', 'branch_brand.brand_id = brands.brand_id', 'left')
                            ->where('branch_brand.branch_id',$branch_id)
                            ->get('branch_brand')
                            ->result_array();
        return $query;

    }
	
    public function get_subcat_bymainid( $categoryid=0 ){
        $query = $this->db->where('main_id', $categoryid)
                            ->where('category_status','approved')
                            ->order_by('category_order','asc')
                            ->get('document_categories')
                            ->result_array();
        return $query;
    }

}