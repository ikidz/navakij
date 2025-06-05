<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey py-3">
    <div class="container px-0">
        <div class="d-flex flex-wrap">

            <?php $this->_data['info'] = $category_info; ?>
            <?php $this->load->view('investors/include/sidebar', $this->_data); ?>

                <div class="col-12 col-md-9 px-0 px-md-3 mb-3 d-flex flex-wrap">
                    <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                        <p>
                            <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                            <a href="<?php echo site_url('news-update'); ?>" class="btn-text black">นักลงทุนสัมพันธ์</a>
                            <a href="<?php echo site_url('news-update/'.$category_info['category_meta_url']); ?>" class="btn-text navy"><?php echo $category_info['category_title_'.$this->_language]?></a>
                        </p>
                    </div>

                    <div class="col-12 px-0 px-md-3 mb-3">
                        <h4 class="navy"><i class="fas fa-newspaper"></i> <?php echo $category_info['category_title_'.$this->_language]?></h4>
                    </div>
                    <?php foreach($news_list as $rs){      
                            if($rs['article_postdate'] == ""){
                                $rs['article_postdate'] = $rs['article_createdtime'];

                            }
                        
                    ?>
                    <div class="news-item col-12 col-md-4 px-0 px-md-3 my-3">
                        <a href="<?php echo site_url('news-update/'.$rs['article_meta_url']); ?>">
                            <div class="news-item-image">
                                <div class="mask"></div>
                                <?php if( $rs['article_thumbnail']!='' && is_file( realpath('public/core/uploaded/article/thumb/'.$rs['article_thumbnail']) ) === true ): ?>
                                    <img src="<?php echo base_url('public/core/uploaded/article/thumb/'.$rs['article_thumbnail']); ?>" class="img-fullwidth" />
                                <?php else: ?>
                                    <img src="<?php echo assets_url('img/default_image.jpg'); ?>" alt="" class="img-fullwidth" />
                                <?php endif; ?>
                            </div>
                            <div class="news-item-title bg-darkgrey p-3">
                            <h5 class="navy"><?php echo mb_substr($rs['article_title_'.$this->_language], 0, 38, 'UTF-8'); ?><?php echo ( strlen( $rs['article_title_'.$this->_language] ) > 38 ? '...' :'' ); ?></h5>
                                <hr size="0" />
                                <p class="small darkgrey"><?php echo date("d/m", strtotime( $rs['article_postdate'] ) ); ?>/<?php echo date("Y", strtotime( $rs['article_postdate'] ) )+543; ?></p>
                            </div>
                        </a>
                    </div>
                    <?php }?>
                

                

                    
                
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <?php echo $pagination;?>
                </div>

            </div>

        </div>
    </div>
</section>