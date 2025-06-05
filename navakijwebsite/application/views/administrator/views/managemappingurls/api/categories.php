<option value="" <?php echo set_select('category_id','', true); ?>>-- เลือกหมวดหมู่ --</option>
<?php if( isset( $categories ) && count( $categories ) > 0 ): ?>
    <?php if( $settings['has_sub'] == 1 ): ?>
        <?php foreach( $categories as $category ): ?>
            <optgroup label="<?php echo $category['category_title_th']; ?>">
                <option value="<?php echo $category['category_id']; ?>" <?php echo set_select('category_id', $category['category_id']); ?>>หน้ารวมของหมวด <?php echo $category['category_title_th']; ?></option>
                <?php
                    switch( $settings['category_type'] ){
                        case 'articles' :
                            $subcategories = $this->managenavigationsmodel->get_article_categories( $category['category_id'] );
                        break;
                        case 'documents' :
                            $subcategories = $this->managenavigationsmodel->get_document_categories( $category['category_id'] );
                        break;
                        default :
                            $subcategories = array();
                    }
                ?>
                <?php if( isset( $subcategories ) && count( $subcategories ) > 0 ): ?>
                    <?php foreach( $subcategories as $subcategory ): ?>
                        <option value="<?php echo $subcategory['category_id']; ?>" <?php echo set_select('category_id', $subcategory['category_id']); ?>><?php echo $subcategory['category_title_th']; ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </optgroup>
        <?php endforeach; ?>
    <?php else: ?>
        <?php foreach( $categories as $category ): ?>
            <option value="<?php echo $category['category_id']; ?>" <?php echo set_select('category_id', $category['category_id']); ?>><?php echo $category['category_title_th']; ?></option>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endif; ?>