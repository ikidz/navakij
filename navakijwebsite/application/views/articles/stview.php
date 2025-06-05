<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey py-3">
    <div class="container px-0">
        <div class="d-flex flex-wrap">

            <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                <p>
                    <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                    <a href="<?php echo site_url( $article_info['article_meta_url'] ); ?>" class="btn-text navy"><?php echo $article_info['article_title_'.$this->_language]; ?></a>
                </p>
            </div>

            <div class="col-12 px-0 d-flex flex-wrap">
                <div class="info col-12 d-flex flex-wrap">
                    <div class="content-box col-12 px-0">

                        <?php if( $article_info['article_file'] && is_file( realpath('').'/public/core/uploaded/hidden_article/file/'.$article_info['article_file'] ) === true ): ?>
                            <p class="text-right">
                                <a href="<?php echo base_url('public/core/uploaded/hidden_article/file/'.$article_info['article_file']); ?>" class="btn btn-navy"><i class="fas fa-download"></i> <?php echo ( $this->_language == 'th' ? 'ดาวน์โหลด' : 'Download' ); ?></a>
                            </p>
                        <?php endif; ?>

                        <?php if( $article_info['article_image_'.$this->_language] && is_file( realpath('').'/public/core/uploaded/hidden_article/'.$article_info['article_image_'.$this->_language] ) === true ): ?>
                            <p class="text-center">
                                <img src="<?php echo base_url('public/core/uploaded/hidden_article/'.$article_info['article_image_'.$this->_language]); ?>" alt="" class="img-fullwidth" />
                            </p>
                        <?php endif; ?>
                        
                        <h4 class="bold navy"><?php echo $article_info['article_title_'.$this->_language]; ?></h4>

                        <?php echo $article_info['article_desc_'.$this->_language]; ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>