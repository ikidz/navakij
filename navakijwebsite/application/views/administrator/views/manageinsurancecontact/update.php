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
				<?php 
				if($info['insurance_contact_gender'] == 'male')
				{
					$gender = "ผู้ชาย";
				}else{
					$gender = "ผู้หญิง";
				}
				?>
				<div class="control-group">
					<label class="control-label" for="name">ชื่อ-นามสกุล: </label>
					<div class="controls">
						<input type="text" name="document_file_title_en" id="document_file_title_en" value="<?php echo $info['insurance_contact_name'].' '.$info['insurance_contact_lastname']; ?>" class="span6" readonly />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="gender">เพศ: </label>
					<div class="controls">
						<input type="text" name="document_file_title_en" id="document_file_title_en" value="<?php echo $gender; ?>" class="span6" readonly />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="email">อีเมล: </label>
					<div class="controls">
						<input type="text" name="document_file_title_en" id="document_file_title_en" value="<?php echo $info['insurance_contact_email']; ?>" class="span6" readonly />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="telephone">เบอร์ติดต่อ: </label>
					<div class="controls">
						<input type="text" name="document_file_title_en" id="document_file_title_en" value="<?php echo $info['insurance_contact_mobile']; ?>" class="span6" readonly />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="province">จังหวัด: </label>
					<div class="controls">
						<input type="text" name="document_file_title_en" id="document_file_title_en" value="<?php echo $this->manageinsurancecontactmodel->get_provinces_name($info['province_id']); ?>" class="span6" readonly />
					</div>
				</div>
				
				<div class="form-actions" style="text-align:center;">
				 	<a class="btn btn-primary" href="<?php echo admin_url("manageinsurancecontact/index/".$info['insurance_id']); ?>"><i class="icon-undo"></i> ย้อนกลับ</a>
				</div>
				
			</form>
		</div>
	</div>
</div>
