<?php $this->load->view('users/include/header.php'); ?>	

<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
             		<?php
             				$friends_profile_id_jquery = ((( $friends_profile_id * 26 ) + 5364 ) - 769 );
             		?>
                <div class="profile_page_back" style="padding:15px;">
                    <form action = "<?php echo base_url('home/submitYourMassage'); ?>" method = "post" enctype = "multipart/form-data">
                        <div class="profile_block_header"></div>
                        <input type="hidden" id="friend_profile_id" name = "friend_profile_id" value="<?php echo $friends_profile_id_jquery; ?>">
                        <div class="profile_block_body"><textarea style = "width: 100%; height: 85px;" name = "massage" placeholder="Write message"></textarea></div>
                        <div class="profile_block_footer">
                            <input type = "submit" class="btn btn-default" style = "float: right;" value = " Reply ">
                        </div>
                    </form>
                </div>
                <div id ="contraner_albums">
                    <?php
                    if (!empty($messages)) {
                        foreach ($messages as $message) {
                        		$talent_friends_profile_id = ((( $message->user_id * 26 ) + 5364 ) - 769 );
                            ?>
                            <div class="profile_page_back" style="padding:15px;">
                                <div class="profile_block_header">
                                    <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/talentProfile').'/'.$talent_friends_profile_id.'/'.urlencode($message->name); ?>"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $message->image; ?>" alt=""></a></div>
                                    &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><a href = "<?php echo base_url('home/talentProfile').'/'.$talent_friends_profile_id.'/'.urlencode($message->name); ?>"><?php echo $message->name; ?></a></font><br>
                                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $message->text; ?></font><br>
                                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;"> . . . . <?php echo date( 'd-m-Y', $message->created_at); ?></font>

                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <!-- online friend-->
            <div class="col-sm-4">
                <div class="friend_list_main">
                    <p>Inbox Message</p>
                    <div class="friend_block_y">
                        <?php
                        if (!empty($friend_list)) {
                            foreach ($friend_list as $friends) {
                            		?>
                                <div class="particular">
                                    <div class="profile_block_header_thumb"><img height="100%" src="<?php echo base_url(); ?>images/users/<?php echo $friends->image; ?>" alt=""></div>
                                    &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><a href = "<?php echo base_url('home/message/' . $friends->id); ?>" ><?php echo $friends->name; ?></a></font><br>
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