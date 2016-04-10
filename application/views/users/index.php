<?php $this->load->view('users/include/header.php'); ?>	

<!-- banner panel -->
<div class="banner_panel_main" style = "background:url(<?php echo base_url(); ?>images/misc/<?php echo $banner->content; ?>) #333 no-repeat center;">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?= $content->content; ?>
            </div>
        </div>
        <form action = "<?php echo base_url('home/searchTalent'); ?>" method="get">
            <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                    <div class="input-group">
                        <div class="input-group-btn search-panel">
                            <div type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/frontend/chosen/chosen.css">
                                <style type="text/css" media="all">
                                    /* fix rtl for demo */
                                    .chosen-rtl .chosen-drop { left: -9000px; }
                                </style>
                                <select name ="country" data-placeholder="Choose a Country..." class="chosen-select" tabindex="2">
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
                            </div>
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
                        <div class = "search_tab_bet" ><input type="text" class="search_tab_input_text" name="search" placeholder="search talents or post your talent"></div>
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span> &nbsp; Search</button>
                        </span>
                    </div>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </form>
        <br>
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <div class="input-group">
                    <div class="input-group-btn search-panel">
                        <div type="button" class="btn btn-info dropdown-toggle" >
                            <a href = "<?php echo base_url('home/listRequirement'); ?>" class = "link-search"><input type = "button" class="search-button" value = "Latest hiring updates"></a>
                        </div>
                    </div>
                    <div class = "search_tab_bet"></div>
                    <span class="input-group-btn">
                        <?php
                        if(!empty($users_name)){
                        ?>
                            <a href = "<?php echo base_url('home/postRequirement'); ?>" class = "link-search"><button class="btn btn-default" type="submit">Look for a talent</button></a>
                        <?php
                        }else{
                        ?>
                            <a href = "javascript:void(0);" class = "link-search" data-toggle="modal" data-target=".bs-example-modal-sm"><button class="btn btn-default" type="button">Look for a talent</button></a>
                        <?php
                        }
                    ?>
                        
                    </span>
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</div>

<div class="category_panel_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12" >
                <marquee><?php echo $heading->content; ?></marquee>
            </div>
        </div>
    </div>
</div>
<!-- category panel -->
<div class="category_panel_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="wow fadeInRight" data-wow-delay="100ms">Select categories below</h1>
            </div>
        </div>
        <!--<div class="row">
                <div class="col-sm-12" style="text-align:center;"><img class="wow fadeInLeft" data-wow-delay="300ms" src="images/line.jpg" alt=""></div>
        </div>-->
        <div class="row" style="margin-top:23px;">
            <div class="col-sm-2"></div>
            <?php
            $i = 1;
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    ?>

                    <div class="col-sm-2 wow fadeInUp" data-wow-delay="100ms">
                        <a href="<?php echo base_url('home/searchTalent'); ?>?category=<?php echo $category->id; ?>" style="text-decoration:none;">
                            <div class="thumbnail">
                                <img class="wow zoomIn" src="<?php echo base_url(); ?>images/misc/<?php echo $category->category_image; ?>" alt="" style = "height: 138px;">
                                
                            </div>
                            <h2 class = "category_heading"><?php echo $category->category_name; ?></h2>
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