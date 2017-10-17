
<div class="form-group<?php echo isset($group_class) ? ' ' . $group_class : ''; ?>">
    <?php if (isset($label) && !empty($label)): ?>
    
        <label for="<?php echo isset($name) ? $name : ''; ?>"<?php echo isset($label_class) ? "class='{$label_class}'" : ''; ?>><?php echo $label; ?></label>
    <?php endif; ?>
        
    <textarea class="form-control<?php echo isset($classes) ? ' ' . $classes : ''; ?>"<?php echo isset($name) ? " name='{$name}'" : " name='{$id}'"; ?> id="<?php echo isset($id) ? $id : ''; ?>" placeholder="<?php echo isset($placeholder) ? $placeholder : ''; ?>" rows="<?php echo isset($rows) ? $rows : 3; ?>"<?php echo isset($required) ? " required" : ''; ?>><?php echo isset($value) ? $value : ''; ?></textarea>
</div>
