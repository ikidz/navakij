<?php
class Admin_library{
	private $ci;
	private $setting = array();
	private $admin_session_id = "";
	private $admin_session= array();
	private $breadcrumb= array();
	private $admin_islogin = false;
	private $admin_issuper = NULL;
	private $_span = 0;
	public function __construct()
	{
		@ob_start();
		$this->ci = & get_instance();
		$this->ci->load->library('parser');
		$this->ci->load->model('administrator/admin_model');
		//$this->ci->load->library('database');
		$this->setting['body_entry']="";
		$this->setting['get']=array();
		$this->setting['title'] = "Administrator";	
		$this->setting['asset_url'] = base_url("public/panel") . "/";	
		$this->setting['site_url'] = site_url();	
		$this->setting['base_url'] = base_url();	
		$this->setting['admin_url'] = admin_url();	
		$this->setting['current_url'] = site_url($this->ci->uri->uri_string());
		$this->setting['navi_title'] = NULL;
		$this->setting['navi_icon'] = NULL;
		$this->setting['toolbar'] = array();
		$this->setting['company_name']=NULL;
		$this->admin_session_id = "admss_" . md5($this->ci->input->server("HTTP_HOST"));
		$this->admin_session = $this->ci->session->userdata($this->admin_session_id);
		
		if($this->admin_session){
			$this->admin_session=json_decode(base64_decode($this->admin_session),true);
			$this->admin_islogin=true;	
			$this->_getuserinfo();
			$this->getCompanyName();
		}
		if(strpos(@$_SERVER['HTTP_USER_AGENT'],"iPhone") !== false || strpos(@$_SERVER['HTTP_USER_AGENT'],"Android") !== false){
			$this->setting['desktop']=false;
			$this->setting['mobile']=true;
			$this->setting['tablet']=false;
		}else if(strpos(@$_SERVER['HTTP_USER_AGENT'],"iPad") !== false){
			$this->setting['desktop']=false;
			$this->setting['mobile']=false;
			$this->setting['tablet']=true;
		}else{
			$this->setting['desktop']=true;
			$this->setting['mobile']=false;
			$this->setting['tablet']=false;
		}
		define('upload_max_filesize', $this->getSymbol($this->get_upload_max_filesize()));
	}
	
	public function userdata($name){
		if(!$this->admin_session){
			return NULL;
		}
		if(!isset($this->admin_session[$name])){
			return NULL;
		}
		return $this->admin_session[$name];
	}
	public function set_userdata($name,$value){
		$this->admin_session[$name]=$value;
		$setdata = base64_encode(json_encode($this->admin_session));
		$this->ci->session->set_userdata($this->admin_session_id,$setdata);
	}
	public function setLogin($user_id)
	{
		$this->set_userdata('user_id',$user_id);	
	}
	public function logout()
	{
		$this->ci->session->unset_userdata($this->admin_session_id);
	}
	public function isLogin()
	{
		return $this->admin_islogin;
	}
	public function forceLogin()
	{
		if($this->isLogin()==false){
			$current_admin = $this->_getuserinfo();
			if( $current_admin['user_group'] == 5){
				admin_redirect("login/pin?next=" . $this->ci->uri->uri_string());
			}else{
				admin_redirect("login?next=" . $this->ci->uri->uri_string());
			}
		}
	}
	public function assign($name,$value)
	{
		$this->setting[$name] = $value;
	}
	public function setTitle($title,$icon=NULL)
	{
		$this->setting['navi_icon'] = $icon;
		$this->setting['navi_title'] = $title;
		$this->setting['title'] = $title . " Administrator";
	}
	public function setDetail($detail)
	{
		$this->setting['page_detail'] = $detail;
	}
	public function addToolbar($view)
	{
		$this->setting['toolbar'][] = $this->ci->parser->parse($view,$this->setting,true);
	}
	public function addToolbarLink($label,$link,$icon)
	{
		$html = "";
		if($icon){
			$html .= "<i class=\"{$icon} icon-large\"></i>";	
		}
		$html .= "<a href=\"{$link}\">{$label}</a>";
		$this->setting['toolbar'][]=$html;
	}
	public function split_row($output=false)
	{
		$res= $this->ci->load->view("administrator/conquer/row_fluid",array(),true);
		if($output==false){
			$this->setting['body_entry'] .= $res;
		}
	}
	public function output()
	{
		
			//$this->setting['body_entry'] = @ob_get_clean();
			//$this->setting['menu_entry']=$this->_menu_entry();
			
			$this->setting['menu_entry']=$this->permision_menu_list();
			$this->setting['header_bar'] = $this->ci->parser->parse("administrator/conquer/header_bar",$this->setting,true);
			$this->setting['navi_entry'] = $this->ci->parser->parse("administrator/conquer/page_navi",$this->setting,true);
			$this->setting['left_menu'] = $this->ci->parser->parse("administrator/conquer/left_menu",$this->setting,true);
			$this->setting['upload_max_filesize'] = $this->get_upload_max_filesize();
		if(@$_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest" || @$_SERVER['X-fancyBox']=="true"){
			$this->ci->load->view("administrator/conquer/template_ajax",$this->setting);
		}else{	
			$this->ci->load->view("administrator/conquer/template",$this->setting);
		}
	}
	public function output_clean()
	{
			$this->ci->load->view("administrator/conquer/template_clear",$this->setting);
	}
	public function loginoutput()
	{
		$this->setting['body_entry'] = @ob_get_contents();
		@ob_end_clean();
		$this->ci->load->view("administrator/conquer/login",$this->setting);
	}
	public function pinloginoutput(){
		$this->setting['body_entry'] = @ob_get_contents();
		@ob_end_clean();
		$this->ci->load->view("administrator/conquer/pinlogin",$this->setting);
	}
	public function resetpassoutput()
	{
		$this->setting['body_entry'] = @ob_get_contents();
		@ob_end_clean();
		$this->ci->load->view("administrator/conquer/resetpass",$this->setting);
	}
	
