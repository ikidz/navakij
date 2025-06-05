<div class="spacing"></div>
<section id="page-body" class="px-0 page-services">
    <div class="container d-flex flex-wrap h-100">
        <div class="col-12 px-0 align-items-center">

            <div id="breadcrumb" class="breadcrumb col-12 mb-3">
                <p>
                    <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                    <a href="<?php echo site_url('nki-services'); ?>" class="btn-text black">บริการ</a>
                    <a href="<?php echo site_url('nki-services/'.$category['category_meta_url']); ?>" class="btn-text navy"><?php echo $category['category_title_'.$this->_language]; ?></a>
                </p>
            </div>

            <h1 class="service-icon text-center navy revealOnScroll" data-animation="fadeIn" data-timeout="200">
                <?php if( $category['category_icon'] != '' ): ?>
                    <i class="fas <?php echo $category['category_icon']; ?>"></i>
                <?php else: ?>
                    <i class="fas fa-wrench"></i>
                <?php endif; ?>
            </h1>
            <h3 class="section-title navy text-center revealOnScroll delay-1" data-animation="fadeInDown" data-timeout="200"><?php echo $category['category_title_'.$this->_language]; ?></h3>
            
            <div class="d-flex flex-wrap">
                <div class="col-12 px-0 px-md-3 mb-3">
                    <h4 class="navy border-bottom border-2px border-navy pb-3"><i class="fas fa-newspaper"></i> รายการบทความ</h4>
                </div>

                <?php if( isset( $articles ) && count( $articles ) > 0 ): ?>
                    <?php foreach( $articles as $article ): ?>
                        <div class="news-item col-12 col-md-3 px-0 px-md-3 my-3">
                            <a href="<?php echo site_url('nki-services/'.$article['article_meta_url']); ?>">
                                <div class="news-item-image">
                                    <div class="mask"></div>
                                    <?php if( $article['article_thumbnail'] != '' && is_file( realpath('public/core/uploaded/article/thumb/'.$article['article_thumbnail']) ) === true ): ?>
                                        <img src="<?php echo base_url('public/core/uploaded/article/thumb/'.$article['article_thumbnail']); ?>" class="img-fullwidth" />
                                    <?php else: ?>
                                        <img src="<?php echo assets_url('img/default_image.jpg'); ?>" class="img-fullwidth" />
                                    <?php endif; ?>
                                </div>
                                <div class="news-item-title bg-darkgrey p-3">
                                <h4 class="navy"><?php echo mb_substr($article['article_title_'.$this->_language], 0, 38, 'UTF-8'); ?><?php echo ( strlen( $article['article_title_'.$this->_language] ) > 38 ? '...' :'' ); ?></h4>
                                    <hr size="0" />
                                    <p class="small darkgrey"><?php echo date("d/m", strtotime( ( !$article['article_postdate'] ? $article['article_createdtime'] : $article['article_postdate'] ) ) ); ?>/<?php echo date("Y", strtotime( ( !$article['article_postdate'] ? $article['article_createdtime'] : $article['article_postdate'] ) ) )+543; ?></p>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <?php if( $category['category_id'] == 2 ): ?>
                        <div class="news-item col-12 col-md-4 px-0 px-md-3 my-3">
                            <a href="<?php echo site_url('nki-services/claim-service'); ?>">
                                <div class="news-item-image">
                                    <div class="mask"></div>
                                    <img src="<?php echo assets_url('img/claimservice_thumbnail.jpg'); ?>" class="img-fullwidth" />
                                </div>
                                <div class="news-item-title bg-darkgrey p-3">
                                    <h4 class="navy"><?php echo ($this->_language == 'th' ? 'บริการเสริม: ช่วยเหลือรถเสียฉุกเฉิน' : 'Emergency rescue service' ); ?></h4>
                                    <hr size="0" />
                                    <p class="small darkgrey">&nbsp;</p>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <div class="col-12 px-0 px-md-3 my-3">
                    
                    <?php if( isset( $documents_subcatgories ) && count( $documents_subcatgories ) > 0 ): ?>
                        <h4 class="navy border-bottom border-2px border-navy pb-3 mb-4"><i class="fas fa-files"></i> รายการเอกสารต่างๆ</h4>
                        <ul>
                            <?php /*
                            <li class="list-group-item mx-0 ml-lg-3 py-4 px-3 border border-navy no-border-radius">
                                <h5><a href="<?php echo site_url('claim/pdf'); ?>" class="btn-text navy d-flex align-items-center"><i class="fas fa-folder mr-3"></i> <?php echo ($this->_language == 'th' ? 'รายชื่อเครือข่ายบริการ' : 'NKI Partners' ); ?><i class="fas fa-chevron-circle-right ml-auto"></i></a></h5>
                            </li>
                            */ ?>
                            <?php foreach( $documents_subcatgories as $subcategory ): ?>
                                <li class="list-group-item mx-0 ml-lg-3 py-4 px-3 border border-navy no-border-radius">
                                    <h5><a href="<?php echo site_url('nki-services/documents/'.$subcategory['category_meta_url']); ?>" class="btn-text navy d-flex align-items-center"><i class="fas fa-folder mr-3"></i> <?php echo $subcategory['category_title_'.$this->_language]; ?><i class="fas fa-chevron-circle-right ml-auto"></i></a></h5>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>