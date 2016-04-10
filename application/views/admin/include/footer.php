<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="footer-inner">
        2015 &copy;  Flashitt
    </div>
    <div class="footer-tools">
        <span class="go-top">
            <i class="icon-angle-up"></i>
        </span>
    </div>
</div>
<script type="text/javascript">
    function changeStatus(id, table){
        $.ajax({
            url: "<?php echo base_url('common/ajaxChangeStatus'); ?>",
            type: "POST",
            data: {
                id: id,
                table: table,
<?php echo $this->security->get_csrf_token_name() . ":'" . $this->security->get_csrf_hash() . "'"; ?>
            },
            success: function (data) {
                //alert(data);
                $(".status_"+id).html(data);
            }
        });
    }
</script>
<!-- END FOOTER -->
