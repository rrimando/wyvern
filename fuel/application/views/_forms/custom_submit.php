<?php
if (isset($class)) {
    $class = explode(',', $class);
    $classes = trim(implode(' ', $class));
}
?>
<button <?php echo isset($id) ? "id='btn-{$id}'" : '' ?> type="submit" class="btn btn-primary<?php echo isset($classes) ? ' ' . $classes : ''; ?>"><?php echo isset($label) ? $label : 'Submit' ?></button>
