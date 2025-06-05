<div class="span12">
	<div class="widget">
		<div class="widget-title">
			<h4><i class="icon-cogs"></i> เพิ่มรายการ Mapping</h4>
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
                
                <div class="control-group">
                    <label class="control-label" for="map_origin">ลิงก์ต้นทาง : *</label>
                    <div class="controls">
                        <input type="text" name="map_origin" id="map_origin" value="<?php echo set_value('map_origin'); ?>" class="span10" />
                    </div>
                </div>

				<div class="control-group">
                    <label class="control-label" for="content_type">ประเภทของลิงก์ : *</label>
                    <div class="controls">
                        <select name="content_type" id="content_type">
                            <option value="insurance" <?php echo set_select('content_type','insurance'); ?>>ลิงก์ไปยังประกัน</option>
                            <option value="articles" <?php echo set_select('content_type','articles'); ?>>ลิงก์ไปยังบทความ</option>
                            <option value="documents" <?php echo set_select('content_type','documents'); ?>>ลิงก์ไปยังเอกสารบริษัท</option>
                            <option value="internal_link" <?php echo set_select('content_type','internal_link'); ?>>ลิงก์ไปยังหน้าภายใน</option>
                            <option value="external_link" <?php echo set_select('content_type','external_link', true); ?>>ลิงก์ไปภายนอก</option>
                        </select>
                    </div>
                </div>

                <div id="internal_content" class="control-group content-type" <?php echo ( in_array($this->input->post('content_type'), array('insurance','articles','documents')) === true ? '' : 'style="display:none;"'); ?>>
                    <div class="control-group">
                        <label class="control-label" for="category_id">หมวดหมู่ของ <span></span> : *</label>
                        <div class="controls">
                            <select name="category_id" id="category_id">
                                <option value="" <?php echo set_select('category_id','', true); ?>>-- เลือกหมวดหมู่ --</option>
                                <?php if( isset( $categories ) && count( $categories ) > 0 ): ?>
                                    <?php if( $settings['has_sub'] == 1 ): ?>
                                        <?php foreach( $categories as $category ): ?>
                                            <optgroup label="<?php echo $category['category_title_th']; ?>">
                                                <option value="<?php echo $category['category_id']; ?>" <?php echo set_select('category_id', $category['category_id']); ?>>หน้ารวมของหมวด <?php echo $category['category_title_th']; ?></option>
                                                <?php
                                                    switch( $settings['category_type'] ){
                                                        case 'articles' :
                                                            $subcategories = $this->managemappingurlsmodel->get_article_categories( $category['category_id'] );
                                                        break;
                                                        case 'documents' :
                                                            $subcategories = $this->managemappingurlsmodel->get_document_categories( $category['category_id'] );
                                                        break;
                                                        default :
                                                            $subcategories = array();
                                                    }
                                                ?>
                                                <?php if( isset( $subcategories ) && count( $subcategories ) > 0 ): ?>
                                                    <?php foreach( $subcategories as $subcategory ): ?>
                                                        <option value="<?php echo $subcategory['category_id']; ?>" <?php echo set_select('category_id', $subcategory['category_id']); ?>><?php echo $subcategory['category_title_th']; ?></option>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </optgroup>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <?php foreach( $categories as $category ): ?>
                                            <option value="<?php echo $category['category_id']; ?>" <?php echo set_select('category_id', $category['category_id']); ?>><?php echo $category['category_title_th']; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="content_id">ปลายทาง : *</label>
                        <div class="controls">
                            <select name="content_id" id="content_id">
                                <option value="0" <?php echo set_select('content_id',0, true); ?>>ลิงก์ไปหน้ารวม</option>
                                <?php if( isset( $contents ) && count( $contents ) > 0 ): ?>
                                    <?php foreach( $contents as $content ): ?>
                                        <option value="<?php echo $content['content_id']; ?>" <?php echo set_select('content_id', $content['content_id']); ?>><?php echo $content['content_title_th']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="internal_link" class="control-group content-type" <?php echo ( $this->input->post('content_type') == 'internal_link' ? '' : 'style="display:none;"'); ?>>
                    <div class="control-group">
                        <label class="control-label" for="map_internal_url">ปลายทาง : *</label>
                        <div class="controls">
                            <select name="map_internal_url" id="map_internal_url">
                                <option value="" <?php echo set_select('map_internal_url','', true); ?>>-- เลือกปลายทาง --</option>
                                <?php if( isset( $static_pages ) && count( $static_pages ) > 0 ): ?>
                                    <?php foreach( $static_pages as $page ): ?>
                                        <option value="<?php echo $page['page_meta_url']; ?>" <?php echo set_select('page_meta_url'); ?>><?php echo $page['page_title_th']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="external_link" class="control-group content-type" <?php echo ( $this->input->post('content_type') == 'external_link' || !$this->input->post('content_type') ? '' : 'style="display:none;"'); ?>>
                    <div class="control-group">
                        <label class="control-label" for="map_external_url">ปลายทาง : *</label>
                        <div class="controls">
                            <input type="text" name="map_external_url" id="map_external_url" value="<?php echo set_value('map_external_url'); ?>" class="span6" />
                        </div>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="is_newtab">เปิดแท็บใหม่? : </label>
                    <div class="controls">
                        <input type="checkbox" id="is_newtab" name="is_newtab" value="1" <?php echo set_checkbox('is_newtab', 1); ?> />
                    </div>
                </div>

                <div class="control-group">
					<label class="control-label" for="map_status">สถานะการแสดงผล : </label>
					<div class="controls">
						<select class="span2" tab-index="1" name="map_status" id="map_status">
							<option value="approved" <?php echo set_select('map_status','approved', TRUE); ?>>เปิดแสดงผล</option>
							<option value="pending" <?php echo set_select('map_status','pending'); ?>>ปิดแสดงผล</option>
						</select>
					</div>
				</div>
				
				<div class="form-actions">
					<button type="submit" class="btn btn-mini btn-primary"><i class="icon-save"></i> บันทึกข้อมูล</button>
				 	<a class="btn btn-mini" href="<?php echo admin_url("managemappingurls/index"); ?>"><i class="icon-reply"></i> ยกเลิก</a>
				</div>
				
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('body').on('change','#content_type', function(){
        var value = $(this).val();
        $('.content-type').slideUp('fast');
        if( value == 'insurance' || value == 'articles' || value == 'documents' ){
            $.ajax({
                method: 'GET',
                url: '<?php echo admin_url('managemappingurls/get_categories'); ?>/'+value,
                beforeSend: function(){
                    $('#content_id').html('<option value="0" <?php echo set_select('content_id',0, true); ?>>ลิงก์ไปหน้ารวม</option>');
                }
            }).done( function( data ){
                $('#category_id').html( data );
                $('#internal_content').slideDown('fast');
            });
        }else if( value == 'internal_link' ){
            $('#internal_link').slideDown('fast');
        }else{
            $('#external_link').slideDown('fast');
        }
    });

    $('body').on('change','#category_id', function(){
        var contentType = $('#content_type').val();
        var categoryId = $('#category_id').val();
        $.ajax({
            method: 'GET',
            url: '<?php echo admin_url('managemappingurls/get_contents'); ?>/'+contentType+'/'+categoryId,
            beforeSend: function(){
                $('#content_id').html('<option value="0" <?php echo set_select('content_id',0, true); ?>>ลิงก์ไปหน้ารวม</option>');
            }
        }).done( function( data ){
            $('#content_id').html( data );
        });
    });
});
</script>