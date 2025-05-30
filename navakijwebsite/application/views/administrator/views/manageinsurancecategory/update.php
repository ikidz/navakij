<link rel="stylesheet" type="text/css" href="<?php echo base_url('public/core/vendors/icomoon/style.css'); ?>" />
<style type="text/css">
	.chzn-single span{
		font-family: 'icomoon', sans-serif !important;
	}
</style>
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
					<label class="control-label" for="insurance_category_banner">แบนเนอร์ * : </label>
					<div class="controls">
						<div class="preview">
							<?php if( $info['insurance_category_banner'] != '' && is_file( realpath('public/core/uploaded/insurance_categories/'.$info['insurance_category_banner']) ) === true ): ?>
								<img src="<?php echo base_url('public/core/uploaded/insurance_categories/'.$info['insurance_category_banner']); ?>" alt="" style="width:300px;" />
							<?php endif; ?>
						</div>
						<input type="file" name="insurance_category_banner" id="insurance_category_banner" class="readfile" />
						<span class="help-inline">* รองรับไฟล์รูปภาพนามสกุล .jpg, .png ไฟล์ต้องมีขนาด (Size) ไม่เกิน 2 เมกะไบต์ (Mb) เท่านั้น</span>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_category_icon">ไอคอน : *</label>
					<div class="controls">
						<select name="insurance_category_icon" id="insurance_category_icon" class="span4 chosen" data-placeholder="เลือก Icon" style="font-family: 'icomoon', sans-serif !important;">
							<option value="" style="font-family: 'icomoon', sans-serif !important;"></option>
						   <?php foreach($this->manageinsurancecategorymodel->get_icons() as $key=>$text){ ?>
					       <option  style="font-family: 'icomoon', sans-serif !important;" value="<?php echo $key; ?>" <?php echo set_select('insurance_category_icon', $key, $key == $info['insurance_category_icon']); ?>><?php echo str_replace("\\","&#x",$text); ?> <?php echo ucfirst(str_replace("icon-","",$key)); ?></option>
					       <?php } ?>
						</select>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="insurance_category_title_th">ชื่อหมวดหมู่ (ไทย) : </label>
					<div class="controls">
						<input type="text" name="insurance_category_title_th" id="insurance_category_title_th" value="<?php echo set_value('insurance_category_title_th', $info['insurance_category_title_th']); ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_category_title_en">ชื่อหมวดหมู่ (En) : </label>
					<div class="controls">
						<input type="text" name="insurance_category_title_en" id="insurance_category_title_en" value="<?php echo set_value('insurance_category_title_en', $info['insurance_category_title_en']); ?>" />
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_category_meta_url">URL : *</label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-link"></i></span>
							<input type="text" class="input-large" name="insurance_category_meta_url" id="insurance_category_meta_url" placeholder="URL *" value="<?php echo set_value('insurance_category_meta_url', $info['insurance_category_meta_url']); ?>" />
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="insurance_category_status">Status : </label>
					<div class="controls">
						<select name="insurance_category_status" id="insurance_category_status">
							<option value="approved" <?php echo set_select('insurance_category_status','approved', $info['insurance_category_status'] == 'approved'); ?>>เปิดการแสดงผล</option>
							<option value="pending" <?php echo set_select('insurance_category_status','pending', $info['insurance_category_status'] == 'pending'); ?>>ปิดการแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("manageinsurancecategory/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	
	/* Auto Generate Meta Tag Title (en) - Start */
	$('body').on('keyup','#insurance_category_title_en', function(){
		if($(this).val()!=''){
			var url = ToSeoUrl( $(this).val() );
			$('#insurance_category_meta_url').val( url );
		}else{
			$('#insurance_category_meta_url').val('');
		}
	});
	/* Auto Generate Meta Tag Title (en) - End */
});
</script>