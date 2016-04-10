<?php
if (!empty($friend_list)) {
    foreach ($friend_list as $friends) {
        if ($users_loged_in_id == $friends->profile_id1) {
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
            <div class="profile_block_header_thumb"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $profile_image; ?>" alt=""></div>
            &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><a href = "<?php echo base_url('home/talentProfile/' . $profile_id.'/'.urlencode($profile_name)); ?>" ><?php echo $profile_name; ?></a></font><br>
        </div>
        <?php
    }
}
?>
                       