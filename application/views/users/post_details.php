<?php $this->load->view('users/include/header.php'); ?>
<script type="text/javascript">
    function onClickLike( post ) {
        $.ajax({
            url: "<?php echo base_url('home/ajaxLikePost'); ?>",
            type: "POST",
            data: {
                post: post,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                if ( data == "not loged in" ){
                    alert("Please log in before like");
                } else if ( data == "not done" ){
                    alert("You already liked it");
                } else{
                    $("#post_like_"+post).html( data+" Wowed");
                    $("#link_post_"+post).css( 'color', '#E51323' );
                }
            }
        });
    }
    
    function onClickPostStatus( post_id ) {
        var post = $("#post_text_"+post_id).val();
        $.ajax({
            url: "<?php echo base_url('home/ajaxPostComment'); ?>",
            type: "POST",
            data: {
                post_id: post_id,
                post: post,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                if( data == "not loged in" ){
                    alert('Please login');
                }else{
                    $("#total_comment_"+post_id).html( data );
                    $("#post_text_"+post_id).val("");
                }
            }
        });
    }
    
    function onClickFire( post ) {
        $.ajax({
            url: "<?php echo base_url('home/ajaxFirePost'); ?>",
            type: "POST",
            data: {
                post: post,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                if ( data == "not loged in" ){
                    alert("Please log in before like");
                } else if ( data == "not done" ){
                    alert("You already Fireworked it");
                } else{
                    alert("Done");
                    $("#img_firework_"+post).css( 'display', 'block' );
                    $("#count_firework_"+post).html(data);
                }
            }
        });
    }
