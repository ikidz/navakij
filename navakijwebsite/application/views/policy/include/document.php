<div class="download-list mt-5">
    <?php if( isset( $display['info'] ) && count( $display['info'] ) > 0 ): ?>
        <?php $document = $display['info']; ?>
        <div class="item w-100 d-flex flex-wrap">
            <div class="col-12 col-8 col-left">
                <h5><?php echo $document['document_title_'.$this->_language]; ?></h5>
            </div>
            <?php
                $fieldname = ($this->_language == 'en' ? 'document_file_en' : 'document_file' );
                $file = ( $document[$fieldname] != '' && is_file( realpath('public/core/uploaded/documents/'.$document[$fieldname]) ) === true ? $document[$fieldname] : '' );
                //$file = $document[$fieldname];
            ?>
            <?php if( $document['document_type'] == 'multi' ): ?>
                <a href="javascript:void(0);" data-toggle="collapse" data-target="#files-<?php echo $document['document_id']; ?>" aria-controls="files-<?php echo $document['document_id']; ?>" aria-expanded="false" class="col-12 col-lg-4 col-right">
                    <div class="title">
                        <h5>See file lists</h5>
                    </div>
                    <div class="icon ml-auto"><i class="fas fa-arrow-circle-down"></i></div>
                </a>
            <?php else: ?>
                <?php if( $file ): ?>
                    <a href="<?php echo base_url('public/core/uploaded/documents/'.$file); ?>" class="col-12 col-lg-4 col-right" target="_blank">
                        <div class="title">
                            <h5>Download File</h5>
                        </div>
                        <div class="icon ml-auto"><i class="fas fa-arrow-circle-down"></i></div>
                    </a>
                <?php endif; ?>
            <?php endif; ?>

            <?php if($document['document_type'] == "multi"): ?>
                <div id="files-<?php echo $document['document_id']; ?>" class="collapse multi-collapse col-12 px-0">

                    <?php $doc_fieldname = ($this->_language == 'en' ? 'document_file_en' : 'document_file_th' ); ?>
                    <?php $doc_file = $this->policy_model->get_document_file_bydocumentid( $document['document_id']); ?>

                    <?php if( isset( $doc_file ) && count( $doc_file ) > 0 ): ?>
                        <?php foreach($doc_file as $doc): ?>

                            <?php $d_file = ( $doc[$doc_fieldname] != '' && is_file( realpath('public/core/uploaded/documents/files/'.$doc['document_id'].'/'.$doc[$doc_fieldname]) ) === true ? $doc[$doc_fieldname] : '' ); ?>

                            <?php if($d_file): ?>

                                <div class="py-3 px-2 bg-lightgrey border-bottom border-1px border-navy">
                                    <a href="<?php echo base_url('public/core/uploaded/documents/files/'.$doc['document_id'].'/'.$d_file); ?>" class="col-12 btn-text navy" target="_blank"><i class="fas fa-download"></i> <?php echo $doc['document_file_title_'.$this->_language];?></a>
                                </div>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

        </div>
    <?php endif; ?>

</div>