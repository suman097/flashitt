
        <?php
        if(!empty($results)){
            foreach( $results as $result ){
                $user_id = ((( $result->users_id * 26 ) + 5364 ) - 769 );
        ?>
                <div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        <div class="profile_block_header_thumb"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $result->image; ?>" alt=""></div>
                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$user_id.'/'.urlencode($result->name)); ?>"><?php echo $result->name; ?></a></font><font style="color:#333; font-size:11px;"><?php if($result->profile_type == 1){ echo "(Here to show talent)"; }else if ($result->profile_type == 2){ echo "(Here to hire talent)"; } ?></font><br>
                        &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><?php echo $result->title; ?></font><br>
                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $result->category_name; ?>, <?php echo $result->country; ?>, <?php echo $result->city; ?></font><br>
                    </div>
                </div>
                
        <?php
            }
        }else{
            ?>
                <div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        <font style="color:#333; font-size:16px;">No users found. To post your talent please click on Post a Talent on home page</font>
                    </div>
                </div>
            <?php
        }
        ?>
            