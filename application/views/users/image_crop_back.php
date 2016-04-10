<?php $this->load->view('users/include/header.php'); ?>	
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/style-metro.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL STYLES -->
<link href="<?php echo base_url(); ?>assets/plugins/jcrop/css/jquery.Jcrop.min.css" rel="stylesheet"/>
<!-- END PAGE LEVEL STYLES -->
<link href="<?php echo base_url(); ?>assets/css/pages/image-crop.css" rel="stylesheet"/>
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
                        <form action = "<?php echo base_url('home/cropBannerImage'); ?>" method = "post" enctype = "multipart/form-data">
                            <div class="form-group">
                                <label><?php echo $this->session->flashdata('error_upload'); ?></label>
                            </div>
                            <div class="form-group">
                                <label>Banner Image</label>
                                <br>
                                <img src = "<?php echo base_url(); ?>images/users/<?php echo $profile->banner; ?>"  id="demo2">
                            </div>
                                <input type="hidden" id="x1" name="x1" class="m-wrap small" />
                                <input type="hidden" id="y1" name="y1" class="m-wrap small" />
                                <input type="hidden" id="x2" name="x2" class="m-wrap small" />
                                <input type="hidden" id="y2" name="y2" class="m-wrap small" />
                                <input type="hidden" id="w" name="w" class="m-wrap small" />
                                <input type="hidden" id="h" name="h" class="m-wrap small" />
                            <div class="form-group">
                                <a href = "<?php echo base_url('home/profile'); ?>"><button type="button" class="btn btn-default" >Skip</button></a>
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
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->   <script src="assets/plugins/jquery-1.10.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.1.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap-hover-dropdown/twitter-bootstrap-hover-dropdown.min.js" type="text/javascript" ></script>
<!--[if lt IE 9]>
<script src="assets/plugins/excanvas.min.js"></script>
<script src="assets/plugins/respond.min.js"></script>  
<![endif]-->   
<script src="<?php echo base_url(); ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>  
<script src="<?php echo base_url(); ?>assets/plugins/jquery.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/plugins/jcrop/js/jquery.color.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jcrop/js/jquery.Jcrop.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/scripts/app.js"></script>
<script src="<?php echo base_url(); ?>assets/scripts/form-image-crop.js"></script>
<script>
        jQuery(document).ready(function() {
        // initiate layout and plugins
        App.init();
        FormImageCrop.init();
        });
</script>











<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$targ_w = $targ_h = 150;
	$jpeg_quality = 90;

	$src = './demos/demo_files/image5.jpg';

	$img_r = imagecreatefromjpeg($src);

	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,intval($_POST['x']),intval($_POST['y']), $targ_w,$targ_h, intval($_POST['w']),intval($_POST['h']));

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);

	exit;
}
?>