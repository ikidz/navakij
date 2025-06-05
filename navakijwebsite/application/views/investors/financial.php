<div class="spacing"></div>
<section id="page-body" class="bg-lightgrey py-3">
  <div class="container px-0">
    <div class="d-flex flex-wrap">

      <?php $this->load->view('investors/include/sidebar', $this->_data); ?>
      <div class="col-12 col-md-9 px-0 px-md-3 mb-3">
        <div id="breadcrumb" class="breadcrumb col-12 px-0 px-md-3 mb-3">
          <p><a href="<?php echo site_url('investors'); ?>" class="btn-text black">นักลงทุนสัมพันธ์</a>
          <a href="<?php echo site_url('investors/financial'); ?>" class="btn-text black">ข้อมูลทางการเงิน</a>
        </div>

        <div class="col-12 px-0 px-md-3 mb-3">
          <h4 class="navy"><i class="fas fa-chart-pie"></i> ข้อมูลทางการเงิน</h4>
        </div>

        <div class="col-12 px-0 px-md-3 mb-3">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <td colspan="2">สำหรับปีสิ้นสุด ณ 31 ธันวาคม</td>
                  <td colspan="3">งบการเงินตามวิธีส่วนได้เสีย</td>
                </tr>
              </thead>
              <tbody>
                <tr class="bg-grey padding-lg">
                  <td style="width: 40%;"></td>
                  <td>หน่วย</td>
                  <td>2562</td>
                  <td>2561</td>
                  <td>2560</td>
                </tr>
                <tr class="bg-grey padding-lg">
                  <td colspan="5">ฐานะการเงิน</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">สินทรัพย์รวม</p></td><td>ล้านบาท</td><td>5,703.30</td><td>5,228.00</td><td>5,164.95</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">หนี้สินรวม</p></td><td>ล้านบาท</td><td>3,636.81</td><td>3,120.82</td><td>2,992.53</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">ส่วนของผู้ถือหุ้นของบริษัท</p></td><td>ล้านบาท</td><td>2,066.49</td><td>2,107.18</td><td>2,172.42</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">เงินลงทุนในหลักทรัพย์</p></td><td>ล้านบาท</td><td>3,044.19</td><td>2,820.82</td><td>2,960.75</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">เงินปันผลต่อหุ้น</p></td><td>บาท</td><td>1.28</td><td>1.79</td><td>1.80</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">จำนวนหุ้นที่ชำระแล้ว</p></td><td>หุ้น</td><td>35,000,000</td><td>34,000,000</td><td>33,000,000</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">จำนวนหุ้นที่จดทะเบียน</p></td><td>หุ้น</td><td>35,000,000</td><td>34,000,000</td><td>33,000,000</td>
                </tr>
                
                <tr class="bg-grey padding-lg">
                  <td colspan="5">ผลประกอบการ</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">เบี้ยประกันภัยรับทั้งสิ้น</p></td><td>ล้านบาท</td><td>3,023.91</td><td>2,892.62</td><td>2,635.82</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">เบี้ยประกันภัยรับสุทธิ</p></td><td>ล้านบาท</td><td>2,278.50</td><td>2,192.43</td><td>2,010.22</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">เบี้ยประกันภัยที่ถือเป็นรายได้</p></td><td>ล้านบาท</td><td>2,209.45</td><td>2,094.44</td><td>2,086.21</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">รายได้ค่าจ้างและค่าบำเหน็จ</p></td><td>ล้านบาท</td><td>182.36</td><td>197.96</td><td>179.93</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">ค่าสินไหมทดแทนสุทธิ	</p></td><td>ล้านบาท</td><td>1,434.81</td><td>1,218.97</td><td>1,350.34</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">ค่าใช้จ่ายในการรับประกันภัยรวมค่าใช้จ่ายดำเนินงาน</p></td><td>ล้านบาท</td><td>2,542.89</td><td>2,286.59</td><td>2,296.14</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">กำไร (ขาดทุน) จากการรับประกันภัยหลังหักค่าใช้จ่ายดำเนินงาน</p></td><td>ล้านบาท</td><td>(151.09)</td><td>5.81</td><td>(30.00)</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">กำไร (ขาดทุน) จากการลงทุนและรายได้อื่น</p></td><td>ล้านบาท</td><td>180.69</td><td>98.87</td><td>159.53</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">กำไรก่อนค่าใช้จ่ายภาษีเงินได้</p></td><td>ล้านบาท</td><td>29.60</td><td>104.68</td><td>129.53</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">ภาษีเงินได้นิติบุคคล</p></td><td>ล้านบาท</td><td>(0.04)</td><td>18.17</td><td>18.88</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">กำไรสุทธิ</p></td><td>ล้านบาท</td><td>29.64</td><td>86.51</td><td>110.65</td>
                </tr>

                <tr class="bg-grey padding-lg">
                  <td colspan="5">อัตราส่วนสภาพคล่อง</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราส่วนสภาพคล่อง</p></td><td>เท่า</td><td>1.35</td><td>1.37</td><td>1.39</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราส่วนหมุนเวียนเบี้ยประกันภัยค้างรับ</p></td><td>วัน</td><td>54</td><td>53</td><td>54</td>
                </tr>

                <tr class="bg-grey padding-lg">
                  <td colspan="5">อัตราส่วนแสดงความสามารถในการหากำไร</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราการรับเสี่ยงภัยไว้เอง</p></td><td>ร้อยละ</td><td>75.35</td><td>75.79</td><td>76.27</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราค่าสินไหมทดแทน</p></td><td>ร้อยละ</td><td>64.94</td><td>58.20</td><td>64.73</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตรากำไรขั้นต้น</p></td><td>ร้อยละ</td><td>9.54</td><td>18.01</td><td>14.01</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราส่วนค่าใช้จ่ายในการรับประกันภัย</p></td><td>ร้อยละ</td><td>51.45</td><td>50.97</td><td>45.34</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราผลตอบแทนจากการลงทุน	</p></td><td>ร้อยละ</td><td>5.65</td><td>3.28</td><td>5.14</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราเบี้ยประกันภัยรับสุทธิต่อส่วนของผู้ถือหุ้น</p></td><td>เท่า	</td><td>1.09</td><td>1.02</td><td>0.93</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตรากำไรสุทธิ</p></td><td>ร้อยละ</td><td>1.15</td><td>3.62</td><td>4.56</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราผลตอบแทนแก่ผู้ถือหุ้น</p></td><td>ร้อยละ</td><td>1.42</td><td>4.04</td><td>5.12</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">กำไรสุทธิต่อหุ้น*</p></td><td>บาท	 </td><td>0.85</td><td>2.47</td><td>3.16</td>
                </tr>

                <tr class="bg-grey padding-lg">
                  <td colspan="5">อัตราส่วนแสดงประสิทธิภาพในการดำเนินงาน</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราผลตอบแทนต่อสินทรัพย์</p></td><td>ร้อยละ</td><td>0.54</td><td>1.66</td><td>2.06</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราการหมุนเวียนของสินทรัพย์</p></td><td>เท่า</td><td>0.47</td><td>0.46</td><td>0.45</td>
                </tr>

                <tr class="bg-grey padding-lg">
                  <td colspan="5">อัตราส่วนวิเคราะห์นโยบายทางการเงิน</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราส่วนหนี้สินต่อส่วนของผู้ถือหุ้น</p></td><td>เท่า</td><td>1.76</td><td>1.48</td><td>1	.38</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราหนี้สินจากการรับประกันภัยต่อส่วนของผู้ถือหุ้น</p></td><td>เท่า</td><td>1.25</td><td>1.04</td><td>0.99</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราส่วนเงินสำรองเพื่อการเสี่ยงภัยต่อส่วนของผู้ถือหุ้น</p></td><td>เท่า</td><td>0.79</td><td>0.74</td><td>0.66</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราส่วนเงินสำรองเพื่อการเสี่ยงภัยต่อสินทรัพย์รวม</p></td><td>ร้อยละ</td><td>28.80</td><td>29.67</td><td>27.70</td>
                </tr>
                <tr>
                  <td><p class="pl-3 m-0">อัตราการจ่ายเงินปันผลต่อกำไรสุทธิ</p></td><td>ร้อยละ</td><td>151.79</td><td>70.51</td><td>53.68</td>
                </tr>

              </tbody>
            </table>
          </div>
          <p class="my-3 darkgrey">
          * การคำนวณกำไรสุทธิต่อหุ้นได้ปรับปรุงจำนวนหุ้นสามัญที่ใช้ในการคำนวณกำไรต่อหุ้น โดยถือเสมือนว่าการออกหุ้นปันผลได้เกิดขึ้นตั้งแต่วันเริ่มต้นของปีแรกที่เสนอรายงาน
          </p>
        </div>

        <div class="col-12 mt-3 mt-lg-5 text-center">
          <p class="my-3"><a href="<?php echo site_url('investors'); ?>" class="btn btn-lg btn-icon btn-navy-transparent"><i class="fas fa-chevron-left"></i> กลับ</a></p>
        </div>

      </div>

    </div>
  </div>
</section>