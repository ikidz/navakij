<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		
	}

    public function get_contactinfo_byid( $contactid=0 ){
        $query = $this->db->where('contact_id', $contactid)
                                ->get('contact')
                                ->row_array();
        return $query;
    }

    public function create(){
        
        $this->db->set('contact_message', $this->input->post('contact_message'));
        $this->db->set('contact_name', $this->input->post('contact_fname'));
        $this->db->set('contact_lastname', $this->input->post('contact_lname'));
        $this->db->set('contact_mobile', $this->input->post('contact_tel'));
        $this->db->set('contact_email', $this->input->post('contact_email'));
        $this->db->set('contact_status', 'approved');
        $this->db->set('contact_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('contact_createdip', $this->input->ip_address());
        $this->db->insert('contact');
        $contact_id = $this->db->insert_id();

        $message = array(
            'status' => 'message-success',
            'contact_id' => $contact_id,
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }
	

}