
<?php if (isset($this->wyvern_page_model->page_structure['data']['custom_entity_view']['display'])): ?>
    <?php if ($this->wyvern_page_model->page_structure['data']['custom_entity_view']['display'] == 'table'): ?>
        <?php // function render($table_headers, $table_data = array(), $table_controls = false, $table_entity = '', $table_attributes = array())  ?>
        <?php echo $this->wyvern_table_model->render($this->wyvern_page_model->page_structure['data']['custom_entity_view']['fields'], $this->wyvern_page_model->entity_item, (isset($this->wyvern_page_model->page_structure['data']['custom_entity_view']['table_controls'])) ? true : false, $this->wyvern_page_model->page_structure['data']['custom_entity_view']['entity']); ?>
    <?php endif; ?>
<?php else: ?>
    <?php echo $this->wyvern_data_block->render($this->wyvern_page_model->entity_item_view); ?>
<?php endif; ?>
