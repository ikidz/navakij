<div class="spacing"></div>
<section id="page-body" class="px-0">
    <div class="container d-flex flex-wrap h-100">
        <div class="col-12 px-0 align-items-center">

            <h3 class="section-title navy text-center revealOnScroll pb-3" data-animation="fadeInDown">ผลิตภัณฑ์</h3>

            <div class="product-list d-flex flex-wrap pt-3">
                <?php if( isset( $product_categories ) && count( $product_categories ) > 0 ): ?>
                    <?php $delay = 0; ?>
                    <?php foreach( $product_categories as $category ): ?>
                        <?php $delay++; ?>
                        <div class="product-item col-12 my-3 col-sm-6 col-md-3 revealOnScroll delay-<?php echo $delay; ?>" data-animation="fadeInUp" data-timeout="200">
                            <h1 class="product-icon text-center navy"><i class="icomoon <?php echo strtolower( $category['insurance_category_icon'] ); ?> navy"></i></h1>
                            <h4 class="product-title text-center navy my-3"><?php echo $category['insurance_category_title_th']; ?></h4>
                            <p class="text-center"><a href="<?php echo site_url( $category['insurance_category_meta_url'] ); ?>" class="btn btn-turquoise">อ่านเพิ่มเติม</a></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>