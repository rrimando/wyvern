<?php
if (isset($form_attr['class'])) {
    $_class = explode(',', $form_attr['class']);
    $classes = trim(implode(' ', $_class));
}
?>

<form id="<?php echo $form_attr['id']; ?>"<?php echo isset($classes) ? " class='{$classes}'" : '' ?>>
    
    <?php foreach ($form_fields as $field): ?>
    
        <?php echo $field; ?>
    <?php endforeach; ?>

    <?php echo $form_submit; ?>
</form>
