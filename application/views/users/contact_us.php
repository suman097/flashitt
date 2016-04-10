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
                    <p>Contact Us</p>
                    <div class="post_talent_in">
                        <form action = "<?php echo base_url('home/contactUs'); ?>" method = "post" enctype = "multipart/form-data" onsubmit = "return onsubmitCheck();">
                            <div class="form-group">
                                <label><?php echo $this->session->flashdata('successfully_msg'); ?></label>
                            </div>
                            <div class="form-group">
                                <input type="text" name = "email" id = "email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="text" name = "subject" id = "subject" class="form-control" placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <textarea name="description" id = "description" class="form-control" style="height:150px; resize:none;" cols="" rows="" placeholder = "Write here..."></textarea>
                            </div>   
                            <div class="form-group">
                                <button type="submit" class="btn btn-default" name = "SUB">Send</button>
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
<script type = "text/javascript">
    function onsubmitCheck(){
        var email = $("#email").val();
        var subject = $("#subject").val();
        var description = $("#description").val();
        if( email == "" && subject == "" && description == "" ){
            alert("Please enter value for all fields");
            return false;
        }else{
          return true;
        }
    }
</script>