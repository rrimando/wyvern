<nav>
    <ul class="nav">
        <li class="sidebar-brand">
            <h4><?php echo WYVERN_SITE_NAME; ?> Dashboard</h4>
        </li>
        <li>
            <strong>Reports</strong>
        </li>
        <?php if (isset($reports) && !empty($reports)): ?>
            <?php foreach ($reports as $report): ?>
                <li>
                    <a href="<?php echo site_url('reports/view/' . $report) ?>">
                        <strong><?php echo ucwords(str_replace("_", " ", $report)); ?></strong>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>
                <strong><i>No Reports Have Been Setup</i></strong>
            </li>
        <?php endif; ?>
        <li>
            <strong>Entities</strong>
        </li>
        <?php foreach ($entities as $entity): ?>
            <li><strong><a href="#" id="btn-<?php echo $entity; ?>" data-toggle="collapse" data-target="#submenu<?php echo $entity; ?>" aria-expanded="false"><?php echo ucwords(str_replace("_", " ", $entity)); ?></strong></a>
                <ul class="nav collapse" class="submenu" id="submenu<?php echo $entity; ?>" role="menu" aria-labelledby="btn-<?php echo $entity; ?>">
                    <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/view">View</a></li>
                    <?php if ($this->session->userdata('user_level') && $this->session->userdata('user_level') != 'Moderator'): ?>
                        <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/create">Add</a></li>
                    <?php endif; ?>
                    <?php if (WYVERN_ENTITY_DEBUG): ?>
                        <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/define">Entity Definition</a></li>
                        <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/reset_entity">Reset Entity</a></li>
                        <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/create_test_data">Create Test Data</a></li>
                    <?php endif; ?>
                </ul>
            </li>
        <?php endforeach; ?>
        <?php if (WYVERN_ENTITY_DEBUG): ?>
            <li><a href="<?php echo base_url(); ?>entity/<?php echo $entity; ?>/clear_entity_tables"><strong>Clear Entity Tables</strong></a></li>
        <?php endif; ?>
    </ul>
</nav>


