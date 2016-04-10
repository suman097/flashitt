
<script src="<?php echo base_url(); ?>assets/crop/js/jquery.min.js"></script>
<script src="<?php echo base_url(); ?>assets/crop/js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="demo_files/main.css" type="text/css" />
<link rel="stylesheet" href="demo_files/demos.css" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/crop/css/jquery.Jcrop.css" type="text/css" />
<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
      aspectRatio: 0,
      onSelect: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

  function checkCoords()
  {
    if (parseInt($('#w').val())) return true;
    alert('Please select a crop region then press submit.');
    return false;
  };

</script>
<style type="text/css">
  #target {
    background-color: #ccc;
    width: 500px;
    height: 330px;
    font-size: 24px;
    display: block;
  }


</style>

<p>Edit Your Profile Banner image</p>
<br>
<img src = "<?php echo base_url(); ?>images/users/<?php echo $profile->banner; ?>" id="cropbox" >
<form action="<?php echo base_url('home/cropBannerImage'); ?>" method="post" onsubmit="return checkCoords();">
	<input type="hidden" id="x" name="x" />
	<input type="hidden" id="y" name="y" />
	<input type="hidden" id="w" name="w" />
	<input type="hidden" id="h" name="h" />
	<input type="submit" value="Crop Image" class="btn btn-large btn-inverse"  style = "cursor:pointer; font-weight:bold; height:50px; margin-top:10px; width: 200px;"/>
	<a href = "<?php echo base_url('home/cropProfileImage'); ?>"><input type="button" value="Skip" class="btn btn-large btn-inverse"  style = "cursor:pointer; font-weight:bold; height:50px; margin-top:10px; width: 200px;"/></a>
</form>
                   