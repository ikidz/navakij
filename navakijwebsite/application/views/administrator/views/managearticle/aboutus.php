<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไข About us</h4>
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
					<label class="control-label" for="article_image_th">รูปภาพหลัก : </label>
					<div class="controls">
						<div class="preview">
							<?php if( $info['article_image_th'] != '' && is_file( realpath('public/core/uploaded/article/'.$info['article_image_th']) ) === true ): ?>
								<img src="<?php echo base_url('public/core/uploaded/article/'.$info['article_image_th']); ?>" alt="" style="width:350px;" />
							<?php endif; ?>
						</div>
						<input type="file" name="article_image_th" id="article_image_th" class="readfile" />
						<span class="help-inline">*รรองรับรูปภาพนามสกุล .jpg, .png เท่านั้น และต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb).</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="article_title_th">ชื่อเรื่อง (ไทย) : *</label>
					<div class="controls">
						<input type="text" name="article_title_th" id="article_title_th" value="<?php echo set_value('article_title_th', $info['article_title_th']); ?>" class="span6" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_title_en">ชื่อเรื่อง (En) : *</label>
					<div class="controls">
						<input type="text" name="article_title_en" id="article_title_en" value="<?php echo set_value('article_title_en', $info['article_title_en']); ?>" class="span6" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="article_desc_th">รายละเอียด (ไทย) : </label>
					<div class="controls">
						<textarea name="article_desc_th" id="article_desc_th" rows="5" class="ckeditor"><?php echo set_value('article_desc_th', $info['article_desc_th']); ?></textarea>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="article_desc_en">รายละเอียด (En) : </label>
					<div class="controls">
						<textarea name="article_desc_en" id="article_desc_en" rows="5" class="ckeditor"><?php echo set_value('article_desc_en', $info['article_desc_en']); ?></textarea>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึก</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managearticle/aboutus/"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>