<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-bookmark"></i> รายละเอียดตำแหน่งที่สมัครงาน</h4>
			<span class="tools">
			    <a href="javascript:;" class="icon-chevron-down"></a>
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				
				<div class="control-group">
                    <label class="control-label" for="location_id">สถานที่ปฏิบัติงาน : </label>
                    <div class="controls col-12 col-lg-8 px-0 d-flex">
                        <select name="location_id" id="location_id" class="select2" disabled>
                            <option value="0" <?php echo set_select('location_id',0, true); ?>>-- เลือกสถานที่ปฏิบัติงาน --</option>
                            <?php if( isset( $locations ) && count( $locations ) > 0 ): ?>
                                <?php foreach( $locations as $location ): ?>
                                    <option value="<?php echo $location['location_id']; ?>" <?php echo set_select('location_id', $location['location_id'], $location['location_id'] == @$info['location_id']); ?>><?php echo $location['location_title_'.$this->_language]; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="job_id">ตำแหน่งงาน : </label>
                    <div class="controls col-12 col-lg-8 px-0 d-flex">
                        <select name="job_id" id="job_id" class="select2" disabled style="width:400px;">
                            <option value="0" <?php echo set_select('job_id',0, true); ?>>-- เลือกตำแหน่งงาน --</option>
                            <?php if( isset( $positions ) && count( $positions ) > 0 ): ?>
                                <?php foreach( $positions as $position ): ?>
                                    <option value="<?php echo $position['job_id']; ?>" <?php echo set_select('job_id', $position['job_id'], $position['job_id'] == @$info['job_id']); ?>><?php echo $position['job_title_'.$this->_language]; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_salary">เงินเดือน : </label>
                    <div class="controls d-flex align-items-center">
                        <input type="text" name="applicant_salary" id="applicant_salary" value="<?php echo set_value('applicant_salary', $info['applicant_salary']); ?>" placeholder="บาท" class="col-8" readonly />
                        <span class="help-inline ml-3">บาท</span>
                    </div>
                </div>
				
			</form>
		</div>
	</div>
</div>

<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-user"></i> ประวัติส่วนตัว</h4>
			<span class="tools">
			    <a href="javascript:;" class="icon-chevron-down"></a>
			</span>							
		</div>
		<div class="widget-body form">
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				
            <div class="control-group">
                <label class="control-label" for="prefix_id">คำนำหน้า</label>
                <div class="controls d-flex">
                    <div class="col-12 col-lg-4 mb-3 mb-lg-0">
                        <select name="prefix_id" id="prefix_id" class="select2" disabled>
                            <option value="0" <?php echo set_select('prefix_id',0, true); ?>>-- เลือกคำนำหน้า --</option>
                            <?php if( isset( $prefixes ) && count( $prefixes ) > 0 ): ?>
                                <?php foreach( $prefixes as $prefix ): ?>
                                    <option value="<?php echo $prefix['prefix_id']; ?>" <?php echo set_select('prefix_id', $prefix['prefix_id'], $prefix['prefix_id'] == $info['prefix_id']); ?>><?php echo $prefix['prefix_title_'.$this->_language]; ?></option>
                                <?php endforeach; ?>
                                <option value="999" <?php echo set_select('prefix_id', 999, $info['prefix_id'] == 999); ?>>อื่นๆ</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <?php if( $info['prefix_id'] == 999 ): ?>
                        <div id="prefix_other_box" style="margin-top:1rem;">
                            <input type="text" name="prefix_other" id="prefix_other" value="<?php echo set_value('prefix_other', $info['prefix_other']); ?>" placeholder="กรุณาระบุคำนำหน้า" readonly />
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="applicant_fname_th">ชื่อ-นามสกุล (ภาษาไทย)<span class="symbol required"></span></label>
                <div class="controls d-flex flex-wrap">
                    <div style="display:inline-block;">
                        <input type="text" name="applicant_fname_th" id="applicant_fname_th" value="<?php echo set_value('applicant_fname_th', $info['applicant_fname_th']); ?>" placeholder="ชื่อ (ภาษาไทย)" class="required" readonly />
                    </div>
                    <div style="display:inline-block;">
                        <input type="text" name="applicant_lname_th" id="applicant_lname_th" value="<?php echo set_value('applicant_lname_th', $info['applicant_lname_th']); ?>" placeholder="นามสกุล (ภาษาไทย)" class="required" readonly />
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="applicant_fname_en">Fullname (English)<span class="symbol required"></span></label>
                <div class="controls d-flex flex-wrap">
                    <div style="display:inline-block;">
                        <input type="text" name="applicant_fname_en" id="applicant_fname_en" value="<?php echo set_value('applicant_fname_en', $info['applicant_fname_en']); ?>" placeholder="Firstname (English)" class="required" readonly />
                    </div>
                    <div style="display:inline-block;">
                        <input type="text" name="applicant_lname_en" id="applicant_lname_en" value="<?php echo set_value('applicant_lname_en', $info['applicant_lname_en']); ?>" placeholder="Lastname (English)" class="required" readonly />
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="applicant_birthdate">วัน/เดือน/ปี เกิด</label>
                <div class="controls d-flex">
                    <div class="icon-append position-relative col-6 col-lg-4">
                        <i class="fas fa-calendar-o grey position-absolute"></i>
                        <input type="text" name="applicant_birthdate" id="applicant_birthdate" value="<?php echo set_value('applicant_birthdate', thai_convert_shortdate( $info['applicant_birthdate'] )); ?>" readonly />
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="applicant_idcard">หมายเลขบัตรประชาชน<span class="symbol required"></span></label>
                <div class="controls d-flex">
                    <div class="col-8">
                        <input type="text" name="applicant_idcard" id="applicant_idcard" value="<?php echo set_value('applicant_idcard', $info['applicant_idcard']); ?>" placeholder="e.g. 1234567890123" class="required validate_number_only" maxlength="13" readonly />
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="applicant_idcard_expired">วันหมดอายุบัตร</label>
                <div class="controls d-flex">
                    <div class="icon-append position-relative col-6 col-lg-4">
                        <i class="fas fa-calendar-o grey position-absolute"></i>
                        <input type="text" name="applicant_idcard_expired" id="applicant_idcard_expired" value="<?php echo set_value('applicant_idcard_expired', thai_convert_shortdate( $info['applicant_idcard_expired'] )); ?>" readonly />
                    </div>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="applicant_height">ส่วนสูง</label>
                <div class="controls d-flex align-items-center">
                    <input type="number" name="applicant_height" id="applicant_height" value="<?php echo set_value('applicant_height', $info['applicant_height']); ?>" min="0" max="999" step="1" readonly />
                    <span class="help-inline ml-3">ซม.</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="applicant_weight">น้ำหนัก</label>
                <div class="controls d-flex align-items-center">
                    <input type="number" name="applicant_weight" id="applicant_weight" value="<?php echo set_value('applicant_weight', $info['applicant_weight']); ?>" min="0" max="9999" step="1" readonly />
                    <span class="help-inline ml-3">กก.</span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="applicant_military_status">สถานภาพทางทหาร</label>
                <div class="controls d-flex">
                    <div class="col-8">
                        <select name="applicant_military_status" id="applicant_military_status" class="select2" disabled>
                            <option value="0" <?php echo set_select('applicant_military_status',0, $info['applicant_military_status'] == 0); ?>>-- เลือกสถานภาพทางทหาร --</option>
                            <option value="serving" <?php echo set_select('applicant_military_status', 'serving', $info['applicant_military_status'] == 'serving'); ?>>อยู่ระหว่างรับราชการ / ทหารเกณฑ์</option>
                            <option value="completed" <?php echo set_select('applicant_military_status', 'completed', $info['applicant_military_status'] == 'completed'); ?>>ผ่านการเกณฑ์ทหาร</option>
                            <option value="exempted" <?php echo set_select('applicant_military_status', 'exempted', $info['applicant_military_status'] == 'exempted'); ?>>ได้รับการยกเว้น</option>
                        </select>
                    </div>
                </div>
            </div>
				
			</form>
		</div>
	</div>
