<?php

function ytitle()
{
	
}//end ytitle


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
	$menu = preg_replace( array( '#^<div[^>]*>#', '#</div>$#', '#^<ul[^>]*>#', '#</ul>$#' ), '', $menu );
	echo 
	'
	<ul id="'.$menu_id.'" class="'.$menu_class.'">'.
	$menu
	.'</ul>
	';
}//end ymenu

function ytemplate_url()
{
	bloginfo('template_url');
}//end ytemplate_url

function ydisplay_sidebar($name)
{
	
	if( !function_exists('dynamic_sidebar') || !dynamic_sidebar($name) )
	{
		dynamic_sidebar($name);
	}
}//end ydisplay_sidebar


function yreg_sidebar($name,$class="",$desc="",$before_title="<h2>",$after_title="</h2>")
{
	register_sidebar(array('name' => __( $name ),'class'=> $class,'id' => $name,'description' => __( $desc ),
	'before_widget' => '<div id="%1$s" class="widget %2$s '.$class.'">',
	'after_widget'  => '</div>',
	'before_title' =>$before_title,'after_title' => $after_title));
}//end yreg_sidebar

function yshortc($name,$func)
{
	add_shortcode($name, $func());
}//end yshortc

function ysimple_loop($class='')
{
	if ( have_posts() )
	{
		 while ( have_posts() )
		 { the_post();?>
			 <div class="ypost<?php echo $class;?> ">
				 <h2><?php the_title() ;?></h2>
				 <div class="tumb"><?phpthe_post_thumbnail(); ?></div>
				 <div class="excerpt"><?php the_excerpt(); ?></div>
				 <div class="y_date"><?php the_time('F j, Y');?></div>
			</div><!--end ypost-->
			<?php
		 }
		 
	}
	else
	{
		return false;
	}
}

function ycat_posts($name,$class='',$amount=100,$query=0)
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
	if ( $the_query->have_posts() ) 
	{

		while ( $the_query->have_posts() ) 
		{

				$the_query->the_post();?>
			 <div class="ypost<?php echo $class;?> ">
				 <h2><?php the_title() ;?></h2>
				 <div class="tumb">"<?phpthe_post_thumbnail(); ?></div>
				 <div class="excerpt"><?php the_excerpt(); ?></div>
				<div class="y_date"><?php the_time('F j, Y');?></div>
			</div><!--end ypost-->
			<?php
		}
	}
	else
	{
		return false;
	}
}
//$custom_query = new WP_Query('cat=-7,-8,-9'); // exclude any categories
//$custom_query = new WP_Query('posts_per_page=3'); // limit number of posts
//$custom_query = new WP_Query('order=ASC'); // reverse the post order
//http://www.billerickson.net/code/wp_query-arguments/

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

//wp_list_cats('sort_column=name&optioncount=1&hierarchical=0');


//options page class

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
   }
   function update_option($option,$post=false)
   {
		if(!$post){$post=$option;}
	   	if(isset ($_POST[$post]))
		{
			update_option($option, $_POST[$post]);
		}
   }
  
}//end yoption_page
?>