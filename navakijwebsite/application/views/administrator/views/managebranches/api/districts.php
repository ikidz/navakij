<option value="" <?php echo set_select('district_id','', true); ?>>-- เลือกอำเภอ / เขต --</option>
<?php if( isset( $districts ) && count( $districts ) > 0 ): ?>
    <?php foreach( $districts as $district ): ?>
        <option value="<?php echo $district['amphoe_id']; ?>" <?php echo set_select('district_id', $district['amphoe_id']); ?>><?php echo $district['name']; ?></option>
    <?php endforeach; ?>
<?php endif; ?>