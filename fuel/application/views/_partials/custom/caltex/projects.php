<div id="projects_funded">
    <div class="post">
        <?php echo fetch_site_variable('funded_projects_content'); ?>
    </div>
    <hr class="horizontal-separator"/>
    <?php
    // Fetch Projects
    $CI = & get_instance();

    $CI->load->model('wyvern_entity_model', '_projects')->init('project');

    $projects = $CI->_projects->filter(array('is_funded' => 'funded'));
    ?>

    <ul>
        <?php if ($projects): ?>
            <?php foreach ($projects as $project): ?>
                <li>
                    <a href="<?php echo site_url('page/single_project/' . $project['project_id']); ?>">
                        <?php echo $project['project_name']; ?> by <?php echo $project['school_name']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No projects have been funded yet.</li>
        <?php endif; ?>
    </ul>

</div>
