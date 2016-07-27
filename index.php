<?php get_header(); ?>
   <div class="row main"> 
    <?php ysimple_loop(' col-xs-12 text-center',false); ?>
	
	<div class="col-xs-12 text-center test_sidebar">
		<?php ydisplay_sidebar("ybootom1");?>
	</div>
	<?php 
	//example theme option
	//$yoption = get_option('yoption');
	//echo $yoption;
	?>
  
    </div>
<?php get_footer(); ?>


