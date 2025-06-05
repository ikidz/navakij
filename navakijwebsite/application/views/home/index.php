    <?php /* #about - Start */ ?>
    <section id="about" class="vh-100 bg-navy">
        <div class="container d-flex flex-wrap h-100">
            <div class="col-12 col-lg-8 px-0 mx-auto align-self-center">
                <div id="title" class="backdrop col-12 mx-auto">
                    <div class="text text-center revealOnScroll" data-animation="fadeIn" date-timeout="200">
                        <!-- <span class="head">นวกิจ</span>
                        <div class="line"></div>
                        <span class="subhead">ประกันภัย</span> -->
                        <span class="icomoon icon-logo"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span><span class="path11"></span><span class="path12"></span><span class="path13"></span><span class="path14"></span><span class="path15"></span><span class="path16"></span><span class="path17"></span></span>

                    </div>
                </div>

                <div id="story" class="col-12 col-lg-8 mx-auto">
                    <p class="text-center white revealOnScroll delay-2" data-animation="fadeInUp" date-timeout="200">
                        <?php echo $aboutus['setting_value']; ?>
                    </p>
                    <p class="text-center"><a href="<?php echo site_url('about-us/company-history'); ?>" class="btn btn-turquoise revealOnScroll delay-3" data-animation="fadeInUp" data-timeout="200">อ่านเพิ่มเติม</a></p>
                </div>
            </div>

        </div>
    </section>
    <?php /* #about - End */ ?>

    <?php /* #products - Start */ ?>
    <section id="products">
        <div class="container d-flex flex-wrap h-100">
            <div class="col-12 px-0 align-items-center">

                <h3 class="section-title white text-center revealOnScroll" data-animation="fadeInDown">ผลิตภัณฑ์</h3>

                <div class="product-list d-flex flex-wrap">
                    <?php if( isset( $product_categories ) && count( $product_categories ) > 0 ): ?>
                        <?php $delay = 1; ?>
                        <?php foreach( $product_categories as $category ): ?>
                            <?php $delay++; ?>
                            <div class="product-item col-12 mb-3 col-sm-6 col-md-3 mb-md-0 align-self-end revealOnScroll delay-<?php echo $delay; ?>" data-animation="fadeInUp" data-timeout="200">
                                <h1 class="product-icon text-center white"><i class="icomoon <?php echo strtolower( $category['insurance_category_icon'] ); ?>"></i></h1>
                                <h4 class="product-title text-center white my-3"><?php echo $category['insurance_category_title_th']; ?></h4>
                                <p class="text-center"><a href="<?php echo site_url( $category['insurance_category_meta_url'] ); ?>" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
    <?php /* #products - End */ ?>

    <?php /* #services - Start */ ?>
    <section id="services">
        <div class="container d-flex flex-wrap h-100">
            <div class="col-12 px-0 align-self-center">

                <h3 class="section-title navy text-center mb-3 revealOnScroll" data-animation="fadeInDown" data-timeout="200">บริการ</h3>

                <div class="service-list d-flex flex-wrap">

                    <?php if( isset( $categories ) && count( $categories ) > 0 ): ?>
                        <?php $delay=0; ?>
                        <?php foreach( $categories as $key => $category ): ?>
                            <?php $delay++; ?>
                            <div class="service-item col-12 col-md-6 col-lg-3 mb-3 mb-lg-5 my-5 revealOnScroll delay-<?php echo $delay; ?>" data-animation="fadeInUp" data-timeout="200">
                                <h1 class="service-icon text-center navy">
                                    <?php if( $category['category_icon'] != '' ): ?>
                                        <i class="fas <?php echo $category['category_icon']; ?>"></i>
                                    <?php else: ?>
                                        <i class="fas fa-wrench"></i>
                                    <?php endif; ?>
                                </h1>
                                <h4 class="service-title text-center navy my-3"><?php echo $category['category_title_'.$this->_language]; ?></h4>
                                <?php /* <p class="service-sdesc text-center navy">Lorem Ipsum is simply dummy text</p> */ ?>
                                <p class="text-center"><a href="<?php echo site_url( 'nki-services/'.$category['category_meta_url'] ); ?>" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    
                    <div class="service-item col-12 col-md-6 col-lg-3 mb-3 mb-lg-5 my-5 revealOnScroll delay-2" data-animation="fadeInUp" data-timeout="200">
                        <h1 class="service-icon text-center navy">
                            <i class="fas fa-map-marked-alt"></i>
                        </h1>
                        <h4 class="service-title text-center navy my-3">
                            <?php if( $this->_language == 'th' ): ?>
                                ศูนย์บริการ / โรงพยาบาล<br />ในเครือนวกิจ
                            <?php else: ?>
                                Partner's <br />Services / Hospital
                            <?php endif; ?>
                        </h4>
                        <p class="text-center"><a href="<?php echo site_url( 'claim' ); ?>" class="btn btn-turquoise"><?php echo ( $this->_language == 'th' ? 'ค้นหาเลย' : 'Search' ); ?></a></p>
                    </div>
                    <?php /*
                    <div class="service-item col-12 col-md-6 col-lg-3 mb-3 mb-lg-0 revealOnScroll delay-2" data-animation="fadeInUp" data-timeout="200">
                        <h1 class="service-icon text-center navy">
                            <i class="fas fa-car-crash"></i>
                        </h1>
                        <h4 class="service-title text-center navy my-3">เคลมรถยนต์</h4>
                        <p class="text-center"><a href="<?php echo site_url( 'nki-services/motor-claims' ); ?>" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                    </div>
                    <div class="service-item col-12 col-md-6 col-lg-3 mb-3 mb-lg-0 revealOnScroll delay-3" data-animation="fadeInUp" data-timeout="200">
                        <h1 class="service-icon text-center navy">
                            <i class="fas fa-heartbeat"></i>
                        </h1>
                        <h4 class="service-title text-center navy my-3">เคลมสุขภาพและอุบัติเหตุ</h4>
                        <p class="text-center"><a href="<?php echo site_url( 'nki-services/accident-and-health-claims' ); ?>" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                    </div>
                    */ ?>
                    <div class="service-item col-12 col-md-6 col-lg-3 mb-3 mb-lg-5 my-5 revealOnScroll delay-3" data-animation="fadeInUp" data-timeout="200">
                        <h1 class="service-icon text-center navy">
                            <i class="fas fa-comment-dollar"></i>
                        </h1>
                        <h4 class="service-title text-center navy my-3">
                            <?php if( $this->_language == 'th' ): ?>
                                แจ้งความประสงค์ยกเว้นภาษีเงินได้สำหรับประกันสุขภาพ
                            <?php else : ?>
                                Health insurance tax exemption request form
                            <?php endif; ?>
                        </h4>
                        <?php /* <p class="service-sdesc text-center navy">Lorem Ipsum is simply dummy text</p> */ ?>
                        <p class="text-center"><a href="https://www.navakij.co.th/policy/consent" target="_blank" class="btn btn-turquoise"><?php echo ( $this->_language == 'th' ? 'อ่านเพิ่มเติม' : 'Read more' ); ?></a></p>
                    </div>
                    <div class="service-item col-12 col-md-6 col-lg-3 mb-3 mb-lg-5 my-5 revealOnScroll delay-5" data-animation="fadeInUp" data-timeout="200">
                        <h1 class="service-icon text-center navy">
                            <i class="fas fa-file-download"></i>
                        </h1>
                        <h4 class="service-title text-center navy my-3">
                            <?php if( $this->_language == 'th' ): ?>
                                เอกสารรับรองการชำระ<br />เบี้ยประกันภัย
                            <?php else: ?>
                                Certificate of Insurance<br />Premium Payment
                            <?php endif; ?>
                        </h4>
                        <p class="text-center"><a href="https://www.navakij.co.th/policy/consent/download" class="btn btn-turquoise" target="_blank"><?php echo ( $this->_language == 'th' ? 'ดาวน์โหลด' : 'Download' ); ?></a></p>
                    </div>
                    <div class="service-item col-12 col-md-6 col-lg-3 mb-3 mb-lg-5 my-5 revealOnScroll delay-4" data-animation="fadeInUp" data-timeout="200">
                        <h1 class="service-icon text-center navy">
                            <i class="fas fa-phone-alt"></i>
                        </h1>
                        <h4 class="service-title text-center navy my-3">
                            <?php if( $this->_language == 'th' ): ?>
                                แจ้งเคลม
                            <?php else: ?>
                                Claim request
                            <?php endif; ?>
                        </h4>
                        <?php /* <p class="service-sdesc text-center navy">Lorem Ipsum is simply dummy text</p> */ ?>
                        <div class="d-flex flex-wrap w-100">
                            <p class="col-12 mb-3 mb-xl-0 col-xl-6 px-1 text-center"><a href="tel:1748" target="_blank" class="w-100 btn btn-turquoise"><?php echo ( $this->_language == 'th' ? 'โทร' : 'Call' ); ?></a></p>
                            <p class="col-12 mb-3 mb-xl-0 col-xl-6 px-1 text-center"><a href="<?php echo assets_url('download/health_and_accidental_claim_form.pdf'); ?>" target="_blank" class="w-100 btn btn-turquoise px-1"><?php echo ( $this->_language == 'th' ? 'แบบฟอร์มเคลม' : 'Claims form' ); ?></a></p>
                        </div>
                    </div>
                    <div class="service-item col-12 col-md-6 col-lg-3 mb-3 mb-lg-5 my-5 revealOnScroll delay-5" data-animation="fadeInUp" data-timeout="200">
                        <h1 class="service-icon text-center navy"><img src="<?php echo assets_url('img/icon_sla.svg'); ?>" alt="" style="width:80px;" /></h1>
                        <h4 class="service-title text-center navy my-3">
                            <?php if( $this->_language == 'th' ): ?>
                                มาตรฐานกรอบระยะเวลาสำหรับการให้บริการ
                            <?php else: ?>
                                Service Level Agreement
                            <?php endif; ?>
                        </h4>
                        <p class="text-center"><a href="https://www.navakij.co.th/th/stview/service-level-agreement" class="btn btn-turquoise" target="_blank"><?php echo ( $this->_language == 'th' ? 'ดูรายละเอียด' : 'Read more' ); ?></a></p>
                    </div>
                    <?php /*
                    <div class="service-item col-12 col-md-6 col-lg-3 my-3 my-lg-0 revealOnScroll delay-5" data-animation="fadeInUp" data-timeout="200">
                        <h1 class="service-icon text-center navy">
                            <i class="fas fa-file-invoice"></i>
                        </h1>
                        <h4 class="service-title text-center navy my-3">บริการรับชำระเบี้ยประกันภัย</h4>
                        <p class="text-center"><a href="<?php echo site_url( 'nki-services/payment' ); ?>" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                    </div>
                    */ ?>

                </div>
            </div>
        </div>
    </section>
    <?php /* #services - End */ ?>

    <?php /* #news - Start */ ?>
    <section id="news" class="bg-lightgrey">
        <div class="container">
            <h3 class="section-title navy text-center">ข่าวสารและกิจกรรม</h3>
            <div class="news-list d-flex flex-wrap">
                
                <?php if( isset( $latest_news ) && count( $latest_news ) > 0 ): ?>
                    <?php foreach( $latest_news as $news ): ?>
                        <div class="col-12 col-sm-6 col-md-4 mb-3 mb-md-0 text-center">
                            <p><a href="<?php echo site_url( 'news-update/'.$news['article_meta_url'] ); ?>"><img src="<?php echo base_url('public/core/uploaded/article/thumb/'.$news['article_thumbnail']); ?>" alt="" class="img-fullwidth" /></a></p>
                            <h5 class="my-3 navy"><?php echo mb_substr($news['article_title_th'], 0, 55, 'UTF-8'); ?><?php echo ( utf8_strlen( $news['article_title_th'] ) > 55 ? '...' : '' ); ?></h5>
                            <p class="my-3 navy"><?php echo $news['article_sdesc_th']; ?></p>
                            <p class="my-3"><a href="<?php echo site_url( 'news-update/'.$news['article_meta_url'] ); ?>" class="btn btn-navy">ดูรายละเอียด</a></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php /* #news - End */ ?>

		<?php /* #introPopup - Start */ ?>
		<?php $introPopup = $this->mainmodel->get_intro(); ?>
		<?php if( isset( $introPopup ) && count( $introPopup ) > 0 ): ?>
		    <a id="introPopup" href="<?php echo ( $introPopup['intro_type'] == 'youtube' ? 'https://www.youtube.com/watch?v='.$introPopup['intro_value'] : base_url('public/core/uploaded/intro/'.$introPopup['intro_value']) ); ?>" data-fancybox>&nbsp;</a>
		<?php endif; ?>
		<?php /* #introPopup - End */ ?>