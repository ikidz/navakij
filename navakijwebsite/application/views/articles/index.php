<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey">
    <div class="container px-0">
        <h3 class="section-title text-center navy"><?php echo ( $this->_language == 'th' ? 'ข่าวสารและกิจกรรม' : 'News update' ); ?></h3>
        <div class="d-flex flex-wrap">

            <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                <p><a href="<?php echo site_url('home'); ?>" class="btn-text black"><?php echo ( $this->_language == 'th' ? 'หน้าหลัก' : 'Home' ); ?></a>
                <a href="<?php echo site_url($this->_language.'/news-update'); ?>" class="btn-text navy"><?php echo ( $this->_language == 'th' ? 'ข่าวสารและกิจกรรม' : 'News update' ); ?></a></p>
            </div>
            <?php foreach($news_categories as $rs){?>
            <div class="news-item col-12 col-md-6 px-0 px-md-3 my-3">
                <div class="wrapper">
                    <a href="<?php echo site_url('news-update/'.$rs['category_meta_url']); ?>" class="d-flex flex-wrap">
                        <div class="col-12 mt-5">
                            <h3 class="white"><?php echo $rs['category_title_'.$this->_language]?></h3>
                            
                        </div>
                        <p class="col-12 mt-auto mb-5 d-none d-lg-block">
                            <button type="button" class="btn btn-turquoise">ดูเพิ่มเติม</button>
                        </p>
                    </a>
                    <?php if( $rs['category_thumbnail'] != '' && is_file( realpath('public/core/uploaded/category/'.$rs['category_thumbnail'] ) ) === TRUE ): ?>
                        <img src="<?php echo base_url('public/core/uploaded/category/'.$rs['category_thumbnail']); ?>" alt="" class="img-fullwidth" />
                    <?php else: ?>
                        <img src="<?php echo base_url('public/core/img/product_default_image.jpg'); ?>" alt="" class="img-fullwidth" />
                    <?php endif; ?>
                </div>
            </div>
            <?php }?>

            

        </div>
    </div>
</section>