<?php
class Manageiplogsmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_iplogs( $aSort=array(), $limit=10, $offset=0 ){

        if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
                hash like "%'.$keyword.'%" OR
				ip like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('created_at >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('created_at <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}

        if($aSort['sort_onlythai'] == 1 ){
            $query = $this->db->where('country_code', 'TH')
								->or_where('country_code', null);
        }

        $query = $this->db->order_by('created_at','desc')
                    ->get('ip_logs', $limit, $offset)
                    ->result_array();
        return $query;
    }

    public function count_iplogs( $aSort=array() ){
        if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
                hash like "%'.$keyword.'%" OR
				ip like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('created_at >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('created_at <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}

        if($aSort['sort_onlythai'] == 1 ){
            $query = $this->db->where('country_code', 'TH');
        }
        $query = $this->db->count_all_results('ip_logs');
        return $query;
    }

	public function export_iplogs( $aSort=array(), $limit=10, $offset=0 ){

        if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
                hash like "%'.$keyword.'%" OR
				ip like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('created_at >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('created_at <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}

        if($aSort['sort_onlythai'] == 1 ){
            $query = $this->db->where('country_code', 'TH');
        }

        $query = $this->db->order_by('created_at','desc')
					->group_by('ip')
                    ->get('ip_logs', $limit, $offset)
                    ->result_array();
        return $query;
    }

    public function count_export_iplogs( $aSort=array() ){
        if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
                hash like "%'.$keyword.'%" OR
				ip like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('created_at >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('created_at <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}

        if($aSort['sort_onlythai'] == 1 ){
            $query = $this->db->where('country_code', 'TH');
        }
        $query = $this->db->count_all_results('ip_logs');
        return $query;
    }

    public function get_iploginfo_byhash( $hash='' ){
        $query =$this->db->where('hash', $hash)
						->group_by('ip')
                        ->get('ip_logs')
                        ->row_array();
        return $query;
    }

    public function get_transactionlogs_byhash( $hash='', $aSort=array(), $limit=10, $offset=0 ){
        if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
				hash like "%'.$keyword.'%" OR
                current_uri like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('created_at >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('created_at <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}

        $query = $this->db->where('hash', $hash)
                            ->order_by('created_at','desc')
                            ->get('ip_transaction_logs', $limit, $offset)
                            ->result_array();
                            // echo $this->db->last_query();
                            // exit();
        return $query;
    }

    public function count_transactionlogs_byhash( $hash='', $aSort=array() ){
        if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
				hash like "%'.$keyword.'%" OR
                current_uri like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('created_at >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('created_at <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}

        $query = $this->db->where('hash', $hash)
                            ->order_by('created_at','desc')
                            ->count_all_results('ip_transaction_logs');
        return $query;
    }

}