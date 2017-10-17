<div class="clearfix"></div>
<ul class="nav nav-tabs">
    <?php foreach ($items as $item => $attributes): ?>
        <li role="presentation" <?php echo ($this->wyvern_page_model->page == $attributes['url']) ? 'class="active"' : ''; ?>>
            <a href = "<?php echo isset($attributes['url']) ? site_url($attributes['url']) : 'javascript:void(0)'; ?>">
                <?php echo $attributes['label']; ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>
