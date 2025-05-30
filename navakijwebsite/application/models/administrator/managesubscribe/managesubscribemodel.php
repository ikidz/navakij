<?php
class Managesubscribemodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}


	
	public function get_subscribes($aSort=array(),$limit=10, $offset=0){
		if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
				subscribe_email like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('subscribe_createdtime >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('subscribe_createdtime <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}
		$query = $this->db->where('subscribe_status !=','discard')
							->order_by('subscribe_id','desc')
							->get('subscribe', $limit, $offset)->result_array();
		return $query;
	}
	
	public function count_subscribes($aSort=array()){
		if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
				subscribe_name like "%'.$keyword.'%" OR 
				subscribe_lastname like "%'.$keyword.'%" OR 
				subscribe_email like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}
		
		if($aSort['sort_start_date']!=''){
			$query = $this->db->where('subscribe_createdtime >=', date("Y-m-d H:i:s", strtotime($aSort['sort_start_date'])));
		}
		
		if($aSort['sort_end_date']!=''){
			$query = $this->db->where('subscribe_createdtime <=', date("Y-m-d H:i:s", strtotime($aSort['sort_end_date'])));
		}
		$query = $this->db->where('subscribe_status !=','discard')
							->count_all_results('subscribe');
		return $query;
	}
	
	public function get_subscribeinfo_byid($subscribeid=0){
		$query = $this->db->where('subscribe_id', $subscribeid)
							->get('subscribe')->row_array();
		return $query;
	}
	
	public function get_subscribeinfo_byorder($order){
		$query = $this->db->where('subscribe_status !=','discard')
							->order_by('subscribe_createdtime','desc')
							->limit(1)
							->get('subscribe')->row_array();
		return $query;
	}
	
}
?>