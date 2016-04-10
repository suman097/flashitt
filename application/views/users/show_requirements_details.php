<?php $this->load->view('users/include/header.php'); ?>	
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-8" id = "ajax_search_result">
                <div class="profile_page_back" style="padding:15px;">
                    <div class="profile_block_header">
                        <?php
                            if(!empty($requirement)){
                                $talent_profile_id = ((( $requirement->users_id * 26 ) + 5364 ) - 769 );
                                ?>
                                <div class="profile_block_header_thumb"><a href = "<?php echo base_url('home/talentProfile/'.$talent_profile_id.'/'.urlencode($requirement->name)); ?>"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $requirement->image; ?>" alt=""></a></div>
                                &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$talent_profile_id.'/'.urlencode($requirement->name)); ?>"><?php echo $requirement->name; ?></a></font>
                                <?php if($requirement->profile_type == 1){ echo "<font style='color:#333; font-size:11px;'>(Here to show talent)</font>"; }else if ($requirement->profile_type == 2){ echo "<font style='color:#333; font-size:11px;'>(Here to hire talent)</font>"; } ?>&nbsp;<br>
                                &nbsp;&nbsp; <font style="color:#333; font-size:16px;"><?php echo $requirement->title; ?></font> &nbsp;<br>
                                &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $requirement->coun; ?>, <?php echo $requirement->city; ?></font><br><br><br>
                                &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $requirement->description	; ?></font><br>
                                &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo date( 'd-m-Y', $requirement->created_at); ?></font><br>
                                <?php
                            }else{
                                echo "data not exist";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $this->load->view('users/include/footer.php'); ?>