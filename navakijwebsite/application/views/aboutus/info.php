<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey py-3">
    <div class="container px-0">
        <div class="d-flex flex-wrap">

            <?php $this->_data['info'] = $info; ?>
            <?php $this->load->view('aboutus/include/sidebar', $this->_data); ?>

            <div class="col-12 col-md-9 px-0 py-3 px-md-3 mb-3 bg-light">
                <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                    <p>
                        <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                        <a href="<?php echo site_url('about-us'); ?>" class="btn-text black"><?php echo ( $this->_language == 'en' ? 'Information' : 'ข้อมูลบริษัท' ); ?></a>
                        <a href="<?php echo site_url('about-us/'.$info['article_meta_url']); ?>" class="btn-text navy"><?php echo $info['article_title_'.$this->_language]; ?></a>
                    </p>
                </div>

                <div class="col-12 px-0 px-md-3 my-3">
                    <h4 class="navy"><i class="far fa-file-alt"></i> <?php echo $info['article_title_'.$this->_language]; ?></h4>
                </div>

                <div class="w-100 d-flex flex-wrap">
                    <?php if( $info['article_image_'.$this->_language] != '' && is_file( realpath('public/core/uploaded/article/'.$info['article_image_'.$this->_language]) ) === true ): ?>
                        <?php /*
                        <div class="images col-12 col-md-6 px-0">
                            <div class="slick">
                                <div>
                                    <img src="<?php echo base_url('public/core/uploaded/article/'.$info['article_image_'.$this->_language]); ?>" alt="" class="img-fullwidth" />
                                </div>
                            </div>
                        </div>*/ ?>
                        <?php if( $info['article_id'] == 8 ): ?>
                            <div class="col-12 px-0 px-md-3">
                                <video playsinline autoplay controls loop preload="metadata" id="bgvid" style="width:100%;">
                                    <source src="<?php echo assets_url('video/banner3.webm'); ?>" type="video/webm">
                                    <source src="<?php echo assets_url('video/banner3.mp4'); ?>" type="video/mp4">
                                </video>
                            </div>
                        <?php else: ?>
                            <div class="images col-12 px-0 px-md-3">
                                <img src="<?php echo base_url('public/core/uploaded/article/'.$info['article_image_'.$this->_language]); ?>" alt="" class="img-fullwidth" />
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="info col-12 px-0 px-md-3 d-flex flex-wrap">
                        <div class="content-box col-12 px-0">
                            <div class="content-box">
                                <?php echo $info['article_desc_'.$this->_language]; ?>
                            </div>
                        </div>
                        <div class="mt-auto col-12 px-0 d-flex flex-wrap align-items-center">
                            <div class="date">
                                <hr size="0" class="my-1" />
                                <p class="small darkgrey"><?php echo date("d/m", strtotime( ( !$info['article_postdate'] ? $info['article_createdtime'] : $info['article_postdate'] ) ) ); ?>/<?php echo date("Y", strtotime( ( !$info['article_postdate'] ? $info['article_createdtime'] : $info['article_postdate'] ) ) )+543; ?></p>
                            </div>
                            <div class="col-12 ml-auto my-3 my-lg-0 d-inline">
                                <?php /* <p class="text-center text-lg-right"><a href="javascript:void(0);" class="btn btn-turquoise" data-toggle="modal" data-target="#shareModal"><i class="fas fa-share-alt"></i> แชร์ประกันนี้</a></p> */ ?>
                                <h5 class="uppercase p-2 text-right"><i class="fas fa-link"></i> แชร์ </h5>
                                <div class="px-0 sharethis-inline-share-buttons"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>