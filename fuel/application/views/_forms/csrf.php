<?php if (WYVERN_CSRF): ?>
    <input type="hidden" class="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" id="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
<?php endif; ?>