</div>

<?php if( isset( $addresses['current'] ) && count( $addresses['current'] ) > 0 ): ?>
    <?php $address = $addresses['current'][0]; ?>
    <div class="span12" style="margin:0;">
        <div class="widget">
            <div class="widget-title">
                <h4><i class="icon-home"></i> ที่อยู่ปัจจุบัน</h4>
                <span class="tools">
                    <a href="javascript:;" class="icon-chevron-down"></a>
                </span>							
            </div>
            <div class="widget-body form">
                <form method="post" enctype="multipart/form-data" class="form-horizontal">
                    
                <div class="control-group">
                    <label class="control-label" for="applicant_current_address_no">บ้านเลขที่</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <input type="text" name="applicant_current_address_no" id="applicant_current_address_no" value="<?php echo set_value('applicant_current_address_no', $address['address_no']); ?>" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_village">หมู่บ้าน/อาคาร</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <input type="text" name="applicant_current_village" id="applicant_current_village" value="<?php echo set_value('applicant_current_village', $address['address_building']); ?>" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_avenue">ซอย</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <input type="text" name="applicant_current_avenue" id="applicant_current_avenue" value="<?php echo set_value('applicant_current_avenue', $address['address_avenue']); ?>" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_road">ถนน</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <input type="text" name="applicant_current_road" id="applicant_current_road" value="<?php echo set_value('applicant_current_road', $address['address_street']); ?>" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_province_id">จังหวัด</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <select name="applicant_current_province_id" id="applicant_current_province_id" class="select2" disabled>
                                <option value="0" <?php echo set_select('applicant_current_province_id',0, true); ?>>-- เลือกจังหวัด --</option>
                                <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                    <?php foreach( $provinces as $province ): ?>
                                        <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_current_province_id', $province['province_id'], $province['province_id'] == $address['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_district_id">เขต/อำเภอ</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <select name="applicant_current_district_id" id="applicant_current_district_id" class="select2" disabled>
                                <option value="0" <?php echo set_select('applicant_current_district_id', '', true); ?>>-- เลือกเขต/อำเภอ --</option>
                                <?php $districts = $this->applicantsreportmodel->get_districts( $this->input->post('applicant_current_province_id') ); ?>
                                <?php if( isset( $districts ) && count( $districts ) > 0 ): ?>
                                    <?php foreach( $districts as $district ): ?>
                                        <option value="<?php echo $district['amphoe_id']; ?>" <?php echo set_select('applicant_current_district_id', $district['amphoe_id'], $district['amphoe_id'] == $address['district_id']); ?>><?php echo ( $this->_language == 'th' ? $district['name'] : $district['name_alt'] ); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_subdistrict_id">แขวง/ตำบล</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <select name="applicant_current_subdistrict_id" id="applicant_current_subdistrict_id" class="select2" disabled>
                                <option value="0" <?php echo set_select('applicant_current_subdistrict_id', '', true); ?>>-- เลือกแขวง/ตำบล -- </option>
                                <?php $subdistricts = $this->applicantsreportmodel->get_subdistricts( $this->input->post('applicant_current_subdistrict_id') ); ?>
                                <?php if( isset( $subdistricts ) && count( $subdistricts ) > 0 ): ?>
                                    <?php foreach( $subdistricts as $subdistrict ): ?>
                                        <option value="<?php echo $subdistrict['tambon_id']; ?>" <?php echo set_select('applicant_current_subdistrict_id', $subdistrict['tambon_id'], $subdistrict['tambon_id'] == $address['subdistrict_id']); ?>><?php echo ( $this->_language == 'th' ? $subdistrict['name'] : $subdistrict['name_alt'] ); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_postcode_id">รหัสไปรษณีย์</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <select name="applicant_current_postcode_id" id="applicant_current_postcode_id" class="select2" disabled>
                                <option value="0" <?php echo set_select('applicant_current_postcode_id', '', true); ?>>-- เลือกรหัสไปรษณีย์ --</option>
                                <?php $postcodes = $this->applicantsreportmodel->get_zipcodes( $this->input->post('applicant_current_subdistrict_id') ); ?>
                                <?php if( isset( $postcodes ) && count( $postcodes ) > 0 ): ?>
                                    <?php foreach( $postcodes as $postcode ): ?>
                                        <option value="<?php echo $postcode['postcode_id']; ?>" <?php echo set_select('applicant_current_postcode_id', $postcode['postcode_id'], $postcode['postcode_id'] == $address['postcode_id']); ?>><?php echo $postcode['postcode']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_telephone">เบอร์โทรศัพท์</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <input type="tel" name="applicant_current_telephone" id="applicant_current_telephone" value="<?php echo set_value('applicant_current_telephone', $address['address_tel']); ?>" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_mobile">เบอร์โทรศัพท์มือถือ <span class="symbol required"></span></label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <input type="tel" name="applicant_current_mobile" id="applicant_current_mobile" value="<?php echo set_value('applicant_current_mobile', $address['address_mobile']); ?>" class="required validate_mobile" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_current_email">อีเมล <span class="symbol required"></span></label>
                    <div class="controls">
                        <div class="col-8">
                            <input type="email" name="applicant_current_email" id="applicant_current_email" value="<?php echo set_value('applicant_current_email', $address['address_email']); ?>" class="required validate_email" readonly />
                        </div>
                    </div>
                </div>
                    
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if( isset( $addresses['registration'] ) && count( $addresses['registration'] ) > 0 ): ?>
    <?php $regist = $addresses['registration'][0]; ?>
    <div class="span12" style="margin:0;">
        <div class="widget">
            <div class="widget-title">
                <h4><i class="icon-home"></i> ที่อยู่ตามสำเนาทะเบียนบ้าน</h4>
                <span class="tools">
                    <a href="javascript:;" class="icon-chevron-down"></a>
                </span>							
            </div>
            <div class="widget-body form">
                <form method="post" enctype="multipart/form-data" class="form-horizontal">

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_address_no">บ้านเลขที่</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <input type="text" name="applicant_register_address_no" id="applicant_register_address_no" value="<?php echo set_value('applicant_register_address_no', $regist['address_no']); ?>" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_village">หมู่บ้าน/อาคาร</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <input type="text" name="applicant_register_village" id="applicant_register_village" value="<?php echo set_value('applicant_register_village', $regist['address_building']); ?>" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_avenue">ซอย</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <input type="text" name="applicant_register_avenue" id="applicant_register_avenue" value="<?php echo set_value('applicant_register_avenue', $regist['address_avenue']); ?>" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_road">ถนน</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <input type="text" name="applicant_register_road" id="applicant_register_road" value="<?php echo set_value('applicant_register_road', $regist['address_street']); ?>" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_province_id">จังหวัด</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <select name="applicant_register_province_id" id="applicant_register_province_id" class="select2" disabled>
                                    <option value="0" <?php echo set_select('applicant_register_province_id',0, true); ?>>-- เลือกจังหวัด --</option>
                                    <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                        <?php foreach( $provinces as $province ): ?>
                                            <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_register_province_id', $province['province_id'], $province['province_id'] == $regist['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_district_id">เขต/อำเภอ</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <select name="applicant_register_district_id" id="applicant_register_district_id" class="select2" disabled>
                                    <option value="0" <?php echo set_select('applicant_register_district_id', '', true); ?>>-- เลือกเขต/อำเภอ --</option>
                                    <?php $districts = $this->applicantsreportmodel->get_districts( $this->input->post('applicant_register_province_id') ); ?>
                                    <?php if( isset( $districts ) && count( $districts ) > 0 ): ?>
                                        <?php foreach( $districts as $district ): ?>
                                            <option value="<?php echo $district['amphoe_id']; ?>" <?php echo set_select('applicant_register_district_id;', $district['amphoe_id'], $district['amphoe_id'] == $regist['district_id']); ?>><?php echo ( $this->_language == 'th' ? $district['name'] : $district['name_alt'] ); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_subdistrict_id">แขวง/ตำบล</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <select name="applicant_register_subdistrict_id" id="applicant_register_subdistrict_id" class="select2" disabled>
                                    <option value="0" <?php echo set_select('applicant_register_subdistrict_id', '', true); ?>>-- เลือกแขวง/ตำบล -- </option>
                                    <?php $subdistricts = $this->applicantsreportmodel->get_subdistricts( $this->input->post('applicant_register_subdistrict_id') ); ?>
                                    <?php if( isset( $subdistricts ) && count( $subdistricts ) > 0 ): ?>
                                        <?php foreach( $subdistricts as $subdistrict ): ?>
                                            <option value="<?php echo $subdistrict['tambon_id']; ?>" <?php echo set_select('applicant_register_subdistrict_id', $subdistrict['tambon_id'], $subdistrict['tambon_id'] == $regist['subdistrict_id']); ?>><?php echo ( $this->_language == 'th' ? $subdistrict['name'] : $subdistrict['name_alt'] ); ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_postcode_id">รหัสไปรษณีย์</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <select name="applicant_register_postcode_id" id="applicant_register_postcode_id" class="select2" disabled>
                                    <option value="0" <?php echo set_select('applicant_register_postcode_id', '', true); ?>>-- เลือกรหัสไปรษณีย์ --</option>
                                    <?php $postcodes = $this->applicantsreportmodel->get_zipcodes( $this->input->post('applicant_register_subdistrict_id') ); ?>
                                    <?php if( isset( $postcodes ) && count( $postcodes ) > 0 ): ?>
                                        <?php foreach( $postcodes as $postcode ): ?>
                                            <option value="<?php echo $postcode['postcode_id']; ?>" <?php echo set_select('applicant_register_postcode_id', $postcode['postcode_id'], $postcode['postcode_id'] == $regist['postcode_id']); ?>><?php echo $postcode['postcode']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_telephone">เบอร์โทรศัพท์</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <input type="tel" name="applicant_register_telephone" id="applicant_register_telephone" value="<?php echo set_value('applicant_register_telephone', $regist['address_tel']); ?>" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_mobile">โทรศัพท์มือถือ</label>
                        <div class="controls d-flex">
                            <div class="col-8">
                                <input type="tel" name="applicant_register_mobile" id="applicant_register_mobile" value="<?php echo set_value('applicant_register_mobile', $regist['address_mobile']); ?>" class="validate_mobile" readonly />
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="applicant_register_email">อีเมล</label>
                        <div class="controls">
                            <div class="col-8">
                                <input type="email" name="applicant_register_email" id="applicant_register_email" value="<?php echo set_value('applicant_register_email', $regist['address_email']); ?>" class="validate_email" readonly />
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-info-circle"></i> อื่นๆ</h4>
			<span class="tools">
			    <a href="javascript:;" class="icon-chevron-down"></a>
			</span>							
		</div>
		<div class="widget-body form">
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				
				<div class="control-group">
                    <label class="control-label" for="applicant_news_source_id">ทราบข่าวการรับสมัครงานของ บมจ. นวกิจประกันภัย จากที่ใด?</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <select name="applicant_news_source_id" id="applicant_news_source_id" class="select2" disabled>
                                <option value="0" <?php echo set_select('applicant_news_source_id', '', true); ?>>-- กรุณาเลือก --</option>
                                <?php if( isset( $sources ) && count( $sources ) > 0 ): ?>
                                    <?php foreach( $sources as $source ): ?>
                                        <option value="<?php echo $source['source_id']; ?>" <?php echo set_select('applicant_news_source_id', $source['source_id'], $source['source_id'] == $info['applicant_news_source_id']); ?>><?php echo $source['source_title_'.$this->_language]; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_applied_status">ท่านเคยสมัครงานกับ บมจ. นวกิจประกันภัย มาก่อนหรือไม่</label>
                    <div class="controls d-flex align-items-center">
                        <label class="col"><input type="checkbox" name="applicant_applied_status" id="applicant_applied_status" value="1" <?php echo set_checkbox('applicant_applied_status', 1, $info['applicant_applied_status'] == 1); ?> class="mr-2" disabled /> เคย</label>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_applied_year">เมื่อใด?</label>
                    <div class="controls d-flex">
                        <div class="col-6 col-lg-4">
                            <input type="text" name="applicant_applied_year" id="applicant_applied_year" value="<?php echo set_value('applicant_applied_year', $info['applicant_applied_year']); ?>" placeholder="ปี" readonly />
                        </div>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label">ท่านเคยป่วยหนักหรือเป็นโรคติดต่อร้ายแรงมาก่อนหรือไม่?</label>
                    <div class="controls d-flex">
                        <label for="applicant_accident_status" class="col"><input type="checkbox" name="applicant_accident_status" id="applicant_accident_status" value="1" <?php echo set_checkbox('applicant_accident_status', 1, $info['applicant_accident_status'] == 1); ?> disabled /> ใช่</label>
                    </div>
                </div>
				
			</form>
		</div>
	</div>
