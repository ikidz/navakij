<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey page-investors py-3">
  <div class="container px-0">
    <div class="d-flex flex-wrap">

      <?php $this->_data['info'] = $category; ?>
      <?php $this->load->view('investors/include/sidebar', $this->_data); ?>
      <div class="col-12 col-md-9 px-0 px-md-3 mb-3">
        <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
          <p>
            <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
            <a href="<?php echo site_url('investor-relations/financial-highlights'); ?>" class="btn-text black">นักลงทุนสัมพันธ์</a>
            <a href="<?php echo site_url($category['category_meta_url']); ?>" class="btn-text navy"><?php echo $category['category_title_'.$this->_language]; ?></a>
          </p>
        </div>

        <div class="col-12 px-0 px-md-3 mb-3">
          <div class="row justify-content-end">
            <div class="col-12 mb-5 mb-md-0">
              <h4 class="navy"><i class="fas fa-folder-open"></i> <?php echo $category['category_title_'.$this->_language]; ?></h4>
            </div>

            <?php /*
            <div class="col-12 col-md-6">
              <ul class="pagination justify-content-end">
                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
              </ul>
            </div>
            */ ?>
          </div>

          <div class="download-list mt-5">
            <?php if( isset( $documents ) && count( $documents ) > 0 ): ?>
              <?php foreach( $documents as $document ): ?>
                <div class="item w-100 d-flex flex-wrap">
                  <div class="col-12 col-8 col-left">
                    <h5><?php echo $document['document_title_'.$this->_language]; ?></h5>
                    <?php if( $document['document_desc_'.$this->_language] ): ?>
                      <p class="small darkgrey pt-1 pb-0">* <?php echo strip_tags( $document['document_desc_'.$this->_language] ); ?></p>
                    <?php endif; ?>
                  </div>
                  <?php
                    $fieldname = ($this->_language == 'en' ? 'document_file_en' : 'document_file' );
                    $file = ( $document[$fieldname] != '' && is_file( realpath('public/core/uploaded/documents/'.$document[$fieldname]) ) === true ? $document[$fieldname] : '' );
                    //$file = $document[$fieldname];
                  ?>
                  <?php if( $document['document_type'] == 'multi' ): ?>
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#files-<?php echo $document['document_id']; ?>" aria-controls="files-<?php echo $document['document_id']; ?>" aria-expanded="false" class="col-12 col-lg-4 col-right">
                      <div class="title">
                        <h5><?php echo ( $this->_language == 'th' ? 'ดูรายการไฟล์' : 'See file lists' ); ?></h5>
                      </div>
                      <div class="icon ml-auto"><i class="fas fa-arrow-circle-down"></i></div>
                    </a>
									<?php elseif( $document['document_type'] == 'link' ): ?>
										<a href="<?php echo $document['document_url_'.$this->_language]; ?>" target="_blank" class="col-12 col-lg-4 col-right">
                      <div class="title">
                        <h5><?php echo ( $this->_language == 'th' ? 'คลิกดูรายละเอียด' : 'View detail' ); ?></h5>
                      </div>
                      <div class="icon ml-auto"><i class="fas fa-external-link-alt"></i></div>
                    </a>
                  <?php else: ?>
                    <?php if( $file ): ?>
                      <a href="<?php echo base_url('public/core/uploaded/documents/'.$file); ?>" class="col-12 col-lg-4 col-right" target="_blank">
                        <div class="title">
                          <h5><?php echo ( $this->_language == 'th' ? 'ดาวน์โหลดไฟล์' : 'Download file' ); ?></h5>
                        </div>
                        <div class="icon ml-auto"><i class="fas fa-arrow-circle-down"></i></div>
                      </a>
                    <?php endif; ?>
                  <?php endif; ?>
                  
                  <?php if($document['document_type'] == "multi"): ?>
                    <div id="files-<?php echo $document['document_id']; ?>" class="collapse multi-collapse col-12 px-0">

                      <?php $doc_fieldname = ($this->_language == 'en' ? 'document_file_en' : 'document_file_th' ); ?>
                      <?php $doc_file = $this->investorsmodel->get_document_file_bydocumentid( $document['document_id']); ?>

                      <?php if( isset( $doc_file ) && count( $doc_file ) > 0 ): ?>
                        <?php foreach($doc_file as $doc): ?>

                          <?php $d_file = ( $doc[$doc_fieldname] != '' && is_file( realpath('public/core/uploaded/documents/files/'.$doc['document_id'].'/'.$doc[$doc_fieldname]) ) === true ? $doc[$doc_fieldname] : '' ); ?>

                          <?php if($d_file): ?>

                            <div class="py-3 px-2 bg-lightgrey border-bottom border-1px border-navy">
                              <a href="<?php echo base_url('public/core/uploaded/documents/files/'.$doc['document_id'].'/'.$d_file); ?>" class="col-12 btn-text navy" target="_blank"><i class="fas fa-download"></i> <?php echo $doc['document_file_title_'.$this->_language];?></a>
                              <?php if( $doc['document_file_desc_'.$this->_language] ): ?>
                                <p class="small darkgrey col-12">* <?php echo strip_tags( $doc['document_file_desc_'.$this->_language] ); ?></p>
                              <?php endif; ?>
                            </div>
                          <?php endif; ?>

                        <?php endforeach; ?>
                      <?php endif; ?>

                    </div>
                  <?php endif; ?>

                </div>
              <?php endforeach; ?>
            <?php endif; ?>
            
          </div>
          
          
        </div>

        <div class="col-12 px-0 px-md-3 mb-3 d-flex flex-wrap justify-content-center">
          <?php echo $pagination;?>
        </div>

      </div>

    </div>
  </div>
</section>