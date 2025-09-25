<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey py-3">
    <div class="container px-0">
        <div class="d-flex flex-wrap">

            <div class="col-12 px-0 px-md-3 py-3 mb-3 bg-light">
                <?php /* #breadcrumb - Start */ ?>
                <div id="breadcrumb" class="breadcrumb col-12 col-md-9 mx-auto px-3 px-md-0 mb-3">
                    <p>
                        <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                        <a href="<?php echo site_url('driving-business-for-sustainability-landing'); ?>" class="btn-text black"><?php echo $display['contentTitle']; ?></a>
                    </p>
                </div>
                <?php /* #breadcrumb - End */ ?>

                <?php /* Display content info - Start */ ?>
                <div class="col-12 col-md-9 mx-auto px-0 my-3">
                    <h4 class="navy">
                        <?php if( $display['contentType'] == 'article' ): ?>
                            <i class="far fa-file-alt"></i> 
                        <?php elseif( $display['contentType'] == 'document' ): ?>
                            <i class="fas fa-folder-open"></i> 
                        <?php endif; ?>
                        <?php echo $display['contentTitle']; ?>
                    </h4>
                </div>
                <?php if( $display['contentType'] == 'article' ): ?>
                    <?php $this->load->view('policy/include/article_nosidebar', $display); ?>
                <?php elseif( $display['contentType'] == 'document' ): ?>
                    <?php $this->load->view('policy/include/document_nosidebar', $display); ?>
                <?php endif; ?>
                <?php /* Display content info - End */ ?>

            </div>

        </div>
    </div>
</section>