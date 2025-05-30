    <?php /* Footer - Start */ ?>
    <footer class="bg-navy pt-3">
        <?php $navigations = $this->mainmodel->get_navigations(0, 5); ?>
        <div class="container px-0">
            <div class="d-flex flex-wrap">
                
                <?php if( isset( $navigations ) && count( $navigations ) > 0 ): ?>
                    <div id="footer-nav" class="col-12 col-lg-10 d-flex flex-wrap">

                        <?php foreach( $navigations as $navigation ): ?>
                            <div class="footer-nav-blog col-6 col-lg my-3">
                                <p class="footer-nav-title white"><?php echo $navigation['nav_title_'.$this->_language]; ?></p>
                                <?php $subnavs = $this->mainmodel->get_navigations( $navigation['nav_id'] ); ?>
                                <?php if( isset( $subnavs ) && count( $subnavs ) > 0 ): ?>
                                    <?php foreach( $subnavs as $subnav ): ?>
                                        <?php
                                            if( in_array( $subnav['content_type'], array('insurance','articles','documents') ) === true ){
                                                $content = array();
                                                $category = array();
                                                if( $subnav['content_type'] == 'insurance' ){
                                                    $category = $this->mainmodel->get_insurance_categoryinfo_byid( $subnav['category_id'] );
                                                    $content = $this->mainmodel->get_insuranceinfo_byid( $subnav['content_id'] );
                                                }else if( $subnav['content_type'] == 'articles' ){
                                                    $category = $this->mainmodel->get_article_categoryinfo_byid( $subnav['category_id'] );
                                                    $maincategory = $this->mainmodel->get_article_categoryinfo_byid( $category['main_id'] );
                                                    $content = $this->mainmodel->get_articleinfo_byid( $subnav['content_id'] );
                                                }else if( $subnav['content_type'] == 'documents' ){
                                                    $category = $this->mainmodel->get_document_categoryinfo_byid( $subnav['category_id'] );
                                                    $maincategory = $this->mainmodel->get_document_categoryinfo_byid( $category['main_id'] );
                                                    $content = $this->mainmodel->get_documentinfo_byid( $subnav['content_id'] );
                                                }

                                                if( isset( $content ) && count( $content ) > 0 ){
                                                    $url = site_url($content['content_meta_url']);
                                                }else if( isset( $category ) && count( $category ) > 0 ){
                                                    if( $subnav['content_type'] == 'articles' && isset( $maincategory ) && count( $maincategory ) > 0 ){
                                                        $url = site_url($maincategory['category_meta_url'].'/'.$category['category_meta_url']);
                                                    }else if( $subnav['content_type'] == 'documents' ){
                                                        $url = site_url($maincategory['category_meta_url'].'/'.$category['category_meta_url']);
                                                    }else{
                                                        $url = site_url($category['category_meta_url']);
                                                    }
                                                    //$url = site_url($category['category_meta_url']);
                                                }else{
                                                    $url = 'javascript:void(0);';
                                                }
                                            }else if( $subnav['content_type'] == 'external_link' ){
                                                $url = $subnav['nav_external_url'];
                                            }else if( $subnav['content_type'] == 'internal_link'){
                                                $url = site_url( $subnav['nav_internal_url'] );
                                            }else{
                                                $url = 'javascript:void(0);';
                                            }
                                        ?>
                                        <p class="footer-nav-item grey"><a href="<?php echo $url; ?>" <?php echo ( $subnav['is_newtab'] == 1 ? 'target="_blank" ' : '' ); ?> class="btn-text grey"><?php echo $subnav['nav_title_'.$this->_language]; ?></a></p>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php /*
                                <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">สุขภาพ</a></p>
                                <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">เบ็ดเตล็ด</a></p>
                                */ ?>
                            </div>
                        <?php endforeach; ?>
                        <?php /*
                        <div class="footer-nav-blog col-6 col-lg my-3">
                            <p class="footer-nav-title white">บริการ</p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">เคลมรถยนต์</a></p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">เคลมอุบัติเหตุและสุขภาพ</a></p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">เคลมอัคคีภัยและทรัพย์สิน</a></p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">บริการรับชำระเบี้ยประกันภัย</a></p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">แจ้งความประสงค์ยกเว้นภาษีเงินได้สำหรับประกันสุขภาพ</a></p>
                        </div>
                        <div class="footer-nav-blog col-6 col-lg my-3">
                            <p class="footer-nav-title white">เกี่ยวกับเรา</p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">ข้อมูลข่าวสาร</a></p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">ติดต่อบริษัท</a></p>
                        </div>
                        <div class="footer-nav-blog col-6 col-lg my-3">
                            <p class="footer-nav-title white">การพัฒนาอย่างยั่งยืน</p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">ความรับผิดชอบต่อสังคม</a></p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">การกำกับดูแลกิจการ</a></p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">ช่องทางการติดต่อร้องเรียน</a></p>
                        </div>
                        <div class="footer-nav-blog col-6 col-lg my-3">
                            <p class="footer-nav-title white">นักลงทุนสัมพันธ์</p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">ข้อมูลการเงิน</a></p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">เอกสารเผยแพร่</a></p>
                            <p class="footer-nav-item grey"><a href="javascript:void(0);" class="btn-text grey">ข้อมูลผู้ถือหุ้น</a></p>
                        </div>
                        */ ?>
                        <div class="col-6 px-0 my-3 mt-lg-0 d-flex d-lg-none flex-wrap align-self-center">
                            <div class="col-12 px-0 d-flex justify-content-center justify-content-md-end align-items-center">
                                <i class="icomoon icon_contact white mr-3 mb-2"></i>
                                <a href="tel:1748" class="bold large">1748</a>
                            </div>
                            <div class="col-12 px-0 mb-3">
                                <p class="white text-center text-md-right"><a href="<?php echo site_url('contact-us'); ?>" class="btn-text white">ติดต่อเรา</a> | <a href="<?php echo site_url('job-vacancy'); ?>" class="btn-text white">ร่วมงานกับเรา</a></p>
                                <p class="text-center text-md-right">
                                    <?php $facebook = $this->mainmodel->get_web_setting('social_facebook'); ?>
                                    <?php if( isset( $facebook ) && count( $facebook ) > 0 && $facebook['setting_value'] != '' ): ?>
                                        <a href="<?php echo $facebook['setting_value']; ?>" class="btn-text white" target="_blank">
                                            <span class="fa-stack fa-1x">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fab fa-facebook-f fa-stack-1x navy"></i>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                    <?php $line = $this->mainmodel->get_web_setting('social_line'); ?>
                                    <?php if( isset( $line ) && count( $line ) > 0 && $line['setting_value'] != '' ): ?>
                                        <a href="<?php echo $line['setting_value']; ?>" class="btn-text white" target="_blank">
                                            <span class="fa-stack fa-1x">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fab fa-line fa-stack-1x navy"></i>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                    <?php $email = $this->mainmodel->get_web_setting('admin_email'); ?>
                                    <?php if( isset( $email ) && count( $email ) > 0 && $email['setting_value'] != '' ): ?>
                                        <a href="mailto:<?php echo $email['setting_value']; ?>" class="btn-text white" target="_blank">
                                            <span class="fa-stack fa-1x">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-envelope fa-stack-1x navy"></i>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="footer-contact" class="col-12 col-lg-2 px-lg-0 d-none d-lg-flex flex-wrap align-items-start">
                        <!-- <form id="subscribeForm" name="subscribeForm" method="post" enctype="multipart/form-data" action="" class="form col-12 col-lg-10 ml-auto px-0 mt-3 mb-0">
                            <div class="control-group">
                                <label class="control-label white mb-3" for="subscribe_email">สมัครรับข่าวสารจากเรา</label>
                                <div class="controls my-0">
                                    <input type="email" name="subscribe_email" id="subscribe_email" placeholder="สมัครอีเมล" class="border-radius border border-1px border-turquoise" />
                                    <button type="submit" name="btn-submit" id="btn-submit"><i class="far fa-arrow-alt-circle-right"></i></button>
                                </div>
                            </div>
                        </form> -->
                        <div class="col-12 px-0 my-3 mt-lg-0 d-flex flex-wrap align-self-center">
                            <div class="col-12 px-0 d-flex justify-content-end">
                                <i class="icomoon icon_contact white mr-3"></i>
                                <a href="tel:1748" class="bold large">1748</a>
                            </div>
                            <div class="col-12 px-0 mb-3">
                                <p class="white text-center"><a href="<?php echo site_url('contact-us'); ?>" class="btn-text white">ติดต่อเรา</a> | <a href="<?php echo site_url('job-vacancy'); ?>" class="btn-text white">ร่วมงานกับเรา</a></p>
                                <p class="white text-center"><a href="<?php echo assets_url('download/E-policy.pdf'); ?>" target="_blank" class="btn-text white">ใบอนุญาต e-Policy</a></p>
                                <p class="text-center mt-1">
                                    <?php $facebook = $this->mainmodel->get_web_setting('social_facebook'); ?>
                                    <?php if( isset( $facebook ) && count( $facebook ) > 0 && $facebook['setting_value'] != '' ): ?>
                                        <a href="<?php echo $facebook['setting_value']; ?>" class="btn-text white" target="_blank">
                                            <span class="fa-stack fa-1x">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fab fa-facebook-f fa-stack-1x navy"></i>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                    <?php $line = $this->mainmodel->get_web_setting('social_line'); ?>
                                    <?php if( isset( $line ) && count( $line ) > 0 && $line['setting_value'] != '' ): ?>
                                        <a href="<?php echo $line['setting_value']; ?>" class="btn-text white" target="_blank">
                                            <span class="fa-stack fa-1x">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fab fa-line fa-stack-1x navy"></i>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                    <?php $email = $this->mainmodel->get_web_setting('admin_email'); ?>
                                    <?php if( isset( $email ) && count( $email ) > 0 && $email['setting_value'] != '' ): ?>
                                        <a href="mailto:<?php echo $email['setting_value']; ?>" class="btn-text white" target="_blank">
                                            <span class="fa-stack fa-1x">
                                                <i class="fas fa-circle fa-stack-2x"></i>
                                                <i class="fas fa-envelope fa-stack-1x navy"></i>
                                            </span>
                                        </a>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <div id="copyright-claims" class="bg-turquoise p-1 mt-3 mt-md-0">
            <div class="container">
                <p class="text-center white small mb-0">Copyright 2016 © The Navakij Insurance Public Company Limited All Right Reserved.</p>
            </div>
        </div>
    </footer>
    <?php /* Footer - End */ ?>
    
    <?php if( !get_cookie( COOKIE_NAME ) ): ?>
        <?php /* #cookies - Start */ ?>
        <?php /*
        <div id="cookies">
            <div class="item">
                <a href="javascript:void(0);" class="btnClose btn-text white"><i class="far fa-times-circle"></i></a>
                <p>&nbsp;</p>
                <p class="white small">
                    <?php if( $this->_language == 'th' ): ?>
                        บริษัท นวกิจประกันภัย จำกัด (มหาชน) ใช้งานคุกกี้ (Cookies) เพื่อเพิ่มประสิทธิภาพในการให้บริการ หากท่านปฏิเสธคุกกี้ หรือยังคงใช้งานเว็บไซต์ต่อไป บริษัทฯจะยังคงเก็บคุกกี้ ที่มีความจำเป็นต่อการใช้งานเว็บไซต์ของท่านเท่านั้น
                    <?php else: ?>
                        Navakij Insurance Public Company Limited uses cookies to enhance the efficiency of its services. If you decline cookies or continue to use the website, the company will only retain cookies necessary for your website usage.
                    <?php endif; ?>
                </p>
                <p class="text-center"><a href="<?php echo site_url('policy'); ?>" class="btn-text white underline"><?php echo ( $this->_language == 'th' ? 'อ่านเพิ่มเติม' : 'Read more' ); ?></a></p>
                <p class="text-center mt-3">
                    <a href="javascript:void(0);" id="btnDeclinePolicy" class="btn btn-grey"><?php echo ( $this->_language == 'th' ? 'ปฏิเสธ' : 'Decline' ); ?></a>
                    <a href="javascript:void(0);" id="btnAcceptPolicy" class="btn btn-turquoise"><?php echo ( $this->_language == 'th' ? 'ยอมรับ' : 'Accept' ); ?></a>
                </p>
            </div>
            <div class="mask"></div>
        </div>
        */ ?>
        <?php /* #cookies - End */ ?>
    <?php endif; ?>

