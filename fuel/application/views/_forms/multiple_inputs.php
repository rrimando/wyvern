<?php
$CI = & get_instance();
$CI->load->library('wyvern/wyvern_form_generator');
?>

<div id="<?php echo isset($id) ? $id : ''; ?>" class="clonable">
    <?php if (isset($label) && !empty($label)): ?>
        <label for="<?php echo isset($name) ? $name : ''; ?>"<?php echo isset($label_class) ? "class='{$label_class}'" : ''; ?>>
            <?php echo $label; ?>
        </label>
    <?php endif; ?>
    <input type="hidden" id="<?php echo isset($id) ? $id : ''; ?>_values" class="clonable-values" value="" />
    <div class="clone-wrap">
        <a href="#" class="btn-primary btn-small add-clonable">+</a>
        <?php // TODO Accept More Field Types ?>

        <?php foreach ($fields as $field): ?>
            <?php if ($field['attributes']['type'] == 'enumeration'): ?>

                <?php
                $options = $field['attributes']['options'];

                $CI->load->model('wyvern_entity_model', '_entity_model')->init($options['attributes']['entity']);

                $_options = $CI->_entity_model->fetch();
                ?>
                <div class="form-group">
                    <?php if (isset($label)): ?>
                        <label><?php echo $field['attributes']['label']; ?></label>
                    <?php endif; ?>

                    <select class="form-control"<?php echo isset($id) ? ' ' . "id='{$field['attributes']['id']}'" : ''; ?><?php echo isset($field['attributes']['name']) ? " name='{$field['attributes']['name']}'" : " name='{$field['attributes']['id']}'"; ?>>
                        <?php foreach ($_options as $_option): ?>

                            <option value="<?php echo $_option[$options['attributes']['value']]; ?>">
                                <?php echo ucwords($_option[$options['attributes']['label']]); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            <?php elseif ($field['attributes']['type'] == 'file'): ?> 

                <?php
                echo $this->wyvern_form_generator->render_element('file', $field['attributes']);
                ?>

            <?php else: ?>

                <?php
                if (isset($field['attributes']['class'])) {
                    $class = explode(',', $field['attributes']['class']);
                    $field['attributes']['classes'] = trim(implode(' ', $class));
                }
                ?>
                <div class="form-group<?php echo isset($field['attributes']['group_class']) ? ' ' . $field['attributes']['group_class'] : ''; ?>">
                    <?php if (isset($field['attributes']['label']) && !empty($field['attributes']['label'])): ?>
                        <label for="<?php echo isset($field['attributes']['name']) ? $field['attributes']['name'] : ''; ?>"<?php echo isset($field['attributes']['label_class']) ? "class='{$field['attributes']['label_class']}'" : ''; ?>>
                            <?php echo $field['attributes']['label']; ?>
                        </label>
                    <?php endif; ?>
                    <input type="<?php echo $field['attributes']['type']; ?>" class="form-control<?php echo isset($field['attributes']['classes']) ? ' ' . $field['attributes']['classes'] : ''; ?>"<?php echo isset($field['attributes']['name']) ? " name='{$field['attributes']['name']}'" : " name='{$field['attributes']['id']}'"; ?> id="<?php echo isset($field['attributes']['id']) ? $field['attributes']['id'] : ''; ?>" value="<?php echo isset($field['attributes']['value']) ? $field['attributes']['value'] : ''; ?>" placeholder="<?php echo isset($field['attributes']['placeholder']) ? $field['attributes']['placeholder'] : ''; ?>"<?php echo (isset($field['attributes']['required']) && $field['attributes']['required'] == true) ? " required" : ''; ?> data-target="<?php echo $id; ?>_values"/>
                </div>


            <?php endif; ?>
        <?php endforeach; ?>
        <div class="small-spacer"></div>
    </div>    
</div>
