<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
        Nav
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dropdownMenu1">
        <?php foreach ($items as $item => $attributes): ?>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo $attributes['url']; ?>"><?php echo $attributes['label']; ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>
