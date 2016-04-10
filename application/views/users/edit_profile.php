<?php $this->load->view('users/include/header.php'); ?>	

<!--inner page content-->    
<!--inner page content-->    
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <!-- post talent-->
            <div class="col-sm-8">
                <div class="friend_list_main">
                    <p>Edit Your Profile</p>
                    <div class="post_talent_in">
                        <form action = "<?php echo base_url('home/editProfile'); ?>" method = "post" enctype = "multipart/form-data">
                            <div class="form-group">
                                <label><?php echo $this->session->flashdata('error_upload'); ?></label>
                            </div>
                            <div class="form-group">
                                <label>I am here</label>
                                <Br>
                                <input type="radio" name = "type"  value = "1" <?php if($profile->profile_type != 2){ echo "checked"; } ?>> to show talent
                                &nbsp; &nbsp; &nbsp; &nbsp;
                                <input type="radio" name = "type"  value = "2" <?php if($profile->profile_type == 2){ echo "checked"; } ?> > to hire talent
                            </div>
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name = "name" class="form-control" placeholder="" value = "<?php echo $profile->name; ?>">
                            </div>
                            <div class="form-group">
                                <label>This is me: </label>
                                <textarea name = "about"  class="form-control" style ="height: 300px;" ><?php echo $profile->about_me; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Category</label>
                                <br><br>
                                <?php
                                $category_array = explode(",", $profile->category);

                                foreach ($categories as $category) {
                                    if (in_array( $category->category_name, $category_array)){
                                        echo '<input type = "checkbox" name = "category[]" value = "'.$category->category_name.'" checked > &nbsp; &nbsp; '.$category->category_name.'<br>';
                                    }else{
                                        echo '<input type = "checkbox" name = "category[]" value = "'.$category->category_name.'" > &nbsp; &nbsp; '.$category->category_name.'<br>';
                                    }
                                }
                                ?>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select name="country" class="form-control">
                                    <?php
                                    foreach ($countries as $country) {
                                        if( $profile->country == $country->id ){
                                            echo '<option value = "' . $country->id . '" selected>' . $country->country . '</option>';
                                        }else{
                                            echo '<option value = "' . $country->id . '">' . $country->country . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name = "city" class="form-control" placeholder="" value = "<?php echo $profile->city; ?>">
                            </div>
                            <div class="form-group">
                                <label>Profile picture</label>
                                <br>
                        <?php
                            if(!empty($profile->image)){
                        ?>
                                <img src = "<?php echo base_url(); ?>images/users/<?php echo $profile->image; ?>" height = "150">
                        <?php
                            }else{
                        ?>
                                <img style="height:100%;" src="<?php echo base_url(); ?>assets/frontend/images/profile.jpg" alt="">
                        <?php
                            }
                        ?>
                                
                                <input type="file" name = "image" >(simply choose file and click on "Save Update" tab below to upload picture)
                            </div>
                            <div class="form-group">
                                <label>Banner Image</label>
                                <br>
                                <img src = "<?php echo base_url(); ?>images/users/<?php echo $profile->banner; ?>"  width = "350">
                                <input type="file" name = "banner">(simply choose file and click on "Save Update" tab below to upload picture)
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default" >Save Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</div>
<?php $this->load->view('users/include/footer.php'); ?>