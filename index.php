<?php get_header(); ?>
   <div class="row main"> 
    <?php ysimple_loop(' col-xs-12 text-center'); ?>
  
    
	<?php ydisplay_sidebar("ybootom1");
	 ypaginate();
	//example theme option
	//$yoption = get_option('yoption');
	//echo $yoption;
	?>
  
    </div>
<?php get_footer(); ?>