	public function view($file,$data=array(),$output=false,$span=12)
	{
		$res= "";
		if($data){
			$data = array_merge($this->setting,$data);
		}else{
			$data = $this->setting;
		}
		foreach($_GET as $key=>$val){
			$this->setting['get'][$key]=$val;
		}
		if($this->_span > 11){
			$this->_span = $span;
			$res .= $this->ci->load->view("administrator/conquer/row_fluid",$data,true);
		}else{
			$this->_span += $span;
		}
		$res .= $this->ci->load->view("administrator/views/".$file,$data,true);
		if($output==false){
			$this->setting['body_entry'] .= $res;
		}
		return $res;
	}
	public function form_view($file,$data=array(),$output=false)
	{
		if($data){
			$data = array_merge($this->setting,$data);
		}else{
			$data = $this->setting;
		}
		foreach($_GET as $key=>$val){
			$this->setting['get'][$key]=$val;
		}
		$res= $this->ci->load->view("administrator/form_view/".$file,$data,true);
		if($output==false){
			$this->setting['body_entry'] = $res;
		}
		return $res;
	}
	public function auth($username,$password)
	{
		$password=md5($password);
		$this->ci->db->where("username",$username);	
		$this->ci->db->where("password",$password);	
		$this->ci->db->where("user_status","active");
		return $this->ci->db->get("system_users")->row_array();
	}
	
