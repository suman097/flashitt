<?php $this->load->view('users/include/header.php'); ?>







<script type="text/javascript">
    function onclickTrust(company, ip) {

        $.ajax({
            url: "<?php echo base_url('home/ajaxCheckIPTrust'); ?>",
            type: "POST",
            data: {
                company: company,
                ip: ip,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                alert(data);
            }
        });
        return false;
    }



    function clickCountrySelect(country) {
        //alert(country);
        $("#hid_country").val(country);
        var country_name = $("#country_name_" + country).val();
        //alert(country_name);
        $("#selected_country_name").html("");
        $("#selected_country_name").html(country_name);
        //$('#cbp-hrmenu').modal('hide');
        return false;
    }

    function submitCheckCountry(country) {
        var coun = $("#hid_country").val();
        if (coun == "") {
            alert("Please Select Country.");
            return false;
        } else {
            return true;
        }
    }
    
    function keyupAutoSagetion(search) {
        var country = $("#hid_country").val();
        //alert(country);
        $.ajax({
            url: "<?php echo base_url('home/ajaxAutoSearchCompany'); ?>",
            type: "POST",
            data: {
                key: search,
                country: country,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                //alert(data);
                $(".auto_sagetion").html(data);
                $(".auto_sagetion").css('display', 'block');
            }
        });
        return false;
    }
    
    function onclickAutoSagetion(key){
        //alert(key);
        $("#search_company").val();
        $("#search_company").val(key);
        $(".auto_sagetion").css('display', 'none');
        return false;
    }