</script>
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <?php
                if(!empty($post)){
                    ?>
                    <div class="col-sm-8">
                        <div id ="contraner_albums">
                            <div class="profile_page_back" style="padding:15px;">
                                <div class="profile_block_header">
                                    <?php
                                        $talent_profile_id = ((( $post->users_id * 26 ) + 5364 ) - 769 );
                                    ?>
                                    <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/talentProfile/'.$talent_profile_id.'/'.urlencode($post->name)); ?>"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $post->image; ?>" alt=""></a></div>
                                    &nbsp;&nbsp; <font style="color:#333; font-size:16px; font-weight: bold;"><a href = "<?php echo base_url('home/talentProfile/'.$talent_profile_id.'/'.urlencode($post->name)); ?>"><?php echo $post->name; ?></a></font>
                                    <?php if($post->profile_type == 1){ echo "<font style='color:#333; font-size:11px;'>(Here to show talent)</font>"; }else if ($post->profile_type == 2){ echo "<font style='color:#333; font-size:11px;'>(Here to hire talent)</font>"; } ?><br>
                                    &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><?php echo $post->title; ?></font><br>
                                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $post->description; ?></font><br><br>
                                    <?php
                                        $post_date_explode = explode(" ", $post->created_at);
                                    ?>
                                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;"> . . . . <?php echo $post_date_explode[0]; ?></font><br>
                                </div>
                                <?php
                                if(!empty($post_contents)){
                                    foreach ($post_contents as $content) {
                                        if ($content->elements_type == 2) {
                                            ?>
                                            <div class="col-sm-6" style = "padding-top: 26px;"><img src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" alt=""></div>
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
                                <span id = "img_firework_<?php echo $post->id; ?>" style = "<?php if(!empty($firework)){ echo 'display: none;'; } ?>"><img src = "<?php echo base_url(); ?>images/graphics-fireworks.gif"></span>
                                <div class="profile_block_footer">
                                    <p style="border-bottom:1px solid #CCC; padding-bottom:10px;">
                                        <a href="javascript:void(0);" id ="link_post_<?php echo $post->id; ?>" onclick = "return onClickLike('<?php echo $post->id; ?>');" <?php if($count_like>0){ echo "style = 'color:#E51323;'"; } ?> ><i class="glyphicon glyphicon-heart-empty"></i><span id = "post_like_<?php echo $post->id; ?>" ><?php if( $count_like>0 ){ echo $count_like." Wowed"; }else{ echo " Wow"; } ?></span></a> &nbsp; &nbsp; 
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLike"><i class="glyphicon glyphicon-heart-empty"></i>-BY</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="#collaps_comment_<?php echo $post->id; ?>" data-toggle="collapse" data-target="#collaps_comment_<?php echo $post->id; ?>"><i class="fa fa-comments-o"></i> <?php if ($count_comments > 0) { echo $count_comments; } ?> Comment</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0);" id ="fire_post_<?php echo $post->id; ?>" onclick = "return onClickFire('<?php echo $post->id; ?>');" ><span class = "firework_span"> &nbsp; &nbsp; &nbsp; &nbsp;</span> <span id = "count_firework_<?php echo $post->id; ?>"><?php if($count_fireworked>0){ echo $count_fireworked; } ?></span> Firework</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalfirework<?php echo $post->id; ?>"><span class = "firework_span"> &nbsp; &nbsp; &nbsp; &nbsp;</span>-By</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <!-- <a href="#"><i class="fa fa-share-square-o"></i> Share</a>-->
                                    </p>

                                    <div id="collaps_comment_<?php echo $post->id; ?>" class="panel-collapse " style="margin-top:15px;">
                                            <div id = "total_comment_<?php echo $post->id; ?>">
                                <?php
                                    if(!empty($comments)){
                                        foreach($comments as $comment){
                                            $comment_profile_id = ((( $comment->user_id * 26 ) + 5364 ) - 769 );
                                ?>
                                            <div style="width:100%; float:left; margin-top:8px; margin-left:10px;">
                                                <div class="profile_block_header_thumb" style = "height: 44px; width: 44px;"><a href = "<?php echo base_url('home/talentProfile/'.$comment_profile_id.'/'.urlencode($comment->name)); ?>"><img height="100%"  width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $comment->image; ?>" alt=""></a></div>
                                                        &nbsp;&nbsp; <font style="color:#333; font-size:12px;"><a href = "<?php echo base_url('home/talentProfile/'.$comment_profile_id.'/'.urlencode($comment->name)); ?>"><?php echo $comment->name; ?></a></font><br>
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

                                        <div style="width:100%; float:left; margin-top:15px;">
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
                        </div>
                    </div>
            
            
                    <div id="myModalLike" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">People Who Wowed This</h4>
                                </div>
                                <div class="modal-body">
                                    <?php
                                        if(!empty($liked)){
                                            foreach($liked as $like){
                                                echo "<p>".$like->name."</p>";
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
                                        if(!empty($fireworked)){
                                            foreach($fireworked as $work){
                                                echo "<p>".$work->name."</p>";
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
                    <?php
                }else{
                    ?>
                    <div class="col-sm-8">
                        <div id ="contraner_albums">
                            <div class="profile_page_back" style="padding:15px;">
                                <div class="profile_block_header">The post does not exist</div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            ?>

            <!-- online friend-->
            <div class="col-sm-4">
                <div class="friend_list_main">
                    <p>All Friends</p>
                    <div class="friend_block_y">
                    <?php
                        if(!empty($friend_list)){
                            foreach($friend_list as $friends){
                                if( $users_loged_in_id == $friends->profile_id1 ){
                                    $profile_id = $friends->profile_id2;
                                    $profile_name = $friends->profile_name2;
                                    $profile_image = $friends->profile_image2;
                                }else{
                                    $profile_id = $friends->profile_id1;
                                    $profile_name = $friends->profile_name1;
                                    $profile_image = $friends->profile_image1;
                                }
                                $profile_id = ((( $profile_id * 26 ) + 5364 ) - 769 );
                    ?>
                                <div class="particular">
                                    <div class="profile_block_header_thumb"><img style="height:100%; width: 100%;" src="<?php echo base_url(); ?>images/users/<?php echo $profile_image; ?>" alt=""></div>
                                    &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><a href = "<?php echo base_url('home/talentProfile/'.$profile_id.'/'.urlencode($profile_name)); ?>" ><?php echo $profile_name; ?></a></font><br>
<!--                                &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>-->
                                </div>
                    <?php
                            }
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('users/include/footer.php'); ?>