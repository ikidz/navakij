<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
	var $_data = array();
	var $_list_type = "sample";
	var $_menu_perm_data = array();
	var $_menu_key = '';
	public function __construct()
	{
		parent::__construct();
		
		$this->_data['button']=array();
		$this->_data['datatable']=array();
		$this->_data['title']="Untitled";
		$this->_data['button']=array();
		$this->_data['top_button']=array();
		$this->_data['checkall_dropdown']=array();
		$this->_data['checkall']=true;
		$this->_data['pagination']=false;
		$this->_data['search_date']=false;
		$this->_data['search_text']=false;
		$this->_data['custom_tools']="";
		$this->_data['tools_width']=0;
	}
	public function initd($e)
	{
	
		$this->me=$e;
		$this->_data['button']=array();
		$this->_data['datatable']=array();
		$this->_data['title']="Untitled";
		$this->_data['button']=array();
		$this->_data['top_button']=array();
		$this->_data['checkall_dropdown']=array();
		$this->_data['checkall']=true;
		$this->_data['pagination']=false;
		$this->_data['search_date']=false;
		$this->_data['search_text']=false;
		$this->_data['custom_tools']="";
		$this->_data['tools_width']=0;
	}
	function set_tools_width($w)
	{
		$this->_data['tools_width']=$w;
	}
	function set_custom_tools($view,$data=array())
	{
		$this->_data['custom_tools'] .= $this->load->view("administrator/views/".$view,$data,true);
	}
	public function show_search_date()
	{
		$this->_data['search_date']=true;
	}
	public function show_search_text()
	{
		$this->_data['search_text']=true;	
	}
	public function assign_param($text,$data)
	{
		foreach($data as $column=>$row)
		{
			$text = str_replace('['.$column.']',$row,$text);
		}
		return $text;
	}
	
	public function get_curr_menu_key()
	{
		return $this->_menu_key;
	}
	public function set_menu_key($menu_key)
	{
		$this->_menu_key = $menu_key;
		if($this->admin_library->is_superadmin()==true){
			$this->_menu_perm_data['r']=true;
			$this->_menu_perm_data['w']=true;
			$this->_menu_perm_data['d']=true;
			$this->_menu_perm_data['s']=true;
			$this->_menu_perm_data['e']=true;
		}else{
			$me = $this->admin_library->me();
			$group_id = $me['user_group']; 
			$this->db->where("perm_menu_key",$menu_key);
			$this->db->where("perm_group_id",$group_id);
			$this->db->where("perm_status","active");
			$perm_row = $this->db->get("system_usergroup_permision")->row_array();
			//exit($this->db->last_query());
			if($perm_row){
				$this->_menu_perm_data['r']=($perm_row['perm_read']=='true')?true:false;
				$this->_menu_perm_data['w']=($perm_row['perm_write']=='true')?true:false;
				$this->_menu_perm_data['d']=($perm_row['perm_delete']=='true')?true:false;
				$this->_menu_perm_data['e']=true;
				$this->_menu_perm_data['s']=false;
			}else{
				$this->_menu_perm_data['r']=false;
				$this->_menu_perm_data['w']=false;
				$this->_menu_perm_data['d']=false;
				$this->_menu_perm_data['e']=true;
				$this->_menu_perm_data['s']=false;
			}
		}
	}
	public function set_datatable($datatable)
	{
		$this->_data['datatable'] = $datatable;
	}
	public function set_title($title,$icon='icon-question-sign')
	{
		$this->_data['title'] = $title;
		$this->_data['icon'] = $icon;
		$this->admin_library->setTitle($title,$icon);
		$this->admin_library->setDetail($title);
	}
	public function set_detail($detail)
	{
		$this->admin_library->setDetail($detail);
	}
	//List View
	public function set_checkall($cancheck=true,$key='id')
	{
		$this->_data['checkall']=$cancheck;
		$this->_data['checkall_key']=$key;
	}
	public function set_pagination($url,$total_rows,$perpage,$uri_segment=3)
	{
		$this->load->helper("create_pagination");
		$this->_data['pagination']=true;
		$this->_data['total_rows']=$total_rows;
		$this->_data['url']=$url;
		$this->_data['perpage']=$perpage;
		$this->_data['uri_segment']=$uri_segment;
	}
	public function set_column($field,$name,$width=0,$icon='icon-file-alt',$class='')
	{
		$this->_data['column'][]=array(
											'field'=>$field,
											'name'=>$name,
											'icon'=>$icon,
											'width'=>$width,
											'class'=>$class
											);
	}
	public function set_column_callback($field,$callback)
	{
		$this->_data['column_callback'][$field]=$callback;
	}
	public function set_top_button($name,$url,$icon='icon-file-alt',$button_type="btn-info",$permision='r',$class='')
	{
		$this->_data['top_button'][]=array(
											'name'=>$name,
											'url'=>$url,
											'icon'=>$icon,
											'type'=>$button_type,
											'permision'=>$permision,
											'btn_type' => 'button',
											'class'=>$class
											);
	}
	public function set_checkall_dropdown($name,$url,$permision='view',$class='')
	{
		$this->_data['checkall_dropdown'][]=array(
											'name'=>$name,
											'url'=>$url,
											'permision'=>$permision,
											'class'=>$class
											);
	}
	public function set_action_button($name,$url,$icon='icon-file-alt',$button_type="btn-info",$permision='view',$class='')
	{
		$this->_data['button'][]=array(
											'name'=>$name,
											'url'=>$url,
											'icon'=>$icon,
											'type'=>$button_type,
											'permision'=>$permision,
											'class'=>$class
											);
	}
	
	public function make_list($tableType='')
	{
		$this->_data['tableType'] = $tableType;
		$this->admin_library->form_view("listview_".$this->_list_type,$this->_data);
		$this->initd($this->me);
	}
	//Form
	public function make_form()
	{
		$this->admin_library->form_view("form_view");
		$this->initd($this->me);
	}
	public function check_permision($perm)
	{
		return $this->_menu_perm_data[$perm];	
	}
	public function update_permision($group_id,$menu_key,$perm)
	{
		$this->db->where("perm_group_id",$group_id);
		$this->db->where("perm_menu_key",$menu_key);
		$has_row = $this->db->get("system_usergroup_permision")->num_rows();
		
		$this->db->set("perm_read",$perm['read']);
		$this->db->set("perm_write",$perm['write']);
		$this->db->set("perm_delete",$perm['delete']);
		if($has_row)
		{
			$this->db->where("perm_menu_key",$menu_key);
			$this->db->where("perm_group_id",$group_id);
			$this->db->update("system_usergroup_permision");
		}else{
			$this->db->set("perm_menu_key",$menu_key);
			$this->db->set("perm_group_id",$group_id);
			$this->db->set("perm_status","active");
			$this->db->insert("system_usergroup_permision");
		}
	}
	public function get_group_permision($group_id)
	{
		$res = array();
		$this->db->where("perm_group_id",$group_id);
		$perm = $this->db->get("system_usergroup_permision")->result_array();
		foreach($perm as $row)
		{
			$res[$row['perm_menu_key']]['read'] = $row['perm_read'];
			$res[$row['perm_menu_key']]['write'] = $row['perm_write'];
			$res[$row['perm_menu_key']]['delete'] = $row['perm_delete'];
		}
		return $res;
	}
	
	public function fckmodel($fckname)
	{
		$data = array(
	        'id'     =>     $fckname,
	        'path'    =>    'public/ckeditor',
	        'ckfinder' => array(
	        'path'    =>    'public/ckfinder',
	        ),
	        'config' => array(
	            'toolbar'     =>     "Basic",
	            'width'     =>     "810px",
	            'height'     =>     '200px',
	        ),
	        'styles' => array(
	         
	        )
	    );

		return $data;
	}
	
	public function get_companyinfo(){
		$query = $this->db->where('company_id', 1)
							->get('system_company')->row_array();
		return $query;
	}

	public function calculateAmount( $amount = 0 ){
		$fee=0;
		$total=0;
		if( $amount < 30000 ){ // 0 - 29,999.99
			$fee = 15;
		}else if( $amount >= 30000 && $amount < 50000 ){ // 30,000 - 49,999.99
			$fee = 20;
		}else if( $amount >= 50000 && $amount < 100000 ){ // 50,000 - 99,999.99
			$fee = 30;
		}else{
			$fee = 100;
		}

		/* Calculate total payment */
		$total = intval( $amount + $fee );
		$response = array(
			'fee' => $fee,
			'total' => $total
		);

		return $response;

	}
}