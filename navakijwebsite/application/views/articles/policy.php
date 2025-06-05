<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey py-3">
    <div class="container px-0">
        <div class="d-flex flex-wrap">

            <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                <p>
                    <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                    <a href="<?php echo site_url('news-update'); ?>" class="btn-text navy">นโยบายเรื่องการใช้คุกกี้</a>
                </p>
            </div>

            <div class="col-12 px-0 px-md-3 mb-3">
                <h4 class="navy">นโยบายเรื่องการใช้คุกกี้</h4>
            </div>

            <div class="d-flex flex-wrap">
                <div class="info col-12 d-flex flex-wrap">
                    <div class="content-box col-12 px-0">
                        <?php echo $info['setting_value'];?>
                    </div>
                </div>
            </div>

           

        </div>
    </div>
</section>