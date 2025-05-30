<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มตำแหน่งผู้บริหาร</h4>
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
                    <label class="control-label" for="position_title_th">ชื่อ (ไทย) : *</label>
                    <div class="controls">
                        <input type="text" name="position_title_th" id="position_title_th" value="<?php echo set_value('position_title_th'); ?>" class="span6" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="position_title_en">ชื่อ (En) : *</label>
                    <div class="controls">
                        <input type="text" name="position_title_en" id="position_title_en" value="<?php echo set_value('position_title_en'); ?>" class="span6" />
                    </div>
                </div>

                <div class="control-group">
					<label class="control-label" for="position_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="position_status" id="position_status">
							<option value="approved" <?php echo set_select('position_status','approved', true); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('position_status','pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<input type="hidden" name="main_id" id="main_id" value="<?php echo $mainId; ?>" />
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managepositions/index/".$mainId); ?>"><i class="icon-save"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>