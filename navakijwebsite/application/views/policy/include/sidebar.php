<div id="sidebar-wrapper" class="col-12 col-md-3 px-0 px-md-3 mb-3">
    <?php if( isset( $contents ) && count( $contents ) > 0 ): ?>
        <h5 class="navy border-bottom border-2px border-navy pb-3 d-flex flex-wrap align-items-center">
            <?php echo $contents['article']['category']['category_title_'.$this->_language]; ?>

            <button class="navbar-toggler ml-auto d-block d-lg-none" type="button" data-toggle="collapse" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-chevron-circle-up navy"></i>
                <i class="fas fa-chevron-circle-down navy"></i>
            </button>
        </h5>
    
        <nav class="navbar navbar-expand-lg navbar-light pt-3">

            <div class="collapse navbar-collapse" id="sidebar">
                <ul class="">
                    <?php
                        if( isset( $contents['article']['lists'] ) && count( $contents['article']['lists'] ) > 0 ){
                            foreach( $contents['article']['lists'] as $key => $article ){
                                $active = '';
                                $color = 'black';
                                if( isset( $article['article_meta_url'] ) && $article['article_meta_url'] != '' ){
                                    $url = 'company-policy/'.$contents['article']['category']['category_meta_url'].'/article/'.$article['article_id'];
                                    $active = ( @$display['contentId'] == $article['article_id'] ? 'active':'' );
                                    $color = ( @$display['contentId'] == $article['article_id'] ? 'navy':'black' );
                                }else{
                                    $url = 'javascript:void(0);';
                                }
                    ?>
                                <li class="<?php echo $active; ?>">
                                    <a href="<?php echo $url; ?>" class="btn-text <?php echo $color; ?> px-1">
                                        <?php echo $article['article_title_'.$this->_language]; ?>
                                    </a>
                                </li>
                    <?php
                            }
                        }
                        if( isset( $contents['document']['lists'] ) && count( $contents['document']['lists'] ) > 0 ){
                            foreach( $contents['document']['lists'] as $key => $document ){
                                $active = '';
                                $color = 'black';
                                if( isset( $document['document_meta_url'] ) && $document['document_meta_url'] != '' ){
                                    $url = 'company-policy/'.$contents['article']['category']['category_meta_url'].'/document/'.$document['document_id'];
                                    $active = ( @$display['contentId'] == $document['document_id'] ? 'active':'' );
                                    $color = ( @$display['contentId'] == $document['document_id'] ? 'navy':'black' );
                                }else{
                                    $url = 'javascript:void(0);';
                                }
                    ?>
                                <li class="<?php echo $active; ?>">
                                    <a href="<?php echo $url; ?>" class="btn-text <?php echo $color; ?> px-1">
                                        <?php echo $document['document_title_'.$this->_language]; ?>
                                    </a>
                                </li>
                    <?php
                            }
                        }
                    ?>
                </ul>
            </div>
        </nav>
    <?php endif; ?>
</div>