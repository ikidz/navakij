<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey page-sustainable py-3">
  <div class="container px-0">
    <div class="d-flex flex-wrap">

      <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
        <p><a href="<?php echo site_url('home'); ?>" class="btn-text black">หน้าหลัก</a>
        <a href="<?php echo site_url('sustainable'); ?>" class="btn-text black">การพัฒนาอย่างยั่งยืน</a>
      </div>

      <div class="col-12 px-0 px-md-3 mb-3">
        <div class="row justify-content-end">
          <div class="col-12 col-md-6 mb-5 mb-md-0">
            <h4 class="navy"><i class="fas fa-layer-group"></i> การพัฒนาอย่างยั่งยืน</h4>
          </div>
          <div class="col-12 col-md-6">
            <ul class="pagination justify-content-end">
              <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
          </div>
        </div>

        <div class="download-list mt-5">
        <?php for($i=0; $i<5; $i++) { ?>
          <div class="item">
            <div class="col-left">
              <h4>กฎบัตรคณะกรรมการบริหารความเสี่ยง</h4>
            </div>
            <a href="#" class="col-right">
              <div class="title">
                <h5>Download PDF File</h5>
                <small>navasan63-20160920113933.pdf (9 MB)</small>
              </div>
              <div class="icon"><i class="fas fa-arrow-circle-down"></i></div>
            </a>
          </div>
        <?php } ?>
        </div>
        
        
      </div>

      <div class="col-12 mt-3 mt-lg-5 text-center">
        <p class="my-3"><a href="<?php echo site_url(''); ?>" class="btn btn-lg btn-icon btn-navy-transparent"><i class="fas fa-chevron-left"></i> กลับ</a></p>
      </div>

    </div>
  </div>
</section>