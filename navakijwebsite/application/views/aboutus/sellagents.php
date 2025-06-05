<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey page-sustainable">
  <div class="container">
    <div class="row justify-content-center">

        <?php $this->load->view('aboutus/include/sidebar', $this->_data); ?>

        <div class="col-12 col-md-9 px-0 py-0 px-md-3 mb-3">

            <div id="breadcrumb" class="breadcrumb col-12 mb-3">
                <p><a href="<?php echo site_url(''); ?>" class="btn-text black"><?php echo ( $this->_language == 'en' ? 'Home' : 'หน้าหลัก' ); ?></a>
                <a href="<?php echo site_url('about-us'); ?>" class="btn-text black"><?php echo ( $this->_language == 'en' ? 'Company Profile' : 'ข้อมูลบริษัท' ); ?></a>
                <a href="<?php echo site_url('about-us/awards'); ?>" class="btn-text navy"><?php echo ( $this->_language == 'en' ? 'Sell Agents' : 'ตัวแทนนายหน้านวกิจประกันภัย' ); ?></a>
            </div>

            <div class="col-12 mb-3">
                <h4 class="navy"><i class="fas fa-award"></i> <?php echo ( $this->_language == 'en' ? 'Sell Agents' : 'ตัวแทนนายหน้านวกิจประกันภัย' ); ?></h4>
            </div>

						<form id="searchAgentForm" name="searchAgentForm" method="get" enctype="multipart/form-data" action="<?php echo site_url('about-us/sell-agents'); ?>" class="form col-12 py-3 my-0">
							<div class="control-group mb-3">
			          <i class="fas fa-search"></i>
			          <input type="text" name="keywords" id="keywords" value="<?php echo $this->input->get('keywords'); ?>"
			            placeholder="ชื่อตัวแแทน/นายหน้า">
			        </div>
							<div class="col-12 col-md mb-3">
			          <button type="submit" name="btn-submit" class="btn btn-navy w-100">ค้นหา</button>
			        </div>
						</form>

            <div id="lists" class="col-12 px-0 d-flex flex-wrap table-responsive">
                <table id="sellagents" class="table table-hover">
                    <thead>
                        <tr>
                            <td class="text-center"><?php echo ( $this->_language == 'en' ? 'Name' : 'ตัวแทน/นายหน้า' ); ?></td>
                            <td class="text-center"><?php echo ( $this->_language == 'en' ? 'License No.' : 'เลขที่ใบอนุญาตฯ' ); ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if( isset( $sellagents ) && count( $sellagents ) > 0 ): ?>
                            <?php foreach( $sellagents as $agent ): ?>
                                <tr>
                                    <td class="pl-3"><?php echo $agent['agent_name_'.$this->_language]; ?></td>
                                    <td class="text-center"><?php echo $agent['agent_license_no']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
  </div>
</section>