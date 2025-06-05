<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

    var $_data;
    var $language;
    public function __construct(){
        parent::__construct();
        $this->load->model('api_model');
        $this->load->library('form_validation');
        $this->language = 'th';
    }
    
    function save_subscribe(){

        $this->form_validation->set_rules('email','อีเมล','trim|required|valid_email|is_unique[subscribe.subscribe_email]');
        
        $this->form_validation->set_message('required','กรุณาระบุ "%s"');
        $this->form_validation->set_message('valid_email','รูปแบบอีเมลไม่ถูกต้อง');
        $this->form_validation->set_message('is_unique','อีเมลนี้ถูกใช้งานไปแล้ว');
        $this->form_validation->set_error_delimiters('','');

        if($this->form_validation->run()===FALSE){
            $response = array(
                'status' => 500,
                'text' => form_error('email')
            );
            $this->json->set('response', $response);
            $this->json->send();
		}else{

            $result = $this->api_model->create();
            if($result ){
                $response = array(
                    'status' => 200,
                    'text' => 'ลงทะเบียนอีเมลเรียบร้อย'
                );
            }else{
                $response = array(
                    'status' => 500,
                    'text' => 'ไม่สามารถลงทะเบียนอีเมลได้'
                );
            }
            $this->json->set('response', $response);
            $this->json->send();
        }
	}

    public function acceptCookies(){
        $hash = md5('NKI_'.date("YmdHis"));

        set_cookie( COOKIE_NAME, $hash, time()+86500 );

        $response = array(
            'status' => 200
        );

        echo json_encode($response);

    }

    public function destroyCookie(){
        delete_cookie( COOKIE_NAME );
    }

    public function load_gallery(){
        $articleId = $this->input->post('articleId');
        $limit = $this->input->post('limit');
        $offset = $this->input->post('offset');
        $newOffset = intval( $limit + $offset );

        $this->_data['language'] = $this->input->post('language');
        $this->_data['galleries'] = $this->api_model->get_gallery_byarticleid( $articleId, $limit, $newOffset );
        $datas = $this->load->view('api/gallery_items', $this->_data, true);

        $response = array(
            'status' => 200,
            'items' => $datas,
            'offset' => $newOffset
        );

        $this->json->set('response', $response);
        $this->json->send();
    }

    public function load_branches(){
        $limit = $this->input->post('limit');
        $offset = $this->input->post('offset');
        $filters = $this->input->post('filters');
        $newOffset = intval( $limit + $offset );

        $s_data = array();
        if( isset( $filters ) && count( $filters ) > 0 ){
            foreach( $filters as $key => $filter ){
                $s_data[$key] = $filter;
            }
        }

        $this->_data['language'] = $this->input->post('language');
        $this->_data['branch_list'] = $this->api_model->get_branch_list( $s_data, $limit, $newOffset );
        $datas = $this->load->view('api/branch_items', $this->_data, true);

        $response = array(
            'status' => 200,
            'items' => $datas,
            'offset' => $newOffset
        );

        $this->json->set('response', $response);
        $this->json->send();
    }

}

/* End of file Claim.php */