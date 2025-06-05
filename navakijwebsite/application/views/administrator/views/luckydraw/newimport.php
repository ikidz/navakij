<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มเมนูใหม่</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
			<?php 
				if(isset($error_message)){
					echo '<div class="alert alert-error">
						<button class="close" data-dismiss="alert">×</button>
						<strong>เกิดข้อผิดพลาด </strong>'.$error_message.'</div>';
				}
				 ?>
			<form method="post" class="form-horizontal" enctype="multipart/form-data">
				<div class="control-group">
					<label class="control-label">วันที่ข้อมูล : *</label>
						<div class="controls">
							<div class="input-append date date-picker" data-date="<?php echo set_value("key_date",date("d-m-Y")); ?>" data-date-format="dd-mm-yyyy" data-date-viewmode="day">
							   <input name="key_date" id="key_date" required="required" class="input-small date-picker" size="16" type="text" value="<?php echo set_value("key_date",date("d-m-Y")); ?>" ><span class="add-on"><i class="icon-calendar"></i></span>
							</div>
						</div>
				</div>
				<div class="control-group">
					<label class="control-label">ไฟล์ข้อมูล (Excel) : *</label>
						<div class="controls">
							   <input name="file_import" id="file_import" type="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" >
							   <p class="help-block"><i class="icon-question-circle"></i> รองรับไฟล์เฉพาะ นามสกุล .xls และ .xlsx เท่านั้น ขนาดไฟล์ไม่เกิน <?php echo upload_max_filesize; ?>    <a href="<?php echo base_url("public/uploads/excel_import/Importform.xls"); ?>" target="_blank">ดาวน์โหลดไฟล์ตัวอย่างได้ที่นี่</a></p>
						</div>
				</div>
				<div class="form-actions">
				 	<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> นำเข้าข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("luckydraw/index"); ?>"><i class="icon-reply"></i> ยกเลิกการแก้ไข</a>
				</div>
			</form>
		</div>
	</div>
</div>