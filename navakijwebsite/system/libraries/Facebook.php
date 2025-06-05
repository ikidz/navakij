<?php 
require_once(dirname(__FILE__) . "/facebook/base_facebook.php");
require_once("facebook/base_facebook.php");
class CI_Facebook extends BaseFacebook{
	var $_ci;
	var $_fbconfig = array();
	const FBSS_COOKIE_NAME = 'fbss';
	const FBSS_COOKIE_EXPIRE = 31556926; // 1 year
	const FBSS_CACHE_EXPIRE = 86400; // 1 day
	protected $sharedSessionID;
	protected $_me;
	protected $_cache=array();
	protected $_params=array();
	protected $force_cache = false;
	protected $_cache_path;
	protected static $kSupportedKeys = array('state', 'code', 'access_token', 'user_id');
	function __construct()
	{
		$this->_ci =& get_instance();
		$this->_fbconfig = $this->_ci->config->item('facebook_api');
		$config = array();
		$config['appId'] = $this->_fbconfig['app_id'];
		$config['secret'] = $this->_fbconfig['app_secret'];
		if (!session_id()) {
		  session_start();
		}
		parent::__construct($config);
		if (!empty($config['sharedSession'])) {
		  $this->initSharedSession();
		}
		$this->setFileUploadSupport(true);
		$this->_cache_path = realpath('') . "/application/cache/facebook_".$this->getUser().".cache";
		if(file_exists($this->_cache_path)){
			$cache = file_get_contents($this->_cache_path);
			$this->_cache = unserialize(base64_decode($cache));
		}
		/*if(@$_GET['code']){
			$url = "https://graph.facebook.com/oauth/access_token?client_id=".$this->app_id()."&client_secret=".$this->app_secret()."&grant_type=fb_exchange_token&fb_exchange_token=".$this->getAccessToken();
		@parse_str(@file_get_contents($url));
		
			$this->_ci->input->set_cookie("access_token",@$access_token,time()+@$expires);
		}
		if(@$this->_ci->input->cookie('access_token')){
			$this->setAccessToken(@$_COOKIE['access_token']);	
		}*/
		log_message('debug', "Facebook Class Initialized");
	}
	function set($param_key,$param_value)
	{
		$this->_params[$param_key]=$param_value;
	}
	function cache_off()
	{
		$this->force_cache = true;
	}
	function cache_on()
	{
		$this->force_cache = false;
	}
	function app_id()
	{
		return $this->_fbconfig['app_id'];
	}
	function app_secret()
	{
		return $this->_fbconfig['app_secret'];
	}
	function app_namespace()
	{
		return $this->_fbconfig['app_namespace'];
	}
	
