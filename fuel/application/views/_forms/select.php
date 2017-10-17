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
        
    <select<?php echo isset($id) ? ' ' . "id='{$id}'" : ''; ?><?php echo isset($name) ? " name='{$name}'" : " name='{$id}'"; ?> class="form-control<?php echo isset($classes) ? ' ' . "$classes" : ''; ?>"<?php echo isset($required) ? " required" : ''; ?>>
        <?php foreach ($enum_options as $option_value => $option): ?>
        
            <option value="<?php echo strtolower(str_replace("_", " ", $option_value)); ?>"><?php echo ucwords($option); ?></option>
        <?php endforeach; ?>
            
    </select>
</div>
