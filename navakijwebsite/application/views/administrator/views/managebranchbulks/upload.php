<div class="span12" style="margin:0! important;">
	<div class="widget">
		<div class="widget-title">
			<h4>
				<i class="icon-plus"></i> เพิ่มไฟล์
			</h4>
			<?php /* 
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>	
			*/ ?>						
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
            <form method="post" enctype="multipart/form-data" id="uploadForm" action="" class="form-horizontal form-inline">

				<div class="control-group">
					<label class="control-label" for="category_id">หมวดหมู่ * :</label>
					<div class="controls">
						<select name="category_id" id="category_id">
							<option value="" <?php echo set_select('category_id','', true); ?>>-- เลือกหมวดหมู่ --</option>
							<?php if( isset( $categories ) && count( $categories ) > 0 ): ?>
								<?php foreach( $categories as $category ): ?>
									<option value="<?php echo $category['category_id']; ?>" <?php echo set_select('category_id', $category['category_id']); ?>><?php echo $category['category_title_th']; ?></option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="bulk_title">ชื่อกลุ่มข้อมูล * :</label>
					<div class="controls">
						<input type="text" name="bulk_title" id="bulk_title" value="<?php echo set_value('bulk_title'); ?>" class="span6" />
					</div>
				</div>
            
                <div class="control-group">
					<label class="control-label" for="bulk_file">ไฟล์ : </label>
					<div class="controls">
                        <input type="file" id="bulk_file" name="bulk_file">
						<span class="help-inline">*รองรับไฟล์นามสกุล .xls, .xlsx เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 100 เมกะไบต์ (Mb)</span>
						<p class="helper" style="margin-top:0.25rem;">ตัวอย่างไฟล์สำหรับใส่ข้อมูลเพื่ออัพโหลด : <a href="<?php echo assets_url('download/branches_import_template.xlsx?v='.date('Ymd')); ?>" target="_blank"><i class="icon icon-download"></i> ดาวน์โหลด</a></p>
					</div>
                </div>
                
                <div class="form-actions" style="text-align:center;">
					<button type="submit" class="btn btn-success" id="btn-submit"><i class="icon-upload"></i> อัพโหลดไฟล์</button>
				 	<a class="btn btn-danger" href="<?php echo admin_url("managebranchbulks/index"); ?>"><i class="icon-times"></i> ยกเลิก</a>
				 	<a class="btn btn-primary" href="<?php echo admin_url("managebranchcategories/index"); ?>"><i class="icon-undo"></i> กลับไปยังเครือข่ายสินไหมฯ</a>
				</div>
				
			</form>
		</div>
	</div>
</div>