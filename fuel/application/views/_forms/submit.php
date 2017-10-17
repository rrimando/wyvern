<?php
if (isset($class)) {
    $class = explode(',', $class);
    $classes = trim(implode(' ', $class));
}
?>

<?php
if (isset($data_controls)) {
    $_data_controls = '';
    foreach ($data_controls as $attribute => $value) {
        $_data_controls .= $attribute . "='{$value}' ";
    }
}
?>

<button <?php echo isset($id) ? "id='btn-{$id}'" : '' ?> 
    type="submit" 
    class="btn btn-primary<?php echo isset($classes) ? ' ' . $classes : ''; ?>"
    
    <?php echo isset($_data_controls) ? $_data_controls : ''; ?>>
    <span <?php echo isset($span_class) ? "class='{$span_class}'" : '' ?>>
        
        <?php echo isset($label) ? $label : 'Submit' ?>
    </span>
</button>
