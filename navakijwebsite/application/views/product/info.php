<div class="spacing"></div>
<section id="page-body" class="px-0">

    <?php /* #page-banner - Start */ ?>
    <?php $background_img = ( $category_info['insurance_category_banner'] != '' && is_file( realpath('public/core/uploaded/insurance_categories/'.$category_info['insurance_category_banner']) ) === true ? base_url('public/core/uploaded/insurance_categories/'.$category_info['insurance_category_banner']) : base_url('public/core/img/page_banner.png') ); ?>
    <div id="page-banner" class="d-flex flex-wrap" style="background-image:url( '<?php echo $background_img; ?>' );">
        <div class="container">

            <?php /*
            <div class="col-12 col-md-8 mx-auto border border-2px border-white d-flex flex-wrap px-0">
                <div class="col-5 col-md-6">&nbsp;</div>
                <div id="caption" class="col-7 col-md-6">
                    <h1 class="text-center white"><?php echo $category_info['insurance_category_title_'.$this->_language]?></h1>
                </div>
            </div>
            <?php */ ?>

        </div>
    </div>
    <?php /* #page-banner - End */ ?>

    <?php /* #product-info - Start */ ?>
    <div id="product-info">
        <div class="container px-0 d-flex flex-wrap">

            <div id="breadcrumb" class="breadcrumb col-12 col-lg-6 mb-3">
                <p><a href="<?php echo site_url(''); ?>" class="btn-text black"><?php echo ( $this->_language == 'en' ? 'Home' : 'หน้าหลัก' ); ?></a>
                <a href="<?php echo site_url('products'); ?>" class="btn-text black">ผลิตภัณฑ์</a>
                <a href="<?php echo site_url( $category_info['insurance_category_meta_url'] ); ?>" class="btn-text black"><?php echo $category_info['insurance_category_title_'.$this->_language]?></a>
                <a href="<?php echo site_url( $product_info['insurance_meta_url'] ); ?>" class="btn-text navy"><?php echo $product_info['insurance_title_'.$this->_language];?></a></p>
            </div>
            
            <div class="col-12 col-lg-6 mb-3 text-right">
                <p class="text-center text-lg-right mb-3"><a href="#download-files" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="download-files" class="btn btn-navy"><i class="fas fa-bars"></i> <?php echo ( $this->_language == 'th' ? 'สนใจผลิตภัณฑ์' : 'Proceed' ); ?></a></p>
                <div id="download-files" class="col-12 col-lg-7 offset-lg-8 collapse multi-collapse">
                    <?php if( $product_info['insurance_file_'.$this->_language] != '' && is_file( realpath('public/core/uploaded/insurance/file/'.$product_info['insurance_file_'.$this->_language]) ) === true ): ?>
                        <p class="text-center text-lg-left pb-3"><a href="<?php echo base_url('public/core/uploaded/insurance/file/'.$product_info['insurance_file_'.$this->_language]); ?>" class="btn-text navy mx-lg-3" target="_blank"><i class="fas fa-map"></i> <?php echo ( $this->_language == 'th' ? 'ใบคำขอ' : 'Request Form' ); ?></a></p>
                    <?php endif; ?>
                    <?php if( $product_info['insurance_file_2_'.$this->_language] != '' && is_file( realpath('public/core/uploaded/insurance/file/'.$product_info['insurance_file_2_'.$this->_language]) ) === true ): ?>
                        <p class="text-center text-lg-left pb-3"><a href="<?php echo base_url('public/core/uploaded/insurance/file/'.$product_info['insurance_file_2_'.$this->_language]); ?>" class="btn-text navy mx-lg-3" target="_blank"><i class="fas fa-file-pdf"></i> <?php echo ( $this->_language == 'th' ? 'รายละเอียดผลิตภัณฑ์' : 'Brochure' ); ?></a></p>
                    <?php endif; ?>
                    <?php if( $product_info['insurance_file_3_'.$this->_language] != '' && is_file( realpath('public/core/uploaded/insurance/file/'.$product_info['insurance_file_3_'.$this->_language]) ) === true ): ?>
                        <p class="text-center text-lg-left pb-3"><a href="<?php echo base_url('public/core/uploaded/insurance/file/'.$product_info['insurance_file_3_'.$this->_language]); ?>" class="btn-text navy mx-lg-3" target="_blank"><i class="fas fa-file-download"></i> <?php echo ( $product_info['insurance_file_3_label_'.$this->_language] != '' ? $product_info['insurance_file_3_label_'.$this->_language] : 'Download 1' ); ?></a></p>
                    <?php endif; ?>
                    <?php if( $product_info['insurance_file_4_'.$this->_language] != '' && is_file( realpath('public/core/uploaded/insurance/file/'.$product_info['insurance_file_4_'.$this->_language]) ) === true ): ?>
                        <p class="text-center text-lg-left"><a href="<?php echo base_url('public/core/uploaded/insurance/file/'.$product_info['insurance_file_4_'.$this->_language]); ?>" class="btn-text navy mx-lg-3" target="_blank"><i class="fas fa-file-download"></i> <?php echo ( $product_info['insurance_file_4_label_'.$this->_language] != '' ? $product_info['insurance_file_4_label_'.$this->_language] : 'Download 2' ); ?></a></p>
                    <?php endif; ?>
                    <p class="text-center text-lg-left"><a href="https://lin.ee/4WexKut" class="btn-text navy mx-lg-3" target="_blank"><i class="fab fa-line"></i> <?php echo ( $this->_language == 'th' ? 'ติดต่อเจ้าหน้าที่' : 'Contact us' ); ?></a></p>

                </div>
            </div>

            <?php $panelInfoClass = ( $product_info['insurance_contact_form'] == 1 ? 'col-12 col-lg-8 mb-3 mb-md-0' : 'col-12 mb-3 mb-md-0' ); ?>
            <div id="panel-info" class="<?php echo $panelInfoClass; ?>">

                <div id="image" class="mb-3"><img src="<?php echo base_url( 'public/core/uploaded/insurance/'.$product_info['insurance_image'] ); ?>" alt="" class="img-fullwidth" /></div>
                <div class="content-box">
                    <h2 class="navy"><?php echo $product_info['insurance_title_'.$this->_language];?></h2>
                    <?php if( $product_info['sum_insured'] > 0 ): ?>
                        <p class="mb-3 bold">คุ้มครองสูงสุด <?php echo number_format( (float)$product_info['sum_insured'] ); ?>.- บาท</p>
                    <?php endif; ?>
                    <?php if($product_info['price'] > 0): ?>
                        <p class="mb-3 bold">เบี้ยประกันเริ่มต้น <?php echo number_format((float)$product_info['price'])?>.- บาท</p>
                    <?php endif; ?>
                    <p><?php echo $product_info['insurance_sdesc_'.$this->_language];?></p>
                    <div id="icons" class="d-flex flex-wrap">
                        <?php foreach($icon as $rs){  ?>
                            <div class="col px-1 px-md-3">
                                <p class="text-center"><img src="<?php echo base_url( 'public/core/uploaded/icons/'.$rs['icon_image'] ); ?>" alt="" class="img-icon img-fullwidth" /></p>
                                <p class="text-center"><?php echo ( $rs['insurance_label_'.$this->_language] == '' ? $rs['icon_title_'.$this->_language] : $rs['insurance_label_'.$this->_language] );?></p>
                            </div>
                        <?php }?>
                    </div>
                    <p>&nbsp;</p>
                    <p class="text-center"><?php echo $product_info['insurance_desc_'.$this->_language];?></p>

                    <?php if( isset( $vehicle_list ) && count( $vehicle_list ) > 0 ): ?>

                        <nav>
                            <div class="nav nav-tabs d-flex" id="nav-tab" role="tablist">
                                <?php foreach( $vehicle_list as $key => $v_rs ): ?>
                                    <a class="nav-item nav-link <?php echo ( $key == 0 ? 'active' : '' ); ?>" id="nav-package-<?php echo $v_rs['vehicle_insurance_id']; ?>" data-toggle="tab" href="#tab-package-<?php echo $v_rs['vehicle_insurance_id']; ?>" role="tab" aria-controls="tab-package-<?php echo $v_rs['vehicle_insurance_id']; ?>" aria-selected="<?php echo ( $key == 0 ? true : false ); ?>">
                                        <h5 class="navy">ทุนประกัน <?php echo number_format( $v_rs['sum_insured'] ); ?></h4>
                                        <p class="grey">เบี้ยประกัน <?php echo number_format( $v_rs['price'] ); ?></p>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <?php foreach( $vehicle_list as $key => $v_rs ): ?>
                                <div class="tab-pane fade <?php echo ( $key == 0 ? 'show active': '' ); ?>" id="tab-package-<?php echo $v_rs['vehicle_insurance_id']; ?>" role="tabpanel" aria-labelledby="nav-package-<?php echo $v_rs['vehicle_insurance_id']; ?>">
                                    <?php echo $v_rs['vehicle_insurance_desc_'.$this->_language]?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>
                    
                    
                </div>

                <?php if( $product_info['insurance_contact_form'] == 0 ): ?>
                <div class="d-flex flex-wrap mb-3">
                    <div class="col-12 ml-auto my-3 my-lg-0 d-inline">
                        <?php /* <p class="text-center text-lg-right"><a href="javascript:void(0);" class="btn btn-turquoise" data-toggle="modal" data-target="#shareModal"><i class="fas fa-share-alt"></i> แชร์ประกันนี้</a></p> */ ?>
                        <h5 class="uppercase p-2 text-right"><i class="fas fa-link"></i> แชร์ </h5>
                        <div class="px-0 sharethis-inline-share-buttons"></div>
                    </div>
                    <div class="col-12 my-3 my-lg-0">
                        <p class="text-center"><a href="<?php echo site_url( $category_info['insurance_category_meta_url'] ); ?>" class="btn btn-navy"><i class="fas fa-chevron-left"></i> กลับไปยัง <?php echo $category_info['insurance_category_title_'.$this->_language]; ?></a></p>
                    </div>
                </div>
                <?php endif; ?>

            </div>
            
            <?php if( $product_info['insurance_contact_form'] == 1 ): ?>
                <?php /* #product-sidebar - Start */ ?>
                <div id="product-sidebar" class="col-12 col-md-4 py-3">
                    <h4>
                        <a href="#contactForm" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="contactForm" class="d-flex flex-wrap align-items-center border-radius bg-blue white p-3">
                            <strong class="white"><?php echo ( $this->_language == 'th' ? 'ข้อมูลสำหรับติดต่อกลับ' : 'Contact form' ); ?></strong>
                            <span class="ml-auto text-right">
                                <i class="fas fa-chevron-down white"></i>
                                <i class="fas fa-chevron-up white"></i>
                            </span>
                        </a>
                    </h4>
                    <div id="contactForm" class="collapse multi-collapse p-3 mt-3 show bg-blue border-radius">
                    <?php $message = $this->session->flashdata('message');
                                
                                if(@$message!=NULL){ ?>
                                <?php echo $message;?>
                                </div>
                        <?php } ?>

                        <form id="contact" name="contact" method="post" enctype="multipart/form-data" action="" class="form mb-3">
                            <input type="hidden" name="insurance_id" id="insurance_id" value="<?php echo $product_info['insurance_id'];?>">
                            
                            <?php /*
                            <div class="control-group d-flex flex-wrap bg-white">
                                <label class="control-label col-4"><?php echo ( $this->_language == 'th' ? 'เพศ' : 'Sex' ); ?></label>
                                <div class="controls col-8 px-1 my-0 d-flex flex-wrap align-items-center justify-content-end">
                                    <div class="mk-trc my-2" data-style="radio" data-radius="true" data-text="true" data-color="blue-grey">
                                        <input type="radio" name="contact_gender" id="contact_gender_m" value="male" <?php echo set_checkbox('contact_gender','male'); ?>>
                                        <label for="contact_gender_m"><i></i> <?php echo ( $this->_language == 'th' ? 'ชาย' : 'Male'); ?></label>
                                    </div>
                                    <div class="mk-trc my-2 ml-3" data-style="radio" data-radius="true" data-text="true" data-color="blue-grey">
                                        <input type="radio" name="contact_gender" id="contact_gender_f" value="female" <?php echo set_checkbox('contact_gender','female'); ?>>
                                        <label for="contact_gender_f"><i></i> <?php echo ( $this->_language == 'th' ? 'หญิง' : 'Female' ); ?></label>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_error('contact_gender'); ?>
                            */ ?>
                            <div class="control-group d-flex flex-wrap bg-white">
                                <label class="control-label col-4" for="contact_fname"><?php echo ( $this->_language == 'th' ? 'ชื่อจริง' : 'Firstname' ); ?></label>
                                <div class="controls col-8 px-1 my-0">
                                    <input type="text" name="contact_fname" id="contact_fname" value="<?php echo set_value('contact_fname'); ?>" placeholder="<?php echo ( $this->_language == 'th' ? 'โปรดระบุ' : 'Required' ); ?>" class="text-right noborder" />
                                </div>
                            </div>
                            <?php echo form_error('contact_fname'); ?>
                            <div class="control-group d-flex flex-wrap bg-white">
                                <label class="control-label col-4" for="contact_lname"><?php echo ( $this->_language == 'th' ? 'นามสกุล' : 'Lastname' ); ?></label>
                                <div class="controls col-8 px-1 my-0">
                                    <input type="text" name="contact_lname" id="contact_lname" value="<?php echo set_value('contact_lname'); ?>" placeholder="<?php echo ( $this->_language == 'th' ? 'โปรดระบุ' : 'Required' ); ?>" class="text-right noborder" />
                                </div>
                            </div>
                            <?php echo form_error('contact_lname'); ?>
                            <div class="control-group d-flex flex-wrap bg-white">
                                <label class="control-label col-4" for="contact_tel"><?php echo ( $this->_language == 'th' ? 'เบอร์โทรศัพท์' : 'Telephone No.' ); ?></label>
                                <div class="controls col-8 px-1 my-0">
                                    <input type="tel" name="contact_tel" id="contact_tel" value="<?php echo set_value('contact_tel'); ?>" placeholder="<?php echo ( $this->_language == 'th' ? 'โปรดระบุ' : 'Required' ); ?>" class="text-right noborder" />
                                </div>
                            </div>
                            <?php echo form_error('contact_tel'); ?>
                            <?php /*
                            <div class="control-group d-flex flex-wrap bg-white">
                                <label class="control-label col-4" for="contact_email"><?php echo ( $this->_language == 'th' ? 'อีเมล' : 'Email' ); ?></label>
                                <div class="controls col-8 px-1 my-0">
                                    <input type="email" name="contact_email" id="contact_email" value="<?php echo set_value('contact_email'); ?>" placeholder="<?php echo ( $this->_language == 'th' ? 'โปรดระบุ' : 'Required' ); ?>" class="text-right noborder" />
                                </div>
                            </div>
                            <?php echo form_error('contact_email'); ?>
                            */ ?>
                            <div class="control-group d-flex flex-wrap bg-white">
                                <label class="control-label col-4" for="province_id"><?php echo ( $this->_language == 'th' ? 'จังหวัด' : 'City' ); ?></label>
                                <div class="controls col-8 px-1 my-0">
                                    <select id="province_id" name="province_id" class="select2">
                                    <option value="" <?php echo set_select('province_id','', true); ?>><?php echo ( $this->_language == 'th' ? 'โปรดระบุ' : 'Choose province' ); ?></option>
                                        <?php foreach($provinces as $p_rs){?>
                                            <option value="<?php echo $p_rs['province_id']?>" <?php echo set_select('province_id', $p_rs['province_id']); ?>><?php echo ( $this->_language == 'th' ? $p_rs['province_name_th'] : $p_rs['province_name_en'] ); ?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                            <?php echo form_error('province_id'); ?>
                            <div class="control-group d-flex flex-wrap">
                                <div class="controls">
                                    <div class="mk-trc my-2" data-style="radio" data-radius="true" data-text="true" data-color="white">
                                        <input type="radio" name="agreement" id="agreement" value="1" <?php echo set_radio('agreement', 1); ?>>
                                        <label for="agreement">
                                            <i class="fas" data-before-check="" data-after-check="&#xf00c;"></i>
                                            <?php if( $this->_language == 'th' ): ?>
                                                <span class="small white">
                                                    ข้าพเจ้าตกลงยินยอมให้เก็บรวบรวมและใช้ข้อมูลส่วน
                                                    บุคคลข้างต้นของข้าพเจ้า เพื่อติดต่อข้าพเจ้าในการ
                                                    นำเสนอผลิตภัณฑ์และบริการที่ข้าพเจ้าสนใจหรือที่บริษัทฯ 
                                                    เห็นว่าเป็นประโยชน์แก่ข้าพเจ้าได้โดยข้าพเจ้าให้ถือเอา
                                                    การทำเครื่องหมาย <span class="far fa-check-circle"></span> ในช่อง เป็นการแสดง
                                                    เจตนายินยอมของข้าพเจ้าแทนการลงลายมือชื่อเป็น
                                                    หลักฐาน ทั้งนี้ ก่อนการแสดงเจตนาดังกล่าวข้างต้น 
                                                    ข้าพเจ้าได้อ่านและรับทราบเกี่ยวกับ <a href="javascript:void(0);" class="btn-text white underline">นโยบายความเป็นส่วนตัวแล้ว</a>
                                                </span>
                                            <?php else: ?>
                                                <span class="small white">
                                                    I, hereby, give consent for my personal data in the form above to be collected and processed by the company in order to offer products and services which either I am interested in purchasing or the company would like to offers those that are beneficial to me as a customer. By means of marking <span class="far fa-check-circle"></span> in the circle, it represents my signature for the confirmation of my permission for processing my personal data. Acknowledgedly, I have read and understood the privacy policy.
                                                </span>
                                            <?php endif; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_error('agreement'); ?>
                            <div class="control-group d-flex flex-wrap">
                                <div class="controls col-8 px-1 my-0">
                                    <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_KEY;?>"></div>
                                </div>
                            </div>
                            <?php echo form_error('g-recaptcha-response'); ?>
                            
                            <div class="form-actions text-center mt-3">
                                <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-navy"><?php echo ( $this->_language == 'th' ? 'ตกลง' : 'Submit' ); ?></button>
                            </div>
                        </form>
                    </div>
                    <div class="border-radius bg-navy white d-flex align-items-center justify-content-center p-3 mt-3">
                        <h3><a href="https://lin.ee/4WexKut" target="_blank" class="white"><i class="far fa-comment-dots"></i> <?php echo ( $this->_language == 'th' ? 'แชทกับเรา' : 'Chat with us' ); ?></a></h3>
                    </div>
                    <div class="white col-12 ml-auto my-3 my-lg-0 d-inline">
                        <?php /* <p class="text-center text-lg-right"><a href="javascript:void(0);" class="btn btn-turquoise" data-toggle="modal" data-target="#shareModal"><i class="fas fa-share-alt"></i> แชร์ประกันนี้</a></p> */ ?>
                        <h5 class="uppercase p-2 text-right"><i class="fas fa-link"></i> <?php echo ( $this->_language == 'th' ? 'แชร์' : 'Share' ); ?> </h5>
                        <div class="px-0 sharethis-inline-share-buttons"></div>
                    </div>
                </div>
                <?php /* #product-sidebar - End */ ?>
            <?php endif; ?>

        </div>

    </div>
    <?php /* #product-info - End */ ?>

    <?php /* #recommend - Start */ ?>
    <div id="recommend" class="bg-lightgrey">
        <div class="container">

            <h3 class="section-title text-center navy"><?php echo $category_info['insurance_category_title_'.$this->_language]?></h3>

            <div class="d-flex flex-wrap">

                <?php
                    foreach($suggestion_list as $s_rs){
                        if($s_rs['price']){
                            $diff = intval($product_info['price']) - intval($s_rs['price']);
                            if($diff > 0){
                                $price = "ถูกกว่า ". number_format( $diff ) ." บาท";
                                $color = 'green';
                            }elseif($diff == 0){
                                $price ="ราคาเดียวกัน";
                                $color = 'navy';
                            }else{
                                $price = "เพิ่มอีกแค่ ". number_format( $diff * -1 ) ." บาท";
                                $color = 'red';
                            }

                        }
                        ?>
                        <div class="recommend-item col-12 col-md-4 px-0 px-md-3 mb-3 mb-md-0">
                            <a href="<?php echo site_url($s_rs['insurance_meta_url']); ?>">
                                <div class="image">
                                    <div class="mask"></div>
                                    <img src="<?php echo base_url( 'public/core/uploaded/insurance/thumb/'.$s_rs['insurance_thumbnail'] ); ?>" alt="" class="img-fullwidth d-block" />
                                </div>
                                <h4 class="bold navy text-center my-3"><?php echo $s_rs['insurance_title_'.$this->_language];?></h4>
                                <div class="text-center navy"><?php echo $s_rs['insurance_sdesc_'.$this->_language];?></div>
                                <?php if( $category_info['insurance_category_id'] == 1 ): ?>
                                    <?php if($s_rs['price']): ?>
                                        <h5 class="bold <?php echo $color; ?> text-center mt-3"><?php echo $price;?></h5>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </a>
                        </div>
                    <?php
                    }
                ?>
                
            </div>
        </div>
    </div>
    <?php /* #recommend - End */ ?>

</section>