<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		
    }
    
    public function get_product_categories(){
        $query = $this->db->where('insurance_category_status','approved')
                            ->order_by('insurance_category_order','asc')
                            ->get('insurance_categories')
                            ->result_array();
        return $query;
    }

    public function get_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('insurance_category_id', $categoryid)
                            ->get('insurance_categories')
                            ->row_array();
        return $query;
    }

	public function get_product_list($category_id){
        $periodCondition = 'insurance_start_date <= "'.date("Y-m-d").'" AND ( insurance_end_date >= "'.date("Y-m-d").'" OR insurance_end_date is null )';
        $query = $this->db->where('insurance_status', 'approved')
                            ->where('insurance_category_id', $category_id)
                            ->where('insurance_highlight', 0)
                            ->where( $periodCondition )
                            //->join('vehicle_insurance', 'insurance.insurance_id = vehicle_insurance.insurance_id', 'left')
                            ->order_by("insurance.insurance_createdtime","desc")
                            ->get('insurance')->result_array();
        return $query;

    }

    public function get_product_highlight( $categoryid ){
        $periodCondition = 'insurance_start_date <= "'.date("Y-m-d").'" AND ( insurance_end_date >= "'.date("Y-m-d").'" OR insurance_end_date is null )';
        $query = $this->db->where('insurance_status','approved')
                            ->where('insurance_category_id', $categoryid)
                            ->where('insurance_highlight', 1)
                            ->where( $periodCondition )
                            ->limit(1)
                            ->order_by('insurance_createdtime','desc')
                            ->get('insurance')
                            ->row_array();
        return $query;
    }
    
    public function get_product_search_list($s_data=array()){
        //$query = $this->db->join('vehicle_insurance', 'vehicle_insurance.insurance_id = insurance.insurance_id', 'left');
        if( $s_data['filter_keywords'] != '' ){
			$keyword = htmlspecialchars( $s_data['filter_keywords'] );
			$conditions = '(
				insurance.insurance_title_'.$this->_language.' like "%'.$keyword.'%" OR 
				insurance.insurance_desc_'.$this->_language.' like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}

        if($s_data['category_id']!=''){
			$query = $this->db->where('insurance.insurance_category_id', $s_data['category_id']);
        }
        
        $periodCondition = 'insurance_start_date <= "'.date("Y-m-d").'" AND ( insurance_end_date >= "'.date("Y-m-d").'" OR insurance_end_date is null )';
    
        $query = $this->db->where('insurance.insurance_status','approved')
                            ->where( $periodCondition )
							->order_by('insurance.insurance_id','desc')
							->get('insurance')->result_array();
		return $query;

	}

	public function get_product_info($insurance_id){
		$query = $this->db->where('insurance_id', $insurance_id)
        //->join('vehicle_insurance', 'insurance.insurance_id = vehicle_insurance.insurance_id', 'left')
        ->limit(1)
        ->get('insurance')->row_array();
        return $query;
    }

    public function get_category_info($category_id){
        $query = $this->db->where('insurance_category_id', $category_id)
        ->limit(1)
        ->get('insurance_categories')->row_array();
        return $query;
    }

    public function get_icon_insurance($insurance_id){
        $query = $this->db->where('insurance_icons.insurance_id', $insurance_id)
                            ->join('icons', 'icons.icon_id = insurance_icons.icon_id')
                            ->get('insurance_icons')->result_array();
        return $query;
    }
    
    public function get_vehicle_insurance_by_insurance_id($insurance_id)
    {
        $query = $this->db->where('vehicle_insurance_status', 'approved')
        ->where('insurance_id', $insurance_id)
        //->join('vehicle_insurance', 'insurance.insurance_id = vehicle_insurance.insurance_id', 'left')
        ->order_by("price","ASC")
        ->get('vehicle_insurance')->result_array();
        return $query;


    }

    public function get_suggestion_insurance($category_id, $main_id){
        $periodCondition = 'insurance_start_date <= "'.date("Y-m-d").'" AND ( insurance_end_date >= "'.date("Y-m-d").'" OR insurance_end_date is null )';
        $query = $this->db->where('insurance.insurance_status', 'approved')
        ->where('insurance.insurance_category_id', $category_id)
        ->where('insurance.insurance_id !=', $main_id)
        ->where( $periodCondition )
        //->join('vehicle_insurance', 'insurance.insurance_id = vehicle_insurance.insurance_id', 'left')
        ->order_by('insurance.insurance_id', 'RANDOM')
        ->order_by("insurance.price","ASC")
       
        ->limit(3)
        ->get('insurance')->result_array();

        return $query;

    }

    public function get_provinces(){
        $query = $this->db->order_by('province_name_th','asc')
                            ->get('system_province')
                            ->result_array();
        return $query;
    }

    public function get_provinceinfo_byid( $provinceid=0 ){
        $query = $this->db->where('province_id', $provinceid)
                            ->get('system_province')
                            ->row_array();
        return $query;
    }

    public function get_vehicle_group(){
        $query = $this->db->order_by('vehicle_group_id','asc')
                            ->get('vehicle_group')
                            ->result_array();
        return $query;
    }

    public function get_vehicle_group_info($vehicle_group_id){
        $query = $this->db->where('vehicle_group_id',$vehicle_group_id)
                            ->get('vehicle_group')
                            ->row_array();
        return $query;
    }


    public function create(){
        
        $this->db->set('insurance_id', $this->input->post('insurance_id'));
        $this->db->set('province_id', $this->input->post('province_id'));
        $this->db->set('insurance_contact_consent', 'yes');
        // $this->db->set('insurance_contact_gender', $this->input->post('contact_gender'));
        $this->db->set('insurance_contact_name', $this->input->post('contact_fname'));
        $this->db->set('insurance_contact_lastname', $this->input->post('contact_lname'));
        $this->db->set('insurance_contact_mobile', $this->input->post('contact_tel'));
        // $this->db->set('insurance_contact_email', $this->input->post('contact_email'));
        $this->db->set('insurance_contact_status', 'approved');
        $this->db->set('insurance_contact_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('insurance_contact_createdip', $this->input->ip_address());
        $this->db->insert('insurance_contact');
        $contactId = $this->db->insert_id();

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ',
            'payLoads' => [
                'contact_id' => $contactId,
                'insurance_id' => $this->input->post('insurance_id')
            ]
        );

        return $message;
    }

    public function get_contactinfo_byid( $contactid=0 ){
        $query = $this->db->where('insurance_contact_id', $contactid)
                            ->get('insurance_contact')
                            ->row_array();
        return $query;
    }
	

}