<?php $this->load->view('users/include/header.php'); ?>	
<script type = "text/javascript">
    function onclickAjaxSearchTalent(){
        var country = $("#country").val();
        var city = $("#city").val();
        var category = $("#category").val();
        var search_content = $("#search_content").val();
        $.ajax({
            url: "<?php echo base_url('home/onclickAjaxSearchTalent'); ?>",
                type: "POST",
                data: {
                    country: country,
                    city: city,
                    category: category,
                    search_content: search_content,
                    <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                },
                success: function(data){
                    if( data == "no data" ){
                        $("#ajax_search_result").html("No data found");
                    }else{
                        $("#ajax_search_result").html(data);
                    }
                }
        });
        
    }
</script>
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-8" id = "ajax_search_result">
                
        <?php
            if(!empty($results)){
                ?>
                <div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        <font style="color:#333; font-size:16px;">
                            <?php 
                                if(!empty($get_category)){
                                    echo "Category: ".$get_category; 
                                }
                            ?>
                        </font>
                    </div>
                </div>
                <?php
                foreach( $results as $result ){
                    $user_id = ((( $result->users_id * 26 ) + 5364 ) - 769 );
            ?>
                    <div class="profile_page_back" style="padding:15px;">
                        <div class="profile_block_header">
                            <div class="profile_block_header_thumb"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $result->image; ?>" alt=""></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$user_id.'/'.urlencode($result->name)); ?>"><?php echo $result->name; ?></a></font><font style="color:#333; font-size:11px;"><?php if($result->profile_type == 1){ echo "(Here to show talent)"; }else if ($result->profile_type == 2){ echo "(Here to hire talent)"; } ?></font><br>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><?php echo $result->title; ?></font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;">
                                <?php
                                    echo $result->category_name; 
                                    if(!empty($result->country)){
                                        echo ','.$result->country;
                                    }
                                    if(!empty($result->city)){
                                        echo ','.$result->city;
                                    }
                                ?>
                            </font>
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
            </div>
            <!-- online friend-->
            <div class="col-sm-4">
                

                <div class="friend_list_main profile_page_back">
                    <p>Search By</p>
                    <div class="input-group" style="padding:15px;">
                        Category:
                        <select id="category" class="form-control">
                        <?php
                            foreach( $categories as $category ){
                                
                                    echo "<option value = '".$category->id."'>".$category->category_name."</option>";
                            }
                        ?>   
                        </select>
                        <?php
                            if(!empty($_GET['search'])){
                                $search_content = $_GET['search'];
                            }else{
                                $search_content = "";
                            }
                            if(!empty($_GET['country'])){
                                $search_country = $_GET['country'];
                            }else{
                                $search_country = "";
                            }
                        ?>
                        <input type = "hidden" name = "search_country" id = "country" value = "<?php echo $search_country; ?>">
                        <input type = "hidden" name = "search_content" id = "search_content" value = "<?php echo $search_content; ?>">
                    </div>
                    <div class="input-group" style="padding:15px;">      
                        <input type="text" class="form-control" id="city" placeholder="City" required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick = "return onclickAjaxSearchTalent();">Search</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('users/include/footer.php'); ?>