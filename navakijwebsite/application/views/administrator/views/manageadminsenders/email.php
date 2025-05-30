<div class="span12">
    <!-- BEGIN RECENT ORDERS PORTLET-->
    <div class="widget">
        <div class="widget-title widget-user">
            <h4><i class="icon-list-alt"></i> รายการอีเมลของผู้ดูแลระบบ</h4>
            <span class="tools">

            </span>
        </div>
        <div class="widget-body form">
            <form method="post" name="menu_form" id="menu_form" enctype="multipart/form-data">

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
                    <label class="control-label" for="setting_value">รายการอีเมล :</label>
                    <div class="controls">
                        <input type="text" class="span12" name="setting_value" id="setting_value" value="<?php echo set_value('setting_value', $info['setting_value']); ?>"/>
                    </div>
                    <div class="controls">
                        <p style="font-size:12px;">ใช้ , คั่นสำหรับส่งหลายคน</p>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>