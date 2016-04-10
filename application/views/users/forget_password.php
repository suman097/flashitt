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
                    <p>Change your password</p>
                    <div class="post_talent_in">
                        <form action = "" method = "post" enctype = "multipart/form-data" onsubmit = "return onSubmitPasswordCheck();">
                            <div class="form-group">
                                <label id = "error_password"><?php echo $this->session->flashdata('error_password'); ?></label>
                            </div>
                            
                            <div class="form-group">
                                <label>New password</label>
                                <input type="password" name = "password" id ="new_password" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>Retype password</label>
                                <input type="password" name = "repass" id ="retype_password" class="form-control" placeholder="">
                            </div>
                            <input type = "hidden" name = "profile_id" value = "<?php echo $profile->id; ?>">
                            <div class="form-group">
                                <button type="submit" class="btn btn-default" name = "SUB">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</div>
<script type = "text/javascript">
    function onSubmitPasswordCheck(){
        var password = $("#new_password").val();
        var retype = $("#retype_password").val();
        var passReg = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/;
        var passwordvalid = passReg.test(password);
        if( password == retype ){
            if(passwordvalid){
                return true;
            }else{
                $("#error_password").html("Password should have alphanumeric and special characters and minimum 8 characters");
                return false;
            }
        }else{
            
            $("#error_password").html("Password not match");
            return false;
        }
    }
</script>
<?php $this->load->view('users/include/footer.php'); ?>