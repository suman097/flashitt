<?php
if (!empty($posts)) {
    foreach ($posts as $post) {
        ?>
        <div class="profile_page_back" style="padding:5px;">
            <div class="profile_block_header">
                <?php $talent_profile_id = ((( $post->users_id * 26 ) + 5364 ) - 769 ); ?>
                <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/talentProfile/' . $talent_profile_id . '/' . urlencode($post->name)); ?>"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $post->image; ?>" alt=""></a></div>
                &nbsp;&nbsp; <a href = "<?php echo base_url('home/talentProfile/' . $talent_profile_id . '/' . urlencode($post->name)); ?>"><font style="color:#333; font-size:16px; font-weight: bold;"><?php echo $post->name; ?></font></a>
                <?php
                if ($users_loged_in_id == $post->users_id) {
                    ?>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span><a href = "javascript:void(0);" onclick = "return onclickPostDelete(<?php echo $post->id; ?>);" style = "color: #CCC;" title = "Delete">X</a></span>
                    <?php
                }
                ?>
                <br>
                <!-- &nbsp;&nbsp; <a href = "<?php echo base_url('home/postDetails/' . $post->id); ?>"><font style="color:#0287F8; font-size:14px;"><?php echo $post->title; ?></font></a> -->
                &nbsp;&nbsp; <font style="color:#0287F8; font-size:14px;"><?php echo $post->title; ?></font>
                &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $post->description; ?></font>
                <br>
                <?php
                $post_date_explode = explode(" ", $post->created_at);
                ?>
                &nbsp;&nbsp; <font style="color:#999; font-size:12px;">. . <?php echo $post_date_explode[0]; ?></font><br>

            </div>
            <?php
            if (!empty($post_contents[$post->id])) {
                foreach ($post_contents[$post->id] as $content) {
                    if ($content->elements_type == 2) {
                        ?>
                        <div class="col-sm-6" ><img src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" alt="">
                            <?php
                            if ($users_loged_in_id == $post->users_id) {
                                ?>
                                <span><a href = "javascript:void(0);" onclick = "return onclickPostContentDelete(<?php echo $content->id; ?>);" style = "color: #CCC;" title = "Delete">Delete</a></span>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    } else if ($content->elements_type == 3) {
                        ?>
                        <div class="profile_block_body">
                            <?php
                            $extention = end(explode(".", $content->elements));
                            ?>
                            <video width="100%" height="315" controls>
                                <source src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" type="video/<?php echo $extention; ?>">
                    <!--                                                <source src="movie.ogg" type="video/ogg">-->
                                Your browser does not support the video tag.
                            </video>
                            <span><a href = "javascript:void(0);" onclick = "return onclickPostContentDelete(<?php echo $content->id; ?>);" style = "color: #CCC;" title = "Delete">Delete</a></span>
                            <!--<iframe width="100%" height="315" src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" frameborder="0" allowfullscreen></iframe>-->
                        </div>
                        <?php
                    }
                }
            }
            ?>
            <span id = "img_firework_<?php echo $post->id; ?>" style = "<?php if (!empty($firework[$post->id])) {
            echo 'display: none;';
        } ?>"><img src = "<?php echo base_url(); ?>images/graphics-fireworks.gif"></span>
            <div class="profile_block_footer">
                <p style="border-bottom:1px solid #CCC;">
                    <a href="javascript:void(0);" 
                       id ="link_post_<?php echo $post->id; ?>" 
                       onclick = "return onClickLike('<?php echo $post->id; ?>');" 
        <?php if ($count_like[$post->id] > 0) {
            echo "style = 'color:#E51323;'";
        } ?> >
                        <i class="glyphicon glyphicon-heart-empty"></i>
                        <span id = "post_like_<?php echo $post->id; ?>" ><?php if ($count_like[$post->id] > 0) {
            echo $count_like[$post->id] . " Wows";
        } else {
            echo " Wow";
        } ?></span></a>&nbsp;&nbsp;
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLike<?php echo $post->id; ?>"><i class="glyphicon glyphicon-heart-empty"></i>-By</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="#collaps_comment_<?php echo $post->id; ?>" data-toggle="collapse" data-target="#collaps_comment_<?php echo $post->id; ?>"><i class="fa fa-comments-o"></i> <?php if ($count_comments[$post->id] > 0) {
            echo $count_comments[$post->id];
        } ?> Comment</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <a href="javascript:void(0);" id ="fire_post_<?php echo $post->id; ?>" onclick = "return onClickFire('<?php echo $post->id; ?>');" ><span class = "firework_span"> &nbsp; &nbsp; &nbsp; &nbsp;</span> <span id = "count_firework_<?php echo $post->id; ?>"><?php if ($count_fireworked[$post->id] > 0) {
            echo $count_fireworked[$post->id];
        } ?></span> Firework</a>
                    <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalfirework<?php echo $post->id; ?>"><span class = "firework_span"> &nbsp; &nbsp; &nbsp; &nbsp;</span>-By</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <!-- <a href="#"><i class="fa fa-share-square-o"></i> Share</a>-->
                </p>
                <!-- who loved modal -->
                <div id="myModalLike<?php echo $post->id; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">People Who Wows This</h4>
                            </div>
                            <div class="modal-body">
        <?php
        if (!empty($liked[$post->id])) {
            foreach ($liked[$post->id] as $like) {
                echo "<p>" . $like->name . "</p>";
            }
        }
        ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- who loved modal -->

                <!-- Who firework of the post -->

                <div id="myModalfirework<?php echo $post->id; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">People who fireworked this</h4>
                            </div>
                            <div class="modal-body">
        <?php
        if (!empty($fireworked[$post->id])) {
            foreach ($fireworked[$post->id] as $work) {
                echo "<p>" . $work->name . "</p>";
            }
        }
        ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Who firework of the post -->

                <div id="collaps_comment_<?php echo $post->id; ?>" class="panel-collapse collapse" style="margin-top:1px;">
                    <div id = "total_comment_<?php echo $post->id; ?>">
        <?php
        if (!empty($comments[$post->id])) {
            foreach ($comments[$post->id] as $comment) {
                $comment_profile_id = ((( $post->users_id * 26 ) + 5364 ) - 769 );
                ?>
                                <div style="width:100%; float:left; margin-top:8px; margin-left:10px;">
                                    <div class="profile_block_header_thumb" style = "height: 44px; width: 44px;"><a href = "<?php echo base_url('home/talentProfile/' . $comment_profile_id . '/' . urlencode($comment->name)); ?>"><img height="100%"  width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $comment->image; ?>" alt=""></a></div>
                                    &nbsp;&nbsp; <font style="color:#333; font-size:12px;"><a href = "<?php echo base_url('home/talentProfile/' . $comment_profile_id . '/' . urlencode($comment->name)); ?>"><?php echo $comment->name; ?></a></font><br>
                                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $comment->comments; ?></font><br>
                <?php
                $comment_date_explode = explode(" ", $comment->post_at);
                ?>
                                    &nbsp;&nbsp; <font style="color:#999; font-size:10px;"> . . . . <?php echo $comment_date_explode[0]; ?></font><br>
                                </div>

                <?php
            }
        }
        ?>
                    </div>

                    <div style="width:100%; float:left; margin-top:1px;">
                        <div class="input-group">     
                            <input type="text" class="form-control" id = "post_text_<?php echo $post->id; ?>" placeholder="Post your comment...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" onclick = "return onClickPostStatus(<?php echo $post->id; ?>);" >Post</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>