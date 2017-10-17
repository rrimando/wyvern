<?php
// Fallback on type
$enumeration_type = isset($enumeration_type) ? $enumeration_type : 'select';

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
            $enum_options[] = trim($_option);
        }
    }
}
?>
<div class="form-group<?php echo isset($group_class) ? ' ' . $group_class : ''; ?>">
    <?php if (isset($label)): ?>
        <label for="<?php echo isset($name) ? $name : ''; ?>"<?php echo isset($label_class) ? "class='{$label_class}'" : ''; ?>><?php echo $label; ?></label>
    <?php endif; ?>
    <?php if ($enumeration_type == 'radio'): ?>
        <?php foreach ($enum_options as $key => $option): ?>
            <label class="radio-block <?php echo str_replace(" ", "-", strtolower($option)); ?><?php echo (isset($value) && ($value == strtolower(str_replace("_", " ", trim($key))))) ? ' active' : ''; ?>" onclick="setVal('#<?php echo $id; ?>', '<?php echo $key ?>')">
                <?php if (isset($index_override) && ($index_override)): ?>
                    <input type="radio" name="optradio<?php echo isset($name) ? '_' . "$name" : ''; ?>" onclick="setVal('#<?php echo $id; ?>', '<?php echo $key ?>')" <?php echo (isset($value) && ($value == strtolower(str_replace("_", " ", trim($key))))) ? 'checked="checked"' : ''; ?><?php echo isset($required) ? " required" : ''; ?>>
                <?php else: ?>
                    <input type="radio" name="optradio<?php echo isset($name) ? '_' . "$name" : ''; ?>" onclick="setVal('#<?php echo $id; ?>', '<?php echo wyvern_clean(strtolower(str_replace("_", " ", trim($option)))); ?>')" <?php echo (isset($value) && ($value == wyvern_clean(strtolower(str_replace("_", " ", trim($option)))))) ? 'checked="checked"' : ''; ?><?php echo isset($required) ? " required" : ''; ?>>
                <?php endif; ?>
                <span><?php echo trim(ucwords($option)); ?></span>
            </label>
        <?php endforeach; ?>
        <input type="hidden" <?php echo isset($id) ? ' ' . "id='{$id}'" : ''; ?><?php echo isset($name) ? " name='{$name}'" : " name='{$id}'"; ?> value="<?php echo (isset($value)) ? $value : ''; ?>"<?php echo isset($required) ? " required" : ''; ?>/>
    <?php endif; ?>
    <?php if ($enumeration_type == 'select'): ?>
        <select<?php echo isset($id) ? ' ' . "id='{$id}'" : ''; ?><?php echo isset($name) ? " name='{$name}'" : " name='{$id}'"; ?> class="form-control<?php echo isset($classes) ? ' ' . "$classes" : ''; ?>"<?php echo isset($required) ? " required" : ''; ?>>
            <?php foreach ($enum_options as $option_value => $option): ?>
                <?php if (isset($index_override) && ($index_override)): ?>
                    <option value="<?php echo strtolower(str_replace("_", " ", $option_value)); ?>" <?php echo (isset($value) && ($value == strtolower(str_replace("_", " ", $option_value)))) ? 'selected="selected"' : ''; ?>><?php echo ucwords($option); ?></option>
                <?php else: ?>
                    <option value="<?php echo strtolower(str_replace("_", " ", $option)); ?>" <?php echo (isset($value) && ($value == strtolower(str_replace("_", " ", $option)))) ? 'selected="selected"' : ''; ?>><?php echo ucwords($option); ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    <?php endif; ?>
</div>