	function me()
	{
		if($this->is_login()==false){
			return new Facebook_Result(array());	
		}
		$this->_me = $this->_api("/v2.2/me?fields=id,name,link,picture,first_name,last_name,birthday,email,gender");	
		return new Facebook_Result($this->_me);
	}
	function profile_image()
	{
		
		$profile_image = $this->_api("/me?fields=picture.height(130).width(130)");	
		return $profile_image['picture']['data']['url'];
		
	}
	function friends()
	{
		$friends = $this->_api("/me/friends?fields=id,gender,name");	
		return new Facebook_Result(@$friends['data']);
	}
	function call($api)
	{
		$call = $this->_api($api);	
		return new Facebook_Result(@$call);
	}
	function fql($query)
	{
		$query = urlencode($query);
		$fql = $this->_api("/fql?q={$query}");	
		return new Facebook_Result(@$fql);
	}
	function request($request_ids)
	{
		
	}
	function delete_request($request_ids)
	{
		try{
		$request_ids = explode(",",$request_ids);
		if($request_ids){
			foreach($request_ids as $id){
				$this->api("/".$id,"delete");
			}
		}
		}catch(Exception $e){
			
		}
	}
	function get_account_info($account_id)
	{
		if($this->is_login()==false){
			return new Facebook_Result(array());	
		}
		
		return $this->_api("/".$account_id);
	}
	function is_login()
	{
		if($this->getUser()){
			return true;
		}else{
			return false;	
		}
	}
	function is_fanpage()
	{
		
		$signed_request = $this->getSignedRequest();
		if(isset($signed_request['page'])){
			if($signed_request['page']['liked']==true){
				return true;	
			}else{
				return false;	
			}
		}else{
			if($this->is_login()==false){
				return true;	
			}
			$like_result = $this->api("/me/likes/".$this->_fbconfig['fanpage_id']);
			if(isset($like_result['data'])){
					if(count($like_result['data']) == 1){
						return true;
					}else{
						return false;	
					}
			}
		}
		return false;
	}
	public function albums()
	{
		if($this->is_login()==false){
			return new Facebook_Result(array());
		}
		$result = $this->api("/me/albums/");
		if(isset($result['data'])){
			return new Facebook_Result($result['data']);
		}else{
			return new Facebook_Result(array());	
		}
	}
	public function is_album($keyword)
	{
		$is = $this->albums()->search($keyword,0);
		if($is->Length() > 0){ return $is->item('id')->toString(); }else{ return false; }
	}
	public function add_album()
	{
		/*if(!isset($this->_params['name'])){
			show_error("Please set {name (required),description (optional),location (optional)} first.",500,"Facebook API Error");	
		}*/
		$this->check_param(__FUNCTION__,'name|required','description|optional','location|optional');
		$is_album = $this->is_album($this->_params['name']);
		if($is_album){
			$this->_params=array();
			return $is_album;
		}
		$res = $this->api("/me/albums/","post",$this->_params);
		$this->_params=array();
		if(isset($res['id'])){
			return $res['id'];
		}else{
			return false;
		}
		
	}
	public function photos($album_id=NULL)
	{
		if($this->is_login()==false){
			return new Facebook_Result(array());
		}
		if($album_id != NULL){
			$api = "/{$album_id}/photos/?limit=1000";
		}else{
			$api = "/me/photos/?limit=1000";
		}
		
		$result = $this->_api($api);
		if(isset($result['data'])){
			$result['data']['album_id'] = $album_id;
			return new Facebook_Result($result['data']);
		}else{
			return new Facebook_Result(array());	
		}
	}
	public function add_photos()
	{
		$this->check_param(__FUNCTION__,'message|optional','image|required');
		
		$this->_params['image'] = "@" . realpath($this->_params['image']);
		if($this->_params['image']=="@"){
			show_error("ไม่พบรูปภาพในการโพสต์รูปไปยัง Facebook.",500,"ข้อกำหนดการใช้งาน Mycools Facebook API ผิดพลาด");
		}
		if(!@$this->_params['album_id']){
			$res = $this->api("/me/photos/","post",$this->_params);
		}else{
			$res = $this->api("/".$this->_params['album_id']."/photos/","post",$this->_params);
		}
		$this->_params=array();
		if(isset($res['id'])){
			return $res;
		}else{
			return false;
		}
		
	}
	public function postwall()
	{
		$this->check_param(__FUNCTION__,'link|optional','name|required','caption|optional','description|optional','picture|optional');
		$this->_params['method'] = "feed";
		if(@$this->_params['picture']){
			$this->_params['picture'] = base_url($this->_params['picture']);
		}
		if(!@$this->_params['facebook_id']){
			$res = $this->api("/me/feed/","post",$this->_params);
		}else{
			$res = $this->api("/".$this->_params['facebook_id']."/feed/","post",$this->_params);
		}
		$this->_params=array();
		if(isset($res['post_id'])){
			return $res['post_id'];
		}else{
			return false;
		}
		
	}
	private function check_param(/* Reqiure Param*/)
	{
		$params = func_get_args();
		if(!$params){
			return true;	
		}
		$function = @$params[0];
		unset($params[0]);
		$required = array();
		$optional = array();
		foreach($params as $data){
			$data = preg_split('/\|/', $data);
			if(@$data[1]=="required"){
				$required[]=@$data[0];
			}
			if(@$data[1]=="optional"){
				$optional[]=@$data[0];
			}
		}
		$manual_url = base_url("user_guide/mycools/facebook_class.html") . "#".$function;
		$ex_code = "&lt;?php<br />";
		if($required){
			$ex_code .= "/* Required parameter. */<br />";
		}
		foreach($required as $key){
			if($key == "image" || $key == "picture"){
				$ex_code .= "\$this->facebook->set('{$key}','/path/to/image.jpg');<br />";
			}else{
				$ex_code .= "\$this->facebook->set('{$key}','data value');<br />";
			}
		}
		if($optional){
			$ex_code .= "/* Optional parameter. */<br />";
		}
		foreach($optional as $key){
			if($key == "image" || $key == "picture"){
				$ex_code .= "\$this->facebook->set('{$key}','/path/to/image.jpg');<br />";
			}else{
				$ex_code .= "\$this->facebook->set('{$key}','data value');<br />";
			}
		}
		$ex_code .= "/* Make request. */<br />";
		$ex_code .= "\$this->facebook->{$function}();<br />";
		$ex_code .= "?&gt;";
		foreach($required as $key){
			if(!isset($this->_params[$key])){
				show_error("
				คุณยังไม่ได้ตั้งค่าตัวแปร '{$key}' กรุณาตั้งค่าให้ถูกต้อง<br /><br />
				<strong>Code Example</strong> 
				<code>
				{$ex_code}
				</code>
				<a href=\"{$manual_url}\">คุณสามารถอ่านเพิ่มเติมได้ที่นี่</a>
				",500,"ข้อกำหนดการใช้งาน Mycools Facebook API ผิดพลาด");
			}
		}
	}
	function app_data()
	{
		$signed_request = $this->getSignedRequest();
		if(isset($signed_request['app_data'])){
			return new Facebook_Result($signed_request['app_data']);	
		}else{
			return new Facebook_Result(array());	
		}
	}
	/*
	Function set_permisions
	Configure user permissions
	Example : $this->facebook->set_permisions('email','user_photos','publish_stream');
	*/
	public function set_permisions(/* Permision */)
	{
		$this->_fbconfig['permisions']=func_get_args();
	}
	public function login($redirect_uri=NULL)
	{
		$args=array();
		if($redirect_uri != NULL){
			$args['redirect_uri']=$redirect_uri;
		}
		//$args['redirect_uri']=$this->_ci->uri->uri_string();
		$args['scope']=$this->_fbconfig['permisions'];
		return $this->getLoginUrl($args);
	}
	
	public function _api(/* polymorphic */) {
		$args = func_get_args();
		if (is_array($args[0])) {
		  	$res = $this->_restserver($args[0]);
		} else {
			if($this->force_cache==false){
				$res = $this->load_cache($args[0]);
			}else{
				//$this->force_cache=false;
				$res = false;
			}
			if($res==false){	
		    	$res = call_user_func_array(array($this, '_graph'), $args);
				$this->save_cache($args[0],$res);
			}else{
				$res = json_decode(base64_decode($res), true);	
			}
		}
		return  $res;
	}
	private function load_cache($cache_key)
	{
		$cache_key = $this->getUser() . "_" . md5($cache_key);
		$rs = @$this->_cache[$cache_key];
		if($rs){
			$expire = strtotime('now')-self::FBSS_CACHE_EXPIRE;
			$expire2 = strtotime($rs['cache_time']);
			if($expire2 > $expire){
				log_message("info","load facebook cache {$cache_key}");
				return $rs['cache_res'];
			}else{
				unset($this->_cache[$cache_key]);
				log_message("info","facebook cache expire {$cache_key}");
				return false;	
			}
		}else{
			return false;	
		}
	}
	private function save_cache($cache_key,$res)
	{
		$cache_key = $this->getUser() . "_" . md5($cache_key);
		$this->_cache[$cache_key]['cache_res']=base64_encode(json_encode($res));
		$this->_cache[$cache_key]['cache_time']=date("Y-m-d H:i:s");
		$cache = base64_encode(serialize($this->_cache));
		
		@file_put_contents($this->_cache_path,$cache);
		/*$cache_key = $this->getUser() . "_" . md5($cache_key);
		$this->_ci->db->where("cache_key",$cache_key);
		$this->_ci->db->delete("cache_facebookapi");*/
		/*$this->_ci->db->set("cache_key",$cache_key);
		$this->_ci->db->set("cache_res",base64_encode(json_encode($res)));
		$this->_ci->db->set("cache_time",date("Y-m-d H:i:s"));
		$this->_ci->db->insert("cache_facebookapi");*/
	}
	protected function initSharedSession() {
	$cookie_name = $this->getSharedSessionCookieName();
	if (isset($_COOKIE[$cookie_name])) {
	  $data = $this->parseSignedRequest($_COOKIE[$cookie_name]);
	  if ($data && !empty($data['domain']) &&
		  self::isAllowedDomain($this->getHttpHost(), $data['domain'])) {
		// good case
		$this->sharedSessionID = $data['id'];
		return;
	  }
	  // ignoring potentially unreachable data
	}
	// evil/corrupt/missing case
	$base_domain = $this->getBaseDomain();
	$this->sharedSessionID = md5(uniqid(mt_rand(), true));
	$cookie_value = $this->makeSignedRequest(
	  array(
		'domain' => $base_domain,
		'id' => $this->sharedSessionID,
	  )
	);
	$_COOKIE[$cookie_name] = $cookie_value;
	if (!headers_sent()) {
	  $expire = time() + self::FBSS_COOKIE_EXPIRE;
	  setcookie($cookie_name, $cookie_value, $expire, '/', '.'.$base_domain);
	} else {
	  // @codeCoverageIgnoreStart
	  self::errorLog(
		'Shared session ID cookie could not be set! You must ensure you '.
		'create the Facebook instance before headers have been sent. This '.
		'will cause authentication issues after the first request.'
	  );
	  // @codeCoverageIgnoreEnd
	}
	}
	
	/**
	* Provides the implementations of the inherited abstract
	* methods.  The implementation uses PHP sessions to maintain
	* a store for authorization codes, user ids, CSRF states, and
	* access tokens.
	*/
	protected function setPersistentData($key, $value) {
	if (!in_array($key, self::$kSupportedKeys)) {
	  self::errorLog('Unsupported key passed to setPersistentData.');
	  return;
	}
	
	$session_var_name = $this->constructSessionVariableName($key);
	$_SESSION[$session_var_name] = $value;
	}
	
	protected function getPersistentData($key, $default = false) {
	if (!in_array($key, self::$kSupportedKeys)) {
	  self::errorLog('Unsupported key passed to getPersistentData.');
	  return $default;
	}
	
	$session_var_name = $this->constructSessionVariableName($key);
	return isset($_SESSION[$session_var_name]) ?
	  $_SESSION[$session_var_name] : $default;
	}
	
	protected function clearPersistentData($key) {
	if (!in_array($key, self::$kSupportedKeys)) {
	  self::errorLog('Unsupported key passed to clearPersistentData.');
	  return;
	}
	
	$session_var_name = $this->constructSessionVariableName($key);
	unset($_SESSION[$session_var_name]);
	}
	
	protected function clearAllPersistentData() {
	foreach (self::$kSupportedKeys as $key) {
	  $this->clearPersistentData($key);
	}
	if ($this->sharedSessionID) {
	  $this->deleteSharedSessionCookie();
	}
	}
	
	protected function deleteSharedSessionCookie() {
	$cookie_name = $this->getSharedSessionCookieName();
	unset($_COOKIE[$cookie_name]);
	$base_domain = $this->getBaseDomain();
	setcookie($cookie_name, '', 1, '/', '.'.$base_domain);
	}
	
	protected function getSharedSessionCookieName() {
	return self::FBSS_COOKIE_NAME . '_' . $this->getAppId();
	}
	
	protected function constructSessionVariableName($key) {
	$parts = array('fb', $this->getAppId(), $key);
	if ($this->sharedSessionID) {
	  array_unshift($parts, $this->sharedSessionID);
	}
	return implode('_', $parts);
	}
}
class Facebook_Result
{
	var $_data = NULL;
	function __construct($data)
	{
		$this->_data = $data;
	}
	function __toString()

