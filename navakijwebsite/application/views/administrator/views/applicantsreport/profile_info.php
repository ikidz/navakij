<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-bookmark"></i> รายละเอียดผู้ฝากประวัติ</h4>
			<span class="tools">
			    <a href="javascript:;" class="icon-chevron-down"></a>
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
			<form method="post" enctype="multipart/form-data" class="form-horizontal">

                <div class="control-group">
                    <label class="control-label" for="job_id">ตำแหน่งงาน : </label>
                    <div class="controls col-12 col-lg-8 px-0 d-flex">
                        <select name="job_id" id="job_id" class="select2" disabled style="width:400px;">
                            <option value="0" <?php echo set_select('job_id',0, true); ?>>-- เลือกตำแหน่งงาน --</option>
                            <?php if( isset( $positions ) && count( $positions ) > 0 ): ?>
                                <?php foreach( $positions as $position ): ?>
                                    <option value="<?php echo $position['job_id']; ?>" <?php echo set_select('job_id', $position['job_id'], $position['job_id'] == @$info['job_id']); ?>><?php echo $position['job_title_'.$this->_language]; ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
				
			</form>
		</div>
	</div>
</div>

<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-user"></i> ประวัติส่วนตัว</h4>
			<span class="tools">
			    <a href="javascript:;" class="icon-chevron-down"></a>
			</span>							
		</div>
		<div class="widget-body form">
			<form method="post" enctype="multipart/form-data" class="form-horizontal">

                <div class="control-group">
                    <label class="control-label" for="profile_name">ชื่อ-นามสกุล <span class="symbol required"></span></label>
                    <div class="controls">
                        <input type="text" name="profile_name" id="profile_name" value="<?php echo set_value('profile_name', $info['profile_name']); ?>" placeholder="ชื่อ-นามสกุล" class="required" readonly />
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="profile_mobile">เบอร์โทรศัพท์มือถือ <span class="symbol required"></span></label>
                    <div class="controls d-flex">
                        <div class="col-8">
                            <input type="tel" name="profile_mobile" id="profile_mobile" value="<?php echo set_value('profile_mobile', $info['profile_mobile']); ?>" class="required validate_mobile" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="profile_email">อีเมล <span class="symbol required"></span></label>
                    <div class="controls">
                        <div class="col-8">
                            <input type="email" name="profile_email" id="profile_email" value="<?php echo set_value('profile_email', $info['profile_email']); ?>" class="required validate_email" readonly />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">ไฟล์</label>
                    <div class="controls d-flex">
                        <div class="col-12">
                            <?php if( $info['profile_file'] != '' && is_file( realpath('public/core/uploaded/leaving_profile/'.$info['profile_file']) ) === true ): ?>
                                <p style="margin-bottom:1rem;">
                                    <a href="<?php echo base_url('public/core/uploaded/leaving_profile/'.$info['profile_file']); ?>" target="_blank">Download</a>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
				
			</form>
		</div>
	</div>
</div>

<div class="span12" style="margin:0;">
	<div class="widget">
		<div class="widget-body form">
				
				<div class="form-actions" style="text-align:center;">
				 	<a class="btn btn-primary" href="<?php echo admin_url("applicantsreport/profiles"); ?>"><i class="icon-reply"></i> Back</a>
				</div>
				
			</form>
		</div>
	</div>
</div>