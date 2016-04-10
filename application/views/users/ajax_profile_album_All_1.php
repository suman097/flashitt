<?php
    if (!empty($posts)) {
        foreach ($posts as $post) {
            ?>
            <div class="profile_page_back" style="padding:15px;">
                <div class="profile_block_header">
                    <?php $talent_profile_id = ((( $post->users_id * 26 ) + 5364 ) - 769 ); ?>
                    <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/talentProfile/'.$talent_profile_id.'/'.urlencode($post->name)); ?>"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $post->image; ?>" alt=""></a></div>
                    &nbsp;&nbsp; <a href = "<?php echo base_url('home/talentProfile/'.$talent_profile_id.'/'.urlencode($post->name)); ?>"><font style="color:#333; font-size:16px; font-weight: bold;"><?php echo $post->name; ?></font></a><br>
                    &nbsp;&nbsp; <font style="color:#0287F8; font-size:16px;"><?php echo $post->title; ?></font> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                    <?php
                        if($users_loged_in_id == $post->users_id){
                    ?>
                    <span><a href = "javascript:void(0);" onclick = "return onclickPostDelete(<?php echo $post->id; ?>);" style = "color: #CCC;" title = "Delete">X</a></span>
                    <?php
                        }
                    ?>
                    <br>
                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;">.... <?php echo $post->created_at; ?></font><br>
                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $post->description; ?></font><br><br>
                </div>
                <?php
                if(!empty($post_contents[$post->id])){
                    foreach ($post_contents[$post->id] as $content) {
                        if ($content->elements_type == 2) {
                            ?>
                            <div class="col-sm-6" style = "padding-top: 26px;">
                                <img src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" alt="">
                                <?php
                                if($users_loged_in_id == $post->users_id){
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
                                <?php
                                if($users_loged_in_id == $post->users_id){
                                ?>
                                <span><a href = "javascript:void(0);" onclick = "return onclickPostContentDelete(<?php echo $content->id; ?>);" style = "color: #CCC;" title = "Delete">Delete</a></span>
                                <?php
                                }
                                ?>
                                <!--<iframe width="100%" height="315" src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" frameborder="0" allowfullscreen></iframe>-->
                            </div>
                            <?php
                        }
                    }
                }
                ?>
                <span id = "img_firework_<?php echo $post->id; ?>" style = "<?php if(!empty($firework[$post->id])){ echo 'display: none;'; } ?>"><img src = "<?php echo base_url(); ?>images/graphics-fireworks.gif"></span>
                <div class="profile_block_footer">
                    <p style="border-bottom:1px solid #CCC; padding-bottom:10px;">
                        
                        <a href="javascript:void(0);" id ="link_post_<?php echo $post->id; ?>" onclick = "return onClickLike('<?php echo $post->id; ?>');" <?php if($count_like[$post->id]){ echo "style = 'color:#E51323;'"; } ?> ><i class="glyphicon glyphicon-heart-empty"></i><span id = "post_like_<?php echo $post->id; ?>" ><?php if( $count_like[$post->id]>0 ){ echo $count_like[$post->id]." Wows"; }else{ echo " Wow"; } ?></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="#collapsexx" data-toggle="collapse" data-target="#collapsexx"><i class="fa fa-comments-o"></i> Comment</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0);" id ="fire_post_<?php echo $post->id; ?>" onclick = "return onClickFire('<?php echo $post->id; ?>');" ><span class = "firework_span"> &nbsp; &nbsp; &nbsp; &nbsp;</span> <span id = "count_firework_<?php echo $post->id; ?>"><?php if($count_fireworked[$post->id]>0){ echo $count_fireworked[$post->id]; } ?></span> Firework</a>
                        <!-- <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalfirework<?php echo $post->id; ?>">-By</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
                                    
<!--                                    <a href="#"><i class="fa fa-share-square-o"></i> Share</a>-->
                    </p>

                    <div id="collapsexx" class="panel-collapse collapse" style="margin-top:15px;">
                        <?php
                            if(!empty($comments[$post->id])){
                                foreach($comments[$post->id] as $comment){
                        ?>
                                    <div style="width:100%; float:left; margin-top:10px;">
                                        <div class="profile_block_header_thumb"><img height="100%" src="<?php echo base_url(); ?>images/users/<?php echo $comment->image; ?>" alt=""></div>
                                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><?php echo $comment->name; ?></font><br>
                                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;">Posted on : <?php echo $comment->post_at; ?></font><br>
                                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $comment->comments; ?></font><br>
                                    </div>

                        <?php
                                }
                            }
                        ?>
                        <div style="width:100%; float:left; margin-top:15px;">
                            <div class="input-group">     
                                <input type="text" class="form-control" id = "post_text" placeholder="Post your comment...">
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