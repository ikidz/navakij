<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey py-3">
    <div class="container px-0">
        <div class="d-flex flex-wrap">

            <?php $this->_data['contents'] = $contents; ?>
            <?php $this->load->view('policy/include/sidebar', $this->_data); ?>

            <div class="col-12 col-md-9 px-0 py-3 px-md-3 mb-3 bg-light">
                <?php /* #breadcrumb - Start */ ?>
                <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                    <p>
                        <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                        <a href="<?php echo site_url('company-policy'); ?>" class="btn-text black"><?php echo $category['category_title_'.$this->_language]; ?></a>
                        <a href="<?php echo site_url('company-policy/'.$contents['article']['category']['category_meta_url']); ?>" class="btn-text black"><?php echo $contents['article']['category']['category_title_'.$this->_language]; ?></a>
                        <a href="<?php echo site_url('company-policy/'.$contents['article']['category']['category_meta_url'].'/'.$display['contentType'].'/'.$display['contentId']); ?>" class="btn-text navy"><?php echo $display['contentTitle']; ?></a>
                    </p>
                </div>
                <?php /* #breadcrumb - End */ ?>

                <?php /* Display content info - Start */ ?>
                <div class="col-12 px-0 px-md-3 my-3">
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
                    <?php $this->load->view('policy/include/article', $display); ?>
                <?php elseif( $display['contentType'] == 'document' ): ?>
                    <?php $this->load->view('policy/include/document', $display); ?>
                <?php endif; ?>
                <?php /* Display content info - End */ ?>

            </div>

        </div>
    </div>
</section>