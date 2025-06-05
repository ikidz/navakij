<div class="spacing"></div>
<section id="page-body" class="px-0">
    
    <?php if( isset( $product_highlight ) && count( $product_highlight ) > 0 ): ?>
        <?php /* #newest - Start */ ?>
        <div id="newest" class="d-flex flex-wrap">
            <div class="thumbnail col-12 col-lg-6 px-0">
                <a href="<?php echo site_url( $product_highlight['insurance_meta_url'] ); ?>">
                    <?php if( $product_highlight['insurance_thumbnail'] != '' && is_file( realpath('public/core/uploaded/insurance/thumb/'.$product_highlight['insurance_thumbnail']) ) === true ): ?>
                        <img src="<?php echo base_url( 'public/core/uploaded/insurance/thumb/'.$product_highlight['insurance_thumbnail'] ); ?>" alt="" class="img-fullwidth d-block" />
                    <?php else: ?>
                        <img src="<?php echo base_url('public/core/img/product_default_image.jpg'); ?>" alt="" class="img-fullwidth d-block" />
                    <?php endif; ?>
                </a>
            </div>
            <div class="info col-12 col-lg-6 bg-lightgrey">
                <h2 class="navy"><?php echo $product_highlight['insurance_title_'.$this->_language]?></h2>
                <div class="sdesc">
                    <p><?php echo $product_highlight['insurance_sdesc_'.$this->_language]?></p>
                </div>
                <p><a href="<?php echo site_url( $product_highlight['insurance_meta_url'] ); ?>" class="btn btn-navy">ดูรายละเอียด</a></p>
            </div>
        </div>
        <?php /* #newest - End */ ?>
    <?php endif; ?>

    <div class="container">

        <?php /* #filterForm - Start */ ?>
        <form id="filterForm" name="filterForm" method="post" enctype="multipart/form-data" action="<?php echo site_url('products/search/'.$category_id);?>" class="form border-top border-1px border-navy">
            <div class="d-flex flex-wrap align-items-center">
                <div class="col-12 px-0 d-flex flex-wrap">
                    <div class="control-group bordered col-12 col-lg-8 px-0 bg-grey">
                        <i class="fas fa-search"></i>
                        <input type="text" name="filter_keywords" id="filter_keywords" value="" placeholder="ค้นหาประกันที่เหมาะกับคุณ" class="h-100" />
                    </div>
                    <div id="categories" class="col-12 col-lg-4 d-flex flex-wrap align-items-center">
                        <?php if( isset( $product_categories ) && count( $product_categories ) > 0 ): ?>
                            <?php foreach( $product_categories as $category ): ?>
                                <a href="<?php echo site_url( $category['insurance_category_meta_url'] );?>" class="col <?php echo ( $category['insurance_category_id'] == $category_id ? 'active' : '' ); ?> "><?php echo $category['insurance_category_title_'.$this->_language]; ?></a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-12 px-0 d-flex flex-wrap my-3">
                    <?php if($category_id == 99){?>
                    <div class="control-group col-6 col-md mt-0 mb-3 my-md-0">
                        <select name="vehicle_group_id" id="vehicle_group_id" class="w-100 h-100 navy">
                            <option value="" <?php echo set_select('vehicle_group_id','', true); ?>>ประเภทของรถ</option>
                            <?php foreach($vehicle_group as $rs) { ?>
                            <option value="<?php echo $rs['vehicle_group_id']?>" ><?php echo $rs['vehicle_group_title_'.$this->_language];?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="control-group col-6 col-md mt-0 mb-3 my-md-0">
                        <select name="year" id="year" class="w-100 h-100 navy">
                            <option value="" <?php echo set_select('year','', true); ?>>ปีของรถ</option>
                            <?php $current_year = date("Y");
                                    for($i=1;$i<16;$i++){
                            ?>
                            <option value="<?php echo $current_year;?>" ><?php echo $current_year;?></option>
                            <?php $current_year = (int)$current_year-1;  
                                    }
                            ?>
                        </select>
                    </div>
                    <div class="control-group col-6 col-md mt-0 mb-3 my-md-0">
                        <select name="sum_insured" id="sum_insured" class="w-100 h-100 navy">
                            <option value="" <?php echo set_select('sum_insured','', true); ?>>ทุนประกัน/ปี</option>
                            <option value="100000" >100,000</option>
                            <option value="200000" >200,000</option>
                            <option value="300000" >300,000</option>
                        </select>
                    </div>
                    
                    <?php }?>
                    <div class="form-actions col-12 col-md-3 mx-auto">
                        <button type="submit" name="btn-submit" id="btn-submit" class="btn btn-navy w-100">ค้นหา</button>
                    </div>
                </div>
            </div>
        </form>
        <?php /* #filterForm - End */ ?>

        <?php /* #products - Start */ ?>
        <div id="products" class="d-flex flex-wrap">
            <?php /*
            <?php if(@$product_list[0]){?>
            <div class="col-12 col-md-6 px-0 px-md-3 mb-3">
                <div class="product-item item-1 h-100" style="background-image:url('<?php echo base_url( 'public/core/uploaded/insurance/thumb/'.$product_list[0]['insurance_thumbnail'] ); ?>');">
                    <a href="<?php echo site_url($product_list[0]['insurance_meta_url']); ?>" class="product-caption d-flex flex-wrap h-100">
                        <p id="category-icon" class="col-12"><i class="icomoon <?php echo $category_info['insurance_category_icon']; ?>"></i></p>
                        <h2 class="col-12 bold"><?php echo $product_list[0]['insurance_title_'.$this->_language]?></h2>
                        <p class="px-3"><button type="button" class="btn btn-turquoise">ดูรายละเอียด</button></p>
                    </a>
                </div>
            </div>
            <?php }?>
            <div class="col-12 col-md-6 px-0 px-md-3 mb-3 d-flex flex-wrap">
                <?php if(@$product_list[1]){?>
                <div class="product-item item-2 col-12 px-0 mb-3 mb-lg-0" style="background-image:url('<?php echo base_url( 'public/core/uploaded/insurance/thumb/'.$product_list[1]['insurance_thumbnail'] ); ?>');">
                    <a href="<?php echo site_url($product_list[1]['insurance_meta_url']); ?>" class="product-caption d-flex flex-wrap h-100">
                        <h2 class="col-12 mt-auto bold"><?php echo $product_list[1]['insurance_title_'.$this->_language]?></h2>
                        <p class="px-3 mt-3"><button type="button" class="btn btn-turquoise">ดูรายละเอียด</button></p>
                    </a>
                </div>
                <?php } 
                if(@$product_list[2]){
                ?>
                <div class="product-item item-3 col-12 px-0" style="background-image:url('<?php echo base_url( 'public/core/uploaded/insurance/thumb/'.$product_list[2]['insurance_thumbnail'] ); ?>');">
                    <a href="<?php echo site_url($product_list[2]['insurance_meta_url']); ?>" class="product-caption d-flex flex-wrap h-100">
                        <h2 class="col-12 mt-auto bold"><?php echo $product_list[2]['insurance_title_'.$this->_language]?></h2>
                        <p class="px-3 mt-3"><button type="button" class="btn btn-turquoise">ดูรายละเอียด</button></p>
                    </a>
                </div>
                <?php }?>
            </div>
            */ ?>
            <?php foreach($product_list as $key=>$rs): ?>
                <div class="col-12 col-md-6 px-0 px-md-3 mb-3">
                    <div class="product-item item-<?php echo $key; ?>">
                        <?php if( $rs['insurance_thumbnail'] != '' && is_file( realpath('public/core/uploaded/insurance/thumb/'.$rs['insurance_thumbnail']) ) === TRUE ): ?>
                            <img src="<?php echo base_url( 'public/core/uploaded/insurance/thumb/'.$rs['insurance_thumbnail']); ?>" alt="" class="img-fullwidth d-block" />
                        <?php else: ?>
                            <img src="<?php echo base_url('public/core/img/product_default_image.jpg'); ?>" alt="" class="img-fullwidth d-block" />
                        <?php endif; ?>
                        <a href="<?php echo site_url($rs['insurance_meta_url']); ?>" class="product-caption d-flex flex-wrap h-100">
                            <?php /* <h2 class="col-12 mt-auto bold"><?php echo $rs['insurance_title_'.$this->_language]?></h2> */ ?>
                            <p class="px-3 mt-3"><button type="button" class="btn btn-turquoise">ดูรายละเอียด</button></p>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php /* #products - End */ ?>

        <!-- <div class="text-center mt-3">
            <a href="javascript:void(0);" class="btnMore btn btn-navy-transparent">เพิ่มเติม</a>
        </div> -->

    </div>

</section>