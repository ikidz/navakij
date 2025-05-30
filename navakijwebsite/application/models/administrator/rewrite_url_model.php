<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rewrite_url_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
	}
	public function get_all_url()
	{
		$url = array();
		$urlgroup['group']="หน้าเพจที่สร้างด้วยตนเอง";
		foreach($this->_get_cms_url()->result_array() as $row){
			$urlgroup['child'][]=array("title"=>$row['content_subject'],"url"=>$row['request_path']);
		}
		$url[]=$urlgroup;
		
		foreach($this->_get_cms_group()->result_array() as $cms_group){
			$urlgroup['group']=$cms_group['content_subject'];
			$urlgroup['child']=array();
			foreach($this->_get_cms_content_url($cms_group['layout_type'])->result_array() as $cms_content){
				switch($cms_group['layout_type']){
					case "news":
					$urlr = "page/view?content_id=".$cms_content['default_content_id']."&cms_id=".$cms_content['default_cms_id'];
					break;
					case "clip":
					$urlr = "page/play_clip?content_id=".$cms_content['default_content_id']."&cms_id=".$cms_content['default_cms_id'];
					break;
				}
				
				$urlgroup['child'][]=array("title"=>$cms_content['content_subject'],"url"=>$urlr,"desc"=>$cms_content['content_description']);
			}
			
			$url[]=$urlgroup;
		}
		return $url;
	}
	private function _get_cms_url()
	{
		$this->db->select("system_url_rewrite.request_path,system_cms_id.content_subject,system_cms_id.page_type");
		$this->db->join("system_url_rewrite","system_url_rewrite.url_rewrite_id = system_cms_id.url_rewrite_id","INNER");
		$this->db->where("system_cms_id.cms_status","active");
		
		$this->db->where("system_cms_id.layout_type IN ('news','clip')",false,false);
		return $this->db->get("system_cms_id");
	}
	private function _get_cms_group()
	{
		$this->db->select("system_cms_id.cms_id,system_cms_id.layout_type,system_cms_id.content_subject,system_cms_id.page_type");
		$this->db->where("system_cms_id.cms_status","active");
		$this->db->where("system_cms_id.layout_type IN ('news','clip')",false,false);
		return $this->db->get("system_cms_id");
	}
	private function _get_cms_content_url($layout)
	{
		$this->db->select("layout_type_{$layout}.type_id,layout_type_{$layout}.default_content_id,layout_type_{$layout}.default_cms_id,layout_content_type_{$layout}.content_subject,layout_content_type_{$layout}.content_description");
		$this->db->join("layout_content_type_{$layout}","layout_content_type_{$layout}.type_id = layout_type_{$layout}.type_id","INNER");
		$this->db->where("layout_type_{$layout}.type_status","active");
		$this->db->where("layout_content_type_{$layout}.lang_id","TH");
		return $this->db->get("layout_type_".$layout);
	}
}