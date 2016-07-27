<?php

/*
table of contents:
*misc funcs
*menu
*sidebars
*shortcodes
*wp loops
*scripts
*options page class
*custom widgets funcs
*
*/


//no config (incase some idiot didnt include config.php before this file)
if(!defined(YREAD_MORE)){define("YREAD_MORE",'read more');}
if(!defined(YDATE_FORMAT)){define("YDATE_FORMAT",'F j, Y');}

function ycss_link($file)
{
	$html = '
	<link href="'.get_template_directory_uri ().'/'.$file.'" rel="stylesheet" type="text/css" />
	';
	echo $html;
	
}

function yjs_link($file)
{
	$html = '
	<script href="'.get_template_directory_uri ().'/'.$file.'"></script>
	';
	echo $html;
}

function ytemplate_url()
{
	bloginfo('template_url');
}//end ytemplate_url

//echo option
function yecho_op($name)
{
	$yoption = get_option($name);
	echo $yoption;
}//end yecho_op

/////////////menu///////////////

function yreg_menu($location,$desc)
{
	register_nav_menus( array($location => $desc));
}//end yreg_menu
//,$container_id='',$container_class=''
function ymenu($theme_location,$menu_id='',$menu_class='')
{
	$arr = array(
	'theme_location'  => $theme_location,
	'echo' => false,
	//'container' => false,
	);

	$menu = wp_nav_menu($arr);
	$menu = preg_replace( array( '#^<div[^>]*>#', '#</div>$#', '#^<ul[^>]*>#', '#</ul>$#' ), '', $menu );//get rid of containers
	echo 
	'
	<ul id="'.$menu_id.'" class="'.$menu_class.'">'.
	$menu
	.'</ul>
	';
}//end ymenu

/////////////end menu///////////////



////////sidebars//////////////

function ydisplay_sidebar($name)
{
	
	if( !function_exists('dynamic_sidebar') || !dynamic_sidebar($name) )
	{
		dynamic_sidebar($name);
	}
}//end ydisplay_sidebar


function yreg_sidebar($name,$desc="",$before_title="<h2>",$after_title="</h2>")
{
	$class="";
	$arr = array('name' => __( $name ),
		'class'=> $class,'id' => $name,'description' => __( $desc ),
		'before_widget' => '<div id="%1$s" class="widget %2$s '.$class.'">',
		'after_widget'  => '</div>',
		'before_title' =>$before_title,'after_title' => $after_title);
		
	add_action( 'widgets_init', function()use( &$arr){
		register_sidebar($arr);	
	});
	//add_action( 'widgets_init', create_function( '', 'register_widget("yitem");' ) );
}//end yreg_sidebar

////////end sidebars//////////////

/////////////shortcodes//////////////


function yshortc($name,$func)
{
	add_shortcode($name, $func);
}//end yshortc

/////////////end shortcodes//////////////

/////////////wp loops//////////////


function ysimple_loop($class='',$show_excerpt=true)
{
	if ( have_posts() )
	{
		 while ( have_posts() )
		 { global $post;the_post();?>
			 <div class="ypost <?php echo $class;?> " id="post-<?php the_ID(); ?>">
				 <h2><?php the_title() ;?></h2>
				 <div class="tumb"><?php the_post_thumbnail(); ?></div>
				<?php if($show_excerpt){ ?>
					<div class="excerpt"><?php the_excerpt(); ?></div>
					<a class="permalink" href='<?php echo get_permalink($post->ID); ?>'>
					<?php echo YREAD_MORE;?></a>
				<?php }else{ ?>
					<div class="content"><?php the_content(); ?></div>
				<?php }//end else ?>
				 <div class="y_date"><?php the_time(YDATE_FORMAT); edit_post_link();?></div>
			</div><!--end ypost-->
			<?php
		 }
		 
	}
	else
	{
		return false;
	}

	wp_reset_query();

	ypaginate();
}

function ycat_posts($name,$class='',$show_excerpt=true,$amount=100,$query=0)
{ 

	 if($query==0)
	 {
		 $args = array(
		  'category_name' => $name,
		  'posts_per_page' => $amount
		);
		$the_query = new WP_Query( $args );
	 }
	 else
	 {
		$the_query = new WP_Query( $query ); 
	 }
	
	// The Loop
	if( $the_query->have_posts() ) 
	{

		 while( $the_query->have_posts() )
		 { global $post; $the_query->the_post();?>
			 <div class="ypost <?php echo $class;?> " id="post-<?php the_ID(); ?>">
				 <h2><?php the_title() ;?></h2>
				 <div class="tumb"><?php the_post_thumbnail(); ?></div>
				<?php if($show_excerpt){ ?>
					<div class="excerpt"><?php the_excerpt(); ?></div>
					<a class="permalink" href='<?php echo get_permalink($post->ID); ?>'>
					<?php echo YREAD_MORE;?></a>
				<?php }else{ ?>
					<div class="content"><?php the_content(); ?></div>
				<?php }//end else ?>
				 <div class="y_date"><?php the_time(YDATE_FORMAT); edit_post_link();?></div>
			</div><!--end ypost-->
			<?php
		 }
	}
	else
	{
		return false;
	}
	
	wp_reset_query();
	
	ypaginate();
}
//$custom_query = new WP_Query('cat=-7,-8,-9'); // exclude any categories
//$custom_query = new WP_Query('posts_per_page=3'); // limit number of posts
//$custom_query = new WP_Query('order=ASC'); // reverse the post order
//http://www.billerickson.net/code/wp_query-arguments/

