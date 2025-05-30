<div class="span12">
    <!-- BEGIN RECENT ORDERS PORTLET-->
    <div class="widget">
        <div class="widget-title widget-user">
            <h4><i class="icon-list-alt"></i> ตั้งค่าลบข้อมูลอัตโนมัติ</h4>
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
                    <label class="control-label" for="setting_value">จำนวนวัน :</label>
                    <div class="controls">
                        <input type="number" name="setting_value" id="setting_value" value="<?php echo set_value('setting_value', $info['setting_value']); ?>" step="1" min="0" max="999999" class="span2" />
                        <span class="help-inline">วัน</span>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>