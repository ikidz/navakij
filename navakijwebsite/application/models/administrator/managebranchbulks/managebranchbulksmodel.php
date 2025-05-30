<?php
class Managebranchbulksmodel extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}

    public function get_branch_categories(){
        $query = $this->db->where('category_status','approved')
                            ->order_by('category_order','asc')
                            ->get('branch_categories')
                            ->result_array();
        return $query;
    }

    public function get_branch_categorinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                        ->get('branch_categories')
                        ->row_array();
        return $query;
    }

    public function get_bulks( $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('branch_bulks.bulk_status !=','discard')
                            ->join('branch_categories','branch_bulks.category_id = branch_categories.category_id','inner')
                            ->order_by('branch_bulks.bulk_createdtime','desc')
                            ->get('branch_bulks')
                            ->result_array();
        return $query;
    }

    public function count_bulks(){
        $query = $this->db->where('branch_bulks.bulk_status !=','discard')
                            ->join('branch_categories','branch_bulks.category_id = branch_categories.category_id','inner')
                            ->order_by('branch_bulks.bulk_createdtime','desc')
                            ->count_all_results('branch_bulks');
        return $query;
    }

    public function get_bulkinfo_byid( $bulkid=0 ){
        $query = $this->db->where('bulk_id', $bulkid)
                            ->get('branch_bulks')
                            ->row_array();
        return $query;
    }

    public function setStatus( $setto='approved', $bulkid=0 ){
        $message = array();
        $info = $this->get_bulkinfo_byid( $bulkid );

        $this->db->set('bulk_status', $setto);
        $this->db->set('bulk_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('bulk_updatedip', $this->input->ip_address());
        $this->db->where('bulk_id', $info['bulk_id']);
        $this->db->update('branch_bulks');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';
        return $message;
    }

    public function create(){
        $message = array();

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/branch_bulks';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'xlsx|xls';
        $config['max_size'] = 102400;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'bulk_file', $_FILES['bulk_file']);
        /* Upload - End */

        $this->db->set('category_id', $this->input->post('category_id'));
        $this->db->set('bulk_title', $this->input->post('bulk_title'));
        $this->db->set('bulk_file', $file);
        if( !$file ){
            $this->db->set('bulk_status','error');
            $this->db->set('bulk_remark', 'ไม่มีไฟล์อัพโหลด');
        }else{
            $this->db->set('bulk_status','pending');
        }
        $this->db->set('bulk_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('bulk_createdip', $this->input->ip_address());
        $this->db->insert('branch_bulks');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ ระบบนำเข้าจะเข้ามาอ่านข้อมูลในอีก 5 นาที'
        );

        return $message;
    }
}
?>