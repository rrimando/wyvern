<?php foreach ($partials as $partial => $attributes): ?>
    <?php $this->wyvern_page_model->__partial($partial, $attributes); ?>
<?php endforeach; ?>

