<?php
class Manageemployeesmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_employees( $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('employee_status !=','discard')
                            ->order_by('employee_order','asc')
                            ->get('employees')
                            ->result_array();
        return $query;
    }

    public function count_employees(){
        $query = $this->db->where('employee_status !=','discard')
                            ->order_by('employee_order','asc')
                            ->count_all_results('employees');
        return $query;
    }

    public function get_employeeinfo_byid( $employeeid=0 ){
        $query = $this->db->where('employee_id', $employeeid)
                            ->get('employees')
                            ->row_array();
        return $query;
    }

    public function get_employeeinfo_byorder( $order=0 ){
        $query = $this->db->where('employee_order', $order)
                            ->where('employee_status !=','discard')
                            ->limit(1)
                            ->get('employees')
                            ->row_array();
        return $query;
    }

    public function reOrder(){
        $lists = $this->get_employees();
        if( isset( $lists ) && count( $lists ) > 0 ){
            $i=0;
            foreach( $lists as $list ){
                $i++;
                $this->db->set('employee_order', $i);
                $this->db->where('employee_id', $list['employee_id']);
                $this->db->update('employees');
            }
        }
    }

    public function create(){
        $message = array();

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/employees';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 1024;
        $config['max_width'] = 1200;
        $config['min_width'] = 1200;
        $config['max_height'] = 1200;
        $config['min_height'] = 1200;
        $config['encrypt_name'] = true;
                    
        $file_th = $this->uploadmodel->do_upload($config, 'employee_image_th', $_FILES['employee_image_th']);
        $file_en = $this->uploadmodel->do_upload($config, 'employee_image_en', $_FILES['employee_image_en']);
        /* Upload - End */

        $this->db->set('employee_image_th', $file_th);
        $this->db->set('employee_image_en', $file_en);
        $this->db->set('employee_name_th', $this->input->post('employee_name_th'));
        $this->db->set('employee_name_en', $this->input->post('employee_name_en'));
        $this->db->set('employee_order', 0);
        $this->db->set('employee_status', $this->input->post('employee_status'));
        $this->db->set('employee_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('employee_createdip', $this->input->ip_address());
        $this->db->insert('employees');

        $this->reOrder();

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );
    }

    public function update( $employeeid=0 ){
        $message = array();
        $info = $this->get_employeeinfo_byid( $employeeid );

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/employees';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = 1024;
        $config['max_width'] = 1200;
        $config['min_width'] = 1200;
        $config['max_height'] = 1200;
        $config['min_height'] = 1200;
        $config['encrypt_name'] = true;
                    
        $file_th = $this->uploadmodel->edit_upload($config, 'employee_image_th', $_FILES['employee_image_th'], $info['employee_image_th']);
        $file_en = $this->uploadmodel->edit_upload($config, 'employee_image_en', $_FILES['employee_image_en'], $info['employee_image_en']);
        /* Upload - End */

        $this->db->set('employee_image_th', $file_th);
        $this->db->set('employee_image_en', $file_en);
        $this->db->set('employee_name_th', $this->input->post('employee_name_th'));
        $this->db->set('employee_name_en', $this->input->post('employee_name_en'));
        $this->db->set('employee_status', $this->input->post('employee_status'));
        $this->db->set('employee_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('employee_updatedip', $this->input->ip_address());
        $this->db->where('employee_id', $info['employee_id']);
        $this->db->update('employees');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto='discard', $employeeid=0 ){
        $message = array();
        $info = $this->get_employeeinfo_byid( $employeeid );

        $this->db->set('employee_status', $setto);
        $this->db->set('employee_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('employee_updatedip', $this->input->ip_address());
        $this->db->where('employee_id', $info['employee_id']);
        $this->db->update('employees');

        if( $setto == 'discard' ){
            $this->reOrder();
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกข้อมูลการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }

    public function setOrder( $movement = 'up', $employeeid=0 ){
        $message = array();
        $info = $this->get_employeeinfo_byid( $employeeid );
        $total = $this->count_employees();

        if( $movement == 'up' ){
            $newOrder = intval( $info['employee_order'] - 1 );
            if( $newOrder <= 0 ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{

                $exists = $this->get_employeeinfo_byorder( $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['employee_order'] + 1 );
                    $this->db->set('employee_order', $exists_newOrder);
                    $this->db->where('employee_id', $exists['employee_id']);
                    $this->db->update('employees');
                }

                $this->db->set('employee_order', $newOrder);
                $this->db->where('employee_id', $infop['employee_id']);
                $this->db->update('employees');

                $message = array(
                    'status' => 'message-success',
                    'text' => 'บันทึกข้อมูลการจัดลำดับสำเร็จ'
                );

            }
        }else if( $movement == 'down' ){
            $newOrder = intval( $info['employee_order'] + 1 );
            if( $newOrder > $total ){
                $message = array(
                    'status' => 'message-warning',
                    'text' => 'ข้อมูลลำดับบนสุด ไม่สามารถเลื่อนขึ้นได้'
                );
            }else{

                $exists = $this->get_employeeinfo_byorder( $newOrder );
                if( isset( $exists ) && count( $exists ) > 0 ){
                    $exists_newOrder = intval( $exists['employee_order'] - 1 );
                    $this->db->set('employee_order', $exists_newOrder);
                    $this->db->where('employee_id', $exists['employee_id']);
                    $this->db->update('employees');
                }

                $this->db->set('employee_order', $newOrder);
                $this->db->where('employee_id', $infop['employee_id']);
                $this->db->update('employees');

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