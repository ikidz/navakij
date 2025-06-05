<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4>
				<i class="icon-plus"></i> เพิ่มรูปภาพ
			</h4>
			<span class="tools">
			<a href="javascript:;" class="icon-chevron-down"></a>
			<a href="<?php echo current_url(); ?>" class="icon-refresh"></a>		
			</span>							
		</div>
		<div class="widget-body form">
			<?php echo validation_errors('<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>
				<strong>เกิดข้อผิดพลาด </strong>','</div>'); ?>
            <form method="post" enctype="multipart/form-data" id="sortform" class="form-horizontal form-inline filesupload">
            
				<!-- Redirect browsers with JavaScript disabled to the origin page -->
                <noscript
                ><input
                    type="hidden"
                    name="redirect"
                    value="<?php echo admin_url('managegallery/index/'.$category['category_id'].'/'.$article['article_id']); ?>"
                /></noscript>
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="row fileupload-buttonbar">
                    <div class="col-lg-7">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Add files...</span>
                            <input type="file" name="files[]" multiple />
                        </span>
                        <button type="submit" class="btn btn-primary start">
                            <i class="glyphicon glyphicon-upload"></i>
                            <span>Start upload</span>
                        </button>
                        <button type="reset" class="btn btn-warning cancel">
                            <i class="glyphicon glyphicon-ban-circle"></i>
                            <span>Cancel upload</span>
                        </button>
                        <button type="button" class="btn btn-danger delete">
                            <i class="glyphicon glyphicon-trash"></i>
                            <span>Delete selected</span>
                        </button>
                        <input type="checkbox" class="toggle" />
                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <!-- The global progress state -->
                    <div class="col-lg-5 fileupload-progress fade">
                        <!-- The global progress bar -->
                        <div
                        class="progress progress-striped active"
                        role="progressbar"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        >
                            <div
                            class="progress-bar progress-bar-success"
                            style="width: 0%;"
                            ></div>
                        </div>
                        <!-- The extended global progress state -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped">
                    <tbody class="files"></tbody>
                </table>
				
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    
});
</script>