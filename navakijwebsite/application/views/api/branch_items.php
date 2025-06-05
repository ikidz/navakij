<?php if(isset( $branch_list ) && count( $branch_list ) > 0 ){?>
    <?php foreach($branch_list as $key=>$rs) { 
        $cate = $this->api_model->get_category_branch_info($rs['category_id']);
        $brand = $this->api_model->get_brand_title($rs['branch_id']);
        // if($brand){

        //     foreach($brand as $key=>$b_rs){
        //         if($key == 0){
        //             $brand_list = $b_rs['brand_title'];
        //         }else{
        //             $brand_list = $brand_list.", ".$b_rs['brand_title'];
        //         }
        //     }
        // }
        ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="item-claim noborder">
                <?php /*
                <div class="row-thumb">
                <?php if( $rs['branch_image'] != '' && is_file( realpath('public/core/uploaded/branches/'.$rs['branch_image']) ) === true ): ?>
                    <img src="<?php echo base_url( 'public/core/uploaded/branches/'.$rs['branch_image'] ); ?>" />
                <?php else: ?>
                    <img src="<?php echo base_url('public/core/img/default_image.jpg'); ?>" alt="" class="img-fullwidth" />
                <?php endif; ?>
                </div>
                */ ?>
                <div class="row-detail bg-lightgrey">
                <h5 class="navy"><?php echo $rs['branch_title_'.$language];?></h5>
                <div class="row">
                    <div class="label">ประเภท</div>
                    <div class="content"><?php echo $cate['category_title_'.$language];?></div>
                </div>
                <?php /*
                <div class="row">
                    <div class="label">ยี่ห้อรถ</div>
                    <div class="content"><?php echo $brand_list;?></div>
                </div>
                */ ?>
                <div class="row">
                    <div class="label">โทรศัพท์</div>
                    <div class="content"><?php echo $rs['branch_tel'];?></div>
                </div>
                <div class="row">
                    <div class="label">โทรสาร</div>
                    <div class="content"><?php echo $rs['branch_fax'];?></div>
                </div>
                <div class="row">
                    <div class="label">อีเมล์</div>
                    <div class="content"><?php echo $rs['branch_email'];?></div>
                </div>
                <div class="row">
                    <div class="label">เว็บไซต์</div>
                    <div class="content"><?php echo $rs['branch_website'];?></div>
                </div>
                <div class="row">
                    <div class="label">สถานที่ตั้ง</div>
                    <div class="content"><?php echo $rs['branch_address'];?></div>
                </div>
                <?php if($this->input->get('lat') != "" && $this->input->get('lng') != ""){ ?>
                <div class="row">
                    <div class="label">ระยะทาง</div>
                    <div class="content">ประมาณ <?php echo number_format($rs['distance'],2);?> กิโลเมตร</div>
                </div>
                <?php } ?>
								<?php if( $rs['branch_gmap_url'] != null ): ?>
									<?php if( $rs['branch_gmap_url'] != "-" ): ?>
					      		<a href="<?php echo $rs['branch_gmap_url'];?>" class="btn" target="_blank">ขอรับเส้นทาง</a>
									<?php endif; ?>
					      <?php endif; ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>