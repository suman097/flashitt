<!DOCTYPE html><?php //print_r($this->session->userdata('admin')->logged_id);echo"<pre>";print_r($books);exit;  ?>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Flashitt | Manage users </title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>assets/css/themes/brown.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/select2/select2_metro.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.css" />
        <!-- END PAGE LEVEL STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <!-- END HEAD -->
    <?php $this->load->view('admin/include/header.php'); ?>
    <?php $this->load->view('admin/include/sideber.php'); ?>
    <!-- BEGIN PAGE -->
    <div class="page-content">
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div id="portlet-config" class="modal hide">
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button"></button>
                <h3>Manage Users</h3>
            </div>
            <div class="modal-body">
                <p>Show Post Of All Users</p>
            </div>
        </div>
        <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE CONTAINER-->        
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->
            <div class="row-fluid">
                <div class="span12">

                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        Users <small>Show Post Of All Users</small>
                    </h3>
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i>
                            <a href="<?php base_url('dashboard'); ?>">Home</a> 
                            <i class="icon-angle-right"></i>
                        </li>
                        <li>
                            <a href="">Users</a>
                            <i class="icon-angle-right"></i>
                        </li>
                        <li><a href="<?php base_url('user_management'); ?>">Show Post Of All Users</a></li>
                    </ul>
                    <!-- END PAGE TITLE & BREADCRUMB-->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <!-- BEGIN PAGE CONTENT-->
            <div class="row-fluid">
                <div class="span12">
                    <!-- BEGIN EXAMPLE TABLE PORTLET-->
                    <div class="portlet box light-grey">
                        <div class="portlet-title">
                            <div class="caption"><i class="icon-globe"></i>Show Post Of All Users</div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                                <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                <a href="javascript:;" class="reload"></a>
                                <a href="javascript:;" class="remove"></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row-fluid">
                                <div class="span12 ">
                                    <div class="control-group">
                                        <b><?php echo $post->title; ?></b><br><br>
                                        <?php echo $post->description; ?>
                                    </div>

                                    <?php
                                        if(!empty($post_contents)){
                                            foreach ($post_contents as $content) {
                                                if ($content->elements_type == 2) {
                                                    ?>
                                                    <div class="col-sm-6" style = "padding-top: 26px;"><img src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" alt=""></div>
                                                    <?php
                                                } else if ($content->elements_type == 3) {
                                                    ?>
                                                    <div class="profile_block_body">
                                                        <?php
                                                            $extention = end(explode(".", $content->elements));
                                                        ?>

                                                        <video width="100%" height="315" controls>
                                                            <source src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" type="video/<?php echo $extention; ?>">
                <!--                                                <source src="movie.ogg" type="video/ogg">-->
                                                            Your browser does not support the video tag.
                                                        </video>
                                                        <span><a href = "javascript:void(0);" onclick = "return onclickPostContentDelete(<?php echo $content->id; ?>);" style = "color: #CCC;" title = "Delete">Delete</a></span>
                                                        <!--<iframe width="100%" height="315" src="<?php echo base_url(); ?>images/talent/<?php echo $content->elements; ?>" frameborder="0" allowfullscreen></iframe>-->
                                                    </div>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>

                                        <div class="profile_block_footer">
                                            <p style="border-bottom:1px solid #CCC; padding-bottom:10px;">
                                                <a href="#collaps_comment_<?php echo $post->id; ?>" data-toggle="collapse" data-target="#collaps_comment_<?php echo $post->id; ?>"><i class="fa fa-comments-o"></i> <?php if ($count_comments > 0) { echo $count_comments; } ?> Comment</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </p>

                                            <div id="collaps_comment_<?php echo $post->id; ?>" class="panel-collapse " style="margin-top:15px;">
                                                <div id = "total_comment_<?php echo $post->id; ?>">
                                                <?php
                                                    if(!empty($comments)){
                                                        foreach($comments as $comment){
                                                            $comment_profile_id = ((( $comment->user_id * 26 ) + 5364 ) - 769 );
                                                ?>
                                                            <div style="width:100%; float:left; margin-top:8px; margin-left:10px;">
                                                                <div class="profile_block_header_thumb" style = "height: 44px; width: 44px;"><a href = "<?php echo base_url('home/talentProfile/'.$comment_profile_id); ?>"><img height="100%"  width ="100%" src="<?php echo base_url(); ?>images/users/<?php echo $comment->image; ?>" alt=""></a></div>
                                                                        &nbsp;&nbsp; <font style="color:#333; font-size:12px;"><a href = "<?php echo base_url('home/talentProfile/'.$comment_profile_id); ?>"><?php echo $comment->name; ?></a></font><br>
                                                                &nbsp;&nbsp; <font style="color:#999; font-size:12px;"><?php echo $comment->comments; ?></font><br>
                                                                <?php
                                                                    $comment_date_explode = explode(" ", $comment->post_at);
                                                                ?>
                                                                &nbsp;&nbsp; <font style="color:#999; font-size:10px;"> . . . . <?php echo $comment_date_explode[0]; ?></font><br>
                                                            </div>

                                                <?php
                                                        }
                                                    }
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <a href = "<?php echo base_url('user_management/deletePostUserManagement').'/'.$post->id; ?>"><button type="button" class="btn">Delete</button></a>
                        </div>
                    </div>
                    <!-- END EXAMPLE TABLE PORTLET-->
                </div>
            </div>
            <!-- END PAGE CONTENT-->
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('admin/include/footer.php'); ?>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->   <script src="<?php echo base_url(); ?>assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
<!--[if lt IE 9]>
<script src="<?php echo base_url(); ?>assets/plugins/excanvas.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/respond.min.js"></script>  
<![endif]-->   
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/plugins/data-tables/DT_bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/table-managed.js"></script>     
<script>
                                                jQuery(document).ready(function () {
                                                    App.init();
                                                    TableManaged.init();
                                                });
</script>
</body>
<!-- END BODY -->
</html>