	<?php
		if(!empty($search_results)){
			foreach( $search_results as $profile ){
				$user_id = ((( $profile->id * 26 ) + 5364 ) - 769 );
				?>
				<div class="profile_page_back" style="padding:15px;">
					<div class="profile_block_header">
						<div class="profile_block_header_thumb"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $profile->image; ?>" alt=""></div>
						&nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$user_id.'/'.urlencode($profile->name)); ?>"><?php echo $profile->name; ?></a></font>
                                                <font style="color:#333; font-size:11px;"><?php if($profile->profile_type == 1){ echo "(Here to show talent)"; }else if ($profile->profile_type == 2){ echo "(Here to hire talent)"; } ?></font>
                                                <br>
						&nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $profile->country_name; ?></font><br>
						</div>
					</div>
				<?php
			}
		}else if(!empty($search_category_results)){
			foreach( $search_category_results as $profile ){
				$user_id = ((( $profile->id * 26 ) + 5364 ) - 769 );
				?>
				<div class="profile_page_back" style="padding:15px;">
					<div class="profile_block_header">
						<div class="profile_block_header_thumb"><img height="100%" width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $profile->image; ?>" alt=""></div>
						&nbsp;&nbsp; <font style="color:#333; font-size:16px;"><a href = "<?php echo base_url('home/talentProfile/'.$user_id.'/'.urlencode($profile->name)); ?>"><?php echo $profile->name; ?></a></font>
                                                <font style="color:#333; font-size:11px;"><?php if($profile->profile_type == 1){ echo "(Here to show talent)"; }else if ($profile->profile_type == 2){ echo "(Here to hire talent)"; } ?></font>
                                                <br>
						&nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $profile->country_name; ?></font><br>
					</div>
				</div>
				<?php
			}
		}else{
			?>
			<div class="profile_page_back" style="padding:15px;">
					<div class="profile_block_header">
					&nbsp;&nbsp; <font style="color:#333; font-size:16px;">No users found. To post your talent please click on Post a Talent on home page</font><br>
					</div>
			</div>
			<?php
		}
	?>