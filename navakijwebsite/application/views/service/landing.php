<div class="spacing"></div>
<section id="page-body" class="px-0 page-services">
    <div class="container d-flex flex-wrap h-100">
        <div class="col-12 px-0 align-items-center">

            <h3 class="section-title navy text-center revealOnScroll pt-5" data-animation="fadeInDown" data-timeout="200">
                <?php if( $this->_language == 'th' ): ?>
                    ข้อมูลบริการ
                <?php else: ?>
                    Services
                <?php endif; ?>
            </h3>

            <div class="service-list d-flex flex-wrap justify-content-center">
                
                <?php if( isset( $categories ) && count( $categories ) > 0 ): ?>
                    <?php $delay=0; ?>
                    <?php foreach( $categories as $key => $category ): ?>
                        <?php $delay++; ?>
                        <div class="service-item col-6 col-lg-3 mb-3 mb-lg-0 my-5 revealOnScroll delay-<?php echo $delay; ?>" data-animation="fadeInUp" data-timeout="200">
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
                
                <?php /*
                <?php $total_categories = count( $categories ); ?>
                <div class="service-item col-6 col-lg-3 mb-3 mb-lg-0 my-5 revealOnScroll delay-<?php echo $total_categories+1; ?>" data-animation="fadeInUp" data-timeout="200">
                    <h1 class="service-icon text-center navy">
                        <i class="fas fa-file-invoice"></i>
                    </h1>
                    <h4 class="service-title text-center navy my-3">บริการรับชำระเบี้ยประกันภัย</h4>
                    <p class="text-center"><a href="<?php echo site_url( 'nki-services/payment' ); ?>" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                </div>
                */ ?>
                
                <?php /*
                <div class="service-item col-6 col-lg-3 mb-3 mb-lg-0 my-5 revealOnScroll delay-<?php echo $total_categories+2; ?>" data-animation="fadeInUp" data-timeout="200">
                    <h1 class="service-icon text-center navy">
                        <i class="fas fa-comment-dollar"></i>
                    </h1>
                    <h4 class="service-title text-center navy my-3">แจ้งความประสงค์ยกเว้นภาษีเงินได้สำหรับประกันสุขภาพ</h4>
                    <p class="service-sdesc text-center navy">Lorem Ipsum is simply dummy text</p>
                    <p class="text-center"><a href="https://www.navakij.co.th/policy/consent" target="_blank" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                </div>
                */ ?>

            </div>
            
            <div class="py-5">
                <hr size="0" class="bg-navy" />
            </div>

            <div class="product-list d-flex flex-wrap">
                <div class="product-item col-12 my-3 col-sm-6 col-md-3 revealOnScroll delay-5" data-animation="fadeInUp" data-timeout="200">
                    <h1 class="product-icon text-center navy">
                        <i class="fas fa-map-marked-alt"></i>
                    </h1>
                    <h4 class="product-item text-center navy my-3">
                        <?php if( $this->_language == 'th' ): ?>
                            ศูนย์บริการ / โรงพยาบาล<br />ในเครือข่ายนวกิจ
                        <?php else: ?>
                            Partner's <br />Services / Hospital
                        <?php endif; ?>
                    </h4>
                    <p class="text-center"><a href="<?php echo site_url( 'claim' ); ?>" class="btn btn-turquoise"><?php echo ( $this->_language == 'th' ? 'ค้นหาเลย' : 'Search' ); ?></a></p>
                </div>
                <div class="product-item col-12 my-3 col-sm-6 col-md-3 revealOnScroll delay-6" data-animation="fadeInUp" data-timeout="200">
                    <h1 class="product-icon text-center navy"><i class="fas fa-comment-dollar"></i></h1>
                    <h4 class="product-item text-center navy my-3">
                        <?php if( $this->_language == 'th' ): ?>
                            แจ้งความประสงค์ยกเว้นภาษีเงินได้สำหรับประกันสุขภาพ
                        <?php else : ?>
                            Health insurance tax exemption request form
                        <?php endif; ?>
                    </h4>
                    <?php /* <p class="service-sdesc text-center navy">Lorem Ipsum is simply dummy text</p> */ ?>
                    <p class="text-center"><a href="https://www.navakij.co.th/policy/consent" target="_blank" class="btn btn-turquoise"><?php echo ( $this->_language == 'th' ? 'อ่านเพิ่มเติม' : 'Read more' ); ?></a></p>
                </div>
                <div class="product-item col-12 col-md-6 col-lg-3 my-3 revealOnScroll delay-7" data-animation="fadeInUp" data-timeout="200">
                    <h1 class="product-icon text-center navy"><i class="fas fa-file-download"></i></h1>
                    <h4 class="product-item text-center navy my-3">
                        <?php if( $this->_language == 'th' ): ?>
                            เอกสารรับรองการชำระ<br />เบี้ยประกันภัย
                        <?php else: ?>
                            Certificate of Insurance<br />Premium Payment
                        <?php endif; ?>
                    </h4>
                    <p class="text-center"><a href="https://www.navakij.co.th/policy/consent/download" class="btn btn-turquoise" target="_blank"><?php echo ( $this->_language == 'th' ? 'ดาวน์โหลด' : 'Download' ); ?></a></p>
                </div>
                <div class="product-item col-12 my-3 col-sm-6 col-md-3 revealOnScroll delay-8" data-animation="fadeInUp" data-timeout="200">
                    <h1 class="product-icon text-center navy"><i class="fas fa-phone-alt"></i></h1>
                    <h4 class="product-item text-center navy my-3">
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
                <div class="product-item col-12 my-3 col-sm-6 col-md-3 revealOnScroll delay-9" data-animation="fadeInUp" data-timeout="200">
                    <h1 class="product-icon text-center navy"><img src="<?php echo assets_url('img/icon_sla.svg'); ?>" alt="" style="width:80px;" /></h1>
                    <h4 class="product-item text-center navy my-3">
                        <?php if( $this->_language == 'th' ): ?>
                            มาตรฐานกรอบระยะเวลาสำหรับการให้บริการ
                        <?php else: ?>
                            Service Level Agreement
                        <?php endif; ?>
                    </h4>
                    <p class="text-center"><a href="https://www.navakij.co.th/th/stview/service-level-agreement" class="btn btn-turquoise" target="_blank"><?php echo ( $this->_language == 'th' ? 'ดูรายละเอียด' : 'Read more' ); ?></a></p>
                </div>
                <?php /*
                <div class="product-item col-12 my-3 col-sm-6 col-md-3 revealOnScroll delay-8" data-animation="fadeInUp" data-timeout="200">
                    <h1 class="product-icon text-center navy"><i class="fas fa-file-invoice"></i></h1>
                    <h4 class="product-item text-center navy my-3">บริการรับชำระเบี้ยประกันภัย</h4>
                    <p class="service-sdesc text-center navy">Lorem Ipsum is simply dummy text</p>
                    <p class="text-center"><a href="<?php echo site_url('nki-services/payment'); ?>" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                </div>
                */ ?>

                
            </div>

        </div>
    </div>
</section>