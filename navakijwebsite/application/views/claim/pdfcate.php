<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey page-sustainable py-3">
  <div class="container px-0">
    <div class="d-flex flex-wrap">

      <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
        <p>
          <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
          <a href="<?php echo site_url('nki-services'); ?>" class="btn-text black">บริการ</a>
          <a href="<?php echo site_url('claim/pdf'); ?>" class="btn-text navy"><?php echo ( $this->_language == 'th' ? 'รายชื่อเครือข่ายบริการ' : 'NKI Partners' ); ?></a>
        </p>
      </div>

      <div class="col-12 px-0 px-md-3 mb-3">
        <div class="row justify-content-end">
          <div class="col-12 mb-5 mb-md-0">
            <h4 class="navy"><i class="fas fa-folder-open"></i> <?php echo ( $this->_language == 'th' ? 'รายชื่อเครือข่ายบริการ' : 'NKI Partners' ); ?></h4>
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
            <?php if( isset( $categories ) && count( $categories ) > 0 ): ?>
                <?php foreach( $categories as $category ): ?>
                    <div class="item d-flex flex-wrap">
                        <div class="col-12 col-lg-8 col-left">
                            <h4><?php echo $category['category_title_'.$this->_language]; ?></h4>
                        </div>
                        <a href="<?php echo site_url('claim/pdf/'.$category['category_id']); ?>" class="col-12 col-lg-4 col-right" target="_blank">
                            <div class="title">
                                <h5><?php echo ( $this->_language == 'th' ? 'ดูรายชื่อ' : 'See list' ); ?></h5>
                            </div>
                            <div class="icon ml-auto"><i class="fas fa-arrow-circle-right"></i></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        
      </div>

      <div class="col-12 mt-3 mt-lg-5 text-center">
        <p class="my-3"><a href="<?php echo site_url('nki-services'); ?>" class="btn btn-lg btn-icon btn-navy-transparent"><i class="fas fa-chevron-left"></i> กลับ</a></p>
      </div>

    </div>
  </div>
</section>