<?php $this->load->view('users/include/header.php'); ?>	

<!--inner page content-->    
<!--inner page content--> 
<script type="text/javascript">
    function onChangeOpenOtherCategory(category){
        if( category == 0 ){
            $("#display_others_text").css("display", "block");
        }else{
            $("#display_others_text").css("display", "none");
        }
    }

    function onClickFormSubmit(){
    	var country = $( "#form-country" ).val();
    	if( country == ""){
    		alert("please select country atleast one");
    		return false;
    	}else{
    		$( "#post_talent_form" ).submit();
    	}
    }

</script>   
<div class="inner_page_container">
    <div class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <!-- post talent-->
            <div class="col-sm-8">
                <div class="friend_list_main">
                    <p>Post your Talent (to enable users to connect)</p>
                    <div class="post_talent_in">
                        <form id = "post_talent_form" action = "<?php echo base_url('home/postTalent'); ?>" method = "post" enctype = "multipart/form-data">
                            <div class="form-group">
                                <label><?php echo $this->session->flashdata('error_upload'); ?></label>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Upload Picture</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="file" name = "photo1">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="file" name = "photo2">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Upload Video</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <input type="file" name = "video">(Please upload only mp4 files & delete old videos to make best use of allocated space given to each user)
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Post category</label>
                                <select name="category" class="form-control" onchange = "return onChangeOpenOtherCategory(this.value);" >
                                    <?php
                                    foreach ($categories as $category) {
                                        echo '<option value = "' . $category->id . '">' . $category->category_name . '</option>';
                                    }
                                    ?>
                                    <option value = "0">Others</option>
                                </select>
                            </div>
                            
                            <div class="form-group" id = "display_others_text" style = "display: none;">
                                <label>Others category</label>
                                <input type="text" name = "others" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Title (label your talent in one short word to enable users to connect)</label>
                                <input type="text" name = "title" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" style="height:150px; resize:none;" cols="" rows=""></textarea>
                            </div>
<!--                            <div class="form-group">
                                <label>Speciality</label>
                                <input type="text" name = "speciality" class="form-control" placeholder="">
                            </div>-->
                            <div class="form-group">
                                <label>Country</label>
                                <select name="country[]" class="form-control" multiple="multiple" style = "height: 100px;" id = "form-country">
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
                                <button type="button" class="btn btn-default" onclick = "return onClickFormSubmit();" name = "SUB">Post Your Talent</button>
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