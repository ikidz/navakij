<?php
class Managehierarchymodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_positions( $mainid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('main_id', $mainid)
                            ->where('position_status', 'approved')
                            ->order_by('position_order','asc')
                            ->get('positions')
                            ->result_array();
        return $query;
    }

    public function count_positions( $mainid=0 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('position_status', 'approved')
                            ->order_by('position_order','asc')
                            ->count_all_results('positions');
        return $query;
    }

    public function get_positioninfo_byid( $positionid=0 ){
        $query = $this->db->where('position_id', $positionid)
                            ->get('positions')
                            ->row_array();
        return $query;
    }

    public function get_boardmembers(){
        $query = $this->db->where('member_status','approved')
                            ->order_by('member_name_th','asc')
                            ->get('board_members')
                            ->result_array();
        return $query;
    }

    public function get_boardmemberinfo_byid( $memberid=0 ){
        $query = $this->db->where('member_id', $memberid)
                            ->get('board_members')
                            ->row_array();
        return $query;
    }

    public function get_hierarchy( $positionid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('position_id', $positionid)
                            ->where('hierarchy_status !=','discard')
                            ->order_by('hierarchy_order','asc')
                            ->get('hierarchy')
                            ->result_array();
        return $query;
    }

    public function count_hierarchy( $positionid=0 ){
        $query = $this->db->where('position_id', $positionid)
                            ->where('hierarchy_status !=','discard')
                            ->order_by('hierarchy_order','asc')
                            ->count_all_results('hierarchy');
        return $query;
    }

    public function get_hierarchyinfo_byid( $hierarchyid=0 ){
        $query = $this->db->where('hierarchy_id', $hierarchyid)
                            ->get('hierarchy')
                            ->row_array();
        return $query;
    }

    public function get_hierarchyinfo_byorder( $positionid=0, $order=0 ){
        $query = $this->db->where('position_id', $positionid)
                            ->where('hierarchy_order', $order)
                            ->limit(1)
                            ->get('hierarchy')
                            ->row_array();
        return $query;
    }

    public function reOrder( $positionid=0 ){
        $lists = $this->get_hierarchy( $positionid );
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;
                $this->db->set('hierarchy_order', $i);
                $this->db->where('hierarchy_id', $list['hierarchy_id']);
                $this->db->update('hierarchy');
            }
        }
    }

    public function create( $positionid=0 ){
        $message = array();
        $position = $this->get_positioninfo_byid( $positionid );
        $total = $this->count_hierarchy( $positionid );
        $newOrder = intval( $total + 1 );

        $this->db->set('position_id', $position['position_id']);
        $this->db->set('member_id', $this->input->post('member_id'));
        $this->db->set('hierarchy_level', $this->input->post('hierarchy_level'));
        $this->db->set('hierarchy_position_th', $this->input->post('hierarchy_position_th'));
        $this->db->set('hierarchy_position_en', $this->input->post('hierarchy_position_en'));
        $this->db->set('hierarchy_order', $newOrder);
        $this->db->set('hierarchy_status', $this->input->post('hierarchy_status'));
        $this->db->set('hierarchy_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('hierarchy_createdip', $this->input->ip_address());
        $this->db->insert('hierarchy');

        $this->reOrder( $position['position_id'] );

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );
    }

    public function update( $positionid=0, $hierarchyid=0 ){
        $message = array();
        $position = $this->get_positioninfo_byid( $positionid );
        $hierarchy = $this->get_hierarchyinfo_byid( $hierarchyid );

        $this->db->set('member_id', $this->input->post('member_id'));
        $this->db->set('hierarchy_level', $this->input->post('hierarchy_level'));
        $this->db->set('hierarchy_position_th', $this->input->post('hierarchy_position_th'));
        $this->db->set('hierarchy_position_en', $this->input->post('hierarchy_position_en'));
        $this->db->set('hierarchy_status', $this->input->post('hierarchy_status'));
        $this->db->set('hierarchy_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('hierarchy_updatedip', $this->input->ip_address());
        $this->db->where('hierarchy_id', $hierarchy['hierarchy_id']);
        $this->db->update('hierarchy');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );
    }

    public function setStatus( $setto='approved', $hierarchyid=0 ){
        $message = array();
        $hierarchy = $this->get_hierarchyinfo_byid( $hierarchyid );

        $this->db->set('hierarchy_status', $setto);
        $this->db->set('hierarchy_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('hierarchy_updatedip', $this->input->ip_address());
        $this->db->where('hierarchy_id', $hierarchy['hierarchy_id']);
        $this->db->update('hierarchy');

        if( $setto == 'discard' ){
            $this->reOrder( $hierarchy['position_id'] );
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
        }
        $message['status'] = 'message-success';

        return $message;
    }

    public function setOrder( $movement='up', $hierarchyid=0 ){
        $message = array();
        $info = $this->get_hierarchyinfo_byid( $hierarchyid );
        $total = $this->count_hierarchy( $info['position_id'] );

        if( $movement == 'up' ){
            $newOrder = intval( $info['hierarchy_order'] - 1 );

            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{

                $exists = $this->get_hierarchyinfo_byorder( $info['position_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['hierarchy_order'] + 1 );
                    $this->db->set('hierarchy_order', $exists_newOrder);
                    $this->db->where('hierarchy_id', $exists['hierarchy_id']);
                    $this->db->update('hierarchy');
                }

                $this->db->set('hierarchy_order', $newOrder);
                $this->db->where('hierarchy_id', $info['hierarchy_id']);
                $this->db->update('hierarchy');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );

            }
        }else if( $movement == 'down' ){
            $newOrder = intval( $info['hierarchy_order'] + 1 );

            if( $newOrder > $total ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับล่างสุด ไม่สามารถเลื่อนลงได้'
                );
            }else{

                $exists = $this->get_hierarchyinfo_byorder( $info['position_id'], $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['hierarchy_order'] - 1 );
                    $this->db->set('hierarchy_order', $exists_newOrder);
                    $this->db->where('hierarchy_id', $exists['hierarchy_id']);
                    $this->db->update('hierarchy');
                }

                $this->db->set('hierarchy_order', $newOrder);
                $this->db->where('hierarchy_id', $info['hierarchy_id']);
                $this->db->update('hierarchy');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );

            }
        }else{
            $message = array(
                'status' => 'message-error',
                'text' => 'ไม่สามารถบันทึกข้อมูลการจัดลำดับได้'
            );
        }

        return $message;
    }
}
?>