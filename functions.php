<?php
include_once('config.php' );
require_once('yfuncs.php' );
require_once('yoptions.php' );

//castum widget
include_once('widgets/yitem.php' );

error_reporting(E_ALL);
ini_set('display_errors', 1);
//manu init
yreg_menu("ymain_menu","y_top menu");

//sidbars
yreg_sidebar("ybootom1","sidebar description");

//shortcode
yshortc("hellovelt",function($atts)
{
	
	return "hello velt ".$atts['t'];
	
});
//[hellovelt t="is hello world in german"]
add_theme_support( 'post-thumbnails' ); 
//scripts
yadd_bootstrap();
yupload_scripts();
?>