</div>

<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-building-o"></i> ประวัติการศึกษา</h4>
			<span class="tools">
			    <a href="javascript:;" class="icon-chevron-down"></a>
			</span>							
		</div>
		<div class="widget-body form">
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				
				<div class="control-group">
                    <label class="control-label">ขณะนี้ท่านอยู่ระหว่างการศึกษาหรือไม่?</label>
                    <div class="controls d-flex align-items-center">
                        <label for="applicant_studying_status" class="col"><input type="checkbox" name="applicant_studying_status" id="applicant_studying_status" value="1" <?php echo set_checkbox('applicant_studying_status', 1, $info['applicant_studying_status'] == 1); ?> disabled /> ใช่</label>
                    </div>
                </div>
                
                <?php /* High school - Start */ ?>
                <div class="control-group">
                    <label class="control-label" for="applicant_education_highschool_name">มัธยมศึกษา</label>
                    <div class="controls d-flex">
                        <div class="col-12">
                            <input type="text" name="applicant_education_highschool_name" id="applicant_education_highschool_name" value="<?php echo set_value('applicant_education_highschool_name', $info['applicant_education_highschool_name']); ?>" placeholder="ชื่อสถาบัน" readonly style="width:84%;" />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls d-flex flex-wrap align-items-center">
                        <select name="applicant_education_highschool_province_id" id="applicant_education_highschool_province_id" class="select2" disabled style="width:20%;">
                            <option value="0" <?php echo set_select('applicant_education_highschool_province_id', 0, true); ?>>-- จังหวัด --</option>
                            <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                <?php foreach( $provinces as $province ): ?>
                                    <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_highschool_province_id', $province['province_id'], $province['province_id'] == $info['applicant_education_highschool_province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="text" name="applicant_education_highschool_year" id="applicant_education_highschool_year" value="<?php echo set_value('applicant_education_highschool_year', $info['applicant_education_highschool_year']); ?>" placeholder="ปีที่จบการศึกษา" readonly style="width:20%;" />
                        <input type="text" name="applicant_education_highschool_major" id="applicant_education_highschool_major" value="<?php echo set_value('applicant_education_highschool_major', $info['applicant_education_highschool_major']); ?>" placeholder="วิชาเอก" readonly style="width:20%;" />
                        <input type="text" name="applicant_education_highschool_gpa" id="applicant_education_highschool_gpa" value="<?php echo set_value('applicant_education_highschool_gpa', $info['applicant_education_highschool_gpa']); ?>" placeholder="เกรดเฉลี่ย" readonly style="width:20%;" />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls"><hr size="0" class="border-navy" /></div>
                </div>
                <?php /* High school - End */ ?>
                
                <?php /* Vocational - Start */ ?>
                <div class="control-group">
                    <label class="control-label" for="applicant_education_vocational_name">ปวช.</label>
                    <div class="controls d-flex">
                        <div class="col-12">
                            <input type="text" name="applicant_education_vocational_name" id="applicant_education_vocational_name" value="<?php echo set_value('applicant_education_vocational_name', $info['applicant_education_vocational_name']); ?>" placeholder="ชื่อสถาบัน" readonly style="width:84%;" />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls d-flex flex-wrap align-items-center">
                        <select name="applicant_education_vocational_province_id" id="applicant_education_vocational_province_id" class="select2" style="width:20%;" disabled>
                            <option value="0" <?php echo set_select('applicant_education_vocational_province_id', 0, true); ?>>-- จังหวัด --</option>
                            <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                <?php foreach( $provinces as $province ): ?>
                                    <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_vocational_province_id', $province['province_id'], $province['province_id'] == $info['applicant_education_vocational_province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="text" name="applicant_education_vocational_year" id="applicant_education_vocational_year" value="<?php echo set_value('applicant_education_vocational_year', $info['applicant_education_vocational_year']); ?>" placeholder="ปีที่จบการศึกษา" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_vocational_major" id="applicant_education_vocational_major" value="<?php echo set_value('applicant_education_vocational_major', $info['applicant_education_vocational_major']); ?>" placeholder="วิชาเอก" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_vocational_gpa" id="applicant_education_vocational_gpa" value="<?php echo set_value('applicant_education_vocational_gpa', $info['applicant_education_vocational_gpa']); ?>" placeholder="เกรดเฉลี่ย" style="width:20%;" readonly />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls"><hr size="0" class="border-navy" /></div>
                </div>
                <?php /* Vocational - End */ ?>

                <?php /* Diploma - Start */ ?>
                <div class="control-group">
                    <label class="control-label" for="applicant_education_diploma_name">ปวท./ปวส.</label>
                    <div class="controls d-flex">
                        <div class="col-12">
                            <input type="text" name="applicant_education_diploma_name" id="applicant_education_diploma_name" value="<?php echo set_value('applicant_education_diploma_name', $info['applicant_education_diploma_name']); ?>" placeholder="ชื่อสถาบัน" style="width:84%;" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls d-flex flex-wrap align-items-center">
                        <select name="applicant_education_diploma_province_id" id="applicant_education_diploma_province_id" class="select2" style="width:20%;" disabled>
                            <option value="0" <?php echo set_select('applicant_education_diploma_province_id', 0, true); ?>>-- จังหวัด --</option>
                            <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                <?php foreach( $provinces as $province ): ?>
                                    <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_diploma_province_id', $province['province_id'], $province['province_id'] == $info['applicant_education_diploma_province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="text" name="applicant_education_diploma_year" id="applicant_education_diploma_year" value="<?php echo set_value('applicant_education_diploma_year', $info['applicant_education_diploma_year']); ?>" placeholder="ปีที่จบการศึกษา" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_diploma_major" id="applicant_education_diploma_major" value="<?php echo set_value('applicant_education_diploma_major', $info['applicant_education_diploma_major']); ?>" placeholder="วิชาเอก" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_diploma_gpa" id="applicant_education_diploma_gpa" value="<?php echo set_value('applicant_education_diploma_gpa', $info['applicant_education_diploma_gpa']); ?>" placeholder="เกรดเฉลี่ย" style="width:20%;" readonly />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls"><hr size="0" class="border-navy" /></div>
                </div>
                <?php /* Diploma - End */ ?>

                <?php /* Bachelor - Start */ ?>
                <div class="control-group">
                    <label class="control-label" for="applicant_education_bachelor_name">ปริญญาตรี</label>
                    <div class="controls d-flex">
                        <div class="col-12">
                            <input type="text" name="applicant_education_bachelor_name" id="applicant_education_bachelor_name" value="<?php echo set_value('applicant_education_bachelor_name', $info['applicant_education_bachelor_name']); ?>" placeholder="ชื่อสถาบัน" readonly style="width:84%;" />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls d-flex flex-wrap align-items-center">
                        <select name="applicant_education_bachelor_province_id" id="applicant_education_bachelor_province_id" class="select2" style="width:20%;" disabled>
                            <option value="0" <?php echo set_select('applicant_education_bachelor_province_id', 0, true); ?>>-- จังหวัด --</option>
                            <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                <?php foreach( $provinces as $province ): ?>
                                    <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_bachelor_province_id', $province['province_id'], $province['province_id'] == $info['applicant_education_bachelor_province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="text" name="applicant_education_bachelor_year" id="applicant_education_bachelor_year" value="<?php echo set_value('applicant_education_bachelor_year', $info['applicant_education_bachelor_year']); ?>" placeholder="ปีที่จบการศึกษา" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_bachelor_major" id="applicant_education_bachelor_major" value="<?php echo set_value('applicant_education_bachelor_major', $info['applicant_education_bachelor_major']); ?>" placeholder="วิชาเอก" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_bachelor_gpa" id="applicant_education_bachelor_gpa" value="<?php echo set_value('applicant_education_bachelor_gpa', $info['applicant_education_bachelor_gpa']); ?>" placeholder="เกรดเฉลี่ย" style="width:20%;" readonly />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls"><hr size="0" class="border-navy" /></div>
                </div>
                <?php /* Bachelor - End */ ?>

                <?php /* Master - Start */ ?>
                <div class="control-group">
                    <label class="control-label" for="applicant_education_master_name">ปริญญาโท</label>
                    <div class="controls d-flex">
                        <div class="col-12">
                            <input type="text" name="applicant_education_master_name" id="applicant_education_master_name" value="<?php echo set_value('applicant_education_master_name', $info['applicant_education_master_name']); ?>" placeholder="ชื่อสถาบัน" style="width:84%;" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls d-flex flex-wrap align-items-center">
                        <select name="applicant_education_master_province_id" id="applicant_education_master_province_id" class="select2" style="width:20%;" disabled>
                            <option value="0" <?php echo set_select('applicant_education_master_province_id', 0, true); ?>>-- จังหวัด --</option>
                            <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                <?php foreach( $provinces as $province ): ?>
                                    <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_master_province_id', $province['province_id'], $province['province_id'] == $info['applicant_education_master_province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="text" name="applicant_education_master_year" id="applicant_education_master_year" value="<?php echo set_value('applicant_education_master_year', $info['applicant_education_master_year']); ?>" placeholder="ปีที่จบการศึกษา" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_master_major" id="applicant_education_master_major" value="<?php echo set_value('applicant_education_master_major', $info['applicant_education_master_major']); ?>" placeholder="วิชาเอก" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_master_gpa" id="applicant_education_master_gpa" value="<?php echo set_value('applicant_education_master_gpa', $info['applicant_education_master_gpa']); ?>" placeholder="เกรดเฉลี่ย" style="width:20%;" readonly />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls"><hr size="0" class="border-navy" /></div>
                </div>
                <?php /* Master - End */ ?>

                <?php /* Other - Start */ ?>
                <div class="control-group">
                    <label class="control-label" for="applicant_education_other_name">อื่นๆ</label>
                    <div class="controls d-flex">
                        <div class="col-12">
                            <input type="text" name="applicant_education_other_name" id="applicant_education_other_name" value="<?php echo set_value('applicant_education_other_name', $info['applicant_education_other_name']); ?>" placeholder="ชื่อสถาบัน" style="width:84%;" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls d-flex flex-wrap align-items-center">
                        <select name="applicant_education_other_province_id" id="applicant_education_other_province_id" class="select2" style="width:20%;" disabled>
                            <option value="0" <?php echo set_select('applicant_education_other_province_id', 0, true); ?>>-- จังหวัด --</option>
                            <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                <?php foreach( $provinces as $province ): ?>
                                    <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_other_province_id', $province['province_id'], $province['province_id'] == $info['applicant_education_other_province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <input type="text" name="applicant_education_other_year" id="applicant_education_other_year" value="<?php echo set_value('applicant_education_other_year', $info['applicant_education_other_year']); ?>" placeholder="ปีที่จบการศึกษา" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_other_major" id="applicant_education_other_major" value="<?php echo set_value('applicant_education_other_major', $info['applicant_education_other_major']); ?>" placeholder="วิชาเอก" style="width:20%;" readonly />
                        <input type="text" name="applicant_education_other_gpa" id="applicant_education_other_gpa" value="<?php echo set_value('applicant_education_other_gpa', $info['applicant_education_other_gpa']); ?>" placeholder="เกรดเฉลี่ย" style="width:20%;" readonly />
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls"><hr size="0" class="border-navy" /></div>
                </div>
                <?php /* Other - End */ ?>
				
			</form>
		</div>
	</div>
