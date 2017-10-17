<?php
if (isset($class)) {
    $class = explode(',', $class);
    $classes = trim(implode(' ', $class));
}

if (isset($options)) {
    if (is_array($options)) {
        $enum_options = $options;
    } else {
        $enum_options = array();
        $_options = explode(',', $options);
        foreach ($_options as $_option) {
            $enum_options[$_option] = $_option;
        }
    }
}
?>
<div class="form-group<?php echo isset($group_class) ? ' ' . $group_class : ''; ?>">
    <?php if (isset($label)): ?>
        <label for="<?php echo isset($name) ? $name : ''; ?>"<?php echo isset($label_class) ? "class='{$label_class}'" : ''; ?>><?php echo $label; ?></label>
    <?php endif; ?>

    <?php foreach ($enum_options as $option): ?>
        <label class="radio-block">
            <input type="radio" name="optradio<?php echo isset($name) ? '_' . "$name" : ''; ?>" onclick="setVal('#<?php echo $id; ?>', '<?php echo strtolower(str_replace("_", " ", trim($option))); ?>')">
            <?php echo trim(ucwords($option)); ?>
        </label>
    <?php endforeach; ?>
    <input type="hidden" <?php echo isset($id) ? ' ' . "id='{$id}'" : ''; ?><?php echo isset($name) ? " name='{$name}' " : " name='{$id}' "; ?> value=""<?php echo isset($required) ? " required" : ''; ?>/>
</div>
