<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขข้อมูลตัวแทน</h4>
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
					<label class="control-label" for="agent_name_th">ชื่อตัวแทน (ไทย) * : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="agent_name_th" id="agent_name_th" placeholder="ชื่อตัวแทน (ไทย) *" value="<?php echo set_value('agent_name_th', $info['agent_name_th']); ?>" />
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="agent_name_en">ชื่อตัวแทน (En) : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="agent_name_en" id="agent_name_en" placeholder="ชื่อตัวแทน (En)" value="<?php echo set_value('agent_name_en', $info['agent_name_en']); ?>" />
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="agent_license_no">เลขที่ใบอนุญาต * : </label>
					<div class="controls">
						<div class="input-append">
							<span class="add-on"><i class="icon-font"></i></span>
							<input type="text" class="input-large" name="agent_license_no" id="agent_license_no" placeholder="เลขที่ใบอนุญาต *" value="<?php echo set_value('agent_license_no', $info['agent_license_no']); ?>" />
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="agent_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="agent_status" id="agent_status">
							<option value="approved" <?php echo set_select('agent_status','approved', $info['agent_status'] == 'approved'); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('agent_status','pending', $info['agent_status'] == 'pending'); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
								
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managesellagents/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>