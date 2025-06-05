<?php
class Facebook_db_driver extends CI_Model{ 
	public function set_login()
	{
		$facebook_id = $this->facebook->getUser();
		if(!$facebook_id){
			return true;	
		}
		$code = @$_SESSION["code"];
		if($code){
			//return false;	
		}else{
			$_SESSION["code"]=$this->input->get("code");
			$_SESSION["state"]=$this->input->get("state");	
		}
		$url = "https://graph.facebook.com/oauth/access_token?client_id=".$this->facebook->app_id()."&client_secret=".$this->facebook->app_secret()."&grant_type=fb_exchange_token&fb_exchange_token=".$this->facebook->getAccessToken();
		@parse_str(@file_get_contents($url));
		$_SESSION["access_token"]=@$access_token;
		setcookie("access_token",@$access_token,time()+@$expires);
	}
	public function is_registered()
	{
		$facebook_id = $this->facebook->getUser();
		if(!$facebook_id){
			return true;	
		}
		$this->db->where("fbid",$facebook_id);
		$is_registered = $this->db->count_all_results("system_fbusers");
		if($is_registered > 0){
			return true;	
		}else{
			return false;	
		}
	}
	function getMemberName()
	{
		$facebook_id = $this->facebook->getUser();
		if(!$facebook_id){
			return "";	
		}
		$this->db->where("fbid",$facebook_id);
		$member = $this->db->get("system_fbusers")->row_array();
		return $member['fbname'];
	}
	
	public function get_userid()
	{
		$facebook_id = $this->facebook->getUser();
		if(!$facebook_id){
			return 0;	
		}
		$this->db->where("fbid",$facebook_id);
		$this->db->limit(1);
		$user = $this->db->get("system_fbusers")->row_array();
		if(!$user){
			return 0;	
		}else{
			return intval($user['id']);	
		}
	}
	public function save_user()
	{
		$account_data = $this->facebook->me();	
		if(!$account_data->length()){
			show_error("ไม่สามารถตรวจสอบ Facebook  Account ของคุณได้");	
		}
		$this->db->where("fbid",@$fbInfo['id']);
		$this->db->limit(1);
		$user = $this->db->get("system_fbusers")->row_array();
		if($user){
			$this->update_user();
			return false;
		}
		
		$fbInfo = $account_data->toArray();
		$this->db->set("fbid",@$fbInfo['id']);
		$this->db->set("fbname",@$fbInfo['name']);
		$this->db->set("fbfname",@$fbInfo['first_name']);
		$this->db->set("fblname",@$fbInfo['last_name']);
		$this->db->set("fbemail",@$fbInfo['email']);
		$this->db->set("fbgender",@$fbInfo['gender']);
		$this->db->set("fbbirthday",date("Y-m-d H:i:s",strtotime(@$fbInfo['birthday'])));
		$this->db->set("join_date",date("Y-m-d H:i:s"));
		$this->db->set("join_ip",$this->input->ip_address());
		$this->db->set("access_token",@$this->facebook->getAccessToken());
		$this->db->set("profile_image",@$fbInfo['picture']['data']['url']);
		$this->db->insert("system_fbusers");
	}
	function update_user()
	{
		$account_data = $this->facebook->me();	
		if(!$account_data->length()){
			show_error("ไม่สามารถตรวจสอบ Facebook  Account ของคุณได้");	
		}
		$fbInfo = $account_data->toArray();
		
		$this->db->set("fbname",@$fbInfo['name']);
		$this->db->set("fbfname",@$fbInfo['first_name']);
		$this->db->set("fblname",@$fbInfo['last_name']);
		$this->db->set("fbemail",@$fbInfo['email']);
		$this->db->set("fbgender",@$fbInfo['gender']);
		$this->db->set("fbbirthday",date("Y-m-d H:i:s",strtotime(@$fbInfo['birthday'])));
		$this->db->set("lastlogin_date",date("Y-m-d H:i:s"));
		$this->db->set("lastlogin_ip",$this->input->ip_address());
		$this->db->set("access_token",@$this->facebook->getAccessToken());
		$this->db->set("profile_image",@$fbInfo['picture']['data']['url']);
		$this->db->where("fbid",@$fbInfo['id']);
		$this->db->update("system_fbusers");
	}
	function make_pagenation($total,$limit,$page,$link)
	{
		$link = tab_url() . "?app_data={$link}";
		$tt = intval($total/$limit);
		if($total%$limit <> 0){
			$tt++;	
		}
		$start = 1;
		$end = 5;
		if($page > 3){
			$start = $page-2;
			$end = $start + 5;	
		}
		if($start+5 > $tt){
			$start = 1;	
			$end = $start + 5;	
		}
		if($end > $tt){
			$end = $tt;	
		}
		$ss = ($start-5 > 1)?($start-5):1;
		$li = '<li><a href="'.$link.'/1" target="_top" class="cufon">หน้าแรก | </a></li>';
		if($start > 1){
			$li .= '<li><a href="'.$link.'/'.$ss.'" target="_top" class="cufon">&laquo; | </a></li>';
		}
		for($i=$start;$i<=$end;$i++){
			$li .= '<li><a href="'.$link.'/'.$i.'" target="_top" class="cufon">'.$i.' | </a></li>';
		}
		if($end < $tt){
			$li .= '<li><a href="'.$link.'/'.($end+1).'" target="_top" class="cufon">&raquo; | </a></li>';
		}
		$li .= '<li><a href="'.$link.'/'.$tt.'" target="_top" class="cufon">หน้าสุดท้าย</a></li>';
		return $li;
	}
	

	
}