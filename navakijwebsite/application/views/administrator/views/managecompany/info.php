<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> การจัดการข้อมูลบริษัท</h4>
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
				
				<?php //var_dump( is_file( UPLOAD_PATH.'/system_company_logo/'.$info['company_logo'] ) ); ?>
				<?php //echo UPLOAD_PATH.'/system_company_logo/'.$info['company_logo']; ?>
				
				<?php if( $info['company_logo']!='' && is_file( UPLOAD_PATH.'/system_company_logo/'.$info['company_logo'] ) ): ?>
					<div class="control-group">
						<label class="control-label">โลโกบริษัท : </label>
						<div class="controls">
							<a href="<?php echo site_url( 'public/core/uploaded/system_company_logo/'.$info['company_logo'] ); ?>" class="fancybox-button">
								<img src="<?php echo site_url( 'public/core/uploaded/system_company_logo/'.$info['company_logo'] ); ?>" alt="" style="max-width:150px;" />
							</a>
						</div>
					</div>
				<?php endif; ?>
				
				<div class="control-group">
					<label class="control-label">โลโกบริษัท : </label>
					<div class="controls">
						<input type="file" name="company_logo" id="company_logo" />
						<span class="inline-help">* รองรับรูปภาพนามสกุล .png และต้องมีขนาดความจุ (Size) ไม่เกิน 1 เมกะไบต์ (Mb)</span>
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">ชื่อบริษัท : </label>
					<div class="controls">
						<div class="input-prepend">
							<span class="add-on"><i class="icon-building"></i></span>
							<input type="text" name="company_name" id="company_name" placeholder="กรุณาระบุชื่อบริษัท" value="<?php echo set_value( 'company_name', $info['company_name'] ); ?>" />
						</div>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managecompany/index"); ?>"><i class="icon-save"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>