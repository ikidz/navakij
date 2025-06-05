<div class="span12" style="margin:0! important;">
	<div class="widget">
		<div class="widget-title">
			<h4>
				<i class="icon-plus"></i> เพิ่มรูปภาพ
			</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
            <form method="post" enctype="multipart/form-data" id="uploadForm" action="<?php echo admin_url('managegallery/uploadImages/'.$category['category_id'].'/'.$article['article_id']); ?>" class="form-horizontal form-inline">
            
                <div class="control-group">
					<label class="control-label" for="gallery_image">รูปภาพ : </label>
					<div class="controls">
                        <input type="file" multiple id="gallery-photo-add" name="gallery-photo-add[]">
                        <div class="gallery" style="margin-top:2rem;"></div>
						<span class="help-inline">*รองรับรูปภาพนามสกุล .jpg, .png เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb) ไม่เกินครั้งละ 20 ภาพ.</span>
					</div>
                </div>
                
                <div class="form-actions" style="text-align:center;">
					<button type="submit" class="btn btn-success" id="btn-submit"><i class="icon-upload"></i> อัพโหลดรูปภาพ</button>
				 	<a class="btn btn-danger" href="<?php echo admin_url("managegallery/index/".$category['category_id'].'/'.$article['article_id']); ?>"><i class="icon-times"></i> ยกเลิก</a>
				 	<a class="btn btn-primary" href="<?php echo admin_url("managearticle/index/".$category['category_id']); ?>"><i class="icon-undo"></i> กลับไปยังรายการบทความ</a>
				</div>
				
			</form>
		</div>
	</div>
</div>