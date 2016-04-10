<?php $this->load->view('users/include/header.php'); ?>
<script type = "text/javascript">
    function onclickReport(report_id, company_id) {
        //alert(report_id);
        self.location = "<?php echo base_url('home/reportAbuse'); ?>/" + report_id + "/" + company_id;
    }
    function onclickSessionPostValueSave() {
        var title = $("#comment_title").val();
        var post = $("#comment_post").val();
        $.ajax({
            url: "<?php echo base_url('home/ajaxInsertSessionComment'); ?>",
            type: "POST",
            data: {
                title: title,
                post: post,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                //alert(data);
                $("#comment_text").val("");
                $("#forum_chat").html("");
                $("#forum_chat").html(data);
            }
        });
        return false;
        alert(title);
    }
</script>
<div class="company_page_main">
    <div class="container">
        <div class="row">
            <!-- left row-->
            <div class="col-sm-8">
                <div class="row">
                    <div class="company_page_banner_main">
                        <div class="company_page_banner">
                            <div class="company_page_banner_namepanel">
                                <div class="company_page_banner_namepanel_logo">
                                    <?php
                                    if ($details->company_logo) {
                                        ?>
                                        <img src="<?php echo base_url(); ?>images/company/<?php echo $details->company_logo; ?>" alt="">
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo base_url(); ?>images/icons/no_image.png" alt="">
                                        <?php
                                    }
                                    ?>	
                                </div>
                                <div class="company_page_banner_namepaneltext">
                                    <h1><?php echo $details->company_name; ?></h1>
                                    <p><?php echo $details->weblink; ?></p>
                                    <p>
                                        <?php if (!empty($details->company_city)) { ?>
                                            <?php echo $details->company_city; ?>,
                                            <?php
                                        }
                                        ?>
                                        <?php echo $details->country; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>         
                <!-- <div class="row" style="border-bottom:1px solid #CCC;">
                     <div class="col-sm-2">
                     <div class="row">
                          <div class="company_pahe_reviews">
                                <a href="#"><h1>5.1k</h1>
                                <p>Reviews</p></a>
                          </div>
                     </div>
                     </div>
                     <div class="col-sm-2">
                     <div class="row">
                          <div class="company_pahe_reviews">
                                <a href="#"><h1>9.6k</h1>
                                <p>Comments</p></a>
                          </div>
                     </div>
                     </div>
                     <div class="col-sm-2">
                     <div class="row">
                          <div class="company_pahe_reviews">
                                <a href="#"><h1>10.7k</h1>
                                <p>Trusts</p></a>
                          </div>
                     </div>
                     </div>
                </div> -->
                <div class="row mar_top3">
                    <div class="company_page_borderedbox">
                        <h1>Details about the Company</h1>
                        <p><?php echo $details->company_description; ?></p>
                        <?php
                        if ($details->count > 0) {
                            $company_rating = floor($details->total / $details->count);
                        } else {
                            $company_rating = 0;
                        }
                        ?>
                        <img src = "<?php echo base_url(); ?>images/icons/rating_<?php echo $company_rating; ?>.png">
                    </div>
                </div> 

                <?php
                if (isset($review)) {
                    foreach ($review as $rev) {
                        ?>
                        <div class="row mar_top3">
                            <div class="company_page_borderedbox">
                                <h4 class="media-heading">
                                    <?php
                                    if (isset($users_type)) {
                                        if ($users_nikname == $rev->nikname) {
                                            echo $rev->nikname;
                                        } else {
                                            ?>
                                            <a href = "<?php echo base_url('home/userProfile') . '/' . $rev->nikname; ?>"><?php echo $rev->nikname; ?></a>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <a href = "<?php echo base_url('home/userProfile') . '/' . $rev->nikname; ?>"><?php echo $rev->nikname; ?></a>
                                        <?php
                                    }
                                    ?>
                                </h4><font size="1"><?php echo $rev->date; ?></font>
                                <div class="media">
                                    <div class="media-left">
                                        <a href="#">
                                                <!--<img class="media-object"  src="<?php echo base_url(); ?>assets/frontend/images/shire2.jpg" alt="">-->
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h4 class="media-heading"><?php echo $rev->title; ?></h4>
                                        <img src = "<?php echo base_url(); ?>images/icons/rating_<?php echo $rev->rating; ?>.png">
                                        <br>
                                        <?php echo $rev->review; ?>

                                    </div>
                                    <div class = "col-xs-12 col-md-12"><a href = "javascript:void(0);" onclick = "return onclickReport(<?php echo $rev->id; ?>, <?php echo $company_id; ?>);" style = "float: right; margin-top: 12px; color: #48a5da;">Report Abuse</a></div>
                                </div>


                            </div>
                        </div>
                        <?php
                    }
                }
                ?>



                <div class="row mar_top3">
                    <div class="company_page_borderedbox">
                        <div class="media">
                            <div>
                                <?php
                                    $comment = "";
                                    $post = "";
                                    $comments = $this->session->userdata('comments');
                                    if(!empty($comments)){
                                        $comment = $comments->title;
                                        $post = $comments->post;
                                    }
                                ?>
                                <h4 class="media-heading">Submit Your Question or Comment about the company</h4>
                                <form action = "" method = "post">
                                    <div class="form-group">
                                        <input type="text" name="title" id="comment_title" value = "<?php echo $comment; ?>" class="form-control input-lg" placeholder="Comment Title" tabindex="5" style="width: 100%;">
                                        <input type="hidden" name = "hid_id" value = "<?php echo $details->id; ?>">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control input-lg"  id="comment_post" placeholder="Comment" tabindex="4" name = "review"><?php echo $post; ?></textarea>
                                    </div>
                                    <div class="starRating" style="margin-top:1px;">
                                        <div>
                                            <div>
                                                <div>
                                                    <div>
                                                        <input id="rating1" type="radio" name="rating_review" value="1">
                                                        <label for="rating1"><span>1</span></label>
                                                    </div>
                                                    <input id="rating2" type="radio" name="rating_review" value="2">
                                                    <label for="rating2"><span>2</span></label>
                                                </div>
                                                <input id="rating3" type="radio" name="rating_review" value="3">
                                                <label for="rating3"><span>3</span></label>
                                            </div>
                                            <input id="rating4" type="radio" name="rating_review" value="4">
                                            <label for="rating4"><span>4</span></label>
                                        </div>
                                        <input id="rating5" type="radio" name="rating_review" value="5">
                                        <label for="rating5"><span>5</span></label>
                                    </div><br>
                                    <small>Please rate</small>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10"></div>
                                        <?php
                                        
                                        if (isset($users_type)) {
                                            ?>
                                            <div class="col-xs-12 col-md-2"><input type="submit" value="Post" class="btn btn-success btn-block btn-lg" tabindex="7"></div>
                                            <?php
                                        } else {
                                            ?>
    <!--                                            <div class="col-xs-12 col-md-2"><input type="button" value="Post" class="btn btn-success btn-block btn-lg" tabindex="7" onClick="alert('Please login for post review');"></div>-->
                                            <div class="col-xs-12 col-md-2"><input type="button" onclick ="return onclickSessionPostValueSave();" value="Post" class="btn btn-success btn-block btn-lg" tabindex="7" data-toggle="modal" data-target="#exampleModal"></div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>




            </div>
            <!-- right row -->

            <div class="col-sm-4">
                <div class="row mar_top3">
                    <div class="col-sm-12">
                        <div class="chat-box-online-div">
                            <div class="chat-box-online-head">
                                Online users
                            </div>
                            <div class="panel-body chat-box-online forum_chat" id = "forum_chat">
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
                                                <a href = "<?php echo base_url('home/userProfile') . '/' . $for->nik; ?>"><img src="<?php echo base_url(); ?>images/icons/administrator.png" alt="bootstrap Chat box user image" class="img-circle" />
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
                <br>
                <div class="col-sm-12">
                    <div class="company_page_borderedbox">
                        <font size="3" color="#333333">Some of our latest Added Companies</font>

                        <?php
                        foreach ($company as $com) {
                            if ($company_details[$com->id]->count > 0) {
                                $comp_rating = floor($company_details[$com->id]->total / $company_details[$com->id]->count);
                            } else {
                                $comp_rating = 0;
                            }
                            ?>
                            <div class="media">
                                <div class="media-left">
                                    <?php
                                    if ($com->company_logo) {
                                        ?>
                                        <a href="<?php echo base_url('home/companyDetails') . "/" . $com->id; ?>"><img class="media-object"  src="<?php echo base_url(); ?>images/company/<?php echo $com->company_logo; ?>" alt="" height = "50" width = "50"></a>
                                        <?php
                                    } else {
                                        ?>
                                        <a href="<?php echo base_url('home/companyDetails') . "/" . $com->id; ?>"><img class="media-object"  src="<?php echo base_url(); ?>images/icons/no_image.png" alt="" height = "50" width = "50"></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $com->company_name; ?></h4>
                                    <img src = "<?php echo base_url(); ?>images/icons/rating_<?php echo $comp_rating; ?>.png">
                                </div>
                            </div>

                            <?php
                        }
                        ?>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</div>
</div>
<?php $this->load->view('users/include/footer.php'); ?>