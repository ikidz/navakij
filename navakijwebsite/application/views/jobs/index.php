<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey">
    <div class="container px-0">
        <h3 class="section-title text-center navy">ร่วมงานกับเรา</h3>
        <div class="d-flex flex-wrap">

            <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                <p>
                    <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                    <a href="javascript:void(0);" class="btn-text navy">ร่วมงานกับเรา</a>
                </p>
            </div>

            <div id="info" class="content-box col-12 px-0 px-md-3">
                <h4 class="navy"><i class="fas fa-home"></i> เรื่องราว...</h4>
                <div class="col-8 px-0 px-md-3 my-3 mx-auto">
                    <video playsinline="" autoplay="false" controls="" loop="" preload="metadata" id="bgvid" style="width:100%;">
                        <source src="<?php echo assets_url('video/banner3.webm'); ?>" type="video/webm">
                        <source src="<?php echo assets_url('video/banner3.mp4'); ?>" type="video/mp4">
                    </video>
                </div>
                <?php /* <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque ut porta nibh, eget fermentum mauris. Integer tristique ullamcorper tellus ut blandit. Nullam porttitor ex id elit aliquam bibendum. Integer vehicula tempor sapien, id pharetra arcu tempor sed. Morbi vehicula commodo ornare. Sed cursus malesuada risus, vitae semper risus vehicula at. Suspendisse porttitor hendrerit magna et tincidunt. Mauris finibus tempor volutpat. Proin in tortor quis sapien malesuada pretium. Sed molestie feugiat augue, nec volutpat augue rhoncus eget. Nullam at lorem mattis, feugiat ante sit amet, rhoncus libero.</p> */ ?>
            </div>

            <div class="col-12">
                <hr size="0" class="border-navy" />
            </div>

            <?php if( isset( $employees ) && count( $employees ) > 0 ): ?>
                <div id="profiles" class="col-12 px-0 px-md-3 d-flex flex-wrap justify-content-center">
                    <h4 class="col-12 navy mb-3"><i class="fas fa-users"></i> ครอบครัวของเรา</h4>
                    <?php foreach( $employees as $employee ): ?>
                        <?php if( $employee['employee_image_'.$this->_language] != '' && is_file( realpath('public/core/uploaded/employees/'.$employee['employee_image_'.$this->_language]) ) === true ): ?>
                            <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                                <p class="text-center mb-2">
                                    <a href="<?php echo base_url('public/core/uploaded/employees/'.$employee['employee_image_'.$this->_language]); ?>" data-fancybox>
                                        <img src="<?php echo base_url('public/core/uploaded/employees/'.$employee['employee_image_'.$this->_language]); ?>" alt="" class="img-fullwidth d-block mx-auto" />
                                    </a>
                                </p>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="col-12">
                    <hr size="0" class="border-navy" />
                </div>
            <?php endif; ?>

            <div class="col-12 text-right">
                <a href="<?php echo site_url('job-applicant'); ?>" class="btn btn-navy"><i class="fas fa-check-square"></i> <?php echo ( $this->_language == 'en' ? 'Apply NOW!' : 'สมัครออนไลน์' ); ?></a>
                <a href="javascript:void(0);" class="btnLeavingProfile btn btn-navy mt-3 mt-lg-0" data-jobId="0"><i class="fas fa-inbox"></i> <?php echo ( $this->_language == 'en' ? 'Leave your profile' : 'ฝากประวัติ' ); ?></a>
            </div>

            <div id="job-list" class="download-list col-12">
                
                <?php if( isset( $jobs ) && count( $jobs ) > 0 ): ?>
                    <?php foreach( $jobs as $job ): ?>
                        <div class="item w-100 d-flex flex-wrap">
                            <div class="col-12 col-8 col-left">
                                <h5><?php echo $job['job_title_'.$this->_language]; ?> <?php echo ( $job['job_remark_label_'.$this->_language] != '' ? '<span class="small red">'.$job['job_remark_label_'.$this->_language].'</span>' : '' ); ?></h5>
                            </div>
                            <a href="javascript:void(0);" data-toggle="collapse" data-target="#job-info-<?php echo $job['job_id']; ?>" aria-controls="job-info-<?php echo $job['job_id']; ?>" aria-expanded="false" class="col-12 col-lg-4 col-right">
                                <div class="title">
                                    <h5><?php echo ( $this->_language == 'en' ? 'View detail' : 'ดูรายละเอียด' ); ?></h5>
                                </div>
                                <div class="icon ml-auto"><i class="fas fa-arrow-circle-down"></i></div>
                            </a>
                        
                            <div id="job-info-<?php echo $job['job_id']; ?>" class="collapse multi-collapse col-12 p-3 p-lg-5">
                                <?php if( $job['job_amount'] > 0 ): ?>
                                    <p class="bold navy"><?php echo ( $this->_language == 'en' ? 'Number of open' : 'จำนวนที่เปิดรับ' ); ?> : <?php echo $job['job_amount']; ?> <?php echo ( $this->_language == 'en' ? 'positions' : 'อัตรา' ); ?></p>
                                <?php endif; ?>
                                <p>&nbsp;</p>
                                <p class="bold navy"><?php echo ( $this->_language == 'en' ? 'Responsibility' : 'หน้าที่ความรับผิดชอบ' ); ?> : </p>
                                <?php echo $job['job_responsibility_'.$this->_language]; ?>
                                <p>&nbsp;</p>
                                <p class="bold navy"><?php echo ( $this->_language == 'en' ? 'Qualification' : 'คุณสมบัติ' ); ?> : </p>
                                <?php echo $job['job_qualification_'.$this->_language]; ?>
                                <hr size="0" class="border-navy" />
                                <div class="w-100 d-flex flex-wrap jusitfy-content-between">
                                    <div class="col-12 col-lg-8 px-0 text-center text-lg-left">
                                        <?php if( $job['is_appliable'] > 0 ): ?>
                                            <a href="<?php echo site_url('job-applicant/'.$job['job_id']); ?>" class="btn btn-navy"><i class="fas fa-check-square"></i> <?php echo ( $this->_language == 'en' ? 'Apply NOW!' : 'สมัครออนไลน์' ); ?></a>
                                        <?php endif; ?>
                                        <?php if( $job['is_profile_leaving'] > 0 ): ?>
                                            <a href="javascript:void(0);" class="btnLeavingProfile btn btn-navy mt-3 mt-lg-0" data-jobId="<?php echo $job['job_id']; ?>"><i class="fas fa-inbox"></i> <?php echo ( $this->_language == 'en' ? 'Leave your profile' : 'ฝากประวัติ' ); ?></a>
                                        <?php endif; ?>
                                        <a href="<?php echo site_url('job-info/'.$job['job_meta_url']); ?>" class="btn btn-navy mt-3 mt-lg-0"><i class="fas fa-eye"></i> <?php echo ( $this->_language == 'en' ? 'View' : 'ดูรายละเอียด'); ?></a>
                                    </div>
                                    <div class="col-12 col-lg-4 px-0 ml-auto my-3 my-lg-0 d-inline text-center text-lg-right">
                                        <span class="navy bold d-none d-lg-inline-block">Share : </span>
                                        <a href="javascript:void(0);" class="btn btn-line share-button st-custom-button mx-1 rounded-circle" data-network="line" data-url="<?php echo site_url('job-info/'.$job['job_meta_url']); ?>"><i class="fab fa-line"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-messenger share-button st-custom-button mx-1 rounded-circle" data-network="messenger" data-url="<?php echo site_url('job-info/'.$job['job_meta_url']); ?>"><i class="fab fa-facebook-messenger"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-facebook share-button st-custom-button mx-1 rounded-circle" data-network="facebook" data-url="<?php echo site_url('job-info/'.$job['job_meta_url']); ?>"><i class="fab fa-facebook-square"></i></a>
                                        <a href="javascript:void(0);" class="btn btn-twitter share-button st-custom-button mx-1 rounded-circle" data-network="twitter" data-url="<?php echo site_url('job-info/'.$job['job_meta_url']); ?>"><i class="fab fa-twitter"></i></a>
                                        <a href="javascript:void(0);" id="btnCopy" class="btn share-button btn-red ml-1 rounded-circle" data-text-to-clipboard="<?php echo site_url('job-info/'.$job['job_meta_url']); ?>"><i class="far fa-copy"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            
          </div>

        </div>
    </div>
</section>