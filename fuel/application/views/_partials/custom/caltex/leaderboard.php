<?php
// Fetch Projects
$CI = & get_instance();

$CI->load->model('wyvern_entity_model', '_projects')->init('project');
$CI->load->model('wyvern_facebook_api_model');

$projects = $CI->_projects->filter();
$sorted_projects = array();


foreach ($projects as $project) {
    $page_stats = reset($CI->wyvern_facebook_api_model->get_fb_likes(site_url('page/single_project/' . $project['project_id'])));

    $project['likes'] = $page_stats->like_count;

    $sorted_projects[] = $project;
}

usort($sorted_projects, function($a, $b) {
    return $b['likes'] - $a['likes'];
});

$top_projects = array_slice($sorted_projects, 0, 28);
?>

<div id="leader_board">
    <div class="post">
        <?php echo fetch_site_variable('leaderboard_content'); ?>
    </div>
    <hr class="horizontal-separator"/>

    <div class="leaderboard-wrap scroll-container default-skin">
        <ul>
            <?php if ($top_projects): ?>
                <?php foreach ($top_projects as $project): ?>
                    <li>
                        <a href="<?php echo site_url('page/single_project/' . $project['project_id']); ?>">
                            <?php echo $project['project_name']; ?> by <?php echo $project['school_name']; ?> <!-- (<?php echo $project['likes']; ?>) -->
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No projects have been funded yet.</li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="disclaimer">
        Disclaimer: Project rank is subject to change depending on the number of likes.
    </div>
</div>

