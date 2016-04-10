<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Post, Search, Hire or Connect with talents around the world">
        <meta name="author" content="">
        <title>Flashitt | Post, Search, Hire or Connect with talents around the world </title>

        <link href='https://fonts.googleapis.com/css?family=Lato:300' rel='stylesheet' type='text/css'>

        <link href='https://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>

        <!-- core CSS -->
        <link href="<?php echo base_url(); ?>assets/frontend/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/frontend/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/frontend/css/animate.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/frontend/css/prettyPhoto.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/frontend/css/main.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/frontend/css/responsive.css" rel="stylesheet">

        <!--smile stories effect -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/style_common.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/frontend/css/style1.css" />
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->     
        <script type = "text/javascript">
            function onclickRegistration(){
                var password = $("#password_register").val();
                //alert(password);
                var retype = $("#retype").val();
                var name = $("#name").val();
                var passReg = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,16}$/;
                var passwordvalid = passReg.test(password);
                var emil_chek = $("#email_register").val();
                var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
                var emailvalid = emailReg.test(emil_chek); //returns true & false
                if(name != ""){
                    if(emailvalid){
                        if(passwordvalid){
                            if( password == retype){
                                $.ajax({
                                url: "<?php echo base_url('home/ajaxCheckEmail'); ?>",
                                        type: "POST",
                                        data: {
                                            email: emil_chek,
                                            <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                                        },
                                        success: function(data){
                                            //alert(data);
                                            if (data == "exist"){
                                                $("#error_msg").html("Email id already taken.");
                                                return false;
                                            }else{
                                                $.ajax({
                                                    url: "<?php echo base_url('home/ajaxRegisterUsers'); ?>",
                                                        type: "POST",
                                                        data: {
                                                            name: name,
                                                            email: emil_chek,
                                                            password: password,
                                                            <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                                                        },
                                                        success: function(data){
                                                            $("#error_msg").html("");
                                                            self.location = "<?php echo base_url('home/profile'); ?>";
                                                        }
                                                });
                                            }
                                        }
                                });
                            }else{
                                $("#error_msg").html("Password and Retype password not match.");
                                return false;
                            }
                        }else{
                            $("#error_msg").html("Password should have alphanumeric and special characters and minimum 8 characters.");
                            return false;
                        }
                    }else{
                        $("#error_msg").html("Please enter a valid email address");
                        return false;
                    }
                }else{
                    $("#error_msg").html("You can't leave name field blank");
                    return false;
                }
            }
            
            function onclickLogin(){
                var email = $("#email").val();
                var password = $("#password").val();
                $.ajax({
                    url: "<?php echo base_url('home/ajaxLoginUsers'); ?>",
                        type: "POST",
                        data: {
                            email: email,
                            password: password,
                            <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                        },
                        success: function(data){
                            //alert(data);
                            if( data == "done" ){
                                $("#error_msg_login").html("");
                                self.location = "<?php echo base_url('home/profile'); ?>";
                            }else if( data == "block by admin" ){
                                $("#error_msg_login").html("your account has been blocked by admin");
                            }else{
                                $("#error_msg_login").html("Email or Password not valid");
                            }
                        }
                });
                return false;
            }
            
            function onclickForgetPassword(){
                var email = $("#forget_email").val();
                $.ajax({
                    url: "<?php echo base_url('home/ajaxForgetPassword'); ?>",
                        type: "POST",
                        data: {
                            email: email,
                            <?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
                        },
                        success: function(data){
                            //alert(data);
                            if( data == "done" ){
                                $("#error_msg_forget").html("");
                                self.location = "<?php echo base_url('home'); ?>";
                            }else{
                                $("#error_msg_forget").html("Email not valid");
                            }
                        }
                });
                
            }
        </script>
    </head><!--/head-->

    <body>




        <!-- login popup -->
        <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm">
                <div class="modal-content" style="border-radius:0px;">
                    <div class="modal-header" style="min-height:40px;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <!--<a class="btn btn-block btn-social btn-facebook">
                            <i class="fa fa-facebook"></i> &nbsp;&nbsp;&nbsp; Sign in with Facebook
                        </a>-->

                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-default" style="border-color:#ffffff; box-shadow:none;">

                                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                    <!--<div class="or-box">
                                <span class="or">OR</span>
                                    </div>-->
                                    <span id = "error_msg_login" style = "color:red;"></span>
                                    <font style="width:100%; float:left; padding-bottom:15px; margin-top:5px; text-align:center; font-size:14px;">Login with existing account</font>
                                    <form method = "post" action = "" onsubmit = "return onclickLogin();">
                                        <div class="form-group">
                                            <input type="text" id ="email" class="form-control" placeholder="E-mail">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" id ="password" class="form-control" placeholder="Password">
                                        </div>
