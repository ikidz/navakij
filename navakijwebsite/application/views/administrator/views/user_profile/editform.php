<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> ปรับปรุงข้อมูลผู้ใช้งาน</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
			<?php echo @$upload_error; ?>
			<form method="post" class="form-horizontal" enctype="multipart/form-data">
				
				<div class="control-group">
				 <label class="control-label" for="avatar_file">รูปโปรไฟล์ :</label>
				 <div class="controls">
				       <input type="file" name="avatar_file" id="avatar_file" class="avatar_file" />
				       <p class="help-block">ให้เว้นว่างไว้หากไม่ต้องการเปลี่ยน ขนาดไฟล์ไม่เกิน 1 MB หรือ 1024x1024px</p>
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="username">ชื่อผู้ใช้งาน : *</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-lock"></i></span>
				       <input class="input-large" name="username" id="username" type="text" placeholder="กรุณาระบุชื่อผู้ใช้งาน" value="<?php echo set_value('username',$row['username']); ?>" />	
				        
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="password">ตั้งรหัสผ่าน :</label>
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
				 <label class="control-label" for="repassword">ตั้งรหัสผ่านอีกครั้ง :</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-key"></i></span>
				       <input class="input-large" name="repassword" id="repassword" type="password" placeholder="กรุณาระบุรหัสผ่านใหม่อีกครั้ง" />	
				    </div>
				     <p class="help-block">รหัสผ่านให้เว้นว่างไว้หากไม่ต้องการเปลี่ยนรหัสผ่าน</p>
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="username">ชื่อ-สกุล : *</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-asterisk"></i></span>
				       <input class="input-large" name="user_fullname" id="user_fullname" type="text" placeholder="กรุณาระบุชื่อ-สกุล" value="<?php echo set_value('user_fullname',$row['user_fullname']); ?>" />	
				        
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="username">อีเมลล์ : *</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-envelope"></i></span>
				       <input class="input-large" name="user_email" id="user_email" type="email" placeholder="กรุณาระบุอีเมลล์" value="<?php echo set_value('user_email',$row['user_email']); ?>" />	
				        
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="username">โทรศัพท์มือถือ : *</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-mobile-phone"></i></span>
				       <input class="input-large" name="user_mobileno" id="user_mobileno" type="tel" placeholder="กรุณาระบุโทรศัพท์มือถือ" value="<?php echo set_value('user_mobileno',$row['user_mobileno']); ?>" />	
				        
				    </div>
				    
				 </div>
				</div>            
				<div class="form-actions">
				 	<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกการเปลี่ยนแปลง</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("user_profile/index"); ?>"><i class="icon-reply"></i> ยกเลิกการแก้ไข</a>
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