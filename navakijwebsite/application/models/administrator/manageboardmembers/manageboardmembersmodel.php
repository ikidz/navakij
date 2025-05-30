<?php
class Manageboardmembersmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_members( $aSort=array(), $limit=0, $offset=0 ){
        if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
                member_name_th like "%'.$keyword.'%" OR
                member_name_en like "%'.$keyword.'%" OR
                member_position_th like "%'.$keyword.'%" OR
                member_position_en like "%'.$keyword.'%" OR
                member_type_th like "%'.$keyword.'%" OR
                member_type_en like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}

        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('member_status !=','discard')
                            ->order_by('member_createdtime','desc')
                            ->get('board_members')
                            ->result_array();
        return $query;
    }

    public function count_members( $aSort=array() ){
        if( $aSort['sort_keyword'] != '' ){
			$keyword = htmlspecialchars( $aSort['sort_keyword'] );
			$conditions = '(
                member_name_th like "%'.$keyword.'%" OR
                member_name_en like "%'.$keyword.'%" OR
                member_position_th like "%'.$keyword.'%" OR
                member_position_en like "%'.$keyword.'%" OR
                member_type_th like "%'.$keyword.'%" OR
                member_type_en like "%'.$keyword.'%"
			)';
			$query = $this->db->where( $conditions );
		}

        $query = $this->db->where('member_status !=','discard')
                            ->order_by('member_createdtime','desc')
                            ->count_all_results('board_members');
        return $query;
    }

    public function get_memberinfo_byid( $memberid=0 ){
        $query = $this->db->where('member_id', $memberid)
                            ->get('board_members')
                            ->row_array();
        return $query;
    }

    public function create(){
        $message = array();

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/boardmembers';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['max_width'] = 595;
        $config['min_width'] = 595;
        $config['max_height'] = 800;
        $config['min_height'] = 800;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'member_image', $_FILES['member_image']);
        /* Upload - End */

        $this->db->set('member_image', $file);
        $this->db->set('member_name_th', $this->input->post('member_name_th'));
        $this->db->set('member_name_en', $this->input->post('member_name_en'));
        $this->db->set('member_position_th', $this->input->post('member_position_th'));
        $this->db->set('member_position_en', $this->input->post('member_position_en'));
        $this->db->set('member_type_th', $this->input->post('member_type_th'));
        $this->db->set('member_type_en', $this->input->post('member_type_en'));
        $this->db->set('member_history_th', $this->input->post('member_history_th'));
        $this->db->set('member_history_en', $this->input->post('member_history_en'));
        $this->db->set('member_age', $this->input->post('member_age'));
        $this->db->set('member_nationality_th', $this->input->post('member_nationality_th'));
        $this->db->set('member_nationality_en', $this->input->post('member_nationality_en'));
        $this->db->set('member_educational_th', $this->input->post('member_educational_th'));
        $this->db->set('member_educational_en', $this->input->post('member_educational_en'));
        $this->db->set('member_committee_seminar_th', $this->input->post('member_committee_seminar_th'));
        $this->db->set('member_committee_seminar_en', $this->input->post('member_committee_seminar_en'));
        $this->db->set('member_other_seminar_th', $this->input->post('member_other_seminar_th'));
        $this->db->set('member_other_seminar_en', $this->input->post('member_other_seminar_en'));
        $this->db->set('member_expertise_th', $this->input->post('member_expertise_th'));
        $this->db->set('member_expertise_en', $this->input->post('member_expertise_en'));
        $this->db->set('member_current_position_th', $this->input->post('member_current_position_th'));
        $this->db->set('member_current_position_en', $this->input->post('member_current_position_en'));
        $this->db->set('member_other_position_th', $this->input->post('member_other_position_th'));
        $this->db->set('member_other_position_en', $this->input->post('member_other_position_en'));
        $this->db->set('member_registered_company_th', $this->input->post('member_registered_company_th'));
        $this->db->set('member_registered_company_en', $this->input->post('member_registered_company_en'));
        $this->db->set('member_unregister_company_th', $this->input->post('member_unregister_company_th'));
        $this->db->set('member_unregister_company_en', $this->input->post('member_unregister_company_en'));
        $this->db->set('member_sharedholding_ratio', $this->input->post('member_sharedholding_ratio'));
        $this->db->set('member_sharedholding_percentage', $this->input->post('member_sharedholding_percentage'));
        $this->db->set('member_sharedholding_updatedat', date( "Y-m-d", strtotime( $this->input->post('member_sharedholding_updatedat') ) ) );
        $this->db->set('member_status', $this->input->post('member_status'));
        $this->db->set('member_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('member_createdip', $this->input->ip_address());
        $this->db->insert('board_members');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update($memberid=0){
        $message = array();
        $info = $this->get_memberinfo_byid( $memberid );

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/boardmembers';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 2048;
        $config['max_width'] = 595;
        $config['min_width'] = 595;
        $config['max_height'] = 800;
        $config['min_height'] = 800;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->edit_upload($config, 'member_image', $_FILES['member_image'], $info['member_image']);
        /* Upload - End */

        $this->db->set('member_image', $file);
        $this->db->set('member_name_th', $this->input->post('member_name_th'));
        $this->db->set('member_name_en', $this->input->post('member_name_en'));
        $this->db->set('member_position_th', $this->input->post('member_position_th'));
        $this->db->set('member_position_en', $this->input->post('member_position_en'));
        $this->db->set('member_type_th', $this->input->post('member_type_th'));
        $this->db->set('member_type_en', $this->input->post('member_type_en'));
        $this->db->set('member_history_th', $this->input->post('member_history_th'));
        $this->db->set('member_history_en', $this->input->post('member_history_en'));
        $this->db->set('member_age', $this->input->post('member_age'));
        $this->db->set('member_nationality_th', $this->input->post('member_nationality_th'));
        $this->db->set('member_nationality_en', $this->input->post('member_nationality_en'));
        $this->db->set('member_educational_th', $this->input->post('member_educational_th'));
        $this->db->set('member_educational_en', $this->input->post('member_educational_en'));
        $this->db->set('member_committee_seminar_th', $this->input->post('member_committee_seminar_th'));
        $this->db->set('member_committee_seminar_en', $this->input->post('member_committee_seminar_en'));
        $this->db->set('member_other_seminar_th', $this->input->post('member_other_seminar_th'));
        $this->db->set('member_other_seminar_en', $this->input->post('member_other_seminar_en'));
        $this->db->set('member_expertise_th', $this->input->post('member_expertise_th'));
        $this->db->set('member_expertise_en', $this->input->post('member_expertise_en'));
        $this->db->set('member_current_position_th', $this->input->post('member_current_position_th'));
        $this->db->set('member_current_position_en', $this->input->post('member_current_position_en'));
        $this->db->set('member_other_position_th', $this->input->post('member_other_position_th'));
        $this->db->set('member_other_position_en', $this->input->post('member_other_position_en'));
        $this->db->set('member_registered_company_th', $this->input->post('member_registered_company_th'));
        $this->db->set('member_registered_company_en', $this->input->post('member_registered_company_en'));
        $this->db->set('member_unregister_company_th', $this->input->post('member_unregister_company_th'));
        $this->db->set('member_unregister_company_en', $this->input->post('member_unregister_company_en'));
        $this->db->set('member_sharedholding_ratio', $this->input->post('member_sharedholding_ratio'));
        $this->db->set('member_sharedholding_percentage', $this->input->post('member_sharedholding_percentage'));
        $this->db->set('member_sharedholding_updatedat', date( "Y-m-d", strtotime( $this->input->post('member_sharedholding_updatedat') ) ) );
        $this->db->set('member_status', $this->input->post('member_status'));
        $this->db->set('member_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('member_updatedip', $this->input->ip_address());
        $this->db->where('member_id', $info['member_id']);
        $this->db->update('board_members');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto='approved', $memberid=0 ){
        $message = array();
        $info = $this->get_memberinfo_byid( $memberid );

        $this->db->set('member_status', $setto);
        $this->db->set('member_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('member_updatedip', $this->input->ip_address());
        $this->db->where('member_id', $info['member_id']);
        $this->db->update('board_members');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }
}
?>