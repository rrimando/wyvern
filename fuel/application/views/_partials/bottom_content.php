<div class="bottom-content">
    <div class="bottom-content-left">
        <?php foreach ($partials['left'] as $partial => $attributes): ?>
            <?php $this->wyvern_page_model->__partial($partial, $attributes); ?>
        <?php endforeach; ?>
    </div>
    <div class="bottom-content-right">
        <?php foreach ($partials['right']as $partial => $attributes): ?>
            <?php $this->wyvern_page_model->__partial($partial, $attributes); ?>
        <?php endforeach; ?>
    </div>
</div>
<?php foreach ($partials['block']['partials'] as $partial => $attributes): ?>
    <?php $this->wyvern_page_model->__partial($partial, $attributes); ?>
<?php endforeach; ?>
