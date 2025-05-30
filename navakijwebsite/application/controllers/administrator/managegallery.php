<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Managegallery extends CI_CONTROLLER{
	var $_data = array();
	var $seq;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('admin_library');
		$this->load->model('administrator/managegallery/managegallerymodel');
		
		$this->admin_library->forceLogin();
		
		$this->admin_model->set_menu_key('1d8bd8e6fde38fdd6e03c1103afdd9e2');
		
		$this->admin_model->initd($this);
		$this->admin_model->set_title("จัดการแกลอรี",'icon-list-alt');
	}

	public function index($categoryid=0, $articleid=0, $offset=0){
        if(!$this->admin_model->check_permision("r")){
			show_error("สิทธิการเข้าถึงของคุณไม่ถูกต้อง.");
        }
        
        $category = $this->managegallerymodel->get_categoryinfo_byid( $categoryid );
        $article = $this->managegallerymodel->get_articleinfo_byid( $articleid );
        $this->_data['category'] = $category;
        $this->_data['article'] = $article;

        $this->admin_model->set_menu_key('c968d3f91811914d4f308ee878f82a7a');
		if( isset( $category ) && count( $category ) > 0 ){
			$this->admin_model->set_detail('รายการแกลอรีของ "'.$article['article_title_th'].'"');
		}else{
			$this->admin_model->set_detail('รายการแกลอรีทั้งหมด');
        }

        /* Set Custom Tools - Start */
		$this->admin_model->set_custom_tools('managegallery/create', $this->_data);
        /* Set Custom Tools - End */
        
        /* Get Data Table - Start */
		$perpage = 10;
		$this->offset = $offset;
		if($offset>1){
			$offset = ($offset*$perpage)-$perpage;
			$this->seq = $offset;
		}else{
			$offset = 0;
		}
		$this->admin_model->set_dataTable($this->managegallerymodel->get_galleries($article['article_id'], $perpage, $offset));
		$totalrows = $this->managegallerymodel->count_galleries($article['article_id']);
        /* Get Data Table - End */

        $this->admin_model->set_checkall_dropdown('<i class="icon-unlock"></i> เปิดการแสดงผล','managegallery/setstatus/approved/'.$category['category_id'].'/'.$article['article_id'], 'w','btn-success');
        $this->admin_model->set_checkall_dropdown('<i class="icon-lock"></i> ปิดการแสดงผล','managegallery/setstatus/pending/'.$category['category_id'].'/'.$article['article_id'], 'w','btn-inverse');
        $this->admin_model->set_checkall_dropdown('<i class="icon-trash"></i> ลบรูปภาพ','managegallery/setstatus/discard/'.$category['category_id'].'/'.$article['article_id'], 'w','btn-danger');
        $this->admin_model->set_checkall(true, 'gallery_id');
        
        $this->admin_model->set_column('gallery_id','ลำดับ','10%','icon-list-ol');
		$this->admin_model->set_column('gallery_image','รูปภาพ','15%','icon-picture-o');
		$this->admin_model->set_column('gallery_status','สถานะการแสดงผล','15%','icon-eye-slash');
		$this->admin_model->set_column_callback('gallery_id','show_seq');
		$this->admin_model->set_column_callback('gallery_image','show_thumbnail');
		$this->admin_model->set_column_callback('gallery_status','show_status');
		
		$this->admin_model->set_pagination("managegallery/index/".$categoryid.'/'.$articleid,$totalrows,$perpage,6);
		$this->admin_model->make_list();
				
		$this->admin_library->output();
    }
    
    public function uploadImages($categoryid=0, $articleid=0){
        $message = $this->managegallerymodel->create( $articleid );

        $this->session->set_flashdata($message['status'], $message['text']);
        admin_redirect('managegallery/index/'.$categoryid.'/'.$articleid);
    }

    public function setstatus( $setto='approved', $categoryid=0, $articleid=0 ){

        $selectedLists = $this->input->get('select_item');

        $message = $this->managegallerymodel->setBulkStatus( $setto, $articleid, $selectedLists );

        $this->session->set_flashdata($message['status'], $message['text']);
        admin_redirect('managegallery/index/'.$categoryid.'/'.$articleid);
    }

    /* Default function - Start */
    public function show_seq($text, $row){
        $this->seq++;
        return $this->seq;
    }

    public function show_thumbnail($text, $row){
        if($text!=''){
            return '<a href="'.base_url('public/core/uploaded/article/galleries/'.$row['article_id'].'/'.$row['gallery_image']).'" class="fancybox-button"><img src="'.base_url('public/core/uploaded/article/galleries/'.$row['article_id'].'/'.$row['gallery_image']).'" alt="" style="width:150px;" /></a>';
        }else{
            return 'ไม่มีรูปภาพแสดง';
        }
    }

    public function show_status($text, $row){
        switch($text){
            case 'approved'	: return '<span class="label label-success"><i class="icon-unlock"></i> แสดงผล</span>'; break;
            case 'pending'	: return '<span class="label label-inverse"><i class="icon-lock"></i> ไม่แสดงผล</span>'; break;
            default : return 'ไม่มีสถานะ';
        }
    }
    /* Default function -  End */

}