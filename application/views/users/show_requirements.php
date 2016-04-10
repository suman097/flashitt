<?php $this->load->view('users/include/header.php'); ?>
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-8" id = "ajax_search_result">
                
        <?php
            if(!empty($requirements)){
                foreach( $requirements as $result ){
                    $talent_profile_id = ((( $result->users_profile_id * 26 ) + 5364 ) - 769 );
                    ?>
                    <div class="profile_page_back" style="padding:15px;">
                        <div class="profile_block_header">
                            <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/talentProfile/'.$talent_profile_id.'/'.urlencode($result->name)); ?>"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $result->image; ?>" alt=""></a></div>
                            &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$talent_profile_id.'/'.urlencode($result->name)); ?>"><?php echo $result->name; ?></a></font>
                            <?php if($result->profile_type == 1){ echo "<font style='color:#333; font-size:11px;'>(Here to show talent)</font>"; }else if ($result->profile_type == 2){ echo "<font style='color:#333; font-size:11px;'>(Here to hire talent)</font>"; } ?>&nbsp;<br>
                            &nbsp;&nbsp; <font style="color:#333; font-size:14px;"><a href = "<?php echo base_url('home/requirementDetails/'.$result->id); ?>"><?php echo $result->title; ?></a></font> &nbsp;<br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $result->category_name; ?>,<?php echo $result->coun; ?>, <?php echo $result->city; ?></font><br>
                            &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo date( 'd-m-Y', $result->created_at); ?></font><br>
                        </div>
                    </div>

                    <?php
                }
            }
        ?>
            </div>
            <!-- online friend-->
            <div class="col-sm-4">
                

<!--                <div class="friend_list_main profile_page_back">
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
                        <input type = "hidden" name = "search_country" id = "country" value = "<?php echo $search_country; ?>">
                    </div>
                    <div class="input-group" style="padding:15px;">      
                        <input type="text" class="form-control" id="city" placeholder="City" required>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" onclick = "return onclickAjaxSearchTalent();">Search</button>
                        </span>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('users/include/footer.php'); ?>