</div>
<?php /* #container - End */ ?>

<?php /* .modal - Start */ ?>
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-3">
            <div class="modal-header p-0">
                <h2 class="navy my-3 px-3">Tell your friend about us...</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times-circle red"></i>
                </button>
            </div>
            <div class="modal-body d-flex felx-wrap justify-content-center">
                <a href="javascript:void(0);" class="btn btn-facebook share-button st-custom-button facebook-share-button mx-1" data-network="facebook"><i class="fab fa-facebook-square"></i> share</a>
                <a href="javascript:void(0);" class="btn btn-twitter share-button st-custom-button twitter-share-button mx-1" data-network="twitter"><i class="fab fa-twitter-square"></i> tweet</a>
                <a href="javascript:void(0);" class="btn btn-line share-button st-custom-button line-share-button mx-1" data-network="line"><i class="fab fa-line"></i> line</a>
                <a href="javascript:void(0);" class="btn btn-green-transparent share-button st-custom-button email-share-button mx-1" data-network="email"><i class="fas fa-envelope-square"></i> email</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-3">
            <div class="modal-header p-0">
                <h2 class="navy my-3 px-3">เราอยากจะบอกกับคุณว่า...</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times-circle red"></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center mb-2">
                    <img src="<?php echo assets_url('img/mockup_profile_1.jpg'); ?>" alt="" class="img-fullwidth d-block mx-auto rounded-circle" />
                </p>
                <p class="navy bold text-center my-3">Khun Nickname 1</p>
                <p class="navy text-center">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce posuere feugiat accumsan."</p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="leavingProfileModal" tabindex="-1" role="dialog" aria-labelledby="leavingProfileModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-3">
            <div class="modal-header p-0">
                <h2 class="navy my-3 px-3">ฝากประวัติสมัครงาน</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times-circle red"></i>
                </button>
            </div>
            <div class="modal-body">
                <form id="leavingProfileForm" name="leavingProfileForm" method="post" enctype="multipart/form-data" action="" class="form">
                    <div class="control-group">
                        <label class="control-label" for="profile_fullname">ชื่อ-สกุล <span class="symbol required"></span></label>
                        <div class="controls d-flex flex-wrap">
                            <div class="col-12 px-0">
                                <input type="text" name="profile_fullname" id="profile_fullname" value="<?php echo set_value('profile_fullname'); ?>" placeholder="Type your name..." class="required" />
                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="profile_job_id">ตำแหน่งงานที่สนใจ <span class="symbol required"></span></label>
                        <div class="controls col-12 px-0 d-flex">
                            <?php $positions = $this->mainmodel->get_jobs(0, 0, 1); ?>
                            <select name="profile_job_id" id="profile_job_id" class="select2 required">
                                <option value="0" <?php echo set_select('profile_job_id',0, true); ?>>-- เลือกตำแหน่งงานที่สนใจ --</option>
                                <?php if( isset( $positions ) && count( $positions ) > 0 ): ?>
                                    <?php foreach( $positions as $position ): ?>
                                        <option value="<?php echo $position['job_id']; ?>" <?php echo set_select('profile_job_id', $position['job_id']); ?>><?php echo $position['job_title_'.$this->_language]; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="profile_mobile">เบอร์ติดต่อกลับ <span class="symbol required"></span></label>
                        <div class="controls d-flex">
                            <div class="col-12 px-0">
                                <input type="tel" name="profile_mobile" id="profile_mobile" value="<?php echo set_value('profile_mobile'); ?>" placeholder="Type your telephone number..." class="required validate_mobile" maxlength="10" />
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="profile_email">อีเมล ติดต่อกลับ <span class="symbol required"></span></label>
                        <div class="controls">
                            <div class="col-12 px-0">
                                <input type="email" name="profile_email" id="profile_email" value="<?php echo set_value('profile_email'); ?>" placeholder="Type your email..." class="required validate_email" />
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <div class="controls">
                        <p>"บริษัท นวกิจประกันภัย จำกัด (มหาชน) ขอเรียนให้ท่านทราบว่า บริษัทฯ ไม่มีความประสงค์ในการเก็บรวบรวมข้อมูลส่วนบุคคลที่มีความอ่อนไหว ซึ่งปรากฎอยู่บนหน้าบัตรประจำตัวประชาชน สำเนาทะเบียนบ้าน สำเนาหนังสือเดินทาง รวมถึงเอกสารอื่นๆ เช่น เชื้อชาติ ข้อมูลศาสนา หมู่โลหิต (กรุ๊ปเลือด) เป็นต้น จึงขอได้โปรด ทำการขีดฆ่า หรือทำเส้นทึบ ปิดทับข้อมูลดังกล่าวบนสำเนาเอกสารต่างๆ ก่อนส่งมอบให้บริษัทฯ ด้วย"</p>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">แนบไฟล์สมัครงาน <span class="symbol required"></span></label>
                        <div class="controls d-flex">
                            <div class="col-12 px-0">
                                <p class="mb-3"><input type="file" name="profile_file" id="profile_file" /></p>
                                <p class="navy small">Allow file extension *.pdf, *.doc, *.docx, *.jpg, *.jpeg, *.png, *.gif, *.xls, *.xlsx</p>
                                <p class="navy small">Maximum file size not over 5Mb/file</p>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php /* <p>การรับรองและให้ความยินยอม ข้าพเจ้าขอรับรองว่า ข้าพเจ้าได้รับทราบ ทบทวน และเข้าใจเนื้อหาตามนโยบายข้อมูลาส่วนบุคคลของผู้สมัครงาน และยินยอมให้ใช้ข้อมูลส่วนบุคคลของข้าพเจ้าเพื่อวัตถุประสงค์ตามที่ระบุตามนโยบายดังกล่าว <a href="javascript:void(0);" data-toggle="modal" data-target="#pdpaModal" class="btn-text navy">อ่านเพิ่มเติม</a></p> */ ?>
                        <p>การรับรองและให้ความยินยอม ข้าพเจ้าขอรับรองว่า ข้าพเจ้าได้รับทราบ ทบทวน และเข้าใจเนื้อหาตามนโยบายข้อมูลาส่วนบุคคลของผู้สมัครงาน และยินยอมให้ใช้ข้อมูลส่วนบุคคลของข้าพเจ้าเพื่อวัตถุประสงค์ตามที่ระบุตามนโยบายดังกล่าว <a href="<?php echo site_url('privacy-policy'); ?>" class="btn-text navy" target="_blank">อ่านเพิ่มเติม</a></p>
                        <div class="controls">
                            <p><label><input type="radio" name="applicant_pdpa_consent" id="applicant_pdpa_consent_accept" value="accept" checked="checked" /> รับรอง / ยินยอม</label></p>
                            <p class="mb-3"><label><input type="radio" name="applicant_pdpa_consent" id="applicant_pdpa_consent_decline" value="decline" /> ปฏิเสธ</label></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php /* <p>* ผู้ที่จะได้รับแต่งตั้งให้เป็นพนักงาน/บุคคลผู้มีอำนาจในการจัดการสาขา (อ้างอิงประกาศคณะกรรมการกำกับและส่งเสริมการประกอบธุรกิจประกันภัย เรื่อง หลักเกณฑ์วิธีการและเงื่อนไขในการขออนุญาตเปิดสาขา ย้ายที่ตั้งสำนักงานใหญ่ หรือสำนักงานสาขา หรือเลิกสาขาของบริษัทประกันวินาศภัย พ.ศ. 2551 ลว. 3 กรกฎาคม 2551 <a href="javascript:void(0);" class="btn-text navy" data-toggle="modal" data-target="#announcingLetterModal">อ่านเพิ่มเติม</a></p> */ ?>
                        <p>* ผู้ที่จะได้รับแต่งตั้งให้เป็นพนักงาน/บุคคลผู้มีอำนาจในการจัดการสาขา (อ้างอิงประกาศคณะกรรมการกำกับและส่งเสริมการประกอบธุรกิจประกันภัย เรื่อง หลักเกณฑ์วิธีการและเงื่อนไขในการขออนุญาตเปิดสาขา ย้ายที่ตั้งสำนักงานใหญ่ หรือสำนักงานสาขา หรือเลิกสาขาของบริษัทประกันวินาศภัย พ.ศ. 2551 ลว. 3 กรกฎาคม 2551 <a href="<?php echo site_url('stfile/announcingletter'); ?>" class="btn-text navy" target="_blank">อ่านเพิ่มเติม</a></p>
                    </div>

                    <div class="control-group">
                        <?php /* <p>1. ท่านเป็นบุคคลซึ่งมีลักษณะต้องห้ามตามมาตรา 34 แห่งพระราชบัญญัติ ประกันวินาศภัย (ฉบับที่ 2) พ.ศ. 2551 ลว.​ 27 มกราคม 2551 หรือไม่ <a href="javcascript:void(0);" data-toggle="modal" data-target="#forbiddenPersonLetterModal" class="btn-text navy">อ่านเพิ่มเติม</a> <span class="symbol required"></span></p> */ ?>
                        <p>1. ท่านเป็นบุคคลซึ่งมีลักษณะต้องห้ามตามมาตรา 34 แห่งพระราชบัญญัติ ประกันวินาศภัย (ฉบับที่ 2) พ.ศ. 2551 ลว.​ 27 มกราคม 2551 หรือไม่ <a href="<?php echo site_url('stfile/nonlife2551'); ?>" class="btn-text navy" target="_blank">อ่านเพิ่มเติม</a> <span class="symbol required"></span></p>
                        <div class="controls my-0">
                            <p><label><input type="radio" name="applicant_forbidden_person" value="yes" /> เป็น</label></p>
                            <p><label><input type="radio" name="applicant_forbidden_person" value="no" checked /> ไม่เป็น</label></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <p>2. ท่านเป็นนายหน้าประกันวินาศภัย หรือไม่ <span class="symbol required"></span></p>
                        <div class="controls my-0">
                            <p><label><input type="radio" name="applicant_broker" value="yes" /> เป็น</label></p>
                            <p><label><input type="radio" name="applicant_broker" value="no" checked /> ไม่เป็น</label></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <p>3. ท่านเป็นบุคคลที่เคยถูกเพิกถอนใบอนุญาตเป็นตัวแทนฯ หรือใบอนุญาตเป็นนายหน้าฯ เว้นแต่จะพ้นระยะเวลา 5 ปีก่อนวันขอรับใบอนุญาต หรือไม่ <span class="symbol required"></span></p>
                        <div class="controls my-0">
                            <p><label><input type="radio" name="applicant_revoked" value="yes" /> เป็น</label></p>
                            <p><label><input type="radio" name="applicant_revoked" value="no" checked /> ไม่เป็น</label></p>
                        </div>
                    </div>

                    <div class="control-group">
                        <p>ข้าพเจ้าขอรับรองว่า ข้อความดังกล่าวทั้งหมดในใบสมัครงานนี้เป็นความจริงทุกประการ หลังจากบริษัทจ้างข้าพเจ้าเข้าทำงานแล้ว ปรากฎว่า รายละเอียดข้อความในใบสมัครงาน และ/หรือเอกสารแนบอื่นๆ ไม่เป็นความจริง บริษัทฯ ขอสงวนสิทธิ์ที่จะเลิกจ้างข้าพเจ้าได้โดยไม่ต้องจ่ายเงินชดเชยหรือค่าเสียหายใดๆ ทั้งสิ้น</p>
                        <div class="controls">
                            <label><input type="checkbox" name="applicant_consent" id="applicant_consent" value="1" <?php echo set_checkbox('applicant_consent', 1); ?> class="required" /> ยอมรับ<span class="symbol required"></span></label>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_signed_name">ชื่อของคุณ <span class="symbol required"></span></label>
                        <div class="controls d-flex flex-wrap my-0">
                            <p class="col-12 mb-3 px-0"><input type="text" name="applicant_signed_name" id="applicant_signed_name" value="<?php echo set_value('applicant_signed_name'); ?>" class="required" /></p>
                            <p class="col-12 text-center"><?php echo thai_convert_fulldate( date('Y-m-d') ); ?></p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="reset" name="btn-profile-reset" id="btn-profile-reset" class="btn btn-navy-transparent" data-dismiss="modal">ยกเลิก</button>
                <button type="button" name="btn-profile-submit" id="btn-profile-submit" class="btn btn-navy">ตกลง</button>
            </div>
        </div>
    </div>
</div>
<?php $announcingLetter = $this->mainmodel->get_web_setting( 'announcing_letter' ); ?>
<?php if( isset( $announcingLetter) && count( $announcingLetter ) > 0 ): ?>
<div class="modal fade applicant-modal" id="announcingLetterModal" tabindex="-1" role="dialog" aria-labelledby="announcingLetterModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content p-3">
            <div class="modal-header p-0">
                <h2 class="navy my-3 px-3">หลักเกณฑ์วิธีการและเงื่อนไขในการขออนุญาตเปิดสาขา ย้ายที่ตั้งสำนักงานใหญ่ หรือสำนักงานสาขา หรือเลิกสาขาของบริษัทประกันวินาศภัย พ.ศ. 2551 ลว. 3 กรกฎาคม 2551</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times-circle red"></i>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $announcingLetter['setting_value']; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $forbiddenPerson = $this->mainmodel->get_web_setting( 'forbidden_person_letter' ); ?>
<?php if( isset( $forbiddenPerson ) && count( $forbiddenPerson ) > 0 ): ?>
    <div class="modal fade applicant-modal" id="forbiddenPersonLetterModal" tabindex="-1" role="dialog" aria-labelledby="forbiddenPersonLetterModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content p-3">
            <div class="modal-header p-0">
                <h2 class="navy my-3 px-3">บุคคลซึ่งมีลักษณะต้องห้ามตามมาตรา 34 แห่งพระราชบัญญัติ ประกันวินาศภัย (ฉบับที่ 2) พ.ศ. 2551 ลว.​ 27 มกราคม 2551</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times-circle red"></i>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $forbiddenPerson['setting_value']; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php $pdpa = $this->mainmodel->get_web_setting( 'pdpa_act' ); ?>
<?php if( isset( $pdpa ) && count( $pdpa ) > 0 ): ?>
<div class="modal fade applicant-modal" id="pdpaModal" tabindex="-1" role="dialog" aria-labelledby="pdpaModal" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content p-3">
            <div class="modal-header p-0">
                <h2 class="navy my-3 px-3">นโยบายข้อมูลส่วนบุคคลของผู้สมัครงาน และยินยอมให้ใช้ข้อมูลส่วนบุคคล</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times-circle red"></i>
                </button>
            </div>
            <div class="modal-body">
                <?php echo $pdpa['setting_value']; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php /* #memberProfileModal - Start */ ?>
<div class="modal fade" id="memberProfileModal" tabindex="-1" role="dialog" aria-labelledby="memberProfileModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content p-3">
            <div class="modal-header p-0">
                <h2 id="modal-member-name" class="navy my-3 px-3"></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times-circle red"></i>
                </button>
            </div>
            <div class="modal-body d-flex flex-wrap">
                
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-navy-transparent" data-dismiss="modal">ปิด</a>
            </div>
        </div>
    </div>
</div>
<?php /* #memberProfileModal - End */ ?>
<?php /* .modal - End */ ?>

<?php /* #loading - Start */ ?>
<div id="loading">
    <div id="spinner" class="loadingio-spinner-double-ring-1va14xj2933">
        <div class="ldio-spczj9pbzv">
            <div></div>
            <div></div>
            <div>
                <div></div>
            </div>
            <div>
                <div></div>
            </div>
        </div>
    </div>
</div>
<?php /* #loading - End */ ?>

<?php /* Javascripts - Start */ ?>
<script type="text/javascript">
    var base_url = '<?php echo base_url(''); ?>';
    var language = '<?php echo $this->_language; ?>';
</script>
<script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=60348e9f317d2200110fb4ee&product=sop' async='async'></script>
<script type="text/javascript" src="<?php echo assets_url('js/jquery-3.4.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('js/jquery-migrate-1.4.1.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('lazyload/jquery.lazyload.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('select2/js/select2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('slick/slick/slick.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('fancybox/jquery.fancybox.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('isotope/isotope.pkgd.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('isotope/imagesloaded.pkgd.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('lazyload/jquery.lazyload.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('sweetalert2/sweetalert2.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo vendors_url('bootstrap-datepicker/js/bootstrap-datepicker.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('js/cookies.js'); ?>"></script>
<script type="text/javascript" src="<?php echo assets_url('js/function.js?v=1.2'); ?>"></script>
<script type="text/javascript">

    $(document).ready(function(){
        <?php $introPopup = $this->mainmodel->get_intro(); ?>
        <?php if( isset( $introPopup ) && count( $introPopup ) > 0 ): ?>
            /* #introPopup trigger - Start */
            <?php if( $introPopup['intro_url'] != '' || $introPopup['intro_url'] != null ): ?>
                $('#introPopup').fancybox({
                    afterShow: function() {
                        console.log('Load complete!');
                        $('.fancybox-image').wrap( $("<a />", {
                            href: '<?php echo $introPopup['intro_url']; ?>',
                            target: "_blank"
                        }));
                    }
                }).trigger('click');
            <?php else: ?>
                $('#introPopup').trigger('click');
            <?php endif; ?>
            /* #introPopup trigger - End */
        <?php endif; ?>

        $('body').on('click','#btnAcceptPolicy', function(){
            var target = $(this);
            var targetParent = target.parents('#cookies');
            $.get( '<?php echo base_url($this->_language . '/api/acceptCookies'); ?>', function(response){
                var res = JSON.parse( response );
                console.log( response );
                if( res.status == 200 ){
                    targetParent.fadeOut('fast');
                }
            });
        });
        $('body').on('click','#cookies .btnClose, #cookies #btnDeclinePolicy', function(){
            var target = $(this);
            var targetParent = target.parents('#cookies');
            targetParent.fadeOut('fast');
        });
    });

    <?php $success = $this->session->flashdata("message-success"); ?>
    <?php if($success): ?>
        swalMessage('message-success', '<?php echo ( $this->_language == 'th' ? 'สำเร็จ!' : 'Success!' ); ?>', '<?php echo $success; ?>' );
    <?php endif; ?>
    
    <?php $info = $this->session->flashdata("message-info"); ?>
    <?php if($info): ?>
        swalMessage('message-info', '<?php echo ( $this->_language == 'th' ? 'กรุณาอ่าน' : 'Please, noted.' ); ?>', '<?php echo $info; ?>' );
    <?php endif; ?>
    
    <?php $error = $this->session->flashdata("message-error"); ?>
    <?php if($error): ?>
        swalMessage('message-error', '<?php echo ( $this->_language == 'th' ? 'เกิดข้อผิดพลาด!' : 'Something wrong!' ); ?>', '<?php echo $error; ?>' );
    <?php endif; ?>

    <?php $warning = $this->session->flashdata("message-warning"); ?>
    <?php if($warning): ?>
        swalMessage('message-warning', '<?php echo ( $this->_language == 'th' ? 'คำเตือน!' : 'Warning!' ); ?>', '<?php echo $warning; ?>' );
    <?php endif; ?>
    
</script>
<?php /* Javascripts - End */ ?>

<?php /* Facebook chat plugin - Start */ ?>
<!-- Messenger Chat plugin Code -->
<?php /*
<div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v10.0'
          });
        };

        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/th_TH/sdk/xfbml.customerchat.js';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
      </script>

      <!-- Your Chat plugin code -->
      <div class="fb-customerchat"
        attribution="page_inbox"
        page_id="187249974717764">
      </div>
*/ ?>
<?php /* Facebook chat plugin - Start */ ?>

<?php /* Chat with us on Line - Start */ ?>
<a href="https://lin.ee/1U8QrgL" id="btnLine" target="_blank">
    <span class="fa-stack fa-2x">
        <i class="fas fa-circle fa-stack-2x green"></i>
        <i class="fab fa-line fa-stack-1x white"></i>
    </span>
</a>
<?php /* Chat with us on Line - End */ ?>

</body>
</html>