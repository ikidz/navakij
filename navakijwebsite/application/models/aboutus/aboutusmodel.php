<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutusmodel extends CI_Model {

    
    public function __construct(){
        parent::__construct();
    }

    public function get_categories( $mainid=1 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('category_status','approved')
                            ->order_by('category_order','asc')
                            ->get('categories')
                            ->result_array();
        return $query;
    }
    
    public function get_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('categories')
                            ->row_array();
        return $query;
    }

    public function get_articles_bycategoryid( $categoryid=0 ){
        $periodCondition = 'article_start_date <= "'.date("Y-m-d").'" AND ( article_end_date >= "'.date("Y-m-d").'" OR article_end_date is null )';
        $query = $this->db->where('category_id', $categoryid)
                            ->where('article_status','approved')
                            ->where( $periodCondition )
                            ->order_by('article_createdtime','asc')
                            ->get('articles')
                            ->result_array();
        return $query;
    }

    public function get_articleinfo_byid( $articleid=0 ){
        $query = $this->db->where('article_id', $articleid)
                            ->get('articles')
                            ->row_array();
        return $query;
    }

    public function get_document_categoryinfo_byid( $categoryid=0 ){
        $query = $this->db->where('category_id', $categoryid)
                            ->get('document_categories')
                            ->row_array();
        return $query;
    }

    public function get_documents_bycategoryid( $categoryid=0, $limit=0, $offset=0 ){
        if( $limit > 0 ){
            $query = $this->db->limit( $limit );
        }
        if( $offset > 0 ){
            $query = $this->db->offset( $offset );
        }
        $query = $this->db->where('category_id', $categoryid)
                            ->where('document_status','approved')
                            ->order_by('document_order','asc')
                            ->get('documents')
                            ->result_array();
        return $query;
    }

    public function count_document_list($categoryid=0){
        $query = $this->db->where('category_id', $categoryid)
                            ->where('document_status','approved')
                            ->count_all_results('documents');
        return $query;

    }

    public function get_document_file_bydocumentid($documentid){
        $query = $this->db->where('document_id', $documentid)
                            ->where('document_file_status','approved')
                            ->order_by('document_file_createdtime','desc')
                            ->get('document_files')
                            ->result_array();
        return $query;
    }

    public function get_awards(){
        $query = $this->db->where('award_status','approved')
                            ->order_by('award_order','asc')
                            ->get('awards')
                            ->result_array();
        return $query;
    }

    public function get_positioninfo_byid( $positionid=0 ){
        $query = $this->db->where('position_id', $positionid)
                            ->get('positions')
                            ->row_array();
        return $query;
    }

    public function get_boardmembers( $positionid=0 ){
        $lists = array();
        $hierarchies = $this->db->select('hierarchy.hierarchy_level')
                                ->where('hierarchy.position_id', $positionid)
                                ->where('hierarchy.hierarchy_status','approved')
                                ->order_by('hierarchy.hierarchy_level','asc')
                                ->group_by('hierarchy_level')
                                ->get('hierarchy')
                                ->result_array();
        if( isset( $hierarchies ) && count( $hierarchies ) > 0 ){
            foreach( $hierarchies as $hierarchy ){

                $members = $this->db->where('hierarchy.hierarchy_level', $hierarchy['hierarchy_level'])
                                    ->where('hierarchy.position_id', $positionid)
                                    ->where('hierarchy.hierarchy_status','approved')
                                    ->order_by('hierarchy.hierarchy_order','asc')
                                    ->join('board_members','hierarchy.member_id = board_members.member_id','inner')
                                    ->get('hierarchy')
                                    ->result_array();
                $lists[$hierarchy['hierarchy_level']] = array();
                if( isset( $members ) && count( $members ) > 0 ){
                    foreach( $members as $member ){
                        $aMember = array(
                            'id' => $member['member_id'],
                            'image' => $member['member_image'],
                            'name_th' => $member['member_name_th'],
                            'name_en' => $member['member_name_en'],
                            'position_th' => $member['hierarchy_position_th'],
                            'position_en' => $member['hierarchy_position_en']
                        );

                        array_push( $lists[ $hierarchy['hierarchy_level'] ], $aMember );
                    }
                }
            }
        }

        return $lists;
    }

    public function get_positions_bymainid( $mainid=0 ){
        $query = $this->db->where('main_id', $mainid)
                            ->where('position_status','approved')
                            ->order_by('position_order','asc')
                            ->get('positions')
                            ->result_array();
        return $query;
    }

    public function get_sellagents($sData=array()){

				$query = $this->db->where('agent_status','approved');
				if( $sData['keywords'] != '' ){
					$keyword = $sData['keywords'];
					$conditions = '(
						`agent_name_th` like "%'.$keyword.'%" or
						`agent_name_en` like "%'.$keyword.'%" or
						`agent_license_no` like "%'.$keyword.'%"
					)';

					$query = $this->db->where( $conditions );
				}
        $query = $this->db->order_by('agent_id','asc')
                            ->get('sell_agents')
                            ->result_array();
        return $query;

    }

    public function get_memberinfo_byid( $memberid=0 ){
        $query = $this->db->where('member_id', $memberid)
                        ->get('board_members')
                        ->row_array();
        return $query;
    }

}

/* End of file Aboutus.php */
