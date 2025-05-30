<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> แก้ไขประเภทเครือข่าย</h4>
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
					<label class="control-label" for="category_title_th">ชื่อประเภท (ไทย) : </label>
					<div class="controls">
						<input type="text" name="category_title_th" id="category_title_th" value="<?php echo set_value('category_title_th', $info['category_title_th']); ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="category_title_en">ชื่อประเภท (En) : </label>
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
					<label class="control-label" for="category_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select name="category_status" id="category_status">
							<option value="approved" <?php echo set_select('category_status','approved', $info['category_status'] == 'approved'); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('category_status','pending', $info['category_status'] == 'pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managebranchcategories/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
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