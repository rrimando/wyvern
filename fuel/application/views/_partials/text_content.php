<div id="main_inner">
    <p>
        <?php
        $_content = fetch_site_variable(nl2br($content));
        if (!empty($_content)) {
            echo $_content;
        } else {
            echo $content;
        }
        ?>  
    </p>
</div>
