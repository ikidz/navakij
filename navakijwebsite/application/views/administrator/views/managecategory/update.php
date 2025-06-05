<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขหมวดหมู่</h4>
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
					<label class="control-label" for="is_use_icon">ใช้ไอคอน : </label>
					<div class="controls">
						<input type="checkbox" name="is_use_icon" id="is_use_icon" value="1" <?php echo set_checkbox('is_use_icon', $info['is_use_icon'] == 1); ?> />
					</div>
				</div>
				<div class="cover control-group" <?php echo ( $info['is_use_icon'] == 1 ? 'style="display:none;"' : '' ); ?>>
					<label class="control-label" for="category_thumbnail">รูปภาพปก : </label>
					<div class="controls">
						<div class="preview">
							<?php if( $info['category_thumbnail'] != '' && is_file( realpath('public/core/uploaded/category/'.$info['category_thumbnail']) ) === true ): ?>
								<img src="<?php echo base_url('public/core/uploaded/category/'.$info['category_thumbnail']); ?>" alt="" style="width:300px;" />
							<?php endif; ?>
						</div>
						<input type="file" name="category_thumbnail" id="category_thumbnail" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb)</span>
					</div>
				</div>
				<div class="theicon control-group" <?php echo ( $info['is_use_icon'] == 0 ? 'style="display:none;"' : '' ); ?>>
					<label class="control-label" for="category_icon">ไอคอน : <?php echo $info['category_icon']; ?></label>
					<div class="controls">
						<select name="category_icon" id="category_icon" class="chosen" data-placeholder="เลือก Icon" style="font-family: 'FontAwesome',Tahoma;">
							<option value=""></option>
						   <?php foreach($this->menu_model->get_icons() as $key=>$text){ ?>
					       <option  style="font-family: 'FontAwesome',Tahoma;" value="<?php echo $key; ?>" <?php if(set_value("category_icon", $info['category_icon'])==$key){ ?> selected="selected" <?php } ?>><?php echo str_replace("\\","&#x",$text); ?> <?php echo ucfirst(str_replace("icon-","",$key)); ?></option>
					       <?php } ?>
						</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="category_title_th">ชื่อหมวดหมู่ (ไทย) : </label>
					<div class="controls">
						<input type="text" name="category_title_th" id="category_title_th" value="<?php echo set_value('category_title_th', $info['category_title_th']); ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="category_title_en">ชื่อหมวดหมู่ (En) : </label>
					<div class="controls">
						<input type="text" name="category_title_en" id="category_title_en" value="<?php echo set_value('category_title_en', $info['category_title_en']); ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="category_meta_url">URL : *</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-link"></i></span>
							<input type="text" class="input-large" name="category_meta_url" id="category_meta_url" placeholder="URL *" value="<?php echo set_value('category_meta_url', $info['category_meta_url']); ?>" />
						</div>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="category_status">Status : </label>
					<div class="controls">
						<select name="category_status" id="category_status">
							<option value="approved" <?php echo set_select('category_status','approved', $info['category_status'] == 'approved'); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('category_status','pending', $info['category_status'] == 'pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<input type="hidden" name="main_id" id="main_id" value="<?php echo ( isset( $maincategory ) && count( $maincategory ) > 0 ? $maincategory['category_id'] : 0 ); ?>" />
					<input type="hidden" name="category_id" id="category_id" value="<?php echo $info['category_id']; ?>" />
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managecategory/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	
	/* Auto Generate Meta Tag Title (en) - Start */
	$('body').on('keyup','#category_title_en', function(){
		if($(this).val()!=''){
			var url = ToSeoUrl( $(this).val() );
			$('#category_meta_url').val( url );
		}else{
			$('#category_meta_url').val('');
		}
	});
	/* Auto Generate Meta Tag Title (en) - End */
});
</script>