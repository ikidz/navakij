<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey">
    <div class="container px-0">
        <h3 class="section-title text-center navy">ร่วมงานกับเรา</h3>
        <div class="d-flex flex-wrap">

            <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                <p>
                    <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                    <a href="<?php echo site_url('job-vacancy'); ?>" class="btn-text navy">ร่วมงานกับเรา</a>
                    <a href="<?php echo site_url('job-info/'.$info['job_meta_url']); ?>" class="btn-text navy"><?php echo $info['job_title_'.$this->_language]; ?></a>
                </p>
            </div>

            <div id="info" class="content-box col-12 px-0 px-md-3">
                <div class="w-100 d-flex flex-wrap align-items-center">
                    <h4 class="navy"><i class="fas fa-info-circle"></i> <?php echo $info['job_title_'.$this->_language]; ?></h4>
                    <div class="ml-auto px-0 text-center text-lg-left d-none d-lg-block">
                        <?php if( $info['is_appliable'] > 0 ): ?>
                            <a href="<?php echo site_url('job-applicant/'.$info['job_id']); ?>" class="btn btn-navy"><i class="fas fa-check-square"></i> <?php echo ( $this->_language == 'en' ? 'Apply NOW!' : 'สมัครออนไลน์' ); ?></a>
                        <?php endif; ?>
                        <?php if( $info['is_profile_leaving'] > 0 ): ?>
                            <a href="javascript:void(0);" class="btnLeavingProfile btn btn-navy mt-3 mt-lg-0" data-jobId="<?php echo $info['job_id']; ?>"><i class="fas fa-inbox"></i> <?php echo ( $this->_language == 'en' ? 'Leave your profile' : 'ฝากประวัติ' ); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if( $info['job_amount'] > 0 ): ?>
                    <p class="bold navy"><?php echo ( $this->_language == 'en' ? 'Number of open' : 'จำนวนที่เปิดรับ' ); ?> : <?php echo $info['job_amount']; ?> <?php echo ( $this->_language == 'en' ? 'positions' : 'อัตรา' ); ?></p>
                <?php endif; ?>
                <p>&nbsp;</p>
                <p class="bold navy"><?php echo ( $this->_language == 'en' ? 'Responsibility' : 'หน้าที่ความรับผิดชอบ' ); ?> : </p>
                <?php echo $info['job_responsibility_'.$this->_language]; ?>
                <p>&nbsp;</p>
                <p class="bold navy"><?php echo ( $this->_language == 'en' ? 'Qualification' : 'คุณสมบัติ' ); ?> : </p>
                <?php echo $info['job_qualification_'.$this->_language]; ?>
                <hr size="0" class="border-navy" />
                <div class="w-100 d-flex flex-wrap jusitfy-content-between align-items-center">
                    <div class="col-12 col-lg-8 px-0 text-center text-lg-left">
                        <span class="d-block d-lg-none">
                            <?php if( $info['is_appliable'] > 0 ): ?>
                                <a href="<?php echo site_url('job-applicant/'.$info['job_id']); ?>" class="btn btn-navy"><i class="fas fa-check-square"></i> <?php echo ( $this->_language == 'en' ? 'Apply NOW!' : 'สมัครออนไลน์' ); ?></a>
                            <?php endif; ?>
                            <?php if( $info['is_profile_leaving'] > 0 ): ?>
                                <a href="javascript:void(0);" class="btnLeavingProfile btn btn-navy mt-3 mt-lg-0" data-jobId="<?php echo $info['job_id']; ?>"><i class="fas fa-inbox"></i> <?php echo ( $this->_language == 'en' ? 'Leave your profile' : 'ฝากประวัติ' ); ?></a>
                            <?php endif; ?>
                        </span>
                        <a href="<?php echo site_url('job-vacancy'); ?>" class="btn btn-navy mt-3 mt-lg-0"><i class="fas fa-undo"></i> Back</a>
                    </div>
                    <div class="col-12 col-lg-4 px-0 ml-auto my-3 my-lg-0 d-inline text-center text-lg-right">
                        <span class="navy bold d-none d-lg-inline-block">Share : </span>
                        <a href="javascript:void(0);" class="btn btn-line share-button st-custom-button mx-1 rounded-circle" data-network="line" data-url="<?php echo site_url('job-info/'.$info['job_meta_url']); ?>"><i class="fab fa-line"></i></a>
                        <a href="javascript:void(0);" class="btn btn-messenger share-button st-custom-button mx-1 rounded-circle" data-network="messenger" data-url="<?php echo site_url('job-info/'.$info['job_meta_url']); ?>"><i class="fab fa-facebook-messenger"></i></a>
                        <a href="javascript:void(0);" class="btn btn-facebook share-button st-custom-button mx-1 rounded-circle" data-network="facebook" data-url="<?php echo site_url('job-info/'.$info['job_meta_url']); ?>"><i class="fab fa-facebook-square"></i></a>
                        <a href="javascript:void(0);" class="btn btn-twitter share-button st-custom-button mx-1 rounded-circle" data-network="twitter" data-url="<?php echo site_url('job-info/'.$info['job_meta_url']); ?>"><i class="fab fa-twitter"></i></a>
                        <a href="javascript:void(0);" id="btnCopy" class="btn share-button btn-red ml-1 rounded-circle" data-text-to-clipboard="<?php echo site_url('job-info/'.$info['job_meta_url']); ?>"><i class="far fa-copy"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>