</div>

<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-star"></i> ความสามารถอื่นๆ</h4>
			<span class="tools">
			    <a href="javascript:;" class="icon-chevron-down"></a>
			</span>							
		</div>
		<div class="widget-body form">
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				
                <div class="control-group">
                    <label class="control-label" for="applicant_skill_computer">ความรู้/ความสามารถเกี่ยวกับคอมพิวเตอร์</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <textarea name="applicant_skill_computer" id="applicant_skill_computer" rows="5" readonly style="resize:none;"><?php echo set_value('applicant_skill_computer', $info['applicant_skill_computer']); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_skill_typing_thai">อัตราพิมพ์ดีด ภาษาไทย</label>
                    <div class="controls d-flex align-items-center">
                        <input type="number" name="applicant_skill_typing_thai" id="applicant_skill_typing_thai" value="<?php echo set_value('applicant_skill_typing_thai', $info['applicant_skill_typing_thai']); ?>" step="1" min="0" max="999" readonly />
                        <span class="help-inline ml-3">คำ/นาที</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_skill_typing_english">อัตราพิมพ์ดีด ภาษาอังกฤษ</label>
                    <div class="controls d-flex align-items-center">
                        <input type="number" name="applicant_skill_typing_english" id="applicant_skill_typing_english" value="<?php echo set_value('applicant_skill_typing_english', $info['applicant_skill_typing_english']); ?>" step="1" min="0" max="999" readonly />
                        <span class="help-inline ml-3">คำ/นาที</span>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_skill_office_tools">สามารถใช้เครื่องใช้สำนักงานอะไรได้บ้าง</label>
                    <div class="controls d-flex">
                        <textarea name="applicant_skill_office_tools" id="applicant_skill_office_tools" rows="5" readonly style="resize:none;"><?php echo set_value('applicant_skill_office_tools', $info['applicant_skill_office_tools']); ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_skill_specials">ความรู้/ความสามารถพิเศษ</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <textarea name="applicant_skill_specials" id="applicant_skill_specials" rows="5" readonly style="resize:none;"><?php echo set_value('applicant_skill_specials', $info['applicant_skill_specials']); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="applicant_skill_activities">กิจกรรมระหว่างการศึกษา</label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <textarea name="applicant_skill_activities" id="applicant_skill_activities" rows="5" readonly style="resize:none;"><?php echo set_value('appicant_skill_activities', $info['applicant_skill_activities']); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">ความสามารถในการขับขี่ยานพาหนะ</label>
                    <div class="controls d-flex flex-wrap">
                        <p class="col-12 d-flex align-items-center mb-3"><input type="checkbox" name="applicant_skill_driving_status" id="applicant_skill_driving_status" value="1" <?php echo set_checkbox('applicant_skill_driving_status', 1, $info['applicant_skill_driving_status'] == 1); ?> class="mr-3" disabled /> ข้าพเจ้าสามารถขับรถยนต์ได้ <input type="text" name="applicant_skill_driving_license" id="applicant_skill_driving_license" value="<?php echo set_value('applicant_skill_driving_license', $info['applicant_skill_driving_license']); ?>" placeholder="เลขที่ใบอนุญาตขับขี่" readonly /></p>
                        <p class="col-12 d-flex align-items-center"><input type="checkbox" name="applicant_skill_riding_status" id="applicant_skill_riding_status" value="1" <?php echo set_checkbox('applicant_skill_riding_status', 1, $info['applicant_skill_riding_status'] == 1); ?> class="mr-3" disabled /> ข้าพเจ้าสามารถขับขี่มอเตอร์ไซค์ได้ <input type="text" name="applicant_skill_riding_license" id="applicant_skill_riding_license" value="<?php echo set_value('applicant_skill_riding_license', $info['applicant_skill_riding_license']); ?>" placeholder="เลขที่ใบอนุญาตขับขี่" class="col-4 ml-3" readonly /></p>
                    </div>
                </div>
				
			</form>
		</div>
	</div>
