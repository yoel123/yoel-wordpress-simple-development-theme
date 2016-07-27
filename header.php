<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php   bloginfo('name'); ?></title>
<?php ycss_link('style.css'); ?>
<?php wp_head(); ?>


</head>
<body>
        
<div class='container'>
<div class="row">
    <div class="col-xs-12">
		<h1 class='text-center'>
		<?php bloginfo( 'name' );?>
		</h1>
		<nav id="ymain_menu" class="navbar navbar-dark bg-primary">
		<a class="navbar-brand" href="#">Navbar</a>
		<?php 
			ymenu("ymain_menu","","nav navbar-nav");//
		?>
		</nav>
	</div>
</div>
