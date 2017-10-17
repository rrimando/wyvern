<?php $CI = & get_instance(); ?>
<?php $CI->load->model('wyvern_data_block'); ?>
<div class=" table-responsive<?php echo isset($table_attributes['div_class']) ? " " . $table_attributes['div_class'] : ''; ?>">
    <table class="table<?php echo isset($table_attributes['class']) ? " " . $table_attributes['class'] : ''; ?>"<?php echo isset($table_attributes['table_id']) ? " id='{$table_attributes['table_id']}'" : ''; ?>>
        <thead>
            <tr>
                <?php foreach ($table_headers as $field => $attributes): ?>
                    <?php if (isset($attributes['attributes']['admin_hide']) && ($attributes['attributes']['admin_hide'])): ?>
                        <!-- hidden -->
                    <?php else: ?>
                        <?php if (isset($attributes['attributes']['placeholder'])): ?>
                            <th><?php echo truncate(ucwords(str_replace("_", " ", $attributes['attributes']['placeholder'])), 60); ?></th>
                        <?php else: ?>
                            <th><?php echo truncate(ucwords(str_replace("_", " ", $field)), 60); ?></th>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if ($table_controls || isset($table_attributes['custom_actions'])): ?>
                    <th>Actions</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($table_data as $row_array): ?>
                <tr>
                    <?php foreach ($table_headers as $header => $attributes): ?>
                        <?php if (isset($attributes['attributes']['admin_hide']) && ($attributes['attributes']['admin_hide'])): ?>
                            <!-- hidden -->
                        <?php else: ?>
                            <?php if (isset($attributes['attributes']['type'])): ?>
                                <?php if ($attributes['attributes']['type'] == 'file' || $attributes['attributes']['type'] == 'document'): ?>
                                    <?php if (isset($attributes['attributes']['show_thumb']) && $attributes['attributes']['show_thumb'] == false): ?>
                                        <?php $file_url = get_file($row_array[str_replace(" ", "_", $header)], true); ?>
                                        <td>
                                            <?php if ($file_url): ?>
                                                <a href="<?php echo get_file($row_array[str_replace(" ", "_", $header)], true); ?>" data-toggle="lightbox">
                                                    View
                                                </a>
                                            <?php else: ?>
                                                No File Attached
                                            <?php endif; ?>
                                        </td>
                                    <?php else: ?>
                                        <?php $file_url = isset($row_array[str_replace(" ", "_", $header)])?get_file($row_array[str_replace(" ", "_", $header)], true):''; ?>
                                        <td>
                                            <?php if ($file_url): ?>
                                                <a href="<?php echo get_file($row_array[str_replace(" ", "_", $header)], true); ?>" data-toggle="lightbox">
                                                    <?php echo isset($row_array[str_replace(" ", "_", $header)]) ? get_file($row_array[str_replace(" ", "_", $header)]) : ''; ?>
                                                </a>
                                            <?php else: ?>
                                                No File Attached
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if (isset($row_array[str_replace(" ", "_", $header)]) && !empty($row_array[str_replace(" ", "_", $header)])): ?>
                                        <?php if (isset($attributes['attributes']['get_by'])): ?>
                                            <td>
                                                <?php
                                                echo $CI->wyvern_data_block->fetch_single_entity_value(
                                                        $attributes['attributes']['get'], $attributes['attributes']['get_by'], $get_with = $row_array[str_replace(" ", "_", $header)], $attributes['attributes']['get_from']);
                                                ?>
                                            </td>
                                        <?php else: ?>
                                            <td><?php echo isset($row_array[str_replace(" ", "_", $header)]) ? truncate($row_array[str_replace(" ", "_", $header)], 100) : ''; ?></td>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <td>--</td>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php if (isset($row_array[str_replace(" ", "_", $header)]) && !empty($row_array[str_replace(" ", "_", $header)])): ?>
                                    <?php if (isset($attributes['attributes']['get_by'])): ?>
                                        <td>

                                            <?php
                                            echo $CI->wyvern_data_block->fetch_single_entity_value(
                                                    $attributes['attributes']['get'], $attributes['attributes']['get_by'], $get_with = $row_array[str_replace(" ", "_", $header)], $attributes['attributes']['get_from']);
                                            ?>
                                        </td>
                                    <?php else: ?>
                                        <td><?php echo isset($row_array[str_replace(" ", "_", $header)]) ? truncate($row_array[str_replace(" ", "_", $header)], 100) : ''; ?></td>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <td>--</td>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ($table_controls): ?>
                        <?php if (defined('WYVERN_OBFUSCATE') && (WYVERN_OBFUSCATE)): ?>
                            <td>
                                <a href="javascript:void(0)" onclick="entity_edit('<?php echo rawurlencode(base64_encode($table_entity)); ?>', '<?php echo rawurlencode(base64_encode($row_array[$table_entity . '_id'])); ?>')">Edit</a>
                                <?php if ($this->session->userdata('user_level') && $this->session->userdata('user_level') != 'Moderator'): ?>
                                    |
                                    <a href = "javascript:void(0)" onclick = "entity_delete('<?php echo rawurlencode(base64_encode($table_entity)); ?>', '<?php echo rawurlencode(base64_encode($row_array[$table_entity . '_id'])); ?>')">Delete</a>
                                <?php endif; ?>
                            </td>
                        <?php else: ?>
                            <td>
                                <a href="javascript:void(0)" onclick="entity_edit('<?php echo $table_entity; ?>', '<?php echo $row_array[$table_entity . '_id']; ?>')">Edit</a>
                                <?php if ($this->session->userdata('user_level') && $this->session->userdata('user_level') != 'Moderator'): ?>
                                    |
                                    <a href = "javascript:void(0)" onclick = "entity_delete('<?php echo $table_entity; ?>', '<?php echo $row_array[$table_entity . '_id']; ?>')">Delete</a>
                                <?php endif; ?>
                            </td>
                        <?php endif; ?>
                    <?php endif;
                    ?>    
                    <?php if (isset($table_attributes['custom_actions'])): ?>
                        <td>
                            <?php foreach ($table_attributes['custom_actions'] as $action => $attributes): ?>
                                <a href="<?php echo base_url(); ?><?php echo strtolower($action); ?>/<?php echo $table_entity; ?>/<?php echo $row_array[$table_entity . '_id']; ?>">
                                    <?php echo $action; ?>
                                </a>
                            <?php endforeach; ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php if ($table_controls && isset($table_attributes['table_id'])): ?>

    <div class="more-controls">
        <button class="btn btn-mini btn-primary download-excel" onclick="tableToExcel('<?php echo $table_attributes['table_id']; ?>', '<?php echo ucwords(str_replace("_", " ", $table_attributes['table_id'])); ?>')">Download as Excel</button>
    </div>

<?php endif; ?>