<!--                                        <div class="form-group">
                                            <label><input type="checkbox"> Remember me</label>
                                        </div>-->
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-default" >Login</button>
                                        </div>
                                    </form>
                                    Do not have an account please <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Register</a>
                                    <br>Forget password <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">click here</a>
                                </div>



                            </div>
                            <div class="panel panel-default" style="border-color:#ffffff; box-shadow:none;">

                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                    <!--<div class="or-box">
                                <span class="or">OR</span>
                                    </div>-->
                                    <span id = "error_msg" style = "color:red;"></span>
                                    <font style="width:100%; float:left; padding-bottom:15px; margin-top:5px; text-align:center; font-size:14px;">Register as new user</font>
                                    <form>
                                        <div class="form-group">
                                            <input type="text" name ="name" id = "name" class="form-control" placeholder="Name">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name ="email" id = "email_register" class="form-control" placeholder="E-mail">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name ="password" id = "password_register" class="form-control" placeholder="Password">
                                            <span style = "color: #999999; font-size: .8em;">(must have alphabet,numeric and special character like "@,#..")
                                        </div>
                                        <div class="form-group">
                                            <input type="password" id = "retype" class="form-control" placeholder="Confirm password">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" name ="SUB" class="btn btn-default"  onclick = "return onclickRegistration();">Register</button>
                                        </div>
                                    </form>
                                    Have an account? please <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Login</a>
                                    <br>Forget password <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">click here</a>


                                </div>
                            </div>
                            <div class="panel panel-default" style="border-color:#ffffff; box-shadow:none;">

                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                                    <!--<div class="or-box">
                                <span class="or">OR</span>
                                    </div>-->
                                    <span id = "error_msg_forget" style = "color:red;"></span>
                                    <font style="width:100%; float:left; padding-bottom:15px; margin-top:5px; text-align:center; font-size:14px;">Change of password link will be sent to your email id</font>
                                    <form>
                                        <div class="form-group">
                                            <input type="text" id ="forget_email" class="form-control" placeholder="E-mail">
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-default" onclick = "return onclickForgetPassword();">Send</button>
                                        </div>
                                    </form>
                                    Do not have an account please <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Register</a>
                                    <br>Have an account? please <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- navigation -->    
        <div class="header_navi">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <nav class="navbar navbar-inverse" role="banner">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a style="color:#000000;" class="navbar-brand" href="<?php echo base_url('home'); ?>">
                                <img src = "<?php echo base_url(); ?>images/logo.png" height = "40">
                                  Home Page
                                </a>
                            </div>

                            <div class="collapse navbar-collapse">
                                <ul class="nav navbar-nav navbar-right">
                                    
                            <?php
                                if(!empty($users_name)){
                            ?>
                                    <li><a href="<?php echo base_url('home/notification'); ?>">Inbox <i class="fa fa-bell"></i>
                                    <?php
                                    	if( !empty($notification_count) ){
                                    		echo '<span>'.$notification_count.'</span>';
                                    	}
                                    ?>
                                    </a></li>
                                    <li class="active"><a href="<?php echo base_url('home/postRequirement'); ?>">Look for a talent</a></li>
                                    <li class="active"><a href="<?php echo base_url('home/postTalent'); ?>">Post a talent</a></li>
                                    <li><a href="<?php echo base_url('home/profile'); ?>">My timeline</a></li>
                                    <li><a href="<?php echo base_url('home/logout'); ?>">Logout</a></li>
                            <?php
                                }else{
                            ?>
                                    <li class="active"><a href="javascript:void(0);"  data-toggle="modal" data-target=".bs-example-modal-sm">Post a talent</a></li>
                                    <li><a href="javascript:void(0);" data-toggle="modal" data-target=".bs-example-modal-sm">Login / Register</a></li>
                            <?php
                                }
                            ?>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>