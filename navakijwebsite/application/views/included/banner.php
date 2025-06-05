    <?php /* #banner - Start */ ?>
    <?php /*
    <section id="banner" class="vh-100 revealOnScroll" data-animation="fadeIn" data-timeout="200">
        <div class="container h-100">
            <div class="h-100 d-flex flex-wrap">

                <div id="caption" class="col-12 align-self-end text-center">
                    <h1 class="white revealOnScroll delay-1" data-animation="fadeInUp" data-timeout="200">88 ปี จากรุ่นสู่รุ่น</h1>
                    <h1 class="white revealOnScroll delay-2" data-animation="fadeInUp" data-timeout="200">ให้เราดูแลเคียงข้างคุณตลอดไป</h1>
                    <p class="my-3"><a href="<?php echo site_url('products'); ?>" class="btn btn-turquoise revealOnScroll delay-3" data-animation="fadeInUp" data-timeout="200"><i class="fas fa-search"></i> ค้นหาแผนบริหารความเสี่ยงที่เหมาะกับคุณ</a></p>
                </div>

            </div>
        </div>
    </section>
    */ ?>
    <?php $banners = $this->mainmodel->get_banners(); ?>
    <?php if( isset( $banners ) && count( $banners ) > 0 ): ?>
        <section id="banner" class="revealOnScroll <?php echo ( count( $banners ) > 1 ? 'slick-slider': '' ); ?>" data-animation="fadeIn" data-timeout="200">
            <?php foreach( $banners as $banner ): ?>
                <div>
                    <?php if( $banner['banner_image'] != '' && is_file( realpath('public/core/uploaded/banner/'.$banner['banner_image']) ) === true ): ?>
                        <a href="<?php echo ( !$banner['banner_url'] ? 'javascript:void(0);' : $banner['banner_url']); ?>" class="d-none d-lg-block">
                            <img src="<?php echo base_url('public/core/uploaded/banner/'.$banner['banner_image']); ?>" alt="" class="img-fullwidth" />
                        </a>
                    <?php endif; ?>
                    <?php if( $banner['banner_image_mobile'] != '' && is_file( realpath('public/core/uploaded/banner/mobile/'.$banner['banner_image_mobile']) ) === true ): ?>
                        <a href="<?php echo ( !$banner['banner_url'] ? 'javascript:void(0);' : $banner['banner_url']); ?>" class="d-block d-lg-none">
                            <img src="<?php echo base_url('public/core/uploaded/banner/mobile/'.$banner['banner_image_mobile']); ?>" alt="" class="img-maxwidth" />
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php /*
            <div class="mask"></div>
            <video playsinline autoplay muted loop poster="<?php echo assets_url('img/banner_bg.png'); ?>" id="bgvid">
                <source src="<?php echo assets_url('video/banner2.webm'); ?>" type="video/webm">
                <source src="<?php echo assets_url('video/banner2.mp4'); ?>" type="video/mp4">
            </video>
            */ ?>
        </section>
    <?php endif; ?>
    <?php /* #banner - End */ ?>