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
                                <li><a href="<?php echo base_url('home/contactUs'); ?>">&raquo; Contact Us</a></li>
                                <li><a href="<?php echo base_url('home/content/how_it_works'); ?>" style = "color: #02A6F8;" >&raquo; How It Works</a></li>
                                <li><a href="<?php echo base_url('home/listRequirement'); ?>">&raquo; Latest Requirements</a></li>
                            </ul>
                        </div>
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
                                    break;
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

            <div class="col-sm-4 wow fadeInUp" data-wow-delay="200ms" style="margin-top:15px;">
                <h1>Popular Categories</h1>
                <div class="footer_nav">
                    <div class="row">
                        <div class="col-sm-6">
                            <ul class="nav">
                    <?php
                        $j = 1;
                        if(!empty($categories)){
                            foreach($categories as $category){
                                if($j>4){

                    ?>
                                <li><a href="<?php echo base_url('home/searchTalent'); ?>?category=<?php echo $category->id; ?>">&raquo; <?php echo $category->category_name; ?></a></li>
                    <?php
                                
                                
                                }
                                $j++;
                            }
                        }
                    ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="footer_second">
    <div class="container">
        <div class="row">
            <div class="col-sm-12" style="border-top:1px solid #CCC; padding-top:10px;">
                Copyright &copy; 2016 flashitt All Right Reserved
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