<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function index()
	{
			$this->load->view('welcome_message');
			//var_dump($_SERVER);
	}

	public function debug_documentfiles(){
		$display = [];
		$documents = $this->db->where('document_type', 'multi')
							->where('document_status','approved')
							->order_by('document_order','asc')
							->get('documents')
							->result_array();
		foreach( $documents as $document ){
			$aDocs = [
				'document_id' => $document['document_id'],
				'document_name' => $document['document_title_th'],
				'document_order' => $document['document_order'],
				'document_files' => []
			];

			$documentfiles = $this->db->where('document_id', $document['document_id'] )
							->where('document_file_status','approved')
							->order_by('document_file_createdtime','desc')
							->get('document_files')
							->result_array();
			if( isset( $documentfiles ) && count( $documentfiles ) > 0 ){
				$newOrder = 0;
				foreach( $documentfiles as $documentfile ){
					$newOrder++;
					$aDocFiles = [
						'document_file_id' => $documentfile['document_file_id'],
						'document_file_name' => $documentfile['document_file_title_th'],
						'document_file_order' => $documentfile['document_file_order'],
						'document_file_newOrder' => $newOrder
					];
					array_push( $aDocs['document_files'], $aDocFiles );

					if( $documentfile['document_file_order'] == 0 ){
						// $this->db->set('document_file_order', $newOrder);
						// $this->db->where('document_file_id', $documentfile['document_file_id']);
						// $this->db->update('document_files');
					}
				}
			}
			array_push( $display, $aDocs );
		}

		print_r( $display );
		exit();
	}
}