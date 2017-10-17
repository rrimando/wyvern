<div class="top-bar">
    <div class="top-bar-wrap">
        <?php if (array_key_exists('nav_social_links', $partials)): ?>
            <?php echo $this->wyvern_page_model->__partial('nav_social_links'); ?>
        <?php endif; ?>
        <?php if (array_key_exists('contact_no', $partials)): ?>
            <?php echo $this->wyvern_page_model->__partial('contact_no'); ?>
        <?php endif; ?>
    </div>
</div>
<?php $this->wyvern_page_model->__partial('clearfix'); ?>
<?php if (array_key_exists('open_div', $partials)): ?>
    <?php echo $this->wyvern_page_model->__partial('open_div', $partials['open_div']); ?>
<?php endif; ?>
<div class="bottom-bar">
    <div class="bottom-bar-inner-wrap">
        <?php if (array_key_exists('large_logo', $partials)): ?>
            <?php echo $this->wyvern_page_model->__partial('large_logo'); ?>
        <?php endif; ?>
        <?php if (array_key_exists('bare_navigation', $partials)): ?>
            <?php echo $this->wyvern_page_model->__partial('bare_navigation'); ?>
        <?php endif; ?>
    </div>
</div>



