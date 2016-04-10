<!-- footer main -->
<div class="footer_panel_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 wow fadeInUp" data-wow-delay="100ms" style="margin-top:15px;">
                <h1>Quick Links</h1>
                <div class="footer_nav">
                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="nav">
                                <li><a href="<?php echo base_url('home'); ?>">&raquo; Home</a></li>
                                <li><a href="<?php echo base_url('home/content/aboutUs'); ?>">&raquo; About Us</a></li>
                                <li><a href="<?php echo base_url('home/content/terms_and_condition'); ?>">&raquo; Terms &amp; Conditions</a></li>
                                <li><a href="<?php echo base_url('home/content/contactUs'); ?>">&raquo; Contact Us</a></li>
                            </ul>
                        </div>
                        <!-- <div class="col-sm-6">
                            <ul class="nav">
                                <li><a href="#">&raquo; Blog</a></li>
                                <li><a href="#">&raquo; Privacy Policy</a></li>
                                <li><a href="#">&raquo; Feedback</a></li>
                            </ul>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-sm-4 wow fadeInUp" data-wow-delay="200ms" style="margin-top:15px;">
                <h1>Popular Categories</h1>
                <div class="footer_nav">
                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="nav">
                    <?php
                        $i = 1;
                        if(!empty($categories)){
                            foreach($categories as $category){

                    ?>
                                <li><a href="<?php echo base_url('home/searchTalent'); ?>?category=<?php echo $category->id; ?>">&raquo; <?php echo $category->category_name; ?></a></li>
                    <?php
                                if($i%4 == 0){
                                    echo '</ul>
                                        </div>
                                        <div class="col-sm-6">
                                            <ul class="nav">';
                                }
                                $i++;
                            }
                        }
                    ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4 wow fadeInUp" data-wow-delay="400ms" style="margin-top:15px;">
                <h1>Contact Us</h1>
                <address class="footer_address">
                    <i class="fa fa-map-marker"></i>&nbsp; Lorem ipsum is simoly dummy text of the <br><span>typesetting industry</span>
                </address>
                <address class="footer_address">
                    <i class="fa fa-phone"></i>&nbsp; +91 9000000000
                </address>
                <address class="footer_address">
                    <i class="fa fa-envelope"></i>&nbsp; info@company.com
                </address>
                <div class="footer_nav">
                    <a href="#"><div class="facebook"><i class="fa fa-facebook"></i></div></a>
                    <a href="#"><div class="twitter"><i class="fa fa-twitter"></i></div></a>
                    <a href="#"><div class="youtube"><i class="fa fa-youtube"></i></div></a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="footer_second">
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="border-top:1px solid #CCC; padding-top:10px;">
                Copyright &copy; 20015 companyname All Right Reserved
            </div>
        </div>
    </div>
</div>






<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.prettyPhoto.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/jquery.isotope.min.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/main.js"></script>
<script src="<?php echo base_url(); ?>assets/frontend/js/wow.min.js"></script>
<!--<script src="js/index.js"></script>-->
<script src='http://codepen.io/assets/libs/fullpage/jquery.js'></script>
</body>
</html>