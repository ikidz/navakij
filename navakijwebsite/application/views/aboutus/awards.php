<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey page-sustainable">
  <div class="container">
    <div class="row justify-content-center">

        <?php $this->load->view('aboutus/include/sidebar', $this->_data); ?>

        <div class="col-12 col-md-9 px-0 py-0 px-md-3 mb-3">

            <div id="breadcrumb" class="breadcrumb col-12 mb-3">
                <p><a href="<?php echo site_url(''); ?>" class="btn-text black"><?php echo ( $this->_language == 'en' ? 'Home' : 'หน้าหลัก' ); ?></a>
                <a href="<?php echo site_url('about-us'); ?>" class="btn-text black"><?php echo ( $this->_language == 'en' ? 'Information' : 'ข้อมูลบริษัท' ); ?></a>
                <a href="<?php echo site_url('about-us/awards'); ?>" class="btn-text navy"><?php echo ( $this->_language == 'en' ? 'Awards' : 'รางวัลความสำเร็จ' ); ?></a>
            </div>

            <div class="col-12 mb-3">
                <h4 class="navy"><i class="fas fa-award"></i> <?php echo ( $this->_language == 'en' ? 'Awards' : 'รางวัลความสำเร็จ' ); ?></h4>
            </div>

            <div id="lists" class="col-12 px-0 d-flex flex-wrap">
                <?php if( isset( $awards ) && count( $awards ) > 0 ): ?>
                    <?php foreach( $awards as $award ): ?>
                        <div class="blog-item bg-white col-12 d-flex flex-wrap mb-3 p-3 align-items-center">
                            <div class="col-12 col-md-3 mb-3 mb-md-0">
                                <a href="<?php echo base_url('public/core/uploaded/awards/'.$award['award_image']); ?>" data-fancybox data-caption="<?php echo $award['award_title_'.$this->_language]; ?>">
                                    <img src="<?php echo base_url('public/core/uploaded/awards/'.$award['award_image']); ?>" alt="" class="img-fullwidth" />
                                </a>
                            </div>
                            <div class="col-12 col-md-9">
                                <h5 class="navy pb-3 mb-3 border-bottom border-1px border-navy"><?php echo $award['award_title_'.$this->_language]; ?></h5>
                                <?php echo $award['award_desc_'.$this->_language]; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>

    </div>
  </div>
</section>