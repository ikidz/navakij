<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขรายการสถานที่</h4>
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
					<label class="control-label" for="location_title_th">ขื่อสถานที่ (ไทย) : </label>
					<div class="controls">
						<input type="text" name="location_title_th" id="location_title_th" value="<?php echo set_value('location_title_th', $info['location_title_th']); ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="location_title_en">ขื่อสถานที่ (En) : </label>
					<div class="controls">
						<input type="text" name="location_title_en" id="location_title_en" value="<?php echo set_value('location_title_en', $info['location_title_en']); ?>" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="location_status">Status : </label>
					<div class="controls">
						<select name="location_status" id="location_status">
							<option value="approved" <?php echo set_select('location_status','approved', $info['location_status'] == 'approved' ); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('location_status','pending', $info['location_status'] == 'pending' ); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managelocations/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>