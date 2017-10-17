
<?php
if (isset($class)) {
    $class = explode(',', $class);
    $classes = trim(implode(' ', $class));
}
?>

<div class="form-group<?php echo isset($group_class) ? ' ' . $group_class : ''; ?>">

    <?php if (isset($label) && !empty($label)): ?>

        <label for="<?php echo isset($name) ? $name : ''; ?>"<?php echo isset($label_class) ? "class='{$label_class}'" : ''; ?>><?php echo $label; ?></label>
    <?php endif; ?>

    <input type="text" class="form-control<?php echo isset($classes) ? ' ' . $classes : ''; ?>"<?php echo isset($name) ? " name='{$name}'" : " name='{$id}'"; ?> id="<?php echo isset($id) ? $id : ''; ?>" value="<?php echo isset($value) ? $value : ''; ?>" placeholder="<?php echo isset($placeholder) ? $placeholder : ''; ?>"<?php echo (isset($required) && ($required)) ? " required" : ''; ?>/>
    <?php if (isset($footnote)): ?>

        <span class="footnote"><?php echo $footnote; ?></span>
    <?php endif; ?>
    <?php if (isset($tooltip)): ?>

        <span class="tooltip"><?php echo $tooltip; ?></span>
    <?php endif; ?>

</div>