</script>
<div class="banner_panel_main">
    <div class="container mar_top4">
        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="logo">

                            <?php echo $details->banner_text; ?>
                        </div>
                    </div>
                </div>
                <div class="row mar_top3">
                    <div class="col-sm-12">
                        <div class="row navbar-default">
                            <div class="col-sm-2">
                                <div class="row">
                                    <div style="height:40px"></div>	
                                </div>
                            </div>
                            <form action="<?php echo base_url('home/searchCompany'); ?>" method="post" onSubmit="return submitCheckCountry();">
                                <div class="col-sm-8">
                                    <div class="row">

                                        <input type="text" name = "search" class="form-control" id ="search_company" placeholder="Which company are you looking for?"  autocomplete="off" onkeyup = "return keyupAutoSagetion(this.value);">
                                        <input type="hidden" name = "country" id = "hid_country">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="row">
                                        <button type="submit" class="btn btn-default">Search</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="logo_secend">
                            <br>To register new company<br>
                            <a href = "<?php echo base_url('home/companyRegister'); ?>"><input type = "button" value = "Register" class="btn btn-success"></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="chat-box-online-div">
                            <div class="chat-box-online-head">
                                Online users
                            </div>
                            <div class="panel-body chat-box-online" id = "forum_chat">
                                <?php
                                if (isset($forum)) {
                                    $c = 0;
                                    foreach ($forum as $for) {
                                        $c++;
                                        if ($c % 2 != 0) {
                                            ?>
                                            <div class="chat-box-online-left">
                                                <a href = "<?php echo base_url('home/userProfile') . '/' . $for->nik; ?>"><img src="<?php echo base_url(); ?>images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />
                                                    -  <?php echo $for->nik; ?></a>
                                                <br />
                                                <?php echo $for->content; ?>
                                                <br>
                                                ( <small><?php echo $for->date; ?></small> )
                                            </div>
                                            <hr class="hr-clas-low" />
                                            <?php
                                        } else {
                                            ?>
                                            <div class="chat-box-online-right">
                                                <a href = "<?php echo base_url('home/userProfile') . '/' . $for->nik; ?>"> <img src="<?php echo base_url(); ?>images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />
                                                    -  <?php echo $for->nik; ?></a>
                                                <br />
                                                <?php echo $for->content; ?>
                                                <br>
                                                ( <small><?php echo $for->date; ?></small> )
                                            </div>
                                            <hr class="hr-clas-low" />

                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="form_panel"  style="height: 52px;">
                                <?php
                                if (isset($users_type)) {
                                    ?>
                                    <form action = "" method="post" onsubmit = "return submitForumComment('<?php echo $users_nikname; ?>');">
                                        <div style="width:80%; float:left;">
                                            <input type="text" class="form-control" placeholder="write your comment" id = "comment_text">
                                        </div>
                                        <div style="width:20%; float:left;">
                                            <button type="submit" class="btn btn-default">Post</button>
                                        </div>
                                    </form>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row dropdown_pos">
            <div class="col-sm-12">
                <div class="row">
                    <nav id="cbp-hrmenu" class="cbp-hrmenu">
                        <ul>
                            <li>
                                <a href="#" style="height:40px;"><span id = "selected_country_name">Select Country</span> &nbsp; <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span></a>
                                <div class="cbp-hrsub">
                                    <div class="cbp-hrsub-inner"> 
                                        <div>
                                            <h4>Country</h4>
                                            <ul>
                                                <?php
                                                $col_country = ceil($count_country / 4);
                                                for ($i = 0; $i < $col_country; $i++) {
                                                    ?>
                                                    <li><a href=" " onclick = "return clickCountrySelect('<?php echo $country[$i]->id; ?>');"><?php echo $country[$i]->country; ?></a></li>
                                                    <input type = "hidden" id = "country_name_<?php echo $country[$i]->id; ?>" value = "<?php echo $country[$i]->country; ?>">
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div>
                                            <h4>Country</h4>
                                            <ul>
                                                <?php
                                                for ($j = $i; $j < (2 * $col_country); $j++) {
                                                    ?>
                                                    <li><a href = "" onclick = "return clickCountrySelect('<?php echo $country[$j]->id; ?>');"><?php echo $country[$j]->country; ?></a></li>
                                                    <input type = "hidden" id = "country_name_<?php echo $country[$j]->id; ?>" value = "<?php echo $country[$j]->country; ?>">
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div>
                                            <h4>Country</h4>
                                            <ul>
                                                <?php
                                                for ($k = $j; $k < (3 * $col_country); $k++) {
                                                    ?>
                                                    <li><a href=" " onclick = "return clickCountrySelect('<?php echo $country[$k]->id; ?>');"><?php echo $country[$k]->country; ?></a></li>
                                                    <input type = "hidden" id = "country_name_<?php echo $country[$k]->id; ?>" value = "<?php echo $country[$k]->country; ?>">
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div>
                                            <h4>Country</h4>
                                            <ul>
                                                <?php
                                                for ($l = $k; $l < (4 * $col_country); $l++) {
                                                    ?>
                                                    <li><a href=" " onclick = "return clickCountrySelect('<?php echo $country[$l]->id; ?>');"><?php echo $country[$l]->country; ?></a></li>
                                                    <input type = "hidden" id = "country_name_<?php echo $country[$l]->id; ?>" value = "<?php echo $country[$l]->country; ?>">  
                                                    <?php
                                                    if ($l == ($count_country - 1)) {
                                                        break;
                                                    }
                                                }
                                                ?>
                                            </ul>
                                        </div>

                                    </div><!-- /cbp-hrsub-inner -->
                                </div><!-- /cbp-hrsub -->
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>


        <div class = "auto_sagetion" style="display: none; ">
            
        </div>


    </div>
</div>

<div class="some_company_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h2>Some of our latest Added Companies</h2>
            </div>
        </div>

        <div class="row mar_top3">
            <div class="col-sm-12">
                <div class="row">

                    <?php
                    $c = 0;
                    foreach ($company_details as $com) {
                        $c++;
                        if ($c == 7) {
                            echo "</div>
				<div class='row'>";
                        }
                        if ($company_details[$com->id]->count > 0) {
                            $comp_rating = floor($company_details[$com->id]->total / $company_details[$com->id]->count);
                        } else {
                            $comp_rating = 0;
                        }
                        ?>
                        <div class="col-sm-2">
                            <div class="thumbnail">
                                <?php
                                if ($com->company_logo) {
                                    ?>
                                    <a href = "<?php echo base_url('home/companyDetails') . "/" . $com->id; ?>"><img src="<?php echo base_url(); ?>images/company/<?php echo $com->company_logo; ?>" alt=""></a>
                                    <?php
                                } else {
                                    ?>
                                    <a href = "<?php echo base_url('home/companyDetails') . "/" . $com->id; ?>"><img src="<?php echo base_url(); ?>images/icons/no_image.png" alt=""></a>
                                    <?php
                                }
                                ?>

                                <div class="caption">
                                    <h3><a href = "<?php echo base_url('home/companyDetails') . "/" . $com->id; ?>"><?php echo $com->company_name; ?></a></h3>
                                    <div class="rating_main">
                                        <img src = "<?php echo base_url(); ?>images/icons/rating_<?php echo $comp_rating; ?>.png">
                                    </div>
                                    <h4><a href=" " onclick = "return onclickTrust('<?php echo $com->id; ?>', '<?php echo $_SERVER["REMOTE_ADDR"]; ?>')"><span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span> <?php echo $com->trust; ?> trust</a></h4>
                                </div>
                            </div>
                        </div>


                        <?php
                        if ($c >= 12) {
                            break;
                        }
                    }
                    ?>

                </div>
            </div>
        </div>



        <div class="row mar_top2">
            <div class="col-sm-12" style="text-align:center;">
                <a href = "<?php echo base_url('home/companyListing'); ?>"><button type="button" class="btn btn-default">View More</button></a>
            </div>
        </div>
    </div>
</div>



<div class="about_panel_main">
    <div class="container">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <h1>Welcome to our company</h1>
                <p><?php echo $home_about->content; ?></p>
            </div>
            <div class="col-sm-2"></div>
        </div>

        <div class="row mar_top2">
            <div class="col-sm-12" style="text-align:center;">
                <a href="<?php echo base_url('home/content/aboutUs'); ?>"><button type="button" class="btn btn-default">View More</button></a>
                <br><br>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('users/include/footer.php'); ?>
