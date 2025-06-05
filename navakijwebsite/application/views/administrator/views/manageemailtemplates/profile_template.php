<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> <?php echo $page_title; ?></h4>
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

                <?php $success = $this->session->flashdata("message-success"); ?>
                <?php if($success){ ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>การทำรายการเสร็จสมบูรณ์ </strong> <?php echo $success; ?>
                </div>
                <?php } ?>

                <?php if(@$success_message!=NULL){ ?>
                <div class="alert alert-success">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Success !</strong> <?php echo $success_message; ?>
                </div>
                <?php } ?>

                <?php $error_message = validation_errors(); ?>
                <?php if(@$error_message!=NULL){ ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert">×</button>
                    <strong>Error !</strong> <?php echo $error_message; ?>
                </div>
                <?php }?>
				
				<div class="control-group">
                    <label class="control-label" for="email_subject">หัวข้อ : *</label>
                    <div class="controls">
                        <input type="text" name="email_subject" id="email_subject" value="<?php echo set_value('email_subject', $info['subject']['setting_value']); ?>" class="span12" />
                    </div>
                    <div class="controls">
                        <p>&nbsp;</p>
                        <p style="font-size:12px;">คัดลอก <a href="javascript:void(0);" data-text-to-clipboard="{$profile_name}" class="btnClipboard">{$profile_name}</a> สำหรับ ชื่อผู้สมัคร</p>
                        <p style="font-size:12px;">คัดลอก <a href="javascript:void(0);" data-text-to-clipboard="{$profile_createdtime}" class="btnClipboard">{$profile_createdtime}</a> สำหรับ วันที่สมัคร</p>
                        <p style="font-size:12px;">คัดลอก <a href="javascript:void(0);" data-text-to-clipboard="{$position_title_th}" class="btnClipboard">{$posiiotn_title_th}</a> สำหรับ ตำแหน่งงานที่สมัคร</p>
                        <p style="font-size:12px;">คัดลอก <a href="javascript:void(0);" data-text-to-clipboard="{$admin_link_back}" class="btnClipboard">{$admin_link_back}</a> สำหรับ ลิงก์เพื่อกลับมายังหน้าผู้ดูแลระบบ</p>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="email_body">ข้อความ : *</label>
                    <div class="controls">
                        <textarea name="email_body" id="email_body" class="ckeditor"><?php echo set_value('email_body', $info['body']['setting_value']); ?></textarea>
                    </div>
                    <div class="controls">
                        <p>&nbsp;</p>
                        <p style="font-size:12px;">คัดลอก <a href="javascript:void(0);" data-text-to-clipboard="{$profile_name}" class="btnClipboard">{$profile_name}</a> สำหรับ ชื่อผู้สมัคร</p>
                        <p style="font-size:12px;">คัดลอก <a href="javascript:void(0);" data-text-to-clipboard="{$profile_createdtime}" class="btnClipboard">{$profile_createdtime}</a> สำหรับ วันที่สมัคร</p>
                        <p style="font-size:12px;">คัดลอก <a href="javascript:void(0);" data-text-to-clipboard="{$position_title_th}" class="btnClipboard">{$posiiotn_title_th}</a> สำหรับ ตำแหน่งงานที่สมัคร</p>
                        <p style="font-size:12px;">คัดลอก <a href="javascript:void(0);" data-text-to-clipboard="{$admin_link_back}" class="btnClipboard">{$admin_link_back}</a> สำหรับ ลิงก์เพื่อกลับมายังหน้าผู้ดูแลระบบ</p>
                    </div>
                </div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('body').on('click','.btnClipboard', function(){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val( $(this).attr('data-text-to-clipboard') ).select();
        console.log( $temp.val() );
        document.execCommand("copy");
        $temp.remove();
        alert('Copy!');
    });
    /* #btnClipboard handler - End */
});
</script>