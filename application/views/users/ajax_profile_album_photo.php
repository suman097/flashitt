
<div class="profile_page_back" style="padding:15px;">
    <?php
        if (!empty($post_data)) {
            foreach ($post_data as $key => $content) {
                ?>
                <div class="col-sm-12" style = "padding-top: 26px;"><img src="<?php echo base_url(); ?>images/talent/<?php echo $content; ?>" alt="">
                <br>Posted on : <?= $post_at[$key]; ?></div>
                <div class="profile_block_footer">
                    <p style="border-bottom:1px solid #CCC; padding-bottom:10px;">
                        <a href="javascript:void(0);" id ="link_post_<?php echo $post[$key]; ?>" onclick = "return onClickLike('<?php echo $post[$key]; ?>');" <?php if($count_like[$key]){ echo "style = 'color:#E51323;'"; } ?> ><i class="glyphicon glyphicon-heart-empty"></i>
                            <span id = "post_like_<?php echo $post[$key]; ?>" ><?php if( $count_like[$key]>0 ){ echo $count_like[$key]." Wows"; }else{ echo " Wow"; } ?></span>
                        </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </p>

                    <div id="collapsexx" class="panel-collapse collapse" style="margin-top:15px;">
                        <?php
                            if(!empty($comments[$key])){
                                foreach($comments[$key] as $comment){
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
                                    <button class="btn btn-default" type="button" onclick = "return onClickPostStatus(<?php echo $post[$key]; ?>);" >Post</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    ?>
</div>