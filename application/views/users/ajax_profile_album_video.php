
<div class="profile_page_back" style="padding:15px;">
    <?php
        if (!empty($post_data)) {
            foreach ($post_data as $content) {
                ?>
                <div class="profile_block_body">
                    <?php
                        $extention = end(explode(".", $content));
                    ?>

                    <video width="100%" height="315" controls>
                        <source src="<?php echo base_url(); ?>images/talent/<?php echo $content; ?>" type="video/<?php echo $extention; ?>">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <?php
            }
        }
    ?>
</div>