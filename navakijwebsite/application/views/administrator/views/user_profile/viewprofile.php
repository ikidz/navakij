<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> ข้อมูลผู้ใช้งาน</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php $success = $this->session->flashdata("message-success"); ?>
			<?php if($success){ ?>
			<div class="alert alert-success">
				<button class="close" data-dismiss="alert">×</button>
				<strong>การทำรายการเสร็จสมบูรณ์ </strong> <?php echo $success; ?>
			</div>
			<?php } ?>
			
			<?php $info = $this->session->flashdata("message-info"); ?>
			<?php if($info){ ?>
			<div class="alert alert-info">
				<button class="close" data-dismiss="alert">×</button>
				<strong>ข้อมูลเพิ่มเติม </strong> <?php echo $info; ?>
			</div>
			<?php } ?>
			
			<?php $error = $this->session->flashdata("message-error"); ?>
			<?php if($error){ ?>
			<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong> <?php echo $error; ?>
			</div>
			<?php } ?>
			<?php $warning = $this->session->flashdata("message-warning"); ?>
			<?php if($warning){ ?>
			<div class="alert">
				<button class="close" data-dismiss="alert">×</button>
				<strong>คำเตือน </strong> <?php echo $warning; ?>
			</div>
			<?php } ?>
			<form method="post" class="form-horizontal">
			
				<div class="control-group">
				 <label class="control-label" for="username">รูปโปรไฟล์ :</label>
				 <div class="controls">
				    <div class="profile_image">
				    	<?php if($row['user_avatar'] != ""){ ?>
				    	<img src="<?php echo site_url("src/128x128/user_admin/".$row['user_avatar']); ?>" />
				    	<?php }else{ ?>
					    <i class="icon-user"></i>
					    <?php } ?>
				    </div>
				    
				 </div>
				</div>
				<div class="control-group">
				 <label class="control-label" for="username">ชื่อผู้ใช้งาน :</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-lock"></i></span>
				       <input class="input-large" type="text" placeholder="กรุณาระบุชื่อผู้ใช้งาน" value="<?php echo $row['username']; ?>" disabled="disabled" />	
				        
				    </div>
				    
				 </div>
				</div>
				<div class="control-group">
				 <label class="control-label" for="username">ชื่อ-สกุล :</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-asterisk"></i></span>
				        <input class="input-large" type="text" placeholder="กรุณาระบุชื่อผู้ใช้งาน" value="<?php echo $row['user_fullname']; ?>" disabled="disabled" />
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="username">อีเมลล์ :</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-envelope"></i></span>
				        <input class="input-large" type="text" placeholder="กรุณาระบุอีเมลล์" value="<?php echo $row['user_email']; ?>" disabled="disabled" />
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
				 <label class="control-label" for="username">โทรศัพท์มือถือ :</label>
				 <div class="controls">
				    <div class="input-prepend">
				       <span class="add-on"><i class="icon-mobile-phone"></i></span>	
				        <input class="input-large" type="text" placeholder="กรุณาระบุโทรศัพท์มือถือ" value="<?php echo $row['user_mobileno']; ?>" disabled="disabled" />
				    </div>
				    
				 </div>
				</div>
				
				<div class="control-group">
					<label class="control-label" >กลุ่มผู้ใช้งาน :</label>
					<div class="controls">
					    <div class="input-prepend">
					       <span class="add-on"><i class="icon-group"></i></span>	
					        <input class="input-large" type="text" placeholder="กรุณาระบุกลุ่มผู้ใช้งาน" value="<?php echo $this->admin_library->getGroupName($row['user_group']); ?>" disabled="disabled" />
					    </div>
				    
					</div>
				</div>
                
                <div class="control-group">
					<label class="control-label" >สถานะผู้ใช้ :</label>
					<div class="controls">
					    <div class="input-prepend">
					       <span class="add-on"><i class="icon-lock"></i></span>	
					        <input class="input-large" type="text" placeholder="กรุณาระบุสถานะผู้ใช้" value="<?php echo ($row['user_status'])?"เปิดใช้งาน":"ระงับสิทธิ์"; ?>" disabled="disabled" />
					    </div>
				    
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" ></label>
					<div class="controls">
						<div class="input-prepend input-append">
							<a  href="<?php echo admin_url("user_profile/edit"); ?>" class="btn btn-info"><i class="icon-edit"></i> แก้ไขข้อมูลส่วนตัว</a>
							<a  href="<?php echo admin_url("logout"); ?>" class="btn btn-danger"><i class="icon-signout"></i> ออกจากระบบ</a>
						</div>
					</div>
				</div>
			 </form>
		</div>
	</div>
</div>
<style type="text/css">
.profile_image{
	width: 128px;
	height: 128px;
	text-align: center;
	vertical-align: middle;
	border: solid 1px #e0e0e0;
	padding: 1px;
}
.profile_image i{
	font-size: 128px;
}
.profile_image img{
	width: 128px;
	height: 128px;
}
</style>