<script type="text/javascript">
    $(document).ready(function(event){
        var validator = $('#<?php echo $form['attributes']['id']; ?>').validate();
        $("#btn-<?php echo $form['submit']['id']; ?>").click(function(){
            var ladda_loader = Ladda.create(this);
            validator.form();
            var _valid = validator.valid();
            if(_valid){
                ladda_loader.start();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() . $form['ajax']['url']; ?>",   
                    data: {
                        <?php foreach ($form['fields'] as $field => $attributes): ?>
                            <?php if(isset($attributes['attributes']['id']) 
                                    && $attributes['attributes']['type'] != 'custom_submit' 
                                    && $attributes['attributes']['type'] != 'content_block' 
                                    && $attributes['attributes']['type'] != 'header' // Need a better way to do this
                                    && !isset($attributes['attributes']['primary_key'])
                                    ): ?>
                                <?php if($attributes['attributes']['type'] == 'multiple_inputs'): ?>
                                    
                                    <?php echo "multiple_input_" . strtolower(str_replace(" ", "_",$field)); ?>: $("#<?php echo $attributes['attributes']['id']; ?>_values").val(),
                                <?php else: ?>
                                    
                                    <?php echo strtolower(str_replace(" ", "_",$field)); ?>: $("#<?php echo $attributes['attributes']['id']; ?>").val(),
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>    
                        <?php if(isset($form['attributes']['is_entity'])): ?>
                            
                            'entity' : '<?php echo strtolower(str_replace(" ", "_", $form['attributes']['entity_name'])); ?>',
                            'entity_load' : '1',
                        <?php endif; ?>
                        <?php if(is_logged()): ?>    
                                <?php if(isset($_SERVER['HTTP_REFERER'])): ?>

                                'previous_page': '<?php echo $_SERVER['HTTP_REFERER']; ?>',
                                <?php endif; ?>
                        <?php endif; ?>    
                        <?php if(WYVERN_CSRF): ?>    

                                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                        <?php endif; ?>
                            
                    },
                    dataType: 'json', // Choosing a JSON datatype

                <?php if(isset($form['ajax']['success'])): ?>    

                    success: function(response){
                        <?php if(isset($form['ajax']['success_action'])): ?>
                                
                            <?php echo $form['ajax']['success_action']; ?>(<?php echo $form['ajax']['success']; ?>);
                        <?php else: ?>
                            
                            redirect('<?php echo base_url() .$form['ajax']['success']; ?>');
                        <?php endif; ?>
                            
                    }
                });
                <?php else: ?>
            
                }).done(function(response) {
                    setTimeout(function(){
                        ladda_loader.stop();
                        executeFunctionByName(response.callback, window, response.params);
                        //your code to be executed after 1 seconds
                    },800);
                });
                
                <?php endif;?>
                
            }
            return false;
            event.prevenDefault();
        })
    });
    $(function () {
    
        <?php foreach ($form['fields'] as $field => $attributes): ?>
            <?php if(isset($attributes['attributes']['id'])): ?>
                <?php if($attributes['attributes']['type'] == 'date'): ?>
                    
                    $('#datetimepicker<?php echo "_" . $attributes['attributes']['id']; ?>').datetimepicker();
                <?php endif;?>
                <?php if($attributes['attributes']['type'] == 'custom_submit'): ?>
                    
                    $('#btn-<?php echo $attributes['attributes']['id']; ?>').click(function(){ _alert('We are working on that :D Just type anything on the custom field for now')});
                <?php endif;?>
                <?php if(isset($attributes['attributes']['disabled']) && $attributes['attributes']['disabled'] == true): ?>
                    
                    $("#<?php echo $attributes['attributes']['id']; ?>").attr('disabled', 'disabled');
                <?php endif; ?>
                <?php if($attributes['attributes']['type'] == 'file' || $attributes['attributes']['type'] == 'document' || $attributes['attributes']['type'] == 'video'): ?>
                    <?php $timestamp = time();?>
                     
                    <?php if (defined('WYVERN_UPLOADIFIVE')): ?> 
                     
                    $("#uploadify-<?php echo $attributes['attributes']['id']; ?>").uploadifive({
                    <?php else: ?> 
                     
                    $("#uploadify-<?php echo $attributes['attributes']['id']; ?>").uploadify({
                    <?php endif; ?>
                            
                        'formData'     : {
                                <?php if(isset($attributes['attributes']['allowed_types'])): ?>
                                            
                                    'allowed_types' : '<?php echo $attributes['attributes']['allowed_types']; ?>',
                                <?php endif; ?>
                                <?php if(WYVERN_CSRF): ?>
                                    
                                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
                                <?php endif; ?>
                                    
                                'timestamp' : '<?php echo $timestamp; ?>',
                                'token'     : '<?php echo md5('unique_salt' . $timestamp);?>'
                        
                        },
                        'onUploadComplete' : function(file, data) {
                            // console.log(file);
                            // console.log(data);
                            // console.log(response);
                            var _data = $.parseJSON( data );
                            
                            if(_data.callback) { 
                                executeFunctionByName(_data.callback, window, _data.params);
                            }else{
                                $("#<?php echo $attributes['attributes']['id']; ?>").val(_data.id);
                                $("#fileinput-<?php echo $attributes['attributes']['id']; ?> .file_container").empty();
                                
                                <?php if($attributes['attributes']['type'] == 'file'): ?>
                                    
                                    var image_html = '<a href="<?php echo base_url(); ?>assets/<?php echo strtolower(WYVERN_SITE_NAME); ?>/uploads/' + _data.filename + '" data-toggle="lightbox"><img src="<?php echo base_url(); ?>assets/<?php echo strtolower(WYVERN_SITE_NAME); ?>/uploads/' + _data.filename + '" /></a>'
                                    $("#fileinput-<?php echo $attributes['attributes']['id']; ?> .file_container").append(image_html);
                                <?php elseif($attributes['attributes']['type'] == 'video'): ?>   
                                
                                    var image_html = '<div id="video-container"><video width="640" height="360" id="player1" controls="controls" preload="none" poster="<?php echo base_url(); ?>assets/<?php echo strtolower(WYVERN_SITE_NAME); ?>/images/logo.png"><source src="<?php echo base_url(); ?>assets/<?php echo strtolower(WYVERN_SITE_NAME); ?>/uploads/' + _data.filename + '"  type="video/mp4" /></video></div>'
                                    $("#fileinput-<?php echo $attributes['attributes']['id']; ?> .file_container").append(image_html);
                                <?php else: ?>
                                    
                                    var image_html = '<a href="<?php echo base_url(); ?>assets/<?php echo strtolower(WYVERN_SITE_NAME); ?>/uploads/' + _data.filename + '" target="_blank">Download</a>'
                                    $("#fileinput-<?php echo $attributes['attributes']['id']; ?> .file_container").append(image_html);
                                <?php endif; ?>
                            }
                        },
                        'onUploadSuccess' : function(file, data) {
                            // console.log(file);
                            // console.log(data);
                            // console.log(response);
                            var _data = $.parseJSON( data );
                            
                            if(_data.callback) { 
                                executeFunctionByName(_data.callback, window, _data.params);
                            }else{
                                $("#<?php echo $attributes['attributes']['id']; ?>").val(_data.id);
                                $("#<?php echo $attributes['attributes']['id']; ?> .file_container").empty();
                                
                                <?php if($attributes['attributes']['type'] == 'file'): ?>
                                    
                                    var image_html = '<a href="<?php echo base_url(); ?>assets/<?php echo strtolower(WYVERN_SITE_NAME); ?>/uploads/' + _data.filename + '" data-toggle="lightbox"><img src="<?php echo base_url(); ?>assets/<?php echo strtolower(WYVERN_SITE_NAME); ?>/uploads/' + _data.filename + '" /></a>'
                                    $("#fileinput-<?php echo $attributes['attributes']['id']; ?> .file_container").append(image_html);
                                <?php else: ?>
                                    
                                    var image_html = '<a href="<?php echo base_url(); ?>assets/<?php echo strtolower(WYVERN_SITE_NAME); ?>/uploads/' + _data.filename + '" target="_blank">Download</a>'
                                    $("#fileinput-<?php echo $attributes['attributes']['id']; ?> .file_container").append(image_html);
                                <?php endif; ?>
                            }
                        },
                        buttonText    : 'Browse',
                        sizeLimit     : '1073741824',
                        height        : 20,
                        swf           : '<?php echo base_url(); ?>/assets/uploadify/uploadify.swf',
                        uploadScript  : '<?php echo base_url(); ?>upload/upload_file',
                        uploader      : '<?php echo base_url(); ?>upload/upload_file',
                        width         : 80
                    });
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; ?>
            
    });
</script>


