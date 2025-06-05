<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey page-sustainable">
  <div class="container">
    <div class="row justify-content-center">
      <div class="d-flex flex-wrap">

        <?php $this->load->view('aboutus/include/sidebar', $this->_data); ?>

        <div class="col-12 col-md-9 px-0 px-md-3 mb-3">

          <div id="breadcrumb" class="breadcrumb col-12 mb-3">
            <p><a href="<?php echo site_url(''); ?>" class="btn-text black"><?php echo ( $this->_language == 'th' ? 'ข่าวสารและกิจกรรม' : 'Information' ); ?></a>
            <a href="<?php echo site_url('about-us'); ?>" class="btn-text black"><?php echo ( $this->_language == 'en' ? 'Information' : 'ข้อมูลบริษัท' ); ?></a>
            <a href="<?php echo site_url('about-us/boardofdirectors'); ?>" class="btn-text navy"><?php echo $position['position_title_th']; ?></a>
          </div>

          <div class="col-12 mb-3">
            <h4 class="navy"><i class="fas fa-users"></i> <?php echo $position['position_title_'.$this->_language]; ?></h4>
          </div>

          <div class="col-12 mt-4">
            <div class="board-list">

              <?php $aLevel = array( 1 => 'lg', 2 => 'md', 3 => '' ); ?>
              <?php if( isset( $boardmembers ) &&  count( $boardmembers ) > 0 ): ?>
                <?php foreach( $boardmembers as $level => $members ): ?>
                  <div class="board-row">
                    <?php if( isset( $members ) && count( $members ) > 0 ): ?>
                      <?php foreach( $members as $member ): ?>
                        <div class="board-item <?php echo $aLevel[$level]; ?>">
                          <a href="javascript:void(0);" data-memberid="<?php echo $member['id']; ?>" class="showProfile">
                            <div class="thumb">
                              <?php if( $member['image'] != '' && is_file( realpath( 'public/core/uploaded/boardmembers/'.$member['image'] ) ) === true ): ?>
                                <img src="<?php echo base_url('public/core/uploaded/boardmembers/'.$member['image']); ?>" class="img-fullwidth" />
                              <?php endif; ?>
                            </div>
                            <div class="detail">
                              <h5><?php echo $member['name_'.$this->_language]; ?></h5>
                              <p><?php echo $member['position_'.$this->_language]; ?></p>
                            </div>
                          </a>
                        </div>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
              
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>
</section>