	public function getuserinfo_byemail($email)
	{
		$this->ci->db->where("user_email",$email);	
		return $this->ci->db->get("system_users")->row_array();
	}
	public function getuserinfo_byusername($email)
	{
		$this->ci->db->where("username",$email);	
		return $this->ci->db->get("system_users")->row_array();
	}
	public function getuserinfo($user_id)
	{
		$this->ci->db->where("user_id",$user_id);	
		return $this->ci->db->get("system_users")->row_array();
	}
	public function user_id()
	{
		return  $this->userdata("user_id");
	}
	public function me()
	{
		$user_id = $this->userdata("user_id");
		$this->ci->db->where("user_id",$user_id);	
		return $this->ci->db->get("system_users")->row_array();
	}
	public function check_username($username)
	{
		$this->ci->db->where("username",$username);	
		$this->ci->db->where("user_status !=","delete");	
		return $this->ci->db->count_all_results("system_users");
	}
	public function adduser($user_fullname,$user_email,$user_mobileno,$user_group,$username,$password)
	{
		$password=md5($password);
		
		$this->ci->db->set("user_fullname",$user_fullname);
		$this->ci->db->set("user_email",$user_email);
		$this->ci->db->set("user_mobileno",$user_mobileno);
		$this->ci->db->set("user_group",$user_group);
		$this->ci->db->set("username",$username);
		$this->ci->db->set("password",$password);
		$this->ci->db->set("user_joindate","NOW()",false);
		$this->ci->db->set("user_joinip",$this->ci->input->ip_address());
		$this->ci->db->where("user_id",$user_id);
		$this->ci->db->insert("system_users");
		return $this->ci->db->insert_id();
	}
	public function updateuserinfo($user_id,$user_fullname,$user_email,$user_mobileno,$user_group,$username)
	{
		$this->ci->db->set("user_fullname",$user_fullname);
		$this->ci->db->set("user_email",$user_email);
		$this->ci->db->set("user_mobileno",$user_mobileno);
		$this->ci->db->set("user_group",$user_group);
		$this->ci->db->set("username",$username);
		$this->ci->db->where("user_id",$user_id);
		$this->ci->db->update("system_users");
	}
	public function active_account($user_id)
	{
		$this->ci->db->set("user_status","active");
		$this->ci->db->where("user_id",$user_id);
		$this->ci->db->update("system_users");
	}
	public function delete_account($user_id)
	{
		$this->ci->db->set("user_status","delete");
		$this->ci->db->where("user_id",$user_id);
		$this->ci->db->update("system_users");
	}
	public function suspend_account($user_id)
	{
		$this->ci->db->set("user_status","suspend");
		$this->ci->db->where("user_id",$user_id);
		$this->ci->db->update("system_users");
	}
	public function getResetUserFromKey($reset_key)
	{
		$this->ci->db->set("reset_status","expired");
		$this->ci->db->where("reset_date <",date("Y-m-d H:i:s",strtotime("-30 minutes")));
		$this->ci->db->update("system_resetpass");
		
		$this->ci->db->where("reset_key",$reset_key);	
		$this->ci->db->where("reset_date >",date("Y-m-d H:i:s",strtotime("-30 minutes")));
		$this->ci->db->where("reset_status","pending");
		$res = $this->ci->db->get("system_resetpass")->row_array();
		if($res){
			return $res['user_id'];	
		}else{
			return false;	
		}
		
	}
	public function updatePassword($user_id,$newpassword)
	{
		$newpassword=md5($newpassword);
		$this->ci->db->set("password",$newpassword);
		$this->ci->db->where("user_id",$user_id);
		$this->ci->db->update("system_users");
		
		$this->ci->db->set("reset_status","complete");
		$this->ci->db->where("user_id",$user_id);
		$this->ci->db->update("system_resetpass");
	}
	public function getResetPassUUID($user_id)
	{
		$user_data = $this->getuserinfo($user_id);
		$reset_key=NULL;
		if(!$user_data){ return false; }
		$this->ci->db->where("user_id",$user_data['user_id']);	
		$this->ci->db->where("reset_date >",date("Y-m-d H:i:s",strtotime("-30 minutes")));
		$this->ci->db->where("reset_status","pending");
		$old_key = $this->ci->db->get("system_resetpass")->row_array();
		if($old_key){
			$reset_key = $old_key['reset_key'];
		}else{
			$this->ci->db->set("reset_status","expired");
			$this->ci->db->where("user_id",$user_data['user_id']);	
			$this->ci->db->update("system_resetpass");
			
			$this->ci->db->set("reset_key","UUID()",false);
			$this->ci->db->set("user_id",$user_data['user_id']);	
			$this->ci->db->set("reset_date",date("Y-m-d H:i:s"));
			$this->ci->db->set("reset_ip",$this->ci->input->ip_address());
			$this->ci->db->insert("system_resetpass");
			$this->ci->db->where("reset_id",$this->ci->db->insert_id());	
			$new_key = $this->ci->db->get("system_resetpass")->row_array();
			if($new_key){
				$reset_key = $new_key['reset_key'];
			}
		}
		if($reset_key){
			return $reset_key;	
		}else{
			show_error("Couldn't create reset_key");	
		}
		
	}
	public function createResetLink($user_id)
	{
		$user_data = $this->getuserinfo($user_id);
		if(!$user_data){ return false; }
		$this->ci->db->where("user_id",$user_data['user_id']);	
		$this->ci->db->where("reset_date >",date("Y-m-d H:i:s",strtotime("-30 minutes")));
		$this->ci->db->where("reset_status","pending");
		$old_key = $this->ci->db->get("system_resetpass")->row_array();
		if($old_key){
			$reset_key = $old_key['reset_key'];
		}else{
			$reset_key=md5($user_email.time());
			$this->ci->db->set("reset_key",$reset_key);
			$this->ci->db->set("user_id",$user_data['user_id']);	
			$this->ci->db->set("reset_date",date("Y-m-d H:i:s"));
			$this->ci->db->set("reset_ip",$this->ci->input->ip_address());
			$this->ci->db->insert("system_resetpass");
		}
		return admin_url("resetpassword/{$reset_key}");
	}
	public function getAllGroup()
	{
		$this->ci->db->order_by("group_name","ASC");
		$this->ci->db->where("group_status !=","delete");
		return $this->ci->db->get("system_group");
	}
	public function getGroupDetail($group_id)
	{
		$this->ci->db->where("group_id",$group_id);
		$this->ci->db->where("group_status !=","delete");
		return $this->ci->db->get("system_group")->row_array();
	}
	public function getGroupName($group_id)
	{
		$this->ci->db->where("group_id",$group_id);
		$this->ci->db->where("group_status !=","delete");
		$row = $this->ci->db->get("system_group")->row_array();
		return $row['group_name'];
	}
	public function getGroupRow($group_id)
	{
		$this->ci->db->where("group_id",$group_id);
		$this->ci->db->where("group_status !=","delete");
		return $this->ci->db->get("system_group");
	}
	public function addGroup($group_name,$group_superadmin,$company_id)
	{
		$this->ci->db->set("group_name",$group_name);
		$this->ci->db->set("group_superadmin",$group_superadmin);
		$this->ci->db->set("company_id",$company_id);
		$this->ci->db->set("group_status","active");
		$this->ci->db->insert("system_group");
		return $this->ci->db->insert_id();
	}
	public function updateGroup($group_id,$group_name,$group_superadmin,$company_id)
	{
		$this->ci->db->set("group_name",$group_name);
		$this->ci->db->set("group_superadmin",$group_superadmin);
		$this->ci->db->set("company_id",$company_id);
		$this->ci->db->where("group_id",$group_id);
		return $this->ci->db->update("system_group");
	}
	public function deleteGroup($group_id)
	{
		$this->ci->db->set("group_status","delete");
		$this->ci->db->where("group_id",$group_id);
		$this->ci->db->update("system_group");
		
		$this->ci->db->set("user_status","delete");
		$this->ci->db->where("user_group",$group_id);
		$this->ci->db->update("system_users");
		
		$this->ci->db->set("perm_status","delete");
		$this->ci->db->where("perm_group_id",$group_id);
		$this->ci->db->update("system_usergroup_permision");
	}
	public function clearPermision($group_id)
	{
		$this->ci->db->where("group_id",$group_id);
		return $this->ci->db->delete("system_permision");
	}
	public function addPermision($group_id,$menu_id,$submenu_id){
		if($submenu_id > 0){
				$this->ci->db->where("menu_id",$menu_id);
				$has = $this->ci->db->count_all_results("system_permision");
				if(!$has){
					$this->addPermision($group_id,$menu_id,0);
				}
		}
		$this->ci->db->set("submenu_id",$submenu_id);
		$this->ci->db->set("menu_id",$menu_id);
		$this->ci->db->set("group_id",$group_id);
		return $this->ci->db->insert("system_permision");
	}
	public function getAllCompany()
	{
		$this->ci->db->order_by("company_name","ASC");
		$this->ci->db->where("company_status !=","delete");
		return $this->ci->db->get("system_company");
	}
	public function getAllUser()
	{
		$current_admin = $this->_getuserinfo();
		$company_id = $current_admin['company_id'];
		$this->ci->db->select("system_users.user_id,system_users.user_avatar,system_users.username,system_users.user_fullname,system_users.user_email,system_users.user_mobileno,system_users.user_status,system_users.user_joindate,system_users.user_group,system_group.company_id");
		$this->ci->db->join("system_group","system_group.group_id=system_users.user_group");
		$this->ci->db->where("system_users.user_status !=","delete");
		$this->ci->db->where("system_group.company_id",$company_id);
		return $this->ci->db->get("system_users");
	}
	public function getCompanyName()
	{
		if($this->setting['company_name']==NULL){
			$grp = $this->getGroupDetail($this->setting['user_info']['user_group']);
			$user_company = $grp['company_id'];
		
			$this->ci->db->select("company_name");
			$this->ci->db->where("company_id",$user_company);
			$rs = $this->ci->db->get("system_company")->row_array();
			if(!$rs){
				show_error("Cannot find company for current user.");	 
			}
			$this->setting['company_name'] = $rs['company_name'];
		}
		return $this->setting['company_name'];
	}
	private function _getuserinfo()
	{
		$user_id = $this->userdata("user_id");
		$this->ci->db->select("system_users.user_id,system_users.user_avatar,system_users.username,system_users.user_fullname,system_users.user_email,system_users.user_mobileno,system_users.user_status,system_users.user_joindate,system_users.user_group,system_group.company_id");
		$this->ci->db->join("system_group","system_group.group_id=system_users.user_group");
		$this->ci->db->where("system_users.user_id",$user_id);
		$this->setting['user_info'] = $this->ci->db->get("system_users")->row_array(); 
		$grp = $this->getGroupDetail($this->setting['user_info']['user_group']);
		$this->setting['user_company']= $grp['company_id'];
		if(!$this->setting['user_info']){
			$this->admin_islogin=false;	
			return false;
		}
		return $this->setting['user_info'];
	}
	public function getMenu($menu_link)
	{
		$this->ci->db->where("menu_link",$menu_link);
		return $this->ci->db->get("system_menu")->row_array();
	}
	public function getSubMenu($menu_link,$submenu_link)
	{
		$this->ci->db->like("menu_link",$menu_link,"after");
		$menu = $this->ci->db->get("system_menu")->row_array();
		if(!$menu){
			return false;	
		}
		
		$this->ci->db->where("menu_id",$menu["menu_id"]);
		$this->ci->db->like("menu_link",$submenu_link,"before");
		$submenu = $this->ci->db->get("system_submenu")->row_array();
		
		return $submenu;
	}
	public function menuPermision($group_id,$menu_id,$submenu_id){
		$this->ci->db->where("group_id",$group_id);
		$this->ci->db->where("menu_id",$menu_id);
		$this->ci->db->where("submenu_id",$submenu_id);
		$has = $this->ci->db->count_all_results("system_permision");
		$has = ($has > 0)?true:false;
		return $has;
	}
	public function add_breadcrumb($menu_label,$menu_link,$menu_icon)
	{
		$this->breadcrumb[] = array(
				"menu_label" => $menu_label,
				"menu_link" => admin_url($menu_link),
				"menu_icon" => $menu_icon,
			);
	}
	public function breadcrumb()
	{
		$result = array();
		$current_class = $this->ci->router->fetch_class();
		$current_method = $this->ci->router->fetch_method();
		$menu = $this->getMenu($current_class);
		$submenu = $this->getSubMenu($current_class,$current_method);
		if($menu){
			$result[]=array(
				"menu_label" => $menu['menu_label'],
				"menu_link" => admin_url(@$menu['menu_link']),
				"menu_icon" => $menu['menu_icon'],
			);
		}
		if($submenu){
			$result[]=array(
				"menu_label" => $submenu['menu_label'],
				"menu_link" => admin_url($submenu['menu_link']),
				"menu_icon" => $submenu['menu_icon'],
			);
		}
		$result = array_merge($result,$this->breadcrumb);
		return $result;
	}
	public function getAllMenu()
	{
		return $this->_admin_menu_entry();	
	}
	private function _admin_menu_entry()
	{
		$this->ci->db->order_by("menu_sequent","asc");
		$menu = $this->ci->db->get("system_menu");
		$entry = array();
		$curr_menu_key = $this->ci->admin_model->get_curr_menu_key();
		foreach($menu->result_array() as $row){
			
			$sub_entry = array();
			$sub_entry['submenu_entry']=$this->_admin_sub_menu_entry($row);
			$sub_entry['id'] = $row['menu_id'];
			$sub_entry['label'] = $row['menu_label'];
			$sub_entry['icon'] = $row['menu_icon'];
			$sub_entry['key'] = $row['menu_key'];
			$sub_entry['link'] = admin_url($row['menu_link']);
			$class_menu = explode("/", $row['menu_link']);
			$current_class = $this->ci->router->fetch_class();
			if($curr_menu_key == ""){
				$sub_entry['active'] = ($current_class==$class_menu[0])?"active":"";
			}else{
				$sub_entry['active'] = ($curr_menu_key==$row['menu_key'])?"active":"";
			}
			
			$entry[] = $sub_entry;
			unset($sub_entry);
		}
		return $entry;
	}
	private function _admin_sub_menu_entry($menu)
	{
		$this->ci->db->where("menu_id",$menu['menu_id']);
		$this->ci->db->order_by("menu_sequent","asc");
		$submenu = $this->ci->db->get("system_submenu");
		$entry = array();
		$curr_menu_key = $this->ci->admin_model->get_curr_menu_key();
		foreach($submenu->result_array() as $row){
			
			$sub_entry = array();
			$sub_entry['submenu_entry']=array();
			$sub_entry['id'] = $row['submenu_id'];
			$sub_entry['label'] = $row['menu_label'];
			$sub_entry['icon'] = $row['menu_icon'];
			$sub_entry['key'] = $row['menu_key'];
			$sub_entry['link'] = admin_url($menu['menu_link'] . "/".$row['menu_link']);
			$class_menu = explode("/", $row['menu_link']);
			$current_class = $this->ci->router->fetch_class();
			if($curr_menu_key == ""){
				$sub_entry['active'] = ($current_class==$class_menu[0])?"active":"";
			}else{
				$sub_entry['active'] = ($curr_menu_key==$row['menu_key'])?"active":"";
			}
			$entry[] = $sub_entry;
			unset($sub_entry);
		}
		return $entry;
	}
	function is_superadmin()
	{
		if($this->admin_issuper==NULL){
			$rs = $this->getGroupDetail($this->setting['user_info']['user_group']);	
			if($rs['group_superadmin']!="yes"){ 
				return false;
			}else{
				return true;
			}
		}
		return $this->admin_issuper;
	}
	private function _menu_entry()
	{
		$this->ci->db->order_by("menu_sequent","asc");
		$menu = $this->ci->db->get("system_menu");
		$entry = array();
		foreach($menu->result_array() as $row){
			if($this->is_superadmin()==false){
				$checked = $this->menuPermision($this->setting['user_info']['user_group'],$row['menu_id'],0);
			}else{
				$checked = true;	
			}
			if($checked){
				$sub_entry = array();
				$sub_entry['submenu_entry']=$this->_sub_menu_entry($row);
				$sub_entry['id'] = $row['menu_id'];
				$sub_entry['label'] = $row['menu_label'];
				$sub_entry['icon'] = $row['menu_icon'];
				$sub_entry['link'] = admin_url($row['menu_link']);
				$class_menu = explode("/", $row['menu_link']);
				//$current_class = $this->ci->router->fetch_class();
				$class_curr = explode("/", $this->ci->uri->uri_string());
				$current_class = @$class_curr[1];
				$sub_entry['active'] = ($current_class==$class_menu[0])?"active":"";
				//$sub_entry['active'] = (strpos($current_class,$row['menu_link']) !== false)?"active":"";
				$entry[] = $sub_entry;
				unset($sub_entry);
			}
		}
		return $entry;
	}
	private function _sub_menu_entry($menu)
	{
		$this->ci->db->where("menu_id",$menu['menu_id']);
		$this->ci->db->order_by("menu_sequent","asc");
		$submenu = $this->ci->db->get("system_submenu");
		$entry = array();
		foreach($submenu->result_array() as $row){
			if($this->is_superadmin()==false){
				$checked = $this->menuPermision($this->setting['user_info']['user_group'],$menu['menu_id'],$row['submenu_id']);
			}else{
				$checked = true;
			}
			if($checked){
				$sub_entry = array();
				$sub_entry['submenu_entry']=array();
				$sub_entry['id'] = $row['submenu_id'];
				$sub_entry['label'] = $row['menu_label'];
				$sub_entry['icon'] = $row['menu_icon'];
				$sub_entry['link'] = admin_url($menu['menu_link'] . "/".$row['menu_link']);
				$class_menu = explode("/", $row['menu_link']);
				$current_class = $this->ci->router->fetch_method();
				//$sub_entry['active'] = ($current_class==$class_menu[0])?"active":"";
				$sub_entry['active'] = (strpos($this->ci->uri->uri_string(),$menu['menu_link'] . "/".$row['menu_link']) !== false)?"active":"";
				$entry[] = $sub_entry;
				unset($sub_entry);
			}
		}
		return $entry;
	}
	public function getLanguageList()
	{
		return $this->ci->db->get("system_language")->result_array();	 
	}
	public function getLanguagename($lang_id)
	{
		$this->ci->db->where("lang_id",$lang_id);
		$lang = $this->ci->db->get("system_language")->row_array();	 
		return $lang['lang_name'];
	}
	public function getLanguageflag($lang_id)
	{
		$this->ci->db->where("lang_id",$lang_id);
		$lang = $this->ci->db->get("system_language")->row_array();	 
		return $lang['lang_flag'];
	}
	public function permision_menu_list()
	{
		$me = $this->me();
		$group_id = $me['user_group'];
		if($this->is_superadmin()==false){
			$menu_list = $this->_perm_mainmenu_list($group_id);
		}else{
			$menu_list = $this->_superadmin_mainmenu_list($group_id);
		}
		return $menu_list;
	}
	private function _perm_mainmenu_list($group_id=0)
	{
		$this->ci->db->select("system_menu.menu_id,system_menu.menu_label,system_menu.menu_icon,system_menu.menu_link,system_menu.menu_key");
		$this->ci->db->join("system_usergroup_permision","system_usergroup_permision.perm_menu_key = system_menu.menu_key","inner");
		$this->ci->db->where("(system_usergroup_permision.perm_write='true' OR system_usergroup_permision.perm_delete='true' OR system_usergroup_permision.perm_read='true') AND system_usergroup_permision.perm_status='active' AND system_usergroup_permision.perm_group_id={$group_id}",false,false);
		$this->ci->db->order_by("system_menu.menu_sequent","ASC");
		$system_menu = $this->ci->db->get("system_menu")->result_array();
		$entry = array();
		$curr_menu_key = $this->ci->admin_model->get_curr_menu_key();
		foreach($system_menu as $row){
			$sub_entry = array();
			$sub_entry['submenu_entry']=$this->_perm_submenu_list($row['menu_link'],$group_id,$row['menu_id']);
			$sub_menu_active = false;
			if( isset( $sub_entry ) && count( $sub_entry ) > 0 ){
				$sub_menu_active=$sub_entry['submenu_entry']['curr_menu'];
			}
			$sub_entry['id'] = $row['menu_id'];
			$sub_entry['label'] = $row['menu_label'];
			$sub_entry['icon'] = $row['menu_icon'];
			$sub_entry['link'] = admin_url($row['menu_link']);
			$sub_entry['active'] = ( $sub_menu_active === true ? 'active' : '' );
			$curr_active = strpos(current_url(),admin_url($row['menu_link']));

			if($sub_menu_active==true){
				$sub_entry['active'] = "active";
			}else if( $curr_menu_key == $row['menu_key'] ){
				$sub_entry['active'] = 'active';
			}
			$entry[] = $sub_entry;
		}
		return $entry;
	}
	private function _perm_submenu_list($link,$group_id,$menu_id)
	{
		$this->ci->db->select("system_submenu.menu_id,system_submenu.menu_label,system_submenu.menu_icon,system_submenu.menu_link,system_submenu.menu_key");
		$this->ci->db->join("system_usergroup_permision","system_usergroup_permision.perm_menu_key = system_submenu.menu_key","inner");
		$this->ci->db->where("(system_usergroup_permision.perm_write='true' OR system_usergroup_permision.perm_delete='true' OR system_usergroup_permision.perm_read='true') AND system_usergroup_permision.perm_status='active' AND system_usergroup_permision.perm_group_id={$group_id} AND system_submenu.menu_id={$menu_id}",false,false);
		$this->ci->db->order_by("system_submenu.menu_sequent","ASC");
		$system_menu = $this->ci->db->get("system_submenu")->result_array();
		$entry = array();
		$curr_menu_key = $this->ci->admin_model->get_curr_menu_key();
		$curr_menu = false;
		if( isset( $system_menu ) && count( $system_menu ) > 0 ){
			foreach($system_menu as $row){
				$sub_entry = array();
				$sub_entry['submenu_entry']=array();
				$sub_entry['id'] = $row['menu_id'];
				$sub_entry['label'] = $row['menu_label'];
				$sub_entry['icon'] = $row['menu_icon'];
				$sub_entry['link'] = admin_url(/* $link . "/" . */$row['menu_link']);
				$curr_active = strpos(current_url(),admin_url($link . "/" .$row['menu_link']));
				
				if($curr_menu_key == ""){
					$sub_entry['active'] = ($curr_active !== false)?"active":"";
				}else{
					$sub_entry['active'] = ($curr_menu_key==@$row['menu_key'])?"active":"";
				}
				$curr_menu = false;
				if($sub_entry['active']=="active"){
					$curr_menu=true;
				}
				$entry[] = $sub_entry;
			}
		}
		$entry['curr_menu']=$curr_menu;
		return $entry;
	}
	private function _superadmin_mainmenu_list($group_id)
	{
		$this->ci->db->select("system_menu.menu_id,system_menu.menu_label,system_menu.menu_icon,system_menu.menu_link,system_menu.menu_key");
		$this->ci->db->order_by("system_menu.menu_sequent","ASC");
		$system_menu = $this->ci->db->get("system_menu")->result_array();
		$entry = array();
		$curr_menu_key = $this->ci->admin_model->get_curr_menu_key();
		foreach($system_menu as $row){
			$sub_entry = array();
			$submenu_entry=$this->_superadmin_submenu_list($row['menu_link'],$row['menu_id']);
			$sub_menu_active=$submenu_entry['curr_menu'];
			$sub_entry['submenu_entry']=@$submenu_entry['menu'];
			$sub_entry['id'] = $row['menu_id'];
			$sub_entry['label'] = $row['menu_label'];
			$sub_entry['icon'] = $row['menu_icon'];
			$sub_entry['link'] = admin_url($row['menu_link']);
			$curr_active = strpos(current_url(),admin_url($row['menu_link']));
			$sub_entry['active'] = ($curr_active !== false)?"active":"";
			if($sub_menu_active==true){
				$sub_entry['active'] = "active";
			}
			$entry[] = $sub_entry;
		}
		return $entry;
	}
	private function _superadmin_submenu_list($link,$menu_id)
	{
		$this->ci->db->select("system_submenu.menu_id,system_submenu.menu_label,system_submenu.menu_icon,system_submenu.menu_link,system_submenu.menu_key");
		$this->ci->db->where("system_submenu.menu_id",$menu_id);
		$this->ci->db->order_by("system_submenu.menu_sequent","ASC");
		$system_menu = $this->ci->db->get("system_submenu")->result_array();
		$entry = array();
		$curr_menu=false;
		$curr_menu_key = $this->ci->admin_model->get_curr_menu_key();
		foreach($system_menu as $row){
			$sub_entry = array();
			$sub_entry['submenu_entry']=array();
			$sub_entry['id'] = $row['menu_id'];
			$sub_entry['label'] = $row['menu_label'];
			$sub_entry['icon'] = $row['menu_icon'];
			$sub_entry['link'] = admin_url(/* $link . "/" . */$row['menu_link']);
			$curr_active = strpos(current_url(),admin_url($link . "/" .$row['menu_link']));
			//$curr_active = ($this->ci->admin_model->get_curr_menu_key()==$row['menu_key']);
			if($curr_menu_key == ""){
				$sub_entry['active'] = ($curr_active !== false)?"active":"";
			}else{
				$sub_entry['active'] = ($curr_menu_key==$row['menu_key'])?"active":"";
			}
			
			if($sub_entry['active']=="active"){
				$curr_menu=true;
			}
			$entry['menu'][] = $sub_entry;
		}
		$entry['curr_menu']=$curr_menu;
		return $entry;
	}
	function get_upload_max_filesize()
	{
		$upload_max_filesize = $this->return_bytes( ini_get("upload_max_filesize") );
		$post_max_size = $this->return_bytes( ini_get("post_max_size") );
		$max = ($upload_max_filesize < $post_max_size)?$upload_max_filesize:$post_max_size;
		return $max;
	}
	function getSymbol($bytes) {
	    $symbols = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB');
	    $exp = floor(log($bytes)/log(1024));
	
	    return sprintf('%.2f '.$symbols[$exp], ($bytes/pow(1024, floor($exp))));
	}
	function return_bytes($val) {
	    $val = trim($val);
	    $last = strtolower($val[strlen($val)-1]);
	    if( is_int( $last ) === false ){
		    $val = str_replace($last, '', strtolower($val));
		}
	    switch($last) {
	        // The 'G' modifier is available since PHP 5.1.0
	        case 'g':
	            $val *= 1024;
	        case 'm':
	            $val *= 1024;
	        case 'k':
	            $val *= 1024;
	    }
	
	    return $val;
	}
}