	{
			return strval($this->_data);	
	}
	function isNull()
	{
		if(!$this->_data){
			return true;	
		}else{
			return false;	
		}
	}
	function toJson()
	{
		return json_encode($this->_data);
	}
	function toArray()
	{
		if(is_array($this->_data)){
			return $this->_data;	
		}else{
			return array();
		}
	}
	function toObject()
	{
		if(is_object($this->_data)){
			return $this->_data;	
		}else{
			return new obj();
		}
	}
	function toString()
	{
		if(is_string($this->_data)){
			return $this->_data;	
		}else{
			return NULL;
		}
	}
	function Length()
	{
		if(is_array($this->_data)){
			return count($this->_data);	
		}
		if(is_object($this->_data)){
			return count($this->_data);	
		}
		if(is_string($this->_data)){
			return strlen($this->_data);	
		}else{
			return false;	
		}
	}
	public function eq($index)
	{
		return new Facebook_Result(@$this->_data[$index]);
	}
	function item($key)
	{
		return new Facebook_Result(@$this->_data[$key]);
	}
	function search($keyword,$index=-1)
	{
		$res_data = array();
		if(is_array($this->_data)){
			foreach($this->_data as $key => $val){
				if(is_string($val)){
					if($keyword==$val){
						$res_data[] = new Facebook_Result($this->_data[$key]);
					}
				}
				if(is_array($val)){
					$result = $this->search_child($val,$keyword);
					if($result !== false){
						$res_data = array_merge($res_data, $result);	
					}
				}
			}
		}
		
		if($index == -1){
			return $res_data;
		}else{
			if(!@$res_data[$index]){
				return new Facebook_Result(array());
			}else{
				return @$res_data[$index];
			}
		}
	}
	function search_child($data,$keyword)
	{
		$res_data = array();
		if(is_array($data)){
			
			foreach($data as $key => $val){
				if(is_string($val)){
					if($keyword==$val){
						$res_data[] = new Facebook_Result(@$data);
					}
				}
				if(is_array($val)){
					$result = $this->search_child($val,$keyword);
					
					if($result !== false){
						$res_data = array_merge($res_data, $result);	
					}
				}
			}
		}
		return $res_data;
	}
	function find($search_key,$index=-1)
	{
		$res_data = array();
		if(is_array($this->_data)){
			foreach($this->_data as $key => $val){
				if($key==$search_key){
					$res_data[] =  new Facebook_Result($this->_data[$key]);
				}
				if(is_array($val)){
					$result = $this->find_child($val,$search_key);
					if($result !== false){
						$res_data = array_merge($res_data, $result);	
					}
				}
			}
		}
		if($index == -1){
			return $res_data;
		}else{
			if(!@$res_data[$index]){
				return new Facebook_Result(array());
			}else{
				return @$res_data[$index];
			}
		}
	}
	private function find_child($search_key,$data)
	{
		$res_data = array();
		if(is_array($data)){
			foreach($data as $key => $val){
				if($key==$search_key){
					$res_data[] = new Facebook_Result($data);
				}
				if(is_array($val)){
					$result = $this->find_child($search_key,$val);
					if($result !== false){
						$res_data = array_merge($res_data, $result);	
					}
				}
			}
		}
		return $res_data;
	}
	public function random()
	{
		if(is_array($this->_data)){
			return new Facebook_Result($this->array_random_assoc($this->_data, count($this->_data)));	
		}else{
			return array();
		}
	}
	private function array_random_assoc($arr, $num = 1) {
		$keys = array_keys($arr);
		shuffle($keys);
		
		$r = array();
		for ($i = 0; $i < $num; $i++) {
			$r[$i] = $arr[$keys[$i]];
		}
		return $r;
	}
}
class obj{}
// END Pagination Class

/* End of file Facebook.php */
/* Location: ./system/libraries/Facebook.php */