</div>

<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-flag"></i> ความสามารถด้านภาษา</h4>
			<span class="tools">
			    <a href="javascript:;" class="icon-chevron-down"></a>
			</span>							
		</div>
		<div class="widget-body form">
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				<?php $languages = $this->applicantsreportmodel->get_languages( $info['applicant_id'] ); ?>
                <?php if( isset( $languages ) && count( $languages ) > 0 ): ?>
                    <?php foreach( $languages as $language ): ?>
                        <div class="language-skill-item control-group pb-3">
                            <div class="controls d-flex flex-wrap">
                                <input type="text" name="applicant_skill_languages[name][]" value="<?php echo set_value('applicant_skill_languages[name][]', $language['language_name']); ?>" placeholder="กรุณาระบุภาษา" style="width:80%; margin-bottom:1rem;" readonly />
                                <select name="applicant_skill_languages[listen][]" style="width:20%;" disabled>
                                    <option value="0" <?php echo set_select('applicant_skill_languages[listen][]',0, $language['language_listen'] == 0 || $language['language_listen'] == null ); ?>>-- เลือกระดับการฟัง --</option>
                                    <option value="great" <?php echo set_select('applicant_skill_languages[listen][]', 'great', $language['language_listen'] == 'great'); ?>>ดีมาก</option>
                                    <option value="good" <?php echo set_select('applicant_skill_languages[listen][]', 'good', $language['language_listen'] == 'good'); ?>>ดี</option>
                                    <option value="moderate" <?php echo set_select('applicant_skill_languages[listen][]', 'moderate', $language['language_listen'] == 'moderate'); ?>>พอใช้</option>
                                </select>
                                <select name="applicant_skill_languages[speaking][]" style="width:20%;" disabled>
                                    <option value="0" <?php echo set_select('applicant_skill_languages[speaking][]',0, $language['language_speaking'] == 0 || $language['language_speaking'] == null ); ?>>-- เลือกระดับการพูด --</option>
                                    <option value="great" <?php echo set_select('applicant_skill_languages[speaking][]', 'great', $language['language_speaking'] == 'great'); ?>>ดีมาก</option>
                                    <option value="good" <?php echo set_select('applicant_skill_languages[speaking][]', 'good', $language['language_speaking'] == 'good'); ?>>ดี</option>
                                    <option value="moderate" <?php echo set_select('applicant_skill_languages[speaking][]', 'moderate', $language['language_speaking'] == 'moderate'); ?>>พอใช้</option>
                                </select>
                                <select name="applicant_skill_languages[reading][]" style="width:20%;" disabled>
                                    <option value="0" <?php echo set_select('applicant_skill_languages[reading][]',0, $language['language_reading'] == 0 || $language['language_reading'] == null ); ?>>-- เลือกระดับการอ่าน --</option>
                                    <option value="great" <?php echo set_select('applicant_skill_languages[reading][]', 'great', $language['language_reading'] == 'great'); ?>>ดีมาก</option>
                                    <option value="good" <?php echo set_select('applicant_skill_languages[reading][]', 'good', $language['language_reading'] == 'good'); ?>>ดี</option>
                                    <option value="moderate" <?php echo set_select('applicant_skill_languages[reading][]', 'moderate', $language['language_reading'] == 'moderate'); ?>>พอใช้</option>
                                </select>
                                <select name="applicant_skill_languages[writing][]" style="width:20%;" disabled>
                                    <option value="0" <?php echo set_select('applicant_skill_languages[writing][]',0, $language['language_writing'] == 0 || $language['language_writing'] == null ); ?>>-- เลือกระดับการเขียน --</option>
                                    <option value="great" <?php echo set_select('applicant_skill_languages[writing][]', 'great', $language['language_writing'] == 'great'); ?>>ดีมาก</option>
                                    <option value="good" <?php echo set_select('applicant_skill_languages[writing][]', 'good', $language['language_writing'] == 'good'); ?>>ดี</option>
                                    <option value="moderate" <?php echo set_select('applicant_skill_languages[writing][]', 'moderate', $language['language_writing'] == 'moderate'); ?>>พอใช้</option>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
				
			</form>
		</div>
	</div>
