<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มรายการรางวัล</h4>
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
					<label class="control-label" for="award_image">รูปรางวัล * : </label>
					<div class="controls">
						<div class="preview"></div>
						<input type="file" name="award_image" id="award_image" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb) เท่านั้น</span>
					</div>
				</div>

                <div class="control-group">
                    <label class="control-label" for="award_title_th">ชื่อ (ไทย) * : </label>
                    <div class="controls">
                        <input type="text" name="award_title_th" id="award_title_th" value="<?php echo set_value('award_title_th'); ?>" class="span6" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="award_title_en">ชื่อ (En) * : </label>
                    <div class="controls">
                        <input type="text" name="award_title_en" id="award_title_en" value="<?php echo set_value('award_title_en'); ?>" class="span6" />
                    </div>
                </div>

                <div class="control-group">
					<label class="control-label" for="award_desc_th">รายละเอียด (ไทย) : </label>
					<div class="controls">
						<textarea name="award_desc_th" id="award_desc_th" rows="5" class="ckeditor"><?php echo set_value('award_desc_th'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="award_desc_en">รายละเอียด (En) : </label>
					<div class="controls">
						<textarea name="award_desc_en" id="award_desc_en" rows="5" class="ckeditor"><?php echo set_value('award_desc_en'); ?></textarea>
					</div>
				</div>

                <div class="control-group">
					<label class="control-label" for="award_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="award_status" id="award_status">
							<option value="approved" <?php echo set_select('award_status','approved', true); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('award_status','pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("manageawards/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>