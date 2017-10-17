<ul class="pull-right" role="menu" id="<?php echo $id; ?>">
    <?php foreach ($items as $item => $attributes): ?>
        <?php if ($attributes['label'] == 'Edit Profile'): ?>
            <?php
            $entity_type = $this->session->userdata('entity_type');
            ?>
            <?php if (defined('WYVERN_OBFUSCATE') && (WYVERN_OBFUSCATE)): ?>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('entity/edit/' . rawurlencode(base64_encode($entity_type)) . "/" . rawurlencode(base64_encode($this->session->userdata($entity_type . "_id")))); ?>"><?php echo $attributes['label']; ?></a></li>
            <?php else: ?>
                <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo site_url('entity/edit/' . $entity_type . "/" . $this->session->userdata($entity_type . "_id")); ?>"><?php echo $attributes['label']; ?></a></li>
            <?php endif; ?>
        <?php else: ?>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo isset($attributes['url']) ? site_url($attributes['url']) : 'javascript:void(0)'; ?>"><?php echo $attributes['label']; ?></a></li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>
