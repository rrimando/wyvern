<?php // todo fixe sources     ?>
<?php if ($welcome_source == 'session') : ?>
    <h2><strong><?php echo $this->session->userdata($welcome_value); ?></strong><?php echo $welcome_message; ?></h2>
<?php else: ?>
    <h2><?php echo $welcome_message; ?></h2>
<?php endif; ?>

