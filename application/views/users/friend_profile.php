<?php $this->load->view('users/include/header.php'); ?>	

<script type = "text/javascript">
    function onclickSuggestFriend() {
        var email = $("#suggest_email").val();
        var category = $("#suggest_category").val();
        var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        var emailvalid = emailReg.test(email);
        if (emailvalid) {
            $.ajax({
                url: "<?php echo base_url('home/ajaxSuggestFriend'); ?>",
                type: "POST",
                data: {
                    category: category,
                    email: email,
                    <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                },
                success: function (data) {
                    alert("Thank you for your suggestion");
            //                        bootbox.dialog({
            //                            message: '<div class="row" style=" color:#666; font-size:18px; text-align:center;"> ' +
            //                                    'Thank you for your suggestion' +
            //                                    '</div>',
            //                        });
                }
            });
        } else {
            alert("Please enter a valid email");
    //            bootbox.dialog({
    //                message: '<div class="row" style=" color:#666; font-size:18px; text-align:center;"> ' +
    //                        'Please enter a valid email' +
    //                        '</div>',
    //            });
        }
    }

    function onclickPhotoShow(id) {
        $.ajax({
            url: "<?php echo base_url('home/ajaxPhotoShowFriend'); ?>",
            type: "POST",
            data: {
                id: id,
                <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                $("#contraner_albums").html(data);
                $("#load_more_span").css("display","none");
            }
        });
        return false;
    }

    function onclickVideoShow(id) {
        $.ajax({
            url: "<?php echo base_url('home/ajaxVideoShowFriend'); ?>",
            type: "POST",
            data: {
                id: id,
                <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                $("#contraner_albums").html(data);
                $("#load_more_span").css("display","none");
            }
        });
        return false;
    }

    function onclickAllShow(id) {
        $.ajax({
            url: "<?php echo base_url('home/ajaxAllShowFriend'); ?>",
            type: "POST",
            data: {
                id: id,
                <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                $("#contraner_albums").html(data);
                $("#limit_value_of_page").val(1);
                $("#load_more_span").css("display","block");
            }
        });
        return false;
    }
    
    function onclickPageLimitLoadMore(id) {
        $("#load_more_span").css("display","none");
        $("#limit_page_loading").css("display","block");
        var page = $("#limit_value_of_page").val();
        $.ajax({
            url: "<?php echo base_url('home/ajaxAllShowLimitFriend'); ?>",
            type: "POST",
            data: {
                page: page,
                id: id,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                if(data != ""){
                    $("#contraner_albums").append(data);
                    var naxt_page = parseInt(page) + 1;
                    $("#limit_value_of_page").val(naxt_page);
                    $("#load_more_span").css("display","block");
                    $("#limit_page_loading").css("display","none");
                }else{
                    $("#limit_page_loading").css("display","none");
                }
            }
        });
        
        return false;
    }

    function onClickLike(post) {
        $.ajax({
            url: "<?php echo base_url('home/ajaxLikePost'); ?>",
            type: "POST",
            data: {
                post: post,
                <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                if ( data == "not loged in" ){
                    alert("Please login");
                } else if ( data == "not done" ){
                    alert("You already wowed it");
                } else{
                    $("#post_like_"+post).html( data+" Wows");
                    $("#link_post_"+post).css( 'color', '#E51323' );
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
                    alert("Please login");
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

    function onClickPostStatus( post_id ) {
        var post = $("#post_text_"+post_id).val();
        var friends_id = $("#friend_profile_id").val();
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
    
    function onKeyUpFriendSearch( search ) {
        var search_friend_id = $("#search_friend_id").val();
        $.ajax({
            url: "<?php echo base_url('home/ajaxSearchFriends'); ?>",
            type: "POST",
            data: {
                search: search,
                user_id: search_friend_id,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                if( data ){
                    //alert(data);
                    $("#friend_list").html(data);
                }
            }
        });
    }
</script>
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="profile_page_back" style="padding:5px;">
                    <form action = "<?php echo base_url('home/profileSearch'); ?>" method = "get">
                        <div class="input-group">       
                            <input type="text" class="form-control" name="search" placeholder="Search friend and send request....">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> &nbsp; Search</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="profile_page_back">
                    <div style="width:100%; float:left; background:url(<?php echo base_url(); ?>images/users/<?php echo $friends->banner; ?>) #333 no-repeat center; background-size:cover; padding:180px 15px 15px 15px;">
                        <div class="profile_admin">
                            <?php
                            if (empty($friends->image)) {
                                ?>
                                <img style="height:100%; width: 100%;" src="<?php echo base_url(); ?>assets/frontend/images/profile.jpg" alt="">
                                <?php
                            } else {
                                ?>
                                <img style="height:100%; width: 100%;" src="<?php echo base_url(); ?>images/users/<?php echo $friends->image; ?>" alt="">
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                            $coma = 0;
                            if(!empty($friends->city)){
                                $coma++;
                            }
                            if(!empty($friends->country_name)){
                                $coma++;
                            }
                        ?>
                        <br><br><br><p class = "profile-name"><?php echo $friends->name; ?>
                        
                        <br>
                        <?php
                            echo $friends->city;
                            if($coma == 2){
                                echo ", ";
                            }
                            echo $friends->country_name;
                        ?>
                        </p>
                    </div>
                </div>
                <div>
                    <div class="homepage_postsection">
                        <?php
                            if($friends->profile_type == 1){
                                echo "<b style = 'color: #02A6F8; ' >I am here to show talent</b>";
                            }else if ($friends->profile_type == 2){
                                echo "<b style = 'color: #02A6F8; ' >I am here to hire talent</b>";
                            }
                            if(!empty($friends->category)){
                                $profile_category = explode( ",", $friends->category);
                                foreach($profile_category as $p_category){
                                    echo '<a href="" class="btn btn-default" style = "margin-left: 5px; border: none;">'.$p_category.'</a>';
                                }
                            }
                        ?>
                        <br>
                        <b>This is me : </b>
                        <?php echo $friends->about_me; ?>
                    </div>
                </div>
                <?php
                if (!empty($friends_status)) {
                    if ($friends_status->status == 0) {
                        $request_action = "Friend Request Sent";
                        $action_target = "not set";
                    } else if ($friends_status->status == 1) {
                        $request_action = "Friend";
                        $action_target = "not set";
                    } else if ($friends_status->status == 2) {
                        $request_action = "Rejected";
                        $action_target = "not set";
                    }
                } else {
                    $request_action = "Add Friend";
                    $action_target = ((( $friends_profile_id * 26 ) + 5364 ) - 769 );
                }
                ?>
                   
                <div>
                    <?php
                        if(!empty($users_name)){
                    ?>
                            <div class="homepage_postsection">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalReport" class="btn btn-default pull-right" style = "margin-left: 5px; background-color: #E51323; border: none;">Report this user</a>
                                <?php
                                if ($action_target != "not set") {
                                    ?>
                                    <a href="<?php echo base_url(); ?>home/friendsAction/<?php echo $action_target; ?>" class="btn btn-default pull-right"  style = "background-color: #E51323; border: none;" ><?php echo $request_action; ?></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href="" class="btn btn-default pull-right"  style = " background-color: #E51323; border: none;"><?php echo $request_action; ?></a>
                                    <?php
                                }
                                ?>
                            </div>
                    <?php
                        }
                    ?>
                </div>
                <?php
		            	$friends_profile_id_jquery = ((( $friends_profile_id * 26 ) + 5364 ) - 769 );
		            ?>
             
                <div class="profile_page_back" style="padding:5px;">
                    <form action = "<?php echo base_url('home/submitYourMassage'); ?>" method = "post" enctype = "multipart/form-data">
                        <div class="profile_block_header"></div>
                        <input type="hidden" id="friend_profile_id" name = "friend_profile_id" value="<?php echo $friends_profile_id_jquery; ?>">
                        <div class="profile_block_body"><textarea style = "width: 100%; height: 85px;" name = "massage" placeholder="Send message to user"></textarea></div>
                        <div class="profile_block_footer">
                            <?php
                                if(!empty($users_name)){
                            ?>
                                    <input type = "submit" class="btn btn-default" style = "float: right;" value = " Send ">
                            <?php
                                }else{
                            ?>
                                    <input type = "button" class="btn btn-default" style = "float: right;" value = " Send " onclick="alert('Please login');">
                            <?php
                                }
                            ?>
                        </div>
                    </form>
                </div>
                <div class="homepage_postsection col-sm-12" style = "padding-left: 0px; padding-right: 0px;">
                    <div class="col-sm-4 btn btn-default pull-right" onclick = "return onclickVideoShow(<?php echo $friends_profile_id; ?>);">
                        View My Videos
                    </div>
                    <div class="col-sm-4 btn btn-default pull-right" onclick = "return onclickPhotoShow(<?php echo $friends_profile_id; ?>);">
                        View My pictures
                    </div>
                    <div class="col-sm-4 btn btn-default pull-right" onclick = "return onclickAllShow(<?php echo $friends_profile_id; ?>);">
                        View All
                    </div>
                </div>
                <div id ="contraner_albums">
                    <?php
                    if (!empty($posts)) {
                        foreach ($posts as $post) {
                            ?>
                            <div class="profile_page_back" style="padding:5px;">
                                <div class="profile_block_header">
                                    <div class="profile_block_header_thumb">
                                    	<img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $post->image; ?>" alt="">
                                    </div>
                                    <?php $talent_profile_id = ((( $post->users_id * 26 ) + 5364 ) - 769 ); ?>
                                    &nbsp;&nbsp; <a href = "<?php echo base_url('home/talentProfile/'.$talent_profile_id.'/'.urlencode($post->name)); ?>"><font style="color:#333; font-size:16px; font-weight: bold;"><?php echo $post->name; ?></font></a><br>
                                    &nbsp;&nbsp; <font style="color:#0287F8; font-size:14px; word-wrap: break-word;"><?php echo $post->title; ?></font><br>
                                    &nbsp;&nbsp; <font style="color:#999; font-size:12px; word-wrap: break-word;"><?php echo $post->description; ?></font>
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
                                            <div>
                                            	<img src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" alt="">
                                            </div>
                                            <?php
                                        } else if ($content->elements_type == 3) {
                                            ?>
                                            <div class="profile_block_body"><iframe width="100%" height="315" src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" frameborder="0" allowfullscreen></iframe></div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <span id = "img_firework_<?php echo $post->id; ?>" style = "<?php if(!empty($firework[$post->id])){ echo 'display: none;'; } ?>"><img src = "<?php echo base_url(); ?>images/graphics-fireworks.gif"></span>
                                <div class="profile_block_footer">
                                    <p style="border-bottom:1px solid #CCC;">
                                        <a href="javascript:void(0);" id ="link_post_<?php echo $post->id; ?>" onclick = "return onClickLike('<?php echo $post->id; ?>');" <?php if($count_like[$post->id]>0){ echo "style = 'color:#E51323;'"; } ?> >
                                            <i class="glyphicon glyphicon-heart-empty"></i>
                                            <span id = "post_like_<?php echo $post->id; ?>" ><?php if( $count_like[$post->id]>0 ){ echo $count_like[$post->id]." Wows"; }else{ echo " Wow"; } ?></span></a>&nbsp;&nbsp;
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalLike<?php echo $post->id; ?>"><i class="glyphicon glyphicon-heart-empty"></i>-By</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="#collaps_comment_<?php echo $post->id; ?>" data-toggle="collapse" data-target="#collaps_comment_<?php echo $post->id; ?>"><i class="fa fa-comments-o"></i> <?php if ($count_comments[$post->id] > 0) { echo $count_comments[$post->id]; } ?> Comment</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <a href="javascript:void(0);" id ="fire_post_<?php echo $post->id; ?>" onclick = "return onClickFire('<?php echo $post->id; ?>');" ><span class = "firework_span"> &nbsp; &nbsp; &nbsp; &nbsp;</span> <span id = "count_firework_<?php echo $post->id; ?>"><?php if($count_fireworked[$post->id]>0){ echo $count_fireworked[$post->id]; } ?></span> Firework</a>
                                        <a href="javascript:void(0);" data-toggle="modal" data-target="#myModalfirework<?php echo $post->id; ?>"><span class = "firework_span"> &nbsp; &nbsp; &nbsp; &nbsp;</span>-By</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    
                                        <!-- <a href="#"><i class="fa fa-share-square-o"></i> Share</a>-->
                                    </p>
                                    <!-- report model -->
                                    <div id="myModalReport" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <h4 class="modal-title">Why do you want to report this user</h4>
                                                </div>
                                                <form action = "<?php echo base_url('home/submitReport'); ?>" method = "post">
                                                    <div class="modal-body">
                                                        <input type = "hidden" value = "<?php echo $friends_profile_id; ?>" name = "reported_id" >
                                                        <textarea name = "report_content" id = "report_content" style = "width: 100%; height: 200px;" placeholder = "write here"></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-default" name="modal">Send</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- report model -->

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
                                                        if(!empty($liked[$post->id])){
                                                            foreach($liked[$post->id] as $like){
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
                                                    if(!empty($fireworked[$post->id])){
                                                        foreach($fireworked[$post->id] as $work){
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
                                
                                    <div id="collaps_comment_<?php echo $post->id; ?>" class="panel-collapse collapse" style="margin-top:15px;">
                                        <div id = "total_comment_<?php echo $post->id; ?>">
                                        <?php
                                        if (!empty($comments[$post->id])) {
                                            foreach ($comments[$post->id] as $comment) {
                                                //print_r($comment);
                                                $comment_profile_id = ((( $comment->user_id * 26 ) + 5364 ) - 769 );
                                                ?>
                                                <div style="width:100%; float:left; margin-top:10px;">
                                                    <div class="profile_block_header_thumb"  style = "height: 44px; width: 44px;"><a href = "<?php echo base_url('home/talentProfile/'.$comment_profile_id.'/'.urlencode($comment->name)); ?>"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $comment->image; ?>" alt=""></a></div>
                                                    &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$comment_profile_id.'/'.urlencode($comment->name)); ?>"><?php echo $comment->name; ?></a></font><br>
                                                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $comment->comments; ?></font><br>
                                                    <?php
                                                        $comment_date_explode = explode(" ", $comment->post_at);
                                                    ?>
                                                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;"> . . . . <?php echo $comment_date_explode[0]; ?></font><br>
                                                </div>

                                                <?php
                                            }
                                        }
                                        ?>
                                        </div>
                                        <div style="width:100%; float:left; margin-top:15px;">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="post_text_<?php echo $post->id; ?>" placeholder="Post your comment...">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button" onclick = "return onClickPostStatus(<?php echo $post->id; ?>);">Post</button>
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
                </div>
                <div class="profile_page_back" style="padding:5px; text-align: center; ">
                    <input type = "hidden" value = "1" id = "limit_value_of_page">
                    <span id = "load_more_span" onclick="return onclickPageLimitLoadMore(<?php echo $friends_profile_id; ?>);" style = "cursor: pointer; display: block; " >Load more</span>
                    <span id = "limit_page_loading" style = "display:none;" ><img src="<?php echo base_url(); ?>images/29.gif" alt=""></span>
                </div>
            </div>
            

            <!-- online friend-->
            <div class="col-sm-4">
                <div class="friend_list_main">
                    <p>All Friends</p>
                    <div class="friend_block_y">
                        <input type="text" class="form-control" id="search_friend" placeholder="Search friend.." onkeyup = "return onKeyUpFriendSearch(this.value);">
                        <input type="hidden" class="form-control" id="search_friend_id" value = "<?php echo $friends_profile_id_jquery; ?>">
                        <div id = "friend_list">
                            <?php
                            if (!empty($friend_list)) {
                                foreach ($friend_list as $friends) {
                                    if ($friends_profile_id == $friends->profile_id1) {
                                        $profile_id = $friends->profile_id2;
                                        $profile_name = $friends->profile_name2;
                                        $profile_image = $friends->profile_image2;
                                    } else {
                                        $profile_id = $friends->profile_id1;
                                        $profile_name = $friends->profile_name1;
                                        $profile_image = $friends->profile_image1;
                                    }
                                    $profile_id = ((( $profile_id * 26 ) + 5364 ) - 769 );
                                    ?>
                                    <div class="particular">
                                        <div class="profile_block_header_thumb"><img style="height:100%; width: 100%;" src="<?php echo base_url(); ?>images/users/<?php echo $profile_image; ?>" alt=""></div>
                                        &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><a href = "<?php echo base_url('home/talentProfile/' . $profile_id.'/'.urlencode($profile_name)); ?>" ><?php echo $profile_name; ?></a></font><br>
                                        <!--                                &nbsp;&nbsp; <font style="color:#999; font-size:12px;">100 Followers</font>-->
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="friend_list_main profile_page_back">
                    <p>Suggest a Friend</p>
                    <div class="input-group" style="padding:15px;">
                        Category:
                        <select id="suggest_category" class="form-control">
                            <?php
                            foreach ($categories as $category) {
                                echo "<option value = '" . $category->id . "'>" . $category->category_name . "</option>";
                            }
                            ?>   
                        </select>
                    </div>
                    <div class="input-group" style="padding:15px;">      
                        <input type="email" class="form-control" id="suggest_email" placeholder="Enter mail ID...." required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick = "return onclickSuggestFriend();">Suggest</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('users/include/footer.php'); ?>