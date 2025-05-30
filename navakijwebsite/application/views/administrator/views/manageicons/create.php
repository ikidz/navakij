<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มรายการไอคอน</h4>
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
					<label class="control-label" for="icon_image">รูปภาพ : </label>
					<div class="controls">
                        <div class="preview"></div>
						<input type="file" name="icon_image" id="icon_image" class="readfile" />
						<label class="help-inline">* รองรับรูปภาพนามสกุล .jpg, .png, .gif เท่านั้น และต้องมีขนาดไม่เกิน 2 เมกะไบต์ (Mb)</label>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="icon_title_th">ชื่อ (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="icon_title_th" id="icon_title_th" value="<?php echo set_value('icon_title_th'); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="icon_title_en">ชื่อ (En) : *</label>
					<div class="controls">
						<input type="text" name="icon_title_en" id="icon_title_en" value="<?php echo set_value('icon_title_en'); ?>" class="span6" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="icon_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="icon_status" id="icon_status">
							<option value="approved" <?php echo set_select('icon_status','approved', TRUE); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('icon_status','pending'); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึก</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("manageicons/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>