<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey page-sustainable py-3">
  <div class="container px-0">
    <div class="d-flex flex-wrap">

      <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
        <p>
          <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
          <a href="<?php echo site_url('products'); ?>" class="btn-text black">บริการ</a>
          <?php /* <a href="<?php echo site_url('nki-services/'.$maincategory['category_meta_url']); ?>" class="btn-text black"><?php echo $maincategory['category_title_'.$this->_language]; ?></a>*/ ?>
          <a href="<?php echo site_url('nki-services/documents/'.$category['category_meta_url']); ?>" class="btn-text navy"><?php echo $category['category_title_'.$this->_language]; ?></a>
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
              <div class="item d-flex flex-wrap">
                <div class="col-12 col-8 col-left">
                  <h4><?php echo $document['document_title_'.$this->_language]; ?></h4>
                </div>
                <?php
                  $fieldname = ($this->_language == 'en' ? 'document_file_en' : 'document_file' );
                  $file = ( $document[$fieldname] != '' && is_file( realpath('public/core/uploaded/documents/'.$document[$fieldname]) ) === true ? $document[$fieldname] : '' );
                ?>
                <?php if( $file ): ?>
                  <a href="<?php echo base_url('public/core/uploaded/documents/'.$file); ?>" class="col-12 col-lg-4 col-right" target="_blank">
                    <div class="title">
                      <h5>Download File</h5>
                      <?php /*
                      <?php $filesize = filesize( realpath('public/core/uploaded/documents/'.$document[$fieldname]) ); ?>
                      <?php $filesize = round( $filesize / 1024 ) / 1024; ?>
                      <small><?php echo $file; ?> ( <?php echo number_format( $filesize, 2 ); ?> MB)</small>
                      */ ?>
                    </div>
                    <div class="icon ml-auto"><i class="fas fa-arrow-circle-down"></i></div>
                  </a>
                <?php endif; ?>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
        
        
      </div>

      <div class="col-12 mt-3 mt-lg-5 text-center">
        <p class="my-3"><a href="<?php echo site_url('nki-services/'.$maincategory['category_meta_url']); ?>" class="btn btn-lg btn-icon btn-navy-transparent"><i class="fas fa-chevron-left"></i> กลับ</a></p>
      </div>

    </div>
  </div>
</section>