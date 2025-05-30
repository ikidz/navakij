<div class="spacing"></div>
<section id="page-body" class="px-0 page-services">
    <div class="container d-flex flex-wrap h-100">
        <div class="col-12 px-0 align-items-center">

            <h3 class="section-title navy text-center revealOnScroll pt-5" data-animation="fadeInDown" data-timeout="200"><?php echo ( $this->_language == 'en' ? 'Knowledges' : 'บทความควรรู้' ) ;?></h3>

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
                            <p class="text-center"><a href="<?php echo site_url( 'knowledges/'.$category['category_meta_url'] ); ?>" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>

        </div>
    </div>
</section>