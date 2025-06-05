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

          <?php if( isset( $subpositions ) && count( $subpositions ) > 0 ): ?>
            <?php foreach( $subpositions as $subposition ): ?>
              <div class="position-blog d-flex flex-wrap bg-white mb-3">
                <div class="col-8 p-3 mx-3 mb-3">
                  <h4 class="navy bold text-left"><?php echo $subposition['position_title_'.$this->_language]; ?></h4>
                </div>
                <?php $hierarchies = $this->aboutusmodel->get_boardmembers( $subposition['position_id'] ); ?>
                <?php if( isset( $hierarchies ) && count( $hierarchies ) > 0 ): ?>
                  <?php foreach( $hierarchies as $level => $members ): ?>
                    <div class="member-list col-12 px-0 d-flex flex-wrap pt-3">
                      
                      <?php $blog_size = array( 1 => 'col-4 mx-auto', 2 => 'col-3', 3 => 'col-2' ); ?>
                      <?php if( isset( $members ) && count( $members ) > 0 ): ?>
                        <?php foreach( $members as $member ): ?>
                          <div class="member-blog <?php echo $blog_size[$level]; ?> mb-3">
                            <?php if( $member['image'] != '' && is_file( realpath('public/core/uploaded/boardmembers/'.$member['image']) ) === true ): ?>
                              <p><img src="<?php echo base_url('public/core/uploaded/boardmembers/'.$member['image']); ?>" alt="" class="img-fullwidth" /></p>
                            <?php endif; ?>
                            <p class="navy text-center"><?php echo $member['name_'.$this->_language]; ?></p>
                            <p class="grey text-center"><?php echo $member['position_'.$this->_language]; ?></p>
                          </div>
                        <?php endforeach; ?>
                      <?php endif; ?>

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
</section>