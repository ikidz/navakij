<?php if( isset( $galleries ) && count( $galleries ) > 0 ): ?>
    <?php foreach( $galleries as $gallery ): ?>
        <?php if( $gallery['gallery_image'] != '' && is_file( realpath('public/core/uploaded/article/galleries/'.$gallery['article_id'].'/'.$gallery['gallery_image']) ) === true ): ?>
            <div class="grid-item col-12 col-sm-6 col-lg-4 mb-3">
                <a href="<?php echo base_url('public/core/uploaded/article/galleries/'.$gallery['article_id'].'/'.$gallery['gallery_image']); ?>" data-fancybox="gallery">
                    <img data-original="<?php echo base_url('public/core/uploaded/article/galleries/'.$gallery['article_id'].'/'.$gallery['gallery_image']); ?>" class="img-fullwidth not-loaded d-block" />
                </a>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>