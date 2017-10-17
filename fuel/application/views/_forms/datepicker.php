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
    <div class='input-group date' id='datetimepicker<?php echo isset($id) ? "_" . $id : ''; ?>'>
        <input type='text' class="form-control<?php echo isset($classes) ? ' ' . $classes : ''; ?>"<?php echo isset($name) ? " name='{$name}'" : " name='{$id}'"; ?> id="<?php echo isset($id) ? $id : ''; ?>" value="<?php echo isset($value) ? $value : ''; ?>" placeholder="<?php echo isset($placeholder) ? $placeholder : ''; ?>"<?php echo isset($required) ? " required" : ''; ?>/>
        <span class="input-group-addon">
            <span class="glyphicon glyphicon-calendar"></span>
        </span>
    </div>
</div>
<script type="text/javascript">

</script>
