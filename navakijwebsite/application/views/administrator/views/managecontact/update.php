<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> รายการติดต่อเรา</h4>
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
					<label class="control-label" for="name">ชื่อ-นามสกุล: </label>
					<div class="controls">
					<input type="text" name="contact_name" id="contact_name" value="<?php echo $info['contact_name'].' '.$info['contact_lastname']; ?>" class="span6" readonly />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="email">อีเมล: </label>
					<div class="controls">
					<input type="text" name="contact_email" id="contact_email" value="<?php echo $info['contact_email']; ?>" class="span6" readonly />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="telephone">เบอร์ติดต่อ: </label>
					<div class="controls">
					<input type="text" name="contact_mobile" id="contact_mobile" value="<?php echo $info['contact_mobile']; ?>" class="span6" readonly />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="province">ข้อความ: </label>
					<div class="controls">
					<textarea name="insurance_sdesc_th" id="contact_message" rows="3" readonly><?php echo set_value('contact_message', $info['contact_message']);  ?></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="contact_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="contact_status" id="contact_status">
							<option value="approved" <?php echo set_select('contact_status','approved', $info['contact_status'] == 'approved'); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('contact_status','pending', $info['contact_status'] == 'pending'); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managecontact/index/"); ?>"><i class="icon-save"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>
