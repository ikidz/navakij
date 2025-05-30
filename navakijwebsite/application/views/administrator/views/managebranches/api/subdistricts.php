<option value="" <?php echo set_select('subdistrict_id','', true); ?>>-- เลือกตำบล / แขวง --</option>
<?php if( isset( $subdistricts ) && count( $subdistricts ) > 0 ): ?>
    <?php foreach( $subdistricts as $subdistrict ): ?>
        <option value="<?php echo $subdistrict['tambon_id']; ?>" <?php echo set_select('subdistrict_id', $subdistrict['tambon_id']); ?>><?php echo $subdistrict['name']; ?></option>
    <?php endforeach; ?>
<?php endif; ?>