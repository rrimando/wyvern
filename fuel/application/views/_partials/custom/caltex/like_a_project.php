<?php
// Fetch Projects
$CI = & get_instance();

$CI->load->model('wyvern_entity_model', '_projects')->init('project');
$CI->load->model('wyvern_entity_model', '_project_subjects')->init('project_subjects');

$location = $CI->uri->segment(4);

if ($location == 'view_all') {
    unset($location);
}

if (isset($location) && $location != false) {
    $projects = $CI->_projects->filter(array('school_location' => ucwords(str_replace("_", " ", $location))));
} else {
    $projects = $CI->_projects->fetch();
}

$locations = array(
    'view all',
    'manila',
    'las pinas',
    // 'makati',
    // 'mandaluyong',
    'marikina',
    'muntinlupa',
    // 'taguig',
    'quezon city',
    'paranaque',
    'pasay',
    'navotas',
    'san juan',
    'caloocan',
    'malabon',
    'pasig'
);

$project_subjects = $CI->_project_subjects->fetch();
?>
<div id="like_a_project">
    <div class="post">
        <form id="search-filters">
            <img src="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/images/search-by.png"/>
            <select id="subject-filter" class="form-control filter">
                <option value="0">Categories</option>
                <?php foreach ($project_subjects as $key => $array): ?>
                    <option value="<?php echo $array['project_subjects_name']; ?>"><?php echo $array['project_subjects_name']; ?></option>
                <?php endforeach; ?>
            </select>
            <select id="location-filter" class="form-control filter">
                <option value="0">City</option>
                <?php foreach ($locations as $location): ?>
                    <?php if ($location != 'view all'): ?>
                        <option value="<?php echo ucwords($location); ?>"><?php echo ucwords($location); ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
            <script>
                $(function () {
                    $('.filter').bind('change', function () {

                        var loader = "<img src='<?php echo base_url(); ?>/assets/img/loading.gif' class='loader'/>"

                        $("#projects_container").empty().append(loader);

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url() . 'ajax/fetch_content/project'; ?>",
                            data: {
                                'project_subject': $('#subject-filter').val(),
                                'school_location': $('#location-filter').val()
                            },
                            dataType: 'json'
                        }).done(function (response) {
                            if (response.total) {
                                $("#projects_container").empty();
                                $.each(response.data, function (i, item) {
                                    console.log(response.data[i]);
                                    var inner_html = '<div class="project" onclick="window.location.href="<?php echo site_url('page/single_project'); ?>/' + response.data[i].project_id + '">';
                                    inner_html = inner_html + '<div class="image-container"><img src="' + response.data[i].class_photo_image + '" alt="<?php echo WYVERN_SITE_NAME; ?>"/></div>';
                                    var schoolname = response.data[i].school_name;
                                    inner_html = inner_html + '<span class="school-name">' + schoolname.substring(0, 25) + '</span>';

                                    var projectname = response.data[i].school_name;

                                    inner_html = inner_html + '<span class="project-title">' + projectname.substring(0, 20) + '</span>';

                                    var about = response.data[i].about_project

                                    inner_html = inner_html + '<span class="about-project">' + about.substring(0, 140) + '</span>';

                                    // inner_html = inner_html + '<div class="button-container"><div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/"  data-href="<?php echo site_url('page/single_project'); ?>/' + response.data[i].project_id + '" data-width="200" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>';
                                    inner_html = inner_html + '<a href="<?php echo site_url('page/single_project'); ?>/' + response.data[i].project_id + '">View Project</a>';
                                    inner_html = inner_html + '</div>';

                                    $("#projects_container").append(inner_html);
                                    inner_html = '';
                                });
                            } else {
                                $("#projects_container").empty().html('No Projects Found');
                            }
                        }, 2000);
                    });
                })
            </script>
        </form>
        <div class="clearfix"></div>
        <?php echo fetch_site_variable('like_a_project_content'); ?>
    </div>
    <hr class="horizontal-separator"/>
    <div class="location-picker">

        <ul class="locations">
            <?php foreach ($locations as $location): ?>
                <li>
                    <a href="<?php echo site_url('page/like_a_project/location/' . str_replace(' ', '_', $location)); ?>">
                        <img src="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/images/locations/<?php echo str_replace(" ", "", $location); ?>.fw.png" class="img-responsive" alt="<?php echo WYVERN_SITE_NAME; ?>"/>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <hr class="horizontal-separator"/>

    <?php //nice_dump($projects);   ?>
    <div id="projects_container" class="scroll-container default-skin">
        <?php if ($projects): ?>

            <?php foreach ($projects as $project): ?>
                <div class="project" onclick="window.location.href = '<?php echo site_url('page/single_project/' . $project['project_id']); ?>'">
                    <?php $image = get_file($project['class_photo'], true); ?>
                    <div class="image-container"><img src="<?php echo $image; ?>" alt="<?php echo WYVERN_SITE_NAME; ?>"/></div>
                    <span class="school-name">
                        <?php echo htmlentities(truncate(str_replace("High School", "H.S.", $project['school_name']), 25)); ?>
                    </span>
                    <span class="project-title">
                        <?php echo htmlentities(truncate($project['project_name'], 25)); ?>
                    </span>
                    <span class="about-project">
                        <?php echo htmlentities(truncate($project['about_project'], 140)); ?>
                    </span>
                    <div class="button-container">
                        <div class="fb-like" data-href="<?php echo site_url('page/single_project/' . $project['project_id']); ?>" data-width="200" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php /*
              <div class="project"></div>
              <div class="project"></div>
              <div class="project"></div>
              <div class="project"></div>
              <div class="project"></div>
              <div class="project"></div>
              <div class="project"></div>
              <div class="project"></div>
              <div class="project"></div>
              <div class="project"></div>
              <div class="project"></div>
             * 
             */ ?>
        <?php else: ?>
            No Projects Listed
        <?php endif; ?>
    </div>
    <!-- Button trigger modal -->
    <span href="#" class="modal-button" data-toggle="modal" data-target="#how-we-choose">
        <img src="<?php echo base_url(); ?>assets/<?php echo WYVERN_ASSET_FOLDER; ?>/images/how-chosen.png" alt="<?php echo WYVERN_SITE_NAME; ?>"/>
    </span>
</div>

