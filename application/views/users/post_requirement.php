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
                    <p>Post Requirement</p>
                    <div class="post_talent_in">
                        <form action = "<?php echo base_url('home/postRequirement'); ?>" method = "post" enctype = "multipart/form-data">
                            <div class="form-group">
                                <label><?php echo $this->session->flashdata('error_upload'); ?></label>
                            </div>
                            <div class="form-group">
                                <label>Requirement Title (in one short word to enable users to connect with you)</label>
                                <input type="text" name = "title" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" style="height:150px; resize:none;" cols="" rows=""></textarea>
                            </div>
                            <div class="form-group">
                                <label>category</label>
                                <select name="category" class="form-control" onchange = "return onChangeOpenOtherCategory(this.value);" >
                                    <?php
                                    foreach ($categories as $category) {
                                        echo '<option value = "' . $category->id . '">' . $category->category_name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select name="country" class="form-control">
                                    <?php
                                    foreach ($countries as $country) {
                                        echo '<option value = "' . $country->id . '">' . $country->country . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" name ="city" class="form-control" placeholder="(Optional)">
                            </div>    
                            <div class="form-group">
                                <button type="submit" class="btn btn-default" name = "SUB">Post Your Requirement</button>
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