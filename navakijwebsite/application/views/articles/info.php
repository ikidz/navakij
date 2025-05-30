<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey py-3">
    <div class="container px-0">
        <div class="d-flex flex-wrap">

            <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                <p>
                    <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                    <a href="<?php echo site_url('news-update'); ?>" class="btn-text black">ข่าวสารและกิจกรรม</a>
                    <a href="<?php echo site_url('news-update/'.$category_info['category_meta_url']); ?>" class="btn-text black"><?php echo $category_info['category_title_'.$this->_language]?></a>
                    <a href="<?php echo site_url('news-update/'.$article_info['article_meta_url']); ?>" class="btn-text navy"><?php echo $article_info['article_title_'.$this->_language];?></a>
                </p>
            </div>

            <div class="col-12 px-0 px-md-3 mb-3">
                <h4 class="navy"><?php echo $article_info['article_title_'.$this->_language];?></h4>
            </div>

            <div class="d-flex flex-wrap">
                <?php /*
                <div class="images col-12 col-md-6 px-0">
                    <div class="slick">
                        <div>
                            <img src="<?php echo base_url('public/core/uploaded/article/'.$info['article_image_'.$this->_language]); ?>" alt="" class="img-fullwidth" />
                        </div>
                    </div>
                </div>*/ ?>
                <div class="images col-12 px-0 px-md-3 text-center">
                    <img src="<?php echo base_url('public/core/uploaded/article/'.$article_info['article_image_'.$this->_language]); ?>" alt="" class="img-fullwidth" />
                </div>
                <div class="info col-12 d-flex flex-wrap">

                    <?php /* .content-box - Start */ ?>
                    <div class="content-box col-12 px-0">
                        <?php echo $article_info['article_desc_'.$this->_language];?>
                    </div>
                    <?php /* .content-box - End */ ?>

                    <?php if( isset( $galleries ) && count( $galleries ) > 0 ): ?>
                        <hr class="col-12 border-bottom border-1px border-navy my-3 px-0" />

                        <?php /* #galleries - Start */ ?>
                        <div id="galleries" class="col-12 px-0">
                            <h4 class="navy mb-3">รวมรูปภาพ</h4>
                            <div id="gallery-wrapper" class="d-flex flex-wrap">
                                <?php foreach( $galleries as $gallery ): ?>
                                    <?php if( $gallery['gallery_image'] != '' && is_file( realpath('public/core/uploaded/article/galleries/'.$gallery['article_id'].'/'.$gallery['gallery_image']) ) === true ): ?>
                                        <div class="grid-item col-12 col-sm-6 col-lg-4 mb-3">
                                            <a href="<?php echo base_url('public/core/uploaded/article/galleries/'.$gallery['article_id'].'/'.$gallery['gallery_image']); ?>" data-fancybox="gallery">
                                                <img data-original="<?php echo base_url('public/core/uploaded/article/galleries/'.$gallery['article_id'].'/'.$gallery['gallery_image']); ?>" class="img-fullwidth not-loaded d-block" />
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                            <?php if( count( $galleries ) > $limit_gallery ): ?>
                                <div id="btnLoadMore" class="my-3 text-center">
                                    <input type="hidden" name="article_id" value="<?php echo $article_info['article_id']; ?>" />
                                    <input type="hidden" name="current_offset" value="0" />
                                    <a href="javascript:void(0);" id="btnLoadMore-gallery" class="btn btn-navy" data-limit="<?php echo $limit_gallery; ?>">เพิ่มเติม</a>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php /* #galleries - End */ ?>

                    <?php endif; ?>
                    <?php 
                    if($article_info['article_postdate'] == ""){
                        $article_info['article_postdate'] = $article_info['article_createdtime'];
                    }
                    ?>
                    <div class="mt-auto col-12 d-flex flex-wrap align-items-center">
                        <div class="date">
                            <hr size="0" class="my-1" />
                            <p class="small darkgrey"><?php echo date("d/m", strtotime( $article_info['article_postdate'] ) ); ?>/<?php echo date("Y", strtotime( $article_info['article_postdate'] ) )+543; ?></p>
                        </div>
                        <div class="col-12 ml-auto my-3 my-lg-0 d-inline">
                            <?php /* <p class="text-center text-lg-right"><a href="javascript:void(0);" class="btn btn-turquoise" data-toggle="modal" data-target="#shareModal"><i class="fas fa-share-alt"></i> แชร์ประกันนี้</a></p> */ ?>
                            <h5 class="uppercase p-2 text-right"><i class="fas fa-link"></i> แชร์ </h5>
                            <div class="px-0 sharethis-inline-share-buttons"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3 text-center">
                    <p class="my-3"><a href="<?php echo site_url('news-update/'.$category_info['category_meta_url']); ?>" class="btn btn-lg btn-icon btn-navy-transparent"><i class="fas fa-chevron-left"></i> กลับ</a></p>
                </div>
            </div>

           

        </div>
    </div>
</section>