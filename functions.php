<?php
require_once('yfuncs.php' );
require_once('yoptions.php' );
error_reporting(E_ALL);
ini_set('display_errors', 1);
//manu init
yreg_menu("ymain_menu","y_top menu");

//sidbars
add_action('widgets_init', function(){
	
		yreg_sidebar("ybootom1","col-xs-12 text-center test_sidebar");

});

//scripts
yadd_bootstrap();
?>