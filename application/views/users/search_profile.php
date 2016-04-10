<?php $this->load->view('users/include/header.php'); ?>	
<script src="<?php echo base_url(); ?>assets/frontend/js/developer.js"></script>
<script type = "text/javascript">
    function onclickSuggestFriend(){
        var email = $("#suggest_email").val();
        var category = $("#suggest_category").val();
        var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
        var emailvalid = emailReg.test(email);
        if(emailvalid){
            $.ajax({
                url: "<?php echo base_url('home/ajaxSuggestFriend'); ?>",
                    type: "POST",
                    data: {
                        category: category,
                        email: email,
                        <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                    },
                    success: function(data){
                        alert("Thank you for your suggestion");
//                        bootbox.dialog({
//                            message: '<div class="row" style=" color:#666; font-size:18px; text-align:center;"> ' +
//                                    'Thank you for your suggestion' +
//                                    '</div>',
//                        });
                    }
            });
        }else{
            alert("Please enter a valid email");
//            bootbox.dialog({
//                message: '<div class="row" style=" color:#666; font-size:18px; text-align:center;"> ' +
//                        'Please enter a valid email' +
//                        '</div>',
//            });
        }
    }
    
    function onclickSearchFriend(){
        var search_city = $("#search_city").val();
        var search_content = $("#search_content").val();
        $.ajax({
            url: "<?php echo base_url('home/ajaxSearchFriend'); ?>",
                type: "POST",
                data: {
                    search_city: search_city,
                    search_content: search_content,
                    <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                },
                success: function(data){
                    $("#profile_search_data").html(data);
                }
        });
    }
</script>
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="profile_page_back" style="padding:15px;">
                    <form action = "<?php echo base_url('home/profileSearch'); ?>" method = "get">
                        <div class="input-group">       
                            <input type="text" class="form-control" name="search" placeholder="Search friend and send request....">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> &nbsp; Search</button>
                            </span>
                        </div>
                    </form>
                </div>
              <div id = "profile_search_data">
            <?php
                $result_count = 0;
            	if(!empty($search_results)){
                foreach( $search_results as $profile ){
                    $result_count++;
                    $user_id = ((( $profile->id * 26 ) + 5364 ) - 769 );
            ?>
                <div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        <div class="profile_block_header_thumb"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $profile->image; ?>" alt=""></div>
                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$user_id.'/'.urlencode($profile->name)); ?>"><?php echo $profile->name; ?></a></font><font style="color:#333; font-size:11px;"><?php if($profile->profile_type == 1){ echo "(Here to show talent)"; }else if ($profile->profile_type == 2){ echo "(Here to hire talent)"; } ?></font><br>
                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $profile->country_name; ?></font><br>
                    </div>
                </div>
            <?php
                }
              }
              if(!empty($search_category_results)){
                foreach( $search_category_results as $profile ){
                    $result_count++;
                    $user_id = ((( $profile->id * 26 ) + 5364 ) - 769 );
            ?>
                <div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        <div class="profile_block_header_thumb"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $profile->image; ?>" alt=""></div>
                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$user_id.'/'.urlencode($profile->name)); ?>"><?php echo $profile->name; ?></a></font><br>
                        &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $profile->country_name; ?></font><br>
                    </div>
                </div>
            <?php
                }
              }
              if( $result_count == 0 ){
            ?>
              	<div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        &nbsp;&nbsp; <font style="color:#333; font-size:16px;">No users found. To post your talent please click on Post a Talent on home page</font><br>
                    </div>
                </div>
            <?php
              }
            ?>
            </div>
            </div>


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

                <div class="friend_list_main profile_page_back">
                    <p>Search your Friend</p>
                    <div class="input-group" style="padding:15px;">      
                        <input type="text" class="form-control" id="search_city" placeholder="City.." >
                        <input type="hidden" class="form-control" id="search_content" value = "<?= $search; ?>" >
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick = "return onclickSearchFriend();">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('users/include/footer.php'); ?>