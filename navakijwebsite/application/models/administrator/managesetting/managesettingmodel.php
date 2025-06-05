<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managesettingmodel extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_setting_bykey( $key='' ){
        $query = $this->db->where('setting_key', $key )
                            ->get('system_setting')
                            ->row_array();
        return $query;
    }

    public function update( $key='' ){
        $message = array();

        $this->db->set('setting_value', $this->input->post('setting_value') );
        $this->db->where('setting_key', $key );
        $this->db->update('system_setting');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function updateStaticPage( $page='' ){
        $message = array();

        /* Update TH - Start */
        $this->db->set('setting_value', $this->input->post('setting_value_th') );
        $this->db->where('setting_key', $page.'_th' );
        $this->db->update('system_setting');
        /* Update TH - End */

        /* Update EN - Start */
        $this->db->set('setting_value', $this->input->post('setting_value_en') );
        $this->db->where('setting_key', $page.'_en' );
        $this->db->update('system_setting');
        /* Update EN - End */

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function updateAddress(){
        
        /* Update `company_title_th` - Start */
        $this->db->set('setting_value', $this->input->post('company_title_th'));
        $this->db->where('setting_key', 'company_title_th');
        $this->db->update('system_setting');
        /* Update `company_title_th` - End */

        /* Update `company_title_en` - Start */
        $this->db->set('setting_value', $this->input->post('company_title_en'));
        $this->db->where('setting_key', 'company_title_en');
        $this->db->update('system_setting');
        /* Update `company_title_en` - End */

        /* Update `company_address_th` - Start */
        $this->db->set('setting_value', $this->input->post('company_address_th'));
        $this->db->where('setting_key', 'company_address_th');
        $this->db->update('system_setting');
        /* Update `company_address_th` - End */

        /* Update `company_address_en` - Start */
        $this->db->set('setting_value', $this->input->post('company_address_en'));
        $this->db->where('setting_key', 'company_address_en');
        $this->db->update('system_setting');
        /* Update `company_address_en` - End */

        /* Update `company_tel` - Start */
        $this->db->set('setting_value', $this->input->post('company_tel'));
        $this->db->where('setting_key', 'company_tel');
        $this->db->update('system_setting');
        /* Update `company_tel` - End */

        /* Update `company_fax` - Start */
        $this->db->set('setting_value', $this->input->post('company_fax'));
        $this->db->where('setting_key', 'company_fax');
        $this->db->update('system_setting');
        /* Update `company_fax` - End */

        /* Update `company_email` - Start */
        $this->db->set('setting_value', $this->input->post('company_email'));
        $this->db->where('setting_key', 'company_email');
        $this->db->update('system_setting');
        /* Update `company_email` - End */

        /* Update `company_google_map` - Start */
        $this->db->set('setting_value', $this->input->post('company_google_map'));
        $this->db->where('setting_key', 'company_google_map');
        $this->db->update('system_setting');
        /* Update `company_google_map` - End */

        /* Update `company_location_lat` - Start */
        $this->db->set('setting_value', $this->input->post('company_location_lat'));
        $this->db->where('setting_key', 'company_location_lat');
        $this->db->update('system_setting');
        /* Update `company_location_lat` - End */

        /* Update `company_location_lng` - Start */
        $this->db->set('setting_value', $this->input->post('company_location_lng'));
        $this->db->where('setting_key', 'company_location_lng');
        $this->db->update('system_setting');
        /* Update `company_location_lng` - End */

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;

    }
}

/* End of file Managesettingmodel.php */
