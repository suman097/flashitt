<?php $this->load->view('users/include/header.php'); ?>

<div class="self_registation">
    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                <?php
                if (isset($users_type)) {
                    ?>
                    <form role="form" method="post" action="" enctype="multipart/form-data">
                        <center>
                            <h2>Fill in details of the company that you looking for </h2>
                            <h2>or</h2>
                            <h2>fill in details your own company</h2>
                        </center>
                        <hr class="colorgraph">

                        <div class="form-group">
                            <input type="text" name="company" id="display_name" class="form-control input-lg" placeholder="Company Name*" tabindex="3">
                            <?php echo form_error('company', '<span class="req">', '</span>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" name="weblink"  class="form-control input-lg" placeholder="Company Web Link" tabindex="3">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control input-lg" placeholder="Description" tabindex="4" name = "description"></textarea>
                        </div>
                        <div class="form-group">
                            <select name = "country" class="form-control input-lg" placeholder="Country" tabindex="1">
                                <option value = "" selected>Country*</option>
                                <?php
                                if (isset($country)) {
                                    foreach ($country as $try) {
                                        echo '<option value = "' . $try->id . '" >' . $try->country . '</option>';
                                    }
                                }
                                ?>
                            </select>
                            <?php echo form_error('country', '<span class="req">', '</span>'); ?>
                        </div>
                        <div class="form-group">
                            <input type="text" name="city"  class="form-control input-lg" placeholder="City" tabindex="3">
                        </div>
                        <div class="form-group">
                            <input type="file" name="logo_image" id="password" class="form-control input-lg">
                        </div>

                        <hr class="colorgraph">
                        <div class="row">
                            <div class="col-xs-12 col-md-6"></div>
                            <div class="col-xs-12 col-md-6"><input type="submit" value="Submit" class="btn btn-success btn-block btn-lg" tabindex="7"></div>
                        </div>
                    </form>
                    <?php
                } else {
                    echo "Please Login to register.";
                }
                ?>
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
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="t_and_c_m" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Terms & Conditions</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">I Agree</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
</div>
<?php $this->load->view('users/include/footer.php'); ?>

