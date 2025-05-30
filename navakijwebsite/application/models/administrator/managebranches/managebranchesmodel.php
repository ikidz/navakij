<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Managebranchesmodel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }
    
    public function get_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('branch_categories')
                            ->row_array();
        return $query;
    }

    public function get_branches( $categoryid=0, $limit=0, $offset=0 ){
        if( $categoryid > 0 ){
            $query = $this->db->where('category_id', $categoryid);
        }

        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }

        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }

        $query = $this->db->where('branch_status !=','discard')
                            ->order_by('branch_createdtime','desc')
                            ->get('branches')
                            ->result_array();
        return $query;
    }

    public function count_branches( $categoryid=0 ){
        if( $categoryid > 0 ){
            $query = $this->db->where('category_id', $categoryid);
        }

        $query = $this->db->where('branch_status !=','discard')
                            ->order_by('branch_createdtime','desc')
                            ->count_all_results('branches');
        return $query;
    }

    public function get_branchinfo_byid( $branchid=0 ){
        $query = $this->db->where('branch_id', $branchid)
                            ->get('branches')
                            ->row_array();
        return $query;
    }

    public function get_provinces(){
        $query = $this->db->order_by('code','asc')
                            ->get('province')
                            ->result_array();
        return $query;
    }

    public function get_districts( $provinceid=0 ){
        if( $provinceid > 0 ){
            $query = $this->db->where('province_id', $provinceid);    
        }
        
        $query = $this->db->order_by('code','asc')
                        ->get('amphoe')
                        ->result_array();
        return $query;
    }

    public function get_subdistricts( $districtid=0 ){
        if( $districtid > 0 ){
            $query = $this->db->where('amphoe_id', $districtid);
        }

        $query = $this->db->order_by('code','asc')
                            ->get('tambon')
                            ->result_array();
        return $query;
    }
    
    public function create(){
        $message = array();
        $category = $this->get_categoryinfo_byid( $this->input->post('category_id') );

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/branches';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->do_upload($config, 'branch_image', $_FILES['branch_image']);
        /* Upload - End */

        $this->db->set('category_id', $this->input->post('category_id'));
        $this->db->set('branch_image', $file);
        $this->db->set('branch_title_th', $this->input->post('branch_title_th'));
        $this->db->set('branch_title_en', $this->input->post('branch_title_en'));
        $this->db->set('branch_tel', $this->input->post('branch_tel'));
        $this->db->set('branch_fax', ( $this->input->post('branch_fax') ? $this->input->post('branch_fax') : '' ));
        $this->db->set('branch_email', ( $this->input->post('branch_email') ? $this->input->post('branch_email') : '' ));
        $this->db->set('branch_website', ( $this->input->post('branch_website') ? $this->input->post('branch_website') : '' ));
        $this->db->set('branch_address', $this->input->post('branch_address'));
        $this->db->set('province_id', $this->input->post('province_id'));
        $this->db->set('district_id', $this->input->post('district_id'));
        $this->db->set('subdistrict_id', $this->input->post('subdistrict_id'));
        $this->db->set('is_partner', $this->input->post('is_partner'));
        $this->db->set('branch_lat', ( $this->input->post('branch_lat') ? $this->input->post('branch_lat') : 0 ));
        $this->db->set('branch_lng', ( $this->input->post('branch_lng') ? $this->input->post('branch_lng') : 0 ));
        $this->db->set('branch_gmap_url', ( $this->input->post('branch_gmap_url') ? $this->input->post('branch_gmap_url') : '' ));
        $this->db->set('branch_status', $this->input->post('branch_status'));
        $this->db->set('branch_createdtime', date("Y-m-d H:i:s"));
        $this->db->set('branch_createdip', $this->input->ip_address());
        $this->db->insert('branches');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function update(){
        $message = array();
        $category = $this->get_categoryinfo_byid( $this->input->post('category_id') );
        $info = $this->get_branchinfo_byid( $this->input->post('branch_id'));

        /* Upload - Start */
        $uploadpath = realpath('').'/public/core/uploaded/branches';
        if(is_dir($uploadpath)===false){
            mkdir($uploadpath, 0777);
            chmod($uploadpath, 0777);
        }
                    
        $config['upload_path'] = $uploadpath;
        $config['allowed_types'] = 'jpg|png|gif|jpeg';
        $config['max_size'] = 2048;
        $config['encrypt_name'] = true;
                    
        $file = $this->uploadmodel->edit_upload($config, 'branch_image', $_FILES['branch_image'], $info['branch_image']);
        /* Upload - End */

        $this->db->set('category_id', $this->input->post('category_id'));
        $this->db->set('branch_image', $file);
        $this->db->set('branch_title_th', $this->input->post('branch_title_th'));
        $this->db->set('branch_title_en', $this->input->post('branch_title_en'));
        $this->db->set('branch_tel', $this->input->post('branch_tel'));
        $this->db->set('branch_fax', ( $this->input->post('branch_fax') ? $this->input->post('branch_fax') : '' ));
        $this->db->set('branch_email', ( $this->input->post('branch_email') ? $this->input->post('branch_email') : '' ));
        $this->db->set('branch_website', ( $this->input->post('branch_website') ? $this->input->post('branch_website') : '' ));
        $this->db->set('branch_address', $this->input->post('branch_address'));
        $this->db->set('province_id', $this->input->post('province_id'));
        $this->db->set('district_id', $this->input->post('district_id'));
        $this->db->set('subdistrict_id', $this->input->post('subdistrict_id'));
        $this->db->set('is_partner', $this->input->post('is_partner'));
        $this->db->set('branch_lat', ( $this->input->post('branch_lat') ? $this->input->post('branch_lat') : 0 ));
        $this->db->set('branch_lng', ( $this->input->post('branch_lng') ? $this->input->post('branch_lng') : 0 ));
        $this->db->set('branch_gmap_url', ( $this->input->post('branch_gmap_url') ? $this->input->post('branch_gmap_url') : '' ));
        $this->db->set('branch_status', $this->input->post('branch_status'));
        $this->db->set('branch_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('branch_updatedip', $this->input->ip_address());
        $this->db->where('branch_id', $info['branch_id']);
        $this->db->update('branches');

        $message = array(
            'status' => 'message-success',
            'text' => 'บันทึกข้อมูลสำเร็จ'
        );

        return $message;
    }

    public function setStatus( $setto='discard', $branchid=0 ){
        $message = array();
        $info = $this->get_branchinfo_byid( $branchid );

        $this->db->set('branch_status', $setto);
        $this->db->set('branch_updatedtime', date("Y-m-d H:i:s"));
        $this->db->set('branch_updatedip', $this->input->ip_address());
        $this->db->where('branch_id', $info['branch_id']);
        $this->db->update('branches');

        if( $setto == 'discard' ){
            $message['text'] = 'ลบข้อมูลสำเร็จ';
        }else{
            $message['text'] = 'บันทึกสถานะการแสดงผลสำเร็จ';
        }

        $message['status'] = 'message-success';

        return $message;
    }

    public function setDisplayStatus( $type='web', $setto=0, $branchid=0 ){
        $message = array();
        $info = $this->get_branchinfo_byid( $branchid );

        if( $type == 'web' || $type == 'pdf' ){
            if( $type == 'web' ){
                $this->db->set('is_on_website', $setto);
            }else if( $type == 'pdf' ){
                $this->db->set('is_on_pdf', $setto);
            }
            
            $this->db->set('branch_updatedtime', date("Y-m-d H:i:s"));
            $this->db->set('branch_updatedip', $this->input->ip_address());
            $this->db->where('branch_id', $info['branch_id']);
            $this->db->update('branches');

            $message = array(
                'status' => 'message-success',
                'text' => 'บันทึกข้อมูลสำเร็จ'
            );
        }else{
            $message = array(
                'status' => 'message-error',
                'text' => 'ประเภทไม่ถูกต้อง',
            );
        }

        return $message;
    }

}

/* End of file Managebranchesmodel.php */
