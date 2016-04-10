<?php
	if(!empty($comments)){
	  foreach($comments as $comment){
              $comment_profile_id = ((( $comment->user_id * 26 ) + 5364 ) - 769 );
	?>
	      <div style="width:100%; float:left; margin-top:10px;">
                  <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/talentProfile/'.$comment_profile_id.'/'.urlencode($comment->name)); ?>"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $comment->image; ?>" alt=""></a></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$comment_profile_id.'/'.urlencode($comment->name)); ?>"><?php echo $comment->name; ?></a></font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $comment->comments; ?></font><br>
                            <?php
                                $comment_date_explode = explode(" ", $comment->post_at);
                            ?>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">.. <?php echo $comment_date_explode[0]; ?></font><br>
	          
	      </div>
	  
	<?php
	  }
	}
?>