</div>

<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-road"></i> ประวัติการทำงาน</h4>
			<span class="tools">
			    <a href="javascript:;" class="icon-chevron-down"></a>
			</span>							
		</div>
		<div class="widget-body form">
			<form method="post" enctype="multipart/form-data" class="form-horizontal">
				
                <div class="control-group">
                    <label class="control-label" for="applicant_experienced_status">คุณเคยมีประสบการณ์การทำงานมาก่อนหรือไม่?</label>
                    <div class="controls">
                        <label class="px-3"><input type="checkbox" name="applicant_experienced_status" id="applicant_experienced_status" value="1" <?php echo set_checkbox('applicant_experienced_status', 1, $info['applicant_experienced_status'] == 1); ?> disabled /> ใช่</label>
                    </div>
                </div>
                
                <?php $experiences = $this->applicantsreportmodel->get_experiences( $info['applicant_id'] ); ?>
                <?php if( isset( $experiences ) && count( $experiences ) > 0 ): ?>
                    <div id="experiences" style="margin-bottom:1rem;">
                        
                        <?php foreach( $experiences as $key => $experience ): ?>
                            <?php $i = intval( $key + 1 ); ?>
                            <div class="experience-item px-3 my-3 position-relative" style="margin:1rem 0;">
                                <a href="#experience-item-<?php echo $i; ?>" data-toggle="collapse" role="button" aria-expended="<?php echo ( $i == 1 ? true : false ); ?>" aria-controls="experience-<?php echo $i; ?>" class="btn btn-navy w-100" style="width:100%;">
                                    บริษัท <span class="number"><?php echo $i; ?></span>
                                </a>
                                <div class="collapse <?php echo ( $i == 1 ? 'show in' : '' ); ?>" id="experience-item-<?php echo $i; ?>" data-parent="#experiences" style="margin-top:1rem;">

                                    <div class="control-group">
                                        <label class="control-label">ชื่อบริษัท</label>
                                        <div class="controls d-flex">
                                            <input type="text" name="applicant_experiences[company_name][]" value="<?php echo set_value('applicant_experiences[company_name][]', $experience['experience_company_name']); ?>" readonly />
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">ที่อยู่</label>
                                        <div class="controls d-flex">
                                            <textarea name="applicant_experiences[company_address][]" rows="5" readonly><?php echo set_value('applicant_experiences[company_address][]', $experience['experience_company_address']); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">เบอร์โทรศัพท์</label>
                                        <div class="controls d-flex">
                                            <input type="tel" name="applicant_experiences[company_tel][]" value="<?php echo set_value('applicant_experiences[company_tel][]', $experience['experience_company_tel']); ?>" readonly />
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">ช่วงเวลา</label>
                                        <div class="controls d-flex align-items-center">
                                            <div class="col-4">
                                                <input type="text" name="applicant_experiences[start][]" value="<?php echo set_value('applicant_experiences[start][]', thai_convert_shortdate( $experience['experience_start'] )); ?>" placeholder="เริ่มต้น" readonly />
                                            </div>
                                            <span class="col-1 text-center">ถึง</span>
                                            <div class="col-4">
                                                <input type="text" name="applicant_experiences[end][]" value="<?php echo set_value('applicant_experiences[end][]', thai_convert_shortdate( $experience['experience_end'] )); ?>" placeholder="สิ้นสุด" readonly />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">ชื่อผู้บังคับบัญชา/ตำแหน่ง</label>
                                        <div class="controls d-flex">
                                            <input type="text" name="applicant_experiences[superior][]" value="<?php echo set_value('applicant_experiences[superior][]', $experience['experience_superior']); ?>" readonly />
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">หน้าที่ความรับผิดชอบ</label>
                                        <div class="controls d-flex">
                                            <textarea name="applicant_experiences[responsibility][]" rows="5" readonly style="resize:none;"><?php echo set_value('applicant_experiences[responsibility][]', $experience['experience_job_description']); ?></textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">เงินเดือน</label>
                                        <div class="controls d-flex align-items-center">
                                            <input type="text" name="applicant_experiences[salary][]" value="<?php echo set_value('applicant_experiences[salary][]', number_format($experience['experience_salary'])); ?>" step="1" min="0" max="9999999" readonly />
                                            <span class="help-inline">บาท</span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">ค่าครองชีพ</label>
                                        <div class="controls d-flex align-items-center">
                                            <input type="text" name="applicant_experiences[cost_of_living][]" value="<?php echo set_value('applicant_experiences[cost_of_living][]', number_format($experience['experience_cost_of_living'])); ?>" step="1" min="0" max="99999" readonly />
                                            <span class="help-inline">บาท</span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">โบนัส/เดือน</label>
                                        <div class="controls d-flex align-items-center">
                                            <input type="text" name="applicant_experiences[bonus][]" value="<?php echo set_value('applicant_experiences[bonus][]', number_format($experience['experience_bonus'])); ?>" step="1" min="0" max="99999" readonly />
                                            <span class="help-inline">บาท</span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">รายได้อื่นๆ</label>
                                        <div class="controls d-flex align-items-center">
                                            <input type="text" name="applicant_experiences[other][]" value="<?php echo set_value('applicant_experiences[other][]', number_format($experience['experience_other'])); ?>" step="1" min="0" max="99999" readonly />
                                            <span class="help-inline">บาท</span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">รวม</label>
                                        <div class="controls d-flex align-items-center">
                                            <input type="text" name="applicant_experiences[total][]" value="<?php echo set_value('applicant_experiences[total][]', number_format($experience['experience_total'])); ?>" readonly />
                                            <span class="help-inline">บาท</span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">เหตุผลในการลาออก</label>
                                        <div class="controls d-flex align-items-center">
                                            <textarea name="applicant_experiences[reason][]" rows="5" style="resize:none;" readonly><?php echo set_value('applicant_experiences[reason][]', $experience['experience_reason']); ?></textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                <?php endif; ?>

                <div class="control-group">
                    <label class="control-label" for="applicant_introduction">กรุณาแนะนำตัวท่านเองเพื่อให้บริษัทรู้จักตัวท่านดีขึ้น</label>
                    <div class="controls d-flex">
                        <div class="col-12">
                            <textarea name="applicant_introduction" id="applicant_introduction" rows="5" style="resize:none;" readonly><?php echo set_value('applicant_introduction', $info['applicant_introduction']); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">ไฟล์</label>
                    <div class="controls d-flex">
                        <div class="col-12">
                            <?php if( $info['applicant_file_1'] != '' && is_file( realpath('public/core/uploaded/applicants/'.$info['applicant_file_1']) ) === true ): ?>
                                <p style="margin-bottom:1rem;">
                                    <a href="<?php echo base_url('public/core/uploaded/applicants/'.$info['applicant_file_1']); ?>" target="_blank">Download</a>
                                </p>
                            <?php endif; ?>
                            <?php if( $info['applicant_file_2'] != '' && is_file( realpath('public/core/uploaded/applicants/'.$info['applicant_file_2']) ) === true ): ?>
                                <p style="margin-bottom:1rem;">
                                    <a href="<?php echo base_url('public/core/uploaded/applicants/'.$info['applicant_file_2']); ?>" target="_blank">Download</a>
                                </p>
                            <?php endif; ?>
                            <?php if( $info['applicant_file_3'] != '' && is_file( realpath('public/core/uploaded/applicants/'.$info['applicant_file_3']) ) === true ): ?>
                                <p style="margin-bottom:1rem;">
                                    <a href="<?php echo base_url('public/core/uploaded/applicants/'.$info['applicant_file_3']); ?>" target="_blank">Download</a>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
				
			</form>
		</div>
	</div>
