<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขรายการพนักงาน</h4>
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
					<label class="control-label" for="employee_image_th">รูปพนักงาน (ไทย) * : </label>
					<div class="controls">
						<div class="preview">
							<?php if( $info['employee_image_th'] != '' && is_file( realpath('public/core/uploaded/employees/'.$info['employee_image_th']) ) === true ): ?>
								<a href="<?php echo base_url('public/core/uploaded/employees/'.$info['employee_image_th']); ?>" class="fancybox-button">
									<img src="<?php echo base_url('public/core/uploaded/employees/'.$info['employee_image_th']); ?>" alt="" style="width:250px;" />
								</a>
							<?php endif; ?>
						</div>
						<input type="file" name="employee_image_th" id="employee_image_th" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb) และต้องมีขนาด (กว้าง x ยาว) เท่ากับ 1200x1200 พิกเซล (Pixels) เท่านั้น</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="employee_image_en">รูปพนักงาน (En) * : </label>
					<div class="controls">
						<div class="preview">
							<?php if( $info['employee_image_en'] != '' && is_file( realpath('public/core/uploaded/employees/'.$info['employee_image_en']) ) === true ): ?>
								<a href="<?php echo base_url('public/core/uploaded/employees/'.$info['employee_image_en']); ?>" class="fancybox-button">
									<img src="<?php echo base_url('public/core/uploaded/employees/'.$info['employee_image_en']); ?>" alt="" style="width:250px;" />
								</a>
							<?php endif; ?>
						</div>
						<input type="file" name="employee_image_en" id="employee_image_en" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb) และต้องมีขนาด (กว้าง x ยาว) เท่ากับ 1200x1200 พิกเซล (Pixels) เท่านั้น</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="employee_name_th">ชื่อพนักงาน (ไทย) * : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="employee_name_th" id="employee_name_th" placeholder="ชื่อพนักงาน *" value="<?php echo set_value('employee_name_th', $info['employee_name_th']); ?>" />
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="employee_name_en">ชื่อพนักงาน (En) * : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="employee_name_en" id="employee_name_en" placeholder="ชื่อพนักงาน *" value="<?php echo set_value('employee_name_en', $info['employee_name_en']); ?>" />
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="employee_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="employee_status" id="employee_status">
							<option value="approved" <?php echo set_select('employee_status','approved', $info['employee_status'] == 'approved' ); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('employee_status','pending', $info['employee_status'] == 'pending' ); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("manageemployees/index"); ?>"><i class="icon-save"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>