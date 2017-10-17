<div class="post">
    <h1><?php echo fetch_page_content($this->wyvern_page_model->page_structure['page_slug'], 'page_name', $entity = 'page'); ?></h1>
    <?php echo fetch_page_content($this->wyvern_page_model->page_structure['page_slug'], 'page_content', $entity = 'page'); ?>
</div>