</div>

<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-body form">
				
				<div class="form-actions" style="text-align:center;">
				 	<a class="btn btn-primary" href="<?php echo admin_url("applicantsreport/index"); ?>"><i class="icon-reply"></i> Back</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
var base_url = '<?php echo admin_url('applicantsreport'); ?>';
var language = '<?php echo $this->_language; ?>';
$(document).ready(function(){

    /* .select2 - Start */
    $('.select2').select2();
    /* .select2 - End */

    /* #location_id handler - Start */
    $('body').on('change', '#location_id', function(){
        if( $(this).val() != '' ){
            var datas = {
                'location_id' : $(this).val()
            };
            $.ajax({
                type : 'POST',
                url : base_url+'/'+language+'/jobs/api/jobs',
                data : datas
            }).done( function( response ){
                var res = response.data.response;
                if( res.status == 200 ){
                    options = $.map(res.datas, function(item){
                        return '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#job_id').find('option')
                        .remove()
                        .end()
                        .append( '<option value="">-- '+( language == 'en' ? 'Choose, position' : 'เลือกตำแหน่ง' )+' --</option>')
                        .append( options );
                    $('#job_id').select2();
                }
            });
        }
    });
    /* #location_id handler - End */

    /* #prefix_id handler - Start */
    $('body').on('change', '#prefix_id', function(){
        if( $(this).val() == 999 ){
            $('#prefix_other_box').removeClass('d-none');
        }else{
            $('#prefix_other_box').addClass('d-none');
        }
    });
    /* #prefix_id handler - End */

    /* #applicant_current_province_id handler - Start */
    $('body').on('change', '#applicant_current_province_id', function(){
        if( $(this).val() != '' ){
            var datas = {
                'province_id' : $(this).val()
            };
            $.ajax({
                type : 'POST',
                url : base_url+'/'+language+'/jobs/api/districts',
                data : datas
            }).done( function( response ){
                var res = response.data.response;
                if( res.status == 200 ){
                    options = $.map(res.datas, function(item){
                        return '<option value="'+item.id+'">'+item.name+'</option>';
                    })
                    $('#applicant_current_district_id').find('option')
                        .remove()
                        .end()
                        .append( ( language == 'en' ? '<option value="">-- Choose, district --</option>' : '<option value="">-- เลือกเขต/อำเภอ --</option>' ) )
                        .append( options );
                    $('#applicant_current_district_id').select2();
                }
            });
        }
    });
    /* #applicant_current_province_id handler - End */

    /* #applicant_current_district_id handler - Start */
    $('body').on('change','#applicant_current_district_id', function(){
        if( $(this).val() != '' ){
            var datas = {
                'district_id' : $(this).val()
            };
            $.ajax({
                type : 'POST',
                url : base_url+'/'+language+'/jobs/api/subdistricts',
                data : datas
            }).done( function( response ){
                var res = response.data.response;
                if( res.status == 200 ){
                    options = $.map(res.datas, function( item ){
                        return '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#applicant_current_subdistrict_id').find('option')
                        .remove()
                        .end()
                        .append( ( language == 'en' ? '<option value="">-- Choose, sub district --</option>' : '<option value="">-- เลือกแขวง/ตำบล --</option>' ) )
                        .append( options );
                    $('#applicant_current_subdistrict_id').select2();
                }
            })
        }
    });
    /* #applicant_current_district_id handler - End */

    /* #applicant_current_subdistrict_id handler - Start */
    $('body').on('change','#applicant_current_subdistrict_id', function(){
        if( $(this).val() != '' ){
            var datas = {
                'subdistrict_id' : $(this).val()
            };
            $.ajax({
                type : 'POST',
                url : base_url+'/'+language+'/jobs/api/zipcodes',
                data : datas
            }).done( function( response ){
                var res = response.data.response;
                if( res.status == 200 ){
                    options = $.map(res.datas, function( item ){
                        return '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#applicant_current_postcode_id').find('option')
                        .remove()
                        .end()
                        .append( options );
                    $('#applicant_current_postcode_id').select2();
                }
            })
        }
    })
    /* #applicant_current_subdistrict_id handler - End */

    /* #applicant_register_same_address handler - Start */
    $('body').on('change', '#applicant_register_same_address', function(){
        if( $(this).prop('checked') === true ){
            $('#different_address').slideUp('fast');
        }else{
            $('#different_address').slideDown('fast');
        }
    });
    /* #applicant_register_same_address handler - End */

    /* #applicant_register_province_id handler - Start */
    $('body').on('change', '#applicant_register_province_id', function(){
        if( $(this).val() != '' ){
            var datas = {
                'province_id' : $(this).val()
            };
            $.ajax({
                type : 'POST',
                url : base_url+'/'+language+'/jobs/api/districts',
                data : datas
            }).done( function( response ){
                var res = response.data.response;
                if( res.status == 200 ){
                    options = $.map(res.datas, function(item){
                        return '<option value="'+item.id+'">'+item.name+'</option>';
                    })
                    $('#applicant_register_district_id').find('option')
                        .remove()
                        .end()
                        .append( ( language == 'en' ? '<option value="">-- Choose, district --</option>' : '<option value="">-- เลือกเขต/อำเภอ --</option>' ) )
                        .append( options );
                    $('#applicant_register_district_id').select2();
                }
            });
        }
    });
    /* #applicant_register_province_id handler - End */

    /* #applicant_register_district_id handler - Start */
    $('body').on('change','#applicant_register_district_id', function(){
        if( $(this).val() != '' ){
            var datas = {
                'district_id' : $(this).val()
            };
            $.ajax({
                type : 'POST',
                url : base_url+'/'+language+'/jobs/api/subdistricts',
                data : datas
            }).done( function( response ){
                var res = response.data.response;
                if( res.status == 200 ){
                    options = $.map(res.datas, function( item ){
                        return '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#applicant_register_subdistrict_id').find('option')
                        .remove()
                        .end()
                        .append( ( language == 'en' ? '<option value="">-- Choose, sub district --</option>' : '<option value="">-- เลือกแขวง/ตำบล --</option>' ) )
                        .append( options );
                    $('#applicant_register_subdistrict_id').select2();
                }
            })
        }
    });
    /* #applicant_register_district_id handler - End */

    /* #applicant_register_subdistrict_id handler - Start */
    $('body').on('change','#applicant_register_subdistrict_id', function(){
        if( $(this).val() != '' ){
            var datas = {
                'subdistrict_id' : $(this).val()
            };
            $.ajax({
                type : 'POST',
                url : base_url+'/'+language+'/jobs/api/zipcodes',
                data : datas
            }).done( function( response ){
                var res = response.data.response;
                if( res.status == 200 ){
                    options = $.map(res.datas, function( item ){
                        return '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                    $('#applicant_register_postcode_id').find('option')
                        .remove()
                        .end()
                        .append( options );
                    $('#applicant_register_postcode_id').select2();
                }
            })
        }
    })
    /* #applicant_register_subdistrict_id handler - End */

});
</script>