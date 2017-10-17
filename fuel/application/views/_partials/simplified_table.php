<div class="<?php echo isset($table_attributes['div_class']) ? $table_attributes['div_class'] : ''; ?>">
    <table class="table<?php echo isset($table_attributes['class']) ? " " . $table_attributes['class'] : ''; ?> table-bordered">
        <thead>
            <tr>
                <?php foreach ($table_headers as $header): ?>
                    <th><?php echo ucwords(str_replace("_", " ", $header)); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($table_data as $row_lead_in => $row_array):
                if (is_array($row_array)):
                    $count = count($row_array);
                    ?>
                    <tr>
                        <?php for ($i = 0; $i <= $count; $i++): ?>
                            <td><?php echo $row_array[$i]; ?></td>
                        <?php endfor; ?>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td><?php echo $row_lead_in; ?></td>
                        <td><?php echo $row_array; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
