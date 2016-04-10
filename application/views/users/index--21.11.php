<?php $this->load->view('users/include/header.php'); ?>	

<!-- banner panel -->
<div class="banner_panel_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Search thousands of talents</h1>
            </div>
        </div>
        <form action = "<?php echo base_url('home/searchTalent'); ?>" method="get">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="input-group">

                        <div class="input-group-btn search-panel">
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/chosen/chosen.css">
                                <style type="text/css" media="all">
                                    /* fix rtl for demo */
                                    .chosen-rtl .chosen-drop { left: -9000px; }
                                </style>

                                <select name ="country" data-placeholder="Choose a Country..." class="chosen-select" style="width:200px;" tabindex="2">
                                    <option value=""></option>
                                    <?php
                                    if (!empty($countries)) {
                                        foreach ($countries as $country) {
                                            ?>
                                            <option value="<?php echo $country->id; ?>"><?php echo $country->country; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>

                                </select>
                            </button>
                            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
                            <script src="<?php echo base_url(); ?>assets/frontend/chosen/chosen.jquery.js" type="text/javascript"></script>
                            <script type="text/javascript">
                                var config = {
                                    '.chosen-select': {},
                                    '.chosen-select-deselect': {allow_single_deselect: true},
                                    '.chosen-select-no-single': {disable_search_threshold: 10},
                                    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                                    '.chosen-select-width': {width: "95%"}
                                }
                                for (var selector in config) {
                                    $(selector).chosen(config[selector]);
                                }
                            </script>



                        </div>

                        <input type="hidden" id = "search_hidden_category" value = "0" name = "category">  
                        <input type="text" class="form-control" name="search" placeholder="Search talents...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> &nbsp; Search</button>
                        </span>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </form>
    </div>
</div>

<div>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="homepage_postsection">
                    <font style="font-size:18px; float:left; text-transform:uppercase; color:#333; margin-top:10px;">Post your requirement</font>
                    <a href="<?php echo base_url('home/postTalent'); ?>" class="btn btn-default pull-right" >Post Requirement</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- category panel -->
<div class="category_panel_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12"><h1 class="wow fadeInRight" data-wow-delay="100ms">Select categories below</h1></div>
        </div>
        <!--<div class="row">
                <div class="col-sm-12" style="text-align:center;"><img class="wow fadeInLeft" data-wow-delay="300ms" src="images/line.jpg" alt=""></div>
        </div>-->
        <div class="row" style="margin-top:40px;">
            <div class="col-sm-2"></div>
            <?php
            $i = 1;
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    ?>

                    <div class="col-sm-2 wow fadeInUp" data-wow-delay="100ms">
                        <a href="<?php echo base_url('home/searchTalent'); ?>?category=<?php echo $category->id; ?>" style="text-decoration:none;">
                            <div class="thumbnail">
                                <img class="wow zoomIn" src="<?php echo base_url(); ?>assets/frontend/images/icon1.png" alt="">
                                <h2><?php echo $category->category_name; ?></h2>
                            </div>
                        </a>
                    </div>
        <?php
        if ($i % 4 == 0) {
            echo '<div class="col-sm-2"></div>
                            </div>
                            <div class="row" style="margin-top:12px;">
                                <div class="col-sm-2"></div>';
        }
        $i++;
    }
}
?>
            <div class="col-sm-2"></div>
        </div>


    </div>
</div>

<script type="text/javascript">
    function onclickSearchCategory(id, category) {
        $("#search_concept").html(category);
        $("#search_hidden_category").val(id);
    }
</script>
<?php $this->load->view('users/include/footer.php'); ?>