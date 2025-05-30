<option value="" <?php echo set_select('district_id',''); ?>>อำเภอ/เขต</option>
<?php if( isset( $districts ) && count( $districts ) > 0 ): ?>
    <?php foreach( $districts as $district ): ?>
        <option value="<?php echo $district['amphoe_id']; ?>" <?php if($district['amphoe_id'] == $this->input->post('district_id')) { echo "selected";} ?>><?php echo ( $this->_language == 'th' ? $district['name'] : $district['name_alt'] ); ?></option>
    <?php endforeach; ?>
<?php endif; ?>