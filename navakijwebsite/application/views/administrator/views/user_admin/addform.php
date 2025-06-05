<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มข้อมูลผู้ใช้งาน</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
			<form method="post" class="form-horizontal">
			
				<div class="control-group">
				 <label class="control-label" for="username">ชื่อผู้ใช้งาน : *</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-lock"></i></span>
				       <input class="input-large" name="username" id="username" type="text" placeholder="กรุณาระบุชื่อผู้ใช้งาน" value="<?php echo set_value('username'); ?>" />	
				        
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="password">ตั้งรหัสผ่าน : *</label>
				 <div class="controls">
				    <div class="input-append input-prepend">
				       <span class="add-on"><i class="icon-key"></i></span>
				       <input class="input-large" name="password" id="password" type="password" placeholder="กรุณาระบุรหัสผ่านใหม่" />	
				       <button type="button" onclick="random_password();" class="btn btn-info"><i class="icon-random"></i> สุ่มตั้งรหัส</button>		
				    </div>
				    <span class="help-inline rand_pass_display"></span>
				    
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="repassword">ตั้งรหัสผ่านอีกครั้ง : *</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-key"></i></span>
				       <input class="input-large" name="repassword" id="repassword" type="password" placeholder="กรุณาระบุรหัสผ่านใหม่อีกครั้ง" />	
				    </div>
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="username">ชื่อ-สกุล : *</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-asterisk"></i></span>
				       <input class="input-large" name="user_fullname" id="user_fullname" type="text" placeholder="กรุณาระบุชื่อ-สกุล" value="<?php echo set_value('user_fullname'); ?>" />	
				        
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="username">อีเมลล์ : *</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-envelope"></i></span>
				       <input class="input-large" name="user_email" id="user_email" type="email" placeholder="กรุณาระบุอีเมลล์" value="<?php echo set_value('user_email'); ?>" />	
				        
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="username">โทรศัพท์มือถือ : *</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-mobile-phone"></i></span>
				       <input class="input-large" name="user_mobileno" id="user_mobileno" type="tel" placeholder="กรุณาระบุโทรศัพท์มือถือ" value="<?php echo set_value('user_mobileno'); ?>" />	
				        
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >กลุ่มผู้ใช้งาน : *</label>
					<div class="controls">
						<select name="user_group" id="user_group" class="span4" data-placeholder="เลือกกลุ่มผู้ใช้งาน">
						   <?php foreach($this->admin_library->getAllGroup()->result_array() as $rs){ ?>
		                   <option value="<?php echo $rs['group_id']; ?>" <?php if(set_value("user_group")==$rs['group_id']){ ?> selected="selected" <?php } ?>><?php echo $rs['group_name']; ?></option>
		                   <?php } ?>
						</select>
					</div>
				</div>
                
                <div class="control-group">
					<label class="control-label" >สถานะผู้ใช้ : *</label>
					<div class="controls">
						<select name="user_status" id="user_status" class="span4" data-placeholder="เลือกสถานะ">
						   <option value="active">เปิดใช้งาน</option>
						   <option value="suspend" <?php if(set_value('user_status')=="suspend"){ ?> selected="selected" <?php } ?>>ระงับสิทธิ์</option>
						</select>
					</div>
				</div>
				
				              
				<div class="form-actions">
				 	<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกการเปลี่ยนแปลง</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("user_admin/index"); ?>"><i class="icon-reply"></i> ยกเลิกการแก้ไข</a>
				</div>
			 </form>
		</div>
	</div>
</div>
<script type="text/javascript">
function random_password()
{
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
    var string_length = 6;
    var randomstring = '';
    for (var i=0; i<string_length; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        randomstring += chars.substring(rnum,rnum+1);
    }
    $("#password,#repassword").val(randomstring);
    $(".rand_pass_display").text("Password is "+randomstring);
}
</script>