<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขรายการผู้บริหาร</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">

                <div class="control-group">
					<label class="control-label" for="member_image">รูปภาพ * : </label>
					<div class="controls">
						<div class="preview">
							<?php if( $info['member_image'] != '' && is_file( realpath('public/core/uploaded/boardmembers/'.$info['member_image']) ) === true ): ?>
								<a href="<?php echo base_url('public/core/uploaded/boardmembers/'.$info['member_image']); ?>" class="fancybox-button">
									<img src="<?php echo base_url('public/core/uploaded/boardmembers/'.$info['member_image']); ?>" alt="" style="width:250px;" />
								</a>
							<?php endif; ?>
						</div>
						<input type="file" name="member_image" id="member_image" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด กว้าง x ยาว (Dimension) เท่ากับ 595x800 พิกเซล (Pixels) และมีขนาดของไฟล์ (Size) ไม่เกิน 2 เมกะไบต์ (Mb) เท่านั้น</span>
					</div>
				</div>
				
				<div class="control-group">
                    <label class="control-label" for="member_name_th">ชื่อ (ไทย) * : </label>
                    <div class="controls">
                        <input type="text" name="member_name_th" id="member_name_th" value="<?php echo set_value('member_name_th', $info['member_name_th']); ?>" class="span6" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="member_name_en">ชื่อ (En) * : </label>
                    <div class="controls">
                        <input type="text" name="member_name_en" id="member_name_en" value="<?php echo set_value('member_name_en', $info['member_name_en']); ?>" class="span6" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="member_position_th">ตำแหน่ง (ไทย) : </label>
                    <div class="controls">
                        <input type="text" name="member_position_th" id="member_position_th" value="<?php echo set_value('member_position_th', $info['member_position_th']); ?>" class="span12" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="member_position_en">ตำแหน่ง (En) : </label>
                    <div class="controls">
                        <input type="text" name="member_position_en" id="member_position_en" value="<?php echo set_value('member_position_en', $info['member_position_en']); ?>" class="span12" />
                    </div>
                </div>

				<div class="control-group">
					<label class="control-label" for="member_type_th">ประเภทกรรมการที่เสนอแต่งตั้ง (ไทย) : </label>
					<div class="controls">
						<input type="text" name="member_type_th" id="member_type_th" value="<?php echo set_value('member_type_th', $info['member_type_th']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_type_en">ประเภทกรรมการที่เสนอแต่งตั้ง (En) : </label>
					<div class="controls">
						<input type="text" name="member_type_en" id="member_type_en" value="<?php echo set_value('member_type_en', $info['member_type_en']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_history_th">จำนวนปีที่ดำรงตำแหน่งกรรมการ (ไทย) : </label>
					<div class="controls">
						<textarea name="member_history_th" id="member_history_th" rows="5" class="ckeditor"><?php echo set_value('member_history_th', $info['member_history_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_history_en">จำนวนปีที่ดำรงตำแหน่งกรรมการ (En) : </label>
					<div class="controls">
						<textarea name="member_history_en" id="member_history_en" rows="5" class="ckeditor"><?php echo set_value('member_history_en', $info['member_history_en']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_age">อายุ : </label>
					<div class="controls">
						<input type="number" name="member_age" id="member_age" value="<?php echo set_value('member_age', $info['member_age']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_nationality_th">สัญชาติ (ไทย) : </label>
					<div class="controls">
						<input type="text" name="member_nationality_th" id="member_nationality_th" value="<?php echo set_value('member_nationality_th', $info['member_nationality_th']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_nationality_en">สัญชาติ (En) : </label>
					<div class="controls">
						<input type="text" name="member_nationality_en" id="member_nationality_en" value="<?php echo set_value('member_nationality_en', $info['member_nationality_en']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_educational_th">คุณวุฒิการศึกษา (ไทย) : </label>
					<div class="controls">
						<textarea name="member_educational_th" id="member_educational_th" rows="5" class="ckeditor"><?php echo set_value('member_educational_th', $info['member_educational_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_educational_en">คุณวุฒิการศึกษา (En) : </label>
					<div class="controls">
						<textarea name="member_educational_en" id="member_educational_en" rows="5" class="ckeditor"><?php echo set_value('member_educational_en', $info['member_educational_en']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_committee_seminar_th">การอบรมเกี่ยวกับบทบาทหน้าที่กรรมการสมาคมส่งเสริมสถาบันกรรมการบริษัทไทย (ไทย) : </label>
					<div class="controls">
						<textarea name="member_committee_seminar_th" id="member_committee_seminar_th" rows="5" class="ckeditor"><?php echo set_value('member_committee_seminar_th', $info['member_committee_seminar_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_committee_seminar_en">การอบรมเกี่ยวกับบทบาทหน้าที่กรรมการสมาคมส่งเสริมสถาบันกรรมการบริษัทไทย (En) : </label>
					<div class="controls">
						<textarea name="member_committee_seminar_en" id="member_committee_seminar_en" rows="5" class="ckeditor"><?php echo set_value('member_committee_seminar_en', $info['member_committee_seminar_en']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_other_seminar_th">การอบรมอื่น (ไทย) : </label>
					<div class="controls">
						<textarea name="member_other_seminar_th" id="member_other_seminar_th" rows="5" class="ckeditor"><?php echo set_value('member_other_seminar_th', $info['member_other_seminar_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_other_seminar_en">การอบรมอื่น (En) : </label>
					<div class="controls">
						<textarea name="member_other_seminar_en" id="member_other_seminar_en" rows="5" class="ckeditor"><?php echo set_value('member_other_seminar_en', $info['member_other_seminar_en']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_expertise_th">ความเชี่ยวชาญ (ไทย) : </label>
					<div class="controls">
						<textarea name="member_expertise_th" id="member_expertise_th" rows="5" class="ckeditor"><?php echo set_value('member_expertise_th', $info['member_expertise_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_expertise_en">ความเชี่ยวชาญ (En) : </label>
					<div class="controls">
						<textarea name="member_expertise_en" id="member_expertise_en" rows="5" class="ckeditor"><?php echo set_value('member_expertise_en', $info['member_expertise_en']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_current_position_th">ตำแหน่งปัจจุบันในบริษัท (ไทย) : </label>
					<div class="controls">
						<textarea name="member_current_position_th" id="member_current_position_th" rows="5" class="ckeditor"><?php echo set_value('member_current_position_th', $info['member_current_position_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_current_position_en">ตำแหน่งปัจจุบันในบริษัท (En) : </label>
					<div class="controls">
						<textarea name="member_current_position_en" id="member_current_position_en" rows="5" class="ckeditor"><?php echo set_value('member_current_position_en', $info['member_current_position_en']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<h3>การดำรงตำแหน่งปัจจุบันในกิจการอื่น</h3>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_registered_company_th">บริษัทจดทะเบียน (ไทย) : </label>
					<div class="controls">
						<textarea name="member_registered_company_th" id="member_registered_company_th" rows="5" class="ckeditor"><?php echo set_value('member_registered_company_th', $info['member_registered_company_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_registered_company_en">บริษัทจดทะเบียน (En) : </label>
					<div class="controls">
						<textarea name="member_registered_company_en" id="member_registered_company_en" rows="5" class="ckeditor"><?php echo set_value('member_registered_company_en', $info['member_registered_company_en']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_unregister_company_th">กิจการอื่นที่ไม่ใช่บริษัทจดทะเบียน (ไทย) : </label>
					<div class="controls">
						<textarea name="member_unregister_company_th" id="member_unregister_company_th" rows="5" class="ckeditor"><?php echo set_value('member_unregister_company_th', $info['member_unregister_company_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_unregister_company_en">กิจการอื่นที่ไม่ใช่บริษัทจดทะเบียน (En) : </label>
					<div class="controls">
						<textarea name="member_unregister_company_en" id="member_unregister_company_en" rows="5" class="ckeditor"><?php echo set_value('member_unregister_company_en', $info['member_unregister_company_en']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<h3>สัดส่วนการถือหุ้นของบริษัท</h3>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_sharedholding_ratio">สัดส่วนการถือหุ้นของบริษัท (จำนวนหุ้น) : </label>
					<div class="controls">
						<input type="number" name="member_sharedholding_ratio" id="member_sharedholding_ratio" value="<?php echo set_value('member_sharedholding_ratio', $info['member_sharedholding_ratio']); ?>" min="0.00" max="99999999.00" step="0.01" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="member_sharedholding_percentage">สัดส่วนการถือหุ้นของบริษัท (ร้อยละ) : </label>
					<div class="controls">
						<input type="number" name="member_sharedholding_percentage" id="member_sharedholding_percentage" value="<?php echo set_value('member_sharedholding_percentage', $info['member_sharedholding_percentage']); ?>" min="0.00" max="100.00" step="0.01" class="span6" />
					</div>
				</div>

				<div class="control-group">
                    <label class="control-label" for="member_sharedholding_updatedat">วันที่ปรับปรุงสัดส่วนการถือหุ้นของบริษัท : </label>
                    <div class="controls">
                        <div class="input-append date date-picker" data-date="<?php echo date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy">
                            <input type="text" name="member_sharedholding_updatedat" id="member_sharedholding_updatedat" value="<?php echo set_value('member_sharedholding_updatedat', ( $info['member_sharedholding_updatedat'] == '' ? date("d-m-Y") : $info['member_sharedholding_updatedat'] )); ?>" class="input-small date-picker" readonly />
                            <span class="add-on"><i class="icon-calendar"></i></span>
                        </div>
                        <?php echo form_error('member_sharedholding_updatedat'); ?>
                    </div>
                </div>

                <div class="control-group">
					<label class="control-label" for="member_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="member_status" id="member_status">
							<option value="approved" <?php echo set_select('member_status','approved', $info['member_status'] == 'approved'); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('member_status','pending', $info['member_status'] == 'pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("manageboardmembers/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>