<div class="span12">
    <!-- BEGIN RECENT ORDERS PORTLET-->
    <div class="widget">
        <div class="widget-title widget-user">
            <h4><i class="icon-list-alt"></i> ที่อยู่</h4>
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
                    <label class="control-label" for="company_title_th">ชื่อองค์กร (ไทย) :</label>
                    <div class="controls">
                        <input type="text" name="company_title_th" id="company_title_th" class="span6" value="<?php echo set_value('company_title_th', $companyTitle_th['setting_value']); ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="company_title_en">ชื่อองค์กร (En) :</label>
                    <div class="controls">
                        <input type="text" name="company_title_en" id="company_title_en" class="span6" value="<?php echo set_value('company_title_en', $companyTitle_en['setting_value']); ?>" />
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="company_address_th">ที่อยู่องค์กร (ไทย) :</label>
                    <div class="controls">
                        <textarea class="span6 ckeditor" name="company_address_th" id="company_address_th" rows="5" style="resize:none;"><?php echo set_value('company_address_th', $companyAddress_th['setting_value']); ?></textarea>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="company_address_en">ที่อยู่องค์กร (En) :</label>
                    <div class="controls">
                        <textarea class="span6 ckeditor" name="company_address_en" id="company_address_en" rows="5" style="resize:none;"><?php echo set_value('company_address_en', $companyAddress_en['setting_value']); ?></textarea>
                    </div>
                </div>
                
                <?php /*
                <div class="control-group">
                    <label class="control-label" for="company_tel">เบอร์โทรศัพท์ :</label>
                    <div class="controls">
                        <input type="text" name="company_tel" id="company_tel" class="span6" value="<?php echo set_value('company_tel', $companyTel['setting_value']); ?>" />
                        <p class="help-inline">ใช้เครื่องหมาย , คั่นหากมีหลายเบอร์โทรศัพท์</p>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="company_fax">เบอร์โทรสาร :</label>
                    <div class="controls">
                        <input type="text" name="company_fax" id="company_fax" class="span6" value="<?php echo set_value('company_fax', $companyFax['setting_value']); ?>" />
                        <p class="help-inline">ใช้เครื่องหมาย , คั่นหากมีหลายเบอร์โทรสาร</p>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="company_email">อีเมล :</label>
                    <div class="controls">
                        <input type="text" name="company_email" id="company_email" class="span6" value="<?php echo set_value('company_email', $companyEmail['setting_value']); ?>" />
                        <p class="help-inline">ใช้เครื่องหมาย , คั่นหากมีหลายอีเมล</p>
                    </div>
                </div>
                */ ?>
                
                <div class="control-group">
                    <label class="control-label" for="company_google_map">Google Map URL :</label>
                    <div class="controls">
                        <input type="text" name="company_google_map" id="company_google_map" class="span6" value="<?php echo set_value('company_google_map', $companyGoogleMap['setting_value']); ?>" />
                    </div>
                </div>
                
                <div class="control-group">
                    <div class="controls">
                        <input type="text" name="company_location_lat" id="company_location_lat" class="span2" placeholder="Latitude" value="<?php echo set_value('company_location_lat', $companyLocation_lat['setting_value']); ?>" />
                         , 
                        <input type="text" name="company_location_lng" id="company_location_lng" class="span2" placeholder="Longitude" value="<?php echo set_value('company_location_lng', $companyLocation_lng['setting_value']); ?>" />
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </form>
        </div>
    </div>
</div>