function ypaginate()
{
	global $wp_query;

	$big = 999999999; // need an unlikely integer

	echo paginate_links( array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages
	) );	
}//end ypaginate

/////////////end wp loops//////////////

/////////////scripts//////////
function yupload_scripts($dir=false)
{
	if(!$dir)
	{
		$dir=get_template_directory_uri ()."/js/";
	}
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('upload_media_widget', $dir.'upload-media.js', array('jquery'));

	wp_enqueue_style('thickbox');
}//end yupload_scripts

function yadd_bootstrap()
{
	//add bootstrap js 
	add_action( 'wp_enqueue_scripts', function()
	{
		wp_enqueue_style( 'bootstrapstyle', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' );
		wp_enqueue_style( 'bootstraptheme', "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"  );
		if ( ! wp_script_is( 'jquery', 'enqueued' )) {

        //Enqueue
        wp_enqueue_script( 'jquery' );

		}
		wp_enqueue_script(
			'bootstapjs',                                 //slug
			'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', //path
			array('jquery'),                                      //dependencies
			false,                                                //version
			true                                                  //footer
		);
		
	});
}//yadd_bootstrap

function responsiveSlides_load_js($class="yslider")
{
	add_action( 'wp_enqueue_scripts', function()
	{
	
		wp_enqueue_script(
			'responsiveSlides',                                 //slug
			"https://cdn.jsdelivr.net/jquery.responsiveslides/1.54/responsiveslides.min.js", //path
			array('jquery'),                                      //dependencies
			false,                                                //version
			true                                                  //footer
		);
	});

		//<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.0/slick.css"/>
		//<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.0/slick.min.js"></script>"	
}//end slider_load_js

function responsiveSlides_single_slider($class="yslider",$data = 0)
{
	//chack if jquery enqueued
	if ( ! wp_script_is( 'jquery', 'enqueued' )) 
	{

        //Enqueue
        wp_enqueue_script( 'jquery' );

	}
	add_action( 'wp_footer', function()use( &$class){
		 
			echo '
			<script>
			var $ = jQuery.noConflict();
			$( document ).ready(function() {
				$(".'.$class.'").responsiveSlides();
				
			});
			</script>
			'; 
		 
		 
	}, 100);
}
function ywow_js()
{
	//chack if jquery enqueued
	if ( ! wp_script_is( 'jquery', 'enqueued' )) {

        //Enqueue
        wp_enqueue_script( 'jquery' );

	}
	add_action( 'wp_enqueue_scripts', function()
	{
		wp_enqueue_style( 'animatecss', "https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css");
			
		wp_enqueue_script(
			'ywowjs',                                 //slug
			 "https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js", //path
			array('jquery'),                                      //dependencies
			false,                                                //version
			true                                                  //footer
		);
	});
	
	add_action( 'wp_footer', function()use( &$class){
		 
			echo '
			<script>
			new WOW().init();
			</script>
			'; 
		 
		 
	}, 100);
}//end ywow_js
//wp_list_cats('sort_column=name&optioncount=1&hierarchical=0');
/////////////end scripts//////////

//////////options page class////////////////

class yoption_page 
{
  public $page_title;
  public $capability;
  public $menu_slug;


  function __construct($page_title,$capability,$menu_slug) 
  {
	//add_filter( 'the_content', array( $this, 'the_content' ) );
	add_action( 'admin_init', array( $this, 'theme_options_init' ) );
	add_action( 'admin_menu', array( $this, 'theme_options_add_page' ) );
	$this->page_title = $page_title;
	$this->capability = $capability;
	$this->menu_slug = $menu_slug;
  }
  function theme_options_init(){}//end theme_options_init
   
  function theme_options_add_page() 
  {
	  	$page_title = $this->page_title;//also menu title 
		$capability = $this->capability;//wp user capability needed to view this page
		$menu_slug = $this->menu_slug;//The slug name to refer to this menu by (should be unique for this menu)-wp codex
		$callback_func =array( $this,'theme_options_do_page') ; //callback function
		add_theme_page($page_title, $page_title,$capability ,$menu_slug ,$callback_func );

  }//end theme_options_add_page
  
  function yoption_html_form($form)
  {	
		$html = '<div class="wrap"><form method="post" action="">';
		$html .= $form; 
		$html .= '</form></div>';
		return $html;
	   
   }//end yoption_html_form 
   function yupdated_msg($string,$ypost)
   {
	   $html = '<div class="updated fade"><p><strong>';
	   $html .= $string;
	   $html .='</strong></p></div>';
	   if(isset($_POST[$ypost]))
	   {
		   echo $html;
	   }
   }//yupdated_msg
   
   function defult_val($option,$val)
   {
	 if(get_option($option) == '')
	 {
		update_option($option, $val);
	 }
   }//end defult_val
   
   function update_option($option,$post=false)
   {
		if(!$post){$post=$option;}
	   	if(isset ($_POST[$post]))
		{
			update_option($option, $_POST[$post]);
		}
   }//end update_option
   
   
   function yoptions_do($arr,$string,$action)
   {
	    $return=array();
		if($string)
		{
			$arr = explode(",", $arr);
		}
		if($action == "init")
		{
			foreach($arr as $r)
			{
				if(is_array($r))
				{
					$this->defult_val($r[0], $r[1]);
				}
				else
				{
					$this->defult_val($r ,"defult_val");
				}
				
			}
		}
		if($action == "update")
		{
			foreach($arr as $r)
			{
				$this->update_option($r);
			}
		}
		if($action == "get")
		{
			foreach($arr as $r)
			{
				$op= get_option($r);
				$return[$r] = $op;
			}
			return $return;
		}
  }//end yoptions_do
  
   function ytext_input($title,$name,$val="",$class="")
   {
	   $html='
			<div class="'.$class.'">
			<p>
			'.$title.'
			 </p >
			 <input type="text" name="'.$name.'" value="'.$val.'"/>
			<div>
	   ';
	   return $html;
   }//end ytext_input
   
   function yimg_input($title,$name,$val="",$class="")
   {
	   $html='
			<div class="'.$class.'">
			<p>
			'.$title.'
			 </p >
			 <input type="text" name="'.$name.'" value="'.$val .'">
	         <input class="yupload_image_btn button-primary" type="button" value="Upload Image">
			
			<div>
	   ';
	   return $html; 
   }//end yimg_input
   function ysubmit_input()
   {
	  	   $html='
		 	<p class="submit">
				<input type="submit" class="button-primary" value="Save Options" name="update_theme_options" />
			 </p>
	   ';
	   return $html;  
   }//end ysubmit_input
}//end yoption_page
//////////end options page class////////////////

/////custom widgets funcs////////////////

function y_widget_vars($arr,$instance)
{
	if(!is_array($arr))
	{
		$arr = $pieces = explode(",", $arr);
	}
	$return_r = array();
	foreach($arr as $item)
	{
		$return_r[$item] =(isset($instance[$item]))?$instance[$item]:''; 
	}
	//print_r( $return_r);
	return $return_r;
}

function y_widget_text($name,$instance,$that)
{
	$in = "<input ";
	$put = "/>";
	
	$data = y_widget_get_data($name,$instance,$that);
	
	$text = $in.
	   "id = ".$data['g_id'].
	   ' class="widefat"'.
	   " name = '".$data['g_name']."'".
	   "value = '".$data['i_value']."'".
	   $put;
	
	return $text;
}//end y_widget_text
function y_widget_textarea($name,$instance,$that)
{
	$text = "<textarea ";
	$area = "</textarea>"; 
	
	$data = y_widget_get_data($name,$instance,$that);
	
	$textarea =$text.
	   "id = ".$data['g_id'].
	   ' class="widefat"'.
	   " name = '".$data['g_name']."'>".
	   $data['i_value'].
	   $area;
	return $textarea;
	
}//end y_widget_textarea
function y_widget_img($name,$instance,$that)
{

	$data = y_widget_get_data($name,$instance,$that);
	$img = '
	   <input type="text" name="'.$data['g_name'].'" value="'.$data['i_value'].'"  id= "'.$data['g_id'].'"/>
	   <input class="yupload_image_btn button-primary" type="button" value="Upload Image" />';
	return $img;  
	
}//end y_widget_img


function y_widget_get_data($name,$instance,$that)
{
	$data=array();
	$data['g_id']= $that->get_field_id($name);
	$data['g_name']= $that->get_field_name($name);
	$data['i_value']= (!empty($instance[$name]))?$instance[$name]:"";
	
	return $data;
	
}//end y_widget_get_data

function y_widget_create_selectbox($name, $data,$instance,$that)
{
    $defult =(!empty($instance[$name]))?$instance[$name]:"";
	$name = $that->get_field_name($name);
	$id = $that->get_field_id($name);
	
	$html = '<select name="'.$name.'" id ="'.$id.'">';

    foreach($data as $key=>$val) {
		$defultdo = ($defult==$key)?' selected="selected"':"";
		
		$html.='<option value="' .$key. '" '.$defultdo.'>';
        $html.=$val;
        $html.="</option>";
    }
    $html.="</select>";

    return $html;
}//end y_widget_create_selectbox

/////end custom widgets funcs////////////////



?>