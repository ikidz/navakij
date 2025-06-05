<?php if( $info['member_image'] != '' && is_file( realpath( 'public/core/uploaded/boardmembers/'.$info['member_image'] ) ) === true ): ?>
    <div id="modal-member-image" class="col-6 col-md-4 mx-auto">
        <img src="<?php echo base_url('public/core/uploaded/boardmembers/'.$info['member_image']); ?>" alt="" class="img-fullwidth" />
    </div>
<?php endif; ?>
<div id="modal-member-info" class="col-12 col-md-8">
    <hr size="0" class="d-block d-md-none" />
    <div class="row">
        <div class="col-4"><p class="bold navy">ประเภทกรรมการที่เสนอแต่งตั้ง</p></div>
        <div class="col-8"><?php echo $info['member_type_'.$this->_language]; ?></div>
    </div>
    <div class="row">
        <div class="col-4"><p class="bold navy">จำนวนปีที่ดำรงตำแหน่งกรรมการ</p></div>
        <div class="col-8">
            <?php echo $info['member_history_'.$this->_language]; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4"><p class="bold navy">อายุ</p></div>
        <div class="col-8"><?php echo $info['member_age']; ?> ปี</div>
    </div>
    <div class="row">
        <div class="col-4"><p class="bold navy">สัญชาติ</p></div>
        <div class="col-8"><?php echo $info['member_nationality_'.$this->_language]; ?></div>
    </div>
    <div class="row">
        <div class="col-4"><p class="bold navy">คุณวุฒิการศึกษา</p></div>
        <div class="col-8">
            <?php echo $info['member_educational_'.$this->_language]; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p class="bold navy">
                การอบรมเกี่ยวกับบทบาทหน้าที่กรรมการ<br />
                สมาคมส่งเสริมสถาบันกรรมการบริษัทไทย
            </p>
        </div>
        <div class="col-8">
            <?php echo $info['member_committee_seminar_'.$this->_language]; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p class="bold navy">
                การอบรมอื่น
            </p>
        </div>
        <div class="col-8">
            <?php echo $info['member_other_seminar_'.$this->_language]; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p class="bold navy">
                ความเชี่ยวชาญ
            </p>
        </div>
        <div class="col-8">
            <?php echo $info['member_expertise_'.$this->_language]; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p class="bold navy">
                ตำแหน่งปัจจุบันในบริษัท
            </p>
        </div>
        <div class="col-8">
            <?php echo $info['member_current_position_'.$this->_language]; ?>
        </div>
    </div>
    <div class="row my-3">
        <h4 class="navy">การดำรงตำแหน่งปัจจุบันในกิจการอื่น</h4>
    </div>
    <div class="row">
        <div class="col-4">
            <p class="bold navy">
                บริษัทจดทะเบียน
            </p>
        </div>
        <div class="col-8">
            <?php echo $info['member_registered_company_'.$this->_language]; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p class="bold navy">
                กิจการอื่นที่ไม่ใช่บริษัทจดทะเบียน
            </p>
        </div>
        <div class="col-8">
            <?php echo $info['member_unregister_company_'.$this->_language]; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <p class="bold navy">
                สัดส่วนการถือหุ้นของบริษัท<br />
                (ณ <?php echo thai_convert_fulldate( $info['member_sharedholding_updatedat'] ); ?> )
            </p>
        </div>
        <div class="col-8">
            <p><?php echo number_format($info['member_sharedholding_ratio'], 0); ?> หุ้น คิดเป็นร้อยละ <?php echo $info['member_sharedholding_percentage']; ?></p>
            <p>ของหุ้นที่มีสิทธิออกเสียงทั้งหมด (นับรวมบุคคลตามมาตรา 258)</p>
        </div>
    </div>
</div>