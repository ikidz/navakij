<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Policy_model extends CI_Model {
	public function __construct()
	{
		parent::__construct();
		
    }

    public function get_category_bymainid( $mainid=0 ){
        $query = $this->db->where('main_id', $mainid)
                        ->where('category_status', 'approved')
                        ->order_by('category_order', 'ASC')
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

    public function get_sidebar_byurl( $meta_url = '' ){
        $sidebarLists = array(
            'article' => array(),
            'document' => array()
        );
        $articleCategories = $this->db->where('category_meta_url', $meta_url)
                        ->where('category_status', 'approved')
                        ->get('categories')
                        ->result_array();
        if( isset( $articleCategories ) && count( $articleCategories ) > 0 ){
            foreach( $articleCategories as $articleCategory ){
                $articles = $this->db->where('category_id', $articleCategory['category_id'])
                                    ->where('article_status', 'approved')
                                    // ->order_by('article_order', 'ASC')
                                    ->get('articles')
                                    ->result_array();
                if( isset( $articles ) && count( $articles ) > 0 ){
                    $articles = array(
                        'category' => $articleCategory,
                        'lists' => $articles
                    );
                } else {
                    $articles = array(
                        'category' => $articleCategory,
                        'lists' => array()
                    );
                }
            }
            $sidebarLists['article'] = $articles;
        }
        $documentCategories = $this->db->where('category_meta_url', $meta_url)
                        ->where('category_status', 'approved')
                        ->get('document_categories')
                        ->result_array();
        if( isset( $documentCategories ) && count( $documentCategories ) > 0 ){
            foreach( $documentCategories as $documentCategory ){
                $documents = $this->db->where('category_id', $documentCategory['category_id'])
                                    ->where('document_status', 'approved')
                                    ->order_by('document_order', 'ASC')
                                    ->get('documents')
                                    ->result_array();
                if( isset( $documents ) && count( $documents ) > 0 ){
                    $documents = array(
                        'category' => $documentCategory,
                        'lists' => $documents
                    );
                } else {
                    $documents = array(
                        'category' => $documentCategory,
                        'lists' => array()
                    );
                }
            }
            $sidebarLists['document'] = $documents;
        }
        return $sidebarLists;
    }

    public function get_contentinfo_byid( $contentType='', $contentId=0, $sidebarLists=array() ){
        if( $contentType == '' && $contentId == 0 ){
            foreach( $sidebarLists as $key => $sidebar ){
                if( isset( $sidebar['category'] ) && isset( $sidebar['lists'] ) && count( $sidebar['lists'] ) > 0 ){
                    if( $key == 'article' ){
                        $contentType = 'article';
                        $contentId = $sidebar['lists'][0]['article_id'];
                        $contentTitle = $sidebar['lists'][0]['article_title_'.$this->_language];
                        $contentMetaUrl = $sidebar['lists'][0]['article_meta_url'];
                        $info = $sidebar['lists'][0];
                    } else if( $key == 'document' ){
                        $contentType = 'document';
                        $contentId = $sidebar['lists'][0]['document_id'];
                        $contentTitle = $sidebar['lists'][0]['document_title_'.$this->_language];
                        $contentMetaUrl = $sidebar['lists'][0]['document_meta_url'];
                        $info = $sidebar['lists'][0];
                    }
                    break;
                }
            }
            $content = array(
                'contentType' => $contentType,
                'contentId' => $contentId,
                'contentTitle' => $contentTitle,
                'contentMetaUrl' => $contentMetaUrl,
                'info' => $info
            );
        }else{
            $content = array(
                'contentType' => $contentType,
                'contentId' => $contentId,
                'contentTitle' => '',
                'contentMetaUrl' => '',
                'info' => array()
            );
            if( $contentType == 'article' ){
                $content['info'] = $this->db->where('article_id', $contentId)
                                    ->get('articles')
                                    ->row_array();
                $content['contentTitle'] = isset( $content['info']['article_title_'.$this->_language] ) ? $content['info']['article_title_'.$this->_language] : '';
                $content['contentMetaUrl'] = isset( $content['info']['article_meta_url'] ) ? $content['info']['article_meta_url'] : '';
            } else if( $contentType == 'document' ){
                $content['info'] = $this->db->where('document_id', $contentId)
                                    ->get('documents')
                                    ->row_array();
                $content['contentTitle'] = isset( $content['info']['document_title_'.$this->_language] ) ? $content['info']['document_title_'.$this->_language] : '';
                $content['contentMetaUrl'] = isset( $content['info']['document_meta_url'] ) ? $content['info']['document_meta_url'] : '';
            }
        }
        return $content;
    }

    public function get_document_file_bydocumentid($documentid){
        $query = $this->db->where('document_id', $documentid)
                            ->where('document_file_status','approved')
                            ->order_by('document_file_createdtime','desc')
                            ->get('document_files')
                            ->result_array();
        return $query;
    }

}