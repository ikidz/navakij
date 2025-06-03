<div class="w-100 d-flex flex-wrap">
    <?php if( $display['info']['article_image_'.$this->_language] != '' && is_file( realpath('public/core/uploaded/article/'.$display['info']['article_image_'.$this->_language]) ) === true ): ?>
        <div class="images col-12 px-0 px-md-3">
            <a href="<?php echo base_url('public/core/uploaded/article/'.$display['info']['article_image_'.$this->_language]); ?>" data-fancybox>
                <img src="<?php echo base_url('public/core/uploaded/article/'.$display['info']['article_image_'.$this->_language]); ?>" alt="" class="img-fullwidth" />
            </a>
        </div>
    <?php endif; ?>
    <div class="info col-12 px-0 px-md-3 d-flex flex-wrap">
        <div class="content-box col-12 px-0">
            <div class="content-box">
                <?php echo $display['info']['article_desc_'.$this->_language]; ?>
            </div>
        </div>
        <div class="mt-auto col-12 px-0 d-flex flex-wrap align-items-center">
            <div class="date">
                <hr size="0" class="my-1" />
                <p class="small darkgrey"><?php echo date("d/m", strtotime( ( !$display['info']['article_postdate'] ? $display['info']['article_createdtime'] : $display['info']['article_postdate'] ) ) ); ?>/<?php echo date("Y", strtotime( ( !$display['info']['article_postdate'] ? $display['info']['article_createdtime'] : $display['info']['article_postdate'] ) ) )+543; ?></p>
            </div>
            <div class="col-12 ml-auto my-3 my-lg-0 d-inline">
                <?php /* <p class="text-center text-lg-right"><a href="javascript:void(0);" class="btn btn-turquoise" data-toggle="modal" data-target="#shareModal"><i class="fas fa-share-alt"></i> แชร์ประกันนี้</a></p> */ ?>
                <h5 class="uppercase p-2 text-right"><i class="fas fa-link"></i> แชร์ </h5>
                <div class="px-0 sharethis-inline-share-buttons"></div>
            </div>
        </div>
    </div>
</div>