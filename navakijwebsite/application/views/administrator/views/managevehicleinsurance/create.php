<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มบทความ</h4>
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
					<label class="control-label" for="vehicle_group_id">ประเภทรถยนต์ : *</label>
					<div class="controls">
						<select name="vehicle_group_id" id="vehicle_group_id" class="span6">
							<?php foreach($vehicle_group as $rs){ ?>
							<option value="<?php echo $rs['vehicle_group_id'];?>" ><?php echo $rs['vehicle_group_title_th'];?></option>
							<?php }?>
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="sum_insured">เงินเอาประกันภัย : </label>
					<div class="controls">
						<input type="text" name="sum_insured" id="sum_insured" value="<?php echo set_value('sum_insured'); ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="price">เบี้ยประกันภัย : </label>
					<div class="controls">
						<input type="text" name="price" id="price" value="<?php echo set_value('price'); ?>" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="vehicle_insurance_desc_th">รายละเอียด (ไทย) : </label>
					<div class="controls">
						<textarea name="vehicle_insurance_desc_th" id="vehicle_insurance_desc_th" rows="5" class="ckeditor"><?php echo set_value('vehicle_insurance_desc_th'); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="vehicle_insurance_desc_en">รายละเอียด (En) : </label>
					<div class="controls">
						<textarea name="vehicle_insurance_desc_en" id="vehicle_insurance_desc_en" rows="5" class="ckeditor"><?php echo set_value('vehicle_insurance_desc_en'); ?></textarea>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="vehicle_insurance_status">สถานะการแสดงผล : *</label>
					<div class="controls">
						<select name="vehicle_insurance_status" id="vehicle_insurance_status">
							<option value="approved" <?php echo set_select('vehicle_insurance_status','approved', true); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('vehicle_insurance_status','pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>

				
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึก</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managevehicleinsurance/index/".$insurance['insurance_id']); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>