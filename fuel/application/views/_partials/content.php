<div class="post">
    <h3 class="<?php echo str_replace(" ", "-", strtolower($header)); ?>"><?php echo $header; ?></h3>
    <?php
    $_content = fetch_site_variable(nl2br($content));
    if (!empty($_content)) {
        echo $_content;
    } else {
        echo $content;
    }
    ?>  
</div>
