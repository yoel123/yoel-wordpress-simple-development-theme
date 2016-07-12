<?php
/*
//procedural option page
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

//$yoption = get_option('yoption'); //thats how to use the option 

//chack if option has any value if not put defult val
function theme_options_init()
{
	 if(get_option('yoption') == '')
	 {
		update_option('yoption', 'defult_val');
	 }
	// register_setting( 'sample_options', 'sample_theme_options', 'theme_options_validate' );
}//end theme_options_init

//add page to wp admin panel menu  
function theme_options_add_page() 
{
	$page_title = 'Theme Options';//also menu title 
	$capability = 'edit_theme_options';//wp user capability needed to view this page
	$menu_slug = 'theme_options';//The slug name to refer to this menu by (should be unique for this menu)-wp codex
	$callback_func ='theme_options_do_page' ; //callback function
	add_theme_page($page_title, $page_title,$capability ,$menu_slug ,$callback_func );
}

//the option page contants   
function theme_options_do_page()
{
	y_form_action();
	
	$yoption = get_option('yoption'); //call option val
	
	//the html form
	 ?>
	 <div class="wrap">
	 <?php screen_icon(); echo "<h2>" .  wp_get_theme(). " options:</h2>"; ?>
	 
	 <?php if ( isset ($_POST["update_theme_options"]) ) : ?>
	 <div class="updated fade"><p><strong><?php echo( 'Options saved' ); ?></strong></p></div>
	 <?php endif; ?>
	 
	 <form method="post" action="">
		 <p>
		 test option
		 </p >
		 <input type="text" name="yoption" value="<?php echo $yoption ?>"/>
		 <p class="submit">
			<input type="submit" class="button-primary" value="<?php echo( 'Save Options' ); ?>" name="update_theme_options" />
		 </p>
	 </form>
	 </div>
	 <?php
 
}

//update option value after form submitted
function y_form_action()
{
	 if(isset ($_POST["update_theme_options"]))
	 {
		update_option('yoption', $_POST["yoption"]);
	 }
}//end y_form_action*/
?>