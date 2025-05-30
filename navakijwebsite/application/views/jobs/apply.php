<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey">
    <div class="container px-0">
        <h3 class="section-title text-center navy">ร่วมงานกับเรา</h3>
        <div class="d-flex flex-wrap">
            <?php print_r( validation_errors() ); ?>
            <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
                <p>
                    <a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
                    <a href="<?php echo site_url('job-vacancy'); ?>" class="btn-text navy">ร่วมงานกับเรา</a>
                    <a href="<?php echo site_url('job-applicant'); ?>" class="btn-text navy">สมัครงานออนไลน์</a>
                </p>
            </div>

            <div id="steps" class="w-100 text-center">
                <ul class="list-inline">
                    <li class="list-inline-item active">
                        <a href="javascript:void(0);" class="btnStep" data-targetStep="1">
                            <div class="number d-flex align-items-center justify-content-center"><span>1</span></div>
                            <p class="text-center mt-2 navy"><?php echo $this->lang->line('Personal Information'); ?></p>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:void(0);" class="btnStep" data-targetStep="2">
                            <div class="number d-flex align-items-center justify-content-center"><span>2</span></div>
                            <p class="text-center mt-2 navy"><?php echo $this->lang->line('Education history'); ?></p>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript:void(0);" class="btnStep" data-targetStep="3">
                            <div class="number d-flex align-items-center justify-content-center"><span>3</span></div>
                            <p class="text-center mt-2 navy"><?php echo $this->lang->line('Career history'); ?></p>
                        </a>
                    </li>
                </ul>
            </div>

            <form id="applicantForm" name="applicantForm" method="post" enctype="multipart/form-data" action="" class="form col-12 col-md-10 col-lg-8 mx-auto">

                <?php /* .step-item.step-1 - Start */ ?>
                <div class="step-item step-1 active">

                    <div class="wrapper border border-1px border-navy pb-3">

                        <h3 class="bg-navy p-3 white"><?php echo $this->lang->line('Job position detail'); ?></h3>

                        <div class="control-group">
                            <label class="control-label" for="location_id"><?php echo $this->lang->line('Expected area'); ?></label>
                            <div class="controls col-12 col-lg-8 px-0 d-flex">
                                <select name="location_id" id="location_id" class="select2">
                                    <option value="0" <?php echo set_select('location_id',0, true); ?>>-- <?php echo $this->lang->line('Choose expected area'); ?> --</option>
                                    <?php if( isset( $locations ) && count( $locations ) > 0 ): ?>
                                        <?php foreach( $locations as $location ): ?>
                                            <option value="<?php echo $location['location_id']; ?>" <?php echo set_select('location_id', $location['location_id'], $location['location_id'] == @$jobInfo['location_id']); ?>><?php echo $location['location_title_'.$this->_language]; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="job_id"><?php echo $this->lang->line('Position'); ?></label>
                            <div class="controls col-12 col-lg-8 px-0 d-flex">
                                <select name="job_id" id="job_id" class="select2">
                                    <option value="0" <?php echo set_select('job_id',0, true); ?>>-- <?php echo $this->lang->line('Choose position'); ?> --</option>
                                    <?php if( isset( $positions ) && count( $positions ) > 0 ): ?>
                                        <?php foreach( $positions as $position ): ?>
                                            <option value="<?php echo $position['job_id']; ?>" <?php echo set_select('job_id', $position['job_id'], $position['job_id'] == @$jobInfo['job_id']); ?>><?php echo $position['job_title_'.$this->_language]; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_salary"><?php echo $this->lang->line('Salary'); ?></label>
                            <div class="controls d-flex align-items-center">
                                <input type="text" name="applicant_salary" id="applicant_salary" value="<?php echo set_value('applicant_salary'); ?>" placeholder="<?php echo $this->lang->line('Baht'); ?>" class="col-8" />
                                <span class="help-inline ml-3"><?php echo $this->lang->line('Baht'); ?></span>
                            </div>
                        </div>

                    </div>

                    <div class="wrapper border border-1px border-navy pb-3">

                        <h3 class="bg-navy p-3 white"><?php echo $this->lang->line('Personal History'); ?></h3>

                        <div class="control-group">
                            <label class="control-label" for="prefix_id"><?php echo $this->lang->line('Prefix'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-4 mb-3 mb-lg-0">
                                    <select name="prefix_id" id="prefix_id" class="select2">
                                        <option value="0" <?php echo set_select('prefix_id',0, true); ?>>-- <?php echo $this->lang->line('Choose, prefix'); ?>
                                        <?php if( isset( $prefixes ) && count( $prefixes ) > 0 ): ?>
                                            <?php foreach( $prefixes as $prefix ): ?>
                                                <option value="<?php echo $prefix['prefix_id']; ?>" <?php echo set_select('prefix_id', $prefix['prefix_id']); ?>><?php echo $prefix['prefix_title_'.$this->_language]; ?></option>
                                            <?php endforeach; ?>
                                            <option value="999" <?php echo set_select('prefix_id', 999); ?>><?php echo $this->lang->line('Prefix Other'); ?></option>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div id="prefix_other_box" class="col-12 px-0 col-lg-4 d-none">
                                    <input type="text" name="prefix_other" id="prefix_other" value="<?php echo set_value('prefix_other'); ?>" placeholder="<?php echo $this->lang->line('Prefix Other'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_fname_th"><?php echo $this->lang->line('Fullname (Thai)'); ?><span class="symbol required"></span></label>
                            <div class="controls d-flex flex-wrap">
                                <div class="col-12 px-0 pr-lg-3 col-lg-6 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_fname_th" id="applicant_fname_th" value="<?php echo set_value('applicant_fname_th'); ?>" placeholder="<?php echo $this->lang->line('First name TH'); ?>" class="required" />
                                </div>
                                <div class="col-12 px-0 pl-lg-3 col-lg-6">
                                    <input type="text" name="applicant_lname_th" id="applicant_lname_th" value="<?php echo set_value('applicant_lname_th'); ?>" placeholder="<?php echo $this->lang->line('Last name TH'); ?>" class="required" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_fname_en"><?php echo $this->lang->line('Fullname (English)'); ?><span class="symbol required"></span></label>
                            <div class="controls d-flex flex-wrap">
                                <div class="col-12 px-0 pr-lg-3 col-lg-6 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_fname_en" id="applicant_fname_en" value="<?php echo set_value('applicant_fname_en'); ?>" placeholder="<?php echo $this->lang->line('First name EN'); ?>" class="required" />
                                </div>
                                <div class="col-12 px-0 pl-lg-3 col-lg-6">
                                    <input type="text" name="applicant_lname_en" id="applicant_lname_en" value="<?php echo set_value('applicant_lname_en'); ?>" placeholder="<?php echo $this->lang->line('Last name EN'); ?>" class="required" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_birthdate"><?php echo $this->lang->line('Date of birth'); ?></label>
                            <div class="controls d-flex">
                                <div class="icon-append position-relative col-12 px-0 col-lg-4">
                                    <i class="fas fa-calendar-o grey position-absolute"></i>
                                    <input type="text" name="applicant_birthdate" id="applicant_birthdate" value="<?php echo set_value('applicant_birthdate'); ?>" class="date-picker" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_idcard"><?php echo $this->lang->line('Identity Card No.'); ?><span class="symbol required"></span></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <input type="text" name="applicant_idcard" id="applicant_idcard" value="<?php echo set_value('applicant_idcard'); ?>" class="required validate_number_only" maxlength="13" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_idcard_expired"><?php echo $this->lang->line('Date of expiry'); ?></label>
                            <div class="controls d-flex">
                                <div class="icon-append position-relative col-12 px-0 col-lg-4">
                                    <i class="fas fa-calendar-o grey position-absolute"></i>
                                    <input type="text" name="applicant_idcard_expired" id="applicant_idcard_expired" value="<?php echo set_value('applicant_idcard_expired'); ?>" class="date-picker" readonly />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_height"><?php echo $this->lang->line('Height'); ?></label>
                            <div class="controls d-flex align-items-center">
                                <div class="col-10 px-0 col-lg-3">
                                    <input type="number" name="applicant_height" id="applicant_height" value="<?php echo set_value('applicant_height'); ?>" min="0" max="999" step="1" />
                                </div>
                                <span class="help-inline ml-1 ml-lg-3"><?php echo $this->lang->line('Cm.'); ?></span>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_weight"><?php echo $this->lang->line('Weight'); ?></label>
                            <div class="controls d-flex align-items-center">
                                <div class="col-10 px-0 col-lg-3">
                                    <input type="number" name="applicant_weight" id="applicant_weight" value="<?php echo set_value('applicant_weight'); ?>" min="0" max="9999" step="1" />
                                </div>
                                <span class="help-inline ml-1 ml-lg-3"><?php echo $this->lang->line('Kg.'); ?></span>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_military_status"><?php echo $this->lang->line('Military Status'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <select name="applicant_military_status" id="applicant_military_status" class="select2">
                                        <option value="0" <?php echo set_select('applicant_military_status',0, true); ?>>-- <?php echo $this->lang->line('Choose, military status'); ?> --</option>
                                        <option value="serving" <?php echo set_select('applicant_military_status', 'serving'); ?>><?php echo $this->lang->line('Serving'); ?></option>
                                        <option value="completed" <?php echo set_select('applicant_military_status', 'completed'); ?>><?php echo $this->lang->line('Completed'); ?></option>
                                        <option value="exempted" <?php echo set_select('applicant_military_status', 'exempted'); ?>><?php echo $this->lang->line('Exempted'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="wrapper border border-1px border-navy pb-3">

                        <h3 class="bg-navy p-3 white"><?php echo $this->lang->line('Present Address'); ?></h3>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_address_no"><?php echo $this->lang->line('Address No.'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <input type="text" name="applicant_current_address_no" id="applicant_current_address_no" value="<?php echo set_value('applicant_current_address_no'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_village"><?php echo $this->lang->line('Village/Bldg.'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <input type="text" name="applicant_current_village" id="applicant_current_village" value="<?php echo set_value('applicant_current_village'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_avenue"><?php echo $this->lang->line('Soi'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <input type="text" name="applicant_current_avenue" id="applicant_current_avenue" value="<?php echo set_value('applicant_current_avenue'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_road"><?php echo $this->lang->line('Road'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <input type="text" name="applicant_current_road" id="applicant_current_road" value="<?php echo set_value('applicant_current_road'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_province_id"><?php echo $this->lang->line('Province'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <select name="applicant_current_province_id" id="applicant_current_province_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_current_province_id',0, true); ?>>-- <?php echo $this->lang->line('Choose Province'); ?> --</option>
                                        <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                            <?php foreach( $provinces as $province ): ?>
                                                <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_current_province_id', $province['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_district_id"><?php echo $this->lang->line('District'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <select name="applicant_current_district_id" id="applicant_current_district_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_current_district_id', '', true); ?>>-- <?php echo $this->lang->line('Choose District'); ?> --</option>
                                        <?php $districts = $this->jobsmodel->get_districts( $this->input->post('applicant_current_province_id') ); ?>
                                        <?php if( isset( $districts ) && count( $districts ) > 0 ): ?>
                                            <?php foreach( $districts as $district ): ?>
                                                <option value="<?php echo $district['amphoe_id']; ?>" <?php echo set_select('applicant_current_district_id;', $district['amphoe_id']); ?>><?php echo ( $this->_language == 'th' ? $district['name'] : $district['name_alt'] ); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_subdistrict_id"><?php echo $this->lang->line('Sub District'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <select name="applicant_current_subdistrict_id" id="applicant_current_subdistrict_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_current_subdistrict_id', '', true); ?>>-- <?php echo $this->lang->line('Choose sub district'); ?> -- </option>
                                        <?php $subdistricts = $this->jobsmodel->get_subdistricts( $this->input->post('applicant_current_subdistrict_id') ); ?>
                                        <?php if( isset( $subdistricts ) && count( $subdistricts ) > 0 ): ?>
                                            <?php foreach( $subdistricts as $subdistrict ): ?>
                                                <option value="<?php echo $subdistrict['tambon_id']; ?>" <?php echo set_select('applicant_current_subdistrict_id', $subdistrict['tambon_id']); ?>><?php echo ( $this->_language == 'th' ? $subdistrict['name'] : $subdistrict['name_alt'] ); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_postcode_id"><?php echo $this->lang->line('Postcode'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <select name="applicant_current_postcode_id" id="applicant_current_postcode_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_current_postcode_id', '', true); ?>>-- <?php echo $this->lang->line('Postcode'); ?> --</option>
                                        <?php $postcodes = $this->jobsmodel->get_zipcodes( $this->input->post('applicant_current_subdistrict_id') ); ?>
                                        <?php if( isset( $postcodes ) && count( $postcodes ) > 0 ): ?>
                                            <?php foreach( $postcodes as $postcode ): ?>
                                                <option value="<?php echo $postcode['postcode_id']; ?>" <?php echo set_select('applicant_current_postcode_id', $postcode['postcode_id']); ?>><?php echo $postcode['postcode']; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_telephone"><?php echo $this->lang->line('Telephone'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <input type="tel" name="applicant_current_telephone" id="applicant_current_telephone" value="<?php echo set_value('applicant_current_telephone'); ?>" maxlength="10" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_mobile"><?php echo $this->lang->line('Mobile Phone'); ?><span class="symbol required"></span></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <input type="tel" name="applicant_current_mobile" id="applicant_current_mobile" value="<?php echo set_value('applicant_current_mobile'); ?>" class="required validate_mobile" maxlength="10" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_current_email"><?php echo $this->lang->line('Email'); ?><span class="symbol required"></span></label>
                            <div class="controls">
                                <div class="col-12 px-0 col-lg-8">
                                    <input type="email" name="applicant_current_email" id="applicant_current_email" value="<?php echo set_value('applicant_current_email'); ?>" class="required validate_email" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="wrapper border border-1px border-navy pb-3">
                        
                        <h3 class="bg-navy p-3 white"><?php echo $this->lang->line('Address as in housing register'); ?></h3>

                        <div class="control-group">
                            <label class="control-label" for="applicant_register_same_address">
                                <input type="checkbox" name="applicant_register_same_address" id="applicant_register_same_address" value="1" <?php echo set_checkbox('applicant_register_same_address', 1, true); ?> /> <?php echo $this->lang->line('Use same as present address'); ?>
                            </label>
                        </div>
                        
                        <div id="different_address" style="display:none;">

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_address_no"><?php echo $this->lang->line('Address No.'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <input type="text" name="applicant_register_address_no" id="applicant_register_address_no" value="<?php echo set_value('applicant_register_address_no'); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_village"><?php echo $this->lang->line('Village/Bldg.'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <input type="text" name="applicant_register_village" id="applicant_register_village" value="<?php echo set_value('applicant_register_village'); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_avenue"><?php echo $this->lang->line('Soi'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <input type="text" name="applicant_register_avenue" id="applicant_register_avenue" value="<?php echo set_value('applicant_register_avenue'); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_road"><?php echo $this->lang->line('Road'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <input type="text" name="applicant_register_road" id="applicant_register_road" value="<?php echo set_value('applicant_register_road'); ?>" />
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_province_id"><?php echo $this->lang->line('Provicne'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <select name="applicant_register_province_id" id="applicant_register_province_id" class="select2">
                                            <option value="0" <?php echo set_select('applicant_register_province_id',0, true); ?>>-- <?php echo $this->lang->line('Choose Province'); ?> --</option>
                                            <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                                <?php foreach( $provinces as $province ): ?>
                                                    <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_register_province_id', $province['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_district_id"><?php echo $this->lang->line('District'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <select name="applicant_register_district_id" id="applicant_register_district_id" class="select2">
                                            <option value="0" <?php echo set_select('applicant_register_district_id', '', true); ?>>-- <?php echo $this->lang->line('Choose District'); ?> --</option>
                                            <?php $districts = $this->jobsmodel->get_districts( $this->input->post('applicant_register_province_id') ); ?>
                                            <?php if( isset( $districts ) && count( $districts ) > 0 ): ?>
                                                <?php foreach( $districts as $district ): ?>
                                                    <option value="<?php echo $district['amphoe_id']; ?>" <?php echo set_select('applicant_register_district_id;', $district['amphoe_id']); ?>><?php echo ( $this->_language == 'th' ? $district['name'] : $district['name_alt'] ); ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_subdistrict_id"><?php echo $this->lang->line('Sub District'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <select name="applicant_register_subdistrict_id" id="applicant_register_subdistrict_id" class="select2">
                                            <option value="0" <?php echo set_select('applicant_register_subdistrict_id', '', true); ?>>-- <?php echo $this->lang->line('Choose sub district'); ?>-- </option>
                                            <?php $subdistricts = $this->jobsmodel->get_subdistricts( $this->input->post('applicant_register_subdistrict_id') ); ?>
                                            <?php if( isset( $subdistricts ) && count( $subdistricts ) > 0 ): ?>
                                                <?php foreach( $subdistricts as $subdistrict ): ?>
                                                    <option value="<?php echo $subdistrict['tambon_id']; ?>" <?php echo set_select('applicant_register_subdistrict_id', $subdistrict['tambon_id']); ?>><?php echo ( $this->_language == 'th' ? $subdistrict['name'] : $subdistrict['name_alt'] ); ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_postcode_id"><?php echo $this->lang->line('Postcode'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <select name="applicant_register_postcode_id" id="applicant_register_postcode_id" class="select2">
                                            <option value="0" <?php echo set_select('applicant_register_postcode_id', '', true); ?>>-- <?php echo $this->lang->line('Postcode'); ?> --</option>
                                            <?php $postcodes = $this->jobsmodel->get_zipcodes( $this->input->post('applicant_register_subdistrict_id') ); ?>
                                            <?php if( isset( $postcodes ) && count( $postcodes ) > 0 ): ?>
                                                <?php foreach( $postcodes as $postcode ): ?>
                                                    <option value="<?php echo $postcode['postcode_id']; ?>" <?php echo set_select('applicant_register_postcode_id', $postcode['postcode_id']); ?>><?php echo $postcode['postcode']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_telephone"><?php echo $this->lang->line('Telephone'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <input type="tel" name="applicant_register_telephone" id="applicant_register_telephone" value="<?php echo set_value('applicant_register_telephone'); ?>" maxlength="10" />
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_mobile"><?php echo $this->lang->line('Mobile Phone'); ?></label>
                                <div class="controls d-flex">
                                    <div class="col-12 px-0 col-lg-8">
                                        <input type="tel" name="applicant_register_mobile" id="applicant_register_mobile" value="<?php echo set_value('applicant_register_mobile'); ?>" class="validate_mobile" maxlength="10" />
                                    </div>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label" for="applicant_register_email"><?php echo $this->lang->line('Email'); ?></label>
                                <div class="controls">
                                    <div class="col-12 px-0 col-lg-8">
                                        <input type="email" name="applicant_register_email" id="applicant_register_email" value="<?php echo set_value('applicant_register_email'); ?>" class="validate_email" />
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="wrapper border border-1px border-navy pb-3">

                        <h3 class="bg-navy p-3 white"><?php echo $this->lang->line('Presonal History'); ?></h3>

                        <div class="control-group">
                            <label class="control-label" for="applicant_news_source_id"><?php echo $this->lang->line('Do you know the Navakij Insurance PCL\'s recruitment news from where?'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <select name="applicant_news_source_id" id="applicant_news_source_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_news_source_id', '', true); ?>>-- <?php echo $this->lang->line('Choose option'); ?> --</option>
                                        <?php if( isset( $sources ) && count( $sources ) > 0 ): ?>
                                            <?php foreach( $sources as $source ): ?>
                                                <option value="<?php echo $source['source_id']; ?>" <?php echo set_select('applicant_news_source_id', $source['source_id']); ?>><?php echo $source['source_title_'.$this->_language]; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_applied_status"><?php echo $this->lang->line('Have you ever applied for a job with Navakij Insurance PCL. before?'); ?></label>
                            <div class="controls d-flex align-items-center">
                                <label class="col"><input type="checkbox" name="applicant_applied_status" id="applicant_applied_status" value="1" <?php echo set_checkbox('applicant_applied_status', 1); ?> class="mr-2" /> <?php echo $this->lang->line('Yes'); ?></label>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_applied_year"><?php echo $this->lang->line('When?'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-4">
                                    <input type="text" name="applicant_applied_year" id="applicant_applied_year" value="<?php echo set_value('applicant_applied_year'); ?>" placeholder="<?php echo $this->lang->line('Year'); ?>" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="control-group">
                            <label class="control-label"><?php echo $this->lang->line('Have you ever had an accident or illness to the point of being admitted to the hospital?'); ?></label>
                            <div class="controls d-flex">
                                <label for="applicant_accident_status" class="col"><input type="checkbox" name="applicant_accident_status" id="applicant_accident_status" value="1" <?php echo set_checkbox('applicant_accident_status', 1); ?> /> <?php echo $this->lang->line('Yes'); ?></label>
                            </div>
                        </div>

                    </div>

                    <div class="button-wrapper my-3 text-center">
                        <a href="javascript:void(0);" class="btnNextStep btn btn-navy" data-targetStep="2">Next</a>
                    </div>

                </div>
                <?php /* .step-item.step-1 - End */ ?>

                <?php /* .step-item.step-2 - Start */ ?>
                <div class="step-item step-2">
                    
                    <div class="wrapper border border-1px border-navy pb-3">
                        
                        <h3 class="bg-navy p-3 white"><?php echo $this->lang->line('Education Information'); ?></h3>

                        <div class="control-group">
                            <label class="control-label"><?php echo $this->lang->line('Are you in currently studying?'); ?></label>
                            <div class="controls d-flex align-items-center">
                                <label for="applicant_studying_status" class="col"><input type="checkbox" name="applicant_studying_status" id="applicant_studying_status" value="1" <?php echo set_checkbox('applicant_studying_status', 1); ?> /> <?php echo $this->lang->line('Yes'); ?></label>
                            </div>
                        </div>
                        
                        <?php /* High school - Start */ ?>
                        <div class="control-group">
                            <label class="control-label" for="applicant_education_highschool_name"><?php echo $this->lang->line('High school'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0">
                                    <input type="text" name="applicant_education_highschool_name" id="applicant_education_highschool_name" value="<?php echo set_value('applicant_education_highschool_name'); ?>" placeholder="<?php echo $this->lang->line('Stitution name'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls d-flex flex-wrap align-items-center">
                                <div class="col-12 px-0 pr-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <select name="applicant_education_highschool_province_id" id="applicant_education_highschool_province_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_education_highschool_province_id', 0, true); ?>>-- <?php echo $this->lang->line('Province'); ?> --</option>
                                        <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                            <?php foreach( $provinces as $province ): ?>
                                                <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_highschool_province_id', $province['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_highschool_year" id="applicant_education_highschool_year" value="<?php echo set_value('applicant_education_highschool_year'); ?>" placeholder="<?php echo $this->lang->line('Educated Year'); ?>" />
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_highschool_major" id="applicant_education_highschool_major" value="<?php echo set_value('applicant_education_highschool_major'); ?>" placeholder="<?php echo $this->lang->line('Major'); ?>" />
                                </div>
                                <div class="col-12 px-0 pl-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_highschool_gpa" id="applicant_education_highschool_gpa" value="<?php echo set_value('applicant_education_highschool_gpa'); ?>" placeholder="<?php echo $this->lang->line('GPA'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls"><hr size="0" class="border-navy" /></div>
                        </div>
                        <?php /* High school - End */ ?>
                        
                        <?php /* Vocational - Start */ ?>
                        <div class="control-group">
                            <label class="control-label" for="applicant_education_vocational_name"><?php echo $this->lang->line('Vocational'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0">
                                    <input type="text" name="applicant_education_vocational_name" id="applicant_education_vocational_name" value="<?php echo set_value('applicant_education_vocational_name'); ?>" placeholder="<?php echo $this->lang->line('Stitution name'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls d-flex flex-wrap align-items-center">
                                <div class="col-12 px-0 pr-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <select name="applicant_education_vocational_province_id" id="applicant_education_vocational_province_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_education_vocational_province_id', 0, true); ?>>-- <?php echo $this->lang->line('Province'); ?> --</option>
                                        <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                            <?php foreach( $provinces as $province ): ?>
                                                <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_vocational_province_id', $province['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_vocational_year" id="applicant_education_vocational_year" value="<?php echo set_value('applicant_education_vocational_year'); ?>" placeholder="<?php echo $this->lang->line('Educated Year'); ?>" />
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_vocational_major" id="applicant_education_vocational_major" value="<?php echo set_value('applicant_education_vocational_major'); ?>" placeholder="<?php echo $this->lang->line('Major'); ?>" />
                                </div>
                                <div class="col-12 px-0 pl-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_vocational_gpa" id="applicant_education_vocational_gpa" value="<?php echo set_value('applicant_education_vocational_gpa'); ?>" placeholder="<?php echo $this->lang->line('GPA'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls"><hr size="0" class="border-navy" /></div>
                        </div>
                        <?php /* Vocational - End */ ?>

                        <?php /* Diploma - Start */ ?>
                        <div class="control-group">
                            <label class="control-label" for="applicant_education_diploma_name"><?php echo $this->lang->line('Diploma'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0">
                                    <input type="text" name="applicant_education_diploma_name" id="applicant_education_diploma_name" value="<?php echo set_value('applicant_education_diploma_name'); ?>" placeholder="<?php echo $this->lang->line('Stitution Name'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls d-flex flex-wrap align-items-center">
                                <div class="col-12 px-0 pr-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <select name="applicant_education_diploma_province_id" id="applicant_education_diploma_province_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_education_diploma_province_id', 0, true); ?>>-- <?php echo $this->lang->line('Province'); ?> --</option>
                                        <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                            <?php foreach( $provinces as $province ): ?>
                                                <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_diploma_province_id', $province['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_diploma_year" id="applicant_education_diploma_year" value="<?php echo set_value('applicant_education_diploma_year'); ?>" placeholder="<?php echo $this->lang->line('Educated Year'); ?>" />
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_diploma_major" id="applicant_education_diploma_major" value="<?php echo set_value('applicant_education_diploma_major'); ?>" placeholder="<?php echo $this->lang->line('Major'); ?>" />
                                </div>
                                <div class="col-12 px-0 pl-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_diploma_gpa" id="applicant_education_diploma_gpa" value="<?php echo set_value('applicant_education_diploma_gpa'); ?>" placeholder="<?php echo $this->lang->line('GPA'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls"><hr size="0" class="border-navy" /></div>
                        </div>
                        <?php /* Diploma - End */ ?>

                        <?php /* Bachelor - Start */ ?>
                        <div class="control-group">
                            <label class="control-label" for="applicant_education_bachelor_name"><?php echo $this->lang->line('Bachelor'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0">
                                    <input type="text" name="applicant_education_bachelor_name" id="applicant_education_bachelor_name" value="<?php echo set_value('applicant_education_bachelor_name'); ?>" placeholder="<?php echo $this->lang->line('Stitution Name'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls d-flex flex-wrap align-items-center">
                                <div class="col-12 px-0 pr-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <select name="applicant_education_bachelor_province_id" id="applicant_education_bachelor_province_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_education_bachelor_province_id', 0, true); ?>>-- <?php echo $this->lang->line('Province'); ?> --</option>
                                        <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                            <?php foreach( $provinces as $province ): ?>
                                                <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_bachelor_province_id', $province['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_bachelor_year" id="applicant_education_bachelor_year" value="<?php echo set_value('applicant_education_bachelor_year'); ?>" placeholder="<?php echo $this->lang->line('Educated Year'); ?>" />
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_bachelor_major" id="applicant_education_bachelor_major" value="<?php echo set_value('applicant_education_bachelor_major'); ?>" placeholder="<?php echo $this->lang->line('Major'); ?>" />
                                </div>
                                <div class="col-12 px-0 pl-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_bachelor_gpa" id="applicant_education_bachelor_gpa" value="<?php echo set_value('applicant_education_bachelor_gpa'); ?>" placeholder="<?php echo $this->lang->line('GPA'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls"><hr size="0" class="border-navy" /></div>
                        </div>
                        <?php /* Bachelor - End */ ?>

                        <?php /* Master - Start */ ?>
                        <div class="control-group">
                            <label class="control-label" for="applicant_education_master_name"><?php echo $this->lang->line('Master'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0">
                                    <input type="text" name="applicant_education_master_name" id="applicant_education_master_name" value="<?php echo set_value('applicant_education_master_name'); ?>" placeholder="<?php echo $this->lang->line('Stitution Name'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls d-flex flex-wrap align-items-center">
                                <div class="col-12 px-0 pr-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <select name="applicant_education_master_province_id" id="applicant_education_master_province_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_education_master_province_id', 0, true); ?>>-- <?php echo $this->lang->line('Province'); ?> --</option>
                                        <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                            <?php foreach( $provinces as $province ): ?>
                                                <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_master_province_id', $province['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_master_year" id="applicant_education_master_year" value="<?php echo set_value('applicant_education_master_year'); ?>" placeholder="<?php echo $this->lang->line('Educated Year'); ?>" />
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_master_major" id="applicant_education_master_major" value="<?php echo set_value('applicant_education_master_major'); ?>" placeholder="<?php echo $this->lang->line('Major'); ?>" />
                                </div>
                                <div class="col-12 px-0 pl-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_master_gpa" id="applicant_education_master_gpa" value="<?php echo set_value('applicant_education_master_gpa'); ?>" placeholder="<?php echo $this->lang->line('GPA'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls"><hr size="0" class="border-navy" /></div>
                        </div>
                        <?php /* Master - End */ ?>

                        <?php /* Other - Start */ ?>
                        <div class="control-group">
                            <label class="control-label" for="applicant_education_other_name"><?php echo $this->lang->line('Other'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0">
                                    <input type="text" name="applicant_education_other_name" id="applicant_education_other_name" value="<?php echo set_value('applicant_education_other_name'); ?>" placeholder="<?php echo $this->lang->line('Stitution Name'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls d-flex flex-wrap align-items-center">
                                <div class="col-12 px-0 pr-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <select name="applicant_education_other_province_id" id="applicant_education_other_province_id" class="select2">
                                        <option value="0" <?php echo set_select('applicant_education_other_province_id', 0, true); ?>>-- <?php echo $this->lang->line('Province'); ?> --</option>
                                        <?php if( isset( $provinces ) && count( $provinces ) > 0 ): ?>
                                            <?php foreach( $provinces as $province ): ?>
                                                <option value="<?php echo $province['province_id']; ?>" <?php echo set_select('applicant_education_other_province_id', $province['province_id']); ?>><?php echo ( $this->_language == 'th' ? $province['name'] : $province['name_alt'] ); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_other_year" id="applicant_education_other_year" value="<?php echo set_value('applicant_education_other_year'); ?>" placeholder="<?php echo $this->lang->line('Educated Year'); ?>" />
                                </div>
                                <div class="col-12 px-0 px-lg-3 col-lg-4 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_other_major" id="applicant_education_other_major" value="<?php echo set_value('applicant_education_other_major'); ?>" placeholder="<?php echo $this->lang->line('Major'); ?>" />
                                </div>
                                <div class="col-12 px-0 pl-lg-3 col-lg-2 mb-3 mb-lg-0">
                                    <input type="text" name="applicant_education_other_gpa" id="applicant_education_other_gpa" value="<?php echo set_value('applicant_education_other_gpa'); ?>" placeholder="<?php echo $this->lang->line('GPA'); ?>" />
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls"><hr size="0" class="border-navy" /></div>
                        </div>
                        <?php /* Other - End */ ?>

                    </div>

                    <div class="wrapper border border-1px border-navy pb-3">
                        
                        <h3 class="bg-navy p-3 white"><?php echo $this->lang->line('Knowledge/Skills'); ?></h3>

                        <div class="control-group">
                            <label class="control-label" for="applicant_skill_computer"><?php echo $this->lang->line('Computer skill'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <textarea name="applicant_skill_computer" id="applicant_skill_computer" rows="5"><?php echo set_value('applicant_skill_computer'); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_skill_typing_thai"><?php echo $this->lang->line('Rate of typing in Thai'); ?></label>
                            <div class="controls d-flex align-items-center">
                                <div class="col-10 px-0 col-lg-3">
                                    <input type="number" name="applicant_skill_typing_thai" id="applicant_skill_typing_thai" value="<?php echo set_value('applicant_skill_typing_thai'); ?>" step="1" min="0" max="999" />
                                </div>
                                <span class="help-inline ml-1 ml-lg-3"><?php echo $this->lang->line('word/minute'); ?></span>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_skill_typing_english"><?php echo $this->lang->line('Rate of typing in English'); ?></label>
                            <div class="controls d-flex align-items-center">
                                <div class="col-10 px-0 col-lg-3">
                                    <input type="number" name="applicant_skill_typing_english" id="applicant_skill_typing_english" value="<?php echo set_value('applicant_skill_typing_english'); ?>" step="1" min="0" max="999" />
                                </div>
                                <span class="help-inline ml-1 ml-lg-3"><?php echo $this->lang->line('word/minute'); ?></span>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_skill_office_tools"><?php echo $this->lang->line('What office equipment can you use?'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <textarea name="applicant_skill_office_tools" id="applicant_skill_office_tools" rows="5"><?php echo set_value('applicant_skill_office_tools'); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_skill_specials"><?php echo $this->lang->line('Special Knowledge/Skills'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <textarea name="applicant_skill_specials" id="applicant_skill_specials" rows="5"><?php echo set_value('applicant_skill_specials'); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_skill_activities"><?php echo $this->lang->line('Activities during the study.'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0 col-lg-8">
                                    <textarea name="applicant_skill_activities" id="applicant_skill_activities" rows="5"><?php echo set_value('appicant_skill_activities'); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label"><?php echo $this->lang->line('Driving skill'); ?></label>
                            <div class="controls d-flex flex-wrap">
                                <p class="col-12 px-0 d-flex align-items-center mb-3"><input type="checkbox" name="applicant_skill_driving_status" id="applicant_skill_driving_status" value="1" <?php echo set_checkbox('applicant_skill_driving_status', 1); ?> class="mr-3" /> <?php echo $this->lang->line('Yes, I can drive'); ?> <input type="text" name="applicant_skill_driving_license" id="applicant_skill_driving_license" value="<?php echo set_value('applicant_skill_driving_license'); ?>" placeholder="<?php echo $this->lang->line('License Number'); ?>" class="col-4 ml-3" /></p>
                                <p class="col-12 px-0 d-flex align-items-center"><input type="checkbox" name="applicant_skill_riding_status" id="applicant_skill_riding_status" value="1" <?php echo set_checkbox('applicant_skill_riding_status', 1); ?> class="mr-3" /> <?php echo $this->lang->line('Yes, I can ride'); ?> <input type="text" name="applicant_skill_riding_license" id="applicant_skill_riding_license" value="<?php echo set_value('applicant_skill_riding_license'); ?>" placeholder="<?php echo $this->lang->line('License Number'); ?>" class="col-4 ml-3" /></p>
                            </div>
                        </div>

                    </div>

                    <div class="wrapper border border-1px border-navy pb-3">
                        
                        <h3 class="bg-navy p-3 white"><?php echo $this->lang->line('Language Ability'); ?></h3>

                        <div id="language-skills">
                        
                            <div class="language-skill-item control-group pb-3">
                                <label class="control-label">
                                    <?php echo $this->lang->line('Thai'); ?>
                                    <input type="hidden" name="applicant_skill_languages[name][]" value="Thai" />
                                </label>
                                <div class="controls d-flex flex-wrap">
                                    <div class="col-12 px-0 pr-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[listen][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[listen][]',0, true); ?>>-- <?php echo $this->lang->line('Choose listening level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[listen][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[listen][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[listen][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 px-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[speaking][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[speaking][]',0, true); ?>>-- <?php echo $this->lang->line('Choose speaking level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[speaking][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[speaking][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[speaking][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 px-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[reading][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[reading][]',0, true); ?>>-- <?php echo $this->lang->line('Choose reading level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[reading][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[reading][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[reading][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 pl-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[writing][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[writing][]',0, true); ?>>-- <?php echo $this->lang->line('Choose writing level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[writing][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[writing][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[writing][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="language-skill-item control-group pb-3">
                                <label class="control-label">
                                    <?php echo $this->lang->line('English'); ?>
                                    <input type="hidden" name="applicant_skill_languages[name][]" value="English" />
                                </label>
                                <div class="controls d-flex flex-wrap">
                                    <div class="col-12 px-0 pr-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[listen][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[listen][]',0, true); ?>>-- <?php echo $this->lang->line('Choose listening level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[listen][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[listen][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[listen][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 px-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[speaking][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[speaking][]',0, true); ?>>-- <?php echo $this->lang->line('Choose speaking level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[speaking][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[speaking][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[speaking][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 px-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[reading][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[reading][]',0, true); ?>>-- <?php echo $this->lang->line('Choose reading level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[reading][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[reading][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[reading][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 pl-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[writing][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[writing][]',0, true); ?>>-- <?php echo $this->lang->line('Choose writing level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[writing][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[writing][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[writing][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="language-skill-item control-group pb-3">
                                <label class="control-label">
                                    <input type="text" name="applicant_skill_languages[name][]" value="<?php echo set_value('applicant_skill_languages[ame[]'); ?>" placeholder="<?php echo $this->lang->line('Please, fill your language'); ?>" />
                                </label>
                                <div class="controls d-flex flex-wrap">
                                    <div class="col-12 px-0 pr-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[listen][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[listen][]',0, true); ?>>-- <?php echo $this->lang->line('Choose listening level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[listen][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[listen][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[listen][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 px-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[speaking][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[speaking][]',0, true); ?>>-- <?php echo $this->lang->line('Choose speaking level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[speaking][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[speaking][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[speaking][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 px-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[reading][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[reading][]',0, true); ?>>-- <?php echo $this->lang->line('Choose reading level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[reading][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[reading][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[reading][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                    <div class="col-12 px-0 pl-lg-3 col-lg-3 mb-3 mb-lg-0">
                                        <select name="applicant_skill_languages[writing][]">
                                            <option value="0" <?php echo set_select('applicant_skill_languages[writing][]',0, true); ?>>-- <?php echo $this->lang->line('Choose writing level'); ?> --</option>
                                            <option value="great" <?php echo set_select('applicant_skill_languages[writing][]', 'great'); ?>><?php echo $this->lang->line('Language skill : great'); ?></option>
                                            <option value="good" <?php echo set_select('applicant_skill_languages[writing][]', 'good'); ?>><?php echo $this->lang->line('Language skill : good'); ?></option>
                                            <option value="moderate" <?php echo set_select('applicant_skill_languages[writing][]', 'moderate'); ?>><?php echo $this->lang->line('Language skill : moderate'); ?></option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="text-center my-5">
                            <a href="javascript:void(0);" class="btnClone btn btn-navy" data-target=".language-skill-item" data-parents="#language-skills"><i class="fas fa-plus"></i> <?php echo $this->lang->line('Add more'); ?></a>
                        </div>

                    </div>

                    <div class="button-wrapper my-3 text-center">
                        <a href="javascript:void(0);" class="btnBackStep btn btn-navy-transparent mx-3" data-targetStep="1">Back</a>
                        <a href="javascript:void(0);" class="btnNextStep btn btn-navy" data-targetStep="3">Next</a>
                    </div>

                </div>
                <?php /* .step-item.step-2 - End */ ?>

                <?php /* .step-item.step-3 - Start */ ?>
                <div class="step-item step-3">
                    
                    <div class="wrapper border border-1px border-navy pb-3">
                        
                        <h3 class="bg-navy p-3 white"><?php echo $this->lang->line('Working Experience in Chronological'); ?></h3>

                        <div class="control-group">
                            <label class="control-label" for="applicant_experienced_status"><?php echo $this->lang->line('Do you have working experience?'); ?></label>
                            <div class="controls">
                                <label class="px-3"><input type="checkbox" name="applicant_experienced_status" id="applicant_experienced_status" value="1" <?php echo set_checkbox('applicant_experienced_status', 1); ?> /> <?php echo $this->lang->line('Yes'); ?></label>
                            </div>
                        </div>

                        <div id="experiences">
                            
                            <?php for( $i=1; $i<=3; $i++ ): ?>
                                <div class="experience-item px-3 my-3 position-relative">
                                    <a href="#experience-item-<?php echo $i; ?>" data-toggle="collapse" role="button" aria-expended="<?php echo ( $i == 1 ? true : false ); ?>" aria-controls="experience-<?php echo $i; ?>" class="btn btn-navy w-100">
                                        <?php echo $this->lang->line('company'); ?> <span class="number"><?php echo $i; ?></span>
                                    </a>
                                    <div class="collapse <?php echo ( $i == 1 ? 'show' : '' ); ?>" id="experience-item-<?php echo $i; ?>" data-parent="#experiences">

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Company Name'); ?></label>
                                            <div class="controls d-flex">
                                                <div class="col-12 px-0 col-lg-8">
                                                    <input type="text" name="applicant_experiences[company_name][]" value="<?php echo set_value('applicant_experiences[company_name][]'); ?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Address'); ?></label>
                                            <div class="controls d-flex">
                                                <div class="col-12 px-0 col-lg-8">
                                                    <textarea name="applicant_experiences[company_address][]" rows="5"><?php echo set_value('applicant_experiences[company_address][]'); ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Telephone'); ?></label>
                                            <div class="controls d-flex">
                                                <div class="col-12 px-0 col-lg-8">
                                                    <input type="tel" name="applicant_experiences[company_tel][]" value="<?php echo set_value('applicant_experiences[company_tel][]'); ?>" maxlength="10" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Period'); ?></label>
                                            <div class="controls d-flex align-items-center">
                                                <div class="col-12 px-0 col-lg-4 mb-3 mb-lg-0">
                                                    <input type="text" name="applicant_experiences[start][]" value="<?php echo set_value('applicant_experiences[start][]'); ?>" class="date-picker" placeholder="<?php echo $this->lang->line('Start'); ?>" />
                                                </div>
                                                <span class="col-12 col-lg-1 px-0 px-lg-3 mb-3 mb-lg-0 text-center">To</span>
                                                <div class="col-12 px-0 col-lg-4 mb-3 mb-lg-0">
                                                    <input type="text" name="applicant_experiences[end][]" value="<?php echo set_value('applicant_experiences[end][]'); ?>" class="date-picker" placeholder="<?php echo $this->lang->line('To'); ?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Name of Superior'); ?></label>
                                            <div class="controls d-flex">
                                                <div class="col-12 px-0 col-lg-8">
                                                    <input type="text" name="applicant_experiences[superior][]" value="<?php echo set_value('applicant_experiences[superior][]'); ?>" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Responsibility'); ?></label>
                                            <div class="controls d-flex">
                                                <div class="col-12 px-0 col-lg-8">
                                                    <textarea name="applicant_experiences[responsibility][]" rows="5"><?php echo set_value('applicant_experiences[responsibility][]'); ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Salary'); ?></label>
                                            <div class="controls d-flex align-items-center">
                                                <div class="col-10 col-lg-8">
                                                    <input type="number" name="applicant_experiences[salary][]" value="<?php echo set_value('applicant_experiences[salary][]'); ?>" step="1" min="0" max="9999999" />
                                                </div>
                                                <span class="help-inline pl-2"><?php echo $this->lang->line('Baht'); ?></span>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Cost of living'); ?></label>
                                            <div class="controls d-flex align-items-center">
                                                <div class="col-10 col-lg-8">
                                                    <input type="number" name="applicant_experiences[cost_of_living][]" value="<?php echo set_value('applicant_experiences[cost_of_living][]'); ?>" step="1" min="0" max="9999999" />
                                                </div>
                                                <span class="help-inline pl-2"><?php echo $this->lang->line('Baht'); ?></span>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Bonus/month'); ?></label>
                                            <div class="controls d-flex align-items-center">
                                                <div class="col-10 col-lg-8">
                                                    <input type="number" name="applicant_experiences[bonus][]" value="<?php echo set_value('applicant_experiences[bonus][]'); ?>" step="1" min="0" max="9999999" />
                                                </div>
                                                <span class="help-inline pl-2"><?php echo $this->lang->line('Baht'); ?></span>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Other income'); ?></label>
                                            <div class="controls d-flex align-items-center">
                                                <div class="col-10 col-lg-8">
                                                    <input type="number" name="applicant_experiences[other][]" value="<?php echo set_value('applicant_experiences[other][]'); ?>" step="1" min="0" max="9999999" />
                                                </div>
                                                <span class="help-inline pl-2"><?php echo $this->lang->line('Baht'); ?></span>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Total income'); ?></label>
                                            <div class="controls d-flex align-items-center">
                                                <div class="col-10 col-lg-8">
                                                    <input type="number" name="applicant_experiences[total][]" value="<?php echo set_value('applicant_experiences[total][]'); ?>" step="0" min="0" max="9999999" />
                                                </div>
                                                <span class="help-inline pl-2"><?php echo $this->lang->line('Baht'); ?></span>
                                            </div>
                                        </div>

                                        <div class="control-group px-0">
                                            <label class="control-label"><?php echo $this->lang->line('Reason of resignation'); ?></label>
                                            <div class="controls d-flex align-items-center">
                                                <div class="col-12 px-0 col-lg-8">
                                                    <textarea name="applicant_experiences[reason][]" rows="5"><?php echo set_value('applicant_experiences[reason][]'); ?></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            <?php endfor; ?>

                        </div>

                        <div class="text-center my-5">
                            <a href="javascript:void(0);" class="btnExpClone btn btn-navy" data-target=".experience-item" data-parents="#experiences"><i class="fas fa-plus"></i> <?php echo $this->lang->line('Add more'); ?></a>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_introduction"><?php echo $this->lang->line('Please, provide any further information about yourself which will allow our compnay to know you better.'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0">
                                    <textarea name="applicant_introduction" id="applicant_introduction" rows="5"><?php echo set_value('applicant_introduction'); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="controls">
                                <p>"บริษัท นวกิจประกันภัย จำกัด (มหาชน) ขอเรียนให้ท่านทราบว่า บริษัทฯ ไม่มีความประสงค์ในการเก็บรวบรวมข้อมูลส่วนบุคคลที่มีความอ่อนไหว ซึ่งปรากฎอยู่บนหน้าบัตรประจำตัวประชาชน สำเนาทะเบียนบ้าน สำเนาหนังสือเดินทาง รวมถึงเอกสารอื่นๆ เช่น เชื้อชาติ ข้อมูลศาสนา หมู่โลหิต (กรุ๊ปเลือด) เป็นต้น จึงขอได้โปรด ทำการขีดฆ่า หรือทำเส้นทึบ ปิดทับข้อมูลดังกล่าวบนสำเนาเอกสารต่างๆ ก่อนส่งมอบให้บริษัทฯ ด้วย"</p>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label"><?php echo $this->lang->line('Upload Files'); ?></label>
                            <div class="controls d-flex">
                                <div class="col-12 px-0">
                                    <p class="mb-3"><input type="file" name="applicant_file_1" id="applicant_file_1" /></p>
                                    <p class="mb-3"><input type="file" name="applicant_file_2" id="applicant_file_2" /></p>
                                    <p class="mb-3"><input type="file" name="applicant_file_3" id="applicant_file_3" /></p>
                                    <p class="navy small"><?php echo $this->lang->line('Allow file extension *.pdf, *.doc, *.docx, *.jpg, *.jpeg, *.png, *.gif, *.xls, *.xlsx'); ?></p>
                                    <p class="navy small"><?php echo $this->lang->line('Maximum file size not over 5Mb/file'); ?></p>
                                </div>
                            </div>
                        </div>

                        <div class="control-group">
                            <?php /* <p>การรับรองและให้ความยินยอม ข้าพเจ้าขอรับรองว่า ข้าพเจ้าได้รับทราบ ทบทวน และเข้าใจเนื้อหาตามนโยบายข้อมูลาส่วนบุคคลของผู้สมัครงาน และยินยอมให้ใช้ข้อมูลส่วนบุคคลของข้าพเจ้าเพื่อวัตถุประสงค์ตามที่ระบุตามนโยบายดังกล่าว <a href="javascript:void(0);" class="btn-text navy" data-toggle="modal" data-target="#pdpaModal">อ่านเพิ่มเติม</a> <span class="symbol required"></span></p> */ ?>
                            <p>การรับรองและให้ความยินยอม ข้าพเจ้าขอรับรองว่า ข้าพเจ้าได้รับทราบ ทบทวน และเข้าใจเนื้อหาตามนโยบายข้อมูลาส่วนบุคคลของผู้สมัครงาน และยินยอมให้ใช้ข้อมูลส่วนบุคคลของข้าพเจ้าเพื่อวัตถุประสงค์ตามที่ระบุตามนโยบายดังกล่าว <a href="<?php echo site_url('privacy-policy'); ?>" class="btn-text navy" target="_blank">อ่านเพิ่มเติม</a> <span class="symbol required"></span></p>
                            <div class="controls">
                                <p><label><input type="radio" name="applicant_pdpa_consent" id="applicant_pdpa_consent_accept" value="accept" checked /> รับรอง / ยินยอม</label></p>
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
                            <div class="controls">
                                <p><label><input type="radio" name="applicant_forbidden_person" value="yes" /> เป็น</label></p>
                                <p><label><input type="radio" name="applicant_forbidden_person" value="no" checked /> ไม่เป็น</label></p>
                            </div>
                        </div>

                        <div class="control-group">
                            <p>2. ท่านเป็นนายหน้าประกันวินาศภัย หรือไม่ <span class="symbol required"></span></p>
                            <div class="controls">
                                <p><label><input type="radio" name="applicant_broker" value="yes" /> เป็น</label></p>
                                <p><label><input type="radio" name="applicant_broker" value="no" checked /> ไม่เป็น</label></p>
                            </div>
                        </div>

                        <div class="control-group">
                            <p>3. ท่านเป็นบุคคลที่เคยถูกเพิกถอนใบอนุญาตเป็นตัวแทนฯ หรือใบอนุญาตเป็นนายหน้าฯ เว้นแต่จะพ้นระยะเวลา 5 ปีก่อนวันขอรับใบอนุญาต หรือไม่ <span class="symbol required"></span></p>
                            <div class="controls">
                                <p><label><input type="radio" name="applicant_revoked" value="yes" /> เป็น</label></p>
                                <p><label><input type="radio" name="applicant_revoked" value="no" checked /> ไม่เป็น</label></p>
                            </div>
                        </div>

                        <div class="control-group">
                            <p>ข้าพเจ้าขอรับรองว่า ข้อความดังกล่าวทั้งหมดในใบสมัครงานนี้เป็นความจริงทุกประการ หลังจากบริษัทจ้างข้าพเจ้าเข้าทำงานแล้ว ปรากฎว่า รายละเอียดข้อความในใบสมัครงาน และ/หรือเอกสารแนบอื่นๆ ไม่เป็นความจริง บริษัทฯ ขอสงวนสิทธิ์ที่จะเลิกจ้างข้าพเจ้าได้โดยไม่ต้องจ่ายเงินชดเชยหรือค่าเสียหายใดๆ ทั้งสิ้น</p>
                            <div class="controls">
                                <label class="px-3"><input type="checkbox" name="applicant_consent" id="applicant_consent" value="1" <?php echo set_checkbox('applicant_consent', 1); ?> class="required" /> <?php echo $this->lang->line('I, agree'); ?><span class="symbol required"></span></label>
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label" for="applicant_signed_name"><?php echo $this->lang->line('Your name'); ?><span class="symbol required"></span></label>
                            <div class="controls d-flex flex-wrap">
                                <p class="col-12 px-0 mb-3"><input type="text" name="applicant_signed_name" id="applicant_signed_name" value="<?php echo set_value('applicant_signed_name'); ?>" class="required" /></p>
                                <p class="col-12 px-0 text-center"><?php echo thai_convert_fulldate( date('Y-m-d') ); ?></p>
                            </div>
                        </div>

                    </div>

                    <div class="button-wrapper my-3 text-center">
                        <a href="javascript:void(0);" class="btnBackStep btn btn-navy-transparent mx-1 mx-lg-3" data-targetStep="2">Back</a>
                        <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-navy">Submit</button>
                    </div>

                </div>
                <?php /* .step-item.step-3 - End */ ?>

            </form>

        </div>
    </div>
</section>