<option value="0" <?php echo set_select('content_id',0, true); ?>>ลิงก์ไปหน้ารวม</option>
<?php if( isset( $contents ) && count( $contents ) > 0 ): ?>
    <?php foreach( $contents as $content ): ?>
        <option value="<?php echo $content['content_id']; ?>" <?php echo set_select('content_id', $content['content_id']); ?>><?php echo $content['content_title_th']; ?></option>
    <?php endforeach; ?>
<?php endif; ?>