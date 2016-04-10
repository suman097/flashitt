<?php $this->load->view('users/include/header.php'); ?>	

<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div id ="contraner_albums">
                    <?php
                    if (!empty($notifications)) {
                        foreach ($notifications as $notification) {
                            ?>
                            <div class="profile_page_back" style="padding:15px;">
                                <div class="profile_block_header">
                                    <?php
                                    if ($notification->type == 1) {
                                        ?>
                                        <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/message/' . $notification->link_id); ?>" ><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $notification->image; ?>" alt=""></a></div>
                                        &nbsp;&nbsp; <font style="color:#333; font-size:14px; font-weight: bold;"><a href = "<?php echo base_url('home/message/' . $notification->link_id); ?>" ><?php echo $notification->notification; ?></a></font>
                                        <?php 
                                            if($notification->status == 1){
                                                echo " &nbsp; &nbsp; &nbsp; <span style = 'font-size: 10px; color: red;'>New</span>";
                                            }
                                        ?>
                                        <br>
                                        <?php
                                    }else if ($notification->type == 3) {
                                        $talent_profile_id = ((( $notification->friend_id *26 ) + 5364 ) - 769 );
                                        ?>
                                        <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/talentProfile/' . $talent_profile_id.'/'.urlencode($notification->name)); ?>" ><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $notification->image; ?>" alt=""></a></div>
                                        &nbsp;&nbsp; <font style="color:#333; font-size:14px; font-weight: bold;"><a href = "<?php echo base_url('home/postDetails/' . $notification->link_id); ?>" ><?php echo $notification->notification; ?></a></font>
                                        <?php 
                                            if($notification->status == 1){
                                                echo " &nbsp; &nbsp; &nbsp; <span style = 'font-size: 10px; color: red;'>New</span>";
                                            }
                                        ?>
                                        <br>
                                        <?php
                                    }else if ($notification->type == 4) {
                                        ?>
                                        <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/talentProfile/' . $notification->link_id.'/'.urlencode($notification->name)); ?>" ><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $notification->image; ?>" alt=""></a></div>
                                        &nbsp;&nbsp; <font style="color:#333; font-size:14px; font-weight: bold;"><a href = "<?php echo base_url('home/talentProfile/' . $notification->link_id.'/'.urlencode($notification->name)); ?>" ><?php echo $notification->notification; ?></a></font>
                                        <?php 
                                            if($notification->status == 1){
                                                echo " &nbsp; &nbsp; &nbsp; <span style = 'font-size: 10px; color: red;'>New</span>";
                                            }
                                        ?>
                                        <br>
                                        <?php
                                    }else{
                                        ?>
                                        <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/requirementDetails/' . $notification->link_id); ?>" ><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $notification->image; ?>" alt=""></a></div>
                                        &nbsp;&nbsp; <font style="color:#333; font-size:14px; font-weight: bold;"><a href = "<?php echo base_url('home/requirementDetails/' . $notification->link_id); ?>" ><?php echo $notification->notification; ?></a></font>
                                        <?php 
                                            if($notification->status == 1){
                                                echo " &nbsp; &nbsp; &nbsp; <span style = 'font-size: 10px; color: red;'>New</span>";
                                            }
                                        ?>
                                        <br>
                                        <?php
                                    }
                                    ?>
                                    <!-- &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $notification->text; ?></font><br> -->
                                    &nbsp;&nbsp; <font style="color:#999; font-size:12px;"> . . . . <?php echo date('d-m-Y', $notification->created_at); ?></font>

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
                                    <div class="profile_block_header_thumb"><img style="height:100%; width: 100%;" src="<?php echo base_url(); ?>images/users/<?php echo $friends->image; ?>" alt=""></div>
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