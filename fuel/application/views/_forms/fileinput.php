<?php
if (isset($class)) {
    $class = explode(',', $class);
    $classes = trim(implode(' ', $class));
}
?>
<div class="form-group<?php echo isset($group_class) ? ' ' . $group_class : ''; ?>" id="fileinput-<?php echo isset($id) ? $id : ''; ?>">
    <?php if (isset($label)): ?>
        <label for="<?php $name; ?>"<?php echo isset($label_class) ? "class='{$label_class}'" : ''; ?>><?php echo $label; ?></label>
    <?php endif; ?>
    <?php if (isset($remove_uploader) && $remove_uploader == true): ?>
        <!-- This will only work if the upload queue is loaded -->
        <div class="queue-trigger">
        </div>
    <?php else: ?>
        <input type="file" class="form-control<?php echo isset($classes) ? ' ' . $classes : ''; ?>" id="<?php echo isset($id) ? "uploadify-" . $id : ''; ?>" placeholder="<?php echo isset($placeholder) ? $placeholder : ''; ?>" <?php echo isset($required) ? " required" : ''; ?> />
    <?php endif; ?>
    <input type="hidden" id="<?php echo isset($id) ? $id : ''; ?>"<?php echo isset($name) ? " name='{$name}'" : " name='{$id}'"; ?> value="<?php echo isset($value) ? $value : ''; ?>"<?php echo isset($required) ? " required" : ''; ?>/>
    <div class="file_container">
        <?php if (isset($value)): ?>
            <?php if ($type == 'video'): ?>
                <div id="video-container">
                    <video width="640" height="360" id="player1" controls="controls" preload="none" poster="<?php echo base_url(); ?>assets/<?php echo strtolower(WYVERN_SITE_NAME); ?>/images/logo.png">
                        <source src="<?php echo get_file($value, true); ?>"  type="video/mp4" />
                    </video>
                </div>
            <?php else: ?>
                <?php $file_url = get_file($value, true); ?>
                <?php if (isset($show_thumb) && $show_thumb == false): ?>  
                    <?php if ($file_url): ?>
                        <a href="<?php echo $file_url; ?>" data-toggle="lightbox">
                            View
                        </a>
                    <?php else: ?>
                        No Image Available
                    <?php endif; ?>
                <?php else: ?>

                    <a href="<?php echo get_file($value, true); ?>" data-toggle="lightbox">
                        <?php get_file($value); ?>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <p class="help-block"><?php echo isset($tooltip) ? $tooltip : ''; ?